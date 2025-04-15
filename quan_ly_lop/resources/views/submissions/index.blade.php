@extends('templates.template_normal')

@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Submissions for {{ $type === 'assignment' ? 'Assignment' : 'Exam' }}: {{ $item->title }}</h3>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Submission Time</th>
                                        <th>Answer File</th>
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submissions as $submission)
                                        <tr>
                                            <td>{{ $submission->student->full_name }}</td>
                                            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if ($submission->answer_file)
                                                    <a href="{{ asset('storage/' . $submission->answer_file) }}"
                                                        target="_blank">
                                                        View File
                                                    </a>
                                                @else
                                                    No file
                                                @endif
                                            </td>
                                            <td>{{ $submission->temporary_score ?? 'Not graded' }}</td>
                                            <td>
                                                @if ($submission->is_late)
                                                    <span class="badge bg-danger">Late</span>
                                                @else
                                                    <span class="badge bg-success">On time</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('submissions.show', $submission) }}"
                                                    class="btn btn-sm btn-info">
                                                    View Details
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#gradeModal{{ $submission->submission_id }}">
                                                    Grade
                                                </button>
                                            </td>
                                        </tr>

                                         Grade Modal
                                        <div class="modal fade" id="gradeModal{{ $submission->submission_id }}"
                                            tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Grade Submission</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('submissions.grade', $submission) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="score" class="form-label">Score</label>
                                                                <input type="number" class="form-control" id="score"
                                                                    name="temporary_score" min="0" max="10"
                                                                    step="0.5"
                                                                    value="{{ $submission->temporary_score }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Grade</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
