@extends('layouts.master')

@section('title')
    Sign Up
@endsection()

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <!-- First Name -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label for="lastName" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="lastName" type="lastName" class="form-control" name="lastName" value="{{ old('lastName') }}" required>

                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="form-group{{ $errors->has('DOB') ? ' has-error' : '' }}">
                            <label for="DOB" class="col-md-4 control-label">DOB</label>

                            <div class="col-md-6">
                                <input id="DOB" type="date" class="form-control" name="DOB" value="{{ old('DOB') }}" required autofocus>

                                @if ($errors->has('DOB'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('DOB') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Profession -->
                        <div class="form-group{{ $errors->has('profession') ? ' has-error' : '' }}">
                            <label for="profession" class="col-md-4 control-label">Profession/Field of Work</label>
                            <!--Added val to just store the number value assigned to a job. Peter -->

                            <div class="col-md-6">
                                <select class="form-control" name="profession" id="profession">
                                    <option disabled selected required>Select...</option>
                                    <option val="1" value="Accounting">Accounting</option>
                                    <option val="1" value="Admin & office support">Admin & office support</option>
                                    <option val="2" value="Aged & disability support">Aged & disability support</option>
                                    <option val="1" value="">Architecture">Architecture</option>
                                    <option val="5" value="Athlete">Athlete</option>
                                    <option val="1" value="Banker/Teller">Banker/Teller</option>
                                    <option val="1" value="CEO & Management">CEO & Management</option>
                                    <option val="1" value="Call Centre and Customer Service">Call Centre and Customer Service</option>
                                    <option val="2" value="Chef/hospitality">Chef/hospitality</option>
                                    <option val="1" value="Engineer">Engineer</option>
                                    <option val="4" value="Farmer">Farmer</option>
                                    <option val="3" value="Flight Attendant">Flight Attendant</option>
                                    <option val="2" value="Fundraiser">Fundraiser</option>
                                    <option val="1" value="Graphics Designer">Graphics Designer</option>
                                    <option val="1" value="Healthcare Professional">Healthcare Professional</option>
                                    <option val="1" value="Information & communication technology">Information & communication technology</option>
                                    <option val="1" value="Insurance and superannuation">Insurance and superannuation</option>
                                    <option val="3" value="Manufacturing & logistics">Manufacturing & logistics</option>
                                    <option val="1" value=">Marketing and communications">Marketing and communications</option>
                                    <option val="4" value="Mining">Mining</option>
                                    <option val="3" value="Paramedic">Paramedic</option>
                                    <option val="3" value="Police">Police</option>
                                    <option val="2" value="Photographer">Photographer</option>
                                    <option val="1" value="Pilot">Pilot</option>
                                    <option val="1" value="Professional Driver">Professional Driver </option>
                                    <option val="1" value="Real estate">Real estate</option>
                                    <option val="2" value="Retail worker">Retail worker</option>
                                    <option val="3" value="Sport and Recreation">Sport and Recreation</option>
                                    <option val="1" value="Trades/Construction worker">Trades/Construction worker</option>
                                    <option val="1" value="Unemployed">*Unemployed</option>
                                </select>

                                @if ($errors->has('profession'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profession') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Exercise Frequency -->
                        <div class="form-group{{ $errors->has('exerciseFrequency') ? ' has-error' : '' }}">
                            <label for="exerciseFrequency" class="col-md-4 control-label">How often do you exercise?</label>

                            <div class="col-md-6">
                                <select class="form-control" name="exerciseFrequency" id="exerciseFrequency">
                                    <option disabled selected required>Select...</option>
                                    <option id="NoExercise" value="0">I do not exercise</option>
                                    <option value="2">1-2 times a week</option>
                                    <option value="3">3 times a week</option>
                                    <option value="4">4 times a week</option>
                                    <option value="5">5 times a week</option>
                                    <option value="6">6 times a week</option>
                                    <option value="7">7 or more times a week</option>
                                </select>

                                @if ($errors->has('exerciseFrequency'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('exerciseFrequency') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    

                        <!-- Height -->
                        <div class="form-group{{ $errors->has('height') ? ' has-error' : '' }}">
                            <label for="height" class="col-md-4 control-label">Height (cm)</label>

                            <div class="col-md-6">
                                <input id="height" type="number" class="form-control" name="height" value="{{ old('height') }}" required autofocus>

                                @if ($errors->has('height'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('height') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Weight -->
                        <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                            <label for="weight" class="col-md-4 control-label">Weight (kg)</label>

                            <div class="col-md-6">
                                <input id="weight" type="number" class="form-control" name="weight" value="{{ old('weight') }}" required autofocus>

                                @if ($errors->has('weight'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight ') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="img-responsive center-block text-center"><img width="100%" src="{{ asset('images/customerjourney.png') }}"> </div>

<!-- Scripts -->
<script src="{{ asset('js/regoForm.js') }}" type="text/javascript"></script>

@endsection()
