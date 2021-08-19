<?php 
	require_once("includes/DB.php");
	require_once("includes/sessions.php");
	require_once("includes/functions.php");
?>

<?php 
		$UserId = $_SESSION['User_ID'];
		if(!checkUserNameExistsorNot($UserId)){
			$_SESSION["ErrorMessage"]= "Sorry, you have not posted any work yet. Go ahead and create one";
			Redirect_to("freelancerdashboard.php");
		}else{
			global $ConnectingDB;
			$sql= "DELETE FROM  freelancergigform WHERE freelancer_reg_id='$UserId'";
			$Execute = $ConnectingDB->query($sql);
			if($Execute){
				$Target_Path_To_Delete_Image_One = "images/freelancer_workImages/$GigPictureOne";
				unlink($Target_Path_To_Delete_Image_One);
				$Target_Path_To_Delete_Image_Two = "images/freelancer_workImages/$GigPictureTwo";
				unlink($Target_Path_To_Delete_Image_Two);
				$_SESSION["SuccessMessage"]= "All Posted works have been deleted Successfully";
				Redirect_to("freelancerdashboard.php");
			}else{
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("freelancerdashboard.php");
			}
		}
		
?>