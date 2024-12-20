<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('settings');
        }

        if ($user->isUser()) {
            return redirect()->route('dashboard');
        }

        if ($user->isBlocked()) {
            return abort(403, 'Your account is blocked.');
        }

        return $next($request);
    }
}
