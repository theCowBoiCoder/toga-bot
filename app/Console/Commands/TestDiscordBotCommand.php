<?php

namespace App\Console\Commands;


use App\Discord\Member;
use App\Football\FootballAPI;
use App\Models\Driver;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Part;
use Discord\Repository\Guild\MemberRepository;
use Discord\WebSockets\Events\GuildMemberAdd;
use Illuminate\Console\Command;
use Discord\Discord;
use Illuminate\Support\Facades\Event;
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
     * @throws \Discord\Exceptions\IntentException
     */
    public function handle()
    {

        $roles = [];
        $discord = new Discord([
            'token' => env('DISCORD_TOKEN')
        ]);

        $discord->on('ready', function () use ($discord) {
            $discord->on(\Discord\WebSockets\Event::GUILD_MEMBER_ADD, function (\Discord\Parts\User\Member $member, Discord $discord) {
                $discord->getChannel(790146349214859264)->sendMessage('Welcome <@' . $member->id . '> head over to <#792844269358153789> to pick what you want to see in here!! ');
            });

            $discord->on(\Discord\WebSockets\Event::GUILD_MEMBER_REMOVE, function (\Discord\Parts\User\Member $member, Discord $discord) {
                $discord->getChannel(790146349214859264)->sendMessage('<@' . $member->id . '> See ya mate!');
            });
            $discord->on('message', function (Message $message) use ($discord) {

                if ($message->content === '--help') {
                    $embedded = new Embed($discord);
                    $embedded->setTitle('Toga Bot Help Commands');
                    $embedded->addFieldValues('--f1', 'Loads Teams and Drivers');
                    $embedded->addFieldValues('--myteam', 'Shows my team and points');
                    $embedded->addFieldValues('--topoftheleague', 'Shows the premier league standings');
                    $embedded->setTimestamp();
                    $embedded->setFooter('POWERED BY TOGA BOT');
                    $message->channel->sendEmbed($embedded);
                }
                if ($message->content === '--f1') {
                    foreach ($message->author->roles->toArray() as $key => $item) {
                        $roles[] = $key;
                    }
                    if (in_array('800491196937404416', $roles)) {
                        $embedded = new Embed($discord);
                        $embedded->setTitle('F1 2021 Toga Motorsport');
                        $embedded->setThumbnail('https://logodownload.org/wp-content/uploads/2016/11/formula-1-logo-2-2.png');
                        $embedded->addFieldValues('Alfa Romeo Racing-Ferrari', 'Alan / Rens');
                        $embedded->addFieldValues('AlphaTauri-Honda', 'Vince / Matt S');
                        $embedded->addFieldValues('Alpine-Renault', 'Tom / Matt M');
                        $embedded->addFieldValues('Aston Martin-Mercedes', 'Harvey / Ben');
                        $embedded->addFieldValues('Ferrari', 'Hayden / Cameron');
                        $embedded->addFieldValues('Haas-Ferrari', 'Reno / Seb');
                        $embedded->addFieldValues('McLaren-Mercedes', 'Bob / James');
                        $embedded->addFieldValues('Mercedes', 'Wanksteen / Nicolas');
                        $embedded->addFieldValues('Red Bull Racing-Honda', 'GuitarBeast / Max');
                        $embedded->addFieldValues('Williams-Mercedes', 'Zac / Steph');
                        $embedded->setTimestamp();
                        $embedded->setFooter('POWERED BY TOGA BOT');
                        $message->channel->sendEmbed($embedded);
                    }else{
                        $message->channel->sendMessage("Sorry you cannot use this command");
                    }


                }

                if ($message->content === '--myteam') {
                    foreach ($message->author->roles->toArray() as $key => $item) {
                        $roles[] = $key;
                    }
                    if (in_array('800491196937404416', $roles)) {
                        if (Str::contains($message->author->username, '-')) {
                            $discordUserName = Str::replace('-', ' ', $message->author->username) . '#' . $message->author->discriminator;
                        } else {
                            $discordUserName = $message->author->username . '#' . $message->author->discriminator;
                        }
                        $driver = Driver::query()->where('discord', $discordUserName)->first();
                        if ($driver != null) {
                            $embedded = new Embed($discord);
                            $embedded->setTitle("My F1 2021 Team");
                            $embedded->setThumbnail('https://logodownload.org/wp-content/uploads/2016/11/formula-1-logo-2-2.png');
                            $embedded->addField(['name' => 'Constructor', 'value' => $driver->myteam->team->name]);
                            $embedded->addFieldValues('Points', 'COMING SOON', true);
                            $embedded->setTimestamp();
                            $embedded->setFooter('POWERED BY TOGA BOT');
                            $message->channel->sendEmbed($embedded)->then(function (Message $message) {
                                //$message->react('804130997863317595');
                            });
                        } else {
                            $message->channel->sendMessage("User Not Found!");
                        }
                    } else {
                        $message->channel->sendMessage("Sorry you cannot use this command");
                    }


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
//
//        $discord->on('ready', function (Discord $discord)  {
//
////                if ($discord->user->id == 703077578419732543) {
////                    dump('hello');
////                    $member = new Member($discord);
////                    $member->moveMember(819300656602939422);
////                }
//            });
//
////            $discord->on('message', function (Message $message) use ($discord) {
////
////
////                if (CommandHandler::check($message->content)) {
////                    CommandHandler::fire($message);
////                }else{
////                    $message->channel->sendMessage("Command not found!");
////                }
////
////
////                if ($message->content === '--join') {
////
////                }
////
////                if ($message->content === '--games today') {
////                    $today_games = Result::query()->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get();
////                    $embedded = new Embed($discord);
////                    $embedded->setTitle("Great please choose from below who you want to predict for.");
////                    if (count($today_games) >= 1) {
////                        foreach ($today_games as $key => $game) {
////                            $embedded->addField(['name' => "[{$key}] {$game->home_team_name} vs {$game->away_team_name}", 'value' => "Odds Coming Soon"]);
////                        }
////
////                        $embedded->setDescription("To predict all you need to do is --predict [0] 1-2 you musy follow this format or the prediction will not work");
////
////                    } else {
////                        $embedded->addField(['name' => 'No Games', 'value' => "Sorry there are no games to predict today try again tomorrow."]);
////                    }
////                    $embedded->setFooter('POWERED BY TOGA BOT');
////                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
////                        $message->react('804130997863317595');
////                    });
////                }
////
////                //Set Predictions
////                if (Str::contains($message->content, '--predict') !== false) {
////                    //Explode the message
////                    $explode_message = explode(' ', $message->content);
////                    $match_id = $explode_message[1];
////                    $score = $explode_message[2];
////
////
////                    $results = Result::query()->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get();
////                    //Check if the prediction has been sent.
////                    $check_prediction = Predictor::checkMatchPrediction($results[$match_id]->id, (int)$message->user_id);
////                    if ($check_prediction == null) {
////                        //Set the Prediction
////                        Predictor::setMatchPrediction($results[$match_id]->id, (int)$message->user_id, $score);
////                        $message->channel->sendMessage("Thanks! Your Prediction for {$results[$match_id]->home_team_name} Vs {$results[$match_id]->away_team_name} has been set.");
////                    } else {
////                        //@TODO - Need to later see if we can get the KICK OFF times so we can change the predictions up to kick off.
////                        $message->channel->sendMessage("Sorry you cannot change your prediction once you have changed it.");
////                    }
////                }
////
////                //Get My Predictions
////                if ($message->content === '--my predictions' || $message->content === '--mypredictions') {
////                    //Get the Games that are not finished
////                    $today_games = Arr::flatten(Result::query()->select('id')->where('status', '!=', 'FINISHED')->whereDate('created_at', Carbon::today()->toDateString())->get()->toArray());
////
////                    //If I have some predictions then show them if not say NO!
////                    $my_predictions = Predictor::getMyMatchPredictions((int)$message->user_id, $today_games);
////                    if (count($my_predictions) >= 1) {
////                        $embedded = new Embed($discord);
////                        $embedded->setTitle("These are your predictions");
////                        foreach ($my_predictions as $my_prediction) {
////                            $embedded->addField(['name' => "{$my_prediction->match->home_team_name} Vs {$my_prediction->match->away_team_name}", 'value' => (string)($my_prediction->result)]);
////                        }
////
////                        $embedded->setFooter('POWERED BY TOGA BOT');
////                        $message->channel->sendEmbed($embedded)->then(function (Message $message) {
////                            $message->react('804130997863317595');
////                        });
////                    } else {
////                        $message->channel->sendMessage("Sorry {$message->author->username} you have not set any predictions yet.");
////                    }
////
////                }
////                if ($message->content === '--topoftheleague') {
////
////                    $team = FootballAPI::getLeagueStandings(env('FOOTBALL_PREMIER_LEAGUE_ID'))[0];
////                    $embedded = new Embed($discord);
////                    $embedded->setTitle((string)$team->team->name);
////                    $embedded->setThumbnail('https://cdn.freebiesupply.com/images/large/2x/manchester-city-logo-png-transparent.png');
////                    $embedded->addField(['name' => 'Played', 'value' => $team->playedGames]);
////                    $embedded->addFieldValues('Won', $team->won, true);
////                    $embedded->addFieldValues('Draw', $team->draw, true);
////                    $embedded->addFieldValues('Lost', $team->lost, true);
////                    $embedded->addFieldValues('Points', $team->points, true);
////                    $embedded->addFieldValues('Scored', $team->goalsFor, true);
////                    $embedded->addFieldValues('Conceded', $team->goalsAgainst, true);
////                    $embedded->addFieldValues('Difference', $team->goalDifference, true);
////                    $embedded->setTimestamp();
////                    $embedded->setFooter('POWERED BY TOGA BOT');
////                    $message->channel->sendEmbed($embedded)->then(function (Message $message) {
////                        $message->react('804130997863317595');
////                    });
////                }
////            });
//        });
//
//        $discord->run();
    }
}
