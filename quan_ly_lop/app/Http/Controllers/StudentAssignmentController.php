<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Exam;
use App\Models\Submission;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentAssignmentController extends Controller
{
    // Xem danh sách bài tập
    public function listAssignments()
    {
        $studentId = Auth::id() ?? 'STD001';

        $assignments = Assignment::whereHas('course.classroom.studentClasses', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
        ->get()
        ->map(function ($assignment) {
            return [
                'id' => $assignment->assignment_id,
                'title' => $assignment->title,
                'content' => $assignment->content,
                'type' => $assignment->type,
                'start_time' => $assignment->start_time,
                'end_time' => $assignment->end_time,
                'status' => $this->getAssignmentStatus($assignment)
            ];
        });

        return response()->json($assignments);
    }

    // Xem danh sách bài thi
    public function listExams()
    {
        $studentId = Auth::id() ?? 'STD001';

        $exams = Exam::whereHas('course.classroom.studentClasses', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
        ->get()
        ->map(function ($exam) {
            return [
                'id' => $exam->exam_id,
                'title' => $exam->title,
                'content' => $exam->content,
                'type' => $exam->type,
                'start_time' => $exam->start_time,
                'end_time' => $exam->end_time,
                'status' => $this->getExamStatus($exam)
            ];
        });

        return response()->json($exams);
    }

    // Làm bài tập
    public function doAssignment(Request $request, $assignmentId)
    {
        $studentId = Auth::id() ?? 'STD001';
        $assignment = Assignment::findOrFail($assignmentId);

        if (!$this->isWithinTimeLimit($assignment->start_time, $assignment->end_time)) {
            return response()->json(['message' => 'Đã quá hạn làm bài'], 400);
        }

        $request->validate([
            'answer' => 'required|file|max:10240'
        ]);

        $submission = Submission::create([
            'submission_id' => (string) Str::uuid(),
            'student_id' => $studentId,
            'assignment_id' => $assignmentId,
            'answer_file' => $request->file('answer')->store('assignments'),
            'is_late' => now() > $assignment->end_time
        ]);

        return response()->json([
            'message' => 'Nộp bài thành công',
            'submission_id' => $submission->submission_id
        ]);
    }

    // Hàm hỗ trợ - Kiểm tra thời gian làm bài
    private function isWithinTimeLimit($startTime, $endTime)
    {
        $now = now();
        return $now >= $startTime && $now <= $endTime;
    }

    // Hàm hỗ trợ - Lấy trạng thái bài tập
    private function getAssignmentStatus($assignment)
    {
        $now = now();
        if ($now < $assignment->start_time) return 'Chưa bắt đầu';
        if ($now > $assignment->end_time) return 'Đã quá hạn';
        return 'Đang diễn ra';
    }

    // Hàm hỗ trợ - Lấy trạng thái bài thi
    private function getExamStatus($exam)
    {
        $now = now();
        if ($now < $exam->start_time) return 'Chưa bắt đầu';
        if ($now > $exam->end_time) return 'Đã kết thúc';
        return 'Đang diễn ra';
    }
}
