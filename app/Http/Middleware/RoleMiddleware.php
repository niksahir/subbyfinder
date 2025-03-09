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

      // Check if the user is authenticated
      if (!Auth::check()) {
         return redirect()->route('login')->with('error', 'You must be logged in.');
      }

      // Check user role
      if (!empty(Auth::user()->role) && Auth::user()->role->slug !== $role) {
         if (Auth::user()->role->slug == "contractor") {
            return redirect()->route('contractor.dashboard.index');
         }

         if (Auth::user()->role->slug == "sub-contractor") {
            return redirect()->route('subcontractor.dashboard.index');
         }

         if (Auth::user()->role->slug == "admin") {
            return redirect()->route('front.home');
         }

         return redirect()->route('front.home')->with('error', 'Unauthorized access.');
      }

      return $next($request);
   }
}
