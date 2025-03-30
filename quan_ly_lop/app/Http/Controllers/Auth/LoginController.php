<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'school_email' => 'required|email',
                'password' => 'required',
            ]);

            // Kiểm tra user tồn tại
            $student = Student::where('school_email', $request->school_email)->first();
            
            if (!$student) {
                \Log::info('Student not found with email: ' . $request->school_email);
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        'school_email' => 'Email không tồn tại trong hệ thống.',
                    ]);
            }

            // Kiểm tra mật khẩu trực tiếp
            if (!Hash::check($request->password, $student->password)) {
                \Log::info('Password incorrect for email: ' . $request->school_email);
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        'password' => 'Mật khẩu không chính xác.',
                    ]);
            }

            // Đăng nhập thủ công
            Auth::login($student, $request->filled('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended('/')
                ->with('success', 'Xin chào ' . $student->full_name . '!');

        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 