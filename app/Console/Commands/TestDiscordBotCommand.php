<?php

namespace App\Console\Commands;

use App\Discord\JoinTeam;
use App\Football\FootballAPI;
use App\Models\Members;
use Carbon\Carbon;
use Discord\Http\Http;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Guild\AuditLog\Options;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\Member;
use Discord\Parts\User\User;
use Discord\WebSockets\Event;
use Discord\WebSockets\Events\GuildIntegrationsUpdate;
use Illuminate\Console\Command;
use Discord\Discord;
use Illuminate\Support\Str;

class TestDiscordBotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $discord = new Discord([
            'token' => env('DISCORD_TOKEN')
        ]);

        $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
            if ($message->content === '!ping') {

            }
        });

//        $discord->on('ready', function (Discord $discord) {
//            $discord->on('message', function (Message $message) use ($discord) {
//                if ($message->content === '!ping') {
//                    $message->channel->sendMessage('cock!');
//                }
//
//                if ($message->content === '--join') {
//                    JoinTeam::join($message);
//                }
//
//                if (Str::contains($message->content, '--changenickname') !== false) {
//                    $explode = explode(' ',$message->content);
//                    dump($explode[1]);
//                    $message->author->setNickname($explode[1]);
//                }
//
//
//                if ($message->content === '--topoftheleague') {
//
//                    $team = FootballAPI::getLeagueStandings(env('FOOTBALL_PREMIER_LEAGUE_ID'))[0];
//                    $embedded = new Embed($discord);
//                    $embedded->setTitle((string)$team->team->name);
//                    $embedded->setThumbnail('https://cdn.freebiesupply.com/images/large/2x/manchester-city-logo-png-transparent.png');
//                    $embedded->addField(['name' => 'Played', 'value' => $team->playedGames]);
//                    $embedded->addFieldValues('Won', $team->won, true);
//                    $embedded->addFieldValues('Draw', $team->draw, true);
//                    $embedded->addFieldValues('Lost', $team->lost, true);
//                    $embedded->addFieldValues('Points', $team->points, true);
//                    $embedded->addFieldValues('Scored', $team->goalsFor, true);
//                    $embedded->addFieldValues('Conceded', $team->goalsAgainst, true);
//                    $embedded->addFieldValues('Difference', $team->goalDifference, true);
//                    $embedded->setTimestamp();
//                    $embedded->setFooter('POWERED BY TOGA BOT');
//                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
//                        $message->react('804130997863317595');
//                    });
//                }
//            });
//        });

        $discord->run();
    }
}
