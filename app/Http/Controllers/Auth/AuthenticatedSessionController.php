<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use DateTime;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Bitrix24\SDK\Services\ServiceBuilder;

class AuthenticatedSessionController extends Controller
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        $dateTimeInMSK = (new DateTime("now", new DateTimeZone('Europe/Moscow')))->format('d.m.Y H:i:s');
        $user = Auth::user();
        if ($user->role !== 'Admin') {
            $b24Id = $user->id_b24;
            $lastAuthDate = DB::table('b24_user_fields')
                ->where('site_field', 'USER_LAST_AUTH_DATE')
                ->value('uf_crm_code');
            $this->serviceBuilder->getCRMScope()->deal()->update($b24Id, [
                $lastAuthDate => $dateTimeInMSK,
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
