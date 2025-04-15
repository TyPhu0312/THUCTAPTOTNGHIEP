<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard('students')->check()) {
            return redirect()->route('homeLoggedIn');  // Kiểm tra nếu đã đăng nhập
        }
        if (Auth::guard('lecturer')->check()) {
            return redirect()->route('homeLoggedIn');  // Kiểm tra nếu đã đăng nhập
        }
    }

    return $next($request);
}

}
