<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginform(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:5']
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return redirect()->route('auth.loginform')->withErrors(['email' => 'اطلاعات وارد شده اشتباه است']);
        }

        if(!Hash::check($request->password,$user->password)){
            return redirect()->route('auth.loginform')->withErrors(['email' => 'اطلاعات وارد شده اشتباه است']);
        }

        Auth::login($user,$remember=true);
        
        return redirect()->route('home');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.loginform');
    }
}
