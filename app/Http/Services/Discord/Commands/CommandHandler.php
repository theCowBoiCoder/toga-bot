<?php


namespace App\Http\Services\Discord\Commands;


use App\Discord\JoinTeam;
use App\Http\Services\Discord\DiscordGuild;
use App\Models\AllowedCommand;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Illuminate\Support\Str;

class CommandHandler
{
    public static function check($command)
    {
        $exploded = substr(explode(' ',$command)[0], 2);
        if (file_exists($exploded.'Command.php')){
            return true;
        }
        return false;
//        $allowed_commands = AllowedCommand::query()->where('command_name', 'LIKE','%'.substr(explode(' ',$command)[0], 2).'%')->where('status', 1)->first();
//        return $allowed_commands != null;

    }

    public static function fire(Message $message)
    {
        $response = 'WHOOPS';
        $response_message = 0;
        $embedded = 0;

        dump($command);
        $discordGuild = new DiscordGuild();

        $discord = new Discord([
            'token' => env('DISCORD_TOKEN')
        ]);

        switch (substr($command, 2)) {
            case 'join':
                try {
                    $embedded = 0;
                    $response_message = 1;
                    $response = JoinTeam::join($message);
                } catch (\Exception $e) {
                    $response = 'FAILED TO JOIN TRY AGAIN SOON!';
                }
                break;
            case 'gay':
                $embedded = 0;
                $response_message = 1;
                $response = 'I KNOW YOU ARE BEN';
                break;
            case 'arsenal':
                $embedded = 0;
                $response_message = 1;
                $response = 'ARE SHIT';
                break;
            case 'default':
                $embedded = 0;
                $response_message = 0;
                $response = 'whooopps';
                break;
        }

        if (Str::contains($command, '--changenickname') !== false) {
            $explode = explode(' ', $message->content);
            $discordGuild->updateGuildMember(env('DISCORD_GUILD'), $message->user_id, ['nick' => $explode[1]]);
            $response_message = 0;
        }

        if ($embedded) {
            //RETURN EMBEDDED
        }

        if($response_message == 1){
            return $message->channel->sendMessage((string)$response);
        }

    }
}
