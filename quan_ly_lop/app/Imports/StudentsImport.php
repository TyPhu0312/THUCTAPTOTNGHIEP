<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // Kiểm tra xem student_code đã tồn tại hay chưa
        $existingStudent = Student::where('student_code', $row[0])->first();

        if ($existingStudent) {
            return null; // Nếu đã tồn tại, bỏ qua không thêm mới
        }

        return new Student([
            'student_code' => $row[0], // Tương ứng với tên cột trong file Excel
            'full_name' => $row[1],
            'school_email' => $row[2],
            'password' =>  Hash::make($row[0]),
            'phone' => $row[3],
            // Thêm các trường khác nếu cần
        ]);
    }
}
