<?php
require_once("../includes/DB.php");
require_once("../includes/sessions.php");
require_once("../includes/functions.php");

// Confirm_Login();
if (!isset($_SESSION['Freelancer_ID']) && !isset($_SESSION['FreelancerName'])) {
	header("location: ../login.php");
}
if (!isset($_GET['submitWork'])) {
	header("location: ../freelancerdashboard.php");
}
$workid = $_GET['submitWork'];
$getReviewImages = $ConnectingDB->query("SELECT * FROM `review_of_work` WHERE work_id='$workid'");
if (isset($_GET['submitThisWork'])) {
	$workID = $_GET['submitThisWork'];
	$submitWork = $ConnectingDB->query("
			UPDATE ongoing_completed_work
			SET gig_status='UNDER REVIEW' WHERE
			id='$workID'
		");
	if ($submitWork) {

		$_SESSION["SuccessMessage"] = "congrats you have submitted your work successfuly";
		Redirect_to("../freelancerdashboard.php");
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>User profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="../css-files/Lobibox.min.css">
	<link rel="stylesheet" type="text/css" href="../css-files/sellerdasboard.css">
	<script type="text/javascript" src="../jquery_file/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../Lobibox.js"></script>
</head>

<body>

	<div class="logoutbtn">

		<!-- images show here -->
		<div class="row">
			<?php foreach ($getReviewImages as $key => $img) { ?>
				<div class="col-md-2">
					<div class="thumbnail card">
						<a href="../images/work_screenshots/<?php echo $img['screenshot'] ?>">
							<img src="../images/work_screenshots/<?php echo $img['screenshot'] ?>" alt="Lights" style="width:100%; height:150px;">
							<div class="caption">
								<p><?php echo $img['screenshot_name'] ?></p>
							</div>
						</a>
					</div>
				</div>
			<?php } ?>

		</div>
		<p><i> Please upload the screenshots with appropriate names for review</i></p>
		<form id="submit-for-review" class="container" enctype="multipart/form-data" method="post" action="upload_image.php">
			<p style="text-align: left;"> Add the first screenshot</p>
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<div class="custom-file">
							<input class="custom-file-input" type="file" name="Imageupdate" id="imageselect" required="">
							<label for="imageselect" class="custom-file-label">Select Image</label>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<input type="text" name="screenshot" class="reviewInputs" required="">
					</div>
				</div>
				<input type="hidden" name="workid" value="<?php echo $workid ?>">
				<div class="col-md-2">
					<div style="text-align: left;">
						<button type="submit" class="btn btn-primary">Add..</button>
					</div>
				</div>
			</div>





		</form>
		<a style="width:100%; color: #fff" class="btn btn-dark mt-3 py-2" href="?submitThisWork=<?php echo ($workid) ?>">submit-for-review</a>
	</div>
</body>

</html>