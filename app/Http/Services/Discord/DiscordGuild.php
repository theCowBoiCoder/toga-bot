<?php


namespace App\Http\Services\Discord;


class DiscordGuild extends Discord
{
    public function getGuild($guildID)
    {
        return $this->get('/guilds/' . $guildID)->object();
    }

    public function getGuildMemeber($guildID, $userID)
    {
        return $this->get('/guilds/' . $guildID . '/members/' . $userID)->object();
    }

    public function updateGuildMember($guildID, $userID, array $body): \Illuminate\Http\Client\Response
    {
        return $this->patch(json_encode($body), '/guilds/' . $guildID . '/members/' . $userID);
    }

    public function updateGuildMemeberAddModRole($guildID, $userId, $roleId)
    {
        return $this->put("/guilds/{$guildID}/members/{$userId}/roles/{$roleId}");
    }

    public function updateGuildMemeberRemoveModRole($guildID, $userId, $roleId)
    {
        return $this->delete("/guilds/{$guildID}/members/{$userId}/roles/{$roleId}");
    }


}
