<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScoresController extends Controller
{
    // Lấy danh sách điểm số
    public function index()
    {
        return response()->json(Score::all());
    }

    // Lấy thông tin chi tiết một điểm số
    public function show($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($score);
    }

    // Tạo mới một điểm số
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'course_id' => 'required|string|exists:course,course_id',
            'process_score' => 'required|numeric|min:0|max:10',
            'midterm_score' => 'required|numeric|min:0|max:10',
            'final_score' => 'required|numeric|min:0|max:10',
            'average_score' => 'nullable|numeric|min:0|max:10',
        ]);

        // Tính điểm trung bình nếu chưa có
        if (!isset($validatedData['average_score'])) {
            $validatedData['average_score'] = (
                $validatedData['process_score'] * 0.3 +
                $validatedData['midterm_score'] * 0.3 +
                $validatedData['final_score'] * 0.4
            );
        }

        $score = Score::create($validatedData);

        return response()->json($score, Response::HTTP_CREATED);
    }

    // Cập nhật điểm số
    public function update(Request $request, $id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'course_id' => 'required|string|exists:course,course_id',
            'process_score' => 'required|numeric|min:0|max:10',
            'midterm_score' => 'required|numeric|min:0|max:10',
            'final_score' => 'required|numeric|min:0|max:10',
            'average_score' => 'nullable|numeric|min:0|max:10',
        ]);

        // Tính lại điểm trung bình nếu cần
        if (!isset($validatedData['average_score'])) {
            $validatedData['average_score'] = (
                $validatedData['process_score'] * 0.3 +
                $validatedData['midterm_score'] * 0.3 +
                $validatedData['final_score'] * 0.4
            );
        }

        $score->update($validatedData);

        return response()->json($score);
    }

    // Xóa điểm số
    public function destroy($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }

        $score->delete();

        return response()->json(['message' => 'Điểm số đã được xóa thành công!'], Response::HTTP_OK);
    }
}
