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
        'profit' => $faker->randomDigit,
        'quantity' => $faker->randomDigit,
        'subtotal' => $faker->randomDigit,
        'cashier' => 'Cashier101',
        'barcode' => $faker->ean13,
        'vatable' => 'N',
        'created_at' => '2021-01-10 09:13:55',
        'updated_at' => '2021-01-10 09:13:55'
    ];
});
