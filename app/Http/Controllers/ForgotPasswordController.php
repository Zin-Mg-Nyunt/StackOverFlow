<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        $email = session('email');
        $status = session('status');
        $expire_at = session('expire_at');
        if($email && $status && $expire_at){
            session()->keep(['email','status','expire_at']);
        };
        return inertia('auth/ForgotPassword',[
            'email' => $email,
            'status' => $status,
            'expire_at' => $expire_at
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $user=User::where('email',$request->email)->first();
        $expire_at=$user->generateOtpAndSend();
        return redirect()->route('password.request')
                            ->with('status','OTP code ပို့ပြီးပါပြီ')
                            ->with('expire_at',$expire_at)
                            ->with('email',$request->email);
    }
    public function change(){
        session()->forget(['email']);
        return back();
    }
}
