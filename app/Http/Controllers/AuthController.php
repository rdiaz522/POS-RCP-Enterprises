<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if(Auth::user()->roles->first()->name == 'Admin'){
                return redirect()->intended('/home');
            }else{
                return redirect()->intended('/index.php/products');
            }
            
        }
        return redirect()->route('welcome')->with('error','INVALID CREDENTIALS!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
