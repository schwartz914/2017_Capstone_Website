<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFitbitkeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitbitkey', function (Blueprint $table) {
            $table->increments('fitbitkeyid');
            $table->integer('userID')->unsigned();;
            $table->string('access_token', 600);
            $table->string('refresh_token', 200);
            $table->string('expires');
            $table->string('fitbitID');

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
        Schema::dropIfExists('fitbitkey');
    }
}
