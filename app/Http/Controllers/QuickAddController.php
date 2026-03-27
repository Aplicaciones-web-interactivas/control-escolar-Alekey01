<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class QuickAddController extends Controller
{
    public function storeUsuario(Request $request)
    {
        $data = $request->validate([
            'nombre'             => 'required|string|max:100',
            'clave_institucional'=> 'required|string|max:50|unique:users,clave_institucional',
            'email'              => 'required|email|max:150|unique:users,email',
            'password'           => 'required|string|min:6',
            'rol'                => ['required', Rule::in(['maestro', 'alumno'])],
        ], [
            'clave_institucional.unique' => 'Esa clave institucional ya está registrada.',
            'email.unique'               => 'Ese correo ya está registrado.',
            'password.min'               => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::create([
            'nombre'              => $data['nombre'],
            'clave_institucional' => $data['clave_institucional'],
            'email'               => $data['email'],
            'password'            => Hash::make($data['password']),
            'rol'                 => $data['rol'],
            'activo'              => true,
        ]);

        return response()->json([
            'id'                  => $user->id,
            'nombre'              => $user->nombre,
            'clave_institucional' => $user->clave_institucional,
        ]);
    }

    public function storeMateria(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:materias,nombre',
            'clave'  => 'required|string|max:20|unique:materias,clave',
        ], [
            'nombre.unique' => 'Ya existe una materia con ese nombre.',
            'clave.unique'  => 'Ya existe una materia con esa clave.',
        ]);

        $materia = Materia::create($data);

        return response()->json([
            'id'     => $materia->id,
            'nombre' => $materia->nombre,
            'clave'  => $materia->clave,
        ]);
    }
}
