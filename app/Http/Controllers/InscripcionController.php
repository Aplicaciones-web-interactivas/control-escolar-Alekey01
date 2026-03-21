<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Materia;
use App\Models\User;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['alumno', 'materia'])->orderBy('id', 'desc')->get();
        return view('layouts.admin.inscripcion', compact('inscripciones'));
    }

    public function create()
    {
        $alumnos  = User::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        return view('layouts.admin.inscripcioncreate', compact('alumnos', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id'  => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'periodo'    => 'required|string|max:20',
        ]);

        $existe = Inscripcion::where('alumno_id',  $request->alumno_id)
                             ->where('materia_id', $request->materia_id)
                             ->where('periodo',    $request->periodo)
                             ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['alumno_id' => 'El alumno ya está inscrito en esta materia para el periodo indicado.']);
        }

        Inscripcion::create($request->only(['alumno_id', 'materia_id', 'periodo']));

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción registrada exitosamente.');
    }

    public function edit($id)
    {
        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Inscripción no encontrada.');
        }

        $alumnos  = User::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        return view('layouts.admin.inscripcioneditar', compact('inscripcion', 'alumnos', 'materias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alumno_id'  => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'periodo'    => 'required|string|max:20',
        ]);

        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Inscripción no encontrada.');
        }

        $existe = Inscripcion::where('alumno_id',  $request->alumno_id)
                             ->where('materia_id', $request->materia_id)
                             ->where('periodo',    $request->periodo)
                             ->where('id', '!=', $id)
                             ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['alumno_id' => 'El alumno ya está inscrito en esta materia para el periodo indicado.']);
        }

        $inscripcion->update($request->only(['alumno_id', 'materia_id', 'periodo']));

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::find($id);
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Inscripción no encontrada.');
        }

        $inscripcion->delete();
        return redirect()->back()->with('success', 'Inscripción eliminada exitosamente.');
    }
}
