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
        //$this->call(CiudadesTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        //$this->call(AvisosTableSeeder::class);
    }
}
