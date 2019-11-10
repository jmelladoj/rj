<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'telefono' => '987654321',
        'usuario' => $faker->unique()->userName,
        'sexo' => $faker->numberBetween(1,3),
        'edad' => $faker->numberBetween(18,50),
        'ciudad_id' => $faker->numberBetween(1,3),
        'nacionalidad' => $faker->country,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'altura' => $faker->randomFloat(1,1,2),
        'busto' => $faker->numberBetween(5,200),
        'cintura' => $faker->numberBetween(5,200),
        'caderas' => $faker->numberBetween(5,200),
        'descripcion' => $faker->text(1000),
        'tipo_usuario' => $faker->numberBetween(2,3),
        'perfil_url'=> $faker->imageUrl(640,480),
        'video_url'=> 'https://www.youtube.com/embed/csx53ZqoQqI',
        'foto_uno_url'=> $faker->imageUrl(640,480),
        'foto_dos_url'=> $faker->imageUrl(640,480),
        'foto_tres_url'=> $faker->imageUrl(640,480),
        'foto_cuatro_url'=> $faker->imageUrl(640,480),
        'foto_cinco_url'=> $faker->imageUrl(640,480),
        'foto_seis_url'=> $faker->imageUrl(640,480),
        'foto_siete_url'=> $faker->imageUrl(640,480),
        'foto_ocho_url'=> $faker->imageUrl(640,480),
        'foto_nueve_url'=> $faker->imageUrl(640,480),
        'foto_diez_url'=> $faker->imageUrl(640,480),
        'foto_once_url'=> $faker->imageUrl(640,480),
        'foto_doce_url'=> $faker->imageUrl(640,480),
        'agencia'=> $faker->numberBetween(0,1),
        'visible'=> 1
    ];
});

