<!-- ĐỖ MINH TRÍ ĐANG CODE DỞ DANG TRONG FILE NÀY... -->
<?php
$classes = [
    [
        'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Công Nghệ',
        'description' => 'Khóa học về công nghệ thông tin.',
        'author' => 'Do Minh Tri',
        'student' => 'Jane',
        'date' => '13 June 2025'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Sinh Học',
        'description' => 'Tìm hiểu thế giới tự nhiên.',
        'author' => 'Nguyễn Văn A',
        'student' => 'John',
        'date' => '10 July 2025'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Kiến Trúc',
        'description' => 'Thiết kế kiến trúc sáng tạo.',
        'author' => 'Đỗ Minh Trí',
        'student' => 'Emma',
        'date' => '25 August 2025'
    ],
    // 4 - Hóa Học
    [
        'image' => 'https://images.unsplash.com/photo-1581091012184-dc63b1ca2707?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Hóa Học',
        'description' => 'Khám phá phản ứng và thí nghiệm hóa học.',
        'author' => 'Phạm Thị Lan',
        'student' => 'Alice',
        'date' => '12 September 2025'
    ],
    // 5
    [
        'image' => 'https://images.unsplash.com/photo-1596495577886-d920f1fb7238?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Vật Lý',
        'description' => 'Nghiên cứu các định luật tự nhiên và vũ trụ.',
        'author' => 'Lê Văn Nam',
        'student' => 'Bob',
        'date' => '30 September 2025'
    ],
    // 6
    [
        'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Toán Học',
        'description' => 'Giải quyết các bài toán từ cơ bản đến nâng cao.',
        'author' => 'Trần Thị Mai',
        'student' => 'Charlie',
        'date' => '15 October 2025'
    ],
    // 7 - Nghệ Thuật
    [
        'image' => 'https://images.unsplash.com/photo-1508919801845-fc2ae1bc2f28?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Nghệ Thuật',
        'description' => 'Thể hiện bản thân qua nghệ thuật và hội họa.',
        'author' => 'Ngô Thị Hồng',
        'student' => 'David',
        'date' => '02 November 2025'
    ],
    // 8 - Lịch Sử
    [
        'image' => 'https://images.unsplash.com/photo-1573164574572-cb89e39749b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Lịch Sử',
        'description' => 'Khám phá các sự kiện lịch sử quan trọng.',
        'author' => 'Vũ Minh Tuấn',
        'student' => 'Eva',
        'date' => '20 November 2025'
    ],
    // 9
    [
        'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Địa Lý',
        'description' => 'Tìm hiểu về địa chất và các hiện tượng thiên nhiên.',
        'author' => 'Hoàng Thị Dung',
        'student' => 'Frank',
        'date' => '01 December 2025'
    ],
    // 10
    [
        'image' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Âm Nhạc',
        'description' => 'Khám phá âm nhạc và kỹ thuật biểu diễn.',
        'author' => 'Nguyễn Nhật Quang',
        'student' => 'Grace',
        'date' => '15 December 2025'
    ],
    // 11
    [
        'image' => 'https://images.unsplash.com/photo-1596495577886-d920f1fb7238?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Thiết Kế Đồ Họa',
        'description' => 'Học cách tạo ra những thiết kế chuyên nghiệp.',
        'author' => 'Trần Đức Bình',
        'student' => 'Henry',
        'date' => '05 January 2026'
    ],
    // 12
    [
        'image' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Kinh Tế',
        'description' => 'Tìm hiểu các nguyên lý và mô hình kinh tế.',
        'author' => 'Phạm Minh Huy',
        'student' => 'Isabella',
        'date' => '20 January 2026'
    ],
    // 13 - Tiếng Anh
    [
        'image' => 'https://images.unsplash.com/photo-1588776814643-b1a74de10443?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Tiếng Anh',
        'description' => 'Nâng cao kỹ năng nghe, nói, đọc, viết tiếng Anh.',
        'author' => 'Nguyễn Hoàng Sơn',
        'student' => 'Jack',
        'date' => '01 February 2026'
    ]
];



$title = $title ?? 'Danh sách lớp đang học'; // Nếu không truyền thì mặc định
?>

<!-- CSS -->
<style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    .class-list-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f8f9fa;
        padding: 20px;
    }

    .class-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .custom-card {
        transition: all 0.3s ease;
        border: 2px solid rgb(220, 220, 220) !important;
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
        padding: 12px;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .custom-btn {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-btn:hover {
        background-color: #2e2f30;
        transform: translateY(-1px);
    }

    .card-body {
        padding: 12px;
    }

    .card-author {
        margin-bottom: 10px;
        color: #6c757d;
        font-size: 0.85rem;
        line-height: 1.2;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding-top: 8px;
        margin-bottom: 12px;
        font-size: 0.85rem;
        color: #555;
    }

    .btn-container {
        margin-top: 10px;
    }
</style>

<!-- Tiêu đề -->
<div class="self-start mt-3">
    <h3 style="font-size: 25px; font-weight: 700; margin: 0; margin-left: 15px;">
        {{ $title ?? 'Danh sách lớp' }}
    </h3>
</div>
<div class="class-list-container" style="width: 100%;">
    <!-- Danh sách lớp -->
    <div class="d-flex flex-wrap gap-4 justify-content-start">
        <div class="d-flex flex-wrap gap-4 justify-content-center">
            @foreach ($classes as $class)
                <x-class-card :image="$class['image']" :title="$class['title']" :description="$class['description']"
                    :author="$class['author']" :student="$class['student']" :date="$class['date']" />
            @endforeach
        </div>
    </div>
</div>
