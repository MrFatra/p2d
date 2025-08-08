<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class OtpThrottle
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Session::get('otp_user_id');

        if (!$userId) {
            return redirect()->back()->withErrors(['error' => 'Sesi OTP tidak ditemukan.']);
        }

        $lastSentAt = Session::get('otp_last_sent_at');

        $delayInSeconds = 60;

        if ($lastSentAt) {
            $lastSent = Carbon::parse($lastSentAt);
            $elapsed = $lastSent->diffInSeconds(now());

            if ($elapsed < $delayInSeconds) {
                $remaining = $delayInSeconds - $elapsed;

                $minutes = floor($remaining / 60);
                $seconds = $remaining % 60;

                $message = 'Tunggu ';
                if ($minutes > 0) $message .= "$minutes menit ";
                if ($seconds > 0) $message .= "$seconds detik ";
                $message .= 'sebelum mengirim ulang OTP.';

                return back()->withErrors(['otp' => trim($message)]);
            }
        }

        Session::put('otp_last_sent_at', now());

        return $next($request);
    }
}
