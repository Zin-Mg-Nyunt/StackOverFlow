<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    public function create(Request $request){
        if (!session('isVerified')) {
            return redirect('/');
        }
        $email = session('email');
        if($email) session()->keep(['email']);
        return inertia('auth/ResetPassword',[
            'email'=> session('email'),
            'otp' => $request->token
        ]);
    }
    public function store(Request $request){
        $email = session('email');
        if($email){
            session()->keep(['email']);
        }
        $request->validate([
            'password'=> ['required','confirmed',Rules\Password::default()]
        ]);
        $user = User::where('email',$email)->first();
        DB::transaction(function() use($request,$user,$email){
            $user->update([
                'password' => $request->password
            ]);
            DB::table('password_reset_tokens')->where('email',$email)->delete();
        });
        session()->forget(['email','otp','isVerified']);
        return redirect()->route('login')->with('status','Your password has been reseted');

    }
}
