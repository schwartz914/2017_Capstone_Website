@extends('layouts.master')

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">

                    <?php if(!fitbitConnected()){ 
                      session_start();
                      $_SESSION['userID'] = Auth::user()->id;
                      ?>

                    <a href="http://localhost/laravel/fitbit.php" class="btn btn-white btn-default active">
                        <i class="fa fa-cog" aria-hidden="true"></i> Connect Fitbit device
                    </a>

                    <?php } else { ?> 
                        fitbit is connected!
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<?php 

function fitbitConnected(){
    $curl = curl_init();
    $userID = Auth::user()->id;

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://localhost/laravel/public/api/device/deviceExists",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n\t\"userID\" : \"" . $userID . "\"\n}",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 2121e510-b525-9167-23ea-d376b6d2c65a"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "Unable to connect your device. Please try again. #:" . $err;
    } else {
    }

    if ($response == " false"){
        return false;
    } else {
        return true;
    }
}

?>