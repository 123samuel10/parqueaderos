<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
 public function registro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
           'email' => 'required|email|unique:usuarios,email',

            'password' => 'required|min:5',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Cuenta creada correctamente. Inicia sesión.');
    }

    public function login()
    {
        return view('auth.login');
    }

public function iniciarSesion(Request $request)
{
    $usuario = Usuario::where('email', $request->email)->first();

    if ($usuario && Hash::check($request->password, $usuario->password)) {
        Session::put('usuario', $usuario);
        return redirect('/')->with('success_login', 'Inicio correcto');
    }

    return back()->with('error', 'Credenciales incorrectas');
}


    public function logout()
    {
        Session::forget('usuario');
        return redirect('/login');
    }
}
