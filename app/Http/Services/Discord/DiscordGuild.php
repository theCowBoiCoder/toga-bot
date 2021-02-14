<?php


namespace App\Http\Services\Discord;


class DiscordGuild extends Discord
{
    public function updateGuildMember($guildID, $userID, array $body): \Illuminate\Http\Client\Response
    {
        return $this->patch(json_encode($body), '/guilds/'.$guildID.'/members/'.$userID);
    }
}
