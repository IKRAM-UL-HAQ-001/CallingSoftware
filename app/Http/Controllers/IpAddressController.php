<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class IpAddressController extends Controller
{
    public function showOtpForm()
    {
        return view('otp_form');
    }

    public function verifyAndLogIp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = $request->input('otp');

        $otpRecord = Otp::where('otp', $otp)
            ->where('otp_exp', '>', Carbon::now()) 
            ->first();

        if ($otpRecord) {
            $response = Http::get('https://api.ipify.org');
            $publicIp = (string) $response->body();  
            $ip = new IpAddress();

            $ip->ipAddress = $publicIp;
            $ip->save();

            return redirect()->route('auth.login')->with('success', 'OTP verified and IP address logged.');
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP, please try again.']);
        }
    }
}
