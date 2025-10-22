<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/iniciosesion', function () {
    return view('inicioSesion');
});

Route::get('/interfazusuario', function () {
    return view('interfazUsuario');
});

Route::get('/editarInformacionUsuario', function () {
    return view('editarInformacionUsuario');
});

Route::get('/levantarTicket', function () {
    return view('levantarTicket');
});

Route::get('/interfazadministrador', function () {
    return view('interfazAdministrador');
});

Route::get('/gestionarusuarios', function () {
    return view('gestionarUsuario');
});

Route::get('/interfazsoporte', function () {
    return view('interfazSoporte');
});

Route::get('/detalleticket', function () {
    return view('detallesTicket');
});