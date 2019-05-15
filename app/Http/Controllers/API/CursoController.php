<?php

namespace App\Http\Controllers\API;

use App\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Http\Resources\Curso as CursoResource;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CursoResource::collection(\App\Curso::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|max:255|bail|unique:cursos',
            'descripcion' => 'required',
            'portada' => 'present|nullable|integer|bail|exists:imagenes,id',
            'duracion' => 'required|integer',
            'unidad_duracion' => 'present|nullable|integer|bail|exists:unidad_duraciones,id',
        ]);

        $unidad_id = $data['unidad_duracion'];
        if($unidad_id == null) {
            $unidad_duracion = \App\UnidadDuracion::where('nombre', '=', 'Mes')->first();
            $unidad_id = $unidad_duracion->id;
        }
        
        $curso = Curso::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'portada_id' => $data['portada'],
            'duracion' => $data['duracion'],
            'unidad_duracion_id' => $unidad_id,
        ]);
        $curso->save();
        return new CursoResource($curso);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        return new CursoResource($curso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'nombre' => 'max:255|bail|unique:cursos',
            'descripcion' => '',
            'portada' => 'nullable|integer|bail|exists:imagenes,id',
            'duracion' => 'integer',
            'unidad_duracion' => 'integer|bail|exists:unidad_duraciones,id',
        ]);

        $mapped = remap_keys($data, [
            'portada' => 'portada_id',
            'unidad_duracion' => 'unidad_duracion_id'
        ]);

        $curso->fill($mapped);
        $curso->save();
        return new CursoResource($curso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
    }



}
