<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Mostrar la vista de gestión de usuarios
     */
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'departamento'])->get();
        $roles = Rol::all();
        $departamentos = Departamento::all();
        
        return view('gestionarUsuario', compact('usuarios', 'roles', 'departamentos'));
    }

    /**
     * Crear un nuevo usuario
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departamentos,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Crear el rol si no existe
        $rol = Rol::firstOrCreate(['nombre' => $request->role]);

        Usuario::create([
            'nombre' => $request->name,
            'correo' => $request->email,
            'contreseña' => Hash::make($request->password),
            'id_rol' => $rol->id,
            'id_departamento' => $request->department_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar información del usuario autenticado
     */
    public function profile()
    {
        $usuario = auth()->user();
        return view('interfazUsuario', compact('usuario'));
    }

    /**
     * Actualizar perfil del usuario
     */
    public function updateProfile(Request $request)
    {
        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usuario->update([
            'nombre' => $request->name,
            'correo' => $request->email,
        ]);

        // Manejar la foto de perfil si se subió
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_photos', $filename);
            // Aquí podrías guardar la ruta en la base de datos si tienes un campo para eso
        }

        return redirect()->route('usuario.profile')->with('success', 'Perfil actualizado exitosamente.');
    }
}
