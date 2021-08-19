<?php 
	require_once("../includes/DB.php");
	require_once("../includes/sessions.php");
	require_once("../includes/functions.php");
?>

<?php 
	if(isset($_GET['acceptWork'])){
		$acceptWork = $_GET['acceptWork'];

		global $ConnectingDB;
		$sql = "UPDATE ongoing_completed_work SET gig_status='ONGOING' WHERE id='$acceptWork'";
		$stmtupdate = $ConnectingDB->query($sql);	
		$_SESSION["SuccessMessage"]= "congrats, You have successfully accepted a job. Good work!!";
		Redirect_to("../freelancerdashboard.php");
	}
	elseif (isset($_GET['deleteWork'])) {
		$deleteWork = $_GET['deleteWork'];

		global $ConnectingDB;
		$sql= "DELETE FROM  ongoing_completed_work WHERE id='$deleteWork'";
		$Execute = $ConnectingDB->query($sql);
		if($Execute){
			$_SESSION["SuccessMessage"]= "Work has been successfully decline. Maybe next time..";
			Redirect_to("../freelancerdashboard.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("../freelancerdashboard.php");
		}
	}else{
		$_SESSION["ErrorMessage"]= "Page is not available";
		Redirect_to("../index.php");
	}

?>