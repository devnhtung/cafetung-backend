<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentRoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        // Bỏ qua kiểm tra role với các route login, forgot-password, register của Filament
        if (preg_match('#^admin/(login|forgot-password|register|profile)#', $path)) {
            return $next($request);
        }

        $user = $request->user();
        // Nếu chưa đăng nhập, chuyển hướng sang trang login
        if (!$user) {
            return redirect('/admin/login');
        }
        // Nếu đã đăng nhập, kiểm tra quyền
        if (in_array($user->role, ['admin', 'manager']) || (method_exists($user, 'hasRole') && ($user->hasRole('admin') || $user->hasRole('manager')))) {
            return $next($request);
        }
        // Nếu không phải admin/manager, chuyển hướng sang trang profile
        return redirect('/admin/profile');
    }
}
