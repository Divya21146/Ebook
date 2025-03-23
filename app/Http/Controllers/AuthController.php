<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $staticEmail = 'admin@gmail.com';
        $staticPassword = 'password';

        if ($credentials['email'] == $staticEmail && $credentials['password'] == $staticPassword) {
            // Manually create and authenticate a user (without database)
            $user = new \stdClass(); // Use a generic object
            $user->email = $staticEmail; // Set email to it for simplicity in using Auth::user()
            Auth::loginUsingId(1);  //Hardcoded user_id. In production, this will read from the db
            session(['user' => $user]);

            return redirect()->route('dashboard');
            // return redirect()->intended(route('pdf.index'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
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