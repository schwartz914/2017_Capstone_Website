<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Laravel\Passport\Client;
use Response;
use App\Http\Requests;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Carbon;


class QuestionsController extends Controller
{

    private $client;

    public function __construct()
    {
      $this->client = Client::find(1); // references password client
    }

    public function getQuestions(Request $request)
    {
        $questions = DB::table('xelaquestions')->get()->toJson();

        return $questions;
    }

    public function storeQuestions(Request $request)
    {
      $email = $request->input('email');
      $user = DB::table('users')->where('email', $email)->first();

      for ($i = 0; $i < $request->input('numQuestions'); $i++){
          $questionID = "questions." . $i . ".id";
          $questionResponse = "questions." . $i . ".response";

          DB::table('userquestionresponse')->insertGetId([
              'questionID' => $request->input($questionID),
              'userID' => $user->id,
              'userResponse' => $request->input($questionResponse),
              'questionDate' => Carbon\Carbon::now()
          ]);
      }

      return "success";
    }
}
