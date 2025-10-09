<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPartida;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/listar', [MiControlador::class, 'listar']);
Route::GET('/partida/{id}', [ControladorPartida::class, 'getPartida'])->whereNumber('id');
Route::get('/partida', [ControladorPartida::class, 'getAllPartidas']);
Route::post('/partida/{numeroCasillas} ', [ControladorPartida::class, 'crearPartida']);
Route::post('/destapar/{num1}/{num2}', [ControladorPartida::class, 'destaparCasilla'])->whereNumber(['num1', 'num2']);