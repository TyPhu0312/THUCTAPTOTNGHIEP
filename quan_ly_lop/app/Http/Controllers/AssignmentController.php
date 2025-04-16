<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    /**
     * Lấy danh sách tất cả bài tập
     */
    public function index()
    {
        $assignments = Assignment::with('classes')->get();
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Lấy chi tiết một bài tập
     */
    public function show($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Bài tập không tồn tại!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($assignment, Response::HTTP_OK);
    }

    /**
     * Hiển thị form tạo mới bài tập
     */
    public function create()
    {
        $classes = ClassModel::all();
        return view('assignments.form', compact('classes'));
    }

    /**
     * Thêm mới một bài tập
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào từ request với các quy tắc sau:
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Tiêu đề: bắt buộc, là chuỗi, tối đa 255 ký tự
            'description' => 'required|string', // Mô tả: bắt buộc, là chuỗi
            'type' => 'required|in:assignment,exam', // Loại: bắt buộc, chỉ được là 'assignment' hoặc 'exam'
            'start_time' => 'nullable|date', // Thời gian bắt đầu: có thể null, phải là định dạng ngày
            'end_time' => 'nullable|date|after:start_time', // Thời gian kết thúc: có thể null, phải là ngày và sau start_time
            'is_simultaneous' => 'boolean', // Làm đồng thời: kiểu boolean
            'class_ids' => 'required|array', // Danh sách lớp: bắt buộc, phải là mảng
            'class_ids.*' => 'exists:classes,id' // Mỗi ID lớp trong mảng phải tồn tại trong bảng classes
        ]);

        $assignment = Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_simultaneous' => $validated['is_simultaneous'] ?? false,
            'created_by' => Auth::id()
        ]);

        $assignment->classes()->attach($validated['class_ids']);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Hiển thị form cập nhật bài tập
     */
    public function edit(Assignment $assignment)
    {
        $classes = ClassModel::all();
        return view('assignments.form', compact('assignment', 'classes'));
    }

    /**
     * Cập nhật một bài tập
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:assignment,exam',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'is_simultaneous' => 'boolean',
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        $assignment->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_simultaneous' => $validated['is_simultaneous'] ?? false
        ]);

        $assignment->classes()->sync($validated['class_ids']);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Xóa một bài tập
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    public function getAllAssignments()
    {
        try {
            $assignments = DB::table('assignment')
                ->select(
                    'assignment_id',
                    'sub_list_id',
                    'title',
                    'content',
                    'type',
                    'isSimultaneous',
                    'start_time',
                    'end_time',
                    'show_result',
                    'status',
                    'created_at'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $assignments,
                'message' => 'Đã lấy danh sách tất cả bài tập thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy dữ liệu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Lấy tất cả bài thi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllExams()
    {
        try {
            $exams = DB::table('exam')
                ->select(
                    'exam_id',
                    'sub_list_id',
                    'title',
                    'content',
                    'type',
                    'isSimultaneous',
                    'start_time',
                    'end_time',
                    'status',
                    'created_at'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $exams,
                'message' => 'Đã lấy danh sách tất cả bài thi thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy dữ liệu',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Lấy chi tiết bài tập kèm các câu hỏi và tùy chọn trả lời
     */
    public function getAssignmentDetail($assignmentId)
    {
        // Tìm thông tin chính của bài tập
        $assignment = DB::table('assignment')
            ->where('assignment_id', $assignmentId)
            ->first();

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài tập'
            ], 404);
        }

        // Lấy danh sách câu hỏi và tùy chọn
        $questions = DB::table('assignment')
            ->select([
                'assignment.assignment_id',
                'assignment.title AS assignment_title',
                'assignment.content AS assignment_content',
                'assignment.type AS assignment_type',
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
            ->join('sub_list', 'assignment.sub_list_id', '=', 'sub_list.sub_list_id')
            ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
            ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
            ->leftJoin('options', 'question.question_id', '=', 'options.question_id')
            ->where('assignment.assignment_id', $assignmentId)
            ->get();

        // Lấy số lượng bài nộp và danh sách bài nộp
        $submissionCount = DB::table('submission')
            ->where('assignment_id', $assignmentId)
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
            ->where('submission.assignment_id', $assignmentId)
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
                'assignment' => $assignment,
                'questions' => $questions,
                'submission_count' => $submissionCount,
                'submissions' => $submissions
            ]
        ]);
    }
}
