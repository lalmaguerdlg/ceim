<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Imagen;

class ImagenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagenes = [
            [
                'tag' => 'default',
                'url' => asset('images/placeholder.jpg'),
                'tipo_media_id' => 'image-url'
            ],
            [
                'tag' => 'default-avatar',
                'url' => asset('images/avatar-placeholder.png'),
                'tipo_media_id' => 'image-url'
            ]
        ];

        Imagen::insert($imagenes);
    }
}
