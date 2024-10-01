<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginCtrl extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            return redirect('/');
        }

        if(request()->isMethod('post')){
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $credentials = array(
                'username' => request()->username,
                'password' => request()->password
            );
            if(Auth::attempt($credentials)){
                if (request()->has('remember')) {
                    // Set a longer session timeout if 'remember me' is checked
                    $lifetime = 43200; // For example, 30 days (in minutes)
                    config(['session.lifetime' => $lifetime]);
                    Auth::viaRemember();
                }
                return redirect('/');
            }

            return back()->with('error',true)->withInput();;
        }
        return view('login');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->intended('/login');
    }
}
