<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Parameters\MuscleController;
use App\Http\Controllers\Training\exercise_routinesController;
use App\Http\Controllers\Training\user_assignmentController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Dashboard
    Route::get('/dashboard', function () {return view('admin.layouts.base');})->name('dashboard');
    // Página de inicio
    Route::get('/inicio', function () {return view('admin.layouts.base');})->name('admin.inicio.index');

    /*
    |--------------------------------------------------------------------------
    | Rutas de administración (vistas)
    |--------------------------------------------------------------------------
    */
    Route::get('/muscles', function () {return view('admin.muscles.index');})->name('admin.muscles.index');
    Route::get('/exercise_routines', function () {return view('admin.exercise_routines.index');})->name('admin.exercise_routines.index');
    Route::get('/user_assignments', function () {return view('admin.user_assignments.index');})->name('admin.user_assignments.index');

    /*
    |--------------------------------------------------------------------------
    | Rutas de API (para obtener información específica)
    |--------------------------------------------------------------------------
    */
    Route::get('/user/{id}', [ApiController::class, 'getuser']);
    Route::get('/muscles/{id}', [ApiController::class, 'getmuscles']);
    Route::get('/exercise_routines/{id}', [ApiController::class, 'getexercise_routines']);
    Route::get('/user_assignments/{id}', [ApiController::class, 'getuser_assignments']);

    /*
    |--------------------------------------------------------------------------
    | Rutas para guardar (POST)
    |--------------------------------------------------------------------------
    */
    Route::post('/guardar/muscles', [MuscleController::class, 'save'])->name('muscles.save');
    Route::post('/guardar/exercise_routines', [exercise_routinesController::class, 'save'])->name('exercise_routines.save');
    Route::post('/guardar/user_assignments', [user_assignmentController::class, 'save'])->name('user_assignments.save');

    /*
    |--------------------------------------------------------------------------
    | Rutas para cambiar el estado (POST)
    |--------------------------------------------------------------------------
    */
    Route::post('/muscles/estado/{id}', [MuscleController::class, 'updateEstado'])->name('muscles.updateEstado');

    /*
    |--------------------------------------------------------------------------
    | Rutas para eliminar (DELETE)
    |--------------------------------------------------------------------------
    */
    Route::delete('/muscles/destroy/{id}', [MuscleController::class, 'delete'])->name('muscles.destroy');
    Route::delete('/exercise_routines/destroy/{id}', [exercise_routinesController::class, 'delete'])->name('exercise_routines.destroy');
    Route::delete('/user_assignments/destroy/{id}', [user_assignmentController::class, 'delete'])->name('user_assignments.destroy');

});
