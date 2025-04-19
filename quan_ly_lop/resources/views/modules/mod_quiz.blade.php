@section('main-content')
    <div class="container mt-5">
        <!-- Loading indicator -->
        <div id="loading" class="text-center">Đang tải...</div>

        <div id="quiz-container" class="card shadow-lg rounded d-none">
            <div class="card-body">
                <h3 id="quiz-title" class="card-title text-center mb-4"></h3>

                <form id="quiz-form">
                    @csrf

                    <div id="quiz-questions"></div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Nộp bài</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="error-msg" class="alert alert-danger d-none mt-3"></div>
        <div id="success-msg" class="alert alert-success d-none mt-3"></div>

    </div>
    @auth
        <meta name="student_id" content="{{ Auth::user()->student_id }}">
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id'); // Lấy tham số id từ URL
            const studentId = document.querySelector('meta[name="student_id"]').getAttribute('content');

            const loadingEl = document.getElementById('loading');
            const quizContainer = document.getElementById('quiz-container');
            const errorMsg = document.getElementById('error-msg');
            const successMsg = document.getElementById('success-msg');
            const questionContainer = document.getElementById('quiz-questions');
            const quizTitle = document.getElementById('quiz-title');

            // Kiểm tra xem ID có tồn tại không
            if (!id) {
                errorMsg.classList.remove('d-none');
                errorMsg.innerText = "Không tìm thấy ID bài thi hoặc bài tập!";
                return;
            }

            try {
                loadingEl.classList.remove('d-none');

                let res, data;

                // Kiểm tra xem ID là của bài thi hay bài tập
                res = await fetch(`/api/exams/getById/${id}`); // Kiểm tra bài thi trước
                if (res.ok) {
                    data = await res.json(); // Chỉ chuyển thành JSON nếu phản hồi là OK
                }

                // Nếu không phải bài thi, kiểm tra xem đó có phải bài tập không
                if (!data) {
                    res = await fetch(
                        `/api/assignments/getById/${id}`); // Nếu không phải bài thi thì lấy bài tập
                    if (res.ok) {
                        data = await res.json();
                    }
                }

                loadingEl.classList.add('d-none');

                if (!data) {
                    errorMsg.classList.remove('d-none');
                    errorMsg.innerText = "Không tìm thấy bài thi hoặc bài tập!";
                    return;
                }

                quizTitle.textContent = data.title;
                quizContainer.classList.remove('d-none');

                const questions = data.questions || [];

                questions.forEach((q, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('mb-4');

                    const questionHtml = `
                <p><strong>Câu ${index + 1}:</strong> ${q.content}</p>
                ${q.choices.map((choice, i) => `
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[${q.question_id}]" value="${choice}" id="q${q.question_id}_${i}">
                                            <label class="form-check-label" for="q${q.question_id}_${i}">
                                                ${choice}
                                            </label>
                                        </div>
                                    `).join('')}
            `;

                    wrapper.innerHTML = questionHtml;
                    questionContainer.appendChild(wrapper);
                });

                // Xử lý submit bài
                document.getElementById('quiz-form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    let hasUnanswered = false;
                    const answers = {};

                    // Thu thập dữ liệu câu trả lời
                    questions.forEach(q => {
                        const selected = formData.get(
                            `answers[${q.question_id}]`); // Lấy câu trả lời từ formData

                        if (!selected) {
                            hasUnanswered = true;
                            alert(`Câu hỏi "${q.content}" chưa được trả lời.`);
                        } else {
                            // Lưu dữ liệu trả lời vào answers
                            answers[q.question_id] = {
                                question_id: q.question_id, // ID câu hỏi
                                answer_content: selected // Nội dung câu trả lời
                            };
                        }
                    });

                    if (hasUnanswered) return;

                    // Gửi yêu cầu nộp bài
                    const response = await fetch('/api/student/submit-answers', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            student_id: studentId,
                            exam_id: data.exam_id || null,
                            assignment_id: data.assignment_id || null,
                            answers
                        })
                    });

                    const responseText = await response.text();
                    console.log('Response Text:', responseText);

                    if (response.ok) {
                        try {
                            const result = JSON.parse(responseText);
                            successMsg.classList.remove('d-none');
                            successMsg.innerText = result.message || "Nộp bài thành công!";
                            quizContainer.classList.add('d-none');
                            window.location.href = '/classDetail';
                        } catch (e) {
                            errorMsg.classList.remove('d-none');
                            errorMsg.innerText = "Lỗi xử lý phản hồi từ server.";
                        }
                    } else {
                        errorMsg.classList.remove('d-none');
                        errorMsg.innerText = responseText || "Đã xảy ra lỗi khi nộp bài.";
                    }
                });

            } catch (err) {
                console.error(err);
                loadingEl.classList.add('d-none');
                errorMsg.classList.remove('d-none');
                errorMsg.innerText = "Không thể tải dữ liệu bài thi hoặc bài tập.";
            }
        });
    </script>
@endsection
