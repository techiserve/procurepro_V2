<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\ExecutiveRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
       $companies = Company::all();

        return view('auth.login', compact('companies'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

  
        // $request->authenticate();
    
        // $request->session()->regenerate();

        // if (Auth::guard('web')->check()) {

        //     if (Auth::guard('web')->user()->isActive) {
        //         return redirect()->intended(RouteServiceProvider::HOME);
        //     } else {
        //         // If the user is inactive, log them out and show an error message.
        //         Auth::guard('web')->logout();
        //         return redirect()->back()->withErrors([
        //             'email' => 'Your account is inactive. Please contact support.',
        //         ]);
        //     }
        // }

       // return redirect('/');

            //dd($request->all());
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();
          //  dd($user);

            if (!$user) {
                return redirect()->back()->withErrors([
                    'email' => 'Authentication failed.',
                ]);
            }

            if (!$user->isActive) {
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors([
                    'email' => 'Your account is inactive. Please contact support.',
                ]);
            }

            // If user is executive but no company_id was selected, show error
            if (!is_null($user->executiveId) && !$request->filled('company_id')) {
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors([
                    'company_id' => 'Please select a company to proceed.',
                ]);
            }

            //Save company_id to session if present
            if ($request->filled('company_id')) {
                 $executiveRole = ExecutiveRole::where('userId', $user->id)
                    ->where('companyId', $request->company_id)
                    ->first();

             $updatedUser = User::find($user->id);
             $updatedUser->companyId = $request->company_id ?? null;
             $updatedUser->userrole = $executiveRole->roleId ?? null;
             $updatedUser->save();

            }

            return redirect()->intended(RouteServiceProvider::HOME);
        
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
