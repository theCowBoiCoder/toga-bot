<?php

namespace App\Twitch;

use GuzzleHttp\Client;

class Connect
{

    public static function token()
    {
        $client = new Client();
        return $client->post('
            https://id.twitch.tv/oauth2/token?client_id='.env('TWITCH_CLIENT_ID').'&client_secret='.env('TWITCH_CLIENT_SECRET').'&grant_type=client_credentials&scope='.env('TWITCH_SCOPE').'');
    }
}
