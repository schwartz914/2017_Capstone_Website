 <?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'AuthController@logout');
});

Route::get('users', 'UserController@users');

/* Questions API */
Route::get('questions/get', 'QuestionsController@getQuestions');
Route::post('questions/store', 'QuestionsController@storeQuestions');

/* Tokens */
Route::post('refresh', 'AuthController@refresh');

/* device connections */
Route::post('device/storeNewDevice', 'DeviceController@storeNewDevice');
Route::post('device/deviceExists', 'DeviceController@deviceExists');
Route::post('device/refreshFitbitToken', 'DeviceController@refreshFitbitToken');
// used for mobile, takes email not user id
Route::post('device/deviceExistsMobile', 'DeviceController@deviceExistsMobile');

//fitbit
Route::post('device/fitbit/fitbitGetProfile', 'DeviceController@fitbitGetProfile');
Route::post('device/fitbit/fitbitGetActivityToday', 'DeviceController@fitbitGetActivityToday');
Route::post('device/fitbit/fitbitGetSleepToday', 'DeviceController@fitbitGetSleepToday');
Route::post('device/fitbit/fitbitGetStepsTimeSeries', 'DeviceController@fitbitGetStepsTimeSeries');
Route::post('device/fitbit/fitbitGetReportTill', 'DeviceController@fitbitGetReportTill');

// Recommendations
Route::post('recommendations/getAll', 'RecommendationsController@getAll');

/* AUTH API */

Route::post('auth/register', 'AuthController@register');

Route::post('auth/login', 'AuthController@login');

Route::post('auth/getAccount', 'AuthController@getAccount');

Route::post('auth/updateAccount', 'AuthController@updateAccount');

Route::post('auth/updatePassword', 'AuthController@updatePassword');

// User Sharing

Route::post('shareData/getObserveeCode', 'ShareController@getandStoreObserveeCode');

Route::post('shareData/watcherConfirmCode', 'ShareController@watcherConfirmCodeandgetCode');

Route::post('shareData/finalConfirmCode', 'ShareController@verifyWatcherCode');

Route::post('shareData/getUserObservees', 'ShareController@getUserObservees');

// Steps
Route::post('steps/getSteps', 'StepsController@getSteps');

Route::post('steps/storeSteps', 'StepsController@storeSteps');
