<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use App\Models\FootballTeam;
use Illuminate\Console\Command;

class StoreTeamData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'togabot:store_team_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store the Team Data Every Week';

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
        $teams = FootballAPI::getLeagueStandings(env('FOOTBALL_PREMIER_LEAGUE_ID'));
        foreach ($teams as $team)
        {
            FootballTeam::query()->updateOrCreate([
                'name' => $team->team->name,
                'league_position' => $team->position,
                'played_games' => $team->playedGames,
                'won' => $team->won,
                'draw' => $team->draw,
                'lost' => $team->lost,
                'points' => $team->points,
                'scored' => $team->goalsFor,
                'conceded' => $team->goalsAgainst,
                'difference' => $team->goalDifference,
                'form' => $team->form
            ]);

            $this->info("{$team->team->name} has been added");
        }
    }
}
