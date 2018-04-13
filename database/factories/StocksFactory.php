<?php

use Faker\Generator as Faker;

$factory->define(App\Stock::class, function (Faker $faker) {
    $branches = ['ANU', 'CMB', 'GAL', 'KOH', 'KOL', 'TRI'];
    $units = ['l', 'kg', 'nos'];
    //randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL)
    $random = rand(0,5);
    return [
        'stock_id' => $faker->unique()->numerify('###'),
        'qty' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 100),
        'branch_id' => $branches[$random],
        'units' => $units[rand(0,2)],
        'minimum_level' => $faker->randomFloat($nbMaxDecimals = 0, $min = 0, $max = 60),
        'name' => ucwords($faker->word)
    ];
});
