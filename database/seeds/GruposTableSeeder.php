<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Carbon\CarbonImmutable;

class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = CarbonImmutable::now();
        $end = $now->addMonth();
        $grupos = [
            ['curso_id' => 1, 'inicio_curso' => $now, 'fin_curso' => $end, 'maestro_id' => 1, 'capacidad' => 30, 'created_at' => $now,  'updated_at' => $now],
            ['curso_id' => 1, 'inicio_curso' => $now, 'fin_curso' => $end, 'maestro_id' => 1, 'capacidad' => 30, 'created_at' => $now,  'updated_at' => $now],
            ['curso_id' => 1, 'inicio_curso' => $now, 'fin_curso' => $end, 'maestro_id' => 1, 'capacidad' => 30, 'created_at' => $now,  'updated_at' => $now]
        ];
        DB::table('grupos')->insert($grupos);
    }
}
