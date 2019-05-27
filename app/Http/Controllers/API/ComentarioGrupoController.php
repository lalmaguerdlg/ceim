<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comentario;
use App\Http\Resources\Comentario as ComentarioResource;

class ComentarioGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $grupo_id)
    {
        //
        $user = $request->user();
        $grupo = $user->grupos()->findOrFail($grupo_id);
        $comentarios = $grupo->comentarios()->with('autor.avatar', 'adjuntos')->orderBy('comentarios.updated_at', 'desc')->get();
        return ComentarioResource::collection($comentarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $grupo_id)
    {
        $user = $request->user();

        $data = $request->validate([
            'mensaje' => 'required|max:255',
            //'adjunto' => ''
        ]);

        $data['autor_id'] = $user->id;
        $data['grupo_id'] = $grupo_id;

        $mensaje = Comentario::create($data);
        $mensaje->load('autor.avatar');
        return ComentarioResource::make($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
