<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$guards   // accepts guest:contractor or guest:subcontractor
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // If no guard was specified in the route, look at both guards.
        $guards = empty($guards) ? ['contractor', 'subcontractor'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard === 'contractor'
                    ? redirect()->route('contractor.dashboard.index')
                    : redirect()->route('subcontractor.dashboard.index');
            }
        }

        return $next($request);
    }
}
