<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student_code' => 'required|string|unique:student,student_code',
                'full_name' => 'required|string',
                'school_email' => 'required|email|unique:student,school_email',
                'phone' => 'required|string|unique:student,phone',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'student_code.unique' => 'Mã số sinh viên đã tồn tại',
                'school_email.unique' => 'Email trường đã được sử dụng',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            ]);

            $student = Student::create([
                'student_code' => $validatedData['student_code'],
                'full_name' => $validatedData['full_name'],
                'school_email' => $validatedData['school_email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Đăng nhập thủ công
            Auth::login($student);

            return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
        } catch (\Exception $e) {
            \Log::error('Register error: ' . $e->getMessage());
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.']);
        }
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
} 