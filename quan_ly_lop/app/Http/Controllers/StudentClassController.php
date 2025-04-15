<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentClassController extends Controller
{
    // Lấy danh sách tất cả bản ghi
    public function index()
    {
        return response()->json(StudentClass::all());
    }

    // Lấy thông tin chi tiết một bản ghi
    public function show($id)
    {
        $studentClass = StudentClass::find($id);
        if (!$studentClass) {
            return response()->json(['message' => 'Không tìm thấy bản ghi!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($studentClass);
    }

    // Tạo mới một bản ghi
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'class_id' => 'required|string|exists:classroom,class_id',
            'status' => 'required|string|in:Active,Drop,Pending',
            'final_score' => 'nullable|numeric|min:0|max:10',
        ]);

        $studentClass = StudentClass::create($validatedData);

        return response()->json($studentClass, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin bản ghi
    public function update(Request $request, $id)
    {
        $studentClass = StudentClass::find($id);
        if (!$studentClass) {
            return response()->json(['message' => 'Không tìm thấy bản ghi!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'class_id' => 'required|string|exists:classroom,class_id',
            'status' => 'required|string|in:Active,Drop,Pending',
            'final_score' => 'nullable|numeric|min:0|max:10',
        ]);

        $studentClass->update($validatedData);

        return response()->json($studentClass);
    }

    // Xóa một bản ghi
    public function destroy($id)
    {
        $studentClass = StudentClass::find($id);
        if (!$studentClass) {
            return response()->json(['message' => 'Không tìm thấy bản ghi!'], Response::HTTP_NOT_FOUND);
        }

        $studentClass->delete();

        return response()->json(['message' => 'Bản ghi đã được xóa thành công!'], Response::HTTP_OK);
    }
}
