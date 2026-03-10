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
