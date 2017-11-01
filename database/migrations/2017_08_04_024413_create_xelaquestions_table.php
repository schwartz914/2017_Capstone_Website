<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXelaQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xelaQuestions', function (Blueprint $table) {
            $table->increments('questionID');
            $table->string('question');
            $table->string('type');
            $table->string('tags');
            $table->string('affectVars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xelaQuestions');
    }
}
