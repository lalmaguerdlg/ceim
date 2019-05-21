<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    //
    protected $table = 'inscripciones';

    protected $fillable = [
        'grupo_id', 'user_id'
    ];

    public function grupo() {
        return $this->belongsTo(\App\Grupo::class);
    }

    public function alumno() {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
