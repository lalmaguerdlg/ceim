<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    //
    protected $table = 'grupos';

    protected $fillable = [
        'curso_id', 'inicio_curso', 'fin_curso', 'maestro_id', 'capacidad',
    ];

    public function curso() {
        return $this->belongsTo(\App\Curso::class);
    }

    public function inscripciones() {
        return $this->hasMany(\App\Inscripcion::class);
    }

    public function maestro() {
        return $this->belongsTo(\App\User::class, 'maestro_id', 'id');
    }

    public function alumnos() {
        return $this->hasManyThrough(\App\User::class, \App\Inscripcion::class, 'grupo_id', 'id', 'id', 'user_id');
    }

}

