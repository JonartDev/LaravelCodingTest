<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        if ($request->expectsJson()) {
            return null;
        }

        // For API routes, return null to prevent redirect
        if ($request->is('api/*')) {
            return null;
        }

        // Only redirect for web routes
        return route('login');
    }
}
