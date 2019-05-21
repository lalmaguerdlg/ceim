<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Curso;
use App\Grupo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Grupo as GrupoResource;

class CursoGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($curso_id)
    {
        $curso = Curso::with('grupos')->find($curso_id);
        if(!$curso) 
            throw new ModelNotFoundException();
        
        return GrupoResource::collection($curso->grupos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $curso_id)
    {
        $data = $request->validate([
            'inicio_curso' => 'required|date|bail|after:yesterday',
            'fin_curso' => 'nullable|date|bail|after:inicio_curso',
            'maestro' => 'present|nullable|integer|bail|exists:user,id',
        ]);

        $mapped = remap_keys($data, ['maestro' => 'maestro_id']);

        $curso = Curso::find($curso_id);
        if(!$curso) 
            throw new ModelNotFoundException();

        $mapped['curso_id'] = $curso->id;
        $grupo = Grupo::create($mapped);
        return GrupoResource::make($grupo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($curso_id, $grupo_id)
    {
        //
        $grupo = Grupo::with('curso')->where(['curso_id' => $curso_id, 'id' => $grupo_id])->first();
        if(!$grupo) 
            throw new ModelNotFoundException();
        
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
