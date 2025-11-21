<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DepartamentoController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/iniciosesion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Rutas del usuario
    Route::get('/interfazusuario', [UsuarioController::class, 'profile'])->name('usuario.profile');
    
    // RUTA DE EDICIÓN: Ahora apunta al método 'edit' en UsuarioController
    Route::get('/editarinformacionusuario', [UsuarioController::class, 'edit'])->name('usuario.edit'); 
    
    // RUTA DE EDICIÓN PARA ADMIN/AUXILIAR: Nueva ruta para editar perfil desde interfaces de admin/auxiliar
    Route::get('/editarinformacionadminaux', [UsuarioController::class, 'editAdminAuxiliar'])->name('usuario.edit.adminaux');
    
    // RUTA DE ACTUALIZACIÓN: Ya existía y apunta al método 'updateProfile' (lo usaremos para guardar la imagen)
    Route::post('/profile/update', [UsuarioController::class, 'updateProfile'])->name('usuario.update');
    
    // RUTA DE ACTUALIZACIÓN PARA ADMIN/AUXILIAR: Nueva ruta para actualizar perfil y redirigir apropiadamente
    Route::post('/profile/update-adminaux', [UsuarioController::class, 'updateProfileAdminAux'])->name('usuario.update.adminaux');
    
    // Rutas de tickets
    Route::get('/levantarTicket', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/api/tickets/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/api/tickets/mis-tickets', [TicketController::class, 'misTickets'])->name('ticket.mis-tickets');
    Route::get('/detalleticket/{id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::delete('/api/tickets/{id}', [TicketController::class, 'destroy'])->name('ticket.destroy');
    
    // Rutas para administrador - gestión de tickets
    Route::get('/api/tickets/todos', [TicketController::class, 'todosLosTickets'])->name('tickets.todos');
    Route::get('/api/auxiliares/disponibles', [TicketController::class, 'auxiliaresDisponibles'])->name('auxiliares.disponibles');
    Route::post('/api/tickets/{id}/asignar', [TicketController::class, 'asignarTicket'])->name('ticket.asignar');
    Route::get('/api/tickets/reporte/finalizados', [TicketController::class, 'reporteFinalizados'])->name('tickets.reporte-finalizados');
    Route::get('/api/dashboard/indicadores', [TicketController::class, 'indicadoresDashboard'])->name('dashboard.indicadores');
    Route::get('/api/auxiliares/rendimiento', [TicketController::class, 'rendimientoAuxiliares'])->name('auxiliares.rendimiento');
    Route::get('/api/reportes/grafica', [TicketController::class, 'datosGrafica'])->name('reportes.grafica');
    Route::post('/admin/reportes/generar-pdf', [TicketController::class, 'generarReportePDF'])->name('reportes.generar-pdf');
    
    // Rutas para auxiliar - gestión de tickets asignados
    Route::get('/api/tickets/mis-asignados', [TicketController::class, 'misTicketsAsignados'])->name('tickets.mis-asignados');
    Route::put('/api/tickets/{id}/estado', [TicketController::class, 'cambiarEstado'])->name('ticket.cambiar-estado');
    
    // Rutas de administración
    Route::get('/gestionarusuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/admin/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/api/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    
    // Rutas de interfaces (mantener compatibilidad)
    Route::get('/interfazadministrador', function () {
        $usuario = auth()->user()->load(['rol', 'departamento']);
        return view('interfazAdministrador', compact('usuario'));
    })->name('administrador');
    
    Route::get('/interfazsoporte', function () {
        $usuario = auth()->user()->load(['rol', 'departamento']);
        return view('interfazSoporte', compact('usuario'));
    })->name('soporte');

    Route::get('/administrardepartamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');
    Route::post('/admin/departamentos/store', [DepartamentoController::class, 'store'])->name('departamentos.store');
    Route::get('/api/departamentos', [DepartamentoController::class, 'obtenerDepartamentos'])->name('departamentos.obtener');
    Route::put('/api/departamentos/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    Route::delete('/api/departamentos/{id}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
    Route::get('/api/usuarios/todos', [DepartamentoController::class, 'obtenerUsuarios'])->name('usuarios.todos');
    Route::post('/admin/departamentos/reasignar', [DepartamentoController::class, 'reasignarUsuario'])->name('departamentos.reasignar');

    Route::get('/gestionauxiliares', function () {
        return view('gestionAuxiliares');
    });

    Route::get('/reportesestadisticas', function () {
        return view('reportesEstadisticas');
    });
});
