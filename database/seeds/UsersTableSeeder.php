<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Auth\Rol;

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

        $user = App\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10)
        ]);
        $user->save();
        $user->roles()->attach($role);

        /*
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10)
        ]);
        */
    }
}
