<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Lấy danh sách tất cả sinh viên
    public function index()
    {
        return response()->json(Student::all());
    }

    // Lấy thông tin chi tiết một sinh viên
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Không tìm thấy sinh viên!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($student);
    }

    // Tạo mới một sinh viên
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_code' => 'required|string|unique:student,student_code',
            'full_name' => 'required|string',
            'school_email' => 'required|string|email|unique:student,school_email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|unique:student,phone',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $student = Student::create($validatedData);

        return response()->json($student, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin sinh viên
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Không tìm thấy sinh viên!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'student_code' => 'required|string|unique:student,student_code,' . $id . ',student_id',
            'full_name' => 'required|string',
            'school_email' => 'required|string|email|unique:student,school_email,' . $id . ',student_id',
            'password' => 'nullable|string|min:6',
            'phone' => 'required|string|unique:student,phone,' . $id . ',student_id',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $student->update($validatedData);

        return response()->json($student);
    }

    // Xóa một sinh viên
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Không tìm thấy sinh viên!'], Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return response()->json(['message' => 'Sinh viên đã được xóa thành công!'], Response::HTTP_OK);
    }
}
