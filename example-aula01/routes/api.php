<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCriptoController;

// Rotas para visualizar os registros
Route::get('/', function(){return response()->json(['Sucesso'=>true]);});   
Route::get('/cripto', [ApiCriptoController::class, 'index']);
Route::get('/cripto/{codigo}', [ApiCriptoController::class, 'show']);

// Rota para inserir os registros
Route::post('/cripto',[ApiCriptoController::class,'store']);

// Rota para alterar os registros
Route::put('/cripto/{codigo}', [ApiCriptoController::class, 'update']);

// Rota para excluir o registro por id/código
Route::delete('/cripto/{id}', [ApiCriptoController::class, 'destroy']);
