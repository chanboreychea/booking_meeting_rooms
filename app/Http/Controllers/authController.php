<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class authController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Please input the username',
            'password.required' => 'Please input the password'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        if ($username == 'admin.iauoffsa.gov.kh' && $password == "123") {
            $request->session()->pull('is_admin_logged_in');
            $request->session()->pull('admin_id');
            session(['is_admin_logged_in' => true, 'admin_id' => "B0r3y!19"]);
            return redirect('/booking');
        }
        return Redirect::route('admin-login');
    }

    public function logout(Request $request)
    {

        if ($request->session()->has('is_admin_logged_in')) {
            $request->session()->pull('is_admin_logged_in');
            $request->session()->pull('admin_id');
        }

        return Redirect::route('homepage');
    }
}
