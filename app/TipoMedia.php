<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMedia extends Model
{
    //
    protected $table = 'tipos_media';
    protected $fillable = [
        'id', 'descripcion', 'controlado'
    ];

    public $incrementing = false;
}
