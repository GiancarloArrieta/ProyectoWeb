<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Departamento;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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

    /**
     * Obtener todos los tickets (para administrador)
     */
    public function todosLosTickets()
    {
        $tickets = Ticket::with(['usuario', 'departamentoAsignado', 'auxiliarAsignado'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($tickets);
    }

    /**
     * Obtener auxiliares disponibles (todos los auxiliares)
     */
    public function auxiliaresDisponibles()
    {
        $rolAuxiliar = Rol::where('nombre', 'Auxiliar')->first();
        
        if (!$rolAuxiliar) {
            return response()->json([]);
        }

        // Obtener todos los auxiliares
        $auxiliares = Usuario::where('id_rol', $rolAuxiliar->id)->get();

        // Devolver todos los auxiliares sin restricción
        $auxiliaresConEstado = $auxiliares->map(function ($auxiliar) {
            // Contar tickets activos (Asignado + En Proceso)
            $ticketsActivos = Ticket::where('id_auxiliar_asignado', $auxiliar->id)
                                    ->whereIn('status', ['Asignado', 'En Proceso'])
                                    ->count();
            
            return [
                'id' => $auxiliar->id,
                'nombre' => $auxiliar->nombre,
                'correo' => $auxiliar->correo,
                'disponible' => true, // Siempre disponible
                'tickets_activos' => $ticketsActivos,
            ];
        });

        return response()->json($auxiliaresConEstado);
    }

    /**
     * Asignar ticket a un auxiliar
     */
    public function asignarTicket(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_auxiliar' => 'required|exists:usuarios,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos'], 400);
        }

        $ticket = Ticket::findOrFail($id);

        // Verificar que el ticket esté pendiente
        if ($ticket->status !== 'Pendiente') {
            return response()->json(['success' => false, 'message' => 'Solo se pueden asignar tickets pendientes'], 400);
        }

        // Sin restricción - el auxiliar puede tener múltiples tickets
        $ticket->update([
            'id_auxiliar_asignado' => $request->id_auxiliar,
            'fecha_asignacion' => Carbon::now(),
            'status' => 'Asignado',
        ]);

        return response()->json(['success' => true, 'message' => 'Ticket asignado exitosamente']);
    }

    /**
     * Obtener tickets asignados al auxiliar autenticado (incluyendo finalizados)
     */
    public function misTicketsAsignados()
    {
        $usuario = auth()->user();
        
        $tickets = Ticket::where('id_auxiliar_asignado', $usuario->id)
                        ->with(['usuario', 'departamentoAsignado'])
                        ->whereIn('status', ['Asignado', 'En Proceso', 'Finalizado'])
                        ->orderByRaw("FIELD(status, 'En Proceso', 'Asignado', 'Finalizado')")
                        ->orderBy('created_at', 'asc')
                        ->get();

        return response()->json($tickets);
    }

    /**
     * Cambiar estado del ticket
     */
    public function cambiarEstado(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Asignado,En Proceso,Finalizado',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Estado inválido'], 400);
        }

        $ticket = Ticket::findOrFail($id);
        $usuario = auth()->user();

        // Verificar que el ticket esté asignado al usuario autenticado
        if ($ticket->id_auxiliar_asignado !== $usuario->id) {
            return response()->json(['success' => false, 'message' => 'No tienes permiso para modificar este ticket'], 403);
        }

        $dataToUpdate = ['status' => $request->status];

        // Registrar fechas según el estado
        if ($request->status === 'En Proceso' && !$ticket->fecha_inicio) {
            $dataToUpdate['fecha_inicio'] = Carbon::now();
        } elseif ($request->status === 'Finalizado' && !$ticket->fecha_finalizacion) {
            $dataToUpdate['fecha_finalizacion'] = Carbon::now();
        }

        $ticket->update($dataToUpdate);

        return response()->json(['success' => true, 'message' => 'Estado actualizado exitosamente', 'ticket' => $ticket]);
    }

    /**
     * Generar reporte de tickets finalizados
     */
    public function reporteFinalizados()
    {
        $ticketsFinalizados = Ticket::with(['usuario', 'departamentoAsignado', 'auxiliarAsignado'])
                                   ->where('status', 'Finalizado')
                                   ->orderBy('fecha_finalizacion', 'desc')
                                   ->get();

        return response()->json([
            'total' => $ticketsFinalizados->count(),
            'tickets' => $ticketsFinalizados,
        ]);
    }
}
