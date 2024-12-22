<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin() && !$request->routeIs('settings')) {
            return redirect()->route('settings');
        }

        if ($user->isDebtor() && !$request->routeIs('debtor')) {
            return redirect()->route('debtor');
        }

        if ($user->isUser() && !$request->routeIs('dashboard')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
