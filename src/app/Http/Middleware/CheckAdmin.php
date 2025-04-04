<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role (role_id = 1)
        if (auth()->user()->role_id !== 1) {
            return redirect('/')
                ->with('error', 'Unauthorized access - Admin privileges required');
        }

        return $next($request);
    }
}