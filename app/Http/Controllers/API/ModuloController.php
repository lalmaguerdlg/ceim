<?php

namespace App\Http\Controllers\API;

use App\Curso;
use App\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Modulo as ModuloResource;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use function GuzzleHttp\json_encode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($curso_id)
    {
        return ModuloResource::collection(Modulo::where('curso_id', '=', $curso_id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $curso_id)
    {
        $errors = [];
        $data = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        $curso = Curso::with('modulos')->find($curso_id);
        if($curso){
            $modulo = $curso->modulos()->whereRaw("upper(`nombre`) LIKE '%". strtoupper($data['nombre']). "%'")->first();
            if($modulo) {
                $errors['nombre'][] = 'El curso ya contiene un modulo con este nombre.';
            }
        } else {
            throw new ModelNotFoundException();
        }

        if(count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }

        $data['curso_id'] = $curso_id;
        $modulo = Modulo::create($data);
        //$modulo->load('curso');
        return ModuloResource::make($modulo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show($curso_id, $modulo_id)
    {
        $modulo = $this->get_modulo($curso_id, $modulo_id);

        if(!$modulo) {
            throw new ModelNotFoundException();
        }

        return ModuloResource::make($modulo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $curso_id, $modulo_id)
    {
        $errors = [];
        $data = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        $curso = Curso::with('modulos')->find($curso_id);
        if($curso) {
            $modulo = $curso->modulos()->where('id', '!=', $modulo_id)->whereRaw("upper(`nombre`) LIKE '%". strtoupper($data['nombre']). "%'")->first();
            if($modulo) {
                $errors['nombre'][] = 'El curso ya contiene un modulo con este nombre.';
            }
        } else {
            throw new ModelNotFoundException();
        }

        if(count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }


        $modulo = $this->get_modulo($curso_id, $modulo_id);
        if(!$modulo) {
            throw new ModelNotFoundException();
        }

        $modulo->fill($data);
        $modulo->save();
        return ModuloResource::make($modulo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($curso_id, $modulo_id)
    {
        $modulo = $this->get_modulo($curso_id, $modulo_id);
        if(!$modulo) {
            throw new ModelNotFoundException();
        }
        $modulo->delete();
        return response()->json(['message' => 'ok']);
    }

    static public function get_modulo($curso_id, $modulo_id){
        return Modulo::where([
            'curso_id' => $curso_id, 
            'id' => $modulo_id
        ])->first();
    }
}
