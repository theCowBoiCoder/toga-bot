<?php

namespace App\Console\Commands;

use App\Discord\JoinTeam;
use App\Discord\Member as DiscordMember;
use App\Football\FootballAPI;
use App\Football\Predictor;
use App\Models\GamePredictor;
use App\Http\Services\Discord\Commands\CommandHandler;
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


        $discord->on('ready', function (Discord $discord) {
            $discord->on('message', function (Message $message) use ($discord) {
                if (CommandHandler::check($message->content)) {
                    CommandHandler::fire($message);
                } else {
                    $message->channel->sendMessage("Sorry, command does not exist.");
                }
                if ($message->content === '!ping') {
                    $message->channel->sendMessage('cock!');
                }

                if ($message->content === '--join') {
                    JoinTeam::join($message);
                }

                if ($message->content === '--games today') {
                    $today_games = Result::query()->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get();
                    $embedded = new Embed($discord);
                    $embedded->setTitle("Great please choose from below who you want to predict for.");
                    if (count($today_games) >= 1) {
                        foreach ($today_games as $key => $game) {
                            $embedded->addField(['name' => "[{$key}] {$game->home_team_name} vs {$game->away_team_name}", 'value' => "Odds Coming Soon"]);
                        }

                        $embedded->setDescription("To predict all you need to do is --predict [0] 1-2 you musy follow this format or the prediction will not work");

                    } else {
                        $embedded->addField(['name' => 'No Games', 'value' => "Sorry there are no games to predict today try again tomorrow."]);
                    }
                    $embedded->setFooter('POWERED BY TOGA BOT');
                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
                        $message->react('804130997863317595');
                    });
                }

                //Set Predictions
                if (Str::contains($message->content, '--predict') !== false) {
                    //Explode the message
                    $explode_message = explode(' ', $message->content);
                    $match_id = $explode_message[1];
                    $score = $explode_message[2];


                    $results = Result::query()->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get();
                    //Check if the prediction has been sent.
                    $check_prediction = Predictor::checkMatchPrediction($results[$match_id]->id, (int)$message->user_id);
                    if($check_prediction == null){
                        //Set the Prediction
                        Predictor::setMatchPrediction($results[$match_id]->id, (int)$message->user_id, $score);
                        $message->channel->sendMessage("Thanks! Your Prediction for {$results[$match_id]->home_team_name} Vs {$results[$match_id]->away_team_name} has been set.");
                    }else{
                        //@TODO - Need to later see if we can get the KICK OFF times so we can change the predictions up to kick off.
                        $message->channel->sendMessage("Sorry you cannot change your prediction once you have changed it.");
                    }
                }

                //Get My Predictions
                if ($message->content === '--my predictions' || $message->content === '--mypredictions') {
                    //Get the Games that are not finished
                    $today_games = Arr::flatten(Result::query()->select('id')->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get()->toArray());

                    //If I have some predictions then show them if not say NO!
                    $my_predictions = Predictor::getMyMatchPredictions((int)$message->user_id, $today_games);
                    if (count($my_predictions) >= 1) {
                        $embedded = new Embed($discord);
                        $embedded->setTitle("These are your predictions");
                        foreach ($my_predictions as $my_prediction) {
                            $embedded->addField(['name' => "{$my_prediction->match->home_team_name} Vs {$my_prediction->match->away_team_name}", 'value' => (string)($my_prediction->result)]);
                        }

                        $embedded->setFooter('POWERED BY TOGA BOT');
                        $message->channel->sendEmbed($embedded)->then(function (Message $message) {
                            $message->react('804130997863317595');
                        });
                    } else {
                        $message->channel->sendMessage("Sorry {$message->author->username} you have not set any predictions yet.");
                    }

                }

                if (Str::contains($message->content, '--changenickname') !== false) {
                    $explode = explode(' ', $message->content);
//                    $discordClient->guild->modifyGuildMember(
//                        ['guild.id' => (int)env('DISCORD_GUILD'), 'user.id' => (int)$message->user_id]
//                    );
                    dump($message->author->id);
                    //$discordClient->guild->modifyGuildMember(['guild.id' => (int)env('DISCORD_GUILD'), 'user.id' => (int)$message->user_id, 'nick' => 'string']);
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
