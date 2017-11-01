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

class RecommendationsController extends Controller
{
    public function getAll(Request $request)
    {
        $userId = $request->input('userId');
        $recommendations = DB::table('recommendations')->where('userId', $userId)->get()->toJson();

        $json = "{ \"recommendations\" :" . $recommendations . "}";

        return $json;
    }

}
/*

"questions":[  
   {  
      "questionID":1,
      "question":"Have you been getting enough sleep?",
      "type":"emotional",
      "tags":"general,stress,mentalHealth",
      "affectVars":"sleepQuality,mentalHealth"
   },


   */