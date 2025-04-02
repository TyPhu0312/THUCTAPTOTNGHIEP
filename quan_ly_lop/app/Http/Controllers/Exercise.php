<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class Exercise extends Controller
{
    public function createAssignment(Request $request)
    {
        // kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|string|exists:course,course_id',
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:255',
            'type' => 'required|in:Trắc nghiệm,Tự luận',
            'isSimultaneous' => 'required|boolean',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'show_result' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // tạo assignment mới
            $assignment = Assignment::create([
                'assignment_id' => (string) Str::uuid(),
                'course_id' => $request->course_id,
                'title' => $request->title,
                'content' => $request->content,
                'type' => $request->type,
                'isSimultaneous' => $request->isSimultaneous,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'show_result' => $request->show_result,
                'status' => 'Pending',
                'created_at' => Carbon::now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Assignment created successfully',
                'data' => $assignment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create assignment',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }
}
