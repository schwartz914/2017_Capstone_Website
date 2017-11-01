<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatcherObserversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watcherObservees', function (Blueprint $table) {
          $table->increments('observeWatchID')->unsigned();
          $table->integer('observeeID')->unsigned();
          $table->string('observeeCode');
          $table->integer('watcherID')->unsigned()->nullable();
          $table->string('watcherCode')->nullable();
          $table->dateTime('dateTimeRequested')->useCurrent();
          $table->enum('completed',['yes', 'no'])->default('no');
          
          //$table->primary('observeWatchID');
          $table->foreign('observeeID')->references('id')->on('users');
          $table->foreign('watcherID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watcherObservers');
    }
}
