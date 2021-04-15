<?php

namespace App\Console\Commands;

use App\Http\Services\Discord\DiscordChannel;
use App\Http\Services\Discord\DiscordGuild;
use Illuminate\Console\Command;

class AssignNightWatchmanRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'togabot:its_night_watchman_time';

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
        $nightWatchManId = env('NIGHT_WATCHMAN');

        $discordChannel = new DiscordChannel();
        $discordGuid = new DiscordGuild();
        $user = $discordGuid->getGuildMemeber(env('DISCORD_GUILD'),$nightWatchManId);

        if (in_array(env('MOD_ROLE'), $user->roles, true)){
            $discordGuid->updateGuildMemeberRemoveModRole(env('DISCORD_GUILD'),$nightWatchManId,env('MOD_ROLE'));
            $discordChannel->createMessage(790146349214859264,['content' => 'The night watchmen shift has ended']);
        }else{
            $discordGuid->updateGuildMemeberAddModRole(env('DISCORD_GUILD'),$nightWatchManId,env('MOD_ROLE'));
            $discordChannel->createMessage(790146349214859264,['content' => 'The night watchmen shift has started']);
        }
    }
}
