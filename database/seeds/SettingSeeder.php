<?php

use App\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create(['computer_name' => 'TEST', 'printer' => 'TEST', 'fullpaths' => 'TEST']);
    }
}
