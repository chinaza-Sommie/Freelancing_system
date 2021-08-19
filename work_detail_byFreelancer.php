<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");
?>

<?php 
$UserId = $_SESSION['User_ID'];
	if (isset($_GET['detail_of_work'])) {
		$detail_of_workID = $_GET['detail_of_work'];

		global $ConnectingDB;
			$sql = "SELECT * FROM `freelancergigform`,`registerfreelancer` WHERE freelancergigform.freelancer_reg_id=registerfreelancer.id AND freelancergigform.id='$detail_of_workID'";
			$stmtgigs = $ConnectingDB->query($sql);
			while ($DataRows = $stmtgigs->fetch()){
				$frelancerGigId 	= $DataRows['id'];
				$freelancerID    	= $DataRows['freelancer_reg_id'];
				$GigProposal 		= $DataRows['Proposal'];
				$GigCategory 		= $DataRows['freelancecategory'];
				$GigPictureOne		= $DataRows['pictureOne'];
				$GigPictureTwo 		= $DataRows['pictureTwo'];
				$GigPrice 			= $DataRows['amount'];
				$workLink			= $DataRows['workLink'];
				$dateadded			= $DataRows['dateadded'];
				$dateadded			= $DataRows['dateadded'];
				$Profile_picture    = $DataRows['profile_picture'];
				$firstname		    = $DataRows['firstname'];
				$lastname    		= $DataRows['lastname'];
			}

	}elseif (isset($_POST['request'])){

			$freelancerName = $_POST['freelancersName'];
			$freelancerStack = "_";
			$freelancer_id = $_POST['freelancer_id'];
			$gigid = 0;
			$freelancer_gigId= $_POST['detail_of_workID'];
			global $ConnectingDB;

			$sql = "INSERT INTO ongoing_completed_work(freelancer_name, freelancer_stack, freelancer_id, freelancer_gigId,client_id, client_gig_id,gig_status)
				VALUES(:freelancerName, :freelancerStack, :freelancerId, :freelancer_gigId,:client_Id, :clientGigId,'REQUESTED')";
			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue('freelancerName', $freelancerName);
			$stmt->bindValue('freelancerStack', $freelancerStack);
			$stmt->bindValue('freelancerId', $freelancer_id);
			$stmt->bindValue('clientGigId', $gigid);
			$stmt->bindValue('freelancer_gigId', $freelancer_gigId);
			$stmt->bindValue('client_Id', $UserId);
			$Execute = $stmt->execute();
			if ($Execute) {
				$_SESSION["SuccessMessage"]= "Congratulations. Request has been made successfully.";
				Redirect_to('companydashboard.php');
				
			}else{
				$_SESSION["ErrorMessage"]= "problem occured. could not inser";
				Redirect_to('companydashboard.php');
			}
	}else{
		$_SESSION["ErrorMessage"]= "could not get page";
		Redirect_to('index.php');
	}
?>

	
<!DOCTYPE html>
<html>
<head>
	<title>freelancers work post</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css-files/sellerdasboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/companydashboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/proposalInformation.css">
</head>
<body>

	<div class="container mt-5" id="viewPostedWork" style="border: 1px solid grey; padding: 10px; border-radius: 5px; box-shadow: 5px 5px 5px grey;">
		<?php

		?>
		<form action="work_detail_byFreelancer.php" method="POST">
			<div class="row">
				<div class="col-md-2">
					<img src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture;?>" class="ml-3" style="width: 80px; height: 80px; border-radius: 50%; border: 1px solid grey">
				</div>
				<div class="col-md-4 pt-3">
					<h4><?php echo $firstname. " ". $lastname?></h4>		
					<div><i><?php echo $GigCategory;?></i></div>		
				</div>
				<div class="col-md-6 text-right pr-4">
					<h5 class="pr-4">Price: N <?php echo number_format($GigPrice);?></h5>
					<p>posted on: <?php 
					$dateadded = date('d M, Y', strtotime($dateadded));
								echo $dateadded;?>
									
					</p>
				</div>
			</div>
			<hr>

			<center><?php echo $GigProposal;?></center>

			<hr>
			<div class="row container">
				<div class="col-md-6" style="border-right:1px solid grey;display: flex; justify-content: center; ">
					<img src="images/freelancer_workImages/<?=$GigPictureOne;?>" style="width:95%; height: 150px; border: 1px solid grey;">
				</div>

				<div class="col-md-6" style="display: flex; justify-content: center; ">
					<img src="images/freelancer_workImages/<?=$GigPictureTwo;?>" style="width:95%; height: 150px; border: 1px solid grey;">
				</div>
			</div>
			
			<center>
				<input type="submit" name="request" value="REQUEST FOR WORK" class="btn btn-success mt-4">
			</center>


			<input type="hidden" name="freelancersName" value="<?php echo $firstname. ' '. $lastname;?>">
			<input type="hidden" name="detail_of_workID" value="<?php echo $detail_of_workID;?>">
			<input type="hidden" name="freelancer_id" value="<?php echo $freelancerID;?>">
		</form>
	</div>

</body>
</html>