<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiControlador;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/listar', [MiControlador::class, 'listar']);
Route::get('/listar/{dni}', [MiControlador::class, 'listarPersona']);
Route::post('/insertar', [MiControlador::class, 'insertar']);
Route::put('/updatear', [MiControlador::class, 'updatear']);
Route::delete('/deletear/{dni}', [MiControlador::class, 'deletear']);
