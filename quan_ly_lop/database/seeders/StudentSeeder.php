<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'student_code' => 'DH52111056',
            'full_name' => 'Nguyễn Diễm Huỳnh',
            'school_email' => 'DH52111056@student.stu.edu.vn',
            'phone' => '0123456789',
            'password' => Hash::make('123456'),
        ]);

        Student::create([
            'student_code' => 'DH51800002',
            'full_name' => 'Trần Thị B',
            'school_email' => 'DH51800002@student.stu.edu.vn',
            'phone' => '0987654321',
            'password' => Hash::make('123456'),
        ]);
    }
} 