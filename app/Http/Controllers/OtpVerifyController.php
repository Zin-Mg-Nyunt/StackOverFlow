<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OtpVerifyController extends Controller
{
    public function verify(Request $request){
        $email = session('email');
        $status = session('status');
        $expire_at = session('expire_at');
        if($email && $status && $expire_at){
            session()->keep(['email','status','expire_at']);
        };

        $now = time();
        $record=DB::table('password_reset_tokens')->where('email',$email)->first();
        if(!$record){
            return back();
        };
        $isVerified = Hash::check($request->otp,$record->token);
        if(!$isVerified){
            return back()->withErrors(['otp'=>'This is incorrect OTP']);
        }
        if(($expire_at - $now) <= 0){
            return back()->withErrors(['otp'=>'This is invalid Otp']);
        }
        session(['isVerified'=>true]);
        return redirect()->route('password.reset',['token'=> $request->otp]);
    }
}