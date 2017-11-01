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


class AuthController extends Controller
{
    private $client;

    public function __construct()
    {
      $this->client = Client::find(1); // references password client
    }

    /* CODE AND TOKEN AUTH FOR SIGN UP */

    public function register(Request $request, User $user)
    {

      $this->validate($request,[
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'height' => 'required|integer|max:300|min:0',
            'weight' => 'required|integer|max:800|min:0',
            'email' => 'required|string|email|max:255|unique:users',
            'profession' => 'required|string|max:191|min:0',
            'exerciseFrequency' => 'required|integer',
            'DOB' => 'required|string',
            'password' => 'required|string|min:6',
    	]);


    	$user->create([
    		    'name' 		=> $request->name,
            'lastName' 	=> $request->lastName,
            'height' 	=> $request->height,
            'weight' 	=> $request->weight,
            'email' 	=> $request->email,
            'profession'=> $request->profession,
            'exerciseFrequency' => $request->exerciseFrequency,
            'DOB' => $request->DOB,
            'password' 	=> bcrypt($request->password),
    		]);
      

      $params = [
          'grant_type' => 'password',
          'client_id' => $this->client->id,
          'client_secret' => $this->client->secret,
          'username' => request('email'),
          'password' => request('password'),
          'scope' => '*'
      ];

      $request->request->add($params);

      $proxy = Request::create('oauth/token', 'POST');

      $userDetails = DB::table('users')->where('email', $request->email)->first(); // find the user

      DB::table('uservariables')->insert([
                  'userID' => ($userDetails->id),
                  'mentalHealth' => '5',
                  'physicalHealth' => '5',
                  'appetite' => '5',
                  'fatigue' => '5',
                  'mood' => '5',
                  'motivation' => '5',
                  'musclePain' => '5',
                  'nutritionQuality' => '5',
                  'readinessToTrain' => '5',
                  'sleepQuality' => '5',
                  'stress' => '5',
                  'timeSlept' => '5'
              ]);

      $pow = Route::dispatch($proxy);
      //line below is removing the final character ' } ', concating userid then in json
      $remove = substr($pow->getContent(), 0, -1) . ", \"userID\": " . $userDetails->id . "}";


      return $remove;
    }

    /* CODE AND TOKEN AUTH FOR LOGIN */

    public function login(Request $request, User $user)
    {
      //if email and password didn't match any user, return 401 error
      if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
          return response()->json(['error' => 'Wrong credentials'], 401);
      }

      $params = [
          'grant_type' => 'password',
          'client_id' => $this->client->id,
          'client_secret' => $this->client->secret,
          'username' => request('email'),
          'scope' => '*'
      ];

      $request->request->add($params);

      $proxy = Request::create('oauth/token', 'POST');

      $userDetails = DB::table('users')->where('email', $request->email)->first(); // find the user

      $pow = Route::dispatch($proxy);
      //line below is removing the final character ' } ', concating userid then in json
      $remove = substr($pow->getContent(), 0, -1) . ", \"userID\": " . $userDetails->id . "}";

      return $remove;
    }

    // refresh token
    public function refresh(Request $request)
    {
      $this->validate($request, [
          'refresh_token' => 'required'
      ]);

      $params = [
          'grant_type' => 'refresh_token',
          'client_id' => $this->client->id,
          'client_secret' => $this->client->secret,
          'username' => request('email'),
          'password' => request('password')
      ];

      $request->request->add($params);

      $proxy = Request::create('oauth/token', 'POST');

      return Route::dispatch($proxy);
    }

    public function logout(Request $request)
    {
      $accessToken = Auth::user()->token();

      DB::table('oauth_fresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);

      $accessToken->revoke();

      return response()->json([], 204);

    }

    /* END LOGIN */

    public function getAccount(Request $request, User $user)
    {

      $email = $request->input('email');
      //$response = Users::find($email);
      $response = DB::table('users')->where('email', $email)->first();
      $count = count($response);
      if($count == 0) {
        return Response::json([
          'message' => 'An error occured',
        ], 401);
      } else {
        return Response::json([
          'message'=>'Details gathered.',
          'user' => $response->name,
          'lastName' => $response->lastName,
          'weight' => $response->weight,
          'height' => $response->height,
          'dob' => $response->DOB,
          'email' => $response->email,
          'profession' => $response->profession,
          'exerciseFrequency' => $response->exerciseFrequency
        ], 200);
      }
    }

    private function exerciseFrequency($input)
    {
      $exerciseValue = 0;
      switch ($input['exerciseFrequency']) {
                    case "I do not exercise":
                        $exerciseValue = 0;
                        break;
                    case "1-2 times a week":
                        $exerciseValue = 2;
                        break;
                    case "3 times a week":
                        $exerciseValue = 3;
                        break;
                    case "4 times a week":
                        $exerciseValue = 4;
                        break;
                    case "5 times a week":
                        $exerciseValue = 5;
                        break;
                    case "6 times a week":
                        $exerciseValue = 6;
                        break;
                    case "7 or more times a week":
                        $exerciseValue = 7;
                        break;
                };
                return $exerciseValue;

    }

    private function professionValue($input)
    {
      $professionValue = 0;
      switch ($input['profession']) {
                    case "Accounting":
                    case "Admin & office support":
                    case "Architecture":
                    case "Banker/Teller":
                    case "CEO & Management":
                    case "Call Centre and Customer Service":
                    case "Engineer":
                    case "Graphics Designer":
                    case "Healthcare Professional":
                    case "Information & communication technology":
                    case "Insurance and superannuation":
                    case "Marketing and communications":
                    case "Pilot":
                    case "Professional Driver":
                    case "Real estate":
                    case "Student":
                    case "Teacher/Academic":
                    case "Unemployed":
                        $professionValue = 1;
                        break;
                    case "Aged & disability support":
                    case "Chef/hospitality":
                    case "Fundraiser":
                    case "Photographer":
                    case "Retail worker":
                        $professionValue = 2;
                        break;
                    case "Flight Attendant":
                    case "Manufacturing & logistics":
                    case "Paramedic":
                    case "Police":
                    case "Sport and Recreation":
                        $professionValue = 2;
                        break;
                    case "Farmer":
                    case "Mining":
                    case "Trades/Construction worker":
                        $professionValue = 2;
                        break;
                    case "Athlete":
                        $professionValue = 5;
                }

                return $professionValue;

    }

    public function updateAccount(Request $request)
    {
      $input = $request->input();

      $input['exerciseFrequency'] = AuthController::exerciseFrequency($input);

      //$input['professionValue'] = AuthController::professionValue($input);

      $email  = $request['email'];

      $user = User::whereEmail($email)->first();
      $user->name = $input['name'];
      $user->lastName = $input['lastName'];
      $user->weight = $input['weight'];
      $user->height = $input['height'];
      $user->profession = $input['profession'];
      //$user->professionValue = $input['professionValue'];
      $user->exerciseFrequency = $input['exerciseFrequency'];


      if(!$user->isDirty()) {
        return Response::json([
          'message' => 'No Details updated',
        ], 200);
      } else if($user->isDirty()) {
        $user->save();
        return Response::json([
              'message' => 'Update Complete',
            ], 200);
      } else {
        return Response::json([
              'message' => 'Update Not Complete',
            ], 401);
      }
    }


    public function updatePassword(Request $request, User $user)
    {
      $email = $request['email'];
      $password = $request['password'];
      $newPassword = $request['newPassword'];

      if(!Auth::attempt(['email' => $email, 'password' => $password])){
          return Response::json([
            'message' => 'Wrong credentials'
          ], 401);
      }
      $user = User::whereEmail($email)->first();
      $user->password = bcrypt($newPassword);

      $user->save();
      return Response::json([
        'message' => 'Password Updated!',
      ], 200);


    }


public function getUserVars(Request $request, User $user)
    {

      $userID = $request->input('userID');
      //$response = Users::find($email);
      $response = DB::table('userVariables')->where('userID', $userID)->first();
      $count = count($response);
      if($count == 0) {
        return Response::json([
          'message' => 'An error occured',
        ], 401);
      } else {
        return Response::json([
            'mentalHealth' => $response->mentalHealth,
            'physicalHealth' => $response->physicalHealth,
            'appetite' => $response->appetite,
            'fatigue' => $response->fatigue,
            'mood' => $response->mood,
            'motivation' => $response->motivation,
            'musclePain' => $response->musclePain,
            'nutritionQuality' => $response->nutritionQuality,
            'readinessToTrain' => $response->readinessToTrain,
            'sleepQuality' => $response->sleepQuality,
            'stress' => $response->stress,
            'timeSlept'=> $response->timeSlept,
        ], 200);
      }
    }



}
