<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tracks')) {
            Schema::create('tracks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('country');
            });
        }


        \App\Models\Track::query()->delete();
        DB::table('tracks')->insert([
            ['name' => 'Albert Park', 'country' => 'Australia'],
            ['name' => 'Bahrain International Circuit', 'country' => 'Bahrain',],
            ['name' => 'Imola', 'country' => 'Italy'],
            ['name' => 'Portimao', 'country' => 'Portugal'],
            ['name' => 'Shanghai International Circuit', 'country' => 'China'],
            ['name' => 'Circuit de Barcelona-Catalunya', 'country' => 'Spain'],
            ['name' => 'Circuit de Monaco', 'country' => 'Monaco'],
            ['name' => 'Baku City Circuit', 'country' => 'Azerbaijan'],
            ['name' => 'Circuit Gilles Villeneuve', 'country' => 'Canada'],
            ['name' => 'Circuit Paul Ricard', 'country' => 'France'],
            ['name' => 'Red Bull Ring', 'country' => 'Austria'],
            ['name' => 'Silverstone', 'country' => 'Great Britain'],
            ['name' => 'Hungaroring', 'country' => 'Hungary'],
            ['name' => 'Spa-Francorchamps', 'country' => 'Belgium'],
            ['name' => 'Zandvoort', 'country' => 'Netherlands'],
            ['name' => 'Monza', 'country' => 'Italy'],
            ['name' => 'Sochi Autodrom', 'country' => 'Russia'],
            ['name' => 'Marina Bay', 'country' => 'Singapore'],
            ['name' => 'Suzuka', 'country' => 'Japan'],
            ['name' => 'Circuit of the Americas', 'country' => 'USA'],
            ['name' => 'Circuit Hermanos Rodriguez', 'country' => 'Mexico'],
            ['name' => 'Interlagos', 'country' => 'Brazil'],
            ['name' => 'Jeddah Street Circuit', 'country' => 'Saudi Arabia'],
            ['name' => 'Yas Marina Circuit', 'country' => 'UAE'],
        ]);


        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->bigInteger('track_id')->unsigned();
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->integer('point')->default(0);
            $table->boolean('fastest_lap')->default(0);
            $table->timestamps();
        });

        Schema::create('constructor_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('track_id')->unsigned();
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->bigInteger('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->bigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->integer('point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->dropForeign('driver_id');
            $table->dropForeign('track_id');
        });

        Schema::table('constructor_points', function (Blueprint $table) {
            $table->dropForeign('driver_id');
            $table->dropForeign('team_id');
            $table->dropForeign('track_id');
        });


        Schema::dropIfExists('tracks');
        Schema::dropIfExists('points');
        Schema::dropIfExists('constructor_points');
    }
}
