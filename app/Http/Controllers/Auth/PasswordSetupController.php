<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordSetupRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class PasswordSetupController extends Controller
{
    public function show(): View|Factory|Application
    {
        return view('auth.password.setup');
    }

    public function update(PasswordSetupRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'],
            'is_first_auth' => false
        ]);

        return redirect()->route('dashboard');
    }
}
