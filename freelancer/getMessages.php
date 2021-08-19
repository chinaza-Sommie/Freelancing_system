<?php 
	require_once("../includes/DB.php");
?>
 <?php
 
 $clientID= isset($_POST['clientID']) ? $_POST['clientID'] : "";
 $userID= isset($_POST['userID']) ? $_POST['userID'] : "";

$clientID=intval($clientID);
$userID=intval($userID);

 $sql = "SELECT * FROM `message` where fl_id=$userID and cl_id=$clientID ORDER BY time_sent";
 $messages = $ConnectingDB->query($sql);
 $responses = array();
 foreach ($messages as $value) {
 	$responses[]=$value;
 }
echo json_encode($responses);			
?>