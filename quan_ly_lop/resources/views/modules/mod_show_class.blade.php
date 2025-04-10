@section('main-content')
<div class="container py-4">
    <h3 class="mb-4">Test API - Lấy danh sách lớp học (không dùng Axios)</h3>

    <div class="card p-4 shadow-sm">
        <hr>

        <div id="class-list" class="mt-4">
            <!-- Kết quả sẽ hiển thị ở đây -->
        </div>
    </div>
</div>


<!-- Truyền student_id vào một thẻ meta (hoặc div) -->
<meta name="student_id" content="{{ Auth::user()->student_id }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
    getStudentClasses(); // Gọi hàm lấy lớp học ngay khi trang được tải
});

function getStudentClasses() {
    const classList = document.getElementById('class-list');
    classList.innerHTML = '<p>Đang tải dữ liệu...</p>';

    // Lấy token từ localStorage hoặc cookie
    const token = localStorage.getItem('token'); // Giả sử token được lưu trong localStorage

    // Lấy student_id từ thuộc tính meta
    const studentId = document.querySelector('meta[name="student_id"]').getAttribute('content');

    console.log("Student ID: ", studentId);  // Kiểm tra giá trị student_id

    fetch(`/api/classrooms/student-classes/${studentId}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}` // Gửi token trong header để xác thực
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Lỗi khi gọi API');
        }
        return response.json();
    })
    .then(data => {
        console.log("API Data:", data);  // Kiểm tra dữ liệu trả về từ API

        if (data.length === 0) {
            classList.innerHTML = '<p>Không có lớp học nào.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        data.forEach(cls => {
            html += `
                <li class="list-group-item">
                    <strong>Khóa học: ${cls.course_name || 'Không có dữ liệu'}</strong> <br>
                    <strong>Mã lớp:</strong> ${cls.class_code || 'Không có dữ liệu'} <br>
                    <strong>Mô tả lớp:</strong> ${cls.class_description || 'Không có dữ liệu'} <br>
                    <strong>Thời gian học:</strong> ${cls.class_duration || 'Không có dữ liệu'} <br>
                    <strong>Giảng viên:</strong> ${cls.lecturer_name || 'Không có dữ liệu'} <br>
                    <strong>Email giảng viên:</strong> ${cls.school_email || 'Không có dữ liệu'} <br>
                    <strong>Số điện thoại:</strong> ${cls.phone || 'Không có dữ liệu'} <br>
                    <strong>Trạng thái:</strong> ${cls.status} <br>
                    <strong>Điểm cuối kỳ:</strong> ${cls.final_score} <br>
                </li>`;
        });
        html += '</ul>';
        classList.innerHTML = html;
    })
    .catch(error => {
        console.error(error);
        classList.innerHTML = '<p class="text-danger">Không thể tải dữ liệu.</p>';
    });
}
</script>
@endsection
