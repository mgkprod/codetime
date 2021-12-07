<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->input(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);
        $validator->validate();

        $remember = $request->remember ?? false;

        if (! auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            $validator->errors()->add('password', __('auth.failed'));

            return back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('welcome');
    }
}
