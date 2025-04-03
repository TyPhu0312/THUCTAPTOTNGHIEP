<!-- resources/views/components/todo_card_exam.blade.php -->
@props([
    'exam_id',
    'sublist_id',
    'title',
    'content',
    'type',
    'isSimultanenous',
    'start_time',
    'end_time',
    'status'
])

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text">Exam ID: {{ $exam_id }}</p>
        <p class="card-text">Sublist ID: {{ $sublist_id }}</p>
        <p class="card-text">Content: {{ $content }}</p>
        <p class="card-text">Type: {{ $type }}</p>
        <p class="card-text">Simultaneous: {{ $isSimultanenous ? 'Yes' : 'No' }}</p>
        <p class="card-text">Start Time: {{ $start_time }}</p>
        <p class="card-text">End Time: {{ $end_time }}</p>
        <p class="card-text">Status: {{ $status }}</p>
    </div>
</div>

<style>
/* Card Exam */
/* Card Exam */
.card.mb-3 {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card.mb-3:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.card-text {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 8px;
}

.card-text p {
    margin-bottom: 8px;
}

.card-text i {
    color: #007bff;
    margin-right: 5px;
}

/* Custom styling for different elements inside card */
.card-text span {
    font-weight: 500;
    color: #333;
}

/* Status color */
.card-text .status {
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 12px;
    color: white;
    background-color: #6c757d;
}

.card-text .status.active {
    background-color: #28a745;
}

.card-text .status.pending {
    background-color: #ffc107;
}

.card-text .status.completed {
    background-color: #007bff;
}

/* Simultaneous badge */
.card-text .simultaneous {
    background-color: #f8f9fa;
    color: #007bff;
    padding: 3px 8px;
    border-radius: 12px;
    font-weight: bold;
}

/* Time and other info */
.card-text .time-info {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #495057;
}

.card-text .time-info p {
    margin-bottom: 0;
}

.card-text .time-info .start-time {
    font-weight: 600;
    color: #007bff;
}

.card-text .time-info .end-time {
    font-weight: 600;
    color: #dc3545;
}

.card-text .card-footer {
    text-align: center;
    margin-top: 20px;
}

.card-footer a {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.card-footer a:hover {
    background-color: #0056b3;
}

</style>
