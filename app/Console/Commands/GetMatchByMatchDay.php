<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use App\Http\Services\Discord\DiscordChannel;
use App\Models\Result;
use Carbon\Carbon;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use RestCord\DiscordClient;

class GetMatchByMatchDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'togabot:get_match_by_match_day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Matches by Match Day';


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

        $matches = FootballAPI::findMatchesByCompetitionAndMatchday(NULL);
        foreach ($matches->matches as $match){
            Result::query()->updateOrCreate([
                'match_id' => $match->id
            ],[
                'match_day' => $match->matchday,
                'status' => $match->status,
                'winner' => $match->score->winner,
                'home_team_name' => $match->homeTeam->name,
                'home_team_score' => $match->score->fullTime->homeTeam,
                'away_team_name' => $match->awayTeam->name,
                'away_team_score' => $match->score->fullTime->awayTeam,
            ]);
        }

        //Send Message in Discord..
        $results = Result::query()->whereDate('created_at',Carbon::today()->toDateString())->get();
        if(count($results) >= 1){
            foreach ($results as $result){
                $fields[] = [
                    'name' => "{$result->home_team_name} VS {$result->away_team_name}",
                    'value' => "{$result->home_team_score} - {$result->away_team_score}"
                ];
            }
            $embeds[] = [
                'title' => 'Football Today ('.Carbon::now()->toDateString().')',
                'image' => [
                    'url' => 'https://cdn.freelogovectors.net/wp-content/uploads/2020/08/epl-premierleague-logo.png'
                ],
                'fields' => $fields,
                "color" => hexdec( "00A8FF" ),
                'timestamp' => Carbon::now()->toDateTimeString(),
            ];

            $data = [
                'content' => 'Premier League Today',
                'embeds' => $embeds
            ];

            $client = new Client();
            $client->request('POST',env('PREMIER_LEAGUE_WEBHOOK'),[
                'json' => $data
            ]);
        }
    }
}
