<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Imagen as ImagenResource;
use App\Http\Resources\Rol as RolResource;
class User extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'avatar' => $this->whenLoaded('avatar', function() { return ImagenResource::make($this->avatar); }, $this->avatar_id),
            'portada' => $this->whenLoaded('portada', function() { return ImagenResource::make($this->portada); }, $this->portada_id),
            'roles' => $this->whenLoaded('roles', function() { return RolResource::collection($this->roles); }, [])
            // info only for admin users
            // 'email_verified_at'=> '2019-05-21 02=>55=>05',
            // 'created_at'=> '2019-05-21 02=>55=>05',
            // 'updated_at'=> '2019-05-21 02:55:05'
        ];
    }
}
