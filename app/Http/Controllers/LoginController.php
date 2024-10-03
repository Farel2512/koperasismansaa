<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function loginproses(Request $request){
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $credentials = [
            'username'  => $request->username,
            'password'  => $request->password
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('manager')) {
                return redirect()->route('manager.dashboard');
            } elseif ($user->hasRole('kasir')) {
                return redirect()->route('kasir.dashboard');
            } else {
                return redirect()->route('login')->with('failed','Role not recognized!');
            }
        } else {
            return redirect()->route('login')->with('failed','Username or Password is incorrect!');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','You have successfully logged out.');
    }
}
