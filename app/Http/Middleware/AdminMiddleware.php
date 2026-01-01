<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role (assuming you have a role field or relationship)
        // You can adjust this based on your user role implementation
        if (!auth()->user()->is_admin && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access to admin area.');
        }

        return $next($request);
    }
}