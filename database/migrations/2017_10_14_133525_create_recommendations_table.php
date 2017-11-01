<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('userId')->unsigned();
          $table->string('description');
          $table->dateTime('date')->useCurrent();
          $table->enum('type',['steps', 'heart', 'calories', 'sleep', 'stress', 'wellness', 'mental'])->default('wellness');
          
          //$table->primary('observeWatchID');
          $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
