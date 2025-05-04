<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        
        '/payfast-notify',
        '/location',  // Exclude this route from CSRF protection
        '/getData',  // Exclude this route from CSRF protection
        '/create-account',  // Exclude this route from CSRF protection
        '/bookings'  // Exclude this route from CSRF protection
    ];
}
