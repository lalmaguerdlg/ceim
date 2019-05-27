<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Grupo as GrupoResource;

class Comentario extends JsonResource
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
            "id" => $this->id,  
            "mensaje" => $this->mensaje,  
            "autor" => $this->whenLoaded('autor', function() { return UserResource::make($this->autor); }, $this->autor_id),
            "grupo" => $this->whenLoaded('grupo', function() { return GrupoResource::make($this->grupo); }, $this->grupo_id),
            "adjuntos" => $this->whenLoaded('adjuntos', function() { return Adjunto::collection($this->adjuntos); }),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
