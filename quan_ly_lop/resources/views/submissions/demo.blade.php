<!-- @extends('layouts.app') -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>
                            @if($type === 'assignment')
                                Bài nộp cho Bài tập: {{ $item->title }}
                            @else
                                Bài nộp cho Bài kiểm tra: {{ $item->title }}
                            @endif
                        </h4>
                        <p class="text-muted mb-0">
                            Hạn nộp: {{ $item->due_date ? date('d/m/Y H:i', strtotime($item->due_date)) : 'Không có' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ $type === 'assignment' ? route('assignments.show', $item->id) : route('exams.show', $item->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã học sinh</th>
                                    <th>Tên học sinh</th>
                                    <th>Thời gian nộp</th>
                                    <th>Tập tin</th>
                                    <th>Điểm tạm thời</th>
                                    <th>Tình trạng</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                    <tr>
                                        <td>{{ $submission->student->student_id }}</td>
                                        <td>{{ $submission->student->name }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($submission->created_at)) }}</td>
                                        <td>
                                            @if($submission->answer_file)
                                                <a href="{{ Storage::url($submission->answer_file) }}" target="_blank">
                                                    <i class="fas fa-file-download"></i> Tải xuống
                                                </a>
                                            @else
                                                <span class="text-muted">Không có tập tin</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->temporary_score !== null)
                                                {{ $submission->temporary_score }}
                                            @else
                                                <span class="text-muted">Chưa chấm</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($submission->is_late)
                                                <span class="badge bg-warning">Nộp muộn</span>
                                            @else
                                                <span class="badge bg-success">Đúng hạn</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scoreModal{{ $submission->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $submission->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Modal chấm điểm -->
                                            <div class="modal fade" id="scoreModal{{ $submission->id }}" tabindex="-1" aria-labelledby="scoreModalLabel{{ $submission->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scoreModalLabel{{ $submission->id }}">Chấm điểm bài nộp của {{ $submission->student->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="scoreForm{{ $submission->id }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="temporary_score" class="form-label">Điểm (0-100)</label>
                                                                    <input type="number" class="form-control" id="temporary_score" name="temporary_score" min="0" max="100" value="{{ $submission->temporary_score }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-primary" onclick="updateScore('{{ $submission->id }}')">Lưu điểm</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Chưa có bài nộp nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateScore(id) {
    const scoreForm = document.getElementById(`scoreForm${id}`);
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
        // Đóng modal
        const modal = bootstrap.Modal.getInstance(document.getElementById(`scoreModal${id}`));
        modal.hide();
        
        // Hiển thị thông báo thành công
        alert('Cập nhật điểm thành công!');
        
        // Làm mới trang
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật điểm');
    });
}

    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa bài nộp này?')) {
            fetch(`/api/submissions/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa bài nộp');
            });
        }
    }
</script>
@endsection