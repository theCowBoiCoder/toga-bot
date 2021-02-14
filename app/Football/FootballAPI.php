<?php

namespace App\Football;

use Carbon\Carbon;
use GuzzleHttp\Client;

class FootballAPI{

    public static function run($uri,$type = 'GET')
    {
        $client = new Client([
            'base_uri'  =>  'http://api.football-data.org/',
            'headers'   =>  [
                'X-Auth-Token' => getenv('FOOTBALL_API_TOKEN')
            ]
        ]);
        return json_decode($client->request($type,$uri)->getBody());
    }

    public static function getLeagues( array $filter = ['stage' => ''])
    {
        $leagueTeams = self::run("v2/competitions"."?".http_build_query($filter));
        return collect($leagueTeams->competitions);
    }

    public static function getLeague(int $leagueID, array $filter = ['areas' => ''])
    {
        $league = self::run("v2/competitions/{$leagueID}"."?".http_build_query($filter));
        return collect($league);
    }

    public static function getLeagueStandings(int $leagueID)
    {
        $leagueStandings = self::run("v2/competitions/{$leagueID}/standings");
        return collect($leagueStandings->standings)[0]->table;
    }

    public static function getTeams($leagueId)
    {
        return self::run('v2/competitions/'.$leagueId.'/teams','GET');
    }

    public static function findPremierLeagueMatchesByDate($date)
    {
        $resource = 'competitions/' . env('FOOTBALL_PREMIER_LEAGUE_ID') . '/matches/?dateFrom='.$date.'&dateTo='.$date.'';
        return self::run("v2/$resource",'GET');
    }

    public static function findPremierLeagueMatchesCompetitionAndMatchday($date)
    {
        $resource = 'competitions/' . env('FOOTBALL_PREMIER_LEAGUE_ID') . '/matches/?matchday=' . $date.'&dateFrom='.Carbon::today()->toDateString().'&dateTo='.Carbon::today()->toDateString().'';
        return self::run("v2/$resource",'GET');
    }

    public static function findChampionsLeagueMatchesCompetitionAndMatchday($date)
    {
        $resource = 'competitions/' . env('CHAMPIONS_LEAGUE_ID') . '/matches/?matchday=' . $date.'&dateFrom='.Carbon::today()->toDateString().'&dateTo='.Carbon::today()->toDateString().'';
        return self::run("v2/$resource",'GET');
    }


    public static function findEuropaLeagueMatchesCompetitionAndMatchday($date)
    {
        $resource = 'competitions/' . env('EURPOA_LEAGUE_ID') . '/matches/?matchday=' . $date.'&dateFrom='.Carbon::today()->toDateString().'&dateTo='.Carbon::today()->toDateString().'';
        return self::run("v2/$resource",'GET');
    }
}
