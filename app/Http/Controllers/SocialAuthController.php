<?php
// app/Http/Controllers/SocialAuthController.php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class SocialAuthController extends Controller
{
    // Đăng nhập bằng Facebook
    // public function redirectToFacebook()
    // {
    //     $redirectUrl = Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
    //     return response()->json(['redirectUrl' => $redirectUrl]);
    // }

    // public function handleFacebookCallback()
    // {
    //     $user = Socialite::driver('facebook')->stateless()->user();
    //     $userData = [
    //         'id' => $user->getId(),
    //         'name' => $user->getName(),
    //         'email' => $user->getEmail(),
    //         'avatar' => $user->getAvatar(),
    //     ];

    //     // Lưu user vào database nếu cần
    //     // ...

    //     // Chuyển hướng về frontend với thông tin người dùng
    //     return redirect("http://yourdomain.com/api/auth/callback?user=" . urlencode(json_encode($userData)));
    // }

    // Đăng nhập bằng Zalo
    public function redirectToZalo()
    {
        $zaloAuthUrl = "https://oauth.zaloapp.com/v4/permission?"
            . "app_id=" . config('services.zalo.client_id')
            . "&redirect_uri=" . urlencode(config('services.zalo.redirect'));
        return response()->json(['redirectUrl' => $zaloAuthUrl]);
    }

    // Trong handleZaloCallback
    public function handleZaloCallback()
    {
        $code = request()->input('code');
        $response = Http::get('https://oauth.zaloapp.com/v4/access_token', [
            'app_id' => env('ZALO_CLIENT_ID'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('ZALO_REDIRECT_URI'),
        ]);

        $data = $response->json();
        $accessToken = $data['access_token'];

        $userResponse = Http::get('https://graph.zalo.me/v2.0/me', [
            'access_token' => $accessToken,
            'fields' => 'id,name,picture',
        ]);

        $user = $userResponse->json();
        var_dump($user);
        $userData = [
            'id' => $user['id'],
            'name' => $user['name'],
            'avatar' => $user['picture']['data']['url'] ?? null,
        ];

        return redirect(env('API_REDIRECT_URI') . "?user=" . urlencode(json_encode($userData)));
    }
}
