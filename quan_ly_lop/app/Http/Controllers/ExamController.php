<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Exam;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    // 🟢 Lấy tất cả bài thi (trả về mảng rỗng nếu không có dữ liệu)
    public function index()
    {
        return response()->json(Exam::all());
    }

    // 🟢 Lấy chi tiết bài thi theo ID
    public function show($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Bài thi không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($exam);
    }

    // 🟢 Tạo bài thi mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'nullable|string|max:100',
            'type' => 'required|string|in:' . implode(',', Exam::getAllowedTypes()),
            'isSimultaneous' => 'required|integer|in:0,1',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'status' => 'required|string|in:' . implode(',', Exam::getAllowedStatuses()),
        ]);

        $exam = Exam::create([
            'exam_id' => Str::uuid(),
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'isSimultaneous' => $request->isSimultaneous,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Bài thi đã được tạo thành công!',
            'exam' => $exam
        ], 201);
    }



    // 🟢 Cập nhật bài thi
    public function update(Request $request, $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Bài thi không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $exam->update($request->all());

        return response()->json([
            'message' => 'Bài thi đã được cập nhật!',
            'exam' => $exam
        ]);
    }

    // 🟢 Xóa bài thi
    public function destroy($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Bài thi không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $exam->delete();

        return response()->json(['message' => 'Bài thi đã bị xóa!']);
    }
}
