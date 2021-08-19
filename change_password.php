<?php 
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");
if (isset($_GET['userID']) && isset($_GET['usertype'])) {
	$userID=$_GET['userID'];
	$usertype=$_GET['usertype'];
}
else{
	if(isset($_POST['change-password'])){
		$newPassword = $_POST['newPass'];
		$confirmNewPassword = $_POST['confirm-newPass'];
		$userID = $_POST['userID'];
		$usertype = $_POST['usertype'];

		if($newPassword === $confirmNewPassword){
			$password_hash=password_hash($newPassword, PASSWORD_DEFAULT);

			global $ConnectingDB;
			$query = "UPDATE $usertype SET pass='$password_hash' WHERE id='$userID'";
			$Execute = $ConnectingDB->query($query);
			if($Execute){
				$_SESSION["SuccessMessage"]= "password changed Successfully";
				Redirect_to("login.php");
			}else{
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("login.php");
			}
		}else{
			// echo "passwords do not match";
			$_SESSION["ErrorMessage"]= "passwords do not match";
		}
	}else{
		Redirect_to("login.php");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css-files/register.css">
</head>
<body>

	<div class="container mt-5">
		<?php 
			echo ErrorMessage();
			echo SuccessMessage();
		?>
		<div class="container" style="width:80%">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<input type="hidden" name="userID" value="<?php echo $userID ?>">
				<input type="hidden" name="usertype" value="<?php echo $usertype ?>">
				<h3>
					Change your password
				</h3>
				<hr>
				<div>
					<p>Enter New Password:</p>
					<div class="input-group">            
						<input type="text" class="form-control" id="search-text" name="newPass" placeholder="Enter new password">    
					</div>
				</div>		

				<div class="mt-3">	

					<p>Confirm New Password:</p>
					<div class="input-group">            
						<input type="text" class="form-control" id="search-text" name="confirm-newPass" placeholder="Confirm new password">    
					</div>
				</div>
						
					<input type="submit" name="change-password" value="Change Password" class="btn btn-primary mt-4" style="width: 100%;">
			</form>
		</div>
	</div>
</body>
</html>