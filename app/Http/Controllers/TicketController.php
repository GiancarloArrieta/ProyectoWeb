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
        // Optimización: Seleccionar solo campos necesarios
        $tickets = Ticket::select(['id', 'título', 'descripción', 'status', 'id_departamento_asignado', 'created_at'])
                        ->where('id_usuario', $usuario->id)
                        ->with(['departamentoAsignado:id,nombre'])
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
        // Optimización: Usar eager loading y limitar campos innecesarios
        $tickets = Ticket::select(['id', 'título', 'descripción', 'status', 'id_usuario', 'id_departamento_asignado', 'id_auxiliar_asignado', 'created_at', 'updated_at', 'fecha_asignacion', 'fecha_inicio', 'fecha_finalizacion'])
                        ->with([
                            'usuario:id,nombre,correo',
                            'departamentoAsignado:id,nombre',
                            'auxiliarAsignado:id,nombre,correo'
                        ])
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

        // Obtener el ID del auxiliar del request
        $auxiliarId = $request->id_auxiliar ?? $request->input('id_auxiliar');
        
        if (!$auxiliarId) {
            return response()->json(['success' => false, 'message' => 'ID de auxiliar requerido'], 400);
        }
        
        // Sin restricción - el auxiliar puede tener múltiples tickets
        $ticket->update([
            'id_auxiliar_asignado' => $auxiliarId,
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
        
        // Optimización: Seleccionar solo campos necesarios
        $tickets = Ticket::select(['id', 'título', 'descripción', 'status', 'id_usuario', 'id_departamento_asignado', 'created_at', 'fecha_inicio', 'fecha_finalizacion'])
                        ->where('id_auxiliar_asignado', $usuario->id)
                        ->with([
                            'usuario:id,nombre,correo',
                            'departamentoAsignado:id,nombre'
                        ])
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
            'fecha_hora_cliente' => 'nullable|date', // Fecha y hora del cliente (opcional)
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

        // Usar la fecha y hora del cliente si se proporciona, de lo contrario usar la del servidor
        $fechaHora = $request->filled('fecha_hora_cliente') 
            ? Carbon::parse($request->fecha_hora_cliente) 
            : Carbon::now();

        // Registrar fechas según el estado
        if ($request->status === 'En Proceso' && !$ticket->fecha_inicio) {
            $dataToUpdate['fecha_inicio'] = $fechaHora;
        } elseif ($request->status === 'Finalizado' && !$ticket->fecha_finalizacion) {
            $dataToUpdate['fecha_finalizacion'] = $fechaHora;
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

    /**
     * Obtener indicadores del dashboard
     */
    public function indicadoresDashboard()
    {
        // Tickets pendientes y finalizados
        $pendientes = Ticket::where('status', 'Pendiente')->count();
        $finalizados = Ticket::where('status', 'Finalizado')->count();
        
        // Tickets por departamento
        $porDepartamento = Departamento::withCount('tickets')
            ->get()
            ->map(function ($departamento) {
                return [
                    'nombre' => $departamento->nombre,
                    'total' => $departamento->tickets_count,
                ];
            });
        
        // Productividad por auxiliar
        $rolAuxiliar = Rol::where('nombre', 'Auxiliar')->first();
        $productividad = [];
        
        if ($rolAuxiliar) {
            $auxiliares = Usuario::where('id_rol', $rolAuxiliar->id)->get();
            
            $productividad = $auxiliares->map(function ($auxiliar) {
                $finalizados = Ticket::where('id_auxiliar_asignado', $auxiliar->id)
                                    ->where('status', 'Finalizado')
                                    ->count();
                
                return [
                    'nombre' => $auxiliar->nombre,
                    'finalizados' => $finalizados,
                ];
            })->sortByDesc('finalizados')->values();
        }
        
        return response()->json([
            'pendientes' => $pendientes,
            'finalizados' => $finalizados,
            'por_departamento' => $porDepartamento,
            'productividad' => $productividad,
        ]);
    }

    /**
     * Obtener rendimiento de auxiliares por período
     */
    public function rendimientoAuxiliares(Request $request)
    {
        $periodo = $request->query('periodo', 'mes_actual');
        
        // Calcular fechas según el período
        $fechaInicio = null;
        switch ($periodo) {
            case 'mes_actual':
                $fechaInicio = Carbon::now()->startOfMonth();
                break;
            case 'trimestre':
                $fechaInicio = Carbon::now()->subMonths(3)->startOfMonth();
                break;
            case 'anual':
                $fechaInicio = Carbon::now()->startOfYear();
                break;
            default:
                $fechaInicio = Carbon::now()->startOfMonth();
        }
        
        $rolAuxiliar = Rol::where('nombre', 'Auxiliar')->first();
        
        if (!$rolAuxiliar) {
            return response()->json([]);
        }
        
        $auxiliares = Usuario::where('id_rol', $rolAuxiliar->id)->get();
        
        $rendimiento = $auxiliares->map(function ($auxiliar) use ($fechaInicio) {
            // Tickets asignados en el período (basado en fecha de asignación o creación)
            $query = Ticket::where('id_auxiliar_asignado', $auxiliar->id)
                          ->where(function($q) use ($fechaInicio) {
                              $q->where('fecha_asignacion', '>=', $fechaInicio)
                                ->orWhere(function($q2) use ($fechaInicio) {
                                    $q2->whereNull('fecha_asignacion')
                                       ->where('created_at', '>=', $fechaInicio);
                                });
                          });
            
            $totalAsignados = (clone $query)->count();
            $finalizados = (clone $query)->where('status', 'Finalizado')->count();
            $pendientes = Ticket::where('id_auxiliar_asignado', $auxiliar->id)
                               ->whereIn('status', ['Pendiente', 'Asignado', 'En Proceso'])
                               ->count();
            
            // Calcular promedio de cierre en horas
            $ticketsFinalizados = Ticket::where('id_auxiliar_asignado', $auxiliar->id)
                                       ->where('status', 'Finalizado')
                                       ->where(function($q) use ($fechaInicio) {
                                           $q->where('fecha_asignacion', '>=', $fechaInicio)
                                             ->orWhere(function($q2) use ($fechaInicio) {
                                                 $q2->whereNull('fecha_asignacion')
                                                    ->where('created_at', '>=', $fechaInicio);
                                             });
                                       })
                                       ->whereNotNull('fecha_finalizacion')
                                       ->get();
            
            $promedioCierre = 0;
            if ($ticketsFinalizados->count() > 0) {
                $totalHoras = $ticketsFinalizados->sum(function ($ticket) {
                    if ($ticket->fecha_inicio && $ticket->fecha_finalizacion) {
                        return $ticket->fecha_inicio->diffInHours($ticket->fecha_finalizacion);
                    }
                    return 0;
                });
                $promedioCierre = $totalHoras / $ticketsFinalizados->count();
            }
            
            return [
                'id' => $auxiliar->id,
                'nombre' => $auxiliar->nombre,
                'total_asignados' => $totalAsignados,
                'finalizados' => $finalizados,
                'pendientes' => $pendientes,
                'promedio_cierre' => $promedioCierre,
            ];
        });
        
        return response()->json($rendimiento);
    }

    /**
     * Obtener datos para gráficas
     */
    public function datosGrafica(Request $request)
    {
        $tipo = $request->query('tipo', 'estatus');
        
        switch ($tipo) {
            case 'estatus':
                $data = [
                    'labels' => ['Pendiente', 'Asignado', 'En Proceso', 'Finalizado'],
                    'values' => [
                        Ticket::where('status', 'Pendiente')->count(),
                        Ticket::where('status', 'Asignado')->count(),
                        Ticket::where('status', 'En Proceso')->count(),
                        Ticket::where('status', 'Finalizado')->count(),
                    ],
                ];
                break;
                
            case 'departamento':
                $departamentos = Departamento::withCount('tickets')->get();
                $data = [
                    'labels' => $departamentos->pluck('nombre')->toArray(),
                    'values' => $departamentos->pluck('tickets_count')->toArray(),
                ];
                break;
                
            case 'auxiliar':
                $rolAuxiliar = Rol::where('nombre', 'Auxiliar')->first();
                if ($rolAuxiliar) {
                    $auxiliares = Usuario::where('id_rol', $rolAuxiliar->id)->get();
                    $data = [
                        'labels' => $auxiliares->pluck('nombre')->toArray(),
                        'values' => $auxiliares->map(function ($aux) {
                            return Ticket::where('id_auxiliar_asignado', $aux->id)
                                        ->where('status', 'Finalizado')
                                        ->count();
                        })->toArray(),
                    ];
                } else {
                    $data = ['labels' => [], 'values' => []];
                }
                break;
                
            case 'tiempo':
                // Gráfica de tiempo promedio de respuesta por mes (últimos 6 meses)
                $meses = [];
                $valores = [];
                for ($i = 5; $i >= 0; $i--) {
                    $fechaInicio = Carbon::now()->subMonths($i)->startOfMonth();
                    $fechaFin = Carbon::now()->subMonths($i)->endOfMonth();
                    
                    $tickets = Ticket::where('status', 'Finalizado')
                                   ->whereBetween('fecha_finalizacion', [$fechaInicio, $fechaFin])
                                   ->whereNotNull('fecha_inicio')
                                   ->get();
                    
                    $promedio = 0;
                    if ($tickets->count() > 0) {
                        $totalHoras = $tickets->sum(function ($ticket) {
                            return $ticket->fecha_inicio->diffInHours($ticket->fecha_finalizacion);
                        });
                        $promedio = $totalHoras / $tickets->count();
                    }
                    
                    $meses[] = $fechaInicio->format('M Y');
                    $valores[] = round($promedio, 1);
                }
                $data = [
                    'labels' => $meses,
                    'values' => $valores,
                ];
                break;
                
            default:
                $data = ['labels' => [], 'values' => []];
        }
        
        return response()->json($data);
    }

    /**
     * Generar reporte PDF
     */
    public function generarReportePDF(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|string',
            'department' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $query = Ticket::with(['usuario', 'departamentoAsignado', 'auxiliarAsignado'])
                      ->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);

        // Filtrar por estatus
        if ($request->status && $request->status !== 'todos') {
            $statusMap = [
                'finalizado' => 'Finalizado',
                'cancelado' => 'Cancelado',
                'pendiente' => 'Pendiente',
                'proceso' => 'En Proceso',
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        // Filtrar por departamento
        if ($request->department && $request->department !== 'todos') {
            $query->where('id_departamento_asignado', $request->department);
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        // Verificar si se puede usar dompdf
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            // Usar dompdf si está disponible
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.pdf', compact('tickets', 'request'));
            return $pdf->download('reporte-tickets-' . date('Y-m-d') . '.pdf');
        } else {
            // Alternativa: retornar HTML para imprimir como PDF
            $html = view('reportes.pdf', compact('tickets', 'request'))->render();
            
            // Retornar HTML con headers para descarga
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="reporte-tickets-' . date('Y-m-d') . '.html"');
        }
    }
}
