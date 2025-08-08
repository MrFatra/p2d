<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class OTPController extends Controller
{
    public function index()
    {
        $user = User::find(Session::get('otp_user_id'));

        if (!$user || !$user->otp) {
            return redirect()->back();
        }

        return Inertia::render('Auth/Otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $user = User::find(Session::get('otp_user_id'));

        if (!$user || $user->otp !== $request->otp || now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        Session::put('valid_otp', true);

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return to_route('password.change.index');
    }

    public function resendOtp()
    {
        $user = User::find(Session::get('otp_user_id'));

        if ($user) {
            $otp = rand(100000, 999999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new OtpMail($otp, $user->name));

            return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        }

        return back()->withErrors(['error' => 'Gagal mengirim ulang kode OTP. Silakan coba lagi.']);
    }
}
