<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Imagen extends JsonResource
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
            'tag' => $this->tag,
            'url' => $this->when($this->tipo_media_id == 'image', function() {
                return Storage::url($this->url);
            }, $this->url),
            'tipo_media' => $this->whenLoaded('tipo_media', function() { return $this->tipo_media;}, $this->tipo_media_id),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];
    }
}
