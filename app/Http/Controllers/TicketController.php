<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Mostrar la vista para crear un ticket
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('levantarTicket', compact('departamentos'));
    }

    /**
     * Crear un nuevo ticket
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usuario = auth()->user();

        Ticket::create([
            'título' => $request->title,
            'descripción' => $request->description,
            'status' => 'Pendiente',
            'id_usuario' => $usuario->id,
            'id_departamento_asignado' => $usuario->id_departamento, // Asignar al departamento del usuario
        ]);

        return redirect()->route('usuario.profile')->with('success', 'Ticket creado exitosamente.');
    }

    /**
     * Obtener tickets del usuario autenticado
     */
    public function misTickets()
    {
        $usuario = auth()->user();
        $tickets = Ticket::where('id_usuario', $usuario->id)
                        ->with(['departamentoAsignado'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($tickets);
    }

    /**
     * Mostrar detalles de un ticket
     */
    public function show($id)
    {
        $ticket = Ticket::with(['usuario', 'departamentoAsignado'])->findOrFail($id);
        return view('detallesTicket', compact('ticket'));
    }

    /**
     * Eliminar un ticket
     */
    public function destroy($id)
    {
        $usuario = auth()->user();
        $ticket = Ticket::where('id', $id)
                       ->where('id_usuario', $usuario->id)
                       ->first();

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket no encontrado'], 404);
        }

        // Solo permitir eliminar tickets con estado "Pendiente"
        if ($ticket->status !== 'Pendiente') {
            return response()->json(['success' => false, 'message' => 'Solo se pueden eliminar tickets pendientes'], 400);
        }

        $ticket->delete();

        return response()->json(['success' => true, 'message' => 'Ticket eliminado exitosamente']);
    }
}
