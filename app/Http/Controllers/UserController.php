<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequestValidate;
use App\Http\Requests\RegisterRequestValidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }

    public function register(RegisterRequestValidate $request)
    {
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->validated());
        Auth::login($user);

        return redirect('/');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function login(LoginRequestValidate $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }

    public function getLogin()
    {
        return view('auth.login');
    }
}
