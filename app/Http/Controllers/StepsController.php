<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use Response;
use App\Http\Requests;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class StepsController extends Controller
{

  public function getSteps(Request $request, User $user) {
    $userID = $request->input('userID');
    $date = $request->input('date');

    $response = DB::table('user_steps')->where([
      ['userID', $userID],
      ['date', $date],
    ])->first();
    if(count($response) == 0) {
      DB::table('user_steps')->insert([
        'userID'=>$userID,
        'steps'=>0,
        'date'=>$date,
      ]);
      return Response::json([
        'message' => 'No Steps Recorded. Entry Created',
      ], 200);
    } else {
      //$steps = $response->'steps';
      return Response::json([
        'message' => 'Step Details',
        'steps' => $response->steps,
      ], 200);
    }

  }

  public function storeSteps(Request $request, User $user) {
    $userID = $request->input('userID');
    $date = $request->input('date');
    $steps = $request->input('steps');
    $userStepsID = DB::table('user_steps')->where([
      ['userID', $userID],
      ['date', $date],
    ])->value('userstepsid');

    if($userStepsID == null) {
      DB::table('user_steps')->insert([
        'userID'=>$userID,
        'steps'=>$steps,
        'date'=>$date,
      ]);
      return Response::json([
            'message' => 'Update Complete',
          ], 200);
    } else {
      $currentSteps = DB::table('user_steps')->where([
        ['userID', $userID],
        ['date', $date],
      ])->value('steps');
      DB::table('user_steps')
        ->where('userstepsid', $userStepsID)
        ->update(['steps'=>$steps+$currentSteps]);

        return Response::json([
              'message' => 'Update Complete',
            ], 200);
    }




  }


}
