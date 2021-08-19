<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");

	// $deleteGigId = $_GET['deleteGigId'];
	if(isset($_GET['deleteGigId'])){
		$deleteGigId = $_GET['deleteGigId'];
		
		global $ConnectingDB;
			$sql = "SELECT * FROM freelancergigform WHERE id='$deleteGigId'";
			$stmtgigs = $ConnectingDB->query($sql);
			while ($DataRows = $stmtgigs->fetch()){
				$frelancerGigId 	= $DataRows['id'];
				$GigProposal 		= $DataRows['Proposal'];
				$GigPictureOne		= $DataRows['pictureOne'];
				$GigPictureTwo 		= $DataRows['pictureTwo'];
				$GigPrice 			= $DataRows['amount'];
			}
	}elseif (isset($_POST['deleteGig'])) {
		$deleteGigId = $_POST['gigvalue'];
		$GigPictureOne = $_POST['GigPictureOne'];
		$GigPictureTwo = $_POST['GigPictureTwo'];
		
		global $ConnectingDB;
		$sql= "DELETE FROM  freelancergigform WHERE id='$deleteGigId'";
		$Execute = $ConnectingDB->query($sql);
		if($Execute){
			$Target_Path_To_Delete_Image_One = "images/freelancer_workImages/$GigPictureOne";
			unlink($Target_Path_To_Delete_Image_One);
			$Target_Path_To_Delete_Image_Two = "images/freelancer_workImages/$GigPictureTwo";
			unlink($Target_Path_To_Delete_Image_Two);
			$_SESSION["SuccessMessage"]= "Gig deleted Successfully";
			Redirect_to("freelancerdashboard.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
		Redirect_to("freelancerdashboard.php");
		}
		
		// this if statement below is to check if it is the client deleting a gig
	}elseif(isset($_GET['deleteClientGigId'])){ 
		$deleteClientGigId = $_GET['deleteClientGigId'];
		global $ConnectingDB;
							
			$sql = "SELECT * FROM clientsgigsform WHERE id ='".$deleteClientGigId."'";
				
			$stmtfreelancergigs = $ConnectingDB->query($sql);
			while ($DataRows = $stmtfreelancergigs->fetch()){
					$ClientsGigId =$DataRows['id'];
					$JobTitle 	= $DataRows['JobTitle'];
					$GigPrice 	= $DataRows['AmountforWork'];
					$WorkLocation 	= $DataRows['WorkLocation'];
					$CompanyMotto 	= $DataRows['CompanyMotto'];
					$CompanyName 	= $DataRows['CompanyName'];
					$Workcategory 	= $DataRows['WorkCategory'];
					$WorkSummary 	= $DataRows['SummaryofWorkdet'];
					$workresponsibility1 	= $DataRows['workresponsibility1'];
					$workresponsibility2 	= $DataRows['workresponsibility2'];
					$workresponsibility3 	= $DataRows['workresponsibility3'];
					$workresponsibility4 	= $DataRows['workresponsibility4'];
					$dueDate 	= $DataRows['DueDate'];
					$clientRegId    = $DataRows['clients_reg_id'];
				}	

	}elseif(isset($_POST['deleteClientGig'])){
		$deleteClientGigId = $_POST['clientgigvalue'];

		global $ConnectingDB;
		$sql= "DELETE FROM clientsgigsform WHERE id='$deleteClientGigId'";
		$Execute = $ConnectingDB->query($sql);
		if($Execute){
			$_SESSION["SuccessMessage"]= "Gig deleted Successfully";
			Redirect_to("companydashboard.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("companydashboard.php");
		}
		// $_SESSION["SuccessMessage"]= "this works";
		// Redirect_to("companydashboard.php");
	}
	else{
		
		$_SESSION["ErrorMessage"]= "could not get page";
		Redirect_to('index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title> Delete Your Gig</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css-files/proposalInformation.css">
</head>
<body>
		<!-- this is for freelancer to delete his or her gig -->
	<div class="container py-3 mt-3 mycontainhide" id="first">
		<h4><em>Delete this Gig...</em></h4>

		<form action="deleteGigs.php" method="POST" class="px-5 py-3" style="border: 1px solid grey;">
			<h4>Gig Title Goes Here</h4>
			<hr>
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="text-center" style="width:100%">
							<img src="images/freelancer_workImages/<?=$GigPictureOne;?>" width="95%" hieght="50px">
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center" style="width:100%">
							<img src="images/freelancer_workImages/<?=$GigPictureTwo;?>" width="95%" hieght="50px">
						</div>
					</div>
				</div>
			</div>
			<div class="mt-3">
				<h5><em>Gig's proposal:</em></h5>
				<p><?=$GigProposal;?></p>
			</div>
			<input type="hidden" name="gigvalue" value="<?=$deleteGigId;?>">
			<input type="hidden" name="GigPictureOne" value="<?=$GigPictureOne;?>">
			<input type="hidden" name="GigPictureTwo" value="<?=$GigPictureTwo;?>">
			<input type="submit" name="deleteGig" value="deleteGig" class="btn btn-primary yes-btn" >
		</form>


		<!-- To delete All the gigs -->
		<?php 
			if(isset($_GET['AlldeleteGigId'])){
				
			}
		?>
	</div>


		<!-- this is for the clients to delete their gigs -->
	<div class="container py-3 mt-3 mycontainhide" id="second">
		<h4><em>Delete this Gig...</em></h4>

		<form action="deleteGigs.php" method="POST" class="px-5 py-3" style="border: 1px solid grey;">
			<h4><?= $JobTitle;?></h4>
			<hr>
			<div class="text-center">
				<img src="images/image1.png" width="100%" height="190px">
			</div>
			<div class="mt-3">
				<!-- <h5><em>Work Responsiblities:</em></h5> -->
				<h5 class="text-center mb-4" style="color: grey"><em><?= $WorkSummary; ?></em></h5>
			</div>

			<div class="Work-date-flex">
				<p>Work Fee: <span><?=$GigPrice;?></span></p>
				<p>due date: <span></span><?=$dueDate;?></p>
			</div>
			<input type="hidden" name="clientgigvalue" value="<?=$deleteClientGigId;?>">
			<input type="submit" name="deleteClientGig" value="deleteGig" class="btn btn-primary yes-btn" style="width: 100%">
		</form>
	</div>


	<script>

		function openTabs(e, tabId){
			console.log(tabId);
			var i, mycontainhide;

			 mycontainhide = document.getElementsByClassName('mycontainhide');
			 // console.log(mycontainhide);
			for(i=0; i<mycontainhide.length; i++){
				mycontainhide[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}

		window.load=function(){
			openTabs(event, 'first');
		}
	</script>
	
	<?php 
	if(isset($_GET['deleteGigId'])){
		echo "<script>openTabs(event, 'first')</script>";
	}elseif(isset($_GET['deleteClientGigId'])){
		echo "<script>openTabs(event, 'second')</script>";
	}
?>
</body>
</html>