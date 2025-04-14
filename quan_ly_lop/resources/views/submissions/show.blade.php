<!-- @extends('layouts.app') -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Chi tiết bài nộp</h4>
                    <div>
                        @if($submission->assignment_id)
                            <a href="{{ route('submissions.index', ['type' => 'assignment', 'id' => $submission->assignment_id]) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách
                            </a>
                        @else
                            <a href="{{ route('submissions.index', ['type' => 'exam', 'id' => $submission->exam_id]) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Thông tin bài nộp</h5>
                            <table class="table">
                                <tr>
                                    <th>Loại bài:</th>
                                    <td>{{ $submission->assignment_id ? 'Bài tập' : 'Bài kiểm tra' }}</td>
                                </tr>
                                <tr>
                                    <th>Tiêu đề:</th>
                                    <td>
                                        @if($submission->assignment_id)
                                            {{ $submission->assignment->title ?? 'N/A' }}
                                        @else
                                            {{ $submission->exam->title ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Học sinh:</th>
                                    <td>{{ $submission->student->name }} ({{ $submission->student->student_id }})</td>
                                </tr>
                                <tr>
                                    <th>Thời gian nộp:</th>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($submission->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        @if($submission->is_late)
                                            <span class="badge bg-warning">Nộp muộn</span>
                                        @else
                                            <span class="badge bg-success">Đúng hạn</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Điểm tạm thời:</th>
                                    <td>
                                        @if($submission->temporary_score !== null)
                                            {{ $submission->temporary_score }}
                                        @else
                                            <span class="text-muted">Chưa chấm</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Tập tin đính kèm</h5>
                            @if($submission->answer_file)
                                <div class="d-flex flex-column align-items-center">
                                    <div class="file-icon mb-3">
                                        <i class="fas fa-file-alt fa-5x"></i>
                                    </div>
                                    <a href="{{ Storage::url($submission->answer_file) }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Không có tập tin đính kèm
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($submission->answers && count($submission->answers) > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Các câu trả lời</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Câu hỏi</th>
                                                <th>Câu trả lời</th>
                                                <th>Điểm</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($submission->answers as $answer)
                                                <tr>
                                                    <td>
                                                        @if($answer->question)
                                                            {!! $answer->question->content !!}
                                                        @else
                                                            <span class="text-muted">Câu hỏi không còn tồn tại</span>
                                                        @endif
                                                    </td>
                                                    <td>{!! $answer->content !!}</td>
                                                    <td>
                                                        @if($answer->score !== null)
                                                            {{ $answer->score }}
                                                        @else
                                                            <span class="text-muted">Chưa chấm</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Chấm điểm</h5>
                            <form id="scoreForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="temporary_score" class="form-label">Điểm (0-100)</label>
                                    <input type="number" class="form-control" id="temporary_score" name="temporary_score" min="0" max="100" value="{{ $submission->temporary_score }}">
                                </div>
                                <button type="button" class="btn btn-primary" onclick="updateScore('{{ $submission->id }}')">Lưu điểm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateScore(id) {
        const scoreForm = document.getElementById('scoreForm');
        const formData = new FormData(scoreForm);
        const score = formData.get('temporary_score');
        
        fetch(`/api/submissions/update/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                temporary_score: score
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Cập nhật điểm thành công!');
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật điểm');
        });
    }
</script>
@endsection