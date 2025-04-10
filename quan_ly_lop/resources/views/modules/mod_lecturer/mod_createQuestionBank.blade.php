<style>
    /* Thiết lập màu sắc chủ đạo */
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --danger-color: #e74a3b;
        --light-color: #f8f9fc;
        --dark-color: #5a5c69;
        --border-color: #e3e6f0;
    }

    /* Thiết lập font chữ và màu nền chung */
    body {
        font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f8f9fc;
        color: #5a5c69;
    }

    /* Cải thiện container chính */
    .container.py-4 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Cải thiện card chính */
    .card.shadow-lg {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card.shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        border-radius: 0.75rem 0.75rem 0 0;
        padding: 1.25rem;
    }

    .card-header h4 {
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .card-body {
        padding: 2rem;
    }

    /* Cải thiện form elements */
    .form-label {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Cải thiện buttons */
    .btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #224abe 0%, var(--primary-color) 100%);
        transform: translateY(-2px);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #13855c 100%);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #13855c 0%, var(--secondary-color) 100%);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #be2617 100%);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #be2617 0%, var(--danger-color) 100%);
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        border: 1px solid var(--border-color);
        color: var(--dark-color);
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-color);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Cải thiện options section */
    #options-section {
        background-color: var(--light-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .option {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s ease;
    }

    .option:hover {
        transform: translateX(5px);
    }

    /* Cải thiện temporary questions section */
    #temporaryQuestionsSection {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }

    #temporaryQuestionsSection h5 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    #temporaryQuestionsList .mb-2 {
        background-color: var(--light-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    #temporaryQuestionsList .mb-2:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    #temporaryQuestionsList strong {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    #temporaryQuestionsList p {
        margin-bottom: 0.5rem;
    }

    #temporaryQuestionsList ul {
        list-style-type: none;
        padding-left: 0;
    }

    #temporaryQuestionsList li {
        padding: 0.5rem 0;
        border-bottom: 1px dashed var(--border-color);
    }

    #temporaryQuestionsList li:last-child {
        border-bottom: none;
    }

    /* Cải thiện alerts */
    .alert {
        border-radius: 0.5rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--secondary-color);
    }

    .alert-danger {
        background-color: rgba(231, 74, 59, 0.1);
        color: var(--danger-color);
    }

    /* Cải thiện form select */
    #courseSelect {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%235a5c69' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    /* Cải thiện radio buttons */
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.25rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Cải thiện textarea */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Cải thiện responsive */
    @media (max-width: 768px) {
        .container.py-4 {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
        }
    }

    /* Animation cho các phần tử */
    .animate__animated {
        animation-duration: 0.5s;
    }

    /* Cải thiện scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-color);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #224abe;
    }

    .card h5 {
        font-size: 1.2rem;
        font-weight: bold;
        color: #343a40;
    }

    .card p {
        margin-bottom: 0.5rem;
    }

    .card .card-body {
        padding: 1.25rem;
    }

    .card-hover::after {
        content: '→';
        /* hoặc dùng biểu tượng khác như '\2192' */
        position: absolute;
        bottom: -10px;
        left: 90%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 2.0rem;
        color: #007bff;
    }

    .card-hover:hover::after {
        opacity: 1;
    }

    .card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        position: relative;
        transition: box-shadow 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .card-text strong {
        color: #495057;
    }
</style>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            @auth
                <form id="courseForm" action="/api/questions/create" method="POST">
                    @csrf
                    <select name="course_id" id="courseSelect" class="form-select">
                        <option selected disabled>-- Chọn môn học --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" id="startCreateQuestion" class="btn btn-primary w-100 mt-3">
                        Bắt đầu tạo bộ câu hỏi
                    </button>
                </form>

                <div id="temporaryQuestionsSection" class="mb-4" style="display: none;">
                    <h5>Câu hỏi đã lưu tạm thời:</h5>
                    <div id="temporaryQuestionsList"></div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-lg animate__animated animate__fadeIn" style="display: none;">
                            <div class="card-header bg-primary text-white text-center">
                                <h4 class="mb-0">Tạo Câu Hỏi Trắc Nghiệm</h4>
                            </div>
                            <div class="card-body p-4">
                                <form id="createQuestionForm" action="{{ route('questions.store') }}" method="POST">
                                    @csrf
                                    <!-- Tiêu đề câu hỏi -->
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Tiêu Đề Câu Hỏi</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            placeholder="Nhập tiêu đề câu hỏi" required>
                                    </div>
                                    <!-- Nội dung câu hỏi -->
                                    <div class="mb-3">
                                        <label for="content" class="form-label fw-bold">Nội Dung Câu Hỏi</label>
                                        <textarea id="content" name="content" class="form-control" rows="4"
                                            placeholder="Nhập nội dung câu hỏi" required></textarea>
                                    </div>
                                    <!-- Loại câu hỏi -->
                                    <div class="mb-3">
                                        <label for="type" class="form-label fw-bold">Loại Câu Hỏi</label>
                                        <select id="type" name="type" class="form-select" required>
                                            <option value="Trắc nghiệm">Trắc nghiệm</option>
                                            <option value="Tự luận">Tự luận</option>
                                        </select>
                                    </div>

                                    <!-- Đáp án (Hiển thị nếu là Trắc nghiệm) -->
                                    <div id="options-section" class="mb-3">
                                        <label class="form-label fw-bold">Đáp Án</label>
                                        <div id="options-container">
                                            <div class="d-flex align-items-center mb-2 option">
                                                <input type="text" name="options[0][option_text]" class="form-control me-2"
                                                    placeholder="Nhập đáp án 1" required>
                                                <input type="radio" name="correct_answer" value="0"
                                                    class="form-check-input">
                                                <span class="ms-2">Đáp án đúng</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary mt-2" onclick="addOption()">+
                                            Thêm Lựa Chọn</button>
                                    </div>

                                    <!-- Nút gửi form -->
                                    <div class="text-center">
                                        <button type="button" id="saveQuestion" class="btn btn-primary w-100 mt-3">Tạo Thêm
                                            Câu Hỏi</button>
                                        <button type="button" id="finishCreating" class="btn btn-success w-100 mt-3">Hoàn
                                            Thành</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div class="container ">
        <div class="flex justify-content-between align-items-center mb-4">
            <h3 class="mb-4">Danh sách bộ câu hỏi của bạn</h3>
            <select name="course_id" id="courseFilter" class="form-select">
                <option value="all" selected>-- Tất cả môn học --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>

        </div>
        <div id="list-question-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 cursor-pointer">
            <!-- Cards sẽ được render ở đây -->
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startButton = document.getElementById("startCreateQuestion");
        const temporaryQuestionsList = document.getElementById("temporaryQuestionsList");
        const saveQuestionButton = document.getElementById("saveQuestion");
        const finishCreatingButton = document.getElementById("finishCreating");
        const questionForm = document.querySelector('.card.shadow-lg');
        const temporaryQuestionsSection = document.getElementById('temporaryQuestionsSection');
        let optionCount = 1;
        const courseId = 'bb18b2e3-b400-44f9-ae2a-d72853575eb3';
        const lecturerId = '13c21c5f-bb57-4e1f-9f65-a3bf69f4cc17';
        const filterSelect = document.getElementById('courseFilter');
        const courseSelect = document.getElementById("courseFilter");
        const container = document.getElementById("list-question-container");
        // Kiểm tra xem đã có list_question_id chưa
        const existingListQuestionId = localStorage.getItem("list_question_id");

        if (existingListQuestionId) {
            questionForm.style.display = 'block';
            temporaryQuestionsSection.style.display = 'block';
            renderTemporaryQuestions();
        }
        function fetchListQuestions(courseId = "null") {
            fetch(`/api/list-questions/getAllQuestion/${courseId}/${lecturerId}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById("list-question-container");
                    container.innerHTML = ""; // Xoá dữ liệu cũ

                    if (data.length === 0) {
                        container.innerHTML = `<p class="text-muted">Chưa có bộ câu hỏi nào cho môn học này.</p>`;
                        return;
                    }

                    data.forEach(item => {
                        const card = document.createElement("div");
                        card.className = "col";
                        const lecturerName = item.lecturer?.fullname || "Không rõ";
                        const courseName = item.course?.course_name || "Không rõ";
                        card.innerHTML = `
                    <div class="card h-100 shadow-sm card-hover position-relative">
                        <div class="card-body">
                            <p class="card-text"><strong>Môn học:</strong> ${courseName}</p>
                            <p class="card-text"><strong>Giảng viên:</strong> ${lecturerName}</p>
                            <p class="card-text"><small class="text-muted">Tạo lúc: ${new Date(item.created_at).toLocaleString()}</small></p>
                        </div>
                        <div class="arrow-icon">→</div>
                    </div>
                `;
                        container.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error("Lỗi khi lấy danh sách câu hỏi:", error);
                    document.getElementById("list-question-container").innerHTML =
                        `<p class="text-danger">Không thể tải dữ liệu. Vui lòng thử lại sau.</p>`;
                });
        }
        //lọc card
        courseSelect.addEventListener("change", function () {
            const selectedValue = this.value;
            const courseId = selectedValue === "all" ? "null" : selectedValue;
            fetchListQuestions(courseId);
        });
        window.addEventListener("DOMContentLoaded", () => {
            fetchListQuestions(); // load tất cả môn học khi chưa chọn gì
        });
        // Hiển thị câu hỏi đã lưu từ localStorage
        function renderTemporaryQuestions() {
            const savedQuestions = JSON.parse(localStorage.getItem('questions')) || [];
            temporaryQuestionsList.innerHTML = '';

            if (savedQuestions.length > 0) {
                savedQuestions.forEach((question, index) => {
                    const questionDiv = document.createElement('div');
                    questionDiv.classList.add('mb-2');
                    questionDiv.innerHTML = `
                        <div>
                            <strong>${question.title}</strong>
                            <p>${question.content}</p>
                            <p><em>Loại câu hỏi: ${question.type}</em></p>
                            <ul>
                                ${question.options.map(option =>
                        `<li>${option.option_text} ${option.is_correct ? '(Đúng)' : ''}</li>`
                    ).join('')}
                            </ul>
                            <button class="btn btn-danger btn-sm delete-question" data-index="${index}">
                                Xóa câu hỏi
                            </button>
                            <hr>
                        </div>
                    `;
                    temporaryQuestionsList.appendChild(questionDiv);
                });

                // Thêm event listeners cho nút xóa
                document.querySelectorAll('.delete-question').forEach(button => {
                    button.addEventListener('click', function () {
                        const index = parseInt(this.getAttribute('data-index'));
                        deleteTemporaryQuestion(index);
                    });
                });
            } else {
                temporaryQuestionsList.innerHTML = "<p>Không có câu hỏi tạm thời nào.</p>";
            }
        }

        // Xóa một câu hỏi tạm thời
        function deleteTemporaryQuestion(index) {
            const savedQuestions = JSON.parse(localStorage.getItem('questions')) || [];
            savedQuestions.splice(index, 1);
            localStorage.setItem('questions', JSON.stringify(savedQuestions));
            renderTemporaryQuestions();
        }

        // Reset form sau khi lưu
        function resetForm() {
            document.getElementById('createQuestionForm').reset();
            document.getElementById('options-container').innerHTML = `
                <div class="d-flex align-items-center mb-2 option">
                    <input type="text" name="options[0][option_text]" class="form-control me-2"
                        placeholder="Nhập đáp án 1" required>
                    <input type="radio" name="correct_answer" value="0"
                        class="form-check-input">
                    <span class="ms-2">Đáp án đúng</span>
                </div>
            `;
            optionCount = 1;
        }

        // Hiển thị phần đáp án khi loại câu hỏi là "Trắc nghiệm"
        document.getElementById('type').addEventListener('change', function () {
            const optionsSection = document.getElementById('options-section');
            optionsSection.style.display = this.value === 'Trắc nghiệm' ? 'block' : 'none';
        });

        // Thêm lựa chọn mới cho câu hỏi trắc nghiệm - sửa lỗi addOption
        function addOption() {
            const container = document.getElementById('options-container');
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('d-flex', 'align-items-center', 'mb-2', 'option');
            optionDiv.innerHTML = `
                <input type="text" name="options[${optionCount}][option_text]" class="form-control me-2"
                    placeholder="Nhập đáp án ${optionCount + 1}" required>
                <input type="radio" name="correct_answer" value="${optionCount}" class="form-check-input">
                <span class="ms-2">Đáp án đúng</span>
            `;
            container.appendChild(optionDiv);
            optionCount++;
        }

        // Gán hàm addOption vào window để có thể gọi từ onclick
        window.addOption = addOption;

        // Khởi động khi nhấn "Bắt đầu tạo câu hỏi"
        if (startButton) {
            startButton.addEventListener("click", function (e) {
                e.preventDefault();
                console.log("Start button clicked"); // Kiểm tra sự kiện click

                const courseId = document.getElementById("courseSelect").value;
                console.log("Course ID:", courseId); // Kiểm tra course ID

                if (!courseId) {
                    alert("Vui lòng chọn môn học trước khi tiếp tục!");
                    return;
                }

                startButton.disabled = true;
                startButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';

                console.log("Calling API endpoint: /api/list-questions");
                console.log("Request body:", { course_id: courseId, lecturer_id: lecturerId });

                console.log("CSRF Token:", csrfToken);

                fetch("/api/list-questions/create", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ course_id: courseId, lecturer_id: lecturerId })
                })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);
                        if (data.id) {
                            console.log("Saving list_question_id to localStorage:", data.id);
                            localStorage.setItem("list_question_id", data.id);
                            localStorage.setItem('questions', JSON.stringify([]));
                            alert("Danh sách câu hỏi đã được tạo!");
                            questionForm.style.display = 'block';
                            temporaryQuestionsSection.style.display = 'block';
                            renderTemporaryQuestions();
                        } else {
                            console.error("No id in response data:", data);
                            alert(data.message || "Có lỗi xảy ra, vui lòng thử lại!");
                        }
                    })
                    .catch(error => {
                        console.error("Error calling API:", error);
                        alert("Có lỗi xảy ra: " + error.message);
                    })
                    .finally(() => {
                        startButton.disabled = false;
                        startButton.innerHTML = 'Bắt đầu tạo bộ câu hỏi';
                    });
            });
        } else {
            console.error("Start button not found"); // Kiểm tra nếu không tìm thấy nút
        }

        // Lưu câu hỏi tạm thời vào localStorage khi nhấn "Tạo Thêm Câu Hỏi"
        if (saveQuestionButton) {
            saveQuestionButton.addEventListener('click', function () {
                console.log("Save button clicked"); // Kiểm tra sự kiện click

                const listQuestionId = localStorage.getItem("list_question_id");
                if (!listQuestionId) {
                    alert("Vui lòng bắt đầu tạo bộ câu hỏi trước!");
                    return;
                }

                const title = document.getElementById('title').value;
                const content = document.getElementById('content').value;
                const type = document.getElementById('type').value;

                console.log("Form data:", { title, content, type }); // Kiểm tra dữ liệu form

                if (!title || !content) {
                    alert("Vui lòng nhập đầy đủ tiêu đề và nội dung câu hỏi!");
                    return;
                }

                const options = [];
                let hasCorrectAnswer = false;

                if (type === 'Trắc nghiệm') {
                    document.querySelectorAll('.option').forEach((optionElement, index) => {
                        const optionText = optionElement.querySelector('input[type="text"]').value;
                        const isCorrect = optionElement.querySelector('input[type="radio"]').checked;

                        if (optionText) {
                            options.push({ option_text: optionText, is_correct: isCorrect });
                            if (isCorrect) hasCorrectAnswer = true;
                        }
                    });

                    console.log("Options:", options); // Kiểm tra options

                    if (options.length < 2) {
                        alert("Câu hỏi trắc nghiệm cần ít nhất 2 lựa chọn!");
                        return;
                    }

                    if (!hasCorrectAnswer) {
                        alert("Vui lòng chọn đáp án đúng!");
                        return;
                    }
                }

                const question = { title, content, type, options };

                let savedQuestions = JSON.parse(localStorage.getItem('questions')) || [];
                savedQuestions.push(question);
                localStorage.setItem('questions', JSON.stringify(savedQuestions));

                alert("Câu hỏi đã được lưu tạm thời.");
                resetForm();
                renderTemporaryQuestions();
            });
        } else {
            console.error("Save button not found"); // Kiểm tra nếu không tìm thấy nút
        }

        // Hoàn thành và gửi tất cả câu hỏi khi nhấn "Hoàn Thành"
        if (finishCreatingButton) {
            finishCreatingButton.addEventListener('click', function () {
                console.log("Finish button clicked"); // Kiểm tra sự kiện click

                let savedQuestions = JSON.parse(localStorage.getItem('questions')) || [];
                console.log("Saved questions:", savedQuestions); // Kiểm tra câu hỏi đã lưu

                if (savedQuestions.length === 0) {
                    alert("Chưa có câu hỏi nào được lưu!");
                    return;
                }

                const listQuestionId = localStorage.getItem("list_question_id");
                console.log("List question ID:", listQuestionId); // Kiểm tra list question ID

                if (!listQuestionId) {
                    alert("Có lỗi xảy ra! Không tìm thấy danh sách câu hỏi.");
                    return;
                }

                finishCreatingButton.disabled = true;
                finishCreatingButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';

                fetch('/api/questions/batch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        list_question_id: listQuestionId,
                        questions: savedQuestions
                    })
                })
                    .then(response => {
                        console.log("Response status:", response.status); // Kiểm tra status code
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data); // Kiểm tra dữ liệu trả về
                        if (data.success) {
                            localStorage.removeItem('questions');
                            localStorage.removeItem('list_question_id');
                            alert("Tất cả câu hỏi đã được lưu thành công!");
                            window.location.href = '/questions';
                        } else {
                            alert("Lỗi: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                        alert("Có lỗi xảy ra: " + error.message);
                    })
                    .finally(() => {
                        finishCreatingButton.disabled = false;
                        finishCreatingButton.innerHTML = 'Hoàn Thành';
                    });
            });
        } else {
            console.error("Finish button not found"); // Kiểm tra nếu không tìm thấy nút
        }
        console.log("Start button:", startButton);
        console.log("Save button:", saveQuestionButton);
        console.log("Finish button:", finishCreatingButton);
    });

</script>
