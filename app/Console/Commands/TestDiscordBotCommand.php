<?php

namespace App\Console\Commands;

use App\Discord\JoinTeam;
use App\Discord\Member as DiscordMember;
use App\Football\FootballAPI;
use App\Football\Predictor;
use App\Models\GamePredictor;
use App\Models\Members;
use App\Models\Result;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RestCord\DiscordClient;

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

        $discordClient = new DiscordClient(['token' => env('DISCORD_TOKEN'),'apiUrl' => 'https://discord.com/api/v8']);

        $discord->on('ready', function (Discord $discord) use ($discordClient) {
            $discord->on('message', function (Message $message) use ($discord, $discordClient) {
                if ($message->content === '!ping') {
                    $message->channel->sendMessage('cock!');
                }

                if ($message->content === '--join') {
                    JoinTeam::join($message);
                }

                if ($message->content === '--games today') {
                    $todays_games = Result::query()->where('status','SCHEDULED')->whereDate('created_at',Carbon::today()->toDateString())->get();
                    $embedded = new Embed($discord);
                    $embedded->setTitle("Great please choose from below who you want to predict for.");
                    if(count($todays_games) >= 1){
                        foreach ($todays_games as $key => $game){
                            $embedded->addField(['name' => "[{$key}] {$game->home_team_name} vs {$game->away_team_name}", 'value' => "Odds Coming Soon"]);
                        }

                        $embedded->setDescription("To predict all you need to do is --predict [0] 1-2 you musy follow this format or the prediction will not work");

                    }else{
                        $embedded->addField(['name' => 'No Games', 'value' => "Sorry there are no games to predict today try again tomorrow."]);
                    }
                    $embedded->setFooter('POWERED BY TOGA BOT');
                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
                        $message->react('804130997863317595');
                    });
                }

                if ($message->content === '--my predictions') {
                    $todays_games = Arr::flatten(Result::query()->select('id')->where('status','SCHEDULED')->whereDate('created_at',Carbon::today()->toDateString())->get()->toArray());
                    $my_predictions = Predictor::getMyMatchPredictions((int)$message->user_id,$todays_games);
                    if(count($my_predictions) >= 1){

                    }else{
                        $message->channel->sendMessage("Sorry {$message->author->username} you have not set any predictions yet.");
                    }

                }

                if (Str::contains($message->content, '--changenickname') !== false) {
                    $explode = explode(' ', $message->content);
//                    $discordClient->guild->modifyGuildMember(
//                        ['guild.id' => (int)env('DISCORD_GUILD'), 'user.id' => (int)$message->user_id]
//                    );
                    dump($message->author->id);
                    $discordClient->guild->modifyGuildMember(['guild.id' => (int)env('DISCORD_GUILD'), 'user.id' => (int)$message->user_id, 'nick' => 'string']);
                }



                if ($message->content === '--topoftheleague') {

                    $team = FootballAPI::getLeagueStandings(env('FOOTBALL_PREMIER_LEAGUE_ID'))[0];
                    $embedded = new Embed($discord);
                    $embedded->setTitle((string)$team->team->name);
                    $embedded->setThumbnail('https://cdn.freebiesupply.com/images/large/2x/manchester-city-logo-png-transparent.png');
                    $embedded->addField(['name' => 'Played', 'value' => $team->playedGames]);
                    $embedded->addFieldValues('Won', $team->won, true);
                    $embedded->addFieldValues('Draw', $team->draw, true);
                    $embedded->addFieldValues('Lost', $team->lost, true);
                    $embedded->addFieldValues('Points', $team->points, true);
                    $embedded->addFieldValues('Scored', $team->goalsFor, true);
                    $embedded->addFieldValues('Conceded', $team->goalsAgainst, true);
                    $embedded->addFieldValues('Difference', $team->goalDifference, true);
                    $embedded->setTimestamp();
                    $embedded->setFooter('POWERED BY TOGA BOT');
                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
                        $message->react('804130997863317595');
                    });
                }
            });
        });

        $discord->run();
    }
}
