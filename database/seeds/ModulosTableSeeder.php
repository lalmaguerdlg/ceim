<?php

use Illuminate\Database\Seeder;
use App\Modulo;
use App\Curso;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ModulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $curso = Curso::find(1);

        $now = Carbon::now();
        Modulo::insert([
            [ 'nombre' => 'Matematicas', 'descripcion' => 'Modulo de matematicas', 'curso_id' => $curso->id, 'created_at' => $now, 'updated_at' => $now],
            [ 'nombre' => 'Español', 'descripcion' => 'Modulo de español', 'curso_id' => $curso->id, 'created_at' => $now, 'updated_at' => $now],
            [ 'nombre' => 'Quimica', 'descripcion' => 'Modulo de quimica', 'curso_id' => $curso->id, 'created_at' => $now, 'updated_at' => $now],
            [ 'nombre' => 'Fisica', 'descripcion' => 'Modulo de fisica', 'curso_id' => $curso->id, 'created_at' => $now, 'updated_at' => $now],
            [ 'nombre' => 'Historia', 'descripcion' => 'Modulo de historia', 'curso_id' => $curso->id, 'created_at' => $now, 'updated_at' => $now]
        ]);

    }
}
