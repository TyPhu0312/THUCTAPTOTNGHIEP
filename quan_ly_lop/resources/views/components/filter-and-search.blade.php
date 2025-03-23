<style>
    /* Style nút Dropdown và Search */
    .btn-custom-dropdown,
    .btn-custom-search {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: all 0.3s ease;
        height: 44px;
        padding: 0 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* Hover cho nút */
    .btn-custom-dropdown:hover,
    .btn-custom-search:hover {
        background-color: #333;
        color: #fff;
        border-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    /* Search input đẹp hơn */
    .custom-search-input {
        padding: 10px 14px;
        width: 250px;
        height: 44px;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    /* Focus vào input */
    .custom-search-input:focus {
        border-color: #333;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
        outline: none;
    }

    /* Animation hiện/ẩn search box mobile */
    #searchBoxMobile {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    #searchBoxMobile.show {
        display: block !important;
        animation: slideDown 0.4s ease forwards;
    }

    @keyframes slideDown {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Nút tìm kiếm mobile */
    #toggleSearchBtn {
        height: 44px;
        padding: 0 12px;
    }

    /* Khoảng cách trên mobile cho đẹp */
    #searchBoxMobile input {
        width: 100%;
    }

    /* Optional: hiệu ứng responsive */
    @media (max-width: 767px) {
        .custom-search-input {
            width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-start align-items-center flex-wrap mb-3 gap-2">
    <!-- Tiêu đề và icon tìm kiếm (cho mobile) -->
    <div class="d-flex align-items-center mb-2 mb-md-0">
        <!-- Icon tìm kiếm hiển thị khi màn hình nhỏ -->
        <button class="btn btn-custom-search d-md-none" type="button" id="toggleSearchBtn">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <!-- Dropdown và tìm kiếm (hiển thị trên desktop) -->
    <div class="d-flex align-items-center flex-wrap gap-2">
        <!-- Dropdown -->
        <div class="dropdown">
            <button class="btn btn-custom-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Tìm theo
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Lớp đang tham gia</a></li>
                <li><a class="dropdown-item" href="#">Lớp đã tham gia</a></li>
                <li><a class="dropdown-item" href="#">Lớp có bài tập / bài kiểm tra</a></li>
            </ul>
        </div>

        <!-- Ô tìm kiếm (ẩn trên mobile, hiện khi có class active) -->
        <div id="searchBox" class="d-none d-md-flex align-items-center gap-2">
            <input type="text" placeholder="Tìm lớp..." class="custom-search-input">
            <button class="btn btn-custom-search">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
</div>

<!-- Ô tìm kiếm dưới tiêu đề khi ở mobile và bấm icon -->
<div id="searchBoxMobile" class="d-none mb-3">
    <div class="d-flex flex-column gap-2">
        <input type="text" placeholder="Tìm lớp..." class="custom-search-input w-100">
        <button class="btn btn-custom-search d-flex justify-content-center align-items-center">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSearchBtn');
        const mobileSearchBox = document.getElementById('searchBoxMobile');

        toggleBtn?.addEventListener('click', function () {
            if (mobileSearchBox.classList.contains('d-none')) {
                mobileSearchBox.classList.remove('d-none');
                mobileSearchBox.classList.add('show');
            } else {
                mobileSearchBox.classList.add('d-none');
                mobileSearchBox.classList.remove('show');
            }
        });
    });
</script>
