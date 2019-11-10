<?php

use App\Aviso;
use Illuminate\Database\Seeder;

class AvisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Aviso::class, 50)->create();
    }
}
