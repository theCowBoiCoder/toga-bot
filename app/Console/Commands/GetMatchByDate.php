<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use App\Models\FootballTeam;
use App\Models\Result;
use Illuminate\Console\Command;

class GetMatchByDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'togabot:get_matches_by_date {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Matches by using a specific date';

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
        $premMatches = FootballAPI::findPremierLeagueMatchesByDate($this->argument('date'));
        dump($premMatches);
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
                'home_team_score' => $match->score->fullTime->homeTeam,
                'away_team_id' => $match->awayTeam->id,
                'away_team_name' => $match->awayTeam->name,
                'away_team_score' => $match->score->fullTime->awayTeam,
            ]);
        }
    }
}
