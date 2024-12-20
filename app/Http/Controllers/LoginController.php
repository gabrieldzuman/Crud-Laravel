<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController
{
    /**
     * Display the login page.
     *
     * @return View The login page view.
     */
    public function index(): View
    {
        return view('login.index');
    }

    /**
     * Handle login attempts.
     *
     * @param Request $request The HTTP request containing user credentials.
     * @return RedirectResponse Redirect to the appropriate route based on authentication result.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()
                ->withErrors(['login' => 'Usuário ou senha inválidos'])
                ->withInput(); 
        }

        $request->session()->regenerate();

        return to_route('series.index');
    }

    /**
     * Handle logout.
     *
     * @param Request $request The HTTP request.
     * @return RedirectResponse Redirect to the login page after logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
