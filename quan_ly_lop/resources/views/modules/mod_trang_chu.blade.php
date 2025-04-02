<?php
$student_name = 'Nguyễn Văn A'; // Sau này có thể lấy từ API hoặc session
?>
<div>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="alert alert-primary d-flex align-items-center" role="alert" style="margin-top: 20px;">
            <i class="bi bi-person-circle me-2"></i> <!-- Bootstrap icon -->
            <span>Xin chào, bạn đang đăng nhập với tư cách là <strong><?php echo $student_name; ?></strong></span>
        </div>
    </div>
    <div style="padding: 20px;">
        @include('components.filter-and-search')
        <!-- danh sách lớp -->
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @include('components.list-class-card', [])
        </div>
    </div>
</div>
