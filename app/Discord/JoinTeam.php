<?php

namespace App\Discord;

use App\Models\Members;
use Discord\Parts\Channel\Message;
use React\Promise\ExtendedPromiseInterface;

class JoinTeam
{

    /**
     * Member joins the discord crew
     * @param Message $message
     * @return ExtendedPromiseInterface
     * @throws \Exception
     */
    public static function join(Message $message): ExtendedPromiseInterface
    {
        $author = $message->author;
        $newUser = Members::query()->where('discord_id', $author->user->id)->first();
        if ($newUser == null) {
            Members::query()->create([
                'discord_id' => $author->user->id,
                'nickname' => $author->nick,
                'username' => $author->username,
                'joined_at' => $author->joined_at->toDateString()
            ]);

            return $message->channel->sendMessage("Welcome {$author->nick} and thanks for joining the Toga Bot. You joined here {$author->joined_at->toDateString()}");
        }

        return $message->channel->sendMessage("Sorry {$author->nick} you have already joined the crew!");
    }
}
