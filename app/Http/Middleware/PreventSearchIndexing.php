<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSearchIndexing
{
    /**
     * Add an indexing directive to private and utility responses while leaving
     * authentication, redirects, and health checks fully functional.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->is(
            'admin',
            'admin/*',
            'settings',
            'settings/*',
            'dashboard',
            'up',
            'login',
            'register',
            'forgot-password',
            'reset-password',
            'reset-password/*',
            'verify-email',
            'verify-email/*',
            'confirm-password',
            'email/verification-notification',
            'logout',
        )) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        return $response;
    }
}
