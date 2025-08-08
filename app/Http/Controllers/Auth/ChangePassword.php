<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ChangePassword extends Controller
{
    public function index()
    {
        $user = User::find(Session::get('otp_user_id'));

        if (!$user || !Session::get('valid_otp')) {
            return redirect()->back();
        }

        return Inertia::render('Auth/ChangePassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = User::find(Session::get('otp_user_id'));

        if (!$user) {
            return back()->withErrors(['password' => 'Pengguna tidak valid.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        Session::forget(['otp_user_id', 'valid_otp']);

        return to_route('login.index')->with('success', 'Password berhasil diubah, silahkan login ulang.');
    }
}
