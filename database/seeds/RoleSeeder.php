<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Cashier']);
        Role::create(['name' => 'Staff']);
    }
}
