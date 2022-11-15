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
    //unit tesztek kedvéért állítom be
    protected $except = [
        '/api/copies',
        '/api/copies/*',
        '/api/users',
        '/api/users/*',
        '/api/books',
        '/api/books/*',
        '/api/users/password/*',
        'api/lendings',
        'api/lendings/*/*/*'
    ];
}
