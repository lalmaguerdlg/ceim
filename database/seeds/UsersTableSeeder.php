<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Auth\Rol;
use App\Imagen;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class, 1)->create();
        $role = Rol::where('rol', 'admin')->first();
        
        $default_image = Imagen::where('tag', 'default')->first();

        $user = App\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'avatar_id' => $default_image->id
        ]);
        $user->save();
        $user->roles()->attach($role);

        $alumno_role = Rol::where('rol', 'alumno')->first();
        $user = App\User::create([
            'name' => 'alumno',
            'email' => 'alumno@alumno.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'avatar_id' => $default_image->id
        ]);
        $user->save();
        $user->roles()->attach($alumno_role);
    }
}
