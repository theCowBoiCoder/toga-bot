<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback()
    {
        $discordUser = Socialite::driver('discord')->user();

        $user = User::updateOrCreate(
            [
                'email' => $discordUser->getEmail(),
            ], [
                'discord_id' =>  $discordUser->getId(),
                'avatar' => $discordUser->getAvatar(),
                'name' => $discordUser->getName()
            ]);

        auth()->login($user);

        return redirect('dashboard');
    }

    public function unlinkDiscord()
    {
        auth()->user()->update([
            'discord_id' => null,
        ]);

        return redirect()->route('welcome');
    }
}
