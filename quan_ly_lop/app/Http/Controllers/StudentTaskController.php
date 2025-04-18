<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Assignment;

class StudentTaskController extends Controller
{
    public function getAllStudentTasks($studentId)
    {
        // 1. Lấy danh sách course_id từ lớp học của sinh viên
        $courseIds = DB::table('student_class')
            ->join('classroom', 'student_class.class_id', '=', 'classroom.class_id')
            ->where('student_class.student_id', $studentId)
            ->pluck('classroom.course_id');

        // 2. Lấy list_question_id từ course_id
        $listQuestionIds = DB::table('list_question')
            ->whereIn('course_id', $courseIds)
            ->pluck('list_question_id');

        // 3. Lấy question_id từ list_question
        $questionIds = DB::table('question')
            ->whereIn('list_question_id', $listQuestionIds)
            ->pluck('question_id');

        // 4. Lấy sub_list_id từ bảng sub_list_question
        $subListIds = DB::table('sub_list_question')
            ->whereIn('question_id', $questionIds)
            ->pluck('sub_list_id');

        // 5. Lấy bài kiểm tra (exam)
        $exams = DB::table('exam')
            ->join('sub_list','exam.sub_list_id','=','sub_list.sub_list_id')
            ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
            ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
            ->join('list_question', 'question.list_question_id', '=', 'list_question.list_question_id')
            ->join('course', 'list_question.course_id', '=', 'course.course_id')
            ->whereIn('exam.sub_list_id', $subListIds)
            ->select(
                'exam_id',
                'exam.sub_list_id as exam_sub_list_id',
                'exam.title',
                'exam.content',
                'exam.type',
                'exam.isSimultaneous',
                'exam.start_time',
                'exam.end_time',
                'exam.status',
                'course.course_name as course_name'
            )
            ->distinct()
            ->get();

        // 6. Lấy bài tập (assignment)
        $assignments = DB::table('assignment')
            ->join('sub_list','assignment.sub_list_id','=','sub_list.sub_list_id')
            ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
            ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
            ->join('list_question', 'question.list_question_id', '=', 'list_question.list_question_id')
            ->join('course', 'list_question.course_id', '=', 'course.course_id')
            ->whereIn('assignment.sub_list_id', $subListIds)
            ->select(
                'assignment.assignment_id',
                'assignment.sub_list_id as assignment_sub_list_id', // Alias cho sub_list_id
                'assignment.title',
                'assignment.content',
                'assignment.type',
                'assignment.isSimultaneous',
                'assignment.start_time',
                'assignment.end_time',
                'assignment.show_result',
                'assignment.status',
                'course.course_name as course_name'
            )
            ->distinct()
            ->get();

        return response()->json([
            'exams' => $exams,
            'assignments' => $assignments
        ]);
    }

    public function getAllStudentTasksOfCourse($studentId,$courseId)
    {
        // 1. Kiểm tra sinh viên có học lớp của môn học đó không
        $isEnrolled = DB::table('student_class')
        ->join('classroom', 'student_class.class_id', '=', 'classroom.class_id')
        ->where('student_class.student_id', $studentId)
        ->where('classroom.course_id', $courseId)
        ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'message' => 'Sinh viên không học môn học này.'
            ], 403);
        }

        // 2. Lấy list_question_id của môn học đó
        $listQuestionIds = DB::table('list_question')
        ->where('course_id', $courseId)
        ->pluck('list_question_id');

        // 3. Lấy question_id từ list_question
        $questionIds = DB::table('question')
            ->whereIn('list_question_id', $listQuestionIds)
            ->pluck('question_id');

        // 4. Lấy sub_list_id từ bảng sub_list_question
        $subListIds = DB::table('sub_list_question')
            ->whereIn('question_id', $questionIds)
            ->pluck('sub_list_id');

        // 5. Lấy bài kiểm tra (exam)
        $exams = DB::table('exam')
            ->join('sub_list','exam.sub_list_id','=','sub_list.sub_list_id')
            ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
            ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
            ->join('list_question', 'question.list_question_id', '=', 'list_question.list_question_id')
            ->join('course', 'list_question.course_id', '=', 'course.course_id')
            ->whereIn('exam.sub_list_id', $subListIds)
            ->select(
                'exam.exam_id',
                'exam.sub_list_id as exam_sub_list_id',
                'exam.title',
                'exam.content',
                'exam.type',
                'exam.isSimultaneous',
                'exam.start_time',
                'exam.end_time',
                'exam.status',
                'course.course_name as course_name'
            )
            ->distinct()
            ->get();

        // 6. Lấy bài tập (assignment)
        $assignments = DB::table('assignment')
            ->join('sub_list','assignment.sub_list_id','=','sub_list.sub_list_id')
            ->join('sub_list_question', 'sub_list.sub_list_id', '=', 'sub_list_question.sub_list_id')
            ->join('question', 'sub_list_question.question_id', '=', 'question.question_id')
            ->join('list_question', 'question.list_question_id', '=', 'list_question.list_question_id')
            ->join('course', 'list_question.course_id', '=', 'course.course_id')
            ->whereIn('assignment.sub_list_id', $subListIds)
            ->select(
                'assignment.assignment_id',
                'assignment.sub_list_id as assignment_sub_list_id',
                'assignment.title',
                'assignment.content',
                'assignment.type',
                'assignment.isSimultaneous',
                'assignment.start_time',
                'assignment.end_time',
                'assignment.show_result',
                'assignment.status',
                'course.course_name as course_name'
            )
            ->distinct()
            ->get();

        return response()->json([
            'exams' => $exams,
            'assignments' => $assignments
        ]);
    }
    public function redirectToProperPage(Request $request)
{
    $id = $request->query('id');

    $task = Exam::where('exam_id', $id)->first()
        ?? Assignment::where('assignment_id', $id)->first();

    if (!$task) {
        return abort(404, 'Không tìm thấy bài thi hoặc bài tập');
    }

    if ($task->type === 'Tự luận') {
        return redirect()->route('essay.page', ['id' => $id]);
    }

    if ($task->type === 'Trắc nghiệm') {
        return redirect()->route('quiz.page', ['id' => $id]);
    }

    return abort(400, 'Loại bài không hợp lệ');
}
}
