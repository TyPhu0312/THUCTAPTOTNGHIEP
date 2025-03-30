@props(['image', 'title', 'description', 'author', 'student', 'date', 'status' => null, 'class_code' => null, 'final_score' => null])

<div class="card h-100" style="width: 18rem;">
    <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}" style="height: 200px; object-fit: cover;">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <p class="card-author mb-0">{{ $author }}</p>
            @if($status)
                <span class="badge {{ $status == 'Active' ? 'bg-success' : ($status == 'Completed' ? 'bg-secondary' : 'bg-warning') }}">
                    {{ $status }}
                </span>
            @endif
        </div>
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text">{{ $description }}</p>
        
        @if($class_code)
            <p class="text-muted small mb-2">Mã lớp: {{ $class_code }}</p>
        @endif
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">{{ $student }}</small>
            <small class="text-muted">{{ $date }}</small>
        </div>

        @if($final_score !== null)
            <div class="mb-3">
                <p class="mb-1">Điểm số: {{ $final_score }}/10</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ ($final_score/10)*100 }}%" 
                         aria-valuenow="{{ $final_score }}" 
                         aria-valuemin="0" 
                         aria-valuemax="10">
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-3">
            @if($status == 'Active')
                <a href="#" class="btn btn-primary w-100">Vào học</a>
            @elseif($status == 'Completed')
                <a href="#" class="btn btn-secondary w-100">Xem lại</a>
            @else
                <a href="#" class="btn btn-outline-primary w-100">Tham gia</a>
            @endif
        </div>
    </div>
</div>
