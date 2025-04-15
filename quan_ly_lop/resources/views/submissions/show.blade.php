@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Phần Bài tập -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Danh sách bài tập</h4>
                    <div>
                        <a href="/assignments/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tạo bài tập mới
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="assignments-table">
                            <thead>
                                <tr>
                                    <th>Mã bài tập</th>
                                    <th>Tiêu đề</th>
                                    <th>Loại</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu bài tập sẽ được thêm vào đây bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Phần Bài kiểm tra -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Danh sách bài kiểm tra</h4>
                    <div>
                        <a href="/exams/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tạo bài kiểm tra mới
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="exams-table">
                            <thead>
                                <tr>
                                    <th>Mã bài kiểm tra</th>
                                    <th>Tiêu đề</th>
                                    <th>Loại</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu bài kiểm tra sẽ được thêm vào đây bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy dữ liệu bài tập từ API
        fetch('/api/assignments-test')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const assignmentsTable = document.querySelector('#assignments-table tbody');
                    assignmentsTable.innerHTML = ''; // Xóa dữ liệu cũ
                    
                    data.data.forEach(assignment => {
                        const row = document.createElement('tr');
                        
                        // Định dạng ngày giờ
                        const startTime = new Date(assignment.start_time);
                        const endTime = new Date(assignment.end_time);
                        const formattedStartTime = `${startTime.getDate()}/${startTime.getMonth() + 1}/${startTime.getFullYear()} ${startTime.getHours()}:${String(startTime.getMinutes()).padStart(2, '0')}`;
                        const formattedEndTime = `${endTime.getDate()}/${endTime.getMonth() + 1}/${endTime.getFullYear()} ${endTime.getHours()}:${String(endTime.getMinutes()).padStart(2, '0')}`;
                        
                        // Tạo trạng thái với màu tương ứng
                        let statusBadge = '';
                        if (assignment.status === 'Completed') {
                            statusBadge = '<span class="badge bg-success">Hoàn thành</span>';
                        } else if (assignment.status === 'In Progress') {
                            statusBadge = '<span class="badge bg-primary">Đang diễn ra</span>';
                        } else {
                            statusBadge = '<span class="badge bg-secondary">Sắp diễn ra</span>';
                        }
                        
                        row.innerHTML = `
                            <td>${assignment.assignment_id}</td>
                            <td>${assignment.title}</td>
                            <td>${assignment.type}</td>
                            <td>${formattedStartTime}</td>
                            <td>${formattedEndTime}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/assignments/${assignment.assignment_id}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/assignments/${assignment.assignment_id}/edit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/submissions/index?type=assignment&id=${assignment.assignment_id}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-tasks"></i>
                                    </a>
                                </div>
                            </td>
                        `;
                        
                        assignmentsTable.appendChild(row);
                    });
                } else {
                    console.error('Không thể lấy dữ liệu bài tập');
                }
            })
            .catch(error => {
                console.error('Lỗi khi gọi API bài tập:', error);
                document.querySelector('#assignments-table tbody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">Không thể tải dữ liệu bài tập. Vui lòng thử lại sau.</td>
                    </tr>
                `;
            });
        
        // Lấy dữ liệu bài kiểm tra từ API
        fetch('/api/exams-test')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const examsTable = document.querySelector('#exams-table tbody');
                    examsTable.innerHTML = ''; // Xóa dữ liệu cũ
                    
                    data.data.forEach(exam => {
                        const row = document.createElement('tr');
                        
                        // Định dạng ngày giờ
                        const startTime = new Date(exam.start_time);
                        const endTime = new Date(exam.end_time);
                        const formattedStartTime = `${startTime.getDate()}/${startTime.getMonth() + 1}/${startTime.getFullYear()} ${startTime.getHours()}:${String(startTime.getMinutes()).padStart(2, '0')}`;
                        const formattedEndTime = `${endTime.getDate()}/${endTime.getMonth() + 1}/${endTime.getFullYear()} ${endTime.getHours()}:${String(endTime.getMinutes()).padStart(2, '0')}`;
                        
                        // Tạo trạng thái với màu tương ứng
                        let statusBadge = '';
                        if (exam.status === 'Completed') {
                            statusBadge = '<span class="badge bg-success">Hoàn thành</span>';
                        } else if (exam.status === 'In Progress') {
                            statusBadge = '<span class="badge bg-primary">Đang diễn ra</span>';
                        } else {
                            statusBadge = '<span class="badge bg-secondary">Sắp diễn ra</span>';
                        }
                        
                        row.innerHTML = `
                            <td>${exam.exam_id}</td>
                            <td>${exam.title}</td>
                            <td>${exam.type}</td>
                            <td>${formattedStartTime}</td>
                            <td>${formattedEndTime}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/exams/${exam.exam_id}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/exams/${exam.exam_id}/edit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/submissions/index?type=exam&id=${exam.exam_id}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-tasks"></i>
                                    </a>
                                </div>
                            </td>
                        `;
                        
                        examsTable.appendChild(row);
                    });
                } else {
                    console.error('Không thể lấy dữ liệu bài kiểm tra');
                }
            })
            .catch(error => {
                console.error('Lỗi khi gọi API bài kiểm tra:', error);
                document.querySelector('#exams-table tbody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">Không thể tải dữ liệu bài kiểm tra. Vui lòng thử lại sau.</td>
                    </tr>
                `;
            });
    });
</script>
@endsection