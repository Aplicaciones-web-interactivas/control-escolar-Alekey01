<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaAlumnoController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['maestro', 'materia'])
            ->where('alumno_id', auth()->id())
            ->latest()
            ->get();

        return view('alumno.mis-tareas', compact('tareas'));
    }

    public function subirPdf(Request $request, int $id)
    {
        $tarea = Tarea::where('id', $id)
            ->where('alumno_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'archivo_pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'archivo_pdf.required' => 'Debes seleccionar un archivo PDF.',
            'archivo_pdf.mimes'    => 'Solo se permiten archivos en formato PDF.',
            'archivo_pdf.max'      => 'El archivo no debe superar los 10 MB.',
        ]);

        // Eliminar archivo anterior si existe
        if ($tarea->archivo_pdf && Storage::disk('public')->exists($tarea->archivo_pdf)) {
            Storage::disk('public')->delete($tarea->archivo_pdf);
        }

        $path = $request->file('archivo_pdf')->store('tareas/pdfs', 'public');

        $tarea->update([
            'archivo_pdf' => $path,
            'estado'      => 'entregada',
        ]);

        return redirect()->route('alumno.mis-tareas')->with('success', 'Tarea entregada exitosamente.');
    }
}
