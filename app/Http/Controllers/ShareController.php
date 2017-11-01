<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ShareController extends Controller
{
  public function getUserObservees(Request $request){
      $userID = $request->input('userID');

      $res = DB::table('watcherobservees')->where([['watcherID', '=', $userID], ['completed', '=', 'yes'],])->get();

      //$observeeID = $res->observeeID;

      $response = DB::table('watcherobservees')->join('users', 'watcherobservees.observeeID', '=', 'users.id')
            //->join('fitbitkey', 'watcherobservees.observeeID', '=', 'fitbitkey.userID')
            ->where([['watcherobservees.watcherID', '=', $userID], ['watcherobservees.completed', '=', 'yes'],])->get();

      $count = count($response);

      if ($count == 0){
          return Response::json(['message' => 'No Observees',], 500);
      } else {
          return $response;
      }

  }

  public function getandStoreObserveeCode(Request $request) {
    $observeeEmail = $request->input('observeeEmail');
    //$watcherEmail = $request->input('watcherEmail');
    $response = DB::table('users')->where('email', $observeeEmail)->first();
    $count = count($response);

    if($count == 0){
      return Response::json([
        'message' => 'An error has occured.',
      ], 401);
    } else {
       do {
        $hashed_value = str_random(6);
        $count = DB::table('watcherobservees')->where('observeeCode', $hashed_value)->get();
      } while(count($count) != 0);
      DB::table('watcherobservees')->insertGetId([
        'observeeID' => $response->id,
        'observeeCode' => $hashed_value,
        'dateTimeRequested' => Carbon::now(),
      ]);
      return Response::json([
        'message' => 'Added Observee Code',
        'observeeCode' => $hashed_value,
      ], 200);

    }

  }

  public function watcherConfirmCodeandgetCode(Request $request) {
    //Check if the code is already used and watcherCode is not null
    $watcherEmail = $request->input('watcherEmail');
    $enteredCode = $request->input('enteredObserveeCode');
    $watcherID = DB::table('users')->where('email', $watcherEmail)->value('id');
    if(count($watcherID) == 0) {
      return Response::json([
        'message'=>'An error has occured',
      ], 401);
    }
    $completed = DB::table('watcherObservees')->where([
      ['observeeCode', $enteredCode],
      ])->value('completed');
    if($completed == 'yes') {
      return Response::json([
        'message'=>'That Code is already used.',
      ], 401);
    } else {
      //$response =
      $observeWatchID = DB::table('watcherObservees')->where([
        ['observeeCode', $enteredCode],
        ])->value('observeWatchID');

      do{
        $hashed_value = str_random(6);
        $count = DB::table('watcherobservees')->where('watcherCode', $hashed_value)->get();
      } while(count($count) != 0);
    //  $update = ['watcherID'=> $watcherID], ['watcherCode'=> $hashed_value];
      DB::table('watcherObservees')->where('observeWatchID', $observeWatchID)->update(['watcherID'=> $watcherID, 'watcherCode'=>$hashed_value]);



      return Response::json([
        'message' => 'Added Watcher Code',
        'watcherCode' => $hashed_value,
        'observeWatchID' => $observeWatchID,
        'watcherID' => $watcherID,
      ], 200);
    }
  }

  public function verifyWatcherCode(Request $request) {
    $observeeEmail = $request->input('observeeEmail');
    $enteredCode = $request->input('enteredWatcherCode');
    $observeeID = DB::table('users')->where('email', $observeeEmail)->value('id');
    if(count($observeeID) == 0 || $enteredCode == null) {
      return Response::json([
        'message'=>'An error has occured',
      ], 401);
    }

    $completed = DB::table('watcherObservees')->where([
      ['watcherCode', $enteredCode],
      ])->value('completed');
    if($completed == 'yes') {
      return Response::json([
        'message'=>'That Code is already used.',
        'value'=> $completed,
      ], 401);
    }

    $observeWatchID = DB::table('watcherObservees')->where([
      ['watcherCode', $enteredCode],
      ])->value('observeWatchID');

      if($observeWatchID == null) {
        return Response::json([
          'message'=>'That is not a valid code.',
        ], 401);
      }

    DB::table('watcherObservees')->where('observeWatchID', $observeWatchID)->update(['completed' => 'yes']);

    return Response::json([
      'message' => 'Details Shared',
      'observeWatchID' => $observeWatchID,
      'observeeID' => $observeeID,
    ], 200);

  }



}
