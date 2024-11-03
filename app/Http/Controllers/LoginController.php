<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\User;
use Auth;
use DB;
use Hash; 
class LoginController extends Controller
{

    public function index()
    {
        $exchangeRecords = Exchange::all();
        return view('auth.login', compact('exchangeRecords'));
    }

    public function login(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'role' => 'required',
            'exchange' => 'nullable|required_if:role,exchange',
        ]);
    
        // Attempt login using Auth::attempt
        if (Auth::attempt($request->only('name', 'password'))) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'exchange':
                    return redirect()->route('exchange.dashboard');
                case 'assistant':
                    return redirect()->route('assistant.dashboard');
                default:
                    // Logout and show error if role is not recognized
                    Auth::logout();
                    return back()->withErrors([
                        'name' => 'The provided credentials do not match our records.',
                    ]);
            }
        }
    
        // Handle failed login attempts
        return back()
            ->withErrors([
                'name' => 'The provided credentials do not match our records.',
            ])
            ->withInput($request->only('name'))
            ->header('X-Frame-Options', 'DENY') // Prevents framing
            ->header('Content-Security-Policy', "frame-ancestors 'self'"); // Allows framing only from the same origin
    }
    public function logout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        } elseif (auth()->check()) {
            Auth::logout();
            return redirect()->route('auth.login')
                ->withHeaders([
                    'X-Frame-Options' => 'DENY', // Prevents framing
                    'Content-Security-Policy' => "frame-ancestors 'self'", // Allows framing only from the same origin
                ]);
        }
    }

    public function logoutAll(Request $request)
    {
        $admin = Auth::user();
        Auth::logout();
        $this->invalidateAllSessions();
        
        return redirect()->route('auth.login')->with('status', 'All users have been logged out.')
            ->withHeaders([
                'X-Frame-Options' => 'DENY', // Prevents framing
                // 'Content-Security-Policy' => "frame-ancestors 'self'", // Allows framing only from the same origin
            ]);
    }

    protected function invalidateAllSessions()
    {
        \DB::table('sessions')->truncate();
    }
    public function update(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        } else {
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8',
            ]);
            
            $user = Auth::user();
            
            if ($user->role == "admin") {
                if (!Hash::check($request->currentPassword, $user->password)) {
                    return response()->json(['message' => 'Current password is incorrect.'], 422);
                } else {
                    $user->password = Hash::make($request->newPassword);
                    $user->save();
                    
                    // Return response with security headers
                    return response()->json(['message' => 'Password updated successfully.'])
                        ->header('X-Frame-Options', 'DENY') // Prevents framing
                        ->header('Content-Security-Policy', "frame-ancestors 'self'"); // Allows framing only from the same origin
                }
            }
        }
        return response()->json(['message' => 'You are not eligible to perform this action.'], 422)
            ->header('X-Frame-Options', 'DENY') // Prevents framing
            ->header('Content-Security-Policy', "frame-ancestors 'self'");
    }
}
