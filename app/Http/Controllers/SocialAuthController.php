<?php
// app/Http/Controllers/SocialAuthController.php
namespace App\Http\Controllers;

use Faker\Provider\Base;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    // Đăng nhập bằng Facebook
    public function redirectToFacebook()
    {
        $redirectUrl = Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
        return response()->json(['redirectUrl' => $redirectUrl]);
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::where('facebook_id', $facebookUser->getId())->first();
            if (!$user) {
                $userData = [
                    'facebook_id' => $facebookUser->getId(),
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'avatar' => $facebookUser->getAvatar(),
                    'password' => bcrypt('password'),
                ];
                $user = User::create($userData);
            }
            Auth::login($user);
            // Tạo token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $facebookUser->getAvatar(),
                'token' => $token, // Gửi token Sanctum
            ];
            // Chuyển hướng về frontend với thông tin người dùng
            return env('FRONTEND_APP_URL');
            return redirect(env('FRONTEND_APP_URL') . "/api/auth/callback?user=" . urlencode(json_encode($userData)));
        } catch (\Exception $e) {
            \Log::error('Facebook callback error: ' . $e->getMessage());
            return response()->json(['error' => 'Facebook authentication failed'], 500);
        }
    }
}
