<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadDuracion extends Model
{

    protected $table = 'unidad_duraciones';

    protected $fillable = [
        'nombre', 'plural'
    ];
}
