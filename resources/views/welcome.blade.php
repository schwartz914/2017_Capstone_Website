@extends('layouts.master')

@section('title')
    XELAS
@endsection()

@section('banner')
	@include('includes.banner')
@endsection()

@section('content')


&nbsp;




            <div class="container text-center"id="topofpage">
            <div class="img-responsive center-block"><img width="80%" src="{{ asset('images/diagram1.png') }}"> </div>


              <div class="well" style= background-color:#4A90E2;color:white;>
               <p><font size= "3"> Modern day fitness applications are capable in many ways. They are able to cater to our needs from a health perspective, but whether they are able to factor in wellness aspects is yet to be seen. Xelas aims to shift the current landscape within the industry by integrating health and wellness data into an all in one solution.</font></p>

              </div>
    
                <hr style="width: 100%; color: #8fb6d8; height: 4px; background-color:#8fb6d8;"/>


                        <h2 style="color:#4A90E2">Our solution comprises of three elements!</h2>
                          <img width="100%" src="{{ asset('images/solutions.png') }}">

               

                <hr>
                   <img width="100%" src="{{ asset('images/screens.png') }}">
                <hr>

                <div class="container text-center">
                    <div class="sec3">
                        <h2 style="color:#4A90E2">What's next?</h2>
                        &nbsp;
                        <p><strong><font size= "4"><em>Join us and start your new and improved life!</em></font></strong></p>
                        &nbsp;
                           <ol>
                            <li align="left"><strong>Install Application</strong> - Download the Xelas Application from the Google Play Store and install it on your mobile device</li>&nbsp;
                               
                            <li align="left"><strong>Sign up</strong> - Fill out our registration form and sign up for our services</li>&nbsp;
                               
                            <li align="left"><strong>Pair your Fitbit Device</strong> - Enter in your Fitbit login and pair your device with our application</li>&nbsp;
                               
                            <li align="left"><strong>Answer Questions</strong> - Respond to your custom daily questionnaire</li>&nbsp;
                               
                            <li align="left"><strong>Receive Reports &amp; Recommendations</strong> - Enquire about your progress at a touch of a button</li>&nbsp;
                               
                            <li align="left"><strong>Share Data</strong> - Share your information with your friends and family</li>&nbsp;
                               
                            <li align="left"><strong>Live Life!</strong> - Live your life whilst being informed about your health and wellness</li>
                          </ol>
                      </div>


                            <div class="img-responsive center-block"><img width="100%" src="{{ asset('images/customerjourney.png') }}"> </div>
                </div>




        

@endsection()
