<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comentario;
use App\Http\Resources\Comentario as ComentarioResource;
use Illuminate\Support\Facades\Storage;
use App\Adjunto;
use Illuminate\Validation\ValidationException;

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
            'mensaje' => 'required|max:255'
        ]);

        $data['autor_id'] = $user->id;
        $data['grupo_id'] = $grupo_id;

        $adjunto = $this->get_adjunto($request);

        $mensaje = Comentario::create($data);
        if($adjunto != null) {
            $mensaje->adjuntos()->save($adjunto);
        }
            
        $mensaje->load('autor.avatar', 'adjuntos');
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


    public function get_adjunto(Request $request) {
        $data = $request->validate([
            'adjunto' => 'nullable',
            'tipo_adjunto' => 'sometimes|in:youtube,image'
        ]);

        
        $has_adjunto = isset($data['adjunto']);
        $tipo_adjunto = $request->input('tipo_adjunto');
        
        if($has_adjunto) {
            if($tipo_adjunto == null) {
                throw ValidationException::withMessages([ 'tipo_adjunto' => 'Debe estar presente si se agrego un adjunto' ]);
            }
            else {
                switch ($tipo_adjunto) {
                    case 'youtube':
                        if($request->file('adjunto'))
                            throw ValidationException::withMessages([ 'adjunto' => 'No es posible subir un archivo a un adjunto marcado como youtube' ]);
                    break;
                    case 'image':
                        if(!$request->file('adjunto'))
                            throw ValidationException::withMessages([ 'adjunto' => 'No se encontro el archivo a subir' ]);
                    break;
                }
            }
        }
        else {
            return null;
        }


        if($tipo_adjunto == 'youtube') {
            return Adjunto::create([
                'url' => $request->input('adjunto'),
                'nombre' => 'Youtube',
                'tipo_media_id' => 'video-url'
            ]);
        }
        else if($tipo_adjunto == 'image') {
            $file = $request->file('adjunto'); 
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = "adjunto".time().'.'.request()->file('adjunto')->getClientOriginalExtension();
            $file->storeAs('adjuntos', $fileName);

            $s3Path = 'ceim/adjuntos/'.$fileName;

            Storage::put($s3Path, file_get_contents($file), 'public');

            return Adjunto::create([
                'url' => $s3Path,
                'nombre' => $originalName,
                'tipo_media_id' => 'image'
            ]);
        }
        return null;
    }
}
