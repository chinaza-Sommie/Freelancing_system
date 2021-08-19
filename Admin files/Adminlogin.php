<?php 
	require_once("../includes/DB.php");
	require_once("../includes/sessions.php");
	require_once("../includes/functions.php");
?>

<?php
	if(isset($_POST['loginAdmin'])){
		$Email = $_POST['email'];
		$Password = $_POST['pass'];

		if(empty($Email) || empty($Password)){
			$errormessage="";
			// Redirect_to("login.php");

		}else{
			

			$found_Account=Login_Admin_Attempt($Email);
			if($found_Account){
				if (password_verify($Password,$found_Account["Password"])) {
					
				$_SESSION['Admin_ID']=$found_Account["id"];
				$_SESSION['AdminName']=$found_Account["firstname"];
				$_SESSION["SuccessMessage"]= "Welcome to your dashboard";
				Redirect_to('adminDashboard.php');
				}else{
					$_SESSION["ErrorMessage"]= "incorrect email/password";
					Redirect_to('Adminlogin.php');
				}
				// echo "Welcome to your dashboard";
			}else{
				$_SESSION["ErrorMessage"]= "incorrect email/password";
			}
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Adim Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../css-files/freelance.css">
	<link rel="stylesheet" type="text/css" href="../css-files/Lobibox.min.css">
	<link rel="stylesheet" type="text/css" href="../css-files/sellerdasboard.css">
	<script type="text/javascript" src="../jquery_file/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../Lobibox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php if (isset($errormessage)): ?>
				Lobibox.notify('error', {
				position: 'top right',
				title: 'Please fill the form',
				msg: '<?php echo $errormessage ?>'
			});
			<?php endif ?>
			
		})
	</script>
</head>
<body>

	<div class="container" style=" display: flex; justify-content: center;">
		<div class="maincon mt-5" style="border: 1px solid grey; border-radius: 15px; width: 80%">
			<div class="text-center mb-4">
				<img src="../images/logo4.jpg" height="95px" width="50px">
				<h3>stretch</h3>
			</div>
			<form class="mycontainhidereg" action="Adminlogin.php" method="POST" enctype="multipart/form-data">
				<div class="text-center">
					
					<input type="email" name="email" placeholder="Enter email" class="reviewInputs">
						
					<input type="password" name="pass" placeholder="Enter password" class="reviewInputs mt-4">
				</div>

				<div class="text-center mt-3">
					<input type="submit" name="loginAdmin" value="Login" class="btn btn-primary mb-5">
					
				</div>
			</form>
		</div>
	</div>

</body>
</html>