<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia; //importate el modelo Materia

class AdminController extends Controller
{
    public function materia(){
        $materias = Materia::all(); // Obtener todas las materias
        return view('layouts.admin.materia', compact('materias'));
    }

    public function saveMateria(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave'  => 'required|string|max:50|unique:materias',
        ]);

        Materia::create([
            'nombre' => $request->input('nombre'),
            'clave'  => $request->input('clave'),
        ]);

        return redirect()->route('admin.materia')->with('success', 'Materia guardada exitosamente');
    }

    public function deleteMateria($id){
        $materia = Materia::find($id);
        if ($materia != null) {
            $materia->delete();
            return redirect()->back()->with('success', 'Materia eliminada exitosamente');
        } else
            return redirect()->back()->with('error', 'Materia no encontrada');
        return redirect()->back();
    }

    public function editMateria($id){
        $materia = Materia::find($id);
        if ($materia != null) {
            return view('layouts.admin.materiaeditar', compact('materia'));
        } else
            return redirect()->back()->with('error', 'Materia no encontrada');
    }

    public function updateMateria(Request $request, $id){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave'  => 'required|string|max:50|unique:materias,clave,' . $id,
        ]);

        $materia = Materia::find($id);
        if ($materia) {
            $materia->nombre = $request->input('nombre');
            $materia->clave  = $request->input('clave');
            $materia->save();
            return redirect()->route('admin.materia')->with('success', 'Materia actualizada exitosamente');
        }
        return redirect()->back()->with('error', 'Materia no encontrada');
    }
}
