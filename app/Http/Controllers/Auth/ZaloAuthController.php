<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ZaloAuthController extends Controller
{
    // Chuyển hướng người dùng đến Zalo để đăng nhập
    public function redirectToZalo()
    {
        $zaloAuthUrl = "https://oauth.zaloapp.com/v4/permission?"
            . "app_id=" . config('services.zalo.client_id')
            . "&redirect_uri=" . urlencode(config('services.zalo.redirect'))
            . "&state=your_random_string";
        return redirect()->away($zaloAuthUrl);
    }

    // Xử lý callback từ Zalo
    public function handleZaloCallback(Request $request)
    {
        $code = $request->query('code');
        if (!$code) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Lấy access token từ Zalo
        $response = Http::asForm()->post('https://oauth.zaloapp.com/v4/access_token', [
            'app_id' => config('services.zalo.client_id'),
            'app_secret' => config('services.zalo.client_secret'),
            'code' => $code,
            'redirect_uri' => config('services.zalo.redirect'),
        ]);

        $tokenData = $response->json();
        if (!isset($tokenData['access_token'])) {
            return response()->json(['error' => 'Invalid Token'], 401);
        }

        $accessToken = $tokenData['access_token'];

        // Lấy thông tin user từ Zalo
        $userResponse = Http::withHeaders([
            'access_token' => $accessToken,
        ])->get('https://graph.zalo.me/v2.0/me?fields=id,name,picture');

        $zaloUser = $userResponse->json();

        // Tìm hoặc tạo mới user trong hệ thống
        $user = User::updateOrCreate(
            ['zalo_id' => $zaloUser['id']],
            [
                'name' => $zaloUser['name'],
                'email' => $zaloUser['id'] . '@zalo.com',
                'password' => bcrypt('password'), // Tạo password ngẫu nhiên
            ]
        );

        // Đăng nhập user vào hệ thống
        Auth::login($user);

        return response()->json([
            'token' => $user->createToken('ZaloLogin')->plainTextToken,
            'user' => $user,
        ]);
    }
}