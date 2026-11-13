<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Display the login form.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Authenticate the user.
    public function login(LoginRequest $request)
    {
        // Retrieve only validated credentials.
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            // Regenerate the session after successful login.
            $request->session()->regenerate();

            return redirect('/posts')
                ->with('status', 'Logged in successfully.');
        }

        // Show an error when credentials are incorrect.
        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->onlyInput('email');
    }

    // Log out the authenticated user.
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate CSRF token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/posts')
            ->with('status', 'Logged out successfully.');
    }
}


