<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

public function bibliotecarioLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    $user = \App\Models\User::where('email', $credentials['email'])
        ->where('role', 'bibliotecario')
        ->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'Estas credenciais não correspondem aos nossos registros.'
        ]);
    }

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'password' => 'Senha incorreta.'
    ]);
}
