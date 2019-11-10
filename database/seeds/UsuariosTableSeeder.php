<?php

use App\User;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(['nombre' => 'Admin', 'usuario' => 'admin@relajandote.cl', 'password' => bcrypt('123456789'), 'tipo_usuario' => 1]);
    
        //factory(User::class, 100)->create();
    }
}
