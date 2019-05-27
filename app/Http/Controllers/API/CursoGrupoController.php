<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Curso;
use App\Grupo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Grupo as GrupoResource;
use App\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class CursoGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($curso_id)
    {
        $curso = Curso::with('grupos')->findOrFail($curso_id);
        
        $grupos = $curso->grupos()->with('maestro.avatar')->withCount('inscripciones')->get();
        return GrupoResource::collection($grupos);
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
            'fin_curso' => 'present|nullable|date|bail|after:inicio_curso',
            'maestro' => 'present|nullable|integer|bail|exists:users,id',
            'capacidad' => 'required|integer',
        ]);

        $curso = Curso::findOrFail($curso_id);

        $mapped = remap_keys($data, ['maestro' => 'maestro_id']);

        $mapped['curso_id'] = $curso->id;
        $mapped['inicio_curso'] = Carbon::parse($mapped['inicio_curso']);
        $mapped['fin_curso'] = $mapped['fin_curso'] !== null ? Carbon::parse($mapped['fin_curso']) : null;
        if($mapped['maestro_id'] != null){
            $maestro = User::find($mapped['maestro_id']);
            if( !$maestro->isAllowed('cursos-teach') ) {
                throw ValidationException::withMessages([ 'maestro' => 'Este usuario no tiene permitido ser maestro de un grupo' ]);
            }
        }
        //dd($mapped);
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
        $grupo = Grupo::with('curso')->withCount('inscripciones')->where(['curso_id' => $curso_id, 'id' => $grupo_id])->firstOrFail();
        return GrupoResource::make($grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $curso_id, $grupo_id)
    {
        $data = $request->validate([
            'inicio_curso' => 'date|bail|after:yesterday',
            'fin_curso' => 'nullable|date|bail|after:inicio_curso',
            'maestro' => 'nullable|integer|bail|exists:users,id',
            'capacidad' => 'integer',
        ]);

        $grupo = Grupo::with('curso')->withCount('inscripciones')->where(['curso_id' => $curso_id, 'id' => $grupo_id])->firstOrFail();

        $mapped = remap_keys($data, ['maestro' => 'maestro_id']);

        $mapped['inicio_curso'] = Carbon::parse($mapped['inicio_curso']);
        $mapped['fin_curso'] = $mapped['fin_curso'] !== null ? Carbon::parse($mapped['fin_curso']) : null;
        if($mapped['maestro_id'] != null){
            $maestro = User::find($mapped['maestro_id']);
            if( !$maestro->isAllowed('cursos-teach') ) {
                throw ValidationException::withMessages([ 'maestro' => 'Este usuario no tiene permitido ser maestro de un grupo' ]);
            }
        }
        $grupo->fill($mapped);
        $grupo->save();
        return GrupoResource::make($grupo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($curso_id, $grupo_id)
    {
        $grupo = Grupo::where(['curso_id' => $curso_id, 'id' => $grupo_id])->firstOrFail();
        $grupo->delete();
        return response()->json(['message' => 'ok']);
    }
}
