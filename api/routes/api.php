<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\TarefaController;

// Rotas para registro e login de usuários
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register'); // Rota para registrar um novo usuário
    Route::post('login', 'login');       // Rota para autenticar um usuário
});

// Rotas protegidas para gerenciar tarefas, exigindo autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('tarefas', TarefaController::class); // Rotas RESTful para tarefas
});
