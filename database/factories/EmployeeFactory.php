<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    $branches = ['ANU', 'CMB', 'GAL', 'KOH', 'KOL', 'TRI'];
    $jobs = ['StockMgr', 'Cashier'];
    $random = rand(0,5);
    return [
        'employee_id' => $faker->unique()->numerify('EMP-'.$branches[$random].'-###'),
        'name' => $faker->name,
        'password' => bcrypt('123456'),
        'job' => $jobs[rand(0,1)],
        'branch_id' => $branches[$random],
    ];
});
