<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'tag', 'url', 'tipo_media_id'
    ];

    public function tipo_media() {
        return $this->belongsTo(\App\TipoMedia::class);
    }
}
