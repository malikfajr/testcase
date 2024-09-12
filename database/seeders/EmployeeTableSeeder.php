<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $positions = Position::all();

        if ($positions->isEmpty()) {
            $this->command->info('Please seed the positions table first!');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'picture' => $faker->imageUrl(640, 480, 'people', true, 'Faker'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->boolean(),
                'date_of_birth' => $faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
                'hire_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'end_date' => $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                'position_id' => $positions->random()->id,
                'salary' => $faker->randomNumber(8, true),
                'status' => $faker->boolean(),
            ];

            $employee = new Employee($data);
            $employee->address = $faker->address();
            $employee->save();
        }
    }
}
