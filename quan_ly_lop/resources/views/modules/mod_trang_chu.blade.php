@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            @auth
                <!-- Thông tin người dùng -->
                <div class="card welcome-card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-4">
                                <i class="fas fa-user-circle fa-3x text-white"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-1">Xin chào, {{ Auth::user()->full_name }}!</h4>
                                <p class="card-text text-muted mb-0">{{ Auth::user()->student_code }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thanh tìm kiếm và lọc -->
                <div class="search-filter-container mb-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control search-input" placeholder="Tìm kiếm lớp học...">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option selected>Tất cả lớp học</option>
                                <option>Đang diễn ra</option>
                                <option>Sắp khai giảng</option>
                                <option>Đã kết thúc</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Danh sách lớp học -->
                <div class="classes-container mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="section-title">Lớp học hiện có</h3>
                        <a href="{{ route('myclass') }}" class="btn btn-outline-primary">
                            <i class="fas fa-book-reader me-2"></i>Xem lớp của tôi
                        </a>
                    </div>
                    <div class="row g-4">
                        @foreach($classes as $class)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="class-card card h-100">
                                    <div class="card-img-wrapper">
                                        <img src="{{ $class['image'] }}" class="card-img-top" alt="{{ $class['title'] }}">
                                        <div class="card-img-overlay">
                                            <span class="badge status-badge {{ $class['status'] == 'Đang diễn ra' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $class['status'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="card-author mb-0">
                                                <i class="fas fa-chalkboard-teacher me-2"></i>{{ $class['author'] }}
                                            </p>
                                        </div>
                                        <h5 class="card-title">{{ $class['title'] }}</h5>
                                        <p class="card-text text-muted">{{ $class['description'] }}</p>
                                        
                                        @if(isset($class['progress']))
                                            <div class="progress-wrapper mb-3">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $class['progress'] }}%"
                                                         aria-valuenow="{{ $class['progress'] }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="progress-text">{{ $class['progress'] }}% hoàn thành</small>
                                            </div>
                                        @endif

                                        <div class="class-info">
                                            <div class="info-item">
                                                <i class="fas fa-users me-2"></i>
                                                <span>{{ $class['student'] }}</span>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                <span>{{ $class['date'] }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <a href="#" class="btn btn-primary w-100">
                                                <i class="fas fa-sign-in-alt me-2"></i>Tham gia
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Trang chào mừng cho khách -->
                <div class="welcome-container text-center py-5">
                    <div class="welcome-icon mb-4">
                        <i class="fas fa-graduation-cap fa-4x text-primary"></i>
                    </div>
                    <h2 class="welcome-title mb-3">Chào mừng đến với hệ thống quản lý lớp học</h2>
                    <p class="welcome-text mb-4">Đăng nhập để trải nghiệm đầy đủ các tính năng của hệ thống.</p>
                    <div class="welcome-buttons">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>

<style>
/* Card styles */
.class-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.class-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.card-img-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
    border-radius: 15px 15px 0 0;
}

.card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Avatar styles */
.avatar-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #007bff, #6610f2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Status badge */
.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
}

/* Progress bar */
.progress-wrapper {
    position: relative;
}

.progress {
    height: 8px;
    border-radius: 4px;
    background-color: #e9ecef;
}

.progress-bar {
    background: linear-gradient(45deg, #007bff, #6610f2);
}

.progress-text {
    position: absolute;
    right: 0;
    top: -20px;
    font-size: 0.85rem;
    color: #6c757d;
}

/* Class info */
.class-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #6c757d;
}

.info-item {
    display: flex;
    align-items: center;
}

/* Welcome section */
.welcome-container {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    padding: 3rem !important;
}

.welcome-icon {
    color: #007bff;
}

.welcome-title {
    color: #2c3e50;
    font-weight: 600;
}

.welcome-text {
    color: #6c757d;
    font-size: 1.1rem;
}

/* Search and filter */
.search-input {
    border-radius: 20px 0 0 20px;
    padding-left: 20px;
}

.search-input + .btn {
    border-radius: 0 20px 20px 0;
}

.form-select {
    border-radius: 20px;
    padding-left: 20px;
}

/* Section title */
.section-title {
    color: #2c3e50;
    font-weight: 600;
    position: relative;
    padding-bottom: 10px;
}

.section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(45deg, #007bff, #6610f2);
    border-radius: 2px;
}
</style>
@endsection
