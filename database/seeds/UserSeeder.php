<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user');

        $admin = Role::where('name', 'Admin')->first();
        $cashier = Role::where('name', 'Cashier')->first();
        $staff = Role::where('name', 'Staff')->first();

        $adminUser = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        $cashierUser = User::create([
            'username' => 'cashier101',
            'password' => Hash::make('cashier'),
        ]);

        $staffUser = User::create([
            'username' => 'staff',
            'password' => Hash::make('staff'),
        ]);

        $adminUser->roles()->attach($admin);
        $cashierUser->roles()->attach($cashier);
        $staffUser->roles()->attach($staff);
    }
}
