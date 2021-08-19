<?php
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");

// if(isset($_SESSION['User_ID'])){
// 	Redirect_to("freelancerdashboard.php");
// }
if (isset($_POST['loginfreelancer'])) {
	$Email = $_POST['email'];
	$Password = $_POST['pass'];

	if (empty($Email) || empty($Password)) {
		echo "<script> alert('All feilds must be filled out')</script>";
		// Redirect_to("login.php");

	} else {


		$found_Account = Login_Freelancer_Attempt($Email);
		if ($found_Account) {
			if (password_verify($Password, $found_Account["pass"])) {

				$_SESSION['Freelancer_ID'] = $found_Account["id"];
				$_SESSION['FreelancerName'] = $found_Account["firstname"];
				$_SESSION["SuccessMessage"] = "Welcome to your dashboard";
				Redirect_to('freelancerdashboard.php');
			} else {

				$_SESSION["SuccessMessage"] = "Incorrect password";
				Redirect_to('login.php');
			}

			// echo "Welcome to your dashboard";
		} else {
			$_SESSION["ErrorMessage"] = "incorrect email/password";
		}
	}
}


// this login is for the client
if (isset($_POST['loginclient'])) {
	$Email = $_POST['email'];
	$Password = $_POST['pass'];

	if (empty($Email) || empty($Password)) {
		echo "<script> alert('All feilds must be filled out')</script>";
		// Redirect_to("login.php");

	} else {
		// this function makes sure that if there is one user with the details, then it takes the user to the dashboard.

		$found_Account = Login_Client_Attempt($Email);
		if ($found_Account) {
			if (password_verify($Password, $found_Account["pass"])) {

				$_SESSION['User_ID'] = $found_Account["id"];
				$_SESSION['UserName'] = $found_Account["firstname"];

				$_SESSION["SuccessMessage"] = "Welcome to dashbord";
				Redirect_to('companydashboard.php');
			} else {

				$_SESSION["SuccessMessage"] = "Incorrect password";
				Redirect_to('login.php');
			}
		} else {
			// echo "incorrect email/password";
			$_SESSION["ErrorMessage"] = "Something went wrong. Try again";
			// Redirect_to("post.php");
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/register.css">
	<link rel="stylesheet" type="text/css" href="css-files/login.css">
</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col-md-6 loginformspace">

				<div class="mycontainhidereg loginchoice container" id="loginchoice">
					<?php echo ErrorMessage(); ?>
					<?php echo SuccessMessage(); ?>
					<div class="row">

						<div class="col-md-6">

							<p class="loginasfreelancer" onclick="openTabs(event, 'loginformfreelancer')"> login as freelancer
							</p>

						</div>

						<div class="col-md-6">
							<p class="loginasclient" onclick="openTabs(event, 'loginformclient')" name="clientloginbtn">login as client</p>
						</div>
					</div>
				</div>

				<div class="mycont mycontainhidereg" id="loginformfreelancer">
					<div class="container">
						<form method="POST" action="login.php" class="text-center">
							<input type="email" name="email" placeholder="Enter Email" class="inputs"> <br>
							<input type="password" name="pass" placeholder="Enter password" class="inputs"><br>

							<input type="submit" name="loginfreelancer" value="Login" class="reg">

							<p>Don't have an account? <a href="registrationpage.php">Register </a></p>
						</form>
					</div>
				</div>

				<div class="mycont mycontainhidereg" id="loginformclient">
					<div class="container">
						<form method="POST" action="login.php" class="text-center">
							<input type="email" name="email" placeholder="Enter Email" class="inputs"> <br>
							<input type="password" name="pass" placeholder="Enter password" class="inputs"><br>

							<input type="submit" name="loginclient" value="Login" class="reg">

							<p>Don't have an account? <a href="registrationpage.php">Register </a></p>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<img src="images/image3.jpg">
			</div>
		</div>
	</div>


	<script>
		function openTabs(e, tabId) {
			var i, mycontainhidereg;

			mycontainhidereg = document.getElementsByClassName('mycontainhidereg');
			for (i = 0; i < mycontainhidereg.length; i++) {
				mycontainhidereg[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}
		window.onload = function() {
			openTabs(event, 'loginchoice');

		}
	</script>

	<!-- javascript goes here -->
	<script type="text/javascript" src="popper/docs/js/jquery.min.js"></script>
	<script type="text/javascript" src="popper/docs/js/main.js"></script>
	<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>