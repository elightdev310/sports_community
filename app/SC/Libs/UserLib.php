<?php

namespace App\SC\Libs;

use DB;
use Auth;
use Mail;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\UserProfile;
use App\SC\Models\Node;
use App\SC\Models\SocialProfile;
use App\SC\Models\UserActivationCode;

use SCHelper;
use App\SC\Libs\UserLib_Helper;

class UserLib 
{
    use UserLib_Helper;
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    // Get User by email
    public function getUserByEmail($email) {
        $user = User::withTrashed()->where("email", $email)->first();
        return $user;
    }

    public function registerUserAction($req) {
        ///////////////////////////
        if ($_user = $this->getUserByEmail($req['email'])) {
            $error = "Your email has been registered, already. <br/>";
            // if ($_user->status == config('sc.user_status.pending')) {
            //     if (MICHelper::isPendingVerification($_user)) {
            //         $error .= 'We sent verification email. Please check email to verfiy your email account.';
            //     } else {
            //         $error .= "But your account is pending. We're reviewing your account.";
            //     }
            // }
            // else if ($_user->status != config('mic.user_status.active')) {
            //     $error .= "But your account is canceled. Please call MIC to reactivate your account.";
            // }
            return $error;
        }

        try {
            // User Model
            $ud = array();
            $ud['name']     = $req['first_name'].' '.$req['last_name'];
            $ud['email']    = $req['email'];
            $ud['password'] = $req['password'];
            $ud['type']     = config('sc.user_type.app_user');
            $ud['status']   = config('sc.user_status.pending');

            $uid = Module::insert("Users", (object)$ud);
            if (!$uid) {
                $error = "Error occurs when creating User.";
                return $error;
            }

            // User Role (APP_USER)
            $user = User::find($uid);
            $user->detachRoles();
            $role = Role::where('name', config('sc.user_role.app_user'))->first();
            $user->attachRole($role);

            // Profile
            $this->saveUserProfile($req, $user);
            

            // Send comfirm mail
            $this->sendActivationMail($user);
            // Login 
            Auth::login($user, true);

            return true;
        }
        catch(Exception $e) {
            return SCHelper::getErrorMessage($e);
        }

        return false;
    }

    /**
     * When login via social site, Create User and Social Profile 
     * @param - provider: social type (facebook, twitter, google)
     * @return: User
     */ 
    public function socialFindOrCreateUser($user, $provider) {
        $socialProfile = SocialProfile::where('email', $user['email'])
                                      ->where('provider', $provider)
                                      ->first();
        if (!$socialProfile) {
            // Create Social Profile
            $email = $user['email'];
            if (!$email) {
                $email = $user['nickname'];
            }
            $socialProfile = SocialProfile::create([
                'provider' => $provider, 
                'provider_id' => $user['id'], 
                'email' => $email, 
                'token' => $user['token']
            ]);
        }

        $authUser = $socialProfile->user;
        if ($authUser) {
            if ($authUser->status == config('sc.user_status.pending')) {
                // Not need to verify in social login
                $authUser->status = config('sc.user_status.active');
                $authUser->save();
            }
            return $authUser;
        }

        // Create New User
        $authUser = User::create([
            'name'     => $user['name'],
            'email'    => $user['email'],
            'type'     => config('sc.user_type.app_user'), 
            'status'   => config('sc.user_status.active')  // Not need to verify in social login
        ]);

        // User Role (APP_USER)
        $authUser->detachRoles();
        $role = Role::where('name', config('sc.user_role.app_user'))->first();
        $authUser->attachRole($role);

        // Not need to send verification mail
        return $authUser;
    }

    /**
     * Send Activation Mail ( 6-digits )
     */
    public function sendActivationMail($user) 
    {
        if ($user->status == config('sc.user_status.active')) {
            return 'activated';
        }

        $code = $this->generateActivationCode($user);
        try {
            $response = Mail::send('emails.user_verification', 
                ['user'=>$user, 'code'=>$code], 
                function ($m) use($user, $code) {
                  $m->to($user->email, $user->name)->subject('User Verification');
                }
            );

            if ($response) {
                return true;
            }
        }
        catch(Exception $e) {
            return SCHelper::getErrorMessage($e);
        }
        return "Email Error";
    }

    /**
     * Generate 6-digits Activation Code
     * expiration - 10 mins
     */
    public function generateActivationCode($user) {
        // Random Number ( 6 digits )
        $code = 0;
        $min = 100001;
        $max = 999999;
        srand((double) microtime() * 1000000);
        
        if (function_exists('mt_rand')) {
            $code = mt_rand($min, $max); // faster
        }
        else {
            $code = rand($min, $max);
        }
        // Store Code in UserActivationCode Table
        $uac = UserActivationCode::where('user_id', $user->id)->first();
        if ($uac) {
            if (($uac->expiration-60) < time()) {
                // Keep OLD code before expiration - 1 min
                $code = $uac->code;
            } 
            else {
                $uac->code = $code;
                $uac->expiration = time() + config('sc.activation_period');
                $uac->save();
            }
        }
        else {
            $uac = UserActivationCode::create([
                'user_id'   => $user->id, 
                'expiration'=> time() + config('sc.activation_period'), 
                'code'      => $code
            ]);
        }

        return $code;
    }

    /**
     * Do Activation using code
     */
    public function handleActivationCode($user, $code) {
        $uac = UserActivationCode::where('user_id', $user->id)
                                 ->where('code', $code)
                                 ->orderBy('expiration', 'DESC')
                                 ->first();
        if ($uac) {
            if ($uac->expiration < time()) {
                return "Your code is expired. Please try to get verification code by clicking send email link.";
            }
            $user->status = config('sc.user_status.active');
            $user->save();
            $uac->forceDelete();
            return true;
        }

        return "Invalid Activation Code";
    }

    /**
     * Save User Profile
     */
    public function saveUserProfile($req, $user) {
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        if ($userProfile) {
            $userProfile->date_birth = $req['date_birth'];
            $userProfile->gender     = $req['gender'];
            $userProfile->save();
        }
        else {
            $userProfile = UserProfile::create([
                'user_id'    => $user->id, 
                'date_birth' => $req['date_birth'], 
                'gender'     => $req['gender']
            ]);
        }
    }
}
