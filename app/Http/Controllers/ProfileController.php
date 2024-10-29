<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(string $id)
    {

        $user = User::where('id', $id)->first();

        return view('profile.change', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(request $request)
    {

        $user = Auth::user();
   
        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {

            //return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            return back()->with('warning', 'The password entered is incorrect!');
        }
    
        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Only update the password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        //dd('done');
        // Save the changes
        $user->save();

        return back()->with('success', 'Profile Updated Successfully!');
        
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
