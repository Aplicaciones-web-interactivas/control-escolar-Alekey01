<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use App\Models\Materia;
use App\Models\User;

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::with(['alumno', 'materia'])->orderBy('id', 'desc')->get();
        return view('layouts.admin.calificacion', compact('calificaciones'));
    }

    public function create()
    {
        $alumnos  = User::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        return view('layouts.admin.calificacioncreate', compact('alumnos', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id'    => 'required|exists:users,id',
            'materia_id'   => 'required|exists:materias,id',
            'calificacion' => 'required|numeric|min:0|max:100',
            'periodo'      => 'required|string|max:20',
        ]);

        Calificacion::create($request->only(['alumno_id', 'materia_id', 'calificacion', 'periodo']));

        return redirect()->route('calificaciones.index')->with('success', 'Calificación registrada exitosamente.');
    }

    public function edit($id)
    {
        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return redirect()->back()->with('error', 'Calificación no encontrada.');
        }

        $alumnos  = User::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        return view('layouts.admin.calificacioneditar', compact('calificacion', 'alumnos', 'materias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alumno_id'    => 'required|exists:users,id',
            'materia_id'   => 'required|exists:materias,id',
            'calificacion' => 'required|numeric|min:0|max:100',
            'periodo'      => 'required|string|max:20',
        ]);

        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return redirect()->back()->with('error', 'Calificación no encontrada.');
        }

        $calificacion->update($request->only(['alumno_id', 'materia_id', 'calificacion', 'periodo']));

        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return redirect()->back()->with('error', 'Calificación no encontrada.');
        }

        $calificacion->delete();
        return redirect()->back()->with('success', 'Calificación eliminada exitosamente.');
    }
}
