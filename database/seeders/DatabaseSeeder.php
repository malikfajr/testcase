<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '12345678'

        ]);

        $this->call([
            PositionTableSeeder::class,
            EmployeeTableSeeder::class,
            EmployeeTableSeeder::class,
        ]);;
    }
}
