<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Repositories\ScopesRepository;
use App\Traits\HasScopes;

class User extends Authenticatable
 {
    use HasScopes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username) {
        return $this->where('email', $username)->first();
    }

    public function hasRole($roles) {
        $rol = null;
        if(is_array($roles)) {
            $rol = $this->roles()->whereIn('rol', $roles)->first();
        }
        else {
            $rol = $this->roles()->where('rol', $roles)->first();
        }
        return $rol != null;
    }

    public function roles() {
        return $this->belongsToMany('\App\Auth\Rol')->withTimestamps();
    }

    public function avatar() {
        return $this->belongsTo(\App\Imagen::class, 'avatar_id', 'id');
    }

    public function imparte_grupos() {
        return $this->hasMany(\App\Grupo::class, 'maestro_id', 'id');
    }

    public function inscripciones() {
        return $this->hasMany(\App\Inscripcion::class);
    }

    public function grupos_inscritos() {
        return $this->hasManyThrough(\App\Grupo::class, \App\Inscripcion::class, 'user_id', 'id', 'id', 'grupo_id');
    }

    public function grupos() {
        // ESTO ES UN FIX TEMPORAL
        $grupos_relation = null;
        if( $this->hasRole(['maestro', 'admin']) ) {
            $grupos_relation = $this->imparte_grupos();
        }
        else {
            $grupos_relation = $this->grupos_inscritos();
        }
        return $grupos_relation;
    }

    public function comentarios_realizados() {
        return $this->hasMany(\App\Comentario::class, 'autor_id');
    }

}
