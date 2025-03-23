<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Import ValidationException

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Attempt to authenticate the user
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...

            // 3. Regenerate the session
            $request->session()->regenerate();

            // 4. Redirect to the intended route (or the dashboard)
            return redirect()->intended(route('dashboard'));  // Or your desired route
        }

        // 5. Authentication failed...

        // Throw a ValidationException with a user-friendly error message
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')], // Use the default authentication error message
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}