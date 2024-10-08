<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
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

        if (Auth::guard('web')->check()) {

            if (Auth::guard('web')->user()->isActive) {
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                // If the user is inactive, log them out and show an error message.
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors([
                    'email' => 'Your account is inactive. Please contact support.',
                ]);
            }
        }

       // return redirect('/');
   
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
