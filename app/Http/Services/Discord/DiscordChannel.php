<?php

namespace App\Http\Services\Discord;

class DiscordChannel extends Discord{

    public function createMessage($channel_id,$content)
    {
        return $this->post(json_encode($content),'/channels/'.$channel_id.'/messages');
    }
}
