<?php
	require_once("../includes/DB.php");
	require_once("../includes/sessions.php");
	require_once("../includes/functions.php");

	if (isset($_GET['SkillId'])) {
		$SkillId = $_GET['SkillId'];
		global $ConnectingDB;
		$sql= "DELETE FROM skills WHERE skill_id='$SkillId'";
		$Execute = $ConnectingDB->query($sql);
		if($Execute){
			$_SESSION["SuccessMessage"]= "Skill deleted Successfully";
			Redirect_to("adminDashboard.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("adminDashboard.php");
		}

	}elseif (isset($_GET['CategoryId'])) {
		$CategoryId = $_GET['CategoryId'];
		global $ConnectingDB;
		$sql= "DELETE FROM categories WHERE ctgy_id='$CategoryId'";
		$Execute = $ConnectingDB->query($sql);
		if($Execute){
			$_SESSION["SuccessMessage"]= "Categories deleted Successfully";
			Redirect_to("adminDashboard.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
			Redirect_to("adminDashboard.php");
		}
	}

	else{
		$_SESSION["ErrorMessage"]= "Something went wrong. Try again";
		Redirect_to("../index.php");
	}



?>

