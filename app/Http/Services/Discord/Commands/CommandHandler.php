<?php


namespace App\Http\Services\Discord\Commands;


class CommandHandler
{
    public static function check($content)
    {
        //TODO this needs to strip out for just the command '--ping sdglkjhdfgkjd' we just want 'ping'
        $command = null;
        if (file_exists('./'.$command)){
            return true;
        }
        return false;
    }

    public static function fire($content)
    {
    }
}
