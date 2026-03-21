<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get('/login',    [AuthController::class, 'login'])->name('login');
Route::post('/login',   [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register',[AuthController::class, 'registerPost'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Dashboard (requiere autenticación)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/admin/materia', [App\Http\Controllers\AdminController::class, 'materia'])->name('admin.materia');
Route::post('/admin/materia', [App\Http\Controllers\AdminController::class, 'saveMateria'])->name('admin.saveMateria');
Route::delete('/admin/materia/{id}', [App\Http\Controllers\AdminController::class, 'deleteMateria'])->name('admin.deleteMateria');
Route::get('/admin/materiaeditar/{id}',  [App\Http\Controllers\AdminController::class, 'editMateria'])->name('admin.editMateria');
Route::put('/admin/materia/{id}',         [App\Http\Controllers\AdminController::class, 'updateMateria'])->name('admin.updateMateria');

// Calificaciones
Route::get('/calificaciones',           [App\Http\Controllers\CalificacionController::class, 'index'])->name('calificaciones.index');
Route::get('/calificaciones/crear',     [App\Http\Controllers\CalificacionController::class, 'create'])->name('calificaciones.create');
Route::post('/calificaciones',          [App\Http\Controllers\CalificacionController::class, 'store'])->name('calificaciones.store');
Route::get('/calificaciones/{id}/editar', [App\Http\Controllers\CalificacionController::class, 'edit'])->name('calificaciones.edit');
Route::put('/calificaciones/{id}',      [App\Http\Controllers\CalificacionController::class, 'update'])->name('calificaciones.update');
Route::delete('/calificaciones/{id}',   [App\Http\Controllers\CalificacionController::class, 'destroy'])->name('calificaciones.destroy');

// Inscripciones
Route::get('/inscripciones',              [App\Http\Controllers\InscripcionController::class, 'index'])->name('inscripciones.index');
Route::get('/inscripciones/crear',        [App\Http\Controllers\InscripcionController::class, 'create'])->name('inscripciones.create');
Route::post('/inscripciones',             [App\Http\Controllers\InscripcionController::class, 'store'])->name('inscripciones.store');
Route::get('/inscripciones/{id}/editar',  [App\Http\Controllers\InscripcionController::class, 'edit'])->name('inscripciones.edit');
Route::put('/inscripciones/{id}',         [App\Http\Controllers\InscripcionController::class, 'update'])->name('inscripciones.update');
Route::delete('/inscripciones/{id}',      [App\Http\Controllers\InscripcionController::class, 'destroy'])->name('inscripciones.destroy');
