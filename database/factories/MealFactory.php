<?php

use Faker\Generator as Faker;

$factory->define(App\Meal::class, function (Faker $faker) {
    $branches = ['ANU', 'CMB', 'GAL', 'KOH', 'KOL', 'TRI'];
    $random = rand(0,5);
    return [
        'meal_id' => $faker->unique()->numerify('###'),
        'unit_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'branch_id' => $branches[$random],
        'status' => 'available',
        'name' => $faker->words($nb = 4, $asText = true) 
    ];
});
