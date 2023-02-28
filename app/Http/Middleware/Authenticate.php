<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
            // return redirect()->route('clients.dashboard');
        }
        // if (Auth::check()) {
        //     if (Auth::user()->isAdmin()) {
        //         return redirect()->route('admin.dashboard');
        //     } else {
        //         return redirect()->route('client.dashboard');
        //     }
           
        // }
    }
}
