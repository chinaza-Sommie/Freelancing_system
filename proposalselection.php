<?php
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");

	$PropId = $_GET['propId'];
	$gigId = $_GET['InitialpropId'];
	if (isset($PropId) || isset($_POST['chooseFreelancer']) || isset($gigId)) {
		// $myattri = $_POST['chooseFreelancer'];
			
		if(isset($_POST['chooseFreelancer'])){
			$activeOn = "ON";
			$freelancerName = $_POST['freelancerName'];
			$freelancerStack = $_POST['freelancerStack'];
			$freelancer_id = $_POST['freelancer_id'];
			$gigid = $_POST['gigId'];
			global $ConnectingDB;
			

			// $sqlInsert query is used to insert into the ongoing_completed_work table
			$sqlInsert = "INSERT INTO ongoing_completed_work(freelancer_name, freelancer_stack, freelancer_id, client_gig_id)
				VALUES(:freelancerName, :freelancerStack, :freelancerId, :clientGigId)";
			$stmt = $ConnectingDB->prepare($sqlInsert);
			$stmt->bindValue('freelancerName', $freelancerName);
			$stmt->bindValue('freelancerStack', $freelancerStack);
			$stmt->bindValue('freelancerId', $freelancer_id);
			$stmt->bindValue('clientGigId', $gigid);
			// var_dump($freelancer_id); die;
			$sqlDelete = "DELETE FROM freelancers_proposals WHERE client_job_id='$gigid'";

			// The code below is used to update the active column in clientsgigsform table
			$sqlUpdate = "UPDATE clientsgigsform SET active='$activeOn' WHERE id='".$gigid."'";

			$ExecuteInsert = $stmt->execute();
			$ExecuteDelete = $ConnectingDB->query($sqlDelete);
			$ExecuteUpdate = $ConnectingDB->query($sqlUpdate);

			if ($ExecuteInsert) {
				if($ExecuteDelete){
					if($ExecuteUpdate){
						$_SESSION["SuccessMessage"]= "Congratulations. You have picked a frelancer for your work.";
						Redirect_to('companydashboard.php');
					}else{
						$_SESSION["ErrorMessage"]= "problem occured. could not update";
				Redirect_to('companydashboard.php');
					}
				}else{
					$_SESSION["ErrorMessage"]= "problem occured. could not delete";
				Redirect_to('companydashboard.php');
				}
				
			}else{
				$_SESSION["ErrorMessage"]= "problem occured. could not inser";
				Redirect_to('companydashboard.php');
			}
		}
	}
	// else if(isset($_POST['chooseFreelancer'])){
		
	// }
	else{
		$_SESSION["ErrorMessage"]= "could not get page";
		Redirect_to('index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Select Proposal</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css-files/proposalInformation.css">

</head>
<body>

	<div class="container main-container mt-5">
			<?php

				global $ConnectingDB;
						
				$sql = "SELECT * FROM freelancers_proposals WHERE id ='".$PropId."'";
													
				$stmtfreelancergigs = $ConnectingDB->query($sql);
				while ($DataRows = $stmtfreelancergigs->fetch()){
						$ProposalId =$DataRows['id'];
						$freelancerName =$DataRows['freelancerName'];
						$proposaldetails =$DataRows['Proposal'];
						$freelancerStack =$DataRows['freelancerStack'];
						$freelancer_id =$DataRows['freelancer_id'];
						$client_job_id =$DataRows['client_job_id'];
						$datesubmitted =$DataRows['date'];
				}
			
			?>
			<div class="mycontainer">
				<form action="proposalselection.php" method="POST">
					<div class="freelancerDet-flex m-3">
						<h4><em><?=$freelancerName;?></em></h4>
						<p>Stack: <span><em><?=$freelancerStack;?></em></span></p>
					</div>
					<div class="options p-1">
						<p><input type="submit" name="chooseFreelancer" class="yes-btn" value="yes"></p>
						<p class="No-btn">NO</p>
					</div>
					<input type="hidden" name="freelancerName" value="<?=$freelancerName;?>">
					<input type="hidden" name="freelancerStack" value="<?=$freelancerStack;?>">
					<input type="hidden" name="freelancer_id" value="<?=$freelancer_id;?>">
					<input type="hidden" name="gigId" value="<?=$gigId;?>">
			</form>
			</div>
	</div>


</body>
</html>