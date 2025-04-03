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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
    Route::get('/todopage', function () {
        return view('todopage');
    })->name('todopage');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::get('/my-classes', [MyClassController::class, 'index'])->name('my-classes');
    Route::get('/class/{class_code}', [ClassroomController::class, 'show'])->name('classroom.show');
    Route::post('/class/join/{class_code}', [ClassroomController::class, 'join'])->name('classroom.join');
    Route::get('/export-pdf/{course_id}', [PDFController::class, 'exportScores']);
    Route::get('/createQuestion', [ListQuestionController::class, 'index'])->name('createQuestion');
    // Routes tạo câu hỏi cho giảng viên
    // API tạo và quản lý danh sách câu hỏi
    Route::post('/list-questions', [ListQuestionController::class, 'store']);
    Route::get('/list-questions/{id}', [ListQuestionController::class, 'show']);
    Route::get('/list-questions', [ListQuestionController::class, 'index']);

    // API quản lý câu hỏi
    Route::post('/questions/batch', [QuestionController::class, 'storeBatch']); // API mới để lưu nhiều câu hỏi
    Route::resource('/questions', QuestionController::class);

    // API quản lý lựa chọn (options)
    Route::get('/questions/{questionId}/options', [OptionsController::class, 'index']);
    Route::post('/questions/{questionId}/options', [OptionsController::class, 'store']);
    Route::resource('/options', OptionsController::class);
});
Route::post('/api/list-questions', [ListQuestionController::class, 'storeFromWeb'])->middleware('web');

