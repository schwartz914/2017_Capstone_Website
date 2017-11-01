<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSelectedQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userSelectedQuestion', function (Blueprint $table) {
            $table->integer('userID')->unsigned();
            $table->integer('questionID')->unsigned();
            $table->index(['userID', 'questionID']);

            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('questionID')->references('questionID')->on('xelaQuestions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userSelectedQuestion');
    }
}
