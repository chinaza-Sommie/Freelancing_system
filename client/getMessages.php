<?php 
	require_once("../includes/DB.php");
?>
 <?php
 
 $freelancerId= isset($_POST['freelancerId']) ? $_POST['freelancerId'] : "";
 $userID= isset($_POST['userID']) ? $_POST['userID'] : "";

$freelancerId=intval($freelancerId);
$userID=intval($userID);

 $sql = "SELECT * FROM `message` where fl_id=$freelancerId and cl_id=$userID ORDER BY time_sent";
 $messages = $ConnectingDB->query($sql);

 $responses = array();
 foreach ($messages as $message) {
 	$responses[]=$message;
 }
echo json_encode($responses);			
?>