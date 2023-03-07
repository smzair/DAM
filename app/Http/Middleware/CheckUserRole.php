<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }
    
        $roledata = getUsersRole($user->id);
        $role_name = "";

        if ($roledata != null) {
            $role_name = $roledata->role_name;
        }
        // dd($role_name , $roles ,$user->id);
        if (! in_array($role_name, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
