<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Admin',
            'NIM' => '221220087',
            'major' => 'Informatics Engineering',
            'email' => '221220087@gmail.com',
            'password' => Hash::make('password'),
            'enrollment_year' => '2020-01-01',
        ]);
    }
}
