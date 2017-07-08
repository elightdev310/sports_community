<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use SCUserLib;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        else {
            // Check Pending User ( Prompt Activation Code )
            $current_user = SCUserLib::currentUser();
            if ($current_user && $current_user->status == config('sc.user_status.pending')) {
                return redirect()->route('user.activate');
            }
        }

        return $next($request);
    }
}
