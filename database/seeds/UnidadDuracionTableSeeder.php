<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadDuracionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_duraciones = [
            ['nombre' => 'Hora', 'plural' => 'Horas'],
            ['nombre' => 'Dia', 'plural' => 'Dias'],
            ['nombre' => 'Semana', 'plural' => 'Semanas'],
            ['nombre' => 'Mes', 'plural' => 'Meses'],
            ['nombre' => 'Sesión', 'plural' => 'Sesiones'],
        ];

        DB::table('unidad_duraciones')->insert($tipo_duraciones);
    }
}
