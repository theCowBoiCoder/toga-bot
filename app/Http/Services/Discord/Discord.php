<?php


namespace App\Http\Services\Discord;

use Illuminate\Support\Facades\Http;

/**
 * Class Discord
 * @package App\Http\Services\Discord
 */
class Discord
{
    const BASE_URL = 'https://discord.com/api/v8';

    public $headers;

    public function __construct()
    {
        $this->headers = [
            'Authorization' => 'Bot ' . env('DISCORD_TOKEN')
        ];
    }


    /**
     * @param array $body
     * @param string $endpoint
     * @return \Illuminate\Http\Client\Response
     */
    public function patch(string $body, string $endpoint)
    {
        return Http::withHeaders(
           $this->headers
        )->withBody($body, 'application/json')->patch(self::BASE_URL . $endpoint);
    }
}
