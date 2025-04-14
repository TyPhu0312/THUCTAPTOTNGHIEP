<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Phần tìm kiếm và bộ lọc -->
            <div class="search-filter-container mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control search-input" 
                                   id="searchKeyword"
                                   placeholder="Tìm kiếm lớp học...">
                            <button class="btn btn-primary" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
=======
@extends('templates.template_normal')
@section('main-content')
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @auth
            <!-- Thông tin người dùng -->
            <div class="profile-header card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar-circle">
                                <i class="fas fa-user-graduate fa-3x text-white"></i>
                            </div>
>>>>>>> c3625acc5bb1d7578809f4c590a444ebdd2e7af8
                        </div>
                        <div class="col">
                            <h4 class="mb-1">Xin chào, {{ Auth::user()->full_name }}</h4>
                            <p class="text-light mb-0">
                                <i class="fas fa-id-card me-2"></i>{{ Auth::user()->student_code }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="">Tất cả lớp học</option>
                            <option value="active">Đang diễn ra</option>
                            <option value="upcoming">Sắp khai giảng</option>
                            <option value="completed">Đã kết thúc</option>
                        </select>
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Danh sách lớp học -->
            <div class="classes-container mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title">Lớp học hiện có</h3>
                    <a href="{{ route('myclass') }}" class="btn btn-outline-primary">
                        <i class="fas fa-book-reader me-2"></i>Xem lớp của tôi
                    </a>
=======
            <!-- Thanh tìm kiếm và lọc -->
            <div class="search-filter-container mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control search-input" placeholder="Tìm kiếm lớp học..."
                                id="searchInput">
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
>>>>>>> c3625acc5bb1d7578809f4c590a444ebdd2e7af8
                </div>
            </div>

<<<<<<< HEAD
                <div class="row g-4" id="searchResults">
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
                                <h5 class="card-title">{{ $class['title'] }}</h5>
                                <p class="card-text">{{ $class['description'] }}</p>
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
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.search-filter-container {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.search-input {
    height: 45px;
    border-radius: 10px 0 0 10px !important;
    border: 2px solid #e0e0e0;
    border-right: none;
}

.search-input:focus {
    box-shadow: none;
    border-color: #007bff;
}

.input-group .btn {
    border-radius: 0 10px 10px 0;
    padding: 0 20px;
}

.form-select {
    height: 45px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
}

.class-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}
=======
            <!-- Thống kê lớp học -->
            <div class="d-flex flex-column justify-content-start ">
                <h3 class="section-title mb-4">Lớp học hiện có</h3>
                <div class="row justify-content-start" id="dynamic-classes">
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
<!--                     <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Đăng ký
                    </a> -->
                </div>
            </div>
        @endauth
    </div>
    @auth
        <meta name="student_id" content="{{ Auth::user()->student_id }}">
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentId = document.querySelector('meta[name="student_id"]').getAttribute('content');
            const token = localStorage.getItem('token');

            fetch(`/api/classrooms/student-classes/${studentId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Lỗi khi gọi API');
                    }
                    return response.json();
                })
                .then(data => {
                    renderClasses(data);
                    window.allClasses = data;
                    searchBox();
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById('dynamic-classes').innerHTML =
                        '<p class="text-danger">Lỗi khi tải lớp học.</p>';
                });
        });
        function renderClasses(data) {
            const container = document.getElementById('dynamic-classes');
            if (data.length === 0) {
                container.innerHTML = '<p class="text-muted">Không có lớp học nào.</p>';
                return;
            }

            let html = '';
            data.forEach(classItem => {
                html += `
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="class-card card h-100">
                                        <div class="class-card-header">
                                            <img src="${classItem.image || 'images/header_image/default-class.jpg'}" class="class-image" alt="${classItem.course_name}">
                                            <div class="card-img-overlay">
                                                <span class="badge status-badge
                                                    ${classItem.status === 'Đang diễn ra' || classItem.status === 'Active' ? 'bg-success' :
                        classItem.status === 'Drop' ? 'bg-secondary' : 'bg-warning'}">
                                                    ${classItem.status || 'Không rõ'}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <p class="card-author mb-0">
                                                    <i class="fas fa-chalkboard-teacher me-2"></i>${classItem.lecturer_name || 'Không rõ'}
                                                </p>
                                            </div>
                                            <h5 class="card-title">${classItem.course_name || 'Tên lớp'}</h5>
                                            <p class="card-text text-muted">${classItem.class_description || 'Không có mô tả'}</p>

                                            <div class="class-info">
                                                <div class="info-item">
                                                    <i class="fas fa-users me-2"></i>
                                                    <span>${classItem.total_students || 0}</span>
                                                </div>
                                                <div class="info-item">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    <span>${classItem.class_duration || 'N/A'}</span>
                                                </div>
                                            </div>
                                            ${classItem.course_score != null ? `
                                                <div class="mt-2">
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-star me-1"></i> Điểm: ${classItem.course_score}/10
                                                    </span>
                                                </div>
                                            ` : ''}

                                            ${classItem.status !== 'Drop' ? `
                                                        <div class="mt-3">
                                                            <button class="btn btn-primary w-100 join-button"
                                                                data-course-id="${classItem.course_id}"
                                                                data-lecturer-id="${classItem.lecturer_id}"
                                                                data-class-id="${classItem.class_id}">
                                                                <i class="fas fa-sign-in-alt me-2"></i>Tham gia
                                                            </button>
                                                        </div>
                                                    ` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
            });

            container.innerHTML = html;
            attachJoinHandlers();
        }
        function attachJoinHandlers() {
            const joinButtons = document.querySelectorAll('.join-button');
            joinButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const courseId = this.getAttribute('data-course-id');
                    const lecturerId = this.getAttribute('data-lecturer-id');
                    const classId = this.getAttribute('data-class-id');
>>>>>>> c3625acc5bb1d7578809f4c590a444ebdd2e7af8

                    const listId = {
                        course_id: courseId,
                        lecturer_id: lecturerId,
                        class_id: classId
                    };

                    localStorage.setItem("list_id_course_lecturer", JSON.stringify(listId));

                    // Tuỳ chọn: điều hướng sang trang
                    window.location.href = "/classDetail";
                });
            });
        }
        function removeVietnameseTones(str) {
            return str.normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
                .replace(/đ/g, 'd').replace(/Đ/g, 'D');
        }
        function searchBox() {
            document.getElementById('searchInput').addEventListener('input', function () {
                const keyword = removeVietnameseTones(this.value.toLowerCase());
                const filtered = window.allClasses.filter(classItem =>
                    removeVietnameseTones(classItem.course_name.toLowerCase()).includes(keyword)
                );
                renderClasses(filtered);
            });
        }

<<<<<<< HEAD
.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.class-info {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e0e0e0;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 0.9rem;
}

.info-item i {
    color: #007bff;
}

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchKeyword = document.getElementById('searchKeyword');
    const searchBtn = document.getElementById('searchBtn');
    const statusFilter = document.getElementById('statusFilter');
    const searchResults = document.getElementById('searchResults');
    
    let searchTimeout = null;
    
    function performSearch() {
        const keyword = searchKeyword.value;
        const status = statusFilter.value;
        
        fetch(`/api/classrooms/search?keyword=${encodeURIComponent(keyword)}&status=${encodeURIComponent(status)}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayResults(data.data);
                }
            })
            .catch(error => {
                console.error('Lỗi khi tìm kiếm:', error);
            });
    }
    
    function displayResults(classes) {
        if (classes.length === 0) {
            searchResults.innerHTML = `
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Không tìm thấy kết quả nào</h4>
                </div>
            `;
            return;
        }
        
        searchResults.innerHTML = classes.map(classroom => `
            <div class="col-12 col-md-6 col-lg-4">
                <div class="class-card card h-100">
                    <div class="card-img-wrapper">
                        <img src="${classroom.image || '/images/default-class.jpg'}" 
                             class="card-img-top" 
                             alt="${classroom.class_code}">
                        <div class="card-img-overlay">
                            <span class="badge status-badge ${classroom.status === 'active' ? 'bg-success' : 'bg-warning'}">
                                ${classroom.status === 'active' ? 'Đang diễn ra' : 'Sắp khai giảng'}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${classroom.class_code}</h5>
                        <p class="card-text">${classroom.class_description || 'Không có mô tả'}</p>
                        <div class="class-info">
                            <div class="info-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>${classroom.lecturer ? classroom.lecturer.fullname : 'Chưa có giảng viên'}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <span>${new Date(classroom.created_at).toLocaleDateString('vi-VN')}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    // Event listeners
    searchKeyword.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300);
    });
    searchBtn.addEventListener('click', performSearch);
    statusFilter.addEventListener('change', performSearch);
});
</script>
=======
    </script>
    <style>
        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg,rgb(16, 42, 80) 0%, #6610f2 100%);
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

        .bg-primary-soft {
            background: rgba(0, 97, 242, 0.1);
        }

        .bg-success-soft {
            background: rgba(40, 167, 69, 0.1);
        }

        .bg-info-soft {
            background: rgba(23, 162, 184, 0.1);
        }

        .bg-warning-soft {
            background: rgba(255, 193, 7, 0.1);
        }

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

        .badge-success {
            background: #28a745;
        }

        .badge-secondary {
            background: #6c757d;
        }

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

        .btn-enter,
        .btn-review {
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
>>>>>>> c3625acc5bb1d7578809f4c590a444ebdd2e7af8
@endsection
