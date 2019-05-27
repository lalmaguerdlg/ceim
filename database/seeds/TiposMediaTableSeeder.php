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
        $tiposMedia = [
            ['id' => 'image', 'descripcion' => 'Imagen en host externo', 'controlado' => false],
            ['id' => 'image-managed', 'descripcion' => 'Imagen en host interno', 'controlado' => true],
            ['id' => 'video', 'descripcion' => 'Video en host externo', 'controlado' => false],
            ['id' => 'video-managed', 'descripcion' => 'Video en host interno', 'controlado' => true],
            ['id' => 'file', 'descripcion' => 'Archivo en host interno', 'controlado' => true],
        ];
        TipoMedia::insert($tiposMedia);
    }
}
