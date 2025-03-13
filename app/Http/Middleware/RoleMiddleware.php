<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
   /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
   public function handle(Request $request, Closure $next, string $role) {
        // Determine authenticated guard
        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
        } elseif (Auth::guard('web')->check()) {
            $userType = 'admin';
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // Check if the user has the correct role
        if ($userType !== $role) {
            return redirect()->route('front.home')->with('error', 'Unauthorized access.');
        }

        return $next($request);
   }
}
