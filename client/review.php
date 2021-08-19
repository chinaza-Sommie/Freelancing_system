<?php 
	require_once("../includes/DB.php");
	require_once("../includes/sessions.php");
	require_once("../includes/functions.php");

	// Confirm_Login();
	if(!isset($_SESSION['User_ID']) && !isset($_SESSION['UserName'])){
	header("location: ../login.php");
}
if (!isset($_GET['workid'])) {
	header("location: ../companydashboard.php");
}
$workid=$_GET['workid'];
$getReviewImages=$ConnectingDB->query("SELECT * FROM `review_of_work` WHERE work_id='$workid'");
if(isset($_GET['pay'])){
	$workID=$_GET['pay'];
		header("location: ../Flutterwave-Rave/paymentForm.php?pay=$workID");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="../css-files/animate.css">
	<link rel="stylesheet" type="text/css" href="../css-files/Lobibox.min.css">
	<link rel="stylesheet" type="text/css" href="../css-files/sellerdasboard.css">
	<script type="text/javascript" src="../jquery_file/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../Lobibox.js"></script>
</head>
<body>

	<div class="logoutbtn" >

					<!-- images show here -->
					<div class="row">
						<?php foreach ($getReviewImages as $key => $img) { ?>
							<div class="col-md-2">
							    <div class="thumbnail card animated fadeInDown" >
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
					<p><i> If you need more shots of the work please message the freelancer before proceeding to payment</i></p>
					
					<center>
						<a style="width:50%; color: #fff" class="btn btn-success mt-3 py-2" href="?pay=<?php echo($workid)?>&&workid=<?php echo($workid)?>"><i class="fa fa-money"></i> Pay for The Work</a>
					</center>
				</div>
</body>
</html>