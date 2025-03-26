<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Lấy danh sách tất cả câu trả lời
     */
    public function index()
    {
        return response()->json(Answer::all());
    }

    /**
     * Lấy chi tiết một câu trả lời
     */
    public function show($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return response()->json(['message' => 'Câu trả lời không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($answer, Response::HTTP_OK);
    }

    /**
     * Thêm mới một câu trả lời
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'submission_id'     => 'required|exists:submission,submission_id',
            'question_title'    => 'required|string',
            'question_content'  => 'required|string',
            'question_answer'   => 'required|string',
        ]);

        $answer = Answer::create($validatedData);
        return response()->json(['message' => 'Thêm câu trả lời thành công!', 'data' => $answer], Response::HTTP_CREATED);
    }

    /**
     * Cập nhật một câu trả lời
     */
    public function update(Request $request, $id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return response()->json(['message' => 'Câu trả lời không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'question_title'    => 'string',
            'question_content'  => 'string',
            'question_answer'   => 'string',
        ]);

        $answer->update($validatedData);
        return response()->json(['message' => 'Cập nhật câu trả lời thành công!', 'data' => $answer], Response::HTTP_OK);
    }

    /**
     * Xóa một câu trả lời
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return response()->json(['message' => 'Câu trả lời không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $answer->delete();
        return response()->json(['message' => 'Xóa câu trả lời thành công!'], Response::HTTP_OK);
    }
}
