<?php

use App\Ciudad;
use Illuminate\Database\Seeder;

class CiudadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Ciudad::create(['nombre' => 'Concepción']);
        Ciudad::create(['nombre' => 'Chillán']);
        Ciudad::create(['nombre' => 'Los Ángeles']);
    }
}
