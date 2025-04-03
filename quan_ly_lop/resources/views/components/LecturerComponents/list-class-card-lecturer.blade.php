<!-- ĐỖ MINH TRÍ ĐANG CODE DỞ DANG TRONG FILE NÀY... -->
<?php
// Kiểm tra nếu có API backend gửi dữ liệu lên
$classes = $classes ?? [
    [
        'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Công Nghệ',
        'classroom' => 'D21_TH10',
        'author' => 'Do Minh Tri',
        'date' => '13 June 2025'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
        'title' => 'Lớp Sinh Học',
        'classroom' => 'D21_TH11',
        'author' => 'Nguyễn Văn A',
        'date' => '10 July 2025'
    ]
];

$title = $title ?? 'Danh sách lớp đang dạy';
?>

<!-- Bootstrap 5 -->
<div class="container-fluid py-4">
    <!-- Tiêu đề -->
    <h3 class="fw-bold mb-3">
        {{ $title }}
    </h3>

    <!-- Danh sách lớp -->
    <div class="row g-3">
        @foreach ($classes as $class)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card shadow-sm border border-secondary-subtle">
                    <img src="{{ $class['image'] }}" class="card-img-top img-fluid" alt="{{ $class['title'] }}" style="height: 150px; object-fit: cover;">

                    <div class="card-body">
                        <p class="text-muted small mb-1">{{ $class['author'] }}</p>
                        <h5 class="card-title">{{ $class['title'] }}</h5>
                        <p class="text-muted small mb-2">Lớp: {{ $class['classroom'] }}</p>

                        <div class="d-flex justify-content-between align-items-center border-top pt-2 text-muted small">
                            <span>Joined:</span>
                            <span>{{ $class['date'] }}</span>
                        </div>

                        <a href="#" class="btn btn-outline-dark w-100 mt-2">Truy cập</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
