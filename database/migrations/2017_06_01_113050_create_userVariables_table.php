<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userVariables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->integer('mentalHealth');
            $table->integer('physicalHealth');
            $table->integer('appetite');
            $table->integer('fatigue');
            $table->integer('mood');
            $table->integer('motivation');
            $table->integer('musclePain');
            $table->integer('nutritionQuality');
            $table->integer('readinessToTrain');
            $table->integer('sleepQuality');
            $table->integer('stress');
            $table->integer('timeSlept');


            $table->foreign('userID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userVariables');
    }
}
