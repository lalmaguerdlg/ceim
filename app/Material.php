<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    protected $table = 'cursos';
    
    protected $fillable = [
        'modulo_id', 'nombre',
    ];

    public function modulo() {
        return $this->belongsTo(\App\Modulo::class);
    }

}
