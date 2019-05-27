<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TipoMedia;

class TiposMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_media')->delete();
        $tiposMedia = [
            ['id' => 'image', 'descripcion' => 'Imagen', 'controlado' => true],
            ['id' => 'image-url', 'descripcion' => 'Imagen en host externo', 'controlado' => false],
            ['id' => 'video', 'descripcion' => 'Video', 'controlado' => true],
            ['id' => 'video-url', 'descripcion' => 'Video en host externo', 'controlado' => false],
            ['id' => 'file', 'descripcion' => 'Archivo', 'controlado' => true],
        ];
        TipoMedia::insert($tiposMedia);
    }
}