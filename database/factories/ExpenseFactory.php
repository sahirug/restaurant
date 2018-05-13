<?php

use Faker\Generator as Faker;
use App\Expenses;

$factory->define(App\Expenses::class, function (Faker $faker) {
    $expense = new Expenses();
    $count = $expense->all()->count();
    ++$count;
    $branches = ['ANU', 'CMB', 'GAL', 'KOH', 'KOL', 'TRI'];
    $random = rand(0,5);
    $types = ['pettycash', 'stock resupply', 'water bill', 'electricity bill', 'misc tax'];
    return [
        'expense_id' => 'EXP-'. $branches[$random] . '-' . $faker->unique()->numerify('###'),
        'expense_date' => $faker->dateTimeThisYear($max = 'now'),
        'type' => $types[rand(0,4)],
        'notes' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 10000),
        'branch_id' => $branches[$random],
    ];
});
