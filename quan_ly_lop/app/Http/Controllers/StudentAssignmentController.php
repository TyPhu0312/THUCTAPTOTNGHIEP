<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Exam;
use App\Models\Submission;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class StudentAssignmentController extends Controller
{
    /**
     * Get list of available assignments and exams for the student
     */
   // Lấy danh sách bài tập theo lớp học của sinh viên
   // Lấy danh sách bài tập theo lớp học của sinh viên
   public function getAssignments($student_id)
{
    $assignments = Assignment::whereHas('classroom.studentClasses', function ($query) use ($student_id) {
        $query->where('student_id', $student_id);
    })->get();

    return response()->json($assignments);
}

   // Lấy danh sách bài thi theo lớp học của sinh viên
   public function getExams($student_id)
   {
       $exams = Exam::whereHas('classroom.studentClasses', function ($query) use ($student_id) {
           $query->where('student_id', $student_id);
       })->get();

       return response()->json($exams);
   }

   // Nộp bài tập hoặc bài thi
   public function submitWork(Request $request)
   {
       $request->validate([
           'student_id' => 'required|exists:students,student_id',
           'exam_id' => 'nullable|exists:exam,exam_id',
           'assignment_id' => 'nullable|exists:assignment,assignment_id',
           'answer_file' => 'required|file|max:10240',
       ]);

       // Kiểm tra nếu cả exam_id và assignment_id đều NULL hoặc cả hai cùng có giá trị
       if (empty($request->exam_id) == empty($request->assignment_id)) {
           return response()->json(['message' => 'Bài nộp phải thuộc về một Exam hoặc Assignment.'], 400);
       }

       // Kiểm tra nếu đã nộp bài trước đó
       $existingSubmission = Submission::where('student_id', $request->student_id)
           ->where(function ($query) use ($request) {
               if ($request->has('exam_id')) {
                   $query->where('exam_id', $request->exam_id);
               }
               if ($request->has('assignment_id')) {
                   $query->where('assignment_id', $request->assignment_id);
               }
           })->first();

       if ($existingSubmission) {
           return response()->json(['message' => 'Bạn đã nộp bài trước đó!'], 400);
       }

       // Lưu file bài nộp
       $filePath = $request->file('answer_file')->store('submissions');

       // Kiểm tra trễ hạn
       $isLate = false;
       if ($request->has('exam_id')) {
           $exam = Exam::find($request->exam_id);
           if (now()->greaterThan($exam->due_date)) {
               $isLate = true;
           }
       } elseif ($request->has('assignment_id')) {
           $assignment = Assignment::find($request->assignment_id);
           if (now()->greaterThan($assignment->due_date)) {
               $isLate = true;
           }
       }

       // Lưu bài nộp
       $submission = Submission::create([
           'student_id' => $request->student_id,
           'exam_id' => $request->exam_id,
           'assignment_id' => $request->assignment_id,
           'answer_file' => $filePath,
           'is_late' => $isLate,
           'temporary_score' => null,
       ]);

       return response()->json(['message' => 'Nộp bài thành công!', 'submission' => $submission], 201);
   }

   // Xem trạng thái bài nộp của sinh viên
   public function getSubmissionStatus($student_id)
   {
       $submissions = Submission::where('student_id', $student_id)->get();
       return response()->json($submissions);
   }

   // Xem điểm của từng bài tập, bài thi
   public function getScores($student_id)
   {
       $scores = Score::where('student_id', $student_id)->get();
       return response()->json($scores);
   }
}