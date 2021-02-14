<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use App\Http\Services\Discord\DiscordChannel;
use App\Models\FootballTeam;
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

        $premMatches = FootballAPI::findPremierLeagueMatchesCompetitionAndMatchday(NULL);
        foreach ($premMatches->matches as $match){

            //Update the team ID
            FootballTeam::query()->where('name',$match->homeTeam->name)
                ->update([
                    'football_api_id' => $match->homeTeam->id
                ]);

            FootballTeam::query()->where('name',$match->awayTeam->name)
                ->update([
                    'football_api_id' => $match->awayTeam->id
                ]);


            Result::query()->updateOrCreate([
                'match_id' => $match->id
            ],[
                'match_day' => $match->matchday,
                'comp' => 'Premier League',
                'status' => $match->status,
                'winner' => $match->score->winner,
                'home_team_id' => $match->homeTeam->id,
                'home_team_name' => $match->homeTeam->name,
                'home_team_score' => ($match->score->fullTime->homeTeam == NULL)?0:$match->score->fullTime->homeTeam,
                'away_team_id' => $match->awayTeam->id,
                'away_team_name' => $match->awayTeam->name,
                'away_team_score' => ($match->score->fullTime->awayTeam == NULL)?0:$match->score->fullTime->awayTeam,
            ]);
        }

//        $champMatches = FootballAPI::findChampionsLeagueMatchesCompetitionAndMatchday(NULL);
//        foreach ($champMatches->matches as $match){
//            Result::query()->updateOrCreate([
//                'match_id' => $match->id
//            ],[
//                'match_day' => $match->matchday,
//                'comp' => 'UFEA Champions League',
//                'status' => $match->status,
//                'winner' => $match->score->winner,
//                'home_team_name' => $match->homeTeam->name,
//                'home_team_score' => $match->score->fullTime->homeTeam,
//                'away_team_name' => $match->awayTeam->name,
//                'away_team_score' => $match->score->fullTime->awayTeam,
//            ]);
//        }

//        $eurpMatches = FootballAPI::findEuropaLeagueMatchesCompetitionAndMatchday(NULL);
//        foreach ($eurpMatches->matches as $match){
//            Result::query()->updateOrCreate([
//                'match_id' => $match->id
//            ],[
//                'match_day' => $match->matchday,
//                'comp' => 'UFEA Europa League',
//                'status' => $match->status,
//                'winner' => $match->score->winner,
//                'home_team_name' => $match->homeTeam->name,
//                'home_team_score' => $match->score->fullTime->homeTeam,
//                'away_team_name' => $match->awayTeam->name,
//                'away_team_score' => $match->score->fullTime->awayTeam,
//            ]);
//        }

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
                'content' => 'Football Results Today',
                'embeds' => $embeds
            ];

            $client = new Client();
            $client->request('POST',env('PREMIER_LEAGUE_WEBHOOK'),[
                'json' => $data
            ]);
        }
    }
}
