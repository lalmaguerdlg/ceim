<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scopes')->delete();

        $scopes = [];
        $config_scopes = config('permissions.scopes', []);
        foreach ($config_scopes as $scope => $description) {
            $scopes[] = [ 'scope' => $scope, 'descripcion' => $description];
        }

        DB::table('scopes')->insert($scopes);

        $scopes = \App\Auth\Scope::all();
        $admin = \App\Auth\Rol::where('rol', 'admin')->first();
        $admin->scopes()->detach();
        $admin->scopes()->attach($scopes);
    }
}
