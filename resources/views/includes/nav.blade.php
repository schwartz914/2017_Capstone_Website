<nav class="navbar-inverse">
	<div class="container">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				<a class="navbar-brand" href="{{ url('/') }}"><img id="navLogo" src="{{ asset('images/whitelogo.png') }}"></a>
			</div>

			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">

					<li class="{{ Request::is('/') ? 'active' : '' }}"> <a href="{{ url('/') }}">Home</a> </li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Contact Us</a></li>

				</ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}"> <span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li><a href="{{ route('register') }}"> <span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li> <a href="#" > Share Data </a></li>
                                <li> <a href="#" > Settings </a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
			</div>
		</div>
	</div>
</nav>