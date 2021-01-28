<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use Carbon\Carbon;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\WebSockets\Event;
use Illuminate\Console\Command;
use Discord\Discord;

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

        $discord->on('ready', function (Discord $discord) {
            $discord->on('message',function (Message $message) use ($discord){
               if($message->content == '!ping'){
                   $message->channel->sendMessage('cock!');
               }

                if($message->content == '--bestteaminengland'){
                    $message->reply('Manchester United!');
                }

                if($message->content == '--bottlejobs'){
                    $message->reply('Liverpool FC');
                }

                if($message->content == '--gymteacher'){
                    $message->reply('ME!');
                }
                if($message->content == '--betecpeteacher'){
                    $message->reply('Mikel Arteta');
                }


                if($message->content == '--topoftheleague'){

                    $team = FootballAPI::getLeagueStandings(env('FOOTBALL_PREMIER_LEAGUE_ID'))[0]->table[0];
                    $embeded = new Embed($discord);
                    $embeded->setTitle((string)$team->team->name);
                    $embeded->setColor('#0A8FF');
                    $embeded->setThumbnail('https://cdn.freebiesupply.com/images/large/2x/manchester-city-logo-png-transparent.png');
                    $embeded->addField(['name' => 'Played','value' => $team->playedGames]);
                    $embeded->addFieldValues('Won',$team->won,true);
                    $embeded->addFieldValues('Draw',$team->draw,true);
                    $embeded->addFieldValues('Lost',$team->lost,true);
                    $embeded->addFieldValues('Points',$team->points,true);
                    $embeded->addFieldValues('Scored',$team->goalsFor,true);
                    $embeded->addFieldValues('Conceded',$team->goalsAgainst,true);
                    $embeded->addFieldValues('Difference',$team->goalDifference,true);
                    $embeded->setTimestamp();
                    $embeded->setFooter('POWERED BY TOGA BOT');
                    $message->channel->sendEmbed($embeded)->then(function (Message $message){
                        $message->react('804130997863317595');
                    });
                }
            });
        });

        $discord->run();
    }
}
