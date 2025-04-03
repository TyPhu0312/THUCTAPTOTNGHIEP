@section('main-content')
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <h3>Upcoming Exams</h3>
                @php
                    $exams = [
                        (object) [
                            'exam_id' => '1',
                            'sublist_id' => '101',
                            'title' => 'Math Exam',
                            'content' => 'Algebra and Geometry',
                            'type' => 'Final',
                            'isSimultanenous' => 0,
                            'start_time' => '2025-04-10 09:00:00',
                            'end_time' => '2025-04-10 12:00:00',
                            'status' => 'Upcoming',
                        ],
                        (object) [
                            'exam_id' => '2',
                            'sublist_id' => '102',
                            'title' => 'Physics Exam',
                            'content' => 'Mechanics and Optics',
                            'type' => 'Midterm',
                            'isSimultanenous' => 1,
                            'start_time' => '2025-04-12 09:00:00',
                            'end_time' => '2025-04-12 12:00:00',
                            'status' => 'Upcoming',
                        ],
                    ];
                @endphp
                @foreach($exams as $exam)
                    <x-todo_card_exam :exam_id="$exam->exam_id" :sublist_id="$exam->sublist_id" :title="$exam->title"
                        :content="$exam->content" :type="$exam->type" :isSimultanenous="$exam->isSimultanenous"
                        :start_time="$exam->start_time" :end_time="$exam->end_time" :status="$exam->status" />
                @endforeach

            </div>

            <div class="col-md-6">
                <h3>Upcoming Assignments</h3>
                @php
                    $assignments = [
                        (object) [
                            'assignment_id' => '1',
                            'sub_list_id' => '201',
                            'title' => 'History Assignment',
                            'content' => 'Essay on Ancient Civilizations',
                            'type' => 'Homework',
                            'isSimultanenous' => 1,
                            'start_time' => '2025-04-05 08:00:00',
                            'end_time' => '2025-04-05 23:59:59',
                            'show_result' => true,
                            'status' => 'Pending',
                        ],
                        (object) [
                            'assignment_id' => '2',
                            'sub_list_id' => '202',
                            'title' => 'English Assignment',
                            'content' => 'Read and summarize chapters 1-5',
                            'type' => 'Homework',
                            'isSimultanenous' => 0,
                            'start_time' => '2025-04-07 08:00:00',
                            'end_time' => '2025-04-07 23:59:59',
                            'show_result' => true,
                            'status' => 'Pending',
                        ],
                    ];
                @endphp
                @foreach($assignments as $assignment)
                    <x-TodoCardAssignment :assignment_id="$assignment->assignment_id" :sub_list_id="$assignment->sub_list_id"
                        :title="$assignment->title" :content="$assignment->content" :type="$assignment->type"
                        :isSimultanenous="$assignment->isSimultanenous" :start_time="$assignment->start_time"
                        :end_time="$assignment->end_time" :show_result="$assignment->show_result"
                        :status="$assignment->status" />
                @endforeach

            </div>
        </div>
    </div>
@endsection
