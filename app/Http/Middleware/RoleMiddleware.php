<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/'); // Redirect to login if not authenticated
        }
        $roles = ['admin', 'exchange','carecenter'];
        // Check if the authenticated user has one of the required roles
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect('/'); // Redirect to home if the user doesn't have the right role
        }

        return $next($request);
    }
    
}
