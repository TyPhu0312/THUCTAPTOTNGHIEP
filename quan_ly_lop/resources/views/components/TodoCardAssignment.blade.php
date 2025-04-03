<!-- resources/views/components/todo_card_assignment.blade.php -->
@props([
    'assignment_id',
    'sub_list_id',
    'title',
    'content',
    'type',
    'isSimultanenous',
    'start_time',
    'end_time',
    'show_result',
    'status'
])

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text">Assignment ID: {{ $assignment_id }}</p>
        <p class="card-text">Sublist ID: {{ $sub_list_id }}</p>
        <p class="card-text">Content: {{ $content }}</p>
        <p class="card-text">Type: {{ $type }}</p>
        <p class="card-text">Simultaneous: {{ $isSimultanenous ? 'Yes' : 'No' }}</p>
        <p class="card-text">Start Time: {{ $start_time }}</p>
        <p class="card-text">End Time: {{ $end_time }}</p>
        <p class="card-text">Show Result: {{ $show_result ? 'Yes' : 'No' }}</p>
        <p class="card-text">Status: {{ $status }}</p>
    </div>
</div>
