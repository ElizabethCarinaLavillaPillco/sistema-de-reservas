<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // Mostrar el formulario de login
public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $credentials = $request->only('correo', 'password');

    if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
        return redirect()->intended('/dashboard');

    }

    return redirect()->route('login')->with('error', 'Credenciales inválidas');
}


    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function username()
{
    return 'correo';
}


    
}