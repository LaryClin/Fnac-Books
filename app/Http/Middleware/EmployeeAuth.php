<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployeeAuth
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
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        if (Auth::user()->roleadherent == null || Auth::user()->roleadherent->attributes['rol_id'] == 2) {
            return redirect()->route('permissionError');
        }

        return $next($request);
    }
}
