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
        //
        $imagen = new Imagen([
            'tag' => 'default',
            'url' => 'https://carepharmaceuticals.com.au/wp-content/uploads/sites/19/2018/02/placeholder-600x400.png'
        ]);
        $imagen->save();
    }
}
