<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScoreNotification;

class ScoresController extends Controller
{
    // Lấy danh sách điểm số
    public function index()
    {
        return response()->json(Score::all());
    }

    // Lấy thông tin chi tiết một điểm số
    public function show($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($score);
    }

    // Lấy thông tin tất cả điểm của từng sinh viên
    public function getAllScoresStudentByStudentId($studentId)
    {
        $score = Score::where('student_id', $studentId)->get();
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($score);
    }


      // Lấy bẳng điểm bằng student_id và coure_id
      public function getScoresStudentByStudentIdAndCoureId($studentId, $courseId)
      {
          $score = Score::where('student_id', $studentId)
                    ->where('course_id',$courseId)
                    ->get();
          if (!$score) {
              return response()->json(['erro' => 'Không tìm thấy điểm số!'], 404);
          }
          return response()->json($score);
      }


    // Tạo mới một điểm số
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'course_id' => 'required|string|exists:course,course_id',
            'process_score' => 'nullable|numeric|min:0|max:10',
            'midterm_score' => 'nullable|numeric|min:0|max:10',
            'final_score' => 'nullable|numeric|min:0|max:10',
            'average_score' => 'nullable|numeric|min:0|max:10',
        ]);

        // // Lấy thông tin course từ course_id
        // $course = Course::find($validatedData['course_id']);


        // if (!$course) {
        //     return response()->json(['error' => 'Course not found.'], 404);
        // }

        // // Kiểm tra nếu chưa có điểm trung bình, đặt mặc định là 0
        // if (!isset($validatedData['average_score'])) {
        //     $validatedData['average_score'] = 0;
        // }

        // // Tính điểm trung bình nếu average_score vẫn là 0
        // if ($validatedData['average_score'] == 0) {
        //     $validatedData['average_score'] = round(
        //         $validatedData['process_score'] * ($course->process_ratio / 100) +
        //             $validatedData['midterm_score'] * ($course->midterm_ratio / 100) +
        //             $validatedData['final_score'] * ($course->final_ratio / 100),
        //         2
        //     );
        // }

        $score = Score::create($validatedData);

        return response()->json($score, Response::HTTP_CREATED);
    }

    public function testSendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            // Gửi email
            Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
                $message->to($validatedData['email'])
                        ->subject($validatedData['subject']);
            });

            return response()->json(['message' => 'Email đã được gửi thành công.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không thể gửi email. Lỗi: ' . $e->getMessage()]);
        }
    }

    // Cập nhật điểm số
    public function update(Request $request, $id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }

        // Cập nhật validation, cho phép null các cột điểm
        $validatedData = $request->validate([
            'student_id' => 'required|string|exists:student,student_id',
            'course_id' => 'required|string|exists:course,course_id',
            'process_score' => 'nullable|numeric|min:0|max:10',
            'midterm_score' => 'nullable|numeric|min:0|max:10',
            'final_score' => 'nullable|numeric|min:0|max:10',
            'average_score' => 'nullable|numeric|min:0|max:10',
        ]);

        // Lấy thông tin course từ course_id
        $course = Course::find($validatedData['course_id']);
        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }

        // Nếu điểm quá trình cũ tồn tại và có điểm mới, tính lại điểm quá trình
        if (isset($validatedData['process_score']) && $score->process_score !== null) {
            // Tính trung bình điểm quá trình cũ và mới
            $newProcessScore = ($score->process_score + $validatedData['process_score']) / 2;
            $validatedData['process_score'] = $newProcessScore;
        }

        // Kiểm tra nếu tất cả 3 cột điểm đều có giá trị (không phải null)
        $processScore = $validatedData['process_score'] ?? $score->process_score;
        $midtermScore = $validatedData['midterm_score'] ?? $score->midterm_score;
        $finalScore = $validatedData['final_score'] ?? $score->final_score;

        if ($processScore !== null && $midtermScore !== null && $finalScore !== null) {
            // Tính lại điểm trung bình nếu có đủ 3 điểm
            $validatedData['average_score'] = round(
                ($processScore * ($course->process_ratio / 100)) +
                    ($midtermScore * ($course->midterm_ratio / 100)) +
                    ($finalScore * ($course->final_ratio / 100)),
                2
            );
            // Gửi email khi đã có điểm tổng
            $studentEmail = $score->student->school_email;
            $subject = 'Thông báo điểm của bạn';
            $message = "Chào " . $score->student->full_name . ",\n\n";
            $message .= "Điểm của bạn cho môn " . $score->course->course_name . " đã được cập nhật:\n\n";
            $message .= "Điểm quá trình: " . $score->process_score . "\n";
            $message .= "Điểm giữa kỳ: " . $score->midterm_score . "\n";
            $message .= "Điểm cuối kỳ: " . $score->final_score . "\n";
            $message .= "Điểm trung bình: " . $score->average_score . "\n\n";
            $message .= "Cảm ơn bạn!";

            // Gửi email thô
            Mail::raw($message, function ($message) use ($studentEmail, $subject) {
                $message->to($studentEmail)
                        ->subject($subject);
            });

        } else {
            // Nếu không đủ 3 điểm, để điểm trung bình là null hoặc giữ lại điểm cũ
            $validatedData['average_score'] = null; // Hoặc $score->average_score để giữ điểm cũ
        }

        // Cập nhật điểm số
        $score->update($validatedData);



        return response()->json($score);
    }



    // Xóa điểm số
    public function destroy($id)
    {
        $score = Score::find($id);
        if (!$score) {
            return response()->json(['message' => 'Không tìm thấy điểm số!'], Response::HTTP_NOT_FOUND);
        }

        $score->delete();

        return response()->json(['message' => 'Điểm số đã được xóa thành công!'], Response::HTTP_OK);
    }
}
