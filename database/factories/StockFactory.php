<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Stocks;
use Faker\Generator as Faker;

$factory->define(Stocks::class, function (Faker $faker) {
    return [
        'id' => $faker->unique(true)->numberBetween(1, 200),
        'quantity' => $faker->numberBetween(1000, 9000),
    ];
});
