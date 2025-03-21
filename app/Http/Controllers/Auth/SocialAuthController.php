<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    public function redirectToZalo()
    {
        return Socialite::driver('zalo')->redirect();
    }

    public function handleZaloCallback()
    {
        try {
            $zaloUser = Socialite::driver('zalo')->user();
            $user = User::updateOrCreate(
                ['zalo_id' => $zaloUser->getId()],
                [
                    'name' => $zaloUser->getName(),
                    'email' => $zaloUser->getEmail(), // Optional, Zalo may not return this
                    'password' => bcrypt('password'), // Generate a random password
                ]
            );

            Auth::login($user, true);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login with Zalo.');
        }
    }
}
