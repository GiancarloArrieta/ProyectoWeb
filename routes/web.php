<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TicketController;
//bla bla
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
    Route::get('/editarInformacionUsuario', function () {
        return view('editarInformacionUsuario');
    })->name('usuario.edit');
    Route::post('/profile/update', [UsuarioController::class, 'updateProfile'])->name('usuario.update');
    
    // Rutas de tickets
    Route::get('/levantarTicket', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/api/tickets/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/api/tickets/mis-tickets', [TicketController::class, 'misTickets'])->name('ticket.mis-tickets');
    Route::get('/detalleticket/{id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::delete('/api/tickets/{id}', [TicketController::class, 'destroy'])->name('ticket.destroy');
    
    // Rutas de administración
    Route::get('/gestionarusuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/admin/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');
    
    // Rutas de interfaces (mantener compatibilidad)
    Route::get('/interfazadministrador', function () {
        return view('interfazAdministrador');
    });
    
    Route::get('/interfazsoporte', function () {
        return view('interfazSoporte');
    });
});