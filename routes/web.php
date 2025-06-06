<?php

use App\Http\Controllers\{UserController, VideowallController};
use App\Http\Controllers\Stores\{VereadoresController, PartidosController, SetoresController};
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');})->name('home');

    // Autenticação e cadastro de usuários do sistema        
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');
    Route::put('/users/{user}/interests', [UserController::class, 'updateInterests'])->name('users.updateInterests');
    Route::put('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Área do videowall
    Route::get('/videowall', [VideowallController::class, 'index'])->name('videowall.index');
    Route::get('/videowall/create', [VideowallController::class, 'create'])->name('videowall.create');
    Route::post('/videowall/vereadores', [VereadoresController::class, 'store'])->name('videowall.vereadores.store');
    Route::post('/videowall/partidos', [PartidosController::class, 'storePartido'])->name('videowall.partidos.store');
    Route::post('/videowall/setores', [SetoresController::class, 'storeSetor'])->name('videowall.setores.store');

    Route::delete('/videowall/vereadores/{vereador}', [VideowallController::class, 'destroyVereador'])->name('videowall.vereadores.destroy');
    Route::delete('/videowall/setores/{setor}', [VideowallController::class, 'destroySetor'])->name('videowall.setores.destroy');
    Route::delete('/videowall/partidos/{partido}', [VideowallController::class, 'destroyPartido'])->name('videowall.partidos.destroy');


});



