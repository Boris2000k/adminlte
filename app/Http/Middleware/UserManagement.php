<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $perms = Auth::user()->permissions;
        if(Str::contains($perms,'user-management'))
        {
            return $next($request);
        }
        else
        {
            return redirect()->back();
        }
        
    }
}
