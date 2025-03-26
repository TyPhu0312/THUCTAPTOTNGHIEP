<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    // Lấy danh sách tất cả câu hỏi
    public function index()
    {
        return response()->json(Question::all());
    }

    // Lấy thông tin chi tiết một câu hỏi
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($question);
    }

    // Tạo mới một câu hỏi
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'list_question_id' => 'required|string|exists:list_question,list_question_id',
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|string|in:Trắc nghiệm,Tự luận',
            'correct_answer' => 'nullable|string',
        ]);

        $question = Question::create($validatedData);

        return response()->json($question, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin câu hỏi
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'list_question_id' => 'required|string|exists:list_question,list_question_id',
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|string|in:Trắc nghiệm,Tự luận',
            'correct_answer' => 'nullable|string',
        ]);

        $question->update($validatedData);

        return response()->json($question);
    }

    // Xóa một câu hỏi
    public function destroy($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $question->delete();

        return response()->json(['message' => 'Câu hỏi đã được xóa thành công!'], Response::HTTP_OK);
    }
}
