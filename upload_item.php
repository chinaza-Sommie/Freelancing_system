<?php
session_start();
require '../resources/db_connect.php';
if(isset($_POST["image"]))
{
	$data = $_POST["image"];


	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);



	$data = base64_decode($image_array_2[1]);
$imageName = time().'.png';
$imageName = "product-$imageName";
file_put_contents('../../img/products/'.$imageName, $data);

$_SESSION['img0']=$imageName;
	$_SESSION['counter']= $_SESSION['counter'] +1;
}
 ?>
