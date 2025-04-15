<div style="flex: 1 0 250px; max-width: 300px;">
    <div class="card custom-card border-0 d-flex flex-column">
        <img src="{{ $image }}" alt="{{ $title }}" class="card-img-top"
            style="object-fit: cover; height: 160px; width: 100%;">

        <div class="card-body d-flex flex-column flex-grow-1">
            <p class="card-author">{{ $author }}</p>
            <h5 class="card-title">{{ $title }}</h5>
            <h7 class="card-title">{{ $classroom ?? 'Không xác định' }}</h7>

            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-center card-footer">
                    <span>Joined: </span>
                    <span>{{ $date }}</span>
                </div>

                <div class="btn-container mt-2 w-auto">
                    <a href="#" class="btn btn-outline-dark btn-truycap custom-btn w-100">Truy cập</a>
                </div>
            </div>
        </div>
    </div>
</div>
