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

        $excludedRoutesForAdmins = [
            'settings',
            'save.user.fields',
            'save.doc.fields',
            'save.setting.fields',
            'save.b24statuses.fields',
            'upload.offer.agreement',
        ];

        if ($user->isAdmin() && !in_array($request->route()->getName(), $excludedRoutesForAdmins)) {
            return redirect()->route('settings');
        }

        if ($user->isDebtor() && !$request->routeIs('debtor')) {
            return redirect()->route('debtor');
        }

        if ($user->isUser()) {
            $allowedRoutes = [
                'dashboard',
                'payment',
                'documents',
                'status-descriptions',
                'offer-agreement',
            ];

            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
