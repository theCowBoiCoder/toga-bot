<?php

namespace Database\Seeders;

use App\Models\AllowedCommand;
use Illuminate\Database\Seeder;

class AllowedCommandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commands = [
           ['command_name' => 'ping','additional_params' => 0],
           ['command_name' => 'join','additional_params' => 0],
           ['command_name' => 'predict','additional_params' => 1],
           ['command_name' => 'games','additional_params' => 0],
           ['command_name' => 'mypredictions','additional_params' => 0],
           ['command_name' => 'topoftheleague','additional_params' => 0],
           ['command_name' => 'games','additional_params' => 0],
           ['command_name' => 'changenickname','additional_params' => 1],
        ];

        foreach ($commands as $command){
            AllowedCommand::query()->create([
                'command_name' => $command['command_name'],
                'additional_params' => $command['additional_params'],
            ]);
        }
    }
}
