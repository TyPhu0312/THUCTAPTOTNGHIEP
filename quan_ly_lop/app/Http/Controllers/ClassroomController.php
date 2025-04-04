<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassroomController extends Controller
{
    /**
     * Lấy danh sách tất cả lớp học
     */
    public function index()
    {
        return response()->json(Classroom::all(), Response::HTTP_OK);
    }

    /**
     * Lấy chi tiết một lớp học
     */
    public function show($id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json(['message' => 'Lớp học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($classroom, Response::HTTP_OK);
    }

    /**
     * Thêm mới một lớp học
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id'         => 'required|exists:course,course_id',
            'lecturer_id'       => 'required|exists:lecturer,lecturer_id',
            'class_code'        => 'required|string|max:50|unique:classroom,class_code',
            'class_description' => 'nullable|string',
            'class_duration'    => 'required|integer|min:1',
        ]);

        $classroom = Classroom::create($validatedData);
        return response()->json(['message' => 'Thêm lớp học thành công!', 'data' => $classroom], Response::HTTP_CREATED);
    }

    /**
     * Cập nhật thông tin lớp học
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json(['message' => 'Lớp học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'course_id'         => 'exists:course,course_id',
            'lecturer_id'       => 'exists:lecturer,lecturer_id',
            'class_code'        => 'string|max:50|unique:classroom,class_code,' . $id . ',class_id',
            'class_description' => 'nullable|string',
            'class_duration'    => 'integer|min:1',
        ]);

        $classroom->update($validatedData);
        return response()->json(['message' => 'Cập nhật lớp học thành công!', 'data' => $classroom], Response::HTTP_OK);
    }

    /**
     * Xóa một lớp học
     */
    public function destroy($id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json(['message' => 'Lớp học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $classroom->delete();
        return response()->json(['message' => 'Xóa lớp học thành công!'], Response::HTTP_OK);
    }
}
