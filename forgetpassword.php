<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");
if (isset($_POST['FLforgetPassword'])) {
	$searchEmail = (isset($_POST['email'])) ? $_POST['email'] : "" ;
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer WHERE email=:emaiL";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':emaiL',$searchEmail);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if($Result == 1){
		$DataRows = $stmt->fetch();
		$userid 	= $DataRows['id'];
		$sendmail= $searchEmail;
		$usertype="registerfreelancer";
	}else{
		echo "<script> alert('email does not exist'); window.location='login.php';</script>";
	}

}elseif (isset($_POST['CLforgetPassword'])) {
	$searchEmail = (isset($_POST['email'])) ? $_POST['email'] : "" ;
	$sql = "SELECT * FROM registerpage WHERE email=:emaiL";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':emaiL',$searchEmail);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if($Result == 1){
		$DataRows = $stmt->fetch();
		$userid 	= $DataRows['id'];
		$sendmail= $searchEmail;
		$usertype="registerpage";
		$sendmail= $searchEmail;
	}else{
		echo "<script> alert('email does not exist'); window.location='login.php';</script>";
	}
} else {
	echo "<script>window.location='login.php';</script>";
}
if (isset($sendmail)) {
	require_once "composer/vendor/autoload.php";
									$template_file = "./email_templates/template_forgot_password.php";
									$email_message = file_get_contents($template_file);
									// create a list of the variables to be swapped in the html template
									$swap_var = array(
									"{SITE_ADDR}" => "https://localhost/freelancing_system",
									"{EMAIL_LOGO}" => "https://localhost/freelancing_system/images/logo4.jpg",
									"{EMAIL_TITLE}" => "Forgot password!",
									"{CUSTOM_URL}" => "http://localhost/freelancing_system/change_password.php?userID=".$userid."&&usertype=".$usertype,
									"{CUSTOM_IMG}" => "https://localhost/freelancing_system/images/logo4.png",
									"{TO_NAME}" => $sendmail,
									"{TO_EMAIL}" => $sendmail
									);

									
									$mail = new PHPMailer;
									$mail->isSMTP();
									$mail->SMTPDebug = 2;
									$mail->Host = 'smtp.hostinger.com';
									$mail->Port = 587;
									$mail->SMTPAuth = true;
									$mail->Username = 'didi@didiscuisine.com';
									$mail->Password = 'KachisiCho1';
									$mail->setFrom('didi@didiscuisine.com', "Stretch");
									$mail->addReplyTo('didi@didiscuisine.com', "Stretch");
									$mail->addAddress($sendmail, $sendmail);
									$mail->Subject = "Welcome To Stretch";
									// search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
										foreach (array_keys($swap_var) as $key){
											if (strlen($key) > 2 && trim($swap_var[$key]) != '')
												$email_message = str_replace($key, $swap_var[$key], $email_message);
										}
									$mail->msgHTML($email_message, __DIR__);

									$mail->IsHTML(true);
									;
									//$mail->addAttachment('test.txt');
									if (!$mail->send()) {
									$message = 'Sorry! - An error occured';
									$type = "error";
									} else {
									$message = 'Verification message have been sent to your email';
									$type = "info";
									}

									echo "<script> alert('".$message."'); window.location='login.php';</script>";
}
?>