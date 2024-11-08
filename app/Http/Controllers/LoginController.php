<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exchange;
use App\Models\User;
use App\Models\IpAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use DB;





class LoginController extends Controller
{

    public function index()
    {
        $exchangeRecords = Exchange::all();
        return view('auth.login', compact('exchangeRecords'));
    }

    public function getIp()
    {
        $ip = request()->header('X-Forwarded-For') ?? request()->ip();
    
        // If the header contains multiple IPs (e.g., from a proxy chain), take the first one
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }
    
        // Validate the extracted IP
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
        }
    
        return 'IP not found';
    }

    public function login(Request $request)
    {
        $publicIp = $this->getIp(); 

        $existingIp = IpAddress::where('ipAddress', $publicIp)->get();
        
        if (!$existingIp ) {
            return back()->withErrors(['error' => 'Your IP Address is not registered.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'role' => 'nullable',
            'exchange' => 'nullable|required_if:role,exchange',
        ]);

        $name = $request->name;
        $password = $request->password;

        $user = User::where('name', $name)->first();

        if($user->status == 'deactive')
        {
            return back()->withErrors(['error' => 'You are not Authorized by Admin.']);
        }



        if ($user && $request->password === $user->password) { 
         // Set session data based on user role
            $sessionData = [
                'user_role' => $user->role,
                'name' => $user->name,
            ];
            // Add exchange to session data if the user is an exchange
            if ($user->role === "exchange" || $user->role === "customercare") {
                // Make sure to check if the user has an exchange related to them
                $sessionData['exchange'] = $user->exchange->name ?? null;
                $sessionData['exchange_id'] = $user->exchange_id ?? null;
                $sessionData['user_id'] = $user->id ?? null;
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
                    return redirect()->route('customer_care.dashboard');    
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
