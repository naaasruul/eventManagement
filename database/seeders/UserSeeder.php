<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'email' => 'admin@example.com',
            'name'=> 'Admin User',
            'password' => Hash::make('password'), // Use Hash::make() to hash the password
            'role' => 'admin',
        ]);

        //   Generate 50 organizers using the factory
          User::factory()->count(3)->create();
    }
}
