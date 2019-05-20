<?php

namespace App\Http\Controllers\API;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Material as MaterialResource;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($curso_id, $modulo_id)
    {
        $modulo = ModuloController::get_modulo($curso_id, $modulo_id);
        if(!$modulo) {
            throw new ModelNotFoundException();
        }
        return MaterialResource::collection($modulo->materiales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $curso_id, $modulo_id)
    {
        $errors = [];
        $data = $request->validate([
            'nombre' => 'required|max:255',
        ]);

        $modulo = ModuloController::get_modulo($curso_id, $modulo_id);
        if($modulo) {
            $material = $modulo->materiales()->whereRaw("upper(`nombre`) LIKE '%". strtoupper($data['nombre']). "%'")->first();
            if($material){
                $errors['nombre'][] = 'El modulo ya tiene un material con este nombre.';
            }
        } 
        else {
            throw new ModelNotFoundException();
        }

        if(count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }

        $data['modulo_id'] = $modulo_id;
        $material = Material::create($data);
        return MaterialResource::make($material);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show($curso_id, $modulo_id, $material_id)
    {
        $material = Material::whereHas('modulo', function ($q) use ($curso_id, $modulo_id) {
            $q->where([ 'id' => $modulo_id, 'curso_id' => $curso_id]);
        })->where('id', $material_id)->first();
        if(!$material) {
            throw new ModelNotFoundException();
        }
        return MaterialResource::make($material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $curso_id, $modulo_id, $material_id)
    {
        $errors = [];
        $data = $request->validate([
            'nombre' => 'required|max:255',
        ]);

        $modulo = ModuloController::get_modulo($curso_id, $modulo_id);
        $modulo->load('materiales');
        if($modulo) {
            $material = $modulo->materiales()->where('id', '!=', $material_id)->whereRaw("upper(`nombre`) LIKE '%". strtoupper($data['nombre']). "%'")->first();
            if($material){
                $errors['nombre'][] = 'El modulo ya tiene un material con este nombre.';
            }
        } 
        else {
            throw new ModelNotFoundException();
        }

        if(count($errors) > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }

        $material = $modulo->materiales()->where('id', $material_id)->first();
        $material->fill($data);
        $material->save();
        return MaterialResource::make($material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy($curso_id, $modulo_id, $material_id)
    {
        $material = Material::whereHas('modulo', function ($q) use ($curso_id, $modulo_id) {
            $q->where([ 'id' => $modulo_id, 'curso_id' => $curso_id]);
        })->where('id', $material_id)->first();
        if(!$material) {
            throw new ModelNotFoundException();
        }
        $material->delete();
        return response()->json([ 'message' => 'ok' ]);
    }
}
