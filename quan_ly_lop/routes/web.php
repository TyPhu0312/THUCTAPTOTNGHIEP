<?php

use App\Http\Controllers\LecturerDashboardController;
use App\Http\Controllers\LecturerStudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MyClassController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ListQuestionController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Collection;


// Route công khai
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes xác thực
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::get('/submission/show', [SubmissionController::class, 'show'])->name('submissions.show');

// Routes yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/myclass', [MyClassController::class, 'index'])->name('myclass');
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/todopage', [AssignmentController::class, 'index'])->name('todopage');
    Route::get('/todopage', [ExamController::class, 'index'])->name('todopage');
    Route::get('/createQuestion', [ListQuestionController::class, 'index'])->name('createQuestion');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::get('/my-classes', [MyClassController::class, 'index'])->name('my-classes');
    Route::get('/class/{class_code}', [ClassroomController::class, 'show'])->name('classroom.show');
    Route::post('/class/join/{class_code}', [ClassroomController::class, 'join'])->name('classroom.join');
    Route::get('/export-pdf/{course_id}', [PDFController::class, 'exportScores']);

    // API tạo và quản lý danh sách câu hỏi
    Route::post('/list-questions/create', [ListQuestionController::class, 'storeFromWeb']);
    Route::get('/list-questions/{id}', [ListQuestionController::class, 'show']);
    Route::get('/list-questions', [ListQuestionController::class, 'index']);
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']);
    Route::post('/api/list-questions', [ListQuestionController::class, 'storeFromWeb'])->middleware('web');
    Route::get('/list-questions/{id}/detail', [ListQuestionController::class, 'chi_tiet_bo_cau_hoi']);
    // API tạo và quản lý câu hỏi
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']);
    Route::delete('/api/questions/{id}', [QuestionController::class, 'destroy']);
    // API quản lý lựa chọn (options)
    Route::get('/questions/{questionId}/options', [OptionsController::class, 'index']);
    Route::post('/questions/{questionId}/options', [OptionsController::class, 'store']);
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');

    // API quản lý bài thi
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exams.show');
    // API quản lý bài tập
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');

    // Submission routes
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
});
Route::post('/api/list-questions', [ListQuestionController::class, 'storeFromWeb'])->middleware('web');
Route::get('/submissions/list/{type}/{target_id}', [App\Http\Controllers\StudentAssignmentController::class, 'listSubmissions'])
    ->name('submissions.list');
// In routes/web.php



Route::get('/classDetail', function () {
    return view('show_class'); // Tạo view student-classes.blade.php
});
Route::get('/getCourseOfStudent/{student_id}', [CourseController::class, 'showCourseOfStudent'])->name('showCourseOfStudent');


//lecturer
Route::get('/lecturer/chi_tiet_bo_cau_hoi/{list_question_id}', function ($list_question_id) {
    return view('lecturerViews.chi_tiet_bo_cau_hoi', [
        'list_question_id' => $list_question_id,
    ]);
})->name('viewListQuestionDetail');
Route::get('/list-questions', [ListQuestionController::class, 'index']);

Route::prefix('lecturer')->group(function () {
    Route::get('/dashboard', [LecturerDashboardController::class, 'index'])->name('lecturer.dashboard');
    Route::get('/exams/{examId}', [LecturerDashboardController::class, 'examDetail'])->name('lecturer.exam.detail');
    Route::get('/assignments/{assignmentId}', [LecturerDashboardController::class, 'assignmentDetail'])->name('lecturer.assignment.detail');
});