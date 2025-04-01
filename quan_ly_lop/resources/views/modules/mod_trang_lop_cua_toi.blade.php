@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @auth
        <!-- Header Profile -->
        <div class="profile-header card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-circle">
                            <i class="fas fa-user-graduate fa-3x text-white"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="mb-1">{{ Auth::user()->full_name }}</h4>
                        <p class="text-light mb-0">
                            <i class="fas fa-id-card me-2"></i>{{ Auth::user()->student_code }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="stats-row row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary-soft">
                        <i class="fas fa-book-open text-primary"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ count($classes) }}</h3>
                        <p>Lớp đang học</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success-soft">
                        <i class="fas fa-graduation-cap text-success"></i>
                    </div>
                    <div class="stat-info">
                        <h3>2</h3>
                        <p>Đã hoàn thành</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-info-soft">
                        <i class="fas fa-clock text-info"></i>
                    </div>
                    <div class="stat-info">
                        <h3>30</h3>
                        <p>Giờ học</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning-soft">
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="stat-info">
                        <h3>8.5</h3>
                        <p>Điểm TB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thanh tìm kiếm và lọc -->
        <div class="search-filter-card card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control search-input" placeholder="Tìm kiếm lớp học...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select custom-select">
                            <option selected>Trạng thái</option>
                            <option>Đang học</option>
                            <option>Đã hoàn thành</option>
                            <option>Tất cả</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select custom-select">
                            <option selected>Sắp xếp theo</option>
                            <option>Mới nhất</option>
                            <option>Cũ nhất</option>
                            <option>Tên A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách lớp -->
        <div class="classes-section">
            <h4 class="section-title mb-4">Lớp của tôi</h4>
            <div class="row g-4">
                @foreach($classes as $class)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="class-card">
                            <div class="class-card-header">
                                <img src="{{ $class['image'] }}" alt="{{ $class['title'] }}" class="class-image">
                                <span class="status-badge {{ $class['status'] == 'Đang học' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $class['status'] }}
                                </span>
                            </div>
                            <div class="class-card-body">
                                <h5 class="class-title">{{ $class['title'] }}</h5>
                                <p class="class-description">{{ $class['description'] }}</p>
                                
                                <div class="class-info">
                                    <div class="info-item">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span>{{ $class['author'] }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $class['date'] }}</span>
                                    </div>
                                </div>

                                @if(isset($class['progress']))
                                    <div class="progress-section">
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $class['progress'] }}%"></div>
                                        </div>
                                        <span class="progress-text">{{ $class['progress'] }}% hoàn thành</span>
                                    </div>
                                @endif

                                @if(isset($class['final_score']))
                                    <div class="score-section">
                                        <div class="score-badge">
                                            <span class="score-label">Điểm số:</span>
                                            <span class="score-value">{{ $class['final_score'] }}/10</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="class-actions">
                                    @if($class['status'] == 'Đang học')
                                        <a href="#" class="btn btn-primary btn-enter">
                                            <i class="fas fa-door-open me-2"></i>Vào học
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-secondary btn-review">
                                            <i class="fas fa-history me-2"></i>Xem lại
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endauth
</div>

<style>
/* Profile Header */
.profile-header {
    background: linear-gradient(135deg, #0061f2 0%, #6610f2 100%);
    border: none;
    border-radius: 15px;
    color: white;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.bg-primary-soft { background: rgba(0, 97, 242, 0.1); }
.bg-success-soft { background: rgba(40, 167, 69, 0.1); }
.bg-info-soft { background: rgba(23, 162, 184, 0.1); }
.bg-warning-soft { background: rgba(255, 193, 7, 0.1); }

.stat-info h3 {
    font-size: 24px;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.stat-info p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

/* Search and Filter */
.search-filter-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
}

.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-input {
    padding-left: 45px;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

.custom-select {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

/* Class Cards */
.class-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    transition: transform 0.3s ease;
}

.class-card:hover {
    transform: translateY(-5px);
}

.class-card-header {
    position: relative;
}

.class-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 8px 15px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
}

.badge-success { background: #28a745; }
.badge-secondary { background: #6c757d; }

.class-card-body {
    padding: 20px;
}

.class-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.class-description {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 15px;
}

.class-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 14px;
}

.progress-section {
    margin-bottom: 15px;
}

.progress {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    margin-bottom: 5px;
}

.progress-bar {
    background: linear-gradient(135deg, #0061f2 0%, #6610f2 100%);
    border-radius: 4px;
}

.progress-text {
    font-size: 12px;
    color: #6c757d;
}

.score-section {
    margin-bottom: 15px;
}

.score-badge {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    padding: 10px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.score-value {
    font-weight: 600;
    font-size: 16px;
}

.class-actions {
    margin-top: 20px;
}

.btn-enter, .btn-review {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    font-weight: 500;
}

.section-title {
    color: #333;
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
    background: linear-gradient(135deg, #0061f2 0%, #6610f2 100%);
    border-radius: 3px;
}
</style>
@endsection
