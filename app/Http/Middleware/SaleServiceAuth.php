<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SaleServiceAuth
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

        if (Auth::user()->roleadherent == null || (Auth::user()->roleadherent->attributes['rol_id'] != 1 && Auth::user()->roleadherent->attributes['rol_id'] != 5)) {
            return redirect()->route('permissionError');
        }

        return $next($request);
    }
}
