<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
class LoginController extends Controller
{

    public function index()
    {
        $exchangeRecords = Exchange::all();
        return view('auth.login', compact('exchangeRecords'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'role' => 'nullable',
            'exchange' => 'nullable|required_if:role,exchange',
        ]);

        $name = $request->name;
        $password = $request->password;

        $user = User::where('name', $name)->first();

        if ($user && $request->password === $user->password) { 
    //         if ($user->role=="admin") {
    //             $sessionData = [
    //                 'user_role' => $user->role,
    //                 'name' => $user->name
    //             ];
    //             $request->session()->put($sessionData);
    //                 return redirect()->route('admin.dashboard');
    //         }elseif ($user->role=="assistant") {
    //             $sessionData = [
    //                 'user_role' => $user->role,
    //                 'name' => $user->name
    //             ];
    //             $request->session()->put($sessionData);
    //             return redirect()->route('assistant.dashboard');
    //         }elseif ($user->role=="exchange"){
    //             $sessionData = [
    //                 'user_role' => $user->role,
    //                 'name' => $user->name,
    //                 'exchange' => $user->exchnage->name
    //             ];
    //             $request->session()->put($sessionData);
    //             return redirect()->route('user.dashboard');
    //         }
    //     }

    //     return back()
    //         ->withErrors([
    //             'name' => 'The provided credentials do not match our records.',
    //         ])
    //         ->withInput($request->only('name'))
    //         ->header('X-Frame-Options', 'DENY') // Prevents framing
    //         ->header('Content-Security-Policy', "frame-ancestors 'self'"); // Allows framing only from the same origin
    // }
         // Set session data based on user role
            $sessionData = [
                'user_role' => $user->role,
                'name' => $user->name,
            ];

            // Add exchange to session data if the user is an exchange
            if ($user->role === "exchange") {
                // Make sure to check if the user has an exchange related to them
                $sessionData['exchange'] = $user->exchange->name ?? null;
            }

            // Store session data
            $request->session()->put($sessionData);

            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'assistant':
                    return redirect()->route('assistant.dashboard');
                case 'exchange':
                    return redirect()->route('exchange.dashboard');
                case 'customercare':
                    return redirect()->route('cutomer_care.dashboard');    
                default:
                    return back()->withErrors(['name' => 'User role is not recognized.'])->withInput($request->only('name'));
            }
        }

        // Handle failed login attempt
        return back()
            ->withErrors(['name' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('name'))
            ->header('X-Frame-Options', 'DENY') // Prevents framing
            ->header('Content-Security-Policy', "frame-ancestors 'self'"); // Allows framing only from the same origin
    }

    
    public function logout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        } elseif (auth()->check()) {
          session()->flush();
            return redirect()->route('auth.login')
                ->withHeaders([
                    'X-Frame-Options' => 'DENY', // Prevents framing
                    'Content-Security-Policy' => "frame-ancestors 'self'", // Allows framing only from the same origin
                ]);
        }
    }

    public function logoutAll(Request $request)
    {
        session()->flush();
        
        
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
