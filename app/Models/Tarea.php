<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'maestro_id',
        'alumno_id',
        'materia_id',
        'fecha_entrega',
        'estado',
        'archivo_pdf',
    ];

    public function maestro()
    {
        return $this->belongsTo(User::class, 'maestro_id');
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
