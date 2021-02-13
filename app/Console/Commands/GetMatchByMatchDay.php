<?php

namespace App\Console\Commands;

use App\Football\FootballAPI;
use Illuminate\Console\Command;

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
        $matches = FootballAPI::findMatchesByCompetitionAndMatchday(23);
        foreach ($matches->matches as $match){
            dd($match);
        }
    }
}
