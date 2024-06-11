<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function regPost(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('login')->with('success', 'Register Berhasil');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logPost(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        }
        return back()->with('error', 'Login Gagal');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logout Berhasil');
    }
}
