<?php
/**
* Controller genrated by bluewebdev
*
*/

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Mail;
use Validator;
use Eloquent;
use Auth;
use Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Str;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use SCUserLib;

class SCAuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
    * Where to redirect users after login / registration.
    *
    * @var string
    */
    protected $redirectTo = '/';

    /**
    * Create a new authentication controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), 
                          ['except' => array( 'logout', 
                                              'setPasswordPage', 
                                              'setPasswordPost' )] );
    }

    /**
    * Login Page (login)
    *
    */
    public function loginPage()
    {
        return view('sc.auth.login');
    }
    public function loginPost(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        return $this->postLogin($request);
    }

    /**
    * Sign Up Page (signup)
    *
    */
    public function signUpPage()
    {
        return view('sc.auth.signup');
    }
    public function signUpPost(Request $request) 
    {
        $_req = $request->all();
        if ($request->input('_action') && $request->input('_action')=='register') {
            $validator = Validator::make($request->all(), [
                                        'first_name'    => 'required', 
                                        'last_name'     => 'required', 
                                        'email'         => 'required|email', 
                                        'password'      => 'required|min:6|confirmed', 
                                        'date_birth'    => 'required', 
                                        'gender'        => 'required'   ]);

            if ($validator->fails()) {
                return redirect()->route('user.signup')
                                 ->withErrors($validator)
                                 ->withInput();
            }

            $result = SCUserLib::registerUserAction($_req); // Log in 
            if ($result === true) {
                return redirect()->route('user.login');
                // redirect to verification page, automatically
            } else {
                if ($result === false) {
                    $result = 'unknown error (signup.post)';
                }
                return redirect()->route('user.signup')
                                 ->withErrors($result)
                                 ->withInput();
            }
        }

        return redirect()->route('user.signup')
                         ->with('status', 'You are registered, successfully. Please login now.')
                         ->withInput();
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if ($provider == 'facebook') {
            return Socialite::driver($provider)->asPopup()->redirect();
        }
        // else if ($provider == 'google') {
        //     return Socialite::driver($provider)->scopes(['profile', 'email'])->redirect();
        // } 
        else {
            return Socialite::driver($provider)->redirect();
        }
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {   
        try {
            $user = Socialite::driver($provider)->user();

            $authUser = SCUserLib::socialFindOrCreateUser((array)$user, $provider);
            Auth::login($authUser, true);
            $request->session()->flash('redirect', '_opener');
            return view('sc.commons.reload_parent');
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Set password after social login since password is blank
     * (password/set)
     */
    public function setPasswordPage(Request $request)
    {
        $current_user = SCUserLib::currentAuthUser();
        $check = $this->checkBlankPassword($current_user);
        if ($check === true) {
            return view('sc.auth.passwords.set', ['email'=>$current_user->email]);
        }
        return $check;
    }
    public function setPasswordPost(Request $request)
    {
        $current_user = SCUserLib::currentAuthUser();
        if ($this->checkBlankPassword($current_user)) {
            $_req = $request->all();
            $validator = Validator::make($request->all(), [
                                        'email'         => 'required|email', 
                                        'password'      => 'required|min:6|confirmed'   ]);
            if ($validator->fails()) {
                return redirect()->route('user.password.set')
                                 ->withErrors($validator);
            }

            $current_user->forceFill([
                'password' => bcrypt($_req['password']),
                //'remember_token' => Str::random(60),
            ])->save();

            return redirect()->route('dashboard');
        }
    }
    protected function checkBlankPassword($current_user)
    {
        if (!$current_user) {
            return redirect()->route('user.login');
        } 
        else if ($current_user->status == config('sc.user_status.active')) {
            if ($current_user->password == '') {
                return true;
            }
        }
        return redirect()->route('dashboard');
    }
}
