<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
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

// Route công khai
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes xác thực
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

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
    Route::get('/list-questions/{course_id}/{lecturer_id}', [ListQuestionController::class, 'showListQuestionForLecturer']);
    // Trong routes/api.php
    Route::get('/list-questions/{id}', [ListQuestionController::class, 'show']);
    Route::get('/list-questions', [ListQuestionController::class, 'index']);
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']);

    // API tạo và quản lý câu hỏi
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']);

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
});
Route::post('/api/list-questions', [ListQuestionController::class, 'storeFromWeb'])->middleware('web');
Route::get('/list-questions', [ListQuestionController::class, 'index']);


