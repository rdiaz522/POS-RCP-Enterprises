<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'contact_no' => $faker->e164PhoneNumber,
        'discount' => '20'
    ];
});
