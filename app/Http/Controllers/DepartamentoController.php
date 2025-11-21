<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartamentoController extends Controller
{
    /**
     * Mostrar la vista de administración de departamentos
     */
    public function index()
    {
        $departamentos = Departamento::withCount('usuarios')->get();
        $usuarios = Usuario::with(['rol', 'departamento'])->get();
        
        return view('administrarDepartamentos', compact('departamentos', 'usuarios'));
    }

    /**
     * Crear un nuevo departamento
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departamentos,nombre',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Departamento::create([
            'nombre' => $request->name,
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Obtener todos los departamentos (API)
     */
    public function obtenerDepartamentos()
    {
        $departamentos = Departamento::withCount('usuarios')
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($departamentos);
    }

    /**
     * Actualizar un departamento
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:departamentos,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        $departamento->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json(['success' => true, 'message' => 'Departamento actualizado exitosamente', 'departamento' => $departamento]);
    }

    /**
     * Eliminar un departamento
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);

        // Verificar si hay usuarios asignados
        if ($departamento->usuarios()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar el departamento porque tiene usuarios asignados'], 400);
        }

        $departamento->delete();

        return response()->json(['success' => true, 'message' => 'Departamento eliminado exitosamente']);
    }

    /**
     * Obtener todos los usuarios (API)
     */
    public function obtenerUsuarios()
    {
        $usuarios = Usuario::with(['rol', 'departamento'])
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($usuarios);
    }

    /**
     * Reasignar usuario a departamento
     */
    public function reasignarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:usuarios,id',
            'department_id' => 'required|exists:departamentos,id',
        ]);

        if ($validator->fails()) {
            // Si es una petición AJAX, devolver JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            }
            return back()->withErrors($validator)->withInput();
        }

        $usuario = Usuario::findOrFail($request->user_id);
        $usuario->update([
            'id_departamento' => $request->department_id,
        ]);

        // Recargar relaciones
        $usuario->load(['rol', 'departamento']);

        // Si es una petición AJAX, devolver JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Usuario reasignado exitosamente.',
                'usuario' => $usuario
            ]);
        }

        return redirect()->route('departamentos.index')->with('success', 'Usuario reasignado exitosamente.');
    }
}

