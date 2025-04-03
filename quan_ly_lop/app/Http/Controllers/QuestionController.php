<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ListQuestionController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Options;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::paginate(10);

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }


    // Lấy thông tin chi tiết một câu hỏi
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($question);
    }

    // Tạo mới một câu hỏi
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'list_question_id' => 'required|string|exists:list_question,list_question_id',
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|string|in:Trắc nghiệm,Tự luận',
            'correct_answer' => 'nullable|string', // Không bắt buộc nếu là câu hỏi tự luận
            'answer_a' => 'nullable|string', // Đáp án A, chỉ cần khi là câu hỏi trắc nghiệm
            'answer_b' => 'nullable|string', // Đáp án B
            'answer_c' => 'nullable|string', // Đáp án C
            'answer_d' => 'nullable|string', // Đáp án D
        ]);
        // Tạo câu hỏi mới
        $questionData = $validatedData;
        if ($questionData['type'] === 'Trắc nghiệm') {
            $questionData['answer_a'] = $request->input('answer_a');
            $questionData['answer_b'] = $request->input('answer_b');
            $questionData['answer_c'] = $request->input('answer_c');
            $questionData['answer_d'] = $request->input('answer_d');
        }
        $question = Question::create($questionData);
        return response()->json($question, Response::HTTP_CREATED);
    }
    public function storeBatch(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'list_question_id' => 'required|string|exists:list_question,list_question_id',
            'questions' => 'required|array',
            'questions.*.title' => 'required|string',
            'questions.*.content' => 'required|string',
            'questions.*.type' => 'required|string|in:Trắc nghiệm,Tự luận',
            'questions.*.options' => 'required_if:questions.*.type,Trắc nghiệm|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            $createdQuestions = [];
            foreach ($request->questions as $questionData) {
                // Tạo câu hỏi
                $question = Question::create([
                    'list_question_id' => $request->list_question_id,
                    'title' => $questionData['title'],
                    'content' => $questionData['content'],
                    'type' => $questionData['type'],
                ]);

                // Xử lý các lựa chọn nếu câu hỏi là trắc nghiệm
                if ($questionData['type'] === 'Trắc nghiệm' && isset($questionData['options'])) {
                    foreach ($questionData['options'] as $index => $option) {
                        // Tạo option mới
                        $newOption = $question->options()->create([
                            'option_text' => $option['option_text'],
                            'is_correct' => $option['is_correct'],
                            'option_order' => $index
                        ]);

                        // Nếu là đáp án đúng, cập nhật correct_answer của câu hỏi
                        if ($option['is_correct']) {
                            $question->correct_answer = $option['option_text'];
                            $question->save();
                        }
                    }
                }

                $createdQuestions[] = $question;
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu thành công ' . count($createdQuestions) . ' câu hỏi',
                'data' => $createdQuestions
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu câu hỏi',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Cập nhật thông tin câu hỏi
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'list_question_id' => 'required|string|exists:list_question,list_question_id', // Kiểm tra sự tồn tại của list_question_id
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|string|in:Trắc nghiệm,Tự luận',
            'correct_answer' => 'nullable|string', // Cập nhật đáp án nếu cần
        ]);
        $question->update($validatedData);
        return response()->json($question);
    }


    // Xóa một câu hỏi
    public function destroy($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['message' => 'Không tìm thấy câu hỏi!'], Response::HTTP_NOT_FOUND);
        }

        // Xóa câu hỏi
        $question->delete();

        // Trả về thông báo thành công kèm theo dữ liệu câu hỏi đã xóa
        return response()->json([
            'message' => 'Câu hỏi đã được xóa thành công!',
            'deleted_question' => $question,
        ], Response::HTTP_OK);
    }

}
