@section('main-content')
<div class="container mt-5">
    <div id="assignment-container" class="card shadow-lg rounded d-none">
        <div class="card-body">
            <h3 id="assignment-title" class="card-title text-center mb-4"></h3>

            <div id="questions-container" class="mb-3"></div>

            <form id="assignment-form" method="POST">
                @csrf
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Nộp bài</button>
                </div>
            </form>
        </div>
    </div>

    <div id="error-msg" class="alert alert-danger d-none"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const urlParams = new URLSearchParams(window.location.search);
        const assignmentId = urlParams.get('id');

        try {
            const res = await fetch(`/api/assignments/getById/${assignmentId}`);
            const assignment = await res.json();

            if (!assignment || assignment.type !== "Tự luận" && assignment.type !== "Trắc nghiệm") {
                document.getElementById('error-msg').classList.remove('d-none');
                document.getElementById('error-msg').innerText = "Loại bài không hợp lệ hoặc không tìm thấy!";
                return;
            }

            document.getElementById('assignment-title').textContent = assignment.title;

            const questionsContainer = document.getElementById('questions-container');
            assignment.questions.forEach((question, index) => {
                const questionElement = document.createElement('div');
                questionElement.classList.add('mb-3');

                const questionContent = document.createElement('div');
                questionContent.classList.add('fw-bold');
                questionContent.textContent = `Câu hỏi ${index + 1}: ${question.content}`;
                questionElement.appendChild(questionContent);

                if (question.choices && question.choices.length) {
                    const choicesList = document.createElement('ul');
                    question.choices.forEach(choice => {
                        const listItem = document.createElement('li');
                        listItem.textContent = choice;
                        choicesList.appendChild(listItem);
                    });
                    questionElement.appendChild(choicesList);
                } else {
                    const answerInput = document.createElement('textarea');
                    answerInput.name = `answer_${question.question_id}`;
                    answerInput.rows = 3;
                    answerInput.classList.add('form-control');
                    questionElement.appendChild(answerInput);
                }

                questionsContainer.appendChild(questionElement);
            });

            document.getElementById('assignment-container').classList.remove('d-none');

            // Gán action submit
            const form = document.getElementById('assignment-form');
            form.action = `/api/essays/submit/${assignmentId}`;
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const answers = {};
                assignment.questions.forEach((question) => {
                    const answerInput = document.querySelector(`[name="answer_${question.question_id}"]`);
                    if (answerInput) {
                        answers[question.question_id] = answerInput.value;
                    }
                });

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ answers }),
                });

                const result = await response.json();

                if (response.ok) {
                    alert("Nộp bài thành công!");
                    form.reset();
                } else {
                    alert(result.message || "Đã xảy ra lỗi khi nộp bài.");
                }
            });

        } catch (err) {
            console.error(err);
            document.getElementById('error-msg').classList.remove('d-none');
            document.getElementById('error-msg').innerText = "Không thể tải dữ liệu bài tập.";
        }
    });
</script>
@endsection
