<?php

use Illuminate\Database\Seeder;
use App\Curso;
use App\UnidadDuracion;

class CursosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $unidad_medida = UnidadDuracion::where('nombre', '=', 'Mes')->first();
        $curso = Curso::create([
            'nombre' => 'Secundaria Libre',
            'descripcion' => 'Cruso de secundaria libre.',
            'duracion' => 6,
            'unidad_duracion_id' => $unidad_medida->id,
        ]);
    }
}
