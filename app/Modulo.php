<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    //
    protected $table = 'modulos';

    protected $fillable = [
        'curso_id', 'nombre', 'descripcion'
    ];

    public function curso() {
        return $this->belongsTo(\App\Curso::class);
    }

    public function materiales() {
        return $this->hasMany(\App\Material::class);
    }
}
