<?php

use Faker\Generator as Faker;

$factory->define(App\Table::class, function (Faker $faker) {
    $branches = ['ANU', 'CMB', 'GAL', 'KOH', 'KOL', 'TRI'];
    $random = rand(0,5);
    return [
        'table_id' => $faker->unique()->numerify('###'),
        'branch_id' => $branches[$random],
        'status' => 'available'
    ];
});
