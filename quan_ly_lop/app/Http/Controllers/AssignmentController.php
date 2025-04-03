<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssignmentController extends Controller
{
    /**
     * Lấy danh sách tất cả bài tập
     */
    public function index()
    {
        {
            return view('todopage');
        }
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
     * Thêm mới một bài tập
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_list_id'   => 'required|exists:sub_list,sub_list_id',
            'title'         => 'required|string|max:255',
            'content'       => 'nullable|string',
            'type'          => 'required|string|in:' . implode(',', Assignment::getAllowedTypes()),
            'isSimultaneous'=> 'boolean',
            'start_time'    => 'nullable|date',
            'end_time'      => 'nullable|date|after_or_equal:start_time',
            'show_result'   => 'boolean',
            'status'        => 'required|string|in:' . implode(',', Assignment::getAllowedStatuses()),
        ]);

        $assignment = Assignment::create($validatedData);
        return response()->json(['message' => 'Thêm bài tập thành công!', 'data' => $assignment], Response::HTTP_CREATED);
    }

    /**
     * Cập nhật một bài tập
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Bài tập không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title'         => 'string|max:255',
            'content'       => 'nullable|string',
            'type'          => 'string|in:' . implode(',', Assignment::getAllowedTypes()),
            'isSimultaneous'=> 'boolean',
            'start_time'    => 'nullable|date',
            'end_time'      => 'nullable|date|after_or_equal:start_time',
            'show_result'   => 'boolean',
            'status'        => 'string|in:' . implode(',', Assignment::getAllowedStatuses()),
        ]);

        $assignment->update($validatedData);
        return response()->json(['message' => 'Cập nhật bài tập thành công!', 'data' => $assignment], Response::HTTP_OK);
    }

    /**
     * Xóa một bài tập
     */
    public function destroy($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['message' => 'Bài tập không tồn tại!'], Response::HTTP_NOT_FOUND);
        }

        $assignment->delete();
        return response()->json(['message' => 'Xóa bài tập thành công!'], Response::HTTP_OK);
    }
}
