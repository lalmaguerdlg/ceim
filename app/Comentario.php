<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    //
    protected $table = 'comentarios';

    protected $fillable = [
        'autor_id', 'mensaje', 'grupo_id'
    ];

    protected $casts = [
        'grupo_id' => 'int'
    ];

    public function autor() {
        return $this->belongsTo(\App\User::class, 'autor_id');
    }

    public function adjuntos() {
        return $this->hasMany(\App\Adjunto::class);
    }

    public function grupo() {
        return $this->belongsTo(\App\Grupo::class);
    }
}
