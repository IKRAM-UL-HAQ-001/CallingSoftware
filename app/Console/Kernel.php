<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{



    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $generateUniqueOtp = function () {
                do {
                    $otp = rand(100000, 999999);
                } while (\App\Models\Otp::where('otp', $otp)->exists());

                return $otp;
            };

            $emails = ['mrdanny160@yahoo.com'];

            foreach ($emails as $email) {
                $otp = $generateUniqueOtp();
                $expiration = \Illuminate\Support\Carbon::now()->addHour();

                \App\Models\Otp::create([
                    'otp' => $otp,
                    'otp_exp' => $expiration,
                ]);

                \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\OtpMail($otp));
            }
        })->everyMinute();  


        $schedule->call(function () {
            \App\Models\IpAddress::truncate(); 
        })->dailyAt('22:00');
    }


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
