<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Exam;
use App\Models\Submission;
use App\Models\Score;
use App\Models\Student; // Thêm model Student
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentAssignmentController extends Controller
{
    /**
     * Get list of available assignments and exams for the student
     */
    public function getAvailableAssignmentsAndExams($student_id)
    {
        // Kiểm tra sinh viên tồn tại
        $student = Student::findOrFail($student_id);

        // Get current time
        $now = Carbon::now();

        // Fetch assignments
        $assignments = Assignment::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->where('status', 'Processing')
            ->get();

        // Fetch exams
        $exams = Exam::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->where('status', 'Processing')
            ->get();

        // Check submission status for each assignment/exam
        $assignments->each(function ($assignment) use ($student) {
            $submission = Submission::where('student_id', $student->id)
                ->where('assignment_id', $assignment->id)
                ->first();
            
            $assignment->submission_status = $submission ? 
                ($submission->is_late ? 'Late' : 'Submitted') : 
                'Not Submitted';
        });

        $exams->each(function ($exam) use ($student) {
            $submission = Submission::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->first();
            
            $exam->submission_status = $submission ? 
                ($submission->is_late ? 'Late' : 'Submitted') : 
                'Not Submitted';
        });

        return response()->json([
            'assignments' => $assignments,
            'exams' => $exams
        ]);
    }

    /**
     * Submit assignment or exam
     */
    public function submitWork(Request $request, $student_id)
    {
        // Kiểm tra sinh viên tồn tại
        $student = Student::findOrFail($student_id);

        $validatedData = $request->validate([
            'work_type' => 'required|in:assignment,exam',
            'work_id' => 'required|uuid',
            'answer_file' => 'required|file|max:10240', // Max 10MB
        ]);

        $now = Carbon::now();

        if ($validatedData['work_type'] === 'assignment') {
            $work = Assignment::findOrFail($validatedData['work_id']);
        } else {
            $work = Exam::findOrFail($validatedData['work_id']);
        }

        // Check if submission is within time
        $isLate = $now > $work->end_time;

        // Store file
        $filePath = $request->file('answer_file')->store('submissions');

        // Create submission
        $submission = Submission::create([
            'student_id' => $student->id,
            'assignment_id' => $validatedData['work_type'] === 'assignment' ? $work->id : null,
            'exam_id' => $validatedData['work_type'] === 'exam' ? $work->id : null,
            'answer_file' => $filePath,
            'is_late' => $isLate
        ]);

        return response()->json([
            'message' => 'Submission successful',
            'is_late' => $isLate,
            'submission_id' => $submission->id
        ]);
    }

    /**
     * Get student's scores and feedback
     */
    public function getScoresAndFeedback($student_id)
    {
        // Kiểm tra sinh viên tồn tại
        $student = Student::findOrFail($student_id);

        // Get submissions with scores
        $submissions = Submission::with(['exam', 'assignment'])
            ->where('student_id', $student->id)
            ->get();

        // Process submissions to include scores
        $submissionScores = $submissions->map(function ($submission) {
            $work = $submission->exam ?? $submission->assignment;
            $workType = $submission->exam_id ? 'exam' : 'assignment';

            return [
                'id' => $submission->id,
                'title' => $work->title,
                'type' => $workType,
                'submitted_at' => $submission->created_at,
                'is_late' => $submission->is_late,
                'temporary_score' => $submission->temporary_score,
                'status' => $submission->temporary_score !== null ? 'Graded' : 'Pending Grading'
            ];
        });

        // Get overall course scores
        $courseScores = Score::where('student_id', $student->id)
            ->with('course')
            ->get();

        return response()->json([
            'submission_scores' => $submissionScores,
            'course_scores' => $courseScores
        ]);
    }
}