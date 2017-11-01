<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Illuminate\Support\Facades\DB;
use App\User;
use djchen\OAuth2\Client\Provider\Fitbit;
use Mailgun\Mailgun;
use JpGraph;  

class DeviceController extends Controller
{
    public function storeNewDevice(Request $request, User $user)
    {
    	DB::table('fitbitkey')->insertGetId([
              'userID' => $request->input('userID'), 
              'access_token' => $request->input('access_token'), 
              'refresh_token' => $request->input('refresh_token'),
              'expires' => $request->input('expires'),
              'fitbitID' => $request->input('fitbitID')
         ]);

    	return $request->input('access_token');
    }

    // Returns false if device is not connected, else returns access token
    public function deviceExists(Request $request)
    {

      $userID = $request->input('userID');

      $count = DB::table('fitbitkey')->where('userID', $userID)->count();

      if ($count > 0){
        $token = DB::table('fitbitkey')->select('access_token')->where('userID', $userID)->get();
        return $token;
      }

      return "false";
    }

    // Used for mobile, takes email not user id
    public function deviceExistsMobile(Request $request)
    {
      $email = $request->input('email');
      //$response = Users::find($email);
      $response = DB::table('users')->select('id')->where('email', $email)->first();

      $userID = $response->id;

      $count = DB::table('fitbitkey')->where('userID', $userID)->count();

      if ($count > 0){
        $token = DB::table('fitbitkey')->select('access_token', 'fitbitID', 'refresh_token')->where('userID', $userID)->first();

        return "{ \"access_token\" : \"" . $token->access_token . "\", \"refresh_token\" : \"" . $token->refresh_token . "\", \"fitbitID\" : \"" . $token->fitbitID . "\" }";
      }
  
      return Response::json([
          'message' => 'An error occured',
        ], 401);
    }

    /* Fitbit api */ 
    private function getFitbitProvider(){
      return $provider = new Fitbit([
            'clientId'          => '228P5Q',
            'clientSecret'      => '3923717ce5255216c6d8d879b24175fe',
            'redirectUri'       => 'http://localhost/laravel/fitbit.php'
          ]);
    }

    public function fitbitGetProfile(Request $request)
    {      
      if($this->hasExpired($request->input('accessToken'))){
          return Response::json(['message' => 'token has invalid/expired',], 511);
      }
      
      $accessToken = $request->input('accessToken');
      $fitbitId = $request->input('fitbitID'); 
      
      $provider = $this->getFitbitProvider();

      $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/profile.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

      $response = $provider->getParsedResponse($request);

      return $response;
    }

    // gets fitbitid, fitbit access token from request
    public function fitbitGetActivityToday(Request $request)
    {      
      if($this->hasExpired($request->input('accessToken'))){
          return Response::json(['message' => 'token has invalid/expired',], 511);
      }

      $today = date("Y-m-d");
      
      $accessToken = $request->input('accessToken');
      $fitbitId = $request->input('fitbitID'); 
      
      $provider = $this->getFitbitProvider();

      $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/activities/date/' . $today .'.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

      $response = $provider->getParsedResponse($request);

      return $response;
    }

    // takes access token, fitbit ID, start and end date of reporting
    function fitbitReportTimeSeries(Request $request){
      if($this->hasExpired($request->input('accessToken'))){
          return Response::json(['message' => 'token has invalid/expired',], 511);
      }

      $accessToken = $request->input('accessToken');
      $fitbitId = $request->input('fitbitID');
      $startDate = $request->input('startDate');
      $endDate = $request->input('endDate');

      $provider = $this->getFitbitProvider();

      $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/activities/steps/date/' . $startDate . '/' . $endDate .'.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

      $response = $provider->getParsedResponse($request);

      $request2 = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/activities/distance/date/' . $startDate . '/' . $endDate .'.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

      $response2 = $provider->getParsedResponse($request2);

      return $response2 + $response;

    }

    function fitbitGetReportTill(Request $request){

        $accessToken = " ";
        $fitbitId = " ";
        $period = $request->input('period');
        $sendCopy = $request->input('sendCopyToEmail');

        //return $this->createGraph();

        if ($sendCopy == "true"){
            //$this->sendMail(); //TODO ATTACH REPORT IN THIS FUNCTION
        }

      // observee report
      if($request->input('obID') != null){
        //first check if user is actually connected
        $res = DB::table('watcherobservees')->where([
          ['watcherID', '=', $request->input('userID')], 
          ['observeeID', '=', $request->input('obID')], 
          ['completed', '=', 'yes'],])->get();

        $count = count($res);

        if ($count == 0){
            return Response::json(['message' => 'observee does not have any devices',], 411);
        } else {
            // find obID fitbit access token
            $fitbitDetails = DB::table('fitbitkey')->where([['userID', '=', $request->input('obID')]])->first();
            $count = count($fitbitDetails);
            if ($count == 0){
              return Response::json(['message' => 'observee does not have any devices',], 411);
            } else {
              if ($fitbitDetails->expires < time()) {
                return Response::json(['message' => 'observee fitbit access token has expired',], 411);
              }

              $accessToken = $fitbitDetails->access_token;
              $fitbitId = $fitbitDetails->fitbitID;
            }
        }
      } else { // not observee report
        $accessToken = $request->input('accessToken');
        $fitbitId = $request->input('fitbitID');
      }

      if($this->hasExpired($accessToken)){
          return Response::json(['message' => 'device connection is invalid/expired',], 511);
      }

      return $this->makeFitBitRequest($period, $fitbitId, $accessToken, 'activities/distance') 
      + $this->makeFitBitRequest($period, $fitbitId, $accessToken, 'activities/steps')
      + $this->makeFitBitRequest($period, $fitbitId, $accessToken, 'activities/calories')
      + $this->makeFitBitRequest($period, $fitbitId, $accessToken, 'activities/heart')
      + $this->makeFitBitRequestDate($period, $fitbitId, $accessToken, 'sleep');

    }

    public function fitbitGetStepsTimeSeries(Request $request)
    {      
      if($this->hasExpired($request->input('accessToken'))){
          return Response::json(['message' => 'token has invalid/expired',], 511);
      }

      $today = date("Y-m-d");
      
      $accessToken = $request->input('accessToken');
      $fitbitId = $request->input('fitbitID'); 
      
      $provider = $this->getFitbitProvider();

      $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/activities/steps/date/' . $today .'/1m.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

      $response = $provider->getParsedResponse($request);

      return $response;
    }

    //Takes userid and refresh token 
    public function refreshFitbitToken(Request $request)
    {
      $userID = $request->input('userID');

      $provider = $this->getFitbitProvider();
      
      $newAccessToken = $provider->getAccessToken('refresh_token', [
          'refresh_token' => $request->input('refresh_token')
      ]);

      $access = (string)$newAccessToken->getToken();
      $refresh = (string)$newAccessToken->getRefreshToken();
      $expire = (string)$newAccessToken->getExpires();

      DB::table('fitbitkey')->where('userID', $userID)->update([
          'userID' => $userID, 
          'access_token' => $access, 
          'refresh_token' => $refresh,
          'expires' => $expire
        ]);
      
      return $newAccessToken;

    }

    private function hasExpired($access_token){
          $expires = DB::table('fitbitkey')->select('expires')->where('access_token', $access_token)->first();

          if($expires->expires < time()){
            return true;
          } else {
            return false;
          }
    }

    private function makeFitBitRequest($period, $fitbitId, $accessToken, $resourcePath){
        $provider = $this->getFitbitProvider();

        $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                 Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/' . $resourcePath . '/date/today' . '/' . $period  .'.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

        return $provider->getParsedResponse($request);
    }

    private function makeFitBitRequestDate($period, $fitbitId, $accessToken, $resourcePath){
        $provider = $this->getFitbitProvider();

        $endDate = date("Y-m-d");

        // gets date based on period submitted...
        $SECONDS_PER_DAY = 86400;
        $startDate = date('Y-m-d', time() - $this->periodToDate($period) * $SECONDS_PER_DAY);

        $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/' . $resourcePath . '/date/' . $startDate . '/' . $endDate  .'.json',
                //Fitbit::BASE_FITBIT_API_URL . '/1/user/' . $fitbitId . '/' . $resourcePath . '/date/' . $period .'.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_AU'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_AU']]
            );

        //https://api.fitbit.com/1.2/user/-/sleep/date/2017-04-02/2017-04-08.json

        return $provider->getParsedResponse($request);
    }

    private function periodToDate($period){      
      switch ($period) {
        case "1w":
            return 7;
            break;
        case "1m":
            return 30;
            break;
        case "3m":
            return 90;
            break;
        case "6m":
          return 180;
          break;
        case "1y":
          return 365;
          break;
    }
  }

  private function createGraph(){
      

    return $html;
  }

  private function sendMail(){

    # Instantiate the client.
    $mgClient = new Mailgun('******');
    $domain = "*******";

    # Make the call to the client.
    $result = $mgClient->sendMessage("$domain",
              array('from'    => 'XELAS <*******>',
                    'to'      => 'Ahmad Hosseini <capstone2017team13@gmail.com>',
                    'subject' => 'Here\'s Your Report',
                    'attachment' => [
    ['filePath'=>'/tmp/foo.jpg', 'filename'=>'test.jpg']
  ],

                    'text'    => 'Here is your report.'));

    # You can see a record of this email in your logs: https://mailgun.com/app/logs .

    # You can send up to 300 emails/day from this sandbox server.
    # Next, you should add your own domain so you can send 10,000 emails/month for free.
  }
}
