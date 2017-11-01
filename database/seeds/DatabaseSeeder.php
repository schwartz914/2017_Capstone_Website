<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(xelaQuestionSeeder::class);
        //this message shown in your terminal after running db:seed command
        $this->command->info("Xela Questions table seeded :)");
    }
}
