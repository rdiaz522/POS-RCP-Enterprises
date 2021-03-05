<?php

use App\Sales;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //NOVEMBER 31 2020
        for($i = 1; $i <= 100;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-John',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2020-11-01 09:13:55',
                'updated_at' => '2020-11-01 09:13:55'
            ]);
        }

         //DECEMBER 25 2020
         for($i = 1; $i <= 100;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Jane',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2020-12-01 09:13:55',
                'updated_at' => '2020-12-01 09:13:55'
            ]);
        }

        //JANUARY 01 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Carl',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-01 09:13:55',
                'updated_at' => '2021-01-01 09:13:55'
            ]);
        }

        //JANUARY 25 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Jason',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-25 09:13:55',
                'updated_at' => '2021-01-25 09:13:55'
            ]);
        }

        //JANUARY 26 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Lourds',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-26 09:13:55',
                'updated_at' => '2021-01-26 09:13:55'
            ]);
        }

        //JANUARY 27 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-27 09:13:55',
                'updated_at' => '2021-01-27 09:13:55'
            ]);
        }

        //JANUARY 28 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Gotico',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-28 09:13:55',
                'updated_at' => '2021-01-28 09:13:55'
            ]);
        }

        //JANUARY 29 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Aegis',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-29 09:13:55',
                'updated_at' => '2021-01-29 09:13:55'
            ]);
        }

        //JANUARY 30 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-30 09:13:55',
                'updated_at' => '2021-01-30 09:13:55'
            ]);
        }

        //JANUARY 31 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Jane',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-01-31 09:13:55',
                'updated_at' => '2021-01-31 09:13:55'
            ]);
        }

        //FEBRUARY 06 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Carl',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-06 09:13:55',
                'updated_at' => '2021-02-06 09:13:55'
            ]);
        }

        //FEBRUARY 07 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Jason',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-07 09:13:55',
                'updated_at' => '2021-02-07 09:13:55'
            ]);
        }

        //FEBRUARY 08 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Lourds',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-08 09:13:55',
                'updated_at' => '2021-02-08 09:13:55'
            ]);
        }

        //FEBRUARY 09 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-09 09:13:55',
                'updated_at' => '2021-02-09 09:13:55'
            ]);
        }

        //FEBRUARY 10 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Gotico',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-10 09:13:55',
                'updated_at' => '2021-02-10 09:13:55'
            ]);
        }

        //FEBRUARY 28 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Aegis',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-02-28 09:13:55',
                'updated_at' => '2021-02-28 09:13:55'
            ]);
        }

        //MARCH 01 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-01 09:13:55',
                'updated_at' => '2021-03-01 09:13:55'
            ]);
        }

        //MARCH 02 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-02 09:13:55',
                'updated_at' => '2021-03-02 09:13:55'
            ]);
        }

        //MARCH 03 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-03 09:13:55',
                'updated_at' => '2021-03-03 09:13:55'
            ]);
        }

        //MARCH 04 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-04 09:13:55',
                'updated_at' => '2021-03-04 09:13:55'
            ]);
        }

        //MARCH 05 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-05 09:13:55',
                'updated_at' => '2021-03-05 09:13:55'
            ]);
        }

        //MARCH 06 2020
        for($i = 1; $i <= 20 ;$i++){
            Sales::create([
                'name' => $faker->name,
                'unit' => $faker->creditCardType,
                'price' => $faker->numberBetween(201,1000),
                'profit' => $faker->numberBetween(50,200),
                'quantity' => $faker->numberBetween(1,100),
                'subtotal' => $faker->numberBetween(500,2000),
                'cashier' => 'Cashier-Ron',
                'barcode' => $faker->ean13,
                'vatable' => 'N',
                'created_at' => '2021-03-06 09:13:55',
                'updated_at' => '2021-03-06 09:13:55'
            ]);
        }

    }
}
