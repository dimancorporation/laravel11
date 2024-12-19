<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirstAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Request | RedirectResponse
    {
        $user = Auth::user();

        if ($user->is_first_auth) {
            return redirect()->route('password.setup');
        }

        return $next($request);
    }
}
