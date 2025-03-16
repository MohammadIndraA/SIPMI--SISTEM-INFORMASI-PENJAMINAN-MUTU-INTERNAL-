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
          // Creating Super Admin User
          $superAdmin = User::create([
            'name' => 'Super Admin', 
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password')
        ]);
        $superAdmin->assignRole('Super Admin');

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
        $Ketua_LPM->assignRole('Ketua LPM');

        // Creating Ketua Program Studi User
        $Ketua_Program_Studi = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Ketua_Program_Studi->assignRole('Ketua Program Studi');

        // Creating Mahasiswa User
        $Mahasiswa = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Mahasiswa->assignRole('Mahasiswa');

        // Creating Alumni User
        $Alumni = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Alumni->assignRole('Alumni');

        // Creating Dosen User
        $Dosen = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
        $Dosen->assignRole('Dosen');

        // Creating UPPS User
        $UPPS = User::create([
            'name' => fake()->name(), 
            'email' => fake()->email(),
            'password' => Hash::make('password')
        ]);
    }
}
