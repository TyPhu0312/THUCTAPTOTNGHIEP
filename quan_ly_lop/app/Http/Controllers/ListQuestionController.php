<?php

namespace App\Http\Controllers;

use App\Models\ListQuestion;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class ListQuestionController extends Controller
{
    // Lấy danh sách câu hỏi của một môn học cụ thể
    public function index(Request $request)
    {
        $courses = Course::all();
        $listQuestions = ListQuestion::all();
        return view('lecturerViews.question_bank', compact('courses', 'listQuestions'));
    }



    // Lấy thông tin chi tiết một danh sách câu hỏi
    public function show($id)
    {
        $listQuestion = ListQuestion::with(['course', 'questions.options'])->find($id);

        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        return view('modules.mod_lecturer.mod_createQuestionBank', compact('listQuestion'));
    }
    public function showListQuestionForLecturer($course_id, $lecturer_id)
    {
        try {
            // Loại bỏ ký tự '\n' và các ký tự trắng (nếu có) từ lecturer_id
            $lecturer_id = trim($lecturer_id);

            // Eager load các quan hệ course, lecturer và questions trong một lần truy vấn
            $listQuestions = ListQuestion::with(['course', 'lecturer', 'questions.options']) // Eager load mối quan hệ
                ->where('lecturer_id', $lecturer_id)
                ->where('course_id', $course_id)
                ->first();

            // Kiểm tra nếu không tìm thấy bản ghi
            if (!$listQuestions) {
                return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], 404);
            }

            // Định dạng dữ liệu câu hỏi
            $formattedQuestions = $listQuestions->questions->map(function ($question) {
                return [
                    'question_id' => $question->question_id,
                    'title' => $question->title,
                    'content' => $question->content,
                    'type' => $question->type,
                    'correct_answer' => $question->correct_answer,
                    'options' => $question->options->pluck('option_text')->toArray(), // Lấy các options
                ];
            });

            return response()->json([
                'data' => [
                    'course_id' => $listQuestions->course_id,
                    'course_name' => $listQuestions->course->course_name,
                    'questions' => $formattedQuestions
                ]
            ]);
        } catch (\Exception $e) {
            // Trả về lỗi nếu có
            return response()->json([
                'error' => $e->getMessage(),
                'details' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);
        $listQuestion = ListQuestion::create($validatedData);
        return response()->json(['message' => 'Tạo danh sách câu hỏi thành công!', 'data' => $listQuestion], Response::HTTP_CREATED);
    }
    public function storeFromWeb(Request $request)
    {
        try {
            // Tạo mới danh sách câu hỏi
            $validatedData = $request->validate([
                'course_id' => 'required|string|exists:course,course_id',
                'lecturer_id' => 'required|string|exists:lecturer,lecturer_id'
            ]);
            $listQuestion = ListQuestion::create([
                'course_id' => $validatedData['course_id'],
                'lecturer_id' => $validatedData['lecturer_id'], // Lưu lecturer_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tạo danh sách câu hỏi thành công!',
                'id' => $listQuestion->list_question_id
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tạo danh sách câu hỏi: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Cập nhật danh sách câu hỏi
    public function update(Request $request, $id)
    {
        $listQuestion = ListQuestion::find($id);
        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'course_id' => 'required|string|exists:course,course_id',
        ]);

        $listQuestion->update($validatedData);
        return response()->json(['message' => 'Cập nhật danh sách câu hỏi thành công!', 'data' => $listQuestion], Response::HTTP_OK);
    }

    // Xóa danh sách câu hỏi
    public function destroy($id)
    {
        $listQuestion = ListQuestion::find($id);
        if (!$listQuestion) {
            return response()->json(['message' => 'Không tìm thấy danh sách câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        $listQuestion->delete();
        return response()->json(['message' => 'Danh sách câu hỏi đã được xóa thành công!'], Response::HTTP_OK);
    }
}
