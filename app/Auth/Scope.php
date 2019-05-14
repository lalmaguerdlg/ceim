<?php

namespace App\Auth;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    public $table = 'scopes';
    protected $primaryKey = 'scope';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scope', 'descripcion'
    ];

    //protected $hidden = array('pivot');

    public function roles() {
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }
}
