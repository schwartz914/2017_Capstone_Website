<?php


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class xelaQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('xelaQuestions')->insert(
              array(
                      array(
                          'question' => 'Have you been getting enough sleep?',
                          'type' => 'emotional',
                          'tags' => 'general,stress.Hi,mentalHealth.Lo',
                          'affectVars' => 'sleepQuality,mentalHealth'),
                      array(
                          'question' => 'How do your muscles feel?',
                          'type' => 'emotional',
                          'tags' => 'recentlyActive.Lo,exerciseFreq.Hi,musclePain.Hi',
                          'affectVars' => 'musclePain,physicalHealth'),
                      array(
                          'question' => 'Are you feeling fatigued?',
                          'type' => 'emotional',
                          'tags' => 'stress.Hi,mentalHealth.Lo,age.Hi,appetite.Lo',
                          'affectVars' => 'fatigue,mentalHealth'),
                      array(
                          'question' => 'Do you feel ill at all?',
                          'type' => 'emotional',
                          'tags' => 'stress.Hi,appetite.Lo',
                          'affectVars' => 'physicalHealth'),
                      array(
                          'question' => 'How stressed are you?',
                          'type' => 'emotional',
                          'tags' => 'general,timeSlept.Lo,sleepQuality.Lo,mentalHealth.Lo',
                          'affectVars' => 'stress,mentalHealth'),
                      array(
                          'question' => 'How much sleep did you get last night?',
                          'type' => 'numerical',
                          'tags' => 'general,sleepQuality.Lo',
                          'affectVars' => 'timeSlept'),
                      array(
                          'question' => 'How well did you sleep last night?',
                          'type' => 'emotional',
                          'tags' => 'general,stress.Hi,timeSlept.Lo',
                          'affectVars' => 'sleepQuality'),

                      array(
                          'question' => 'How ready do you feel to train?',
                          'type' => 'emotional',
                          'tags' => 'stress.Hi,mentalHealth.Lo,motivation.Lo,recentlyActive.Hi',
                          'affectVars' => 'readinessToTrain,mentalHealth'),
                      array(
                          'question' => 'How sore do you feel?',
                          'type' => 'emotional',
                          'tags' => 'recentlyActive.Lo,exerciseFreq.Hi',
                          'affectVars' => 'physicalHealth'),
                      array(
                          'question' => 'How fatigued are you feeling?',
                          'type' => 'emotional',
                          'tags' => 'stress.Hi,mentalHealth.Lo,timeSlept.Lo',
                          'affectVars' => 'physicalHealth'),
                      array(
                          'question' => 'How would you rate your level of stress?',
                          'type' => 'emotional',
                          'tags' => 'stress.Hi,mentalHealth.Lo,sleepQuality.Lo',
                          'affectVars' => 'stress,mentalHealth'),
                      array(
                          'question' => 'How is your mood today?',
                          'type' => 'emotional',
                          'tags' => 'general,mentalHealth.Lo,sleepQuality.Lo,timeSlept.Lo',
                          'affectVars' => 'mood,mentalHealth'),
                      array(
                          'question' => 'How motivated do you feel?',
                          'type' => 'emotional',
                          'tags' => 'general,mentalHealth.Lo',
                          'affectVars' => 'motivation,mentalHealth'),
                      array(
                          'question' => 'Have you been eating nutritious meals?',
                          'type' => 'emotional',
                          'tags' => 'general,exerciseFreq.Hi,physicalHealth.Lo',
                          'affectVars' => 'nutritionQuality,physicalHealth'),
                      array(
                          'question' => 'How do you feel about eating?',
                          'type' => 'emotional',
                          'tags' => 'mentalHealth.Lo,stress.Hi',
                          'affectVars' => 'appetite,physicalHealth,mentalHealth'),


              ));
    }
}
