<?php

namespace App\Http\Controllers;

use App\Models\Options;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptionsController extends Controller
{
    // Lấy tất cả các lựa chọn của một câu hỏi
    public function index($questionId)
    {
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        // Trả về tất cả các lựa chọn (options) của câu hỏi
        return response()->json($question->options);
    }

    // Lấy thông tin chi tiết một lựa chọn
    public function show($id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($option);
    }

    // Tạo mới các lựa chọn cho câu hỏi
    public function store(Request $request, $questionId)
    {
        // Kiểm tra sự tồn tại của câu hỏi
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
            'option_order' => 'nullable|integer',
        ]);

        // Thêm lựa chọn mới cho câu hỏi
        $option = $question->options()->create($validatedData);

        return response()->json($option, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin một lựa chọn
    public function update(Request $request, $id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
            'option_order' => 'nullable|integer',
        ]);

        // Cập nhật thông tin lựa chọn
        $option->update($validatedData);

        return response()->json($option);
    }

    // Xóa một lựa chọn
    public function destroy($id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }

        // Xóa lựa chọn
        $option->delete();

        return response()->json(['message' => 'Lựa chọn đã được xóa thành công!'], Response::HTTP_OK);
    }
}
