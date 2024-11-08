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


    private function isPrivateIp($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    public function verifyAndLogIp(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric',
        'local_ip' => 'required|ip',
    ]);

    $otp = $request->input('otp');
    $localIp = (string) $request->input('local_ip');

    $otpRecord = Otp::where('otp', $otp)
        ->where('otp_exp', '>', Carbon::now())
        ->first();

    if ($otpRecord) {
        $response = Http::get('https://api.ipify.org');

        if ($response->successful()) {
            $publicIp = (string) $response->body();  

            $isPrivateIp = $this->isPrivateIp($localIp);

            dd($publicIp, $isPrivateIp);

            if ($isPrivateIp) {
                $ipExists = IpAddress::where('ipAddress', $publicIp)->exists();

                if (!$ipExists) {
                    $ip = new IpAddress();
                    $ip->ipAddress = $publicIp;
                    $ip->localIpAddress = $localIp;
                    $ip->save();
                }

                return redirect()->route('auth.login')->with('success', 'OTP verified and IP addresses logged.');
            } else {
                return back()->withErrors(['local_ip' => 'Invalid local IP address detected.']);
            }
        } else {
            return back()->withErrors(['ip' => 'Unable to fetch public IP address, please try again later.']);
        }
    } else {
        return back()->withErrors(['otp' => 'Invalid or expired OTP, please try again.']);
    }
}
}
