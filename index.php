<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");

	// Confirm_Login();
?>


<!DOCTYPE html>
<html>
<head>
	<title>Freelancing</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css-files/animate.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/freelance.css">
</head>
<body>

	<?php 
						echo ErrorMessage();
						echo SuccessMessage();
					?>
	<nav class="navbar navbar-expand-md navbar-light bg-light">
	    <a href="#" class="navbar-brand">
	    	 <span> S</span>tretch<span>.</span>
		</a>

	    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
	        <span class="navbar-toggler-icon"></span>
	    </button>

	    <div class="collapse navbar-collapse" id="navbarCollapse">
	    	<div class="ml-auto mynav">
		        <div class="navbar-nav">
		            <a href="#" class="nav-item nav-link">Home</a>
		            <a href="#aboutUs" class="nav-item nav-link" onclick="effectabout()">About Us</a>
		            <a href="#categories" class="nav-item nav-link" onclick="effectcategory()">Categories</a>
		            <a href="#" class="nav-item nav-link" tabindex="-1"></a>
		
		            
		        </div>
		        <div class="navbar-nav">
		            <a href="how-to.php" class="nav-item nav-link">How To</a>
		            <a href="login.php" class="nav-item nav-link">Login</a>
		            <a href="registrationpage.php" class="nav-item nav-link">Register</a>
		        </div>
	    	</div>
	    </div>
	</nav>

			<!-- backgroundimag starts here-->
		<div class="imagecont">
			<div class="writeupcont">
				<div class="writeup-items text-center">
					<h1 class="writeuptext"> A platform You can trust</h1>
					<p class="writeuptext"> Connect and work with talented freelancers to turn Your idea into a reality</p>

					<div class="choice">
						<a href="registrationpage.php"> I want to hire</a>
						<a href="registrationpage.php"> I want to work</a>
					</div>

				</div>
			</div>
		</div>


				<!-- ABOUT -->
		<div class="container" style="margin-top: 100px" id="aboutUs">
			<center><h3> About Us </h3> <hr></center>
			<div class="row">
				<div class="col-md-4" style="display: flex;justify-content: center">
					<img src="images/logo4.jpg" width="50%" height="100%" id="aboutImg">
				</div>
				<div class="col-md-8">
					<p style="font-size: 20px;">We are a trusted platform that enables individuals to connect and conduct business. Our mission is to create economic opportunites so that individuals can live a life made easy by enabling freelancers find work that fits the specified skillset and also for employers to get their work done with ease. With this platform, business has been pioneered into a better method and talents are connected to more opportunities.</p>
				</div>
			</div>
		</div>


				<!-- CATEGORIES -->
		<div class="container" style="margin-top: 100px" id="categories">
			<center><h3> Categories </h3> <hr></center>
			<div class="row center">
				<div class="col-md-4 center-card" >
					<div class="card" style="width: 300px;">
					    <img src="images/web_design.jpeg" class="card-img-top" alt="web development Image">
					    <div class="card-body text-center">
					        <h5 class="card-title"> Web Design</h5>
					    </div>
					</div>
				</div>

				<div class="col-md-4 center-card">
					<div class="card" style="width: 300px;">
					    <img src="images/web_dev.jpeg" class="card-img-top" alt="web development Image">
					    <div class="card-body text-center">
					        <h5 class="card-title"> Web Developement</h5>
					    </div>
					</div>
				</div>

				<div class="col-md-4 center-card">
					<div class="card" style="width: 300px;">
					    <img src="images/android_dev.jpeg" class="card-img-top" alt="web development Image">
					    <div class="card-body text-center">
					        <h5 class="card-title"> Android Developement</h5>
					    </div>
					</div>
				</div>

			</div>
			<div class="row mt-5">
				<div class="col-md-4 center-card">
					<div class="card" style="width: 300px;">
					    <img src="images/IOS_dev.jpeg" class="card-img-top" alt="web development Image">
					    <div class="card-body text-center">
					        <h5 class="card-title"> IOS Developement</h5>
					    </div>
					</div>
				</div>

				<div class="col-md-4 center-card">
					<div class="card" style="width: 300px;">
					    <img src="images/content_writer.jpg" class="card-img-top" alt="web development Image">
					    <div class="card-body text-center">
					        <h5 class="card-title"> Content Writing</h5>
					    </div>
					</div>
				</div>

				<div class="col-md-4 center-card" style="align-items: center;">
					<div class="circle" style="display: flex; justify-content: center" onclick="sendToRegisterPage()">
						<!-- <div class="circle "> -->
							&rightarrow;
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>






		<div class="footer">
			<center><i>A Platform You Can Trust...</i></center>
		</div>

<script type="text/javascript" src="../../popper/docs/js/jquery.min.js"></script>
<script type="text/javascript" src="../../popper/docs/js/main.js"></script>
<script type="text/javascript" src="../../bootstrap/dist/js/bootstrap.js"></script>
<script>
	function effectabout(){
		var addnimation = document.getElementById('aboutImg');
		addnimation.classList.add("animated","bounceIn");
	}
	function sendToRegisterPage(){
		window.location.href="registrationpage.php";
	}
</script>
</body>
</html>