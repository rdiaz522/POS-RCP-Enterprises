<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'barcode' => $faker->ean13,
        'name' => $faker->name,
        'brand' => $faker->lastName,
        'net_wt' => '100ml',
        'unit' => 'bottle',
        'price' => $faker->numberBetween(1000.00, 9000.00),
        'profit' => $faker->numberBetween(1000.00, 9000.00),
        'status' => 'N',
        'category_id' => $faker->unique(true)->numberBetween(1, 200),
        'supplier_id' => $faker->unique(true)->numberBetween(1, 200)
    ];
});
