<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
            return redirect('login');

        $user = Auth::user();

        if($user->isAdmin())
            return $next($request);

        $roles = Role::all();
        foreach($roles as $role) {
            if($user->hasRole($role->slug))
                return $next($request);
        }

        return redirect('login');
    }
}
