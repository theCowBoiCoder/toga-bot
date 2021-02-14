<?php

namespace App\Discord;

use Discord\Parts\Channel\Message;
use React\Promise\ExtendedPromiseInterface;
use RestCord\DiscordClient;

class Member{

    /**
     * Get Current User.
     * @param Message $message
     * @return ExtendedPromiseInterface
     * @throws \Exception
     */
    public static function me(Message $message): ExtendedPromiseInterface
    {
        $user_id = $message->user_id;
        $clientDiscord = new DiscordClient(['token' => env('DISCORD_TOKEN')]);
        $member = $clientDiscord->guild->getGuildMember(['guild.id' => (int)env('DISCORD_GUILD'), 'user.id' => (int)$user_id]);

        return $message->channel->sendMessage("Hello {$member->nick} you absolute legend");
    }
}
