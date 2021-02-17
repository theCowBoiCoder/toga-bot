<?php


namespace App\Http\Services\Discord\Commands;

use App\Http\Services\Discord\DiscordChannel;
use App\Http\Services\Discord\DiscordGuild;

class Command
{
    /**
     * @var DiscordGuild
     */
    public $discordGuild;
    /**
     * @var DiscordChannel
     */
    public $discordChannel;

    public function __construct()
    {
        $this->discordGuild = new DiscordGuild();
        $this->discordChannel = new DiscordChannel();
    }
}
