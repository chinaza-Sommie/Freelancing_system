<?php
include '../includes/DB.php';
if (isset($_POST['deleteQuestion'])) {
	deleteQuestion($_POST['deleteQuestion']);
}
if (isset($_POST['deleteSkill'])) {
	deleteSkill($_POST['deleteSkill']);
}
if (isset($_POST['deleteCategory'])) {
	deleteCategory($_POST['deleteCategory']);
}
if (isset($_POST['getQuestion'])) {
	getQuestion();
}


function deleteSkill($skill_id)
{
	global $ConnectingDB;
	 $query=$ConnectingDB->query("DELETE FROM verification_questions WHERE id=$ques_id");
	// $query=true;
	 if ($query) {
	 	$responses = array(
	 		'message' => 'Skill was deleted successfully',
	 		'type' => 'success',
	 		 );
	 } else {
	 	$responses = array(
	 		'message' => 'An error occured',
	 		'type' => 'error',
	 		 );
	 }

	 echo json_encode($responses);
}
function deleteCategory($ctgy_id)
{
	global $ConnectingDB;
	 $query=$ConnectingDB->query("DELETE FROM verification_questions WHERE id=$ques_id");
	// $query=true;
	 if ($query) {
	 	$responses = array(
	 		'message' => 'Category was deleted successfully',
	 		'type' => 'success',
	 		 );
	 } else {
	 	$responses = array(
	 		'message' => 'An error occured',
	 		'type' => 'error',
	 		 );
	 }

	 echo json_encode($responses);
}
function deleteQuestion($ques_id)
{
	global $ConnectingDB;
	 $query=$ConnectingDB->query("DELETE FROM verification_questions WHERE id=$ques_id");
	// $query=true;
	 if ($query) {
	 	$responses = array(
	 		'message' => 'Question was deleted successfully',
	 		'type' => 'success',
	 		 );
	 } else {
	 	$responses = array(
	 		'message' => 'An error occured',
	 		'type' => 'error',
	 		 );
	 }

	 echo json_encode($responses);
}
function getQuestion()
{
	global $ConnectingDB;
	 // $query=$ConnectingDB->query("DELETE FROM verification_questions WHERE id=$ques_id)";
	$sql = "SELECT * FROM `verification_questions`, `categories` WHERE verification_questions.que_category=categories.ctgy_id";
	 $query = $ConnectingDB->query($sql);
	 $responses = array();
	 $count=0;
	 foreach ($query as $DataRows) {
	 	$count=$count+1;
		$que_answer	= $DataRows['que_answer'];
	 	$DataRows+=['SN'=>$count,'ques_answer'=>$DataRows[$que_answer],'date'=>date("d M, Y", strtotime($DataRows['time_created']))];
	 	$responses[]=$DataRows;
	 }
	echo json_encode($responses);
}
?>