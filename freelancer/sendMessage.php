<?php 
	require_once("../includes/DB.php");
?>
 <?php
 
 $clientid= isset($_POST['clientid']) ? $_POST['clientid'] : "";
 $UserId= isset($_POST['UserId']) ? $_POST['UserId'] : "";
 $clientName= isset($_POST['clientName']) ? $_POST['clientName'] : "";
 $messages= isset($_POST['messages']) ? $_POST['messages'] : "";

 $clientid=intval($clientid);
 $UserId=intval($UserId);

 $sql = "INSERT INTO message(fl_id,cl_id,sender,message )
 VALUES ('$UserId', '$clientid', 'freelancer','$messages')";
 $send = $ConnectingDB->query($sql);

 if ($send) {
 	$responses = array(
 		'type' => 'success',
 		'clientid' => "$clientid",
 		'clientName' => "$clientName"
 	);
 } else {
 	$responses = array(
 		'type' => 'error',
 		'clientid' => "$clientid",
 		'clientName' => "$clientName"
 	);
 }
 
echo json_encode($responses);			
?>