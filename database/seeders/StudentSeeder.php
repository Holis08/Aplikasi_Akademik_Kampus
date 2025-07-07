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
            'NIM' => '123456789',
            'major' => 'Computer Science',
            'email' => 'admin@ifump.net',
            'password' => Hash::make('password'),
            'enrollment_year' => '2020-01-01',
        ]);
    }
}
