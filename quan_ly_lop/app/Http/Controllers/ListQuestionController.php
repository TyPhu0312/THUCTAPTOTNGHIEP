<?php

namespace App\Http\Controllers;

use App\Models\ListQuestion;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListQuestionController extends Controller
{
    // Lấy danh sách câu hỏi của một môn học cụ thể
    public function index()
    {
        $courses = Course::all();
        return view('lecturerViews.question_bank', compact('courses'));
    }

    // Lấy thông tin chi tiết một danh sách câu hỏi
    public function show($id)
    {
        $listQuestion = ListQuestion::with(['course', 'questions.options'])->find($id);

        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        return view('list_questions.show', compact('listQuestion'));
    }



    // Tạo danh sách câu hỏi mới, nếu chưa tồn tại
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);

        $listQuestion = ListQuestion::create($validatedData);
        return response()->json(['message' => 'Tạo danh sách câu hỏi thành công!', 'data' => $listQuestion], Response::HTTP_CREATED);
    }
     /**
     * Phương thức đặc biệt để tạo ListQuestion từ frontend web
     * Chủ yếu để xử lý CSRF token và phản hồi JSON nhất quán
     */
    public function storeFromWeb(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);

        $listQuestion = ListQuestion::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Tạo danh sách câu hỏi thành công!',
            'id' => $listQuestion->list_question_id
        ], Response::HTTP_CREATED);
    }
    // Cập nhật danh sách câu hỏi
    public function update(Request $request, $id)
    {
        $listQuestion = ListQuestion::find($id);
        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);

        $listQuestion->update($validatedData);
        return response()->json(['message' => 'Cập nhật danh sách câu hỏi thành công!', 'data' => $listQuestion], Response::HTTP_OK);
    }

    // Xóa danh sách câu hỏi
    public function destroy($id)
    {
        $listQuestion = ListQuestion::find($id);
        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $listQuestion->delete();
        return response()->json(['message' => 'Danh sách câu hỏi đã được xóa thành công!'], Response::HTTP_OK);
    }
}
