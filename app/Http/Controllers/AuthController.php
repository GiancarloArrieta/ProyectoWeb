<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Facade para la autenticación

class AuthController extends Controller
{
    /**
     * Procesa la solicitud POST para autenticar al usuario.
     * * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // 1. Validación de Datos (Primer paso crucial de seguridad)
        $request->validate([
            'usuario'    => 'required|string|max:30',
            'contrasena' => 'required|string|min:6', // Asegúrate de que la longitud mínima es segura
        ]);

        // 2. Preparación de Credenciales para el intento de Login
        // Nota: Laravel espera 'password' para el campo de contraseña, 
        // por lo que mapeamos 'contrasena' a 'password' en este array.
        $credentials = [
            'usuario'  => $request->input('usuario'),
            'password' => $request->input('contrasena'), // Laravel maneja el hash
        ];

        // 3. Intento de Autenticación (El archivo PHP que hace la consulta)
        // **Este es el paso que genera la consulta y verifica la coincidencia en la BD.**
        if (Auth::attempt($credentials)) {
            
            // 3.1. Autenticación Exitosa: Se encontró coincidencia en la BD
            
            // Regenerar la sesión (seguridad)
            $request->session()->regenerate();

            // Redirigir a una nueva vista
            return redirect()->intended('/dashboard'); 

        } 
        
        // 4. Coincidencia Fallida: No se encontró el usuario o la contraseña no coincide
        
        // Retornar al formulario con un mensaje de error
        return back()->withErrors([
            'usuario' => 'Las credenciales no son válidas. Verifique su usuario y contraseña.',
        ])->onlyInput('usuario'); 
    }
}