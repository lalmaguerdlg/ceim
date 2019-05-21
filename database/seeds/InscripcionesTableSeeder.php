<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InscripcionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::where('email', 'alumno@alumno.com')->first();
        if($user){
            $now = Carbon::now();
            $inscripciones = [
                ['grupo_id' => 1, 'user_id' => $user->id, 'created_at' => $now,  'updated_at' => $now],
            ];

            DB::table('inscripciones')->insert($inscripciones);
        }
    }
}
