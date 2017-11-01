<?php 

namespace App\Http\Controllers;
include('vendor/autoload.php');

use djchen\OAuth2\Client\Provider\Fitbit;
use \Illuminate\Container\Container as Container;
use \Illuminate\Support\Facades\Facade as Facade;
use \Illuminate\Support\Facades\DB as DB;
use Auth;
use GuzzleHttp\Client;

//if (Auth::check())

    $provider = new Fitbit([
        'clientId'          => '228P5Q',
        'clientSecret'      => '3923717ce5255216c6d8d879b24175fe',
        'redirectUri'       => 'http://localhost/laravel/fitbit.php'
    ]);

    // start the session
    session_start();

    // If we don't have an authorization code then get one
    if (!isset($_GET['code'])) {

        // Fetch the authorization URL from the provider; this returns the
        // urlAuthorize option and generates and applies any necessary parameters
        // (e.g. state).
        $authorizationUrl = $provider->getAuthorizationUrl();

        // Get the state generated for you and store it to the session.
        $_SESSION['oauth2state'] = $provider->getState();

        // Redirect the user to the authorization URL.
        header('Location: ' . $authorizationUrl);
        exit;

    // Check given state against previously stored one to mitigate CSRF attack
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');

    } else {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            //echo ($accessToken->hasExpired() ? 'expired' : 'not expired') . "\n";



            

            
            
            // Using the access token, we may look up details about the
            // resource owner.
            $resourceOwner = $provider->getResourceOwner($accessToken);

            //var_export($resourceOwner->toArray());


            // The provider provides a way to get an authenticated API request for
            // the service, using the access token; it returns an object conforming
            // to Psr\Http\Message\RequestInterface.
            $request = $provider->getAuthenticatedRequest(
                Fitbit::METHOD_GET,
                Fitbit::BASE_FITBIT_API_URL . '/1/user/-/profile.json',
                $accessToken,
                ['headers' => [Fitbit::HEADER_ACCEPT_LANG => 'en_US'], [Fitbit::HEADER_ACCEPT_LOCALE => 'en_US']]
                // Fitbit uses the Accept-Language for setting the unit system used
                // and setting Accept-Locale will return a translated response if available.
                // https://dev.fitbit.com/docs/basics/#localization
            );
            echo "ress<br>s<br>s<br>";
            
            // Make the authenticated API request and get the parsed response.
            $response = $provider->getParsedResponse($request);
            var_dump($response);

            // Following code finds the user id, dirty hack job
            // key was off one by hence i have the found variable
            $found = false;
            $fitbitID = "";
            foreach ($response as &$value) {
                foreach ($value as &$value2) {  
                    if ($found){
                        $fitbitID = $value2;
                        $found = false;
                    }
                    if (is_string($value2) && key($value) == "encodedId"){
                            $found = true; 
                    }
                }
            }


            $access = (string)$accessToken->getToken();
            $refresh = (string)$accessToken->getRefreshToken();
            $expire = (string)$accessToken->getExpires();
            $userID = $_SESSION['userID'];
            
            $body = "{\"userID\" : " . $userID . ",\"access_token\" : \"" . $access . "\",\"refresh_token\" : \"" . $refresh . "\",\"expires\" : \"" . $expire . "\",\"fitbitID\" : \"" . $fitbitID . "\"}";
          
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://localhost/laravel/public/api/device/storeNewDevice",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $body,
              CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: bca49283-c200-bd22-5380-be7b97eac7f2"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            unset($_SESSION['userID']);

            var_export($response);

            header('Location: http://localhost/laravel/public/home');
            
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token or user details.
            exit($e->getMessage());
        }

    }
/*} else {
    //re direct to login page
    //header('Location: ');
}
*/

function refreshFitbitToken($existingAccessToken){
    $provider = new Fitbit([
        'clientId'          => '228P5Q',
        'clientSecret'      => '3923717ce5255216c6d8d879b24175fe',
        'redirectUri'       => 'http://localhost/laravel/fitbit.php'
    ]);

    if ($existingAccessToken->hasExpired()) {
        $newAccessToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $existingAccessToken->getRefreshToken()
        ]);

        // Update fitbit token in database here
    }
}