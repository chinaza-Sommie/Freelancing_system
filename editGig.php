<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");
?>

<?php 
	
	if(isset($_GET['editGig'])){
		$editforfreelancer = $_GET['editGig'];

		global $ConnectingDB;
			$sql = "SELECT * FROM freelancergigform WHERE id='$editforfreelancer'";
			$stmtgigs = $ConnectingDB->query($sql);
			while ($DataRows = $stmtgigs->fetch()){
				$frelancerGigId 	= $DataRows['id'];
				$GigProposal 		= $DataRows['Proposal'];
				$GigPictureOne		= $DataRows['pictureOne'];
				$GigPictureTwo 		= $DataRows['pictureTwo'];
				$GigPrice 			= $DataRows['amount'];
				$workLink			= $DataRows['workLink'];
			}

	}elseif (isset($_POST['EditFreelancerGig'])) {
		$proposal = $_POST['proposal'];
		$amountCharged = $_POST['amountCharged'];
		$workLink = $_POST['workLink'];
		$amountCharged = $_POST['amountCharged'];
		$editGidId = $_POST['editGidId'];
		$imageOne = $_FILES["Image1"]["name"];
		$TargetOne = "images/freelancer_workImages/".basename($_FILES["Image1"]["name"]);
		$imageTwo = $_FILES["Image2"]["name"];
		$TargetTwo = "images/freelancer_workImages/".basename($_FILES["Image2"]["name"]);
		// echo "<script>alert('".$amountCharged."')</script>";
		// var_dump($_POST); die;
		if(empty($proposal)){
			$_SESSION["ErrorMessage"]= "Proposal should not be empty";
			Redirect_to('freelancerdashboard.php');
		}elseif(strlen($proposal)<5){
			$_SESSION["ErrorMessage"]= "Proposal should have more than 5 characters";
			Redirect_to('freelancerdashboard.php');
		}elseif(strlen($proposal)>254){
			$_SESSION["ErrorMessage"]= "Proposal is too long";
			Redirect_to('freelancerdashboard.php');
		}else{
			global $ConnectingDB;
			if(!empty($_FILES["Image1"]["name"])){
				$sql = "UPDATE freelancergigform SET Proposal='$proposal', pictureTwo='$imageOne', amount='$amountCharged', workLink='$workLink' WHERE id='$editGidId'";
			}elseif(!empty($_FILES["Image2"]["name"])){
				$sql = "UPDATE freelancergigform SET Proposal='$proposal', pictureTwo='$imageTwo', amount='$amountCharged', workLink='$workLink' WHERE id='$editGidId'";
			}else{
				$sql = "UPDATE freelancergigform SET Proposal='$proposal', amount='$amountCharged', workLink='$workLink' WHERE id='$editGidId'";
			}
			$Execute = $ConnectingDB->query($sql);
			move_uploaded_file($_FILES["Image1"]["tmp_name"],$TargetOne);
			move_uploaded_file($_FILES["Image2"]["tmp_name"],$TargetTwo);
			if($Execute){
				$_SESSION["SuccessMessage"]= "Gig Updated Successfully";
				Redirect_to("freelancerdashboard.php");
			}else{
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("freelancerdashboard.php");
			}
		}

		// this code below is used to update query for clients gigs in the database
	}elseif (isset($_GET['editClientGig'])) {
		$ClientGigId = $_GET['editClientGig'];
		global $ConnectingDB;
							
			$sql = "SELECT * FROM clientsgigsform WHERE id ='".$ClientGigId."'";
				
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
	}elseif (isset($_POST['editClientGigBtn'])) {
		$jobTitle = $_POST['jobTitle'];
		$Workcategory = $_POST['workCategory'];
		$priceTag = $_POST['priceTag'];
		$jobSummary = $_POST['jobSummary'];
		$jobrespbility1 = $_POST['jobrespbility1'];
		$jobrespbility2 = $_POST['jobrespbility2'];
		$jobrespbility3 = $_POST['jobrespbility3'];
		$jobrespbility4 = $_POST['jobrespbility4'];
		$clientGigId = $_POST['clientGigId'];
		// if($Workcategory == "choose"){
		// 	$Workcategory = $_POST['currentworkcategory'];
		// }
		//this is used to validate each input field
		if(empty($jobTitle) || empty($priceTag) || empty($jobSummary) || empty($jobrespbility1) || empty($jobrespbility2) || empty($jobrespbility3) || empty($jobrespbility4)){
			
			$_SESSION["ErrorMessage"]= "No field should be blank. If you do not want to change a field then leave it as it is.";
			Redirect_to('companydashboard.php');

		}elseif ($Workcategory == "choose") {
			$Workcategory = $_POST['currentworkcategory'];
		}
		// var_dump($_POST); die;
			global $ConnectingDB;
			
				$sql = "UPDATE clientsgigsform SET JobTitle='$jobTitle', WorkCategory='$Workcategory', AmountforWork='$priceTag', SummaryofWorkdet='$jobSummary', workresponsibility1='$jobrespbility1', workresponsibility2='$jobrespbility2', workresponsibility3='$jobrespbility3', workresponsibility4='$jobrespbility4' WHERE id='".$clientGigId."'";
				
				$Execute = $ConnectingDB->query($sql);
			if($Execute){
				$_SESSION["SuccessMessage"]= "Gig Updated Successfully";
				Redirect_to("companydashboard.php");
			}else{
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("companydashboard.php");
			}

	}
	else{
		$_SESSION["ErrorMessage"]= "could not get page";
		Redirect_to('index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Gig</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css-files/sellerdasboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/companydashboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/proposalInformation.css">
</head>
<body>

 
	<div class="container mycontainhide mt-3" id="editforfreelancer">
		<div class="applicationformmainflex">
			<div class="applicationformmain addinggigsmain">
				<form class="text-center" action="editGig.php" method="POST"  enctype="multipart/form-data">
					<h4 class="pt-2 pl-3 text-left"><em>Edit gig.</em></h4>
					<hr>
					<textarea rows="5" placeholder="please write your proposal here" 
									name="proposal"	class="amountofcharge p-3"><?=$GigProposal;?></textarea>
					<input type="text" name="amountCharged" placeholder="amount charged" 
										value="<?=$GigPrice;?>" class="amountofcharge">
					<input type="text" name="workLink" placeholder="Please Place a link to your recent website here" value="<?=$workLink;?>" class="amountofcharge">

					<div class="container">
						<p class="text-left mt-2"><em>current images..</em></p>
						<div class="row">
							<div class="col-md-6">
								<div class="text-center" style="width:100%">
									<img src="images/freelancer_workImages/<?=$GigPictureOne;?>" width="90%" hieght="40px">
								</div>
							</div>
							<div class="col-md-6">
								<div class="text-center" style="width:100%">
									<img src="images/freelancer_workImages/<?=$GigPictureTwo;?>" width="90%" hieght="40px">
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group mt-3">
						<div class="custom-file">
							<input class="custom-file-input" type="File" name="Image1" value="" id="imageselect">
							<label for="imageselect" class="custom-file-label">Select New Image</label>
						</div>

					</div>

					<div class="form-group">
						<div class="custom-file">
							<input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
							<label for="imageselect" class="custom-file-label">Select New Image</label>
						</div>

					</div>
					<input type="hidden" name="editGidId" value="<?=$editforfreelancer?>">
					<div class="text-right">
						<input type="submit" name="EditFreelancerGig" value="Edit" class="applicationformapplybtn" style="width: 100%">
					</div>
				</form>
			</div>
		</div>
	</div>



			<!-- EDIT FORM FOR CLIENT -->
	<div class="container mycontainhide " id="editforClient">

		<p class="pt-3"><em>please add your gigs below.</em></p>

		<div class="applicationformmainflex" style="border:1px solid grey">
			<form action="editGig.php" method="POST" class="container py-4">
				<div class="row mb-2">
					<div class="col-sm-6">
						<div class="ml-2"><i>Job Title:</i></div>
							<div class="input-group">
							            
							    <input type="text" class="form-control" name="jobTitle" placeholder="Please Enter Job Title" value="<?=$JobTitle;?>">
							</div>
							<input type="hidden" name="clientGigId" value="<?=$ClientGigId;?>">
					</div>

					<div class="col-sm-6">
						<div class="ml-2"><i>Work Category:</i> 
							<em style="color: grey;">
								(Current category: <span><?=$Workcategory?></span>)
							</em>
						</div>
						<div class="input-group">
							<input type="hidden" name="currentworkcategory" value="<?=$Workcategory?>">
							<select class="form-control" name="workCategory">
							            	<option>choose </option>
								<option name="web_development">web development</option>
								<option name="Android_development">Android development</option>
							 	<option name="Web_design"> Web design</option>
							</select>            
						</div>
					</div>
				</div>

				<div class="row text-center">
					<div class="col-sm-12">
						<div class="ml-2"><i>Amount to be paid:</i></div>
							<div class="input-group">
							            
							  	<input type="text" name="priceTag" class="form-control" placeholder="Please Enter Amount" value="<?= $GigPrice;?>">
							</div>
					</div>

				</div>

				<div class="my-3">
					<div class="input-group">
						<textarea rows="5" cols="30" placeholder="Enter Summary of work Expected to be done" name="jobSummary" style="width: 100%" class="p-3"><?= $WorkSummary;?></textarea>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-sm-6">
						<div class="ml-2"><i>Job Responsibility 1:</i></div>
							<div class="input-group">
							  	<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility1" value="<?=$workresponsibility1;?>" style="width: 100%" class="p-3"><?=$workresponsibility1;?></textarea>
							</div>
						</div>

							 <div class="col-sm-6">
						<div class="ml-2"><i>Job Responsibility 2:</i></div>
							<div class="input-group">
							  	<textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility2" style="width: 100%" class="p-3"> <?=$workresponsibility2;?></textarea>
							</div>	
						</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="ml-2"><i>Job Responsibility 1:</i></div>
						<div class="input-group">
							  <textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility3" style="width: 100%" class="p-3"><?=$workresponsibility3;?></textarea>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="ml-2"><i>Job Responsibility 2:</i></div>
						<div class="input-group">
							  <textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility4" style="width: 100%" class="p-3"><?=$workresponsibility4;?></textarea>
						</div>
					</div>
				</div>
							
				<div class="mt-3">
					<input type="submit" name="editClientGigBtn" value="submit" class="btn btn-primary" style="width: 100%">
				</div>
			</form>
		</div>
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

	</script>
	<?php 
			if(isset($_GET['editGig'])){
				echo "<script>openTabs(event,'editforfreelancer')</script>";
			}
			elseif (isset($_GET['editClientGig'])) {
				echo "<script>openTabs(event,'editforClient')</script>";
			}
		?>
</body>
</html>