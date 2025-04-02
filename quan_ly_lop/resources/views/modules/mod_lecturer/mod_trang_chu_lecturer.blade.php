<?php
$lecture_name = 'Nguyễn Văn A';
?>
<div style="padding: 5px;">
    <div class="d-flex justify-content-center align-items-center mt-2 mb-3">
        <div class="alert alert-primary d-flex align-items-center" role="alert" style="margin-top: 20px;">
            <i class="bi bi-person-circle me-2"></i> <!-- Bootstrap icon -->
            <span>Xin chào, bạn đang đăng nhập với tư cách là giảng viên
                <strong><?php echo $lecture_name; ?></strong></span>
        </div>
    </div>
    @include('components.filter-and-search')
    <!-- danh sách lớp -->
    <div>

        @include('components.LecturerComponents.list-class-card-lecturer', [])
    </div>
</div>
