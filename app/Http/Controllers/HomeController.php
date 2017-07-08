<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use SCUserLib;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $current_user = SCUserLib::currentUser();
        if ($current_user) {
            return redirect()->route('dashboard');
        }
        else {
            return redirect()->route('user.login');
        }
    }

    /**
    * Dashboard Page (dashboard)
    *
    */
    public function dashboard(Request $request) 
    {
        $current_user = SCUserLib::currentUser();
        if ($current_user) {
            if ($current_user->hasRole(config('sc.user_role.super_admin'))) {
                return redirect(config('sc.adminRoute'));
            }
            else if ($current_user->hasRole(config('sc.user_role.web_admin'))) {
                return redirect(config('sc.webadminRoute'));
            }
            else if ($current_user->hasRole(config('sc.user_role.app_user'))) {
                return view('sc.dashboard');
            }
        }
        else {
            return redirect()->route('user.login');
        }
    }
}
