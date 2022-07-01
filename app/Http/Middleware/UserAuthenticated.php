<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            // if user is an admin take him to admin page
            if ($user->isAdmin()) {
                return redirect(route('admin_dashboard'));
            }

            // allow regular user to proceed with request
            else {
                return $next($request);
            }
        } else return $next($request);


        //technically this should never execute, as unauthenticated users are allowed to visit the main page
        //(which this middleware is used for)
        abort(403);  // permission denied error
    }
}
