<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    /**
     * Lấy danh sách tất cả khóa học
     */
    public function index(Request $request)
    {
        $courses = Course::all();

        // Nếu là request API, trả về JSON
        if ($request->wantsJson()) {
            return response()->json($courses, Response::HTTP_OK);
        }

        // Nếu là request từ trình duyệt, trả về view
        return view('lecturerViews.question_bank', compact('courses'));
    }

    /**
     * Lấy chi tiết một khóa học
     */
    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Khóa học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($course, Response::HTTP_OK);
    }

    /**
     * Thêm mới một khóa học
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_name'    => 'required|string|max:255|unique:courses,course_name',
            'process_ratio'  => 'required|numeric|min:0|max:100',
            'midterm_ratio'  => 'required|numeric|min:0|max:100',
            'final_ratio'    => 'required|numeric|min:0|max:100',
        ]);

        // Kiểm tra tổng tỷ lệ có bằng 100 không
        if (($validatedData['process_ratio'] + $validatedData['midterm_ratio'] + $validatedData['final_ratio']) !== 100) {
            return response()->json(['message' => 'Tổng tỷ lệ phải bằng 100%!'], Response::HTTP_BAD_REQUEST);
        }

        $course = Course::create($validatedData);
        return response()->json(['message' => 'Thêm khóa học thành công!', 'data' => $course], Response::HTTP_CREATED);
    }

    /**
     * Cập nhật thông tin khóa học
     */
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Khóa học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'course_name'    => 'string|max:255|unique:courses,course_name,' . $id . ',course_id',
            'process_ratio'  => 'numeric|min:0|max:100',
            'midterm_ratio'  => 'numeric|min:0|max:100',
            'final_ratio'    => 'numeric|min:0|max:100',
        ]);

        // Kiểm tra tổng tỷ lệ có bằng 100 không (chỉ kiểm tra nếu có cập nhật tỷ lệ)
        if (
            isset($validatedData['process_ratio']) ||
            isset($validatedData['midterm_ratio']) ||
            isset($validatedData['final_ratio'])
        ) {
            $new_process = $validatedData['process_ratio'] ?? $course->process_ratio;
            $new_midterm = $validatedData['midterm_ratio'] ?? $course->midterm_ratio;
            $new_final   = $validatedData['final_ratio'] ?? $course->final_ratio;

            if (($new_process + $new_midterm + $new_final) !== 100) {
                return response()->json(['message' => 'Tổng tỷ lệ phải bằng 100%!'], Response::HTTP_BAD_REQUEST);
            }
        }

        $course->update($validatedData);
        return response()->json(['message' => 'Cập nhật khóa học thành công!', 'data' => $course], Response::HTTP_OK);
    }

    /**
     * Xóa một khóa học
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Khóa học không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $course->delete();
        return response()->json(['message' => 'Xóa khóa học thành công!'], Response::HTTP_OK);
    }
}
