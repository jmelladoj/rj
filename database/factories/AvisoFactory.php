<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aviso;
use Faker\Generator as Faker;

$factory->define(Aviso::class, function (Faker $faker) {
    return [
        //
        'titulo' => $faker->name,
        'contenido' => $faker->text(1000),
        'user_id' => $faker->numberBetween(3,100)
    ];
});