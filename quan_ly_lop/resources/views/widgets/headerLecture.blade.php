<style>
    .header-banner {
        height: 100px;
        overflow: hidden;
    }

    /* Logo STU giữ nguyên tỷ lệ, không bị crop */
    .logo-stu {
        height: 100%;
        width: auto; /* Giữ đúng tỷ lệ */
        object-fit: contain; /* Đảm bảo ảnh không bị cắt */
    }

    /* 2 ảnh còn lại fill đầy khung */
    .banner-image {
        height: 100%;
        width: 100%;
        object-fit: cover; /* Fill đầy vùng chứa, có thể crop */
    }

    /* Ẩn ảnh cuối khi màn hình nhỏ */
    @media (max-width: 768px) {
        .hide-on-mobile {
            display: none !important;
        }
    }
</style>

<header class="container-fluid p-0">
    <!-- Banner Top -->
    <div class="d-flex flex-row bg-white flex-nowrap header-banner">
        <!-- Logo STU -->
        <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="background-color: #fff;">
            <img src="/images/header_image/logo.jpg" alt="STU Logo" class="logo-stu">
        </div>

        <!-- Ảnh Bìa -->
        <div class="flex-grow-1">
            <img src="/images/header_image/anhbia.jpg" alt="Ảnh bìa" class="banner-image">
        </div>

        <!-- Hình Tuyên truyền -->
        <div class="flex-grow-1 hide-on-mobile">
            <img src="/images/header_image/tuyentruyen.jpg" alt="Tuyên truyền" class="banner-image">
        </div>
    </div>

    <!-- NAVBAR (Component Blade) -->
    <x-navbarLecture />
</header>
