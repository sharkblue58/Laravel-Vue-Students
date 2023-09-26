<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Mohamed Essam',
            'course' => 'Computer Science',
            'email' =>'zoroloffy90@gmail.com',
            'phone'=>'01201278222',          
        ]);
    }
}
