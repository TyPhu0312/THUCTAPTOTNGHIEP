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
    public function getExamDetail($examId)
{
    // Tìm thông tin chính của bài kiểm tra
    $exam = DB::table('exam')
        ->where('exam_id', $examId)
        ->first();
    
    if (!$exam) {
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy bài kiểm tra'
        ], 404);
    }
    
    // Lấy danh sách câu hỏi và tùy chọn
    $questions = DB::table('exam')
        ->select([
            'exam.exam_id',
            'exam.title AS exam_title',
            'exam.content AS exam_content',
            'exam.type AS exam_type',
            'question.question_id',
            'question.title AS question_title',
            'question.content AS question_content',
            'question.type AS question_type',
            'question.correct_answer',
            'options.option_id',
            'options.option_text',
            'options.is_correct',
            'options.option_order'
        ])
        ->join('sub_list', 'exam.sub_list_id', '=', 'sub_list.sub_list_id')
        ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
        ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
        ->leftJoin('options', 'question.question_id', '=', 'options.question_id')
        ->where('exam.exam_id', $examId)
        ->get();
    
    // Lấy số lượng bài nộp và danh sách bài nộp
    $submissionCount = DB::table('submission')
        ->where('exam_id', $examId)
        ->count();
    
    $submissions = DB::table('submission')
        ->select([
            'submission.submission_id',
            'submission.student_id',
            'submission.answer_file',
            'submission.created_at',
            'submission.is_late',
            'submission.temporary_score',
            'student.full_name AS student_name',
            'student.student_code'
        ])
        ->join('student', 'submission.student_id', '=', 'student.student_id')
        ->where('submission.exam_id', $examId)
        ->get();
    
    // Lấy câu trả lời cho mỗi bài nộp
    foreach ($submissions as $key => $submission) {
        $answers = DB::table('answer')
            ->where('submission_id', $submission->submission_id)
            ->get();
        
        $submissions[$key]->answers = $answers;
    }
    
    return response()->json([
        'success' => true,
        'data' => [
            'exam' => $exam,
            'questions' => $questions,
            'submission_count' => $submissionCount,
            'submissions' => $submissions
        ]
    ]);
}
}
