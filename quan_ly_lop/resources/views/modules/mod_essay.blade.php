@section('main-content')
    <div class="container mt-5">
        <!-- Loading indicator -->
        <div id="loading" class="text-center">Đang tải...</div>

        <div id="assay-container" class="card shadow-lg rounded d-none">
            <div class="card-body">
                <h3 id="assay-title" class="card-title text-center mb-4"></h3>

                <form id="assay-form">
                    @csrf
                    <div id="assay-questions"></div>

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
            const assayContainer = document.getElementById('assay-container');
            const errorMsg = document.getElementById('error-msg');
            const successMsg = document.getElementById('success-msg');
            const questionContainer = document.getElementById('assay-questions');
            const assayTitle = document.getElementById('assay-title');

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
                console.log(data);
                loadingEl.classList.add('d-none');

                if (!data) {
                    errorMsg.classList.remove('d-none');
                    errorMsg.innerText = "Không tìm thấy bài thi hoặc bài tập!";
                    return;
                }
                console.log(data.exam_id,data.assignment_id);
                assayTitle.textContent = data.title;
                assayContainer.classList.remove('d-none');

                const questions = data.questions || [];

                questions.forEach((q, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('mb-4');

                    const questionHtml = `
                        <p><strong>Câu ${index + 1}:</strong> ${q.content}</p>
                        <textarea name="answers[${q.question_id}]" class="form-control" rows="4" placeholder="Nhập câu trả lời..."></textarea>
                    `;

                    wrapper.innerHTML = questionHtml;
                    questionContainer.appendChild(wrapper);
                });

                // Xử lý submit bài
                document.getElementById('assay-form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    let hasUnanswered = false;
                    const answers = {};

                    // Thu thập dữ liệu câu trả lời
                    questions.forEach(q => {
                        const answer = formData.get(`answers[${q.question_id}]`);

                        if (!answer || !answer.trim()) {
                            hasUnanswered = true;
                            alert(`Câu hỏi "${q.content}" chưa được trả lời.`);
                        } else {
                            answers[q.question_id] = {
                                question_id: q.question_id,
                                answer_content: answer.trim()
                            };
                        }
                    });

                    if (hasUnanswered) return;



                    // Kiểm tra xem bài thi hay bài tập được chọn
                    if (!data.exam_id && !data.assignment_id) {
                        errorMsg.classList.remove('d-none');
                        errorMsg.innerText = "Bạn phải chọn hoăc bài thi hoặc bài tập!";
                        return;
                    }

                    // Gửi yêu cầu nộp bài
                    const response = await fetch('/api/student/submit-answers', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            student_id: studentId,
                            exam_id: data.exam_id ||
                            null, // Gửi exam_id nếu có, nếu không thì null
                            assignment_id: data.assignment_id ||
                            null, // Gửi assignment_id nếu có, nếu không thì null
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
                            assayContainer.classList.add('d-none');
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
