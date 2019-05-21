<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Imagen as ImagenResource;

class Grupo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'curso' => $this->whenLoaded('curso', [
                'id' => $this->curso->id,
                'nombre' => $this->curso->nombre,
                'descripcion' => $this->curso->descripcion,
                'portada' => ImagenResource::make($this->whenLoaded('curso.portada', $this->curso->portada)),
            ]),
            //'curso_id' => $this->curso_id,
            'inicio_curso' => $this->inicio_curso,
            'fin_curso' => $this->fin_curso,
            'maestro' => UserResource::make($this->maestro),
            'capacidad' => $this->capacidad,
        ];
    }
}
