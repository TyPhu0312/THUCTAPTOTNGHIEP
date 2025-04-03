<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Lấy danh sách tất cả bài tập
     */
    public function index()
    {
        $assignments = Assignment::with('classes')->get();
        return view('assignments.index', compact('assignments'));
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
     * Hiển thị form tạo mới bài tập
     */
    public function create()
    {
        $classes = ClassModel::all();
        return view('assignments.form', compact('classes'));
    }

    /**
     * Thêm mới một bài tập
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào từ request với các quy tắc sau:
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Tiêu đề: bắt buộc, là chuỗi, tối đa 255 ký tự
            'description' => 'required|string', // Mô tả: bắt buộc, là chuỗi
            'type' => 'required|in:assignment,exam', // Loại: bắt buộc, chỉ được là 'assignment' hoặc 'exam'
            'start_time' => 'nullable|date', // Thời gian bắt đầu: có thể null, phải là định dạng ngày
            'end_time' => 'nullable|date|after:start_time', // Thời gian kết thúc: có thể null, phải là ngày và sau start_time
            'is_simultaneous' => 'boolean', // Làm đồng thời: kiểu boolean
            'class_ids' => 'required|array', // Danh sách lớp: bắt buộc, phải là mảng
            'class_ids.*' => 'exists:classes,id' // Mỗi ID lớp trong mảng phải tồn tại trong bảng classes
        ]);

        $assignment = Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_simultaneous' => $validated['is_simultaneous'] ?? false,
            'created_by' => Auth::id()
        ]);

        $assignment->classes()->attach($validated['class_ids']);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Hiển thị form cập nhật bài tập
     */
    public function edit(Assignment $assignment)
    {
        $classes = ClassModel::all();
        return view('assignments.form', compact('assignment', 'classes'));
    }

    /**
     * Cập nhật một bài tập
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:assignment,exam',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'is_simultaneous' => 'boolean',
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        $assignment->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_simultaneous' => $validated['is_simultaneous'] ?? false
        ]);

        $assignment->classes()->sync($validated['class_ids']);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Xóa một bài tập
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }
}
