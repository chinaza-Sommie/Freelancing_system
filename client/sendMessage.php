<?php 
	require_once("../includes/DB.php");
?>
 <?php
 
 $freelancerId= isset($_POST['freelancerId']) ? $_POST['freelancerId'] : "";
 $UserId= isset($_POST['UserId']) ? $_POST['UserId'] : "";
 $freelancerName= isset($_POST['freelancerName']) ? $_POST['freelancerName'] : "";
 $messages= isset($_POST['messages']) ? $_POST['messages'] : "";

 $freelancerId=intval($freelancerId);
 $UserId=intval($UserId);

 $sql = "INSERT INTO message(fl_id,cl_id,sender,message )
 VALUES ('$freelancerId', '$UserId', 'client','$messages')";
 $send = $ConnectingDB->query($sql);

 if ($send) {
 	$responses = array(
 		'type' => 'success',
 		'freelancerId' => "$freelancerId",
 		'freelancerName' => "$freelancerName"
 	);
 } else {
 	$responses = array(
 		'type' => 'error',
 		'freelancerId' => "$freelancerId",
 		'freelancerName' => "$freelancerName"
 	);
 }
 
echo json_encode($responses);			
?>