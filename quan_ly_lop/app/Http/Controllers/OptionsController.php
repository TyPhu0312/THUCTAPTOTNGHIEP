<?php

namespace App\Http\Controllers;

use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptionsController extends Controller
{
    // Lấy danh sách tất cả Options
    public function index()
    {
        return response()->json(Options::all());
    }

    // Lấy thông tin chi tiết một Option
    public function show($id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($option);
    }

    // Tạo mới một Option
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_id' => 'required|string|exists:questions,question_id',
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
            'option_order' => 'nullable|integer',
        ]);

        $option = Options::create($validatedData);

        return response()->json($option, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin Option
    public function update(Request $request, $id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'question_id' => 'required|string|exists:questions,question_id',
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
            'option_order' => 'nullable|integer',
        ]);

        $option->update($validatedData);

        return response()->json($option);
    }

    // Xóa một Option
    public function destroy($id)
    {
        $option = Options::find($id);
        if (!$option) {
            return response()->json(['message' => 'Không tìm thấy lựa chọn!'], Response::HTTP_NOT_FOUND);
        }

        $option->delete();

        return response()->json(['message' => 'Lựa chọn đã được xóa thành công!'], Response::HTTP_OK);
    }
}
