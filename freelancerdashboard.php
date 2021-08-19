<?php
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");

// Confirm_Login();
?>
<!-- the php code below is used to fetch user data from the registration page -->
<?php

if (!isset($_SESSION['Freelancer_ID']) && !isset($_SESSION['FreelancerName'])) {
	header("location: login.php");
}

$UserId = $_SESSION['Freelancer_ID'];
global $ConnectingDB;
$sql = "SELECT * FROM registerfreelancer WHERE id='$UserId'";
$stmtuser = $ConnectingDB->query($sql);
if ($stmtuser) {
	while ($DataRows = $stmtuser->fetch()) {
		$ExistingName = $DataRows['firstname'];
		$ExistingLastName = $DataRows['lastname'];
		$ExistingCategory = $DataRows['freelancecategory'];
		$Profile_picture  = $DataRows['profile_picture'];
	}
} else {
	header("location: login.php");
}


?>

<!-- THE PHP CODE BELOW IS USED TO VALIDATE A FORM USED TO ADD GIGS TO THE GIG LIST -->
<?php
if (isset($_POST['AddGigToList'])) {
	$proposal = $_POST['proposal'];
	$workType = $_POST['workType'];
	$imageOne = $_FILES["Image1"]["name"];
	$URLlink = $_POST['workLink'];
	$TargetOne = "images/freelancer_workImages/" . basename($_FILES["Image1"]["name"]);
	$imageTwo = $_FILES["Image2"]["name"];
	$TargetTwo = "images/freelancer_workImages/" . basename($_FILES["Image2"]["name"]);
	$amountCharged = $_POST['amountCharged'];

	global $ConnectingDB;
	$sql = "INSERT INTO freelancergigform(freelancecategory,workType, Proposal, workLink, pictureOne, pictureTwo, amount,freelancer_reg_id)";
	$sql .= "VALUES(:freelancecategorY,:workTypE, :proposaL, :worklinK, :pictureonE, :picturetwO, :amounT, :postidformurl)";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':freelancecategorY', $ExistingCategory);
	$stmt->bindValue(':workTypE', $workType);
	$stmt->bindValue(':proposaL', $proposal);
	$stmt->bindValue(':worklinK', $URLlink);
	$stmt->bindValue(':pictureonE', $imageOne);
	$stmt->bindValue(':picturetwO', $imageTwo);
	$stmt->bindValue(':amounT', $amountCharged);
	$stmt->bindValue(':postidformurl', $UserId);
	$Execute = $stmt->execute();
	if ($Execute) {
		move_uploaded_file($_FILES["Image1"]["tmp_name"], $TargetOne);
		move_uploaded_file($_FILES["Image2"]["tmp_name"], $TargetTwo);
		$_SESSION["SuccessMessage"] = "Gig created successfully :)";
	} else {
		$_SESSION["ErrorMessage"] = "A problem occured. Please try again";
	}
}
?>

<!-- display error message for disabled add gig button if freelancer is not verified -->
<?php
if (isset($_POST['verify-disabled-Gig-Btn'])) {
	$_SESSION["ErrorMessage"] = "Sorry you are not yet verified. take the verification test to get verified. Thank you.";
}
?>

<!-- display error messgae for disabled add work button -->
<?php
if (isset($_POST['disabled-Gig-Btn'])) {
	$_SESSION["ErrorMessage"] = "Sorry you have reached your job limit. Complete the jobs and try again later. Thank you";
}
?>

<!-- edit profile Image -->
<?php
if (isset($_POST['EditImage'])) {
	$Imageupdate = $_FILES["Imageupdate"]["name"];
	$TargetOne = "images/freelancer_Profile_Pictures/" . basename($_FILES["Imageupdate"]["name"]);

	global $ConnectingDB;
	if (!empty($_FILES["Imageupdate"]["name"])) {
		$sql = "UPDATE registerfreelancer SET profile_picture='$Imageupdate' WHERE id='$UserId'";
	} else {
		Redirect_to("freelancerdashboard.php");
	}
	$Execute = $ConnectingDB->query($sql);
	move_uploaded_file($_FILES["Imageupdate"]["tmp_name"], $TargetOne);
	if ($Execute) {
		$Target_Path_To_DELETE_Image = "images/freelancer_Profile_Pictures/$Profile_picture";
		unlink($Target_Path_To_DELETE_Image);
		$_SESSION["SuccessMessage"] = "Profile picture updated Successfully";
		Redirect_to("freelancerdashboard.php");
	} else {
		$_SESSION["ErrorMessage"] = "Something went wrong. Try again";
		Redirect_to("freelancerdashboard.php");
	}
}
?>

<!-- this handles questions for verification -->
<?php
if (isset($_POST['finishTest'])) {
	global $ConnectingDB;
	$isCorrectCount = 0;
	// extract($_POST);

	$sql = "SELECT * FROM `verification_questions`, `categories` WHERE categories.ctgy_id= verification_questions.que_category AND categories.ctgy_name='$ExistingCategory'";
	$Count = 1;
	$stmtgigs = $ConnectingDB->query($sql);
	while ($DataRows = $stmtgigs->fetch()) {
		if ($_POST["question$Count"] == $DataRows["que_answer"]) {
			$isCorrectCount += 1;
		}
		$Count++;
	}
	$sql = "UPDATE registerfreelancer SET test_status='1' WHERE id='$UserId'";
	$stmtupdate = $ConnectingDB->query($sql);
	if ($isCorrectCount >= 4) {
		$sql = "UPDATE registerfreelancer SET test_result_status='1' WHERE id='$UserId'";
		$stmtupdate = $ConnectingDB->query($sql);
		$_SESSION["SuccessMessage"] = "congrats you now verified";
		Redirect_to("freelancerdashboard.php");
	} else {
		$_SESSION["takenExamTime"] = time();
		$_SESSION["ErrorMessage"] = "Sorry you didnt make it. try again in two minutes";
		Redirect_to("freelancerdashboard.php");
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>User profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="css-files/Lobibox.min.css">
	<link rel="stylesheet" type="text/css" href="css-files/sellerdasboard.css">
	<script type="text/javascript" src="jquery_file/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="Lobibox.js"></script>

</head>

<body>
	<nav class="navbar navbar-expand-md navbar-light bg-light">
		<a href="#" class="navbar-brand">
			<span> S</span>tretch<span>.</span>
		</a>

		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarCollapse">
			<div class="navbar-nav">
				<a href="#" class="nav-item nav-link Dashboardtab" onclick="openTabs(event, 'Dashboard')"> Dashboard </a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'availabejobs')"> Available jobs </a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'messages')"> Messages</a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'orders')"> Orders </a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'earning')"> Earnings </a>
				<!-- <a href="#" class="nav-item nav-link" tabindex="-1"></a> -->
			</div>
		</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row smalldiv">
			<div class="col-md-4">
				<div class="leftside">
					<div class="text-center">
						<?php
						global $ConnectingDB;
						$sql = "SELECT * FROM registerfreelancer 
							WHERE id='$UserId'";
						$stmtgigs = $ConnectingDB->query($sql);
						while ($DataRows = $stmtgigs->fetch()) {
							$frelancerGigId 	= $DataRows['id'];
							$Profile_picture    = $DataRows['profile_picture'];
						?>
							<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture; ?>" width="100px" height="100px" class="profileimg">
						<?php } ?>
						<p class="userName"> <?php echo $ExistingName; ?> <?php echo $ExistingLastName; ?></p>

						<div>
							<p class="inboxlogout" onclick="openTabs(event, 'verification')"><i>Check Account</i></p>
							<p class="inboxlogout" onclick="openTabs(event, 'messages')">inbox</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Profile')"> settings</p>
							<p class="inboxlogout" onclick="openTabs(event, 'logout')"> Log out </p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8 rightside" id="rightside">


				<div class="mycontainhide" id="Dashboard">
					<?php
					echo ErrorMessage();
					echo SuccessMessage();

					?>
					<p>Posted work</p>
					<hr>
					<div class="gigcontrols">
						<?php
						if (jobLimit($UserId)) {
						?>

							<form action="freelancerdashboard.php" method="POST">
								<button type="submit" name="disabled-Gig-Btn" class="disabled">Add Gig</button>
							</form>
						<?php
						} elseif (!check_test_result($UserId)) {
						?>
							<form action="freelancerdashboard.php" method="POST">
								<button type="submit" name="verify-disabled-Gig-Btn" class="disabled">Add Gig</button>
							</form>
						<?php
						} else {
						?>
							<p class="addgig" onclick="openTabs(event, 'addinggigs')">Add Gig</p>
						<?php } ?>
						<p><span class="fa fa-trash" onclick="openTabs(event, 'deleteAllGigs')"></span></p>

					</div>
					<p class="delete-trigger"></p>
					<div class="container">
						<!-- This php code is used to fetch and display the users own gigs on his/her page -->

						<?php

						if (!checkUserNameExistsorNot($UserId)) {
							echo "<div class='text-center'>
											<div class='alert alert-warning alert-dismissible fade show'>
	    									<strong>Warning!</strong> OOPS!! You dont have any gigs yet
											</div>
										</div>";
						} else {
							global $ConnectingDB;
							$sql = "SELECT * FROM freelancergigform 
								WHERE freelancer_reg_id='$UserId' ORDER BY id desc";
							$stmtgigs = $ConnectingDB->query($sql);
							while ($DataRows = $stmtgigs->fetch()) {
								$frelancerGigId 	= $DataRows['id'];
								$workType 			= $DataRows['workType'];
								$GigProposal 		= $DataRows['Proposal'];
								$GigPictureOne		= $DataRows['pictureOne'];
								$GigPictureTwo 		= $DataRows['pictureTwo'];
								$GigPrice 			= $DataRows['amount'];
						?>
								<div class="gigslist" id="firstgig">
									<img src="images/freelancer_workImages/<?php echo $GigPictureOne; ?>" width="75px" height="50px">
									<p><?php echo $workType; ?></p>
									<p>N <span><?php echo number_format($GigPrice); ?></span></p>
									<div style="width:20%; display: flex; justify-content: space-around;">

										<span class="pr-3"><a href="editGig.php?editGig=<?= $frelancerGigId; ?>" class="fa fa-edit"></a></span>
										<span><a href="deleteGigs.php?deleteGigId=<?= $frelancerGigId; ?>" class="fa fa-trash"></a></span>
									</div>
								</div>
						<?php
							}
						}
						?>

						<!-- the php while loop code stops here -->

					</div>
				</div>

				<!-- available jobs tab -->
				<div class="container mycontainhide" id="availabejobs">
					<?php
					if (!check_test_result($UserId)) {
						echo "<div class='text-center'>
										<div class='alert alert-danger alert-dismissible fade show'>
    									<strong>Warning!</strong> Sorry, You are not yet verified.<br>Get verified to access jobs.
										</div>
									</div>";
					} else {
						if (jobLimit($UserId)) {
							echo "<div class='text-center'>
											<div class='alert alert-warning alert-dismissible fade show'>
	    									<strong>Warning!</strong> Sorry, you have reached your work limit.<br>Complete them and continue your job search.<br>Thank you.
											</div>
										</div>";
						} else {
							if (!availablejobs_forfreelancer($ExistingCategory)) {
								echo "<div class='text-center'>
											<div class='alert alert-warning alert-dismissible fade show'>
	    									<strong>Warning!</strong> Sorry, there are no jobs available at the moment.
											</div>
										</div>";
							} else {
					?>
								<div class="row">
									<table class="table table-striped">

										<thead>
											<tr>
												<td>logo</th>
												<td>Job desc.</td>
												<td>Amount</td>
												<td>action</td>
											</tr>
										</thead>
										<tbody>
											<?php
											global $ConnectingDB;

											$sql = "SELECT * FROM clientsgigsform WHERE WorkCategory='$ExistingCategory' AND active='OFF' ORDER BY id desc";
											$stmtfreelancergigs = $ConnectingDB->query($sql);
											while ($DataRows = $stmtfreelancergigs->fetch()) {
												$ClientsGigId       = $DataRows['id'];
												$JobTitle 			= $DataRows['JobTitle'];
												$GigPrice 			= $DataRows['AmountforWork'];
												$CompanyMotto 			= $DataRows['CompanyMotto'];
												$CompanyName 			= $DataRows['CompanyName'];
												$Workcategory 	= $DataRows['WorkCategory'];

											?>

												<tr>
													<th scope="row"></th>
													<td><?= $JobTitle; ?></td>
													<td><?= $GigPrice; ?></td>
													<td>
														<div class="btn btn-success">
															<a href="proposal_form.php?jobid=<?= $ClientsGigId; ?>" style="color:white;">Apply <span class="fa fa-check"></a>
														</div>

													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
					<?php }
						}
					} ?>
				</div>
				<!-- this is order tab -->

				<?php require 'freelancer/orderTab.php'; ?>

				<?php
				$total_earnings = (isset($earnings)) ? number_format($earnings) : 0;
				$withdrawal =  0;
				$available = $earnings - $withdrawal;
				?>
				<!-- For earnings tab -->
				<div class="container mycontainhide" id="earning">
					<div class="row earning-list text-center">
						<div class="col-md-3">
							<div>Total made</div>
							<p class="amount text-primary"> &#8358;<?php echo $total_earnings; ?></p>
						</div>

						<div class="col-md-3">
							<div>Pending clearance</div>
							<p class="amount text-secondary"> &#8358;<?php echo number_format($pending_earnings); ?></p>
						</div>

						<div class="col-md-3">
							<div>Available for withdrawal</div>
							<p class="amount text-success"> &#8358;<?php echo number_format($available); ?></p>
						</div>

						<div class="col-md-3">
							<div>Withdrawal</div>
							<p class="amount text-danger"> &#8358;<?php echo number_format($withdrawal); ?> </p>
						</div>
					</div>

					<div class="withdrawalchoice">
						<p>Withdrawal type: Transfer</p>
						<div class="withrawoptions">
							<!-- <p>Paypal</p> -->
							<!-- <p>Transfer</p> -->
						</div>

						<div class="previouspayments paymentheading">
							<p> payment By: </p>
							<p> job Done</p>
							<p> Date</p>
							<p> Amount</p>
						</div>

						<div class="previouspayments paymentdetails text-center">
							<p class="payername"> Nestle </p>
							<p class="jobdone"> web development</p>
							<p class="payerdate"> 6/5/2020</p>
							<p class="amountpaid"> N <span class="amountfigures"> 5000</span></p>
						</div>
						<div class="previouspayments paymentdetails paymentdetails2 text-center">
							<p class="payername"> Nestle </p>
							<p class="jobdone"> web development</p>
							<p class="payerdate"> 6/5/2020</p>
							<p class="amountpaid"> N <span class="amountfigures"> 5000</span></p>

						</div>
					</div>
				</div>

				<!-- FOR MESSAGE TAB -->

				<?php require 'freelancer/messages.php'; ?>




				<!-- this is verification tab -->

				<?php require 'freelancer/test_verification.php'; ?>



				<!-- THIS PART IS USED TO ADD GIGS TO THE FREELANCERS GIG-LIST -->
				<div class="container mycontainhide " id="addinggigs">
					<div class="backarrow" onclick="openTabs(event, 'Dashboard')"> &leftarrow; Back</div>

					<p class="pt-3"><em>please add your gigs below.</em></p>

					<div class="applicationformmainflex">
						<div class="applicationformmain addinggigsmain">
							<form class="text-center" action="freelancerdashboard.php" method="POST" enctype="multipart/form-data">

								<p class="text-left">
									Skillset: <span class="lead"><?php echo $ExistingCategory; ?></span>
								</p>
								<input type="text" name="workType" placeholder="title of what you are offering." class="amountofcharge">
								<textarea rows="13" placeholder="please write your proposal here" name="proposal" class="amountofcharge p-3"></textarea>
								<input type="text" name="amountCharged" placeholder="amount charged" class="amountofcharge">
								<input type="text" name="workLink" placeholder="Please Place a link to your recent website here" class="amountofcharge">


								<div class="form-group">
									<div class="custom-file">
										<input class="custom-file-input" type="File" name="Image1" value="" id="imageselect">
										<label for="imageselect" class="custom-file-label">Select Image</label>
									</div>

								</div>

								<div class="form-group">
									<div class="custom-file">
										<input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
										<label for="imageselect" class="custom-file-label">Select Image</label>
									</div>

								</div>
								<div class="text-right">
									<input type="submit" name="AddGigToList" value="post work" class="applicationformapplybtn">
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- ADDING TO FREELANCER'S GIG-LIST ENDS HERE -->

				<!-- FREELANCER'S PROFILE SETTINGS -->
				<div class="mycontainhide" id="Profile">
					<h2 class="lead"> My Profile</h2>
					<hr>
					<div>
						<?php
						global $ConnectingDB;
						$sql = "SELECT * FROM registerfreelancer 
							WHERE id='$UserId'";
						$stmtgigs = $ConnectingDB->query($sql);
						while ($DataRows = $stmtgigs->fetch()) {
							$frelancerGigId 	= $DataRows['id'];
							$firstname 	 		= $DataRows['firstname'];
							$lastname 			= $DataRows['lastname'];
							$email 				= $DataRows['email'];
							$phoneNumber 		= $DataRows['phonenumber'];
							$country 			= $DataRows['country'];
							$freelancecategory 	= $DataRows['freelancecategory'];
							$Location 			= $DataRows['state'];
							$DOB 				= $DataRows['dateofbirth'];
							$Profile_picture    = $DataRows['profile_picture'];
						?>
							<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture; ?>" width="100px" height="100px">

							<form action="freelancerdashboard.php" method="POST" enctype="multipart/form-data">
								<div style="display: flex">
									<div class="form-group" style=" width: 25%">
										<div class="custom-file" style="width: 100%; margin-top: 5px;">
											<input class="custom-file-input" type="File" name="Imageupdate" value="" id="imageselect">
											<label for="imageselect" class="custom-file-label">Select Image</label>
										</div>
									</div>
									<div>
										<input type="submit" name="EditImage" value="Change Image" class="btn btn-primary ml-2 pt-1">
									</div>
								</div>
							</form>
					</div>
					<div>
						<p><b><em>Name:</em> </b><span><?php echo $lastname . " " . $firstname; ?></span></p>
						<p><b><em>Phone Number:</em> </b><span><?php echo $phoneNumber; ?></span></p>
						<p><b><em>Work Category:</em> </b><span><?php echo $freelancecategory; ?></span></p>
						<p><b><em>Nationality:</em></b> <?php echo $country; ?></p>
						<p><b><em>city:</em></b> <?php echo $Location; ?></p>
						<p><b><em>Email Address:</em> </b><span> <?php echo $email; ?></span></p>
						<p><b><em>joined On:</em> </b><span><?php echo $DOB; ?> </span></p>

					</div>
				<?php } ?>

				<div>

					<div class="btn btn-warning" onclick="openTabs(event, 'logout')">Logout</div>
				</div>
				</div>


				<!-- TO DELETE ALL GIGS -->
				<div class="mycontainhide logoutbtn" id="deleteAllGigs">
					<h3>Are you sure you want to delete all the jobs posted?</h3>
					<hr>
					<div class="logout-options">
						<p class="logoutopt1"><a href="deleteAllJobs.php" class="p-3">Yes</a></p>
						<p class="logoutopt2" onclick="openTabs(event, 'Dashboard')">No</p>
					</div>
				</div>

				<!-- this is logout tab -->
				<div class="mycontainhide logoutbtn" id="logout">
					<h3>Are you sure you want to log out?</h3>
					<hr>
					<div class="logout-options">
						<p class="logoutopt1"><a href="logout.php">Yes</a></p>
						<p class="logoutopt2" onclick="openTabs(event, 'Dashboard')">No</p>
					</div>
				</div>

			</div>
		</div>
	</div>

	<footer>
		<div class="dash-footer">
			<div class="footer-head">
				<h3>A platform that you can trust</h3>
			</div>

			<div class="footer-par">
				<p>available jobs</p>
				<p>posted work</p>
			</div>

			<div class="footer-par">
				<p>About us</p>
				<p>contact us</p>
			</div>
		</div>
		<!-- <div class="bitheight">
			
		</div> -->

	</footer>





	<!-- javascript goes here -->
	<script type="text/javascript" src="popper/docs/js/jquery.min.js"></script>
	<script type="text/javascript" src="popper/docs/js/main.js"></script>
	<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>
	<script>
		function openTabs(e, tabId) {
			var i, mycontainhide;

			mycontainhide = document.getElementsByClassName('mycontainhide');
			for (i = 0; i < mycontainhide.length; i++) {
				mycontainhide[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}

		document.getElementById('requestsTab').classList.add('active');

		function orderTabs(e, idTabs) {
			var i, mycontainhide;

			ordercontainhide = document.getElementsByClassName('ordercontainhide');
			var ordertab1 = document.getElementsByClassName('ordertab1');

			for (i = 0; i < ordercontainhide.length; i++) {
				ordercontainhide[i].style.display = "none";
				ordertab1[i].classList.add('active');
			}
			document.getElementById('requestsTab').classList.remove('active');

			document.getElementById(idTabs).style.display = "block";
		}

		// this displays an error message for adding a gig if job limit has been reached



		//messaging tab
		function sendMessage() {

			var inputField = document.getElementById('text-box');
			var inputValue = inputField.value;
			let div1 = document.createElement('div');
			div1.classList.add('holddiv-sent');
			let div2 = document.createElement('div');
			div2.classList.add('message-sent');
			let textParagraph = document.createElement('p');
			textParagraph.textContent = inputValue;
			textParagraph.classList.add('chat-text-sent');
			div2.appendChild(textParagraph);
			div1.appendChild(div2);
			const messageContainer = document.querySelector('.message-inbox-container');
			messageContainer.appendChild(div1);
			inputField.value = ''; //clear input text;
		}
		window.onload = function() {
			openTabs(event, 'Dashboard');
			orderTabs(event, 'requestOrder');
		}
	</script>
</body>

</html>