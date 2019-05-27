<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\TipoMedia as TipoMediaResource;
use App\Http\Resources\Comentario as ComentarioResource;

class Adjunto extends JsonResource
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
            'url' => $this->url,
            'nombre' => $this->nombre,
            'tipo' => $this->whenLoaded('tipo_media', function() { return TipoMediaResource::make($this->tipo_meda); }, $this->tipo_media_id),
            'comentario' => $this->whenLoaded('comentario', function() { return Comentario::make($this->comentario);}, $this->comentario_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
