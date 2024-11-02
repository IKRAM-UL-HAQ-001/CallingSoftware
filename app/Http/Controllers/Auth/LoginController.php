<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Show the login form with exchange records.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $exchangeRecords = Exchange::all();

        // Render the login view with exchange records
        return view('auth.login', compact('exchangeRecords'));
    }

    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'role' => 'required|string',
            'exchange' => 'nullable|required_if:role,exchange',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('name', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'customercare':
                    return redirect()->route('exchange.dashboard');
                case 'assistant':
                    return redirect()->route('assistant.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'name' => 'The provided credentials do not match our records.',
                    ]);
            }
        }

        // On failed login attempt
        return back()
            ->withErrors(['name' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('name')); // CSP Header
    }

    /**
     * Constructor to define middleware for this controller.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
