<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function resetPassword()
    {
        return view('auth.reset-password');
    }
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
    public function verifyEmail()
    {
        return view('auth.verify-email');
    }
    public function confirmPassword()
    {
        return view('auth.confirm-password');
    }
    public function logout()
    {
        // Logic to log out the user
        return redirect()->route('home');
    }
    public function userLogin()
    {
        // Logic to log in the user
        return redirect()->route('home');
    }
    public function userRegister()
    {
        // Logic to register the user
        return redirect()->route('home');
    }
    public function adminLogin()
    {
        // Logic to log in the admin
        return redirect()->route('admin.dashboard');
    }
    

}
