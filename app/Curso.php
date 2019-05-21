<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    //
    protected $table = 'cursos';

    protected $fillable = [
        'nombre', 'descripcion', 'portada_id', 'duracion', 'unidad_duracion_id',
    ];


    public function portada() {
        return $this->belongsTo(Imagen::class)->withDefault([
            'id' => 0,
            'tag' => 'default',
            'url' => asset('public/images/placeholder.jpg')
        ]);
    }

    public function unidad_duracion() {
        return $this->belongsTo(UnidadDuracion::class);
    }

    public function modulos() {
        return $this->hasMany(\App\Modulo::class);
    }

    public function grupos() {
        return $this->hasMany(\App\Grupo::class);
    }

}
