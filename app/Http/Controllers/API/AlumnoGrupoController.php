<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Grupo as GrupoResource;
use App\Grupo;
use Illuminate\Support\Collection;

class AlumnoGrupoController extends Controller
{

    public function __construct()
    {
        // Estos comentarios son solo para futuras referencias
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $grupos = [];
        $grupos = $user->grupos()->with('curso.portada', 'curso.unidad_duracion', 'maestro.avatar')->get();
        return GrupoResource::collection($grupos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $grupo_id)
    {
        $user = $request->user();
        $grupo = $user->grupos()->with(
            'alumnos.avatar', 
            'maestro.avatar',
            'curso.portada', 
            'curso.unidad_duracion', 
            'curso.modulos.materiales' 
            // 'comentarios.autor.avatar', 
            // 'comentarios.adjuntos'
        )->findOrFail($grupo_id);

        return GrupoResource::make($grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
