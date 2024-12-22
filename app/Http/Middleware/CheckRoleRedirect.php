<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
//        dump($request->user()->role);
        if ($request->user()->role === 'Admin') {
            return redirect()->route('settings');
        }
//        dump($request->user()->b24_status);
        if ($request->user()->b24_status === 12) {
            return redirect()->route('debtor');
        }
//        if ($request->user()->b24_status !== 12) {
//            return redirect()->route('dashboard');
//        }
        return $next($request);

//        $user = Auth::user();
//        if ($user && $user->isAdmin()) {
//            return redirect()->route('settings');
//        }
//
//        return $next($request);
    }
}
