<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParqueaderoController;
use Illuminate\Support\Facades\Route;

// Página principal: si hay usuario logueado, muestra sus reservas
Route::get('/', [ParqueaderoController::class, 'inicio']);

// Parqueaderos
Route::get('/crear', [ParqueaderoController::class, 'create']);
Route::post('/guardar', [ParqueaderoController::class, 'store']);
Route::get('/reservar/{id}', [ParqueaderoController::class, 'reservar']);
Route::post('/reservar', [ParqueaderoController::class, 'guardarReserva']);

// Autenticación
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'iniciarSesion']);
Route::get('/registro', [AuthController::class, 'registro']);
Route::post('/registro', [AuthController::class, 'registrar']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/parqueaderos/disponibles', [ParqueaderoController::class, 'disponibles'])->name('parqueaderos.disponibles');



// Editar parqueadero
Route::get('/parqueadero/editar/{id}', [ParqueaderoController::class, 'edit']);
Route::put('/parqueadero/editar/{id}', [ParqueaderoController::class, 'update']);

// Eliminar parqueadero
Route::delete('/parqueadero/eliminar/{id}', [ParqueaderoController::class, 'destroy']);
// Eliminar reserva
Route::delete('/reserva/eliminar/{id}', [ParqueaderoController::class, 'eliminarReserva']);
