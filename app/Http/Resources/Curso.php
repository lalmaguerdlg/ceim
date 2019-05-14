<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use \App\Http\Resources\Imagen as ImagenResource;
use \App\Http\Resources\UnidadDuracion as UnidadDuracionResource;

class Curso extends JsonResource
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
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'portada' => new ImagenResource($this->portada),
            'duracion' => $this->duracion,
            'unidad_duracion' => new UnidadDuracionResource($this->unidad_duracion),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
