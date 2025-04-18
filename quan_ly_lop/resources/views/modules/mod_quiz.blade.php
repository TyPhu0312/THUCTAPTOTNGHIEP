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

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const urlParams = new URLSearchParams(window.location.search);
        const examId = urlParams.get('id');
        const apiUrl = `/api/exams/getById/${examId}`; 
        console.log("aa",examId);

        const loadingEl = document.getElementById('loading');
        const quizContainer = document.getElementById('quiz-container');
        const errorMsg = document.getElementById('error-msg');
        const successMsg = document.getElementById('success-msg');
        const questionContainer = document.getElementById('quiz-questions');
        const quizTitle = document.getElementById('quiz-title');

        try {
            loadingEl.classList.remove('d-none');

            const res = await fetch(apiUrl);
            const exam = await res.json();

            loadingEl.classList.add('d-none');

            if (!exam || exam.type !== "Trắc nghiệm") {
                errorMsg.classList.remove('d-none');
                errorMsg.innerText = "Loại bài không hợp lệ hoặc không tìm thấy!";
                return;
            }

            quizTitle.textContent = exam.title;
            quizContainer.classList.remove('d-none');

            const questions = exam.questions || [];

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

            document.getElementById('quiz-form').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const answers = {};
                let hasUnanswered = false;

                questions.forEach(q => {
                    const selected = formData.get(`answers[${q.question_id}]`);
                    if (!selected) {
                        hasUnanswered = true;
                        alert(`Câu hỏi "${q.content}" chưa được trả lời.`);
                    }
                });

                if (hasUnanswered) return;

                for (let [key, value] of formData.entries()) {
                    const match = key.match(/^answers\[(.+)\]$/);
                    if (match) {
                        const questionId = match[1];
                        answers[questionId] = value;
                    }
                }

                const response = await fetch(`/api/quizzes/submit/${examId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ answers })
                });

                const result = await response.json();

                if (response.ok) {
                    successMsg.classList.remove('d-none');
                    successMsg.innerText = "Nộp bài thành công!";
                    quizContainer.classList.add('d-none');
                } else {
                    errorMsg.classList.remove('d-none');
                    errorMsg.innerText = result.message || "Đã xảy ra lỗi khi nộp bài.";
                }
            });

        } catch (err) {
            console.error(err);
            loadingEl.classList.add('d-none');
            errorMsg.classList.remove('d-none');
            errorMsg.innerText = "Không thể tải dữ liệu bài thi.";
        }
    });
</script>
@endsection
