<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
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

// Módulo alumno — ver y entregar tareas (requiere autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/mis-tareas',                    [App\Http\Controllers\TareaAlumnoController::class, 'index'])->name('alumno.mis-tareas');
    Route::post('/mis-tareas/{id}/subir-pdf',    [App\Http\Controllers\TareaAlumnoController::class, 'subirPdf'])->name('alumno.tareas.subir');
});

// Alumnos
Route::get('/admin/alumnos',        [App\Http\Controllers\AlumnoController::class, 'index'])->name('admin.alumnos');
Route::post('/admin/alumnos',       [App\Http\Controllers\AlumnoController::class, 'store'])->name('admin.alumnos.store');
Route::delete('/admin/alumnos/{id}',[App\Http\Controllers\AlumnoController::class, 'destroy'])->name('admin.alumnos.destroy');

// Quick-add AJAX (para modales en formularios)
Route::post('/ajax/usuario', [App\Http\Controllers\QuickAddController::class, 'storeUsuario'])->name('ajax.usuario.store');
Route::post('/ajax/materia', [App\Http\Controllers\QuickAddController::class, 'storeMateria'])->name('ajax.materia.store');

// Tareas
Route::get('/tareas',              [App\Http\Controllers\TareaController::class, 'index'])->name('tareas.index');
Route::get('/tareas/crear',        [App\Http\Controllers\TareaController::class, 'create'])->name('tareas.create');
Route::post('/tareas',             [App\Http\Controllers\TareaController::class, 'store'])->name('tareas.store');
Route::get('/tareas/{id}/editar',  [App\Http\Controllers\TareaController::class, 'edit'])->name('tareas.edit');
Route::put('/tareas/{id}',         [App\Http\Controllers\TareaController::class, 'update'])->name('tareas.update');
Route::delete('/tareas/{id}',      [App\Http\Controllers\TareaController::class, 'destroy'])->name('tareas.destroy');
