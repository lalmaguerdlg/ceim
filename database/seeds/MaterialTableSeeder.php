<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = Carbon::now();
        $materiales = [
            ['modulo_id' => '1', 'nombre' => 'Guia de estudio', 'created_at' => $now, 'updated_at' => $now ],
            ['modulo_id' => '1', 'nombre' => 'Recursos adicionales', 'created_at' => $now, 'updated_at' => $now ],
        ];
        DB::table('materiales')->insert($materiales);
    }
}
