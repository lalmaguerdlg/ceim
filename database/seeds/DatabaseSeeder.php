<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(ScopesTableSeeder::class);
        $this->call(UnidadDuracionTableSeeder::class);
        $this->call(ImagenesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(ModulosTableSeeder::class);
        $this->call(GruposTableSeeder::class);
        $this->call(InscripcionesTableSeeder::class);
    }
}
