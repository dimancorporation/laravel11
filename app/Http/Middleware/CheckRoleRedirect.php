<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role === 'Admin') {
            return redirect()->route('settings');
        }

        if ($request->user()->b24_status === 12) {
            return redirect()->route('debtor');
        }

        return $next($request);
    }
}
