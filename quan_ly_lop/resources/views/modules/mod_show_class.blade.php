@section('main-content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <div id="course-info"></div>
        </div>
        <div class="col-md-6">
            <div id="lecturer-info" class="border p-3 rounded bg-light"></div>
        </div>
    </div>

</div>


<!-- Truyền student_id vào một thẻ meta (hoặc div) -->
<meta name="student_id" content="{{ Auth::user()->student_id }}">

<script>
    // Lấy dữ liệu từ localStorage
    let courseId = null;
    let lecturerId = null;
    let classId=null;

// Lấy dữ liệu từ localStorage
const storedData = localStorage.getItem("list_id_course_lecturer");

if (storedData) {
    const listId = JSON.parse(storedData);
    courseId = listId.course_id;
    lecturerId = listId.lecturer_id;
    classId= listId.class_id;


} else {
    console.log("Không tìm thấy dữ liệu course_id và lecturer_id.");
}
    document.addEventListener('DOMContentLoaded', function() {
        getCourseInfo(courseId);
        getLecturerInfo(lecturerId);
});

async function getCourseInfo(courseId) {
    const courseInfoDiv = document.getElementById("course-info");

    try {
        const [courseRes, classroom] = await Promise.all([
            fetch(`/api/courses/getById/${courseId}`).then(res => {
                if (!res.ok) throw new Error("Không thể lấy thông tin môn học");
                return res.json();
            }),
            getClassroomInfo(classId) // Đợi dữ liệu mô tả lớp học
        ]);

        courseInfoDiv.innerHTML = `
        <h5>
            Lớp của tôi /
            <a href="/myclass" class="text-dark text-decoration-none"><strong>${courseRes.course_name || 'Không có dữ liệu'}</strong></a>
        </h5>

        <div class="position-relative rounded overflow-hidden text-white" style="min-height: 250px; background-image: url('images/header_image/default-class.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 p-4 rounded">
                <p class="mb-0"><strong>${classroom?.class_description || 'Không có dữ liệu'}</strong> </p>
            </div>
        </div>

        `;
    } catch (err) {
        console.error(err);
        courseInfoDiv.innerHTML = '<p class="text-danger">Không thể tải thông tin môn học.</p>';
    }
}


function getLecturerInfo(lecturerId) {
    const lecturerInfoDiv = document.getElementById("lecturer-info");

    fetch(`/api/lecturers/getById/${lecturerId}`)
        .then(res => {
            if (!res.ok) throw new Error("Không thể lấy thông tin giảng viên");
            return res.json();
        })
        .then(lecturer => {
            lecturerInfoDiv.innerHTML = `
                <p><strong>Họ tên:</strong> ${lecturer.fullname || 'Không có dữ liệu'}</p>
                <p><strong>Email:</strong> ${lecturer.school_email || 'Không có dữ liệu'}</p>
                <p><strong>Email cá nhân:</strong> ${lecturer.personal_email || 'Không có dữ liệu'}</p>
                <p><strong>Số điện thoại:</strong> ${lecturer.phone || 'Không có dữ liệu'}</p>

            `;
        })
        .catch(err => {
            console.error(err);
            lecturerInfoDiv.innerHTML = '<p class="text-danger">Không thể tải thông tin giảng viên.</p>';
        });
}
function getClassroomInfo(classId) {
    return fetch(`/api/classrooms/getById/${classId}`)
        .then(res => {
            if (!res.ok) throw new Error("Không thể lấy thông tin lớp học");
            return res.json();
        })
        .then(classroom => {
            const courseDetailsDiv = document.getElementById("course-details");
            if (courseDetailsDiv) {
                courseDetailsDiv.innerHTML += `
                    <p><strong>Mô tả lớp:</strong> ${classroom.class_description || 'Không có dữ liệu'}</p>
                `;
            }
            return classroom; // 👈 Trả dữ liệu ra ngoài
        })
        .catch(err => {
            console.error(err);
            return null; // hoặc throw err nếu muốn báo lỗi
        });
}

</script>
@endsection
