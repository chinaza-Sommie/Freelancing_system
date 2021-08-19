<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");

	if (isset($_GET['jobid'])) {
		$jobid = $_GET['jobid'];

		// echo '<script>openTabs(event, "applyform");</script>';

		//this if statement is used to get the freelancers  details from the DB
		
			if(isset($_SESSION['Freelancer_ID'])){
				$id = $_SESSION['Freelancer_ID'];
				$sql = "SELECT * FROM registerfreelancer WHERE id='".$id."'";
				$stmtdetails = $ConnectingDB->query($sql);
				while ($DataRows = $stmtdetails->fetch()){
						$freelanceId =$DataRows['id'];
						$firstname =$DataRows['firstname'];
						$lastname =$DataRows['lastname'];
				}
			}
			
		if(freelancer_idCheck($freelanceId,$jobid)){
			$_SESSION["ErrorMessage"]= "SORRY!! You have applied for this particular job. Please check other Gigs. thank you ;)";
			Redirect_to('freelancerdashboard.php');
		}else{
				global $ConnectingDB;
								
				$sql = "SELECT * FROM clientsgigsform WHERE id ='".$jobid."'";
					
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
		}	

		# code...
	}else if (isset($_POST['submitEntireProp'])) {
		// var_dump($_POST); die;
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$fullName = $firstname." ".$lastname;
		$proposalDet = $_POST['proposalDet'];
		// $clientregid = $_POST['employer'];particularJobId
		$clientJobId = $_POST['particularJobId'];
		$freelancerregid = $_POST['employee'];
		$skills = $_POST['skills'];

		// echo "<script>alert('".$clientregid."')</script>";
		global $ConnectingDB;	
			$sql = "INSERT INTO freelancers_proposals(freelancerName, Proposal,freelancerStack, freelancer_id, client_job_id)
			VALUES(:freelancernamE,:proposaL,:freelancerstacK,:freelanceriD, :clientjobiD)";
			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue('freelancernamE',$fullName);
			$stmt->bindValue('proposaL',$proposalDet);
			$stmt->bindValue('freelancerstacK',$skills);
			$stmt->bindValue('freelanceriD',$freelancerregid);
			$stmt->bindValue('clientjobiD',$clientJobId);
			$Execute = $stmt->execute();
			if($Execute){
				$_SESSION["SuccessMessage"]= "Your proposal has been sent. Goodluck ;)";
				Redirect_to('freelancerdashboard.php');
				
			}else{
				$_SESSION["ErrorMessage"]= "A problem occured. Please try again.";
				Redirect_to('freelancerdashboard.php');

			}
	}else{
		$_SESSION["ErrorMessage"]= "could not get page";
		Redirect_to('index.php');
	}


	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Proposal form</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/proposal_form.css">
</head>
<body>

	<div class="container rounded bg-white mt-5 mb-5">
	    <div class="row">
	        <div class="col-md-3 border-right">
	        	<?php 
	        		global $ConnectingDB;
					$sql = "SELECT * FROM registerpage WHERE id='$clientRegId'";
					$stmtuser= $ConnectingDB->query($sql);
					while($DataRows = $stmtuser->fetch()){
						$ExistingName 		= $DataRows['firstname'];
						$ExistingLastName 	= $DataRows['lastname'];
						$email 				= $DataRows['email'];
						$Profile_picture    = $DataRows['profile_picture'];
					}
	        	?>
	            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
	            	<img class="rounded-circle mt-5" src="images/freelancer_Profile_Pictures/<?php echo $Profile_picture;?>" style="border:1px solid grey" height="90" width="90">
	            	<span class="font-weight-bold"><?php echo $ExistingName." ".$ExistingLastName?></span>
	            	<span class="text-black-50"><?php echo $email;?></span>
	            	</div>
	        </div>
	        <div class="mycontainhide col-md-9" id="applyform">
	        	<form action="proposal_form.php" method="POST">
		        <div class="row">
			        <div class="col-md-7 border-right">
			            <div class="p-3 py-5">
			                <div class="d-flex justify-content-between align-items-center mb-3">
			                    <h6 class="text-right">Write
			                     your proposal..</h6>
			                    <div class="px-4 py-1 add-experience" onclick="openTabs(event, 'viewdetails');"> view details</div>
			                </div>
			                <div class="row mt-4">
			                    <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" name="firstname" value="<?=$firstname;?>"></div>
			                    <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" name="lastname" value="<?=$lastname;?>"></div>
			                </div>
			                <div class="row mt-3">
			                    <div class="col-md-12"><label class="labels">Headline</label><input type="text" class="form-control" name="workCategory" placeholder="headline" value="<?=$Workcategory;?>" disabled></div>

			                    <div class="col-md-12"><input type="hidden" class="form-control" placeholder="programmers Stack" name="skills" id="inputSkillVal"></div>

			                    <div class="col-md-12"><input type="hidden" class="form-control" placeholder="programmers Stack" name="employer" id="employer" value="<?=$clientRegId;?>"></div>

			                    <div class="col-md-12"><input type="hidden" class="form-control" placeholder="jobId" name="particularJobId" id="employer" value="<?=$jobid;?>"></div>

			                    <div class="col-md-12"><input type="hidden" class="form-control" placeholder="programmers Stack" name="employee" id="employee" value="<?=$freelanceId;?>"></div>

			                    <div class="col-md-12 mt-3 "><label class="labels">Proposal:</label><textarea rows="9" name="proposalDet" style="width:100%" class="p-2" placeholder="Tell us why we should hire you"></textarea></div>
			                    
			                </div>
			   
			                <div class="mt-4 text-center"><button class="btn btn-primary profile-button" type="submit" name="submitEntireProp">Submit Proposal</button></div>
			            </div>
			        </div>
			        <div class="col-md-5">
			            <div class="p-3 py-5 ">

			                <div class="d-flex justify-content-between align-items-center experience"><span>add skills</span><span class=" px-4 p-1 add-experience" onclick="return addmySkillset()"><i class="fa fa-plus"></i>&nbsp;Skill</span></div>
			                <div id="addskills" class="mt-3">
			                	
			                	<input type="text" name="skillset" placeholder="eg. javaScript.." id="skillset">
			                	<!-- <input type="number" name="experience" placeholder="eg. 2" id="experience"> -->
			                	<input type="button" value="Add skill" name="addSkill" class="inputbutn" id="addSkillBtn">
			                	
			                </div>
			                <div id="skill-container">
			                	<!-- the skillset are added here usig javaScript -->
			                </div>
			   
			            </div>
			        </div>
			    </div>  
			    </form> 
			</div>   

			<div class="container mycontainhide col-md-9 rounded bg-white mt-5 mb-5" id="viewdetails">
			    <div >
			    	<div class="client-img-name mt-3">
									<h4> <?=$CompanyName?>,</h4><span class="ml-3 internet"><em><?=$CompanyMotto?></em></span>
							
							</div>
							<div class="mt-3">
								<p><b><em>work title: </em></b> <span><?=$Workcategory?> </span></p>
								<p><b><em>amount to be paid: </em></b> <span><?=$GigPrice?></span></p>
								<p><b><em>work duration: </em></b> <span> 3 weeks </span></p>
								<p><b><em>due date of work: </em></b> <span><?=$dueDate;?></span></p>
								
								<div class="text-center">
									<h6><em><b>Job Summary:</b></em></h6>
									<p><?=$WorkSummary;?></p>
								</div>
								<hr>
								<div>
									<h6><em><b>work Responsilbity includes:</b></em></h6>
									<ul>
										<li><?=$workresponsibility1;?></li>
										<li><?=$workresponsibility2;?></li>
										<li><?=$workresponsibility3;?></li>
										<li><?=$workresponsibility4;?></li>
									</ul>
								</div>

							<div class="mt-4 text-center"><button class="btn btn-primary px-3 profile-button" type="button">Apply for this Job</button></div>
			    </div>
			</div> 
	    </div>
	</div>

	

<script>

		function openTabs(e, tabId){
			// console.log(tabId);
			var i, mycontainhide;

			 mycontainhide = document.getElementsByClassName('mycontainhide');
			 // console.log(mycontainhide);
			for(i=0; i<mycontainhide.length; i++){
				mycontainhide[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}

		document.getElementById('addskills').style.display= "none";
		function addmySkillset(){
			document.getElementById('addskills').style.display= "block";
		}

		var skill =document.getElementById('addSkillBtn');
		skill.addEventListener('click', addNewSkill);

		// this code below creates elements and a name attribute for our form
		function addNewSkill(){
			var skillVal =document.getElementById('skillset').value;

			if(skillset.value== ""){
				alert("please fill out the required details");
			}else{
			// console.log("skill added");
			console.log(skillVal);

			var skillInput = `<input type="text" value="${skillVal}" name="skill_${skillVal}" class="inputbutn" id="" style="border:none">`;
			// console.log(skillInput);
			 var newSkillHolder = document.createElement('div');
			 newSkillHolder.innerHTML = skillInput;
			 const skillCont = document.getElementById('skill-container');
			 skillCont.appendChild(newSkillHolder);
			
			 var inputSkillVal = document.getElementById('inputSkillVal');
			 inputSkillVal.value += skillVal + ",";

			 skillset.value = "";
			}
		}

		
		
		window.onload=function(){
			openTabs(event, 'applyform');
			
		}
	</script>
</body>
</html>