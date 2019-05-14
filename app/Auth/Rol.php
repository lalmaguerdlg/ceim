<?php

namespace App\Auth;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{

    public $table = 'roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rol', 'descripcion'
    ];

   // protected $hidden = array('pivot');

    public function scopes() {
        return $this->belongsToMany(Scope::class)->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany('\App\User')->withTimestamps();
    }

}
