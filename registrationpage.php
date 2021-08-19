<?php

require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");
if (isset($_POST['registerasclient'])) {
	if (!empty($_POST['Firstname']) && !empty($_POST['Lastname']) && !empty($_POST['dateofbirth']) && !empty($_POST['email']) && !empty($_POST['phonenumber']) && !empty($_POST['gender']) && !empty($_POST['pass']) && !empty($_POST['pass2'])) {
		$firstname = $_POST['Firstname'];
		$Lastname = $_POST['Lastname'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$dateofbirth = $_POST['dateofbirth'];
		$dateofbirth = strtotime($dateofbirth);
		$dateofbirth = date('d M, Y', $dateofbirth);
		$gender = $_POST['gender'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];
		$password_hash = password_hash($pass, PASSWORD_DEFAULT);
		$profile_picture = $_FILES["ProfileImage"]["name"];
		$TargetOne = "images/freelancer_Profile_Pictures/" . basename($_FILES["ProfileImage"]["name"]);

		if (preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $email)) {

			// if (preg_match("(^[0]\d{10}$)", $phonenumber)) {


			if ($pass === $pass2) {
				function checkIfUserNameExistsorNot($email)
				{
					global $ConnectingDB;
					$sql = "SELECT email FROM registerpage WHERE email =:emaiL";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue(':emaiL', $email);
					$stmt->execute();
					$Result = $stmt->rowcount();
					if ($Result == 1) {
						return true;
					} else {
						return false;
					}
				}
				global $ConnectingDB;
				if (!checkIfUserNameExistsorNot($email)) {
					global $ConnectingDB;
					$sql = "INSERT INTO registerpage(firstname, lastname, email, phonenumber, pass, profile_picture, dateofbirth, gender)
								VALUES(:firstnamE,:lastnamE,:emaiL,:phonenumbeR,:passworD, :profile_picturE, :dateofbirtH, :gendeR)";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue('firstnamE', $firstname);
					$stmt->bindValue('lastnamE', $Lastname);
					$stmt->bindValue('emaiL', $email);
					$stmt->bindValue('phonenumbeR', $phonenumber);
					$stmt->bindValue('passworD', $password_hash);
					$stmt->bindValue(':profile_picturE', $profile_picture);
					$stmt->bindValue('dateofbirtH', $dateofbirth);
					$stmt->bindValue('gendeR', $gender);
					$Execute = $stmt->execute();
					if ($Execute) {
						$SearchQueryParameter = $ConnectingDB->lastInsertId();
						move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $TargetOne);
						$_SESSION["SuccessMessage"] = "Registration Successful.Please login";
						Redirect_to('login.php');
					}
				} else {
					echo "Email already exists";
				}
			} else {
				echo "<script> alert('passwords do not match');</script>";
			}

			// }else{
			// 	echo "<script> alert('Must be a nigerian');</script>";
			// }

		} else {
			echo "<script> alert('invalid email address');</script>";
		}
	} else {
		echo "<script> alert('please fill out the form');</script>";
	}
}

// this is for the freelancers' registeration form
if (isset($_POST['registerasfreelancer'])) {
	if (!empty($_POST['Firstname']) && !empty($_POST['Lastname']) && !empty($_POST['dateofbirth']) && !empty($_POST['email']) && !empty($_POST['phonenumber']) && !empty($_POST['gender']) && !empty($_POST['pass']) && !empty($_POST['pass2']) && !empty($_POST['freelancecategory'])) {
		$firstname = $_POST['Firstname'];
		$Lastname = $_POST['Lastname'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$dateofbirth = $_POST['dateofbirth'];
		$dateofbirth = strtotime($dateofbirth);
		$dateofbirth = date('d M, Y', $dateofbirth);
		$gender = $_POST['gender'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];
		$password_hash = password_hash($pass, PASSWORD_DEFAULT);
		$freelancecategory = $_POST['freelancecategory'];
		$profile_picture = $_FILES["ProfileImage"]["name"];
		$TargetOne = "images/freelancer_Profile_Pictures/" . basename($_FILES["ProfileImage"]["name"]);

		if (preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $email)) {

			// if (preg_match("(^[0]\d{10}$)", $phonenumber)) {


			if ($pass === $pass2) {
				function checkfreelancerNameExistsorNot($email)
				{
					global $ConnectingDB;
					$sql = "SELECT email FROM registerfreelancer WHERE email =:emaiL";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue(':emaiL', $email);
					$stmt->execute();
					$Result = $stmt->rowcount();
					if ($Result == 1) {
						return true;
					} else {
						return false;
					}
				}
				global $ConnectingDB;
				if (!checkfreelancerNameExistsorNot($email)) {
					global $ConnectingDB;
					$sql = "INSERT INTO registerfreelancer(firstname, lastname, email, phonenumber, pass, profile_picture, dateofbirth, gender, freelancecategory)
								VALUES(:firstnamE,:lastnamE,:emaiL,:phonenumbeR,:passworD, :profile_picturE, :dateofbirtH, :gendeR, :freelancecategorY)";
					$stmt = $ConnectingDB->prepare($sql);
					$stmt->bindValue('firstnamE', $firstname);
					$stmt->bindValue('lastnamE', $Lastname);
					$stmt->bindValue('emaiL', $email);
					$stmt->bindValue('phonenumbeR', $phonenumber);
					$stmt->bindValue('passworD', $password_hash);
					$stmt->bindValue(':profile_picturE', $profile_picture);
					$stmt->bindValue('dateofbirtH', $dateofbirth);
					$stmt->bindValue('gendeR', $gender);
					$stmt->bindValue('freelancecategorY', $freelancecategory);
					$Execute = $stmt->execute();
					if ($Execute) {
						$SearchQueryParameter = $_GET['id'];
						move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $TargetOne);
						$_SESSION["SuccessMessage"] = "Registration Successful.Please login";
						Redirect_to('login.php');
					} else {
						$_SESSION["ErrorMessage"] = "Something went wrong. Try again";
						Redirect_to("registrationpage.php");
					}
				} else {
					$_SESSION["ErrorMessage"] = "Email already exists. Try again";
					Redirect_to("registrationpage.php");
				}
			} else {
				$_SESSION["ErrorMessage"] = "passwords do not match";
				Redirect_to("registrationpage.php");
			}


			//else{
			// 	$_SESSION["ErrorMessage"]= "passwords do not match";
			// 	Redirect_to("registrationpage.php");
			//}

		} else {
			$_SESSION["ErrorMessage"] = "invalid email address";
			Redirect_to("registrationpage.php");
		}
	} else {
		$_SESSION["ErrorMessage"] = "Sorry, Fields cannot be empty.";
		Redirect_to("registrationpage.php");
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/register.css">
</head>

<body>
	<?php
	echo ErrorMessage();
	echo SuccessMessage();
	?>
	<div class="container maincon">
			<div class="userregistrationchoice">
				<div onclick="openTabs(event, 'iWantToWork')"> Register as Freelancer</div>
				<div onclick="openTabs(event, 'iWantToHire')"> Register as Client</div>
			</div>
			<div class="text-center mb-4">
				<img src="images/logo4.jpg" height="95px" width="50px">
				<h3>stretch</h3>
			</div>
			<form class="mycontainhidereg" id="iWantToWork" action="registrationpage.php" method="POST" enctype="multipart/form-data">
				<h4><em>I am a freelancer...</em></h4>
				<div class="text-center">
					<input type="text" name="Firstname" placeholder="Enter Firstname" class="inputs"> <br>
					<input type="text" name="Lastname" placeholder="Enter Lastname" class="inputs"> <br>
					<input type="email" name="email" placeholder="Enter email" class="inputs"><br>
					<input type="text" name="phonenumber" placeholder="Enter phonenumber" class="inputs"><br>
					<div class=" row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-file">
									<input class="inputs" type="date" name="dateofbirth" placeholder="What is your date of birth">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="File" name="ProfileImage" value="" id="imageselect">
									<label for="imageselect" class="custom-file-label">Add Image</label>
								</div>
							</div>
						</div>
					</div>



				</div>
				<div class="text-left mb-3">
					<input type="radio" name="gender" value="female">Female <br>
					<input type="radio" name="gender" value="male">Male
				</div>

				<div class="input-group text-left">
					<select class="form-control" name="freelancecategory" required="">
						<option>choose category </option>
						<?php
						global $ConnectingDB;
						$sql = "SELECT * FROM categories";
						$stmtgigs = $ConnectingDB->query($sql);
						while ($DataRows = $stmtgigs->fetch()) {
							$CategoryId 			= $DataRows['ctgy_id'];
							$categoryName	 		= $DataRows['ctgy_name'];
						?>
							<option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
						<?php } ?>
					</select>
				</div>

				<input type="password" name="pass" placeholder="Enter password" class="inputs mt-3"> <br>
				<input type="password" name="pass2" placeholder="confirm password" class="inputs">

				<div class="text-center">
					<input type="submit" name="registerasfreelancer" value="Register" class="reg">
					<p>already have an account? <a href="login.php"> login</a></p>
				</div>

		</form>



		<!-- register client -->
		<form class="mycontainhidereg" id="iWantToHire" action="registrationpage.php" method="POST" enctype="multipart/form-data">
			<h4><em>I am a client..</em></h4>
			<div class="text-center">
				<input type="text" name="Firstname" placeholder="Enter Firstname" class="inputs"> <br>
				<input type="text" name="Lastname" placeholder="Enter Lastname" class="inputs"> <br>
				<input type="email" name="email" placeholder="Enter email" class="inputs"><br>
				<input type="text" name="phonenumber" placeholder="Enter phonenumber" class="inputs"><br>
				<div class=" row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-file">
									<input class="inputs" type="date" name="dateofbirth" placeholder="What is your date of birth">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="File" name="ProfileImage" value="" id="imageselect">
									<label for="imageselect" class="custom-file-label">Add Image</label>
								</div>
							</div>
						</div>
					</div>



		
			<div class="text-left mb-3">
				<input type="radio" name="gender" value="female">Female <br>
				<input type="radio" name="gender" value="male">Male
			</div>

			<input type="password" name="pass" placeholder="Enter password" class="inputs"> <br>
			<input type="password" name="pass2" placeholder="confirm password" class="inputs">
			</div>

			<div class="text-center">
				<input type="submit" name="registerasclient" value="Register" class="reg">
				<p>already have an account? <a href="login.php"> login</a></p>
			</div>
		</form>
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
			openTabs(event, 'iWantToWork');

		}
	</script>
</body>

</html>