<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Imagen as ImagenResource;
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
            'avatar' => ImagenResource::make($this->avatar),
            // info only for admin users
            // 'email_verified_at'=> '2019-05-21 02=>55=>05',
            // 'created_at'=> '2019-05-21 02=>55=>05',
            // 'updated_at'=> '2019-05-21 02:55:05'
        ];
    }
}
