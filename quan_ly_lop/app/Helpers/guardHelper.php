<?php
if (!function_exists('getLoggedInUser')) {
    function getLoggedInUser()
    {
        // Kiểm tra người dùng là sinh viên
        if (Auth::guard('students')->check()) {
            return Auth::guard('students')->user();
        }

        // Kiểm tra người dùng là giảng viên
        if (Auth::guard('lecturer')->check()) {
            return Auth::guard('lecturer')->user();
        }

        // Nếu không có người dùng, trả về null
        return null;
    }
}


?>
