<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $classes = [
            [
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                'title' => 'Lập Trình Web',
                'description' => 'Khóa học lập trình web cơ bản đến nâng cao',
                'author' => 'GV. Nguyễn Diễm Huỳnh',
                'student' => '98 sinh viên',
                'status' => 'Đang diễn ra',
                'date' => '20/03/2025',
                'progress' => 75,
                'class_code' => 'WEB101'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
                'title' => 'Cơ Sở Dữ Liệu',
                'description' => 'Thiết kế và quản lý cơ sở dữ liệu',
                'author' => 'GV. Nguyễn Thành Công',
                'student' => '92 sinh viên',
                'status' => 'Sắp khai giảng',
                'date' => '20/06/2025',
                'class_code' => 'DB101'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2',
                'title' => 'Trí Tuệ Nhân Tạo',
                'description' => 'Nhập môn trí tuệ nhân tạo',
                'author' => 'GV. Bùi Nhật Bằng',
                'student' => '110 sinh viên',
                'status' => 'Đang diễn ra',
                'date' => '15/03/2025',
                'progress' => 45,
                'class_code' => 'AI101'
            ]
        ];

        return view('modules.mod_trang_chu', [
            'classes' => $classes,
            'user' => Auth::user()
        ]);
    }
} 