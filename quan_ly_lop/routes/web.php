<?php

use App\Http\Controllers\LecturerDashboardController;
use App\Http\Controllers\LecturerStudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MyClassController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ListQuestionController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\StudentAssignmentController;

// ========== ROUTE CÔNG KHAI ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/public-demo', function () {
    $submissions = collect([
        (object) [
            'submission_id' => '1',
            'student' => (object) ['name' => 'Nguyễn Văn A', 'student_code' => 'SV001'],
            'created_at' => '2025-04-10 14:30:00',
            'file_path' => 'submissions/bai_nop_1.pdf',
            'status' => 'submitted',
            'temporary_score' => null
        ],
        (object) [
            'submission_id' => '2',
            'student' => (object) ['name' => 'Trần Thị B', 'student_code' => 'SV002'],
            'created_at' => '2025-04-10 15:00:00',
            'file_path' => 'submissions/bai_nop_2.pdf',
            'status' => 'submitted',
            'temporary_score' => 8.5
        ],
    ]);
    $assignment = (object) ['assignment_id' => '123', 'title' => 'Bài tập cuối kỳ môn Lập trình Web'];
    return view('submissions.demo', ['submissions' => $submissions, 'assignment' => $assignment, 'exam_id' => null]);
});
Route::get('/classDetail', function () {
    return view('show_class');
});
Route::get('/getCourseOfStudent/{student_id}', [CourseController::class, 'showCourseOfStudent'])->name('showCourseOfStudent');

// ========== ROUTE CHO GUEST ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('Showlogin');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::get('/submission/show', [SubmissionController::class, 'show'])->name('submissions.show');

// ========== ROUTE SAU KHI ĐĂNG NHẬP ==========
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Trang home sau khi đăng nhập
    Route::get('/home', [HomeController::class, 'index'])->middleware('auth:students')->name('homeLoggedIn');
    Route::get('/homeLecturer', [HomeController::class, 'indexLecturer'])->middleware('auth:lecturer')->name('homeLecturer');

    // Profile
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/profile', fn() => view('profile'))->name('profile');

    // Lớp học
    Route::get('/myclass', [MyClassController::class, 'index'])->name('myclass');
    Route::get('/my-classes', [MyClassController::class, 'index'])->name('my-classes');
    Route::get('/class/{class_code}', [ClassroomController::class, 'show'])->name('classroom.show');
    Route::post('/class/join/{class_code}', [ClassroomController::class, 'join'])->name('classroom.join');

    // Xuất PDF
    Route::get('/export-pdf/{course_id}', [PDFController::class, 'exportScores']);

    // Hoàn thành bài thi
    Route::get('/hoanthanh', fn() => view('hoanthanh', [
        'courseName' => 'Lập trình Web',
        'examTitle' => 'Bài kiểm tra giữa kỳ',
        'teacherName' => 'Nguyễn Văn A',
        'completedExams' => 5,
        'totalExams' => 5,
        'examScore' => 8.5,
        'examTime' => '45 phút',
        'completionTime' => '10:30 12/04/2025',
        'homeLink' => route('home'),
    ]))->name('hoanthanh');

    // Danh sách câu hỏi
    Route::get('/createQuestion', [ListQuestionController::class, 'index'])->name('createQuestion');
    Route::get('/list-questions', [ListQuestionController::class, 'index']);
    Route::get('/list-questions/{id}', [ListQuestionController::class, 'show']);
    Route::get('/list-questions/{id}/detail', [ListQuestionController::class, 'chi_tiet_bo_cau_hoi']);
    Route::post('/list-questions/create', [ListQuestionController::class, 'storeFromWeb']);
    Route::post('/api/list-questions', [ListQuestionController::class, 'storeFromWeb'])->middleware('web');

    // Câu hỏi
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']);
    Route::delete('/api/questions/{id}', [QuestionController::class, 'destroy']);
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');

    // Tuỳ chọn câu hỏi
    Route::get('/questions/{questionId}/options', [OptionsController::class, 'index']);
    Route::post('/questions/{questionId}/options', [OptionsController::class, 'store']);

    // Bài thi
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exams.show');

    // Bài tập
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');

    // To-do page (bài tập và bài thi)
    Route::get('/todopage', [AssignmentController::class, 'index'])->name('todopage');
    Route::get('/todopage', [ExamController::class, 'index'])->name('todopage');

    // Nộp bài
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
});

// ========== ROUTE DÀNH RIÊNG CHO GIẢNG VIÊN ==========
Route::middleware('auth:lecturer')->group(function () {
    Route::get('/homeLecturer', [HomeController::class, 'index'])->name('homeLecturer');
    Route::get('/lecturer/chi_tiet_bo_cau_hoi/{list_question_id}', function ($list_question_id) {
        return view('lecturerViews.chi_tiet_bo_cau_hoi', ['list_question_id' => $list_question_id]);
    })->name('viewListQuestionDetail');

});

// ========== ROUTE PHỤ: DÙNG NỘI BỘ ==========
Route::get('/submissions/list/{type}/{target_id}', [StudentAssignmentController::class, 'listSubmissions'])->name('submissions.list');

Route::prefix('lecturer')->group(function () {
    Route::get('/dashboard', [LecturerDashboardController::class, 'index'])->name('lecturer.dashboard');
    Route::get('/exams/{examId}', [LecturerDashboardController::class, 'examDetail'])->name('lecturer.exam.detail');
    Route::get('/assignments/{assignmentId}', [LecturerDashboardController::class, 'assignmentDetail'])->name('lecturer.assignment.detail');
});