<?php

namespace App\Http\Controllers;

use App\Models\ListQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListQuestionController extends Controller
{
    // Lấy danh sách tất cả ListQuestion
    public function index()
    {
        return response()->json(ListQuestion::all());
    }

    // Lấy thông tin chi tiết một ListQuestion
    public function show($id)
    {
        $listQuestion = ListQuestion::find($id);
        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($listQuestion);
    }

    // Tạo mới một ListQuestion
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);

        $listQuestion = ListQuestion::create($validatedData);

        return response()->json($listQuestion, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin ListQuestion
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

        return response()->json($listQuestion);
    }

    // Xóa một ListQuestion
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
