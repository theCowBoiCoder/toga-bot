<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id');
            $table->integer('match_day');
            $table->string('comp');
            $table->string('status')->nullable();
            $table->string('winner')->nullable();
            $table->integer('home_team_id')->nullable();
            $table->string('home_team_name')->nullable();
            $table->integer('home_team_score')->default(0);
            $table->integer('away_team_id')->nullable();
            $table->string('away_team_name')->nullable();
            $table->integer('away_team_score')->default(0);
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
        Schema::dropIfExists('results');
    }
}
