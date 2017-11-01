<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQuestionResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userQuestionResponse', function (Blueprint $table) {
            $table->increments('userQuestionResponseID');
            $table->integer('questionID')->unsigned();;
            $table->integer('userID')->unsigned();;
            $table->string('userResponse');
            $table->date('questionDate')->useCurrent();

            $table->foreign('questionID')->references('questionID')->on('xelaQuestions');
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
        Schema::dropIfExists('userQuestionResponse');
    }
}
