<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // NECESARIO

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

        Usuario::create([
            'nombre' => $request->name,
            'correo' => $request->email,
            'contreseña' => Hash::make($request->password),
            'id_rol' => $request->role,
            'id_departamento' => $request->department_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Obtener información de un usuario específico
     */
    public function show($id)
    {
        $usuario = Usuario::with(['rol', 'departamento'])->findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Actualizar información de un usuario (Desde el panel de administración)
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,correo,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departamentos,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dataToUpdate = [
            'nombre' => $request->name,
            'correo' => $request->email,
            'id_rol' => $request->role,
            'id_departamento' => $request->department_id,
        ];

        // Solo actualizar la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $dataToUpdate['contreseña'] = Hash::make($request->password);
        }

        $usuario->update($dataToUpdate);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Mostrar información del usuario autenticado (interfazUsuario)
     */
    public function profile()
    {
        $usuario = auth()->user();
        return view('interfazUsuario', compact('usuario'));
    }

    /**
     * Mostrar la vista para editar la información del usuario autenticado
     */
    public function edit()
    {
        return view('editarInformacionUsuario');
    }

    /**
     * Actualizar perfil del usuario y manejar la foto de perfil
     */
    public function updateProfile(Request $request)
    {
        $usuario = auth()->user();

        // 1. Validación
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. Manejo de la Foto de Perfil
        if ($request->hasFile('profile_photo')) {
            
            // Eliminar la foto antigua si existe en el disco 'public'
            if ($usuario->profile_photo && Storage::disk('public')->exists($usuario->profile_photo)) {
                Storage::disk('public')->delete($usuario->profile_photo);
            }

            // Guardar la nueva foto
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $usuario->profile_photo = $path;
        }

        // 3. Actualización de datos (nombre y email)
        $usuario->nombre = $request->name;
        $usuario->correo = $request->email;
        
        // 4. Guardar cambios en la base de datos
        $usuario->save();

        // **CAMBIO SOLICITADO:** Redirige a la vista de perfil
        return redirect()->route('usuario.profile')->with('success', '¡Perfil actualizado con éxito, incluyendo la foto!');
    }
}

