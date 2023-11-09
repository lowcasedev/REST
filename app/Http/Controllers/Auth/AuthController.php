<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Encryption\EncryptionController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{


    private EncryptionController $encrypter;

    public function __construct()
    {
        $this->encrypter = new EncryptionController();
    }

    public function signIn(Request $request)
    {
        if ($request->isMethod('get')) return view('Auth.auth');

        $request->validate([
            'login-login' => 'required',
            'login-password' => 'required',
        ]);

        $user = User::where('login', $request->input('login-login'))->first();

        if (!($user && $user->password == $this->encrypter->encrypt($request->input('login-password')))) return redirect('/auth')->withErrors('error', 'Неправильный логин или пароль');

        $request->session()
            ->put(
                ['user' => $user->id]
            );

        return redirect('/notebook');
    }

    public function signUp(Request $request)
    {
        if ($request->isMethod('get')) return view('Auth.auth');

        $request->validate([
            'register-login' => 'required',
            'register-password' => 'required|min:6',
            'register-password-again' => 'required|same:register-password',
        ]);
        $user = User::where('login', $request->input('login'))->first();

        if ($user) return redirect('/auth')->withErrors('error', 'Такой логин уже используется');

        User::create([
            'login' => $request->input('register-login'),
            'password' => $this->encrypter->encrypt($request->input('register-password')),
        ]);

        $user = User::where('login', $request->input('register-login'))->first();

        $request->session()
            ->put(
                ['user' => $user->id]
            );

        return redirect('/notebook');

    }

    public function logOut()
    {
        session()->forget('user');

        return redirect('/');
    }
}
