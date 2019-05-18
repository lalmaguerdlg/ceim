<?php

namespace App\Http\Controllers\API;

use App\UnidadDuracion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Resources\UnidadDuracion as UnidadDuracionResource;


class UnidadDuracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UnidadDuracionResource::collection(UnidadDuracion::all());
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
     * @param  \App\UnidadDuracion  $unidadDuracion
     * @return \Illuminate\Http\Response
     */
    public function show(UnidadDuracion $unidadDuracion)
    {
        return UnidadDuracionResource::make($unidadDuracion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UnidadDuracion  $unidadDuracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnidadDuracion $unidadDuracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UnidadDuracion  $unidadDuracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnidadDuracion $unidadDuracion)
    {
        //
    }
}
