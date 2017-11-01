<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active">
			<img src="{{ asset('images/fitnessphoto1.png') }}" style="width: 100%; height: auto;" alt="Chania">
			<div class="carousel-caption">
			<h1>Practical </h1>
				<p><font size= "4">Quick and easy processes</font></p>
			</div>
		</div>

		<div class="item">
			<img src="{{ asset('images/fitnessphoto2.jpg') }}" style="width: 100%; height: auto;" alt="Chicago">
			<div class="carousel-caption">
            <h1>Physical</h1>
				<p><font size= "4">Seamless monitoring of health data</font></p>
			</div>
		</div>

		<div class="item">
			<img src="{{ asset('images/fitnessphoto3.png') }}" style="width: 100%; height: auto;" alt="New York">
			<div class="carousel-caption">
				<h1>Personable</h1>
                <p><font size= "4">Designed just for you</font></p>
			</div>
		</div>
	</div>

	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
		<span class="sr-only">Next</span>
	</a>
</div>