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
            'local_ip' => 'required',
        ]);

        $otp = $request->input('otp');
        $localIp = $request->input('local_ip');
        $publicIp = $this->getIp(); 

        $otpRecord = Otp::where('otp', $otp)
            ->where('otp_exp', '>', Carbon::now())
            ->first();

        if ($otpRecord) {
            if ($publicIp) {
                $ipExists = IpAddress::where('ipAddress', $publicIp)->exists();

                if (!$ipExists) {
                    $ip = new IpAddress();
                    $ip->ipAddress = $publicIp;
                    $ip->localIpAddress = $localIp;
                    $ip->save();
                }

                return redirect()->route('auth.login')->with('success', 'OTP verified and IP addresses logged.');
            } else {
                return back()->withErrors(['public_ip' => 'Unable to determine public IP address.']);
            }
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP, please try again.']);
        }
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
    
}
