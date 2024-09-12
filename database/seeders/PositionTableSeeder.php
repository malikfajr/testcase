<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['title' => 'Manager', 'description' => 'Manages the team'],
            ['title' => 'Developer', 'description' => 'Develops software'],
            ['title' => 'Designer', 'description' => 'Designs products'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
