<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;




class UserController extends Controller
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

        $user = User::where('name', $username)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                $request->session()->pull('is_user_logged_in');
                session(['is_user_logged_in' => true, 'user_id' =>   $user->id]);
                return redirect('/calendar');
            }
        }
        return Redirect::route('user-login');
    }

    public function logout(Request $request)
    {
        
        if ($request->session()->has('is_user_logged_in')) {
            $request->session()->pull('is_user_logged_in');
            $request->session()->pull('user_id');
        }

        return Redirect::route('homepage');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create',);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['bail', 'required', 'max:100'],
                'email' => ['bail', 'required', 'email', Rule::unique('users', 'email')],
                'password' => ['bail', 'required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            ],
            [
                'name.required' => 'សូមបញ្ចូលឈ្មោះ',
                'name.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ១០០​ តួរ',
                'email.required' => 'សូមបញ្ចូលអ៊ីម៉ែលរបស់អ្នក',
                'email.unique' => 'អ៊ីម៉ែលមានរួចហើយ',
                'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់',
            ]
        );



        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'), ['rounds' => 12]);
        $user->save();
        return redirect('/users');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate(
            [
                'name' => ['required', 'max:100'],
                'email' => ['required', 'email', Rule::unique('users', 'email')->whereNot('id', $id)],
                'password' => ['nullable', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            ],
            [
                'name.required' => 'សូមបញ្ចូលឈ្មោះ',
                'name.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ១០០​ តួរ',
                'email.required' => 'សូមបញ្ចូលអ៊ីម៉ែលរបស់អ្នក',
                'email.unique' => 'អ៊ីម៉ែលមានរួចហើយ',
            ]
        );

        //password
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'), ['rounds' => 12]);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();
        return redirect('/users');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users');
    }
}
