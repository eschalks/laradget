<?php

namespace App\Http\Controllers;

use App\Data\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class PostLogin extends Controller
{
    public function __invoke(LoginForm $loginForm)
    {
        $credentials = [
            'email' => $loginForm->username,
            'password' => $loginForm->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->withInput()->withErrors('Invalid credentials');
        }

        return redirect('/');
    }
}
