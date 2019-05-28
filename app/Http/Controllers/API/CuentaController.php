<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Rol as RolResource;
use App\Imagen;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('portada', 'avatar', 'roles');
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|max:100'
        ]);

        $avatar = $this->create_image_from_request($request, 'avatar', 'avatar');
        $portada = $this->create_image_from_request($request, 'portada', 'portada');

        $user = $request->user();
        $avatar_cargado = false;
        $portada_cargada = false;
        if($request->input('name') != null) 
            $user->name = $request->input('name');
        if($avatar != null) {
            $user->avatar()->associate($avatar);
        }
        if($portada != null) {
            $user->portada()->associate($portada);
        }
        $user->save();

        if(!$avatar_cargado) $user->load('avatar');
        if(!$portada_cargada) $user->load('portada');

        return UserResource::make($user);
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

    public function create_image_from_request(Request $request, $name, $tag) {
        $has_input = $request->input($name) != null || $request->file($name) != null;
        if(!$has_input) return null;
        $is_file = $request->file($name) != null;
        
        $user = $request->user();
        $image = null;
        if($is_file) {
            $request->validate([
                $name => 'image|mimes:jpeg,png,jpg|max:5120'
            ]);

            $file = $request->file($name); 
            //dd($file);
            //$originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $name . '_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            $s3Path = 'ceim/users/'.$fileName;

            Storage::put($s3Path, file_get_contents($file), 'public');

            $image = new Imagen([
                'url' => $s3Path,
                'tag' => $tag,
                'tipo_media_id' => 'image'
            ]);
        }
        else {
            $request->validate([
                $name => 'url'
            ]);

            $image = new Imagen([
                'url' => $request->input($name),
                'tag' => $tag,
                'tipo_media_id' => 'image-url'
            ]);
        }
        $image->save();
        return $image;
    }

    public function roles(Request $request){
        $user = $request->user();
        return RolResource::collection($user->roles);
    }

    public function scopes(Request $request) {
        $user = $request->user();       
        return $user->scopes;
    }
}
