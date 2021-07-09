<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriversTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Driver::query()->truncate();
        Team::query()->truncate();

        Driver::query()->create([
            'name' => 'Harvey',
            'country_code' => 'GBR',
            'discord' => 'Batesey#0001',
            'team_number' => 21,
        ]);

        Driver::query()->create([
            'name' => 'Hayden',
            'country_code' => 'GBR',
            'discord' => 'Hayden Sweet#0001',
            'team_number' => 29,
        ]);

        Driver::query()->create([
            'name' => 'Cameron',
            'country_code' => 'GBR',
            'discord' => 'Cameron Stewart#0001',
            'team_number' => 25,
        ]);

        Driver::query()->create([
            'name' => 'Reno',
            'country_code' => 'GBR',
            'discord' => 'Gs#2004',
            'team_number' => 32,
        ]);

        Driver::query()->create([
            'name' => 'Zak',
            'country_code' => 'GBR',
            'discord' => 'Bob the dabber #6276',
            'team_number' => 96,
        ]);

        Driver::query()->create([
            'name' => 'Alan Busch',
            'country_code' => 'GBR',
            'discord' => 'McLaren MCL35M#9938',
            'team_number' => 84,
        ]);

        Driver::query()->create([
            'name' => 'James',
            'country_code' => 'GBR',
            'discord' => 'James#2045',
            'team_number' => 12,
        ]);

        Driver::query()->create([
            'name' => 'Joost Mulders',
            'country_code' => 'GBR',
            'discord' => 'FM Holland#1337',
            'team_number' => 88,
        ]);

        Driver::query()->create([
            'name' => 'Vincent Vrijdags',
            'country_code' => 'GBR',
            'discord' => 'Vinceptic#5191',
            'team_number' => 23,
        ]);

        Driver::query()->create([
            'name' => 'Thjis',
            'country_code' => 'GBR',
            'discord' => 'Thijsieeee#7077',
            'team_number' => 36,
        ]);

        Driver::query()->create([
            'name' => 'Wanksteen',
            'country_code' => 'GBR',
            'discord' => 'Wanksteen#4578',
            'team_number' => 2,
        ]);

        Driver::query()->create([
            'name' => 'Rens',
            'country_code' => 'GBR',
            'discord' => 'Renzza_1502#4826',
            'team_number' => 15,
        ]);

        Driver::query()->create([
            'name' => 'Ben',
            'country_code' => 'GBR',
            'discord' => 'BNJMN#0585',
            'team_number' => 64,
        ]);

        Driver::query()->create([
            'name' => 'Zac Johnson',
            'country_code' => 'GBR',
            'discord' => 'zacjw#0306',
            'team_number' => 27,
        ]);

        Driver::query()->create([
            'name' => 'Stepan',
            'country_code' => 'GBR',
            'discord' => 'Stefano #1514',
            'team_number' => 13,
        ]);

        Driver::query()->create([
            'name' => 'Sebastian',
            'country_code' => 'GBR',
            'discord' => 'stancedL#1971',
            'team_number' => 56,
        ]);

        Driver::query()->create([
            'name' => 'Tom',
            'country_code' => 'GBR',
            'discord' => 'txlney#0033',
            'team_number' => 20,
        ]);

        Driver::query()->create([
            'name' => 'Matt M',
            'country_code' => 'GBR',
            'discord' => 'Hawk#2599',
            'team_number' => 98,
        ]);

        Driver::query()->create([
            'name' => 'Nicolas',
            'country_code' => 'CYP',
            'discord' => 'NIK_095#1491',
            'team_number' => 95,
        ]);

        Driver::query()->create([
            'name' => 'Matt S',
            'country_code' => 'GBR',
            'discord' => 'Spants#7706',
            'team_number' => 35,
        ]);

        Driver::query()->create([
            'name' => 'Max Whitehouse',
            'country_code' => 'GBR',
            'discord' => 'whitxhousx#0420',
            'team_number' => 34,
        ]);


        Team::query()->create(['name' => 'Mercedes']);
        Team::query()->create(['name' => 'Red Bull Racing-Honda']);
        Team::query()->create(['name' => 'McLaren-Mercedes']);
        Team::query()->create(['name' => 'Aston Martin-Mercedes']);
        Team::query()->create(['name' => 'Alpine-Renault']);
        Team::query()->create(['name' => 'Ferrari']);
        Team::query()->create(['name' => 'AlphaTauri-Honda']);
        Team::query()->create(['name' => 'Alfa Romeo Racing-Ferrari']);
        Team::query()->create(['name' => 'Haas-Ferrari']);
        Team::query()->create(['name' => 'Williams-Mercedes']);

        DB::table('drivers_teams')->insert([
            ['driver_id' => 11, 'team_id' => 1],
            ['driver_id' => 19, 'team_id' => 1],

            ['driver_id' => 21, 'team_id' => 2],
            ['driver_id' => 10, 'team_id' => 2],

            ['driver_id' => 5, 'team_id' => 3],
            ['driver_id' => 7, 'team_id' => 3],

            ['driver_id' => 1, 'team_id' => 4],
            ['driver_id' => 13, 'team_id' => 4],

            ['driver_id' => 17, 'team_id' => 5],
            ['driver_id' => 18, 'team_id' => 5],

            ['driver_id' => 2, 'team_id' => 6],
            ['driver_id' => 3, 'team_id' => 6],

            ['driver_id' => 9, 'team_id' => 7],
            ['driver_id' => 20, 'team_id' => 7],

            ['driver_id' => 6, 'team_id' => 8],
            ['driver_id' => 4, 'team_id' => 8],

            ['driver_id' => 12, 'team_id' => 9],
            ['driver_id' => 16, 'team_id' => 9],

            ['driver_id' => 14, 'team_id' => 10],
            ['driver_id' => 15, 'team_id' => 10],
        ]);
    }
}
