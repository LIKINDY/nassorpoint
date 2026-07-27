<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $superAdminRole = \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);
        $ownerRole = \Spatie\Permission\Models\Role::create(['name' => 'Restaurant Owner']);
        $cashierRole = \Spatie\Permission\Models\Role::create(['name' => 'Cashier']);

        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Likindy Ismail',
            'email' => 'likindyinfor@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('furaha26'),
        ]);

        $superAdmin->assignRole($superAdminRole);
    }
}
