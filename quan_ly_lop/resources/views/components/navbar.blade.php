@php
    $currentRoute = Route::currentRouteName();
@endphp

<style>
    .nav-link {
        transition: all 0.3s ease;
        /* Mượt mà khi hover */
        position: relative;
        font-size: 1.1rem;
        /* Tăng size chữ cho link */
    }

    .navbar-nav {
        font-size: 1.1rem;
        /* Tăng size chữ toàn bộ navbar */
    }

    .nav-link.dropdown-toggle::after {
        display: none !important;
        /* Ẩn mũi tên Bootstrap mặc định */
    }

    .nav-link:hover {
        color: #007bff !important;
        /* Màu xanh tươi hơn khi hover */
        transform: scale(1.05);
        /* Phóng to nhẹ */
    }

    .nav-link.active-nav {
        color: #0056b3 !important;
        /* Xanh đậm hơn khi active */
        font-weight: bold !important;
    }

    /* Hiệu ứng underline */
    .nav-link::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        display: block;
        margin-top: 5px;
        right: 0;
        background: #007bff;
        transition: width 0.3s ease;
        -webkit-transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
        left: 0;
        background: #007bff;
    }

    /* Tăng size icon */
    .navbar-nav .bi {
        font-size: 1.8rem;
        /* Kích thước icon lớn hơn */
    }

    @media (max-width: 768px) {
        .nav-link {
            font-size: 1rem;
            /* Trên mobile nhỏ lại chút */
        }

        .navbar-nav .bi {
            font-size: 1.5rem;
        }
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <!-- Nút toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu content -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul
                class="navbar-nav w-100 d-flex align-items-center justify-content-start justify-content-md-center text-start text-md-center">

                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'home' ? 'active-nav' : '' }}" href="{{ route('home') }}">
                        TRANG CHỦ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'myclass' ? 'active-nav' : '' }}"
                        href="{{ route('myclass') }}">
                        LỚP CỦA TÔI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'account' ? 'active-nav' : '' }}"
                        href="{{ route('account') }}">
                        TÀI KHOẢN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'todopage' ? 'active-nav' : '' }}"
                        href="{{ route('todopage') }}">
                        VIỆC CẦN LÀM
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'createQuestion' ? 'active-nav' : '' }}"
                        href="{{ route('createQuestion') }}">
                        TẠO BÀI THI
                    </a>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @auth
                            <li><a class="dropdown-item" href="#">{{ Auth::user()->full_name }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
