<?php
/**
* Controller genrated by bluewebdev
*
*/

namespace App\Http\Controllers\Auth;

use Mail;
use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use SCUserLib;

class SCActivationController extends Controller
{
    /**
    * Create a new authentication controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        // $this->middleware('auth', 
        //                   ['except' => array( 'promptActivationCodePage', 
        //                                       'activateUserPost' )] );
    }

    /**
     * Activate Page ('activate')
     */
    public function promptActivationCodePage() {
        $current_user = SCUserLib::currentUser();
        if (!$current_user) {
            return redirect()->route('user.login');
        } 
        else if ($current_user->status == config('sc.user_status.active')) {
            return redirect()->route('dashboard');
        }

        return view('sc.auth.activate');
    }
    public function activateUserPost(Request $request) {
        $current_user = SCUserLib::currentUser();
        if (!$current_user) {
            return redirect()->route('user.login');
        } 
        else if ($current_user->status == config('sc.user_status.active')) {
            return redirect()->route('dashboard');
        }

        $code = $request->input('code');
        $result = SCUserLib::handleActivationCode($current_user, $code);
        if ($result === true) {
            return redirect()->route('dashboard');
        }
        else {
            return redirect()->route('user.activate')
                             ->withErrors($result);
        }

        return $code;
    }

    /**
     * Send Email containts Activaton Code ('send-activation')
     */
    public function sendActivationCode(Request $request) 
    {
        $user = SCUserLib::currentUser();
        if ($user) {
            $result = SCUserLib::sendActivationMail($user);
            if ($result === true) {
                return redirect()->route('user.activate');
            }
            else if ($result == 'activated') {
                return redirect()->route('dashboard');
            }
            else {
                return redirect()->route('user.activate')
                                 ->withErrors($result);
            }
        }
        else {
            return redirect()->route('user.login');
        }
    }
}
