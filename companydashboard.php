<?php
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");
?>

<?php
if (!isset($_SESSION['User_ID'])) {
	Redirect_to('login.php');
} else {

	$UserId = $_SESSION['User_ID'];
}
global $ConnectingDB;
$sql = "SELECT * FROM registerpage WHERE id='$UserId'";
$stmtuser = $ConnectingDB->query($sql);
while ($DataRows = $stmtuser->fetch()) {
	$ExistingName 		= $DataRows['firstname'];
	$ExistingLastName 	= $DataRows['lastname'];
	$email 				= $DataRows['email'];
	$phoneNumber 		= $DataRows['phonenumber'];
	$DOB 				= $DataRows['dateofbirth'];
	$Profile_picture    = $DataRows['profile_picture'];
}
?>

<!-- this code adds Client gig details to the DB -->
<?php
if (isset($_POST['SubmitAvailableJob'])) {
	$CompanyName = $_SESSION['UserName'];
	$CompanyMotto = "Together we stand";
	$workLocation = "Lagos";
	$jobTitle = $_POST['jobTitle'];
	$workCategory = $_POST['workCategory'];
	$priceTag = $_POST['priceTag'];
	// $priceTag = number_format($priceTag);
	$DueDate = $_POST['DueDate'];
	$DueDate = strtotime($DueDate);
	$DueDate = date('d M, Y', $DueDate);
	$jobSummary = $_POST['jobSummary'];
	$jobrespbility1 = $_POST['jobrespbility1'];
	$jobrespbility2 = $_POST['jobrespbility2'];
	$jobrespbility3 = $_POST['jobrespbility3'];
	$jobrespbility4 = $_POST['jobrespbility4'];

	if (empty($jobTitle) || empty($workCategory) || empty($priceTag) || empty($DueDate) || empty($jobSummary) || empty($jobrespbility1) || empty($jobrespbility2)) {
		$_SESSION["ErrorMessage"] = "Please fill the necessary fields";
	} elseif (strlen($jobSummary) > 998) {
		$_SESSION["ErrorMessage"] = "Job summary should be less than 1000 characters";
		Redirect_to("companydashboard.php");
	} else {
		global $ConnectingDB;
		$sql = "INSERT INTO clientsgigsform(CompanyName, CompanyMotto, WorkLocation, JobTitle, WorkCategory, AmountforWork,SummaryofWorkdet, workresponsibility1, workresponsibility2, workresponsibility3, workresponsibility4,active, DueDate, clients_reg_id)";
		$sql .= "VALUES(:CompanyNamE, :CompanyMottO, :WorkLocatioN, :JobTitlE, :WorkCategorY, :AmountforWorK, :SummaryofWorkdet, :workresponsibility1, :workresponsibility2, :workresponsibility3, :workresponsibility4,'OFF', :DueDateE, :clientsId)";

		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':CompanyNamE', $CompanyName);
		$stmt->bindValue(':CompanyMottO', $CompanyMotto);
		$stmt->bindValue(':WorkLocatioN', $workLocation);
		$stmt->bindValue(':JobTitlE', $jobTitle);
		$stmt->bindValue(':WorkCategorY', $workCategory);
		$stmt->bindValue(':AmountforWorK', $priceTag);
		$stmt->bindValue(':SummaryofWorkdet', $jobSummary);
		$stmt->bindValue(':workresponsibility1', $jobrespbility1);
		$stmt->bindValue(':workresponsibility2', $jobrespbility2);
		$stmt->bindValue(':workresponsibility3', $jobrespbility3);
		$stmt->bindValue(':workresponsibility4', $jobrespbility4);
		$stmt->bindValue(':DueDateE', $DueDate);
		$stmt->bindValue(':clientsId', $UserId);
		$Execute = $stmt->execute();
		if ($Execute) {
			$_SESSION["SuccessMessage"] = "Gig has been created successfully :)";
		} else {
			$_SESSION["ErrorMessage"] = "A problem occured. Please try again";
		}
	}
}
?>

<?php
if (isset($_POST['deleteAllJobs'])) {
	if (!checkClientUserNameExistsorNot($UserId)) {
		$_SESSION["ErrorMessage"] = "Sorry, you have not posted any work yet. Go ahead and create one";
		Redirect_to("companydashboard.php");
	} else {
		global $ConnectingDB;
		$sql = "DELETE FROM  clientsgigsform WHERE clients_reg_id='$UserId'";
		$Execute = $ConnectingDB->query($sql);
		if ($Execute) {
			$Target_Path_To_Delete_Image_One = "images/freelancer_workImages/$GigPictureOne";
			unlink($Target_Path_To_Delete_Image_One);
			$Target_Path_To_Delete_Image_Two = "images/freelancer_workImages/$GigPictureTwo";
			unlink($Target_Path_To_Delete_Image_Two);
			$_SESSION["SuccessMessage"] = "All Posted works have been deleted Successfully";
			Redirect_to("companydashboard.php");
		} else {
			$_SESSION["ErrorMessage"] = "Something went wrong. Try again";
			Redirect_to("companydashboard.php");
		}
	}
}
?>

<!-- edit profile image -->
<?php
if (isset($_POST['EditImage'])) {
	$Imageupdate = $_FILES["Imageupdate"]["name"];
	$TargetOne = "images/freelancer_Profile_Pictures/" . basename($_FILES["Imageupdate"]["name"]);

	global $ConnectingDB;
	if (!empty($_FILES["Imageupdate"]["name"])) {
		$sql = "UPDATE registerpage SET profile_picture='$Imageupdate' WHERE id='$UserId'";
	} else {
		Redirect_to("companydashboard.php");
	}
	$Execute = $ConnectingDB->query($sql);
	move_uploaded_file($_FILES["Imageupdate"]["tmp_name"], $TargetOne);
	if ($Execute) {
		$Target_Path_To_DELETE_Image = "images/freelancer_Profile_Pictures/$Profile_picture";
		unlink($Target_Path_To_DELETE_Image);
		$_SESSION["SuccessMessage"] = "Profile picture updated Successfully";
		Redirect_to("companydashboard.php");
	} else {
		$_SESSION["ErrorMessage"] = "Something went wrong. Try again";
		Redirect_to("companydashboard.php");
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Company profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="css-files/sellerdasboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/companydashboard.css">
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
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'gigs')"> Posted Jobs </a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'Messages')"> Messages</a>
				<a href="#" class="nav-item nav-link" onclick="openTabs(event, 'orders')"> orders </a>

			</div>
		</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row smalldiv">
			<div class="col-md-4">
				<div class="leftside">
					<div class="text-center">
						<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture; ?>" width="100px" height="100px" class="profileimg">
						<p class="userName"><?php echo $ExistingLastName . " " . $ExistingName; ?></p>

						<div>
							<p class="inboxlogout" onclick="openTabs(event, 'Messages')">inbox</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Profile')"> Profile</p>
							<p class="inboxlogout" onclick="openTabs(event, 'logout')"> Log out</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8 rightside" id="rightside">
				<div class="mycontainhide" id="Dashboard">
					<?php echo ErrorMessage(); ?>
					<?php echo SuccessMessage(); ?>
					<p>Posted work</p>
					<hr>
					<div class="gigcontrols">
						<p class="addgig" onclick="openTabs(event, 'addinggigs')">Add Gig</p>
						<p><span class="fa fa-trash" onclick="openTabs(event, 'deleteAllGigs')"></span></p>

					</div>

					<div class="container">
						<?php
						if (!checkClientUserNameExistsorNot($UserId)) {
							echo "OOPS!!! There are no gigs to advertise yet";
						} else {
							global $ConnectingDB;
							$sql = "SELECT * FROM clientsgigsform
								WHERE clients_reg_id='$UserId' AND active='OFF' ORDER BY id desc";
							$stmtgigs = $ConnectingDB->query($sql);
							while ($DataRows = $stmtgigs->fetch()) {
								$ClientGigid        = $DataRows['id'];
								$JobTitle 			= $DataRows['JobTitle'];
								$GigPrice 			= $DataRows['AmountforWork'];

						?>
								<div class="gigslist" id="firstgig">
									<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture; ?>" width="75px" height="50px">
									<div class="job-price-for-work">
										<p> <?php echo $JobTitle; ?></p>
										<p>N <span><?php echo number_format($GigPrice); ?></span></p>
									</div>
									<div class="clientswork-controls">
										<span class="viewproposal mr-2"><a class="viewproposals p-2" href="proposalInformation.php?gigId=<?= $ClientGigid; ?>"> view Proposal</a></span>
										<span class="fa fa-user pr-3"> <?= proposalnumber($ClientGigid); ?></span>
										<span class="pr-3"><a href="editGig.php?editClientGig=<?= $ClientGigid; ?>" class="fa fa-edit"></a></span>
										<span><a href="deleteGigs.php?deleteClientGigId=<?= $ClientGigid; ?>" class="fa fa-trash"></a></span>
									</div>
								</div>
						<?php
							}
						}
						?>
					</div>


				</div>

				<!-- orders made -->
				< <?php require 'client/orderTab.php' ?> <!-- available gigs tab -->
					<div class="container mycontainhide" id="gigs">
						<form action="companydashboard.php">
							<div style="display: flex; justify-content: right;">
								<div class="input-group" style="width: 40%">
									<input type="text" class="form-control" id="search-text" name="search-text" placeholder="Search by category or keyword">
									<div class="input-group-append">
										<button type="submit" id="Search-freelancer-work">Search</button>
									</div>
								</div>
							</div>
						</form>
						<hr>


						<div class="row" id="workSearch">
							<?php
							if (!diplayAvailbleFlncrJob()) {
								echo "no freelancers match";
							} else {
								global $ConnectingDB;

								$sql = "SELECT * FROM freelancergigform ORDER BY id desc";
								$stmtfreelancergigs = $ConnectingDB->query($sql);
								while ($DataRows = $stmtfreelancergigs->fetch()) {
									$freelancer_id = $DataRows['freelancer_reg_id'];

									$fetch = $ConnectingDB->query("SELECT COUNT(id) AS counter FROM ongoing_completed_work WHERE (gig_status='ONGOING' OR gig_status='UNDER REVIEW') AND freelancer_id='$freelancer_id'");
									$fetchRow =  $fetch->fetch();
									$counter = $fetchRow['counter'];
									if ($counter < 3) {

										$detail_work_id   	= $DataRows['id'];
										$workType   	= $DataRows['workType'];
										$GigProposal 		= $DataRows['Proposal'];
										$GigPictureOne		= $DataRows['pictureOne'];
										$GigPictureTwo 		= $DataRows['pictureTwo'];
										$GigAmount 			= $DataRows['amount'];
										$freelancecategory 	= $DataRows['freelancecategory'];

							?>
										<div class="col-md-4 mb-4">
											<div class="availbletab-item">
												<div class="availabletabimage">
													<img src="images/freelancer_workImages/<?php echo $GigPictureOne; ?>">
													<div>
														<h6 class="freelancername"><?php echo $workType; ?></h6>
													</div>
												</div>

												<p class="worktitle">category:<span><?php echo $freelancecategory; ?></span></p>
												<p class="priceofwork">Amount: N <span class="priceofworkmoney"><?php echo number_format($GigAmount); ?></span></p>

												<div class="availbletab-details mb-3">
													<p>
														<?php
														if (strlen($GigProposal) > 20) {
															$GigProposal = substr($GigProposal, 0, 20) . "...";
														}
														?>
														<?php echo $GigProposal; ?>
													</p>

												</div>
												<a href="work_detail_byFreelancer.php?detail_of_work=<?php echo $DataRows['id']; ?>">
													<div class="available-apply text-center"> View </div>
												</a>
											</div>
										</div>
							<?php }
								}
							} ?>
						</div>
					</div>



					<!-- FOR MESSAGE TAB -->

					<?php require 'client/messages.php'; ?>

					<!-- delete All jobs posted -->
					<div class="mycontainhide logoutbtn" id="deleteAllGigs">
						<h3>Are you sure you want to delete all the jobs posted?</h3>
						<hr>
						<form action="companydashboard.php" method="POST">
							<div class="logout-options">
								<input type="submit" value="Yes" name="deleteAllJobs" class="logoutopt1" style="width: 8%">
								<p class="logoutopt2 mt-3" onclick="openTabs(event, 'Dashboard')">No</p>
							</div>
						</form>
					</div>

					<!-- logout tab -->

					<div class="mycontainhide logoutbtn" id="logout">

						<h3>Are you sure you want to log out?</h3>
						<hr>
						<div class="logout-options">
							<p><a class="logoutopt1 btn" href="logout.php">Yes</a></p>
							<p class="logoutopt2 btn" onclick="openTabs(event, 'Dashboard')">No</p>
						</div>
					</div>


					<!-- this form is used to add available gigs to the clients page -->
					<div class="container mycontainhide " id="addinggigs">
						<div class="backarrow" onclick="openTabs(event, 'Dashboard')"> &leftarrow; Back</div>

						<p class="pt-3"><em>please add your gigs below.</em></p>

						<div class="applicationformmainflex" style="border:1px solid grey">
							<form action="companydashboard.php" method="POST" class="container py-4">
								<div class="row mb-2">
									<div class="col-sm-6">
										<div class="ml-2"><i>Job Title:</i></div>
										<div class="input-group">

											<input type="text" class="form-control" name="jobTitle" placeholder="Please Enter Job Title">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="input-group text-left">
											<select class="form-control mt-4" name="workCategory" required="">
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
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="ml-2"><i>Amount to be paid:</i></div>
										<div class="input-group">

											<input type="text" name="priceTag" class="form-control" placeholder="Please Enter Amount">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="ml-2"><i>Due Date:</i></div>
										<div class="input-group">
											<input type="date" name="DueDate" class="form-control">
										</div>
									</div>
								</div>

								<div class="my-3">
									<div class="input-group">
										<textarea rows="5" cols="30" placeholder="Enter Summary of work Expected to be done" name="jobSummary" style="width: 100%" class="p-3"></textarea>
									</div>
								</div>

								<div class="row mb-2">
									<div class="col-sm-6">
										<div class="ml-2"><i>Job Responsibility 1:</i></div>
										<div class="input-group">
											<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility1" style="width: 100%" class="p-3"></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="ml-2"><i>Job Responsibility 2:</i></div>
										<div class="input-group">
											<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility2" style="width: 100%" class="p-3"></textarea>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="ml-2"><i>Job Responsibility 1:</i></div>
										<div class="input-group">
											<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility3" style="width: 100%" class="p-3"></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="ml-2"><i>Job Responsibility 2:</i></div>
										<div class="input-group">
											<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility4" style="width: 100%" class="p-3"></textarea>
										</div>
									</div>
								</div>

								<div class="mt-3">
									<input type="submit" name="SubmitAvailableJob" value="submit" class="btn btn-primary" style="width: 100%">
								</div>
							</form>
						</div>
					</div>

					<!-- this part displays frealncers details -->

					<div class="mycontainhide" id="Profile">
						<h2 class="lead"> My Profile</h2>
						<hr>
						<div>
							<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture; ?>" width="100px" height="100px">

							<form action="companydashboard.php" method="POST" enctype="multipart/form-data">
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
							<p><b><em>Name:</em> </b><span><?php echo $ExistingName . " " . $ExistingLastName; ?></span></p>
							<p><b><em>Phone Number:</em> </b><span><?php echo $phoneNumber; ?></span></p>
							<p><b><em>Email Address:</em> </b><span> <?php echo $email; ?></span></p>
							<p><b><em>joined On:</em> </b><span><?php echo $DOB; ?> </span></p>

						</div>

						<div>
							<div class="btn btn-warning" onclick="openTabs(event, 'logout')">Logout</div>
						</div>
					</div>

			</div>
		</div>
	</div>



	<!-- footer division -->
	<footer>
		<div class="dash-footer">
			<div class="footer-head">
				<h3>A platform that you can trust</h3>
			</div>

			<div class="footer-par">
				<p>Gigs</p>
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
		$(document).ready(function() {
			// $('#Search-freelancer-work').submit(function(event){
			$("#Search-freelancer-work").click(function() {
				event.preventDefault();
				$.ajax({
					type: 'POST',
					url: 'searchdisplay.php',
					data: {
						name: $("#search-text").val(),
					},
					success: function(data) {
						$("#workSearch").html(data);
					}
				});
			});
			// });
		});

		function openTabs(e, tabId) {
			var i, mycontainhide;

			mycontainhide = document.getElementsByClassName('mycontainhide');
			for (i = 0; i < mycontainhide.length; i++) {
				mycontainhide[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}

		function clearme() {
			var inputvalue = document.getElementById('text-box');
			inputvalue.value = "";
		}

		document.getElementById('ongoingTab').classList.add('active');

		function orderTabs(e, idTabs) {
			var i, mycontainhide;

			ordercontainhide = document.getElementsByClassName('ordercontainhide');
			var ordertab1 = document.getElementsByClassName('ordertab1');

			for (i = 0; i < ordercontainhide.length; i++) {
				ordercontainhide[i].style.display = "none";
				ordertab1[i].classList.add('active');
			}
			document.getElementById('ongoingTab').classList.remove('active');

			document.getElementById(idTabs).style.display = "block";
		}
		window.onload = function() {
			openTabs(event, 'Dashboard');
			clearme();
		}
	</script>
</body>

</html>