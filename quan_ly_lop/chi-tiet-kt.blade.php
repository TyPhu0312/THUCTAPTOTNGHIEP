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
    .not-complete {
        color: #e9182d;
        font-weight: bold;
        text-align: right;
    }
    .status_course {
        text-align: right;
        font-size: 1em;
        font-weight: bold;
    }
    .exam-time-info {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 5px;
        margin: 20px 0;
    }
    .time-arrow {
        margin: 0 10px;
        font-size: 20px;
    }
    .exam-content {
        display: flex;
        gap: 20px;
    }
    .exam-instructions {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        flex: 2;
    }
    .exam-attachments {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        flex: 1;
        text-align: center;
        border: 1px dashed #ccc;
    }
    .exam-attachments button {
        display: block;
        width: 100%;
        margin: 5px 0;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: left;
    }
    .div_button_start {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .start-exam {
        padding: 12px 40px;
        background-color: #292c29;
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
            Lớp của tôi / <?php $courseName ?> / <?php $examTitle ?>
        </div>
        <div class="not-complete"><?php $examStatus ?></div>
    </div>
    <div class="header">
        <div>
            <div>Môn học: <strong><?php $courseName ?></strong></div>
            <div>Giảng viên: <strong><?php $teacherName ?></strong></div>
        </div>
        <div class="status_course"><?php $completedExams ?>/<?php $totalExams ?></div>
    </div>
    <div class="exam-time-info">
        <div><strong>Start:</strong> <?php $startTime ?></div>
        <div class="time-arrow">→</div>
        <div><strong>End:</strong> <?php $endTime ?></div>
    </div>
    <h2>Thi học kỳ môn <?php $examTitle ?></h2>
    <div class="exam-content">
        <div class="exam-instructions">
            <h3>Thông tin bài thi:</h3>
            <p>Hình thức: <?php $examType ?></p>
            <p>Thời gian: <?php $examDuration ?> phút</p>
            <p><?php $examNotes ?></p>
        </div>
        <div class="exam-attachments">
            <h3>TÀI LIỆU ÔN THI</h3>
            @foreach($examMaterials as $material)
                <button><?php $material ?></button>
            @endforeach
        </div>
    </div>
    <div class="div_button_start">
        <a href="<?php $examLink ?>" class="start-exam">START</a>
    </div>
</div>
@endsection
    