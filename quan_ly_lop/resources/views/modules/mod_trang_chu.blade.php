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

            <!-- Danh sách lớp học -->
            <div class="classes-container mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title">Lớp học hiện có</h3>
                    <a href="{{ route('myclass') }}" class="btn btn-outline-primary">
                        <i class="fas fa-book-reader me-2"></i>Xem lớp của tôi
                    </a>
                </div>

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
@endsection
