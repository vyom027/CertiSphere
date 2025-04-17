<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        if (!Session::has('student_logged_in')) {
            return redirect()->route('login-student');
        }

        if (Auth::check() && Auth::user()->user_type === 'student') {
            return $next($request);
        }
        abort(403);

        return redirect()->route('login-student')->with('error', 'Unauthorized access.');
    }
}
