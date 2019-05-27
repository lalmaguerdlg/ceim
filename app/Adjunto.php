<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    //
    protected $table = 'adjuntos';
    protected $fillable = [
        'url', 'nombre', 'tipo_media_id', 'comentario_id'
    ];

    public function comentario() {
        return $this->belongsTo(\App\Comentario::class);
    }

    public function tipo_media() {
        return $this->belongsTo(\App\TipoMedia::class, 'tipo_media');
    }
}
