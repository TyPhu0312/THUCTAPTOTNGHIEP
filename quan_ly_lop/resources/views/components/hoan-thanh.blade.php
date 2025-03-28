@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }
    .exam-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 900px;
        margin: auto;
        padding: 20px;
        text-align: center;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 2px solid #ddd;
    }
    .course-info {
        color: #333;
        font-size: 1em;
        font-weight: bold;
    }
    .completed {
        color: #28a745;
        font-weight: bold;
        text-align: right;
    }
    .status_course {
        text-align: right;
        font-size: 1em;
        font-weight: bold;
    }
    .exam-result {
        margin: 20px 0;
        font-size: 1.2em;
        color: #155724;
        font-weight: bold;
    }
    .exam-details {
        text-align: center;
        margin: 20px 0;
    }
    .time-details {
        margin: 20px 0;
        font-size: 1.2em;
    }
    .time-item {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        font-size: 1.2em;
        font-weight: bold;
    }
    .time-value {
        color: #00008B;
    }
    .btn-home {
        padding: 12px 40px;
        background-color: #343a40;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
    }
</style>

<div class="exam-container">
    <div class="header">
        <div class="course-info">
            Lớp của tôi / {{ $courseName }} / <strong>{{ $examTitle }}</strong>
        </div>
        <div class="completed">COMPLETED</div>
    </div>
    <div class="header">
        <div>
            <div>Môn học: <strong>{{ $courseName }}</strong></div>
            <div>Giảng viên: <strong>{{ $teacherName }}</strong></div>
        </div>
        <div class="status_course">{{ $completedExams }}/{{ $totalExams }}</div>
    </div>
    <div class="exam-result">
        <h2>BẠN ĐÃ HOÀN THÀNH BÀI KIỂM TRA</h2>
        <p>Điểm tạm thời: <strong>{{ $examScore }}/10</strong></p>
    </div>
    <div class="exam-details">
        <div class="time-details">
            <div class="time-item">
                ⏳ Thời gian làm bài: <span class="time-value">{{ $examTime }}</span>
            </div>
            <div class="time-item">
                🕒 Thời gian hoàn thành: <span class="time-value">{{ $completionTime }}</span>
            </div>
        </div>
    </div>
    <div class="div_button_start">
        <a href="{{ $homeLink }}" class="btn-home">VỀ TRANG CHỦ</a>
    </div>
</div>
@endsection
