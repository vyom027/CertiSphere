<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Redirect unauthenticated users.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {            
            return route('login-student'); // Redirect to student login
        }
    }
}
