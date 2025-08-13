<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\SendOtpToUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function LoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'phone' => ['required','regex:/^09[1|2|3][0-9]{8}$/']
        ]);
        try{
        $user = User::where('phone',$request->phone)->first();
        $otp = mt_rand(100000,999999);
        $login_token=Hash::make(Str::random(60));

        if($user){
            $user->update([
                'otp' => $otp,
                'login_token' => $login_token
            ]);
        }else{
            $user = User::create([
                'phone' => $request->phone,
                'otp' => $otp,
                'login_token' => $login_token
            ]);
        }

        //  $user->notify(new SendOtpToUser($otp));

        return response()->json([
            'login_token' => $login_token
        ]);

        }
        
        catch(\Exception $ex){
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'login_token' => 'required'
        ]);

        try {

            $user = User::where('login_token', $request->login_token)->firstOrFail();

            if($user->otp == $request->otp) {
                Auth::login($user, $remember = true);
                return response()->json(['message' => 'ورود با موفقیت انجام شد'], 200);
            } else {
                return response()->json(['message' => 'کد ورود نادرست است'], 422);
            }
            
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function resendOtp(Request $request){
        $request->validate([
            'login_token' => ['required']
        ]);

        try{
        $user = User::where('login_token',$request->login_token)->first();
        $otp = mt_rand(100000,999999);
        $login_token=Hash::make(Str::random(60));

        if($user){
            $user->update([
                'otp' => $otp,
                'login_token' => $login_token
            ]);
        }

        //  $user->notify(new SendOtpToUser($otp));

        return response()->json([
            'login_token' => $login_token
        ]);
        }
        catch(\Exception $ex){
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success','کاربر خارج شد');
    }
}
