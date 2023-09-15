<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
    
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::guard('web')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return route('login'); // Redirect to the login route
            }
        }
    
        return null; // User is authenticated, do not redirect
    }
}
