<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MyClassController extends Controller
{
    public function index()
    {
        $classes = [
            [
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                'title' => 'Lập Trình Web',
                'description' => 'Khóa học lập trình web cơ bản đến nâng cao',
                'author' => 'GV. Phạm Hải Nam',
                'student' => Auth::user()->full_name,
                'status' => 'Đang học',
                'date' => '11/02/2025',
                'progress' => 75,
                'class_code' => 'WEB101',
                'final_score' => null
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2',
                'title' => 'Trí Tuệ Nhân Tạo',
                'description' => 'Nhập môn trí tuệ nhân tạo',
                'author' => 'GV. Đỗ Minh Trí',
                'student' => Auth::user()->full_name,
                'status' => 'Đã hoàn thành',
                'date' => '15/05/2024',
                'progress' => 100,
                'class_code' => 'AI101',
                'final_score' => 8.5
            ]
        ];

        return view('modules.mod_trang_lop_cua_toi', [
            'classes' => $classes,
            'user' => Auth::user()
        ]);
    }
} 