<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = User::where('rol', 'alumno')->orderBy('nombre')->get();

        return view('admin.alumnos', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'              => 'required|string|max:100',
            'clave_institucional' => 'required|string|max:50|unique:users,clave_institucional',
            'email'               => 'required|email|max:150|unique:users,email',
            'password'            => 'required|string|min:6',
        ], [
            'clave_institucional.unique' => 'Esa clave institucional ya esta registrada.',
            'email.unique'               => 'Ese correo ya esta registrado.',
            'password.min'               => 'La contrasena debe tener al menos 6 caracteres.',
        ]);

        User::create([
            'nombre'              => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'email'               => $request->email,
            'password'            => Hash::make($request->password),
            'rol'                 => 'alumno',
            'activo'              => true,
        ]);

        return redirect()->route('admin.alumnos')->with('success', 'Alumno registrado correctamente.');
    }

    public function destroy(int $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.alumnos')->with('success', 'Alumno eliminado correctamente.');
    }
}
