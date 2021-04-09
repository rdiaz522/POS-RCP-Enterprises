<?php

use App\Stocks;
use Illuminate\Database\Seeder;
class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 500; $i++){
            Stocks::create([
                'id' => $i,
                'quantity' => 100
            ]);
        }
    }
}
