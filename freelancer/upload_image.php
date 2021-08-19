<?php
session_start();
	require_once("../includes/DB.php");
if(isset($_FILES["Imageupdate"]["name"]))
{
	$data = $_FILES["Imageupdate"]["tmp_name"];
	$workid= isset($_POST['workid']) ? $_POST['workid'] : "";
	$screenshot= isset($_POST['screenshot']) ? $_POST['screenshot'] : "";
	$imageFileType = strtolower(pathinfo($_FILES["Imageupdate"]["name"],PATHINFO_EXTENSION));
	$imageName = time().'.'.$imageFileType;
	$imageName = "work-$imageName";
	echo $data;
	if(move_uploaded_file($_FILES["Imageupdate"]["tmp_name"],'../images/work_screenshots/'.$imageName)){
		$ConnectingDB->query("INSERT INTO `review_of_work`(`work_id`, `screenshot`, `screenshot_name`) VALUES ('$workid','$imageName','$screenshot')");
		header("location: edit-work.php?submitWork=$workid");
		$_SESSION["SuccessMessage"]= "Gig created successfully :)";
	}
}
 ?>
