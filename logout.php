<?php
	require_once("includes/sessions.php");
	require_once("includes/functions.php");

?>

<?php 
	$_SESSION['User_ID']=null;
	$_SESSION['UserName']= null;
	session_destroy();
	Redirect_to('login.php');
?>