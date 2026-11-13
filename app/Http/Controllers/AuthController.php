<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Display the login form.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Check the user's login credentials.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            // Create a fresh session after logging in.
            $request->session()->regenerate();

            return redirect('/posts')
                ->with('status', 'Logged in successfully.');
        }

        // Return to login if the credentials are incorrect.
        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->onlyInput('email');
    }

    // Log out the current user.
    public function logout(Request $request)
    {
        Auth::logout();

        // Clear the old session.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/posts')
            ->with('status', 'Logged out successfully.');
    }
}

