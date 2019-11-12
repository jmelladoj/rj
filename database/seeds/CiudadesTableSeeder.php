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

        Ciudad::create(['nombre' => 'Antofagasta']);
        Ciudad::create(['nombre' => 'Calama']);
        Ciudad::create(['nombre' => 'Chiloé']);
        Ciudad::create(['nombre' => 'Copiapo']);
        Ciudad::create(['nombre' => 'Curico']);
        Ciudad::create(['nombre' => 'Iquique']);
        Ciudad::create(['nombre' => 'La Serena']);
        Ciudad::create(['nombre' => 'Las Condes']);
        Ciudad::create(['nombre' => 'Ñuñoa']);
        Ciudad::create(['nombre' => 'Osorno']);

        Ciudad::create(['nombre' => 'Providencia']);
        Ciudad::create(['nombre' => 'Puerto Montt']);
        Ciudad::create(['nombre' => 'Rancagua']);
        Ciudad::create(['nombre' => 'Santiago']);
        Ciudad::create(['nombre' => 'Talca']);
        Ciudad::create(['nombre' => 'Temuco']);
        Ciudad::create(['nombre' => 'Valdivia']);
        Ciudad::create(['nombre' => 'Valparaíso']);
        Ciudad::create(['nombre' => 'Viña del mar']);
    }
}
