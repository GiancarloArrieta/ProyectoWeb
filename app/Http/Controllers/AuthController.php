<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLogin()
    {
        return view('inicioSesion');
    }

    /**
     * Procesa la solicitud POST para autenticar al usuario.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'usuario'    => 'required|string',
            'contrasena' => 'required|string',
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $request->usuario)->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contreseña)) {
            // Autenticación exitosa
            Auth::login($usuario);
            $request->session()->regenerate();

            // Redirigir según el rol
            $rol = $usuario->rol->nombre ?? 'Usuario';
            
            switch ($rol) {
                case 'Administrador':
                    return redirect()->intended('/interfazadministrador');
                case 'Auxiliar':
                    return redirect()->intended('/interfazsoporte');
                default:
                    return redirect()->intended('/interfazusuario');
            }
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales no son válidas. Verifique su usuario y contraseña.',
        ])->onlyInput('usuario');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/iniciosesion');
    }
}