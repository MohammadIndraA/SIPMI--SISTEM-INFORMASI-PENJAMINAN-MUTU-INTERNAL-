<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('Admin');

        // Creating Ketua LPM User
        $Ketua_LPM = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Ketua_LPM->assignRole('Auditor');

        // Creating Ketua Program Studi User
        $Ketua_Program_Studi = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Ketua_Program_Studi->assignRole('Kaprodi');

    }
}
