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

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function getLocalIp()
{
    // Attempt to get the local IP using server variables
    if (isset($_SERVER['REMOTE_ADDR'])) {
        $localIp = $_SERVER['REMOTE_ADDR'];
        // Check if the IP is private
        if (filter_var($localIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return $localIp;
        }
    }
    return null; // Return null if no local IP is found
}


    private function isPrivateIp($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    public function verifyAndLogIp(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $otp = $request->input('otp');
    $publicIp = $this->getIp();
    $localIp = $this->getLocalIp(); 
    dd($publicIp, $localIp);

    $otpRecord = Otp::where('otp', $otp)
        ->where('otp_exp', '>', Carbon::now())
        ->first();

    if ($otpRecord) {
        if ($publicIp) {
            // Check if IP already exists in the database
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
}
