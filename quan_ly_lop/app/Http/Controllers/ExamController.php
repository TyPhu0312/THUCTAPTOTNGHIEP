<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Exam;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ExamController extends Controller
{
    public function index()
    {
        return view('todopage');
    }
    public function show($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Bài thi không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($exam);
    }
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



    //  Cập nhật bài thi
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

    //  Xóa bài thi
    public function destroy($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['message' => 'Bài thi không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $exam->delete();

        return response()->json(['message' => 'Bài thi đã bị xóa!']);
    }

    /**
     * Lấy chi tiết bài kiểm tra kèm số lượng sinh viên đã nộp bài
     */
    public function getExamDetail($examId)
    {
        // Tìm bài kiểm tra theo ID
        $exam = Exam::with([
            'subList.subListQuestions.question.options',
        ])->findOrFail($examId);

        // Đếm số lượng bài nộp
        $submissionCount = Submission::where('exam_id', $examId)->count();

        // Lấy danh sách bài nộp kèm thông tin sinh viên và câu trả lời
        $submissions = Submission::with('student', 'answers')
            ->where('exam_id', $examId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'exam' => $exam,
                'submission_count' => $submissionCount,
                'submissions' => $submissions
            ]
        ]);
    }
}
