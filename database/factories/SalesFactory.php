<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Sales;
use Faker\Generator as Faker;

$factory->define(Sales::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'unit' => $faker->name,
        'price' => $faker->randomDigit,
        'quantity' => $faker->randomDigit,
        'subtotal' => $faker->randomDigit,
        'created_at' => '2019-04-21 09:13:55',
        'updated_at' => '2019-04-21 09:13:55'
    ];
});
