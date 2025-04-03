<?php
$api_url = 'https://example.com/api/classes'; // Thay thế bằng API thật
$response = @file_get_contents($api_url);
$classes = $response ? json_decode($response, true) : [];

// Nếu không có dữ liệu từ API, có thể dùng dữ liệu mặc định
if (empty($classes)) {
    $classes = [
        [
            'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=640&q=80',
            'title' => 'Lớp Công Nghệ',
            'description' => 'Khóa học về công nghệ thông tin.',
            'author' => 'Do Minh Tri',
            'date' => '13 June 2025'
        ]
    ];
}

$title = $title ?? 'Danh sách lớp đang học';

// Giả sử lấy tên giảng viên từ API hoặc session

?>



<!-- Tiêu đề -->
<div class="container-fluid py-4" style="margin-left: 20px;">
    <h3 class="fw-bold">
        <?php echo $title; ?>
    </h3>
    <!-- Danh sách lớp -->
    <div class="row mt-3 g-3">
        <?php foreach ($classes as $class) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card border border-secondary-subtle shadow-sm" style="width: 330px;">
                    <img src="<?php echo $class['image']; ?>" class="card-img-top img-fluid" alt="<?php echo $class['title']; ?>"
                        style="height: 140px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <p class="text-muted small mb-2"><?php echo $class['author']; ?></p>
                        <h5 class="card-title"><?php echo $class['title']; ?></h5>
                        <p class="card-text text-muted flex-grow-1"><?php echo $class['description']; ?></p>

                        <div class="d-flex justify-content-between align-items-center border-top pt-2 text-muted small">
                            <span>Joined:</span>
                            <span><?php echo $class['date']; ?></span>
                        </div>

                        <a href="#" class="btn btn-outline-dark w-100 mt-2">Truy cập</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
