<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
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

            // if user is not admin take him to standart home page
            if (!$user->isAdmin()) {
                return redirect(route('home'));
            }

            // allow admin to proceed with request
            else {
                return $next($request);
            }
        }

        abort(403);  // permission denied error

    }
}
