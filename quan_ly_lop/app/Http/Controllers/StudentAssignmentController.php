<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Exam;
use App\Models\Submission;
use App\Models\Score;
use App\Models\Student;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Str;

class StudentAssignmentController extends Controller
{
    /**
     * Get list of available assignments for the student
     */
    public function getAssignments($student_id)
    {
        // Kiểm tra sinh viên tồn tại
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'Không tìm thấy sinh viên với ID: ' . $student_id], 404);
        }

        // Get classes the student is enrolled in
        $studentClasses = $student->studentClasses()
            ->where('status', 'Active')
            ->pluck('class_id');

        if ($studentClasses->isEmpty()) {
            return response()->json(['message' => 'Sinh viên này không đăng ký lớp học nào hoặc không có lớp học đang hoạt động.'], 404);
        }

        // Get assignments for those classes
        $assignments = Assignment::whereIn('sub_list_id', function ($query) use ($studentClasses) {
            $query->select('sub_list_id')
                ->from('list_question')
                ->whereIn('course_id', function ($subQuery) use ($studentClasses) {
                    $subQuery->select('course_id')
                        ->from('classroom')
                        ->whereIn('class_id', $studentClasses);
                });
        })->get();

        return response()->json($assignments);
    }

    /**
     * Get list of available exams for the student
     */
    public function getExams($student_id)
    {
        // Kiểm tra sinh viên tồn tại
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'Không tìm thấy sinh viên với ID: ' . $student_id], 404);
        }
        
        // Get classes the student is enrolled in
        $studentClasses = $student->studentClasses()
            ->where('status', 'Active')
            ->pluck('class_id');
        
        if ($studentClasses->isEmpty()) {
            return response()->json(['message' => 'Sinh viên này không đăng ký lớp học nào hoặc không có lớp học đang hoạt động.'], 404);
        }
            
        // Get exams that are related to the student's courses
        $exams = Exam::whereIn('sub_list_id', function($query) use ($studentClasses) {
            $query->select('sub_list_id')
                ->from('list_question')
                ->whereIn('course_id', function($subQuery) use ($studentClasses) {
                    $subQuery->select('course_id')
                        ->from('classroom')
                        ->whereIn('class_id', $studentClasses);
                });
        })->get();
        
        return response()->json($exams);
    }

    /**
     * Submit an assignment or exam
     */
    public function submitWork(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'exam_id' => 'nullable|exists:exam,exam_id',
            'assignment_id' => 'nullable|exists:assignment,assignment_id',
            'answer_file' => 'required|file|max:10240',
        ]);

        // Check if only one of exam_id or assignment_id is provided
        if ((empty($request->exam_id) && empty($request->assignment_id)) ||
            (!empty($request->exam_id) && !empty($request->assignment_id))
        ) {
            return response()->json(['message' => 'A submission must belong to either an Exam or an Assignment, not both.'], 400);
        }

        // Check if student has already submitted this work
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
            return response()->json(['message' => 'You have already submitted this work!'], 400);
        }

        // Store the submitted file
        $filePath = $request->file('answer_file')->store('submissions');

        // Check if submission is late
        $isLate = false;
        $endTime = null;

        if ($request->has('exam_id') && $request->exam_id) {
            $exam = Exam::find($request->exam_id);
            $endTime = $exam->end_time;
        } elseif ($request->has('assignment_id') && $request->assignment_id) {
            $assignment = Assignment::find($request->assignment_id);
            $endTime = $assignment->end_time;
        }

        if ($endTime && now()->greaterThan($endTime)) {
            $isLate = true;
        }

        // Create the submission
        $submission = Submission::create([
            'submission_id' => Str::random(50), // Generating a unique ID
            'student_id' => $request->student_id,
            'exam_id' => $request->exam_id,
            'assignment_id' => $request->assignment_id,
            'answer_file' => $filePath,
            'is_late' => $isLate,
            'temporary_score' => null,
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Submission successful!', 'submission' => $submission], 201);
    }

    /**
     * Submit answers for questions
     */
    public function submitAnswers(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'submission_id' => 'required|exists:submission,submission_id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:question,question_id',
            'answers.*.answer_content' => 'required|string',
        ]);

        // Get the submission
        $submission = Submission::where('submission_id', $request->submission_id)
            ->where('student_id', $request->student_id)
            ->first();

        if (!$submission) {
            return response()->json(['message' => 'Submission not found.'], 404);
        }

        // Store each answer
        foreach ($request->answers as $answerData) {
            Answer::create([
                'answer_id' => Str::random(50), // Generating a unique ID
                'submission_id' => $submission->submission_id,
                'question_title' => Question::find($answerData['question_id'])->title,
                'question_content' => Question::find($answerData['question_id'])->content,
                'question_answer' => $answerData['answer_content'],
            ]);
        }

        return response()->json(['message' => 'Answers submitted successfully!'], 201);
    }

    /**
     * Get submission status for a student
     */
    public function getSubmissionStatus($student_id)
    {
        $submissions = Submission::where('student_id', $student_id)
            ->get();

        foreach ($submissions as $submission) {
            if ($submission->exam_id) {
                $submission->type = 'Exam';
                $submission->title = Exam::find($submission->exam_id)->title;
            } else if ($submission->assignment_id) {
                $submission->type = 'Assignment';
                $submission->title = Assignment::find($submission->assignment_id)->title;
            }
        }

        return response()->json($submissions);
    }

    /**
     * Get scores for a student
     */
    public function getScores($student_id)
    {
        $scores = Score::where('student_id', $student_id)->get();

        foreach ($scores as $score) {
            $score->course_name = $score->course->course_name;
        }

        return response()->json($scores);
    }

    /**
     * Get questions for an exam or assignment
     */
    public function getQuestions(Request $request)
    {
        $request->validate([
            'exam_id' => 'nullable|exists:exam,exam_id',
            'assignment_id' => 'nullable|exists:assignment,assignment_id',
        ]);

        if ((empty($request->exam_id) && empty($request->assignment_id)) ||
            (!empty($request->exam_id) && !empty($request->assignment_id))
        ) {
            return response()->json(['message' => 'Please provide either an exam_id or assignment_id.'], 400);
        }

        $subListId = null;

        if ($request->exam_id) {
            $subListId = Exam::find($request->exam_id)->sub_list_id;
        } else {
            $subListId = Assignment::find($request->assignment_id)->sub_list_id;
        }

        // Get questions from the sub_list
        $questions = Question::whereIn('question_id', function ($query) use ($subListId) {
            $query->select('question_id')
                ->from('sub_list_question')
                ->where('sub_list_id', $subListId);
        })->get();

        return response()->json($questions);
    }
}
