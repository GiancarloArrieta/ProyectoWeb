<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // 1. Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Validación única excluyendo el email actual del usuario
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Opcional, solo imágenes, hasta 5MB (5120 KB)
        ]);

        // 2. Manejo y Guardado de la Imagen
        if ($request->hasFile('profile_photo')) {
            // Eliminar la foto antigua si existe
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Guardar la nueva foto. Se almacena en storage/app/public/profiles
            // y devuelve la ruta 'profiles/nombre_del_archivo.jpg'
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        // 3. Actualizar otros datos del usuario
        // NOTA: Tu formulario usa 'nombre' y 'correo' para la DB, pero los campos se llaman 'name' y 'email' en el HTML. 
        // Usaré los nombres del HTML ('name', 'email') y los mapearé a las propiedades de tu modelo ('nombre', 'correo')

        $user->nombre = $request->input('name'); // Asumiendo que 'nombre' es el campo real en DB
        $user->correo = $request->input('email'); // Asumiendo que 'correo' es el campo real en DB
        
        $user->save();

        return redirect()->route('usuario.edit')->with('success', '¡Perfil actualizado con éxito, incluyendo la foto!');
    }
}
