<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use App\Models\Materia;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['maestro', 'alumno', 'materia'])->latest()->get();

        return view('layouts.admin.tarea', compact('tareas'));
    }

    public function create()
    {
        $usuarios  = User::where('activo', true)->orderBy('nombre')->get();
        $materias  = Materia::orderBy('nombre')->get();

        return view('layouts.admin.tareacreate', compact('usuarios', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'maestro_id'    => 'required|exists:users,id',
            'alumno_id'     => 'required|exists:users,id',
            'materia_id'    => 'required|exists:materias,id',
            'fecha_entrega' => 'nullable|date',
            'estado'        => 'required|in:pendiente,entregada,calificada',
        ]);

        Tarea::create($request->only(
            'titulo', 'descripcion', 'maestro_id', 'alumno_id', 'materia_id', 'fecha_entrega', 'estado'
        ));

        return redirect()->route('tareas.index')->with('success', 'Tarea asignada correctamente.');
    }

    public function edit(int $id)
    {
        $tarea    = Tarea::findOrFail($id);
        $usuarios = User::where('activo', true)->orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();

        return view('layouts.admin.tareaeditar', compact('tarea', 'usuarios', 'materias'));
    }

    public function update(Request $request, int $id)
    {
        $tarea = Tarea::findOrFail($id);

        $request->validate([
            'titulo'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'maestro_id'    => 'required|exists:users,id',
            'alumno_id'     => 'required|exists:users,id',
            'materia_id'    => 'required|exists:materias,id',
            'fecha_entrega' => 'nullable|date',
            'estado'        => 'required|in:pendiente,entregada,calificada',
        ]);

        $tarea->update($request->only(
            'titulo', 'descripcion', 'maestro_id', 'alumno_id', 'materia_id', 'fecha_entrega', 'estado'
        ));

        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(int $id)
    {
        Tarea::findOrFail($id)->delete();

        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada correctamente.');
    }
}
