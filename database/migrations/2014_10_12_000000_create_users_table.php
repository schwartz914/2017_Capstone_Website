<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastName');
            $table->integer('weight');
            $table->integer('height');
            $table->date('DOB');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('profession', ['Accounting','Admin & office support','Aged & disability support','Architecture',
            'Athlete','Banker/Teller','CEO & Management','Call Centre and Customer Service','Chef/hospitality','Engineer',
            'Farmer','Flight Attendant','Fundraiser','Graphics Designer','Healthcare Professional','Information & communication technology',
            'Insurance and superannuation','Manufacturing & logistics','Marketing and communications','Mining','Paramedic','Police',
            'Photographer','Pilot','Professional Driver','Real estate','Retail worker','Sport and Recreation','Student','Teacher/Academic',
            'Trades/Construction worker','Unemployed']);
            $table->string('exerciseFrequency');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
