<!-- <?php 
	require_once("../includes/DB.php");
	require_once("../includes/sessions.php");
	require_once("../includes/functions.php");

	// Confirm_Login();
?>
	<!-- the php code below is used to fetch user data from the registration page -->
<?php 

if(!isset($_SESSION['Admin_ID']) && !isset($_SESSION['AdminName'])){
	header("location: login.php");
}
	$UserId = $_SESSION['Admin_ID'];
	global $ConnectingDB;
	$sql = "SELECT * FROM admins_registration WHERE id='$UserId'";
	$stmtuser= $ConnectingDB->query($sql);
	if ($stmtuser) {
		while($DataRows = $stmtuser->fetch()){
			$firstname = $DataRows['firstname'];
			$lastname = $DataRows['lastname'];
			$Profile_picture  = $DataRows['profile_picture'];
		}
	} else {
		header("location: Adminlogin.php");
	}
	

?>

		<!-- THIS HANDLES CATEGORY QUESTIONS -->
<?php 
	if (isset($_POST['AddQuestion'])) {
		$question = $_POST['question'];
		$workCategory = $_POST['workCategory'];
		$optionAnswer = $_POST['optionAnswer'];
		$option1 = $_POST['option1'];
		$option2 = $_POST['option2'];
		$option3 = $_POST['option3'];
		$option4 = $_POST['option4'];

		if(empty($question) || ($optionAnswer == 'select correct option') || ($workCategory  =='choose category')|| empty($option1) || empty($option2) || empty($option3) || empty($option4)){
			$_SESSION["ErrorMessage"]= "Sorry, Fields cannot be empty..";
		}else{
			global $ConnectingDB;
			$sql = "INSERT INTO verification_questions(question, que_answer, que_category, option1, option2, option3, option4)";
			$sql .= "VALUES(:questioN, :que_answeR, :que_categorY, :optioN1, :optioN2, :optioN3, :optioN4)";

			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':questioN',$question);
			$stmt->bindValue(':que_answeR',$optionAnswer);
			$stmt->bindValue(':que_categorY',$workCategory);
			$stmt->bindValue(':optioN1',$option1);
			$stmt->bindValue(':optioN2',$option2);
			$stmt->bindValue(':optioN3',$option3);
			$stmt->bindValue(':optioN4',$option4);
		
			$Execute=$stmt->execute();
			if($Execute){
				$_SESSION["SuccessMessage"]= "Question has been added Successfully:)";
				Redirect_to("adminDashboard.php");
			}else{
				$_SESSION["ErrorMessage"]= "A problem occured. Please try again";
			}
		}
	}
 ?>

		<!--  THIS HANDLES THE SKILLS FORM VALIDATION-->
	<?php 
	if(isset($_POST['AddSkills'])){
		$skillName = $_POST['skillName'];
		$workCategory = $_POST['workCategory'];
		$skillSlug = "None";
		if(empty($skillName)){
			$_SESSION["ErrorMessage"]= "This field can not be empty";
		}elseif (checkSkill($skillName)) {
			$_SESSION["ErrorMessage"]= "Sorry, This category already exists.";
		}
		else{
			global $ConnectingDB;
			$sql = "INSERT INTO skills(skill_name, skill_slug, skill_category)";
			$sql .= "VALUES(:skillnamE, :skillsluG, :skillcategorY)";

			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':skillnamE',$skillName);
			$stmt->bindValue(':skillsluG',$skillSlug);
			$stmt->bindValue(':skillcategorY',$workCategory);
		
			$Execute=$stmt->execute();
			if($Execute){
				$_SESSION["SuccessMessage"]= "Skill has been added Successfully:)";
			}else{
				$_SESSION["ErrorMessage"]= "A problem occured. Please try again";
			}
		}
	}
?>
		<!-- THE PHP CODE BELOW IS USED TO ADD CATEGORIES TO THE TABLE -->
<?php 
	if(isset($_POST['AddCategories'])){
		$categoryName = $_POST['categoryName'];
		$categorySlogan= "None";
		$categoryImage = $_FILES["categoryImage"]["name"];
		$TargetOne = "../images/category_img/".basename($_FILES["categoryImage"]["name"]);
		if(empty($categoryName) || empty($categoryImage)){
			$_SESSION["ErrorMessage"]= "This field can not be empty";
		}elseif (checkCategory($categoryName)) {
			$_SESSION["ErrorMessage"]= "Sorry, This category already exists.";
		}
		else{
			global $ConnectingDB;
			$sql = "INSERT INTO categories(ctgy_name, ctgy_slug, category_picture)";
			$sql .= "VALUES(:categorynamE, :categorySlogan, :categoryImagE)";

			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':categorynamE',$categoryName);
			$stmt->bindValue(':categorySlogan',$categorySlogan);
			$stmt->bindValue(':categoryImagE',$categoryImage);
		
			$Execute=$stmt->execute();
			if($Execute){
				move_uploaded_file($_FILES["categoryImage"]["tmp_name"],$TargetOne);
				$_SESSION["SuccessMessage"]= "category has been added Successfully:)";
			}else{
				$_SESSION["ErrorMessage"]= "A problem occured. Please try again";
			}
		}
	}
?>

<!-- DELETE CATEGORIES FROM TABLE -->

<!-- edit profile Image -->
<?php 
	if(isset($_POST['EditImage'])){
		$Imageupdate = $_FILES["Imageupdate"]["name"];
		$TargetOne = "images/freelancer_Profile_Pictures/".basename($_FILES["Imageupdate"]["name"]);

		global $ConnectingDB;
			if(!empty($_FILES["Imageupdate"]["name"])){
				$sql = "UPDATE registerfreelancer SET profile_picture='$Imageupdate' WHERE id='$UserId'";
			}else{
				Redirect_to("freelancerdashboard.php");
			}
			$Execute = $ConnectingDB->query($sql);
			move_uploaded_file($_FILES["Imageupdate"]["tmp_name"],$TargetOne);
			if($Execute){
				$Target_Path_To_DELETE_Image = "images/freelancer_Profile_Pictures/$Profile_picture";
				unlink($Target_Path_To_DELETE_Image);
				$_SESSION["SuccessMessage"]= "Profile picture updated Successfully";
				Redirect_to("freelancerdashboard.php");
			}else{
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("freelancerdashboard.php");
			}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="../css-files/Lobibox.min.css">
	<link rel="stylesheet" type="text/css" href="../css-files/animate.css">
	<link rel="stylesheet" type="text/css" href="../css-files/sellerdasboard.css">
	<script type="text/javascript" src="../jquery_file/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../Lobibox.js"></script>
	
	
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
		            <a href="#" class="nav-item nav-link" onclick="openTabs(event, 'Clients')"> Clients </a>
		            <a href="#" class="nav-item nav-link" onclick="openTabs(event, 'Freelancers')"> Freelancers</a>
		            <a href="#" class="nav-item nav-link" onclick="openTabs(event, 'All_work')"> All work </a>
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
							$sql = "SELECT * FROM admins_registration 
							WHERE id='$UserId'";
							$stmtgigs = $ConnectingDB->query($sql);
							while ($DataRows = $stmtgigs->fetch()){
							$admin_Id 	= $DataRows['id'];
							$Profile_picture    = $DataRows['profile_picture'];
						?>
							<img src="../images/freelancer_Profile_Pictures/<?php echo $Profile_picture;?>" width="100px" height="100px" class="profileimg">
						<?php }?>
						<p class="userName"> <?php echo $firstname. " " . $lastname?></p>

						<div >
							<p class="inboxlogout" onclick="openTabs(event, 'Dashboard')">Dashboard</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Profile')">Profile</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Freelancers')">Freelancers</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Clients')"> Clients</p>
							<p class="inboxlogout" onclick="openTabs(event, 'All_work')"> All work</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Categories')"> Categories</p>
							<p class="inboxlogout" onclick="openTabs(event, 'Skills')"> Skills</p>
							<p class="inboxlogout" onclick="openQuestions()"> Questions</p>
							<p class="inboxlogout" onclick="openTabs(event, 'logout')"> Log out</p>
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
					<h3>Statistics</h3>

						<hr>
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<div class="card text-white bg-primary mb-4 py-4">
						            <div class="card-body text-center">
						                <h5 class="card-title"><?php Total_freelancer() ;?></h5>
						                <h5 class="card-text">Number of freelancers</h5>
						            </div>
						        </div>
							</div>

							<div class="col-md-6">
								<div class="card text-white bg-info mb-4 py-4">
						            <div class="card-body text-center">
						                <h5 class="card-title"><?php Total_clients();?></h5>
						                <h5 class="card-text">Number of clients</h5>
						            </div>
						        </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="card text-white bg-dark mb-4 py-4">
						            <div class="card-body text-center">
						                <h5 class="card-title"><?php Total_work(); ?></h5>
						                <h5 class="card-text">Total work</h5>
						            </div>
						        </div>
							</div>

							<div class="col-md-6">
								<div class="card text-white bg-success mb-4 py-4">
						            <div class="card-body text-center">
						                <h5 class="card-title"><?php total_completed_work(); ?></h5>
						                <h5 class="card-text">Total work completed</h5>
						            </div>
						        </div>
							</div>
						</div>
					</div>
				</div>

				<!-- available jobs tab -->
				<div class="container mycontainhide" id="Freelancers">
					<h3><i>Freelancers</i></h3>
					<hr>
					<?php 
							if(!Total_freelancer_display()){
								echo "OOPS!!! There are no freelancers yet";
							}else{
								global $ConnectingDB;
								$sql = "SELECT * FROM registerfreelancer";
								$stmt = $ConnectingDB->query($sql);
								$SN =1;
								while ($DataRows = $stmt->fetch()){
									$frelancerGigId 		= $DataRows['id'];	
									$firstname		 		= $DataRows['firstname'];
									$lastname		 		= $DataRows['lastname'];
									$email 					= $DataRows['email'];
									$profile_picture 		= $DataRows['profile_picture'];
									$freelancecategory 				= $DataRows['freelancecategory'];
									$profile_picture 		= $DataRows['profile_picture'];
						?>
					<div class="gigslist" id="firstgig"> 
						<p><?php echo $SN;?></p>
						<img src="../images/freelancer_workImages/<?php echo $profile_picture;?>" width="75px" height="50px">
						<p> <?php echo $lastname." ". $firstname;?> </p>
						<p> <?php echo $freelancecategory;?></p>
						<div style="width:20%; display: flex; justify-content: space-around;">
							<p class="badge badge-primary"> <span class=" fa fa-check"></span></p>		
						</div>
					</div>
					<?php $SN++;}}?>
				</div>


					<!-- For earnings tab -->
				<div class="container mycontainhide" id="Clients">
					<h3><i>Clients</i></h3>
					<hr>
					<?php 
							
								$client_sql = "SELECT * FROM `registerpage` ";
								$client_stmt = $ConnectingDB->query($client_sql);
								$SN =1;
								$client_result= $ConnectingDB->query($client_sql);
								$client_result->execute();
								if(($client_result->rowcount())>=1){
								while ($DataRows = $client_stmt->fetch()){
									$ClintId 		= $DataRows['id'];	
									$firstname		 		= $DataRows['firstname'];
									$lastname		 		= $DataRows['lastname'];
									$email 					= $DataRows['email'];
									$profile_picture 		= $DataRows['profile_picture'];
						?>
					<div class="gigslist" id="firstgig"> 
						<p><?php echo $SN;?></p>
						<img src="../images/freelancer_workImages/<?php echo $profile_picture;?>" width="75px" height="50px">
						<p> <?php echo $lastname." ". $firstname;?> </p>
						<div style="width:20%; display: flex; justify-content: space-around;">
							<p class="badge badge-primary"> <span class=" fa fa-check"></span></p>		
						</div>
					</div>
					<?php $SN++;}}
					else{
						echo "OOPS!!! There are no Clients yet";
					}
					?>
				</div>


						<!-- THIS IS ALL_WORK TAB -->
				<?php require 'adminTabs/allworktab.php'; ?>

					<!-- THIS IS SKILLS TAB -->
				<?php require 'adminTabs/addSkills.php'; ?>

				<!-- THIS IS QUESTIONS TAB -->
				<?php require 'adminTabs/questions.php'; ?>


						<!-- THIS WHERE CATEGORIES ARE ADDED -->
				<div class="container mycontainhide " id="Categories">
					<form action="adminDashboard.php" method="POST"  enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<p>Enter Category name:</p>
								<div class="input-group">            
						        	<input type="text" class="form-control" id="search-text" name="categoryName" placeholder="eg. Android Development">    
								</div>
							</div>
							<div class="col-md-6">
								<p>Add Category Image:</p>
								<div class="form-group">
									<div class="custom-file">
										<input class="custom-file-input" type="File" name="categoryImage" value="" id="imageselect" >
										<label for="imageselect" class="custom-file-label">Select Image</label>
									</div>
								</div>
							</div>
						</div>
						<input type="submit" name="AddCategories" value="Add Category" class="btn btn-primary">
					</form>
					<hr>

					<table class="table table-striped table-dark text-center">
						<form action="adminDashboard.php" method="POST">
					    <thead>
					        <tr>
					            <th>S/N</th>
					            <th>Category Name</th>
					            <th>Freelancers in Category</th>
					            <th>Date Added</th>
					            <th>------</th>
					        </tr>
					    </thead>
					    <tbody>

					    	<?php 
								global $ConnectingDB;
								$sql = "SELECT * FROM categories";
								$stmtgigs = $ConnectingDB->query($sql);
								$SN=1;
								while ($DataRows = $stmtgigs->fetch()){
									$CategoryId 			= $DataRows['ctgy_id'];
									$categoryName	 		= $DataRows['ctgy_name'];

									$fetch = $ConnectingDB->query("SELECT COUNT(id) AS counter FROM registerfreelancer WHERE freelancecategory='$categoryName'");
									$fetchRow =  $fetch->fetch();
									$counteFreelancers = $fetchRow['counter'];
								
								$time_created			= $DataRows['time_created'];
							?>
							
					        <tr>
					            <td><?php echo $SN;?></td>
					            <td><?php echo $categoryName; ?></td>
					            <td><?php echo $counteFreelancers;?></td>
					            <td><?php echo date("d M, Y", strtotime($time_created));?></td>
					            <!-- <td><button class="btn-danger" id="deleteCategory"> Drop</button></td> -->
					            <td><a href="deleteCategory-Skills.php?CategoryId=<?=$CategoryId;?>" class="btn btn-danger">Drop</a></td>
					        </tr>  
					        <?php $SN++;}?> 
					         
					    </tbody>
						</form>
					</table>
				</div>
				<!-- ADDING TO FREELANCER'S GIG-LIST ENDS HERE -->



				<!-- Admin'S PROFILE SETTINGS -->
				<div class="mycontainhide" id="Profile">
					<h2 class="lead"> My Profile</h2>
					<hr>
					<div>
						<?php 
							global $ConnectingDB;
							$sql = "SELECT * FROM admins_registration
							WHERE id='$UserId'";
							$stmtgigs = $ConnectingDB->query($sql);
							while ($DataRows = $stmtgigs->fetch()){
							$frelancerGigId 	= $DataRows['id'];
							$firstname 	 		= $DataRows['firstname'];
							$lastname 			= $DataRows['lastname'];
							$Profile_picture    = $DataRows['profile_picture'];
							$email   			= $DataRows['email'];
						?>
							<img src="../images/freelancer_Profile_Pictures/<?php echo $Profile_picture;?>"width="100px" height="100px">
						
						<form action="adminDashboard.php" method="POST"  enctype="multipart/form-data">
							<div style="display: flex">
								<div class="form-group" style=" width: 25%">
									<div class="custom-file" style="width: 100%; margin-top: 5px;">
										<input class="custom-file-input" type="File" name="Imageupdate" value="" id="imageselect" >
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
						<p><b><em>Name:</em> </b><span><?php echo $lastname . " ". $firstname?></span></p>
						<p><b><em>Email Address:</em> </b><span> <?php echo $email;?></span></p>

					</div>
					<?php } ?>

					<div>
						
						<div class="btn btn-warning" onclick="openTabs(event, 'logout')">Logout</div>
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



	<script type="text/javascript">
		function getQuestions(){
			$.ajax({
			type: "POST",
			url: "./admin-functions.php",
			dataType: "json",
			data:{
		        getQuestion: true,
		    },
			success: function (data) {
				console.log(data)
				var values=`<h3>Question</h3>
								<hr>
								<div class="text-right">
									<div class="btn btn-primary" onclick="openTabs(event, 'AddQuestion')"> ADD QUESTIONS</div>
								</div>
								<hr>

								<table class="table table-striped table-dark text-center animated fadeInDown" >
									<form action="adminDashboard.php" method="POST">
								    <thead>
								        <tr>
								            <th>S/N</th>
								            <th>Question</th>
								            <th>Answer to Question</th>
								            <th>Associated Category</th>
								            <th>Date Added</th>
								            <th>Action</th>
								        </tr>
								    </thead>
								    <tbody>
							`;
				if (data.length===0) {
					values += `<tr><div class="alert alert-info">
				 <strong>Oh!</strong> No question yet but you can <a href="javascript:void(0)" class="alert-link" onclick="openTabs(event, 'AddQuestion')">add questions</a>.
				</div></tr>`;
				} else {
					values += data.map(tableData);
				}
				
				function tableData(value) {
				    return `<tr>
					            <td>${value.SN}</td>
					            <td style="white-space: pre-line;">${value.question}</td>
					            <td>${value.ques_answer}</td>
					         	<td> ${value.ctgy_name}</td>
					         	<td>${value.date}</td>
					            <td><a href="javascript:void(0)" onclick="deleteQuestion(${value.id})" class="btn btn-danger">Drop</a></td>
					        </tr>`;
				}		
				values +=`</tbody></table>`;
				$("#Questions").html(values);
			},
			error: function (result) {
				alert("Error");
			}
		})
		}
		function openQuestions(){
			openTabs(event, 'Questions');
			getQuestions();
		}
	</script>

						<!-- javascript goes here -->
	<script type="text/javascript" src="../popper/docs/js/jquery.min.js"></script>
	<script type="text/javascript" src="../popper/docs/js/main.js"></script>
	<script type="text/javascript" src="../bootstrap/dist/js/bootstrap.js"></script>
	<script>


		function openTabs(e, tabId){
			var i, mycontainhide;

			 mycontainhide = document.getElementsByClassName('mycontainhide');
			for(i=0; i<mycontainhide.length; i++){
				mycontainhide[i].style.display = "none";
			}

			document.getElementById(tabId).style.display = "block";
		}


		

		document.getElementById('every-work').classList.add('.active');
		function orderTabs(e, idTabs){
			var i, mycontainhide;

			 ordercontainhide = document.getElementsByClassName('ordercontainhide');
			 var ordertabs = document.getElementsByClassName('ordertabs');

			for(i=0; i<ordercontainhide.length; i++){
				ordercontainhide[i].style.display = "none";
				ordertabs[i].classList.add('.active');
			}
			document.getElementById('every-work').classList.remove('.active');

			document.getElementById(idTabs).style.display = "block";
		}
	
		//messaging tab
		function sendMessage(){

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
		window.onload=function(){
			openTabs(event, 'Dashboard');
			
		}
	</script>
</body>

</html> -->