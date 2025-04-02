<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF
use App\Models\Score; // Model chứa điểm sinh viên
use App\Models\Course;

class PDFController extends Controller
{
    public function exportScores($course_id)
    {
        // Lấy danh sách điểm của sinh viên theo môn học
        $scores = Score::where('course_id', $course_id)->get();

        // Kiểm tra nếu không có điểm
        if ($scores->isEmpty()) {
            return response()->json(['message' => 'No scores found for this course.'], 404);
        }

        // Lấy tên môn học từ course_id
        $course = Course::find($course_id);
        $course_name = $course ? $course->course_name : 'Unknown Course';

        // Tải view 'pdf.scores' với dữ liệu điểm số và tên môn học
        $pdf = Pdf::loadView('pdf.scores', compact('scores', 'course_name'));
        $filename = ($course->course_name).'-scores.pdf';
        // Xuất file PDF với tên "scores.pdf"
        return $pdf->download( $filename);
    }
}
