@extends('layouts.app')
<!-- 
@section('content')
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
@endsection -->
@extends('templates.template_lecture')
@section('title', isset($exam) ? 'Bài kiểm tra: ' . $exam->title : 'Bài tập: ' . $assignment->title)
@section('main-content')
    <div class="container mx-auto py-6 px-4">
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    @if(isset($exam))
                        <span class="text-blue-600">Bài kiểm tra:</span> {{ $exam->title }}
                    @else
                        <span class="text-green-600">Bài tập:</span> {{ $assignment->title }}
                    @endif
                </h1>
                <p class="text-gray-600 mt-1">
                    Thời hạn nộp: {{ isset($exam) ? $exam->end_time : $assignment->end_time ?? 'Chưa cập nhật' }}
                </p>
            </div>
           
            <div class="flex space-x-3">
                @if(isset($exam))
                <a href="{{ route('exams.show', $exam->exam_id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Chi tiết bài kiểm tra
                </a>
                @else
                <a href="{{ route('assignments.show', $assignment->assignment_id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Chi tiết bài tập
                </a>
                @endif
                
                <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại
                </a>
            </div>
        </div>
       
        <!-- Thông tin tổng quan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex items-center">
                    <div class="rounded-md bg-blue-100 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Số lượng bài nộp</p>
                        <p class="text-xl font-semibold">{{ $submissions->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex items-center">
                    <div class="rounded-md bg-green-100 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Đã chấm điểm</p>
                        <p class="text-xl font-semibold">
                            {{ $submissions->filter(function($s) { return isset($s->temporary_score); })->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex items-center">
                    <div class="rounded-md bg-yellow-100 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Nộp muộn</p>
                        <p class="text-xl font-semibold">
                            {{ $submissions->where('status', 'late')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Module danh sách bài nộp -->
        @include('modules.mod_submissions_list', [
            'submissions' => $submissions ?? collect([]),
            'exam_id' => $exam->exam_id ?? null,
            'assignment_id' => $assignment->assignment_id ?? null
        ])
        
        <!-- Chức năng xuất dữ liệu -->
        @if($submissions->count() > 0)
        <div class="mt-6 flex justify-end">
            <button id="export-btn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Xuất Excel
            </button>
        </div>
        @endif
    </div>
    
    <script>
        // Script for export functionality (placeholder)
        document.addEventListener('DOMContentLoaded', function() {
            const exportBtn = document.getElementById('export-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    alert('Chức năng xuất Excel đang được phát triển');
                });
            }
        });
    </script>
@endsection