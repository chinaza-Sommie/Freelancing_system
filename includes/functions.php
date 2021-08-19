<?php
function Redirect_to($New_Location)
{
	header("Location:" . $New_Location);
	exit;
}
?>

<?php
function checkUserNameExistsorNot($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT freelancer_reg_id FROM freelancergigform WHERE freelancer_reg_id =:postidformurl";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':postidformurl', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		// return $stmt->rowcount();
		return true;
	} else {
		return false;
	}
}


function checkClientUserNameExistsorNot($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT clients_reg_id,active FROM clientsgigsform WHERE clients_reg_id =:clientsId AND active='OFF'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':clientsId', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		// return $stmt->rowcount();
		return true;
	} else {
		return false;
	}
}

function Login_Freelancer_Attempt($Email)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer WHERE email=:emaiL LIMIT 1";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':emaiL', $Email);
	// $stmt->bindValue(':passworD',$Password);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result == 1) {
		return $found_Account = $stmt->fetch();
	} else {
		return null;
	}
}

function Login_Client_Attempt($Email)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerpage WHERE email=:emaiL LIMIT 1";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':emaiL', $Email);
	//$stmt->bindValue(':passworD',$Password);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result == 1) {
		return $found_Account = $stmt->fetch();
	} else {
		return null;
	}
}

function Login_Admin_Attempt($Email)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM admins_registration WHERE email=:emaiL LIMIT 1";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':emaiL', $Email);
	//$stmt->bindValue(':passworD',$Password);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result == 1) {
		return $found_Account = $stmt->fetch();
	} else {
		return null;
	}
}

// this code below checks the number of proposals a gig has
function proposalnumber($ClientGigid)
{
	global $ConnectingDB;
	$sql = "SELECT client_job_id FROM freelancers_proposals WHERE client_job_id = :clientsGigId";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':clientsGigId', $ClientGigid);
	$stmt->execute();
	$number = $stmt->rowcount();
	echo $number;
}

function availablejobs_forfreelancer($ExistingCategory)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM clientsgigsform WHERE WorkCategory=:workcategorY";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':workcategorY', $ExistingCategory);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		return true;
	} else {
		return false;
	}
}

// the code below is used to check if a clients id has occured in the application form table
function freelancer_idCheck($freelanceId, $jobid)
{
	global $ConnectingDB;
	$sql = "SELECT freelancer_id,client_job_id FROM freelancers_proposals WHERE freelancer_id =:Freelanceid AND client_job_id = :gigJobId LIMIT 1";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':Freelanceid', $freelanceId);
	$stmt->bindValue(':gigJobId', $jobid);
	$stmt->execute();
	$numberMe = $stmt->rowcount();
	if (($stmt->rowcount()) == 1) {
		// return $stmt->rowcount();
		return true;
	} else {
		return false;
	}
}

function check_ongoing_jobsTable($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT freelancer_id FROM ongoing_completed_work WHERE freelancer_id=:Freelancerid AND gig_status='ONGOING'";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':Freelancerid', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
		// echo $stmt->rowcount();
	} else {
		return false;
	}
}
function check_notOngoing_jobsTable($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT freelancer_id FROM ongoing_completed_work WHERE freelancer_id=:Freelancerid AND gig_status!='ONGOING'";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':Freelancerid', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
		// echo $stmt->rowcount();
	} else {
		return false;
	}
}

function check_requested_jobsTable($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT freelancer_id FROM ongoing_completed_work WHERE freelancer_id=:Freelancerid AND gig_status='REQUESTED'";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':Freelancerid', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
		// echo $stmt->rowcount();
	} else {
		return false;
	}
}
function check_ongoing_jobsTable_client($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND clientsgigsform.clients_reg_id=:ClientId AND ongoing_completed_work.gig_status='ONGOING'";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':ClientId', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
		// echo $stmt->rowcount();
	} else {
		return false;
	}
}
function check_notOngoing_jobsTable_client($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND clientsgigsform.clients_reg_id=:ClientId AND ongoing_completed_work.gig_status!='ONGOING'";

	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':ClientId', $UserId);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
		// echo $stmt->rowcount();
	} else {
		return false;
	}
}

// this checks if a freelancer has taken test or not
function check_verification_stat($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer WHERE  id=:UserId AND test_status='0' AND test_result_status='0'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':UserId', $UserId);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		return true;
	} else {
		return false;
	}
}

// checks if the freelancer is verified or not
function check_test_result($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer WHERE id=:UserId AND test_result_status='1'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':UserId', $UserId);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		return true;
	} else {
		return false;
	}
}

function jobLimit($UserId)
{
	global $ConnectingDB;
	$sql = "SELECT * FROM ongoing_completed_work WHERE freelancer_id=:Freelancerid AND gig_status!='COMPLETED'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':Freelancerid', $UserId);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result == 3) {
		return true;
	} else {
		return false;
	}
}

// --------------------------

function diplayAvailbleFlncrJob()
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer, ongoing_completed_work, freelancergigform WHERE registerfreelancer.id=ongoing_completed_work.freelancer_id AND ongoing_completed_work.gig_status!='COMPLETED' AND freelancergigform.freelancer_reg_id=ongoing_completed_work.freelancer_id";
	$sqlverify = "SELECT * FROM registerfreelancer, freelancergigform WHERE registerfreelancer.id=freelancergigform.freelancer_reg_id AND registerfreelancer.test_result_status='1'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmtverify = $ConnectingDB->prepare($sqlverify);
	$stmt->execute();
	$stmtverify->execute();
	$Result = $stmt->rowcount();
	$Resultverify = $stmtverify->rowcount();
	if (($Resultverify >= 1) || ($Result < 3)) {
		return true;
	} else {
		return false;
	}
}


// -------------------------
// ADMIN FUNCTIONS
function Total_freelancer()
{
	global $ConnectingDB;
	$sql = "SELECT id FROM registerfreelancer";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		echo $Result;
	} else {
		echo '0';
	}
}

function Total_freelancer_display()
{
	global $ConnectingDB;
	$sql = "SELECT * FROM registerfreelancer";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
	} else {
		return false;
	}
}

function Total_clients()
{
	global $ConnectingDB;
	$sql = "SELECT id FROM registerpage";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		echo $Result;
	} else {
		echo '0';
	}
}

function Total_work()
{
	global $ConnectingDB;
	$sql = "SELECT id FROM freelancergigform";
	$sqlclient = "SELECT id FROM clientsgigsform";
	$stmt = $ConnectingDB->prepare($sql);
	$stmtclient = $ConnectingDB->prepare($sqlclient);
	$stmt->execute();
	$stmtclient->execute();
	$FreelancerResult = $stmt->rowcount();
	$ClientResult = $stmtclient->rowcount();
	$Result = $FreelancerResult + $ClientResult;
	if ($Result >= 1) {
		echo $Result;
	} else {
		echo '0';
	}
}

function total_completed_work()
{
	global $ConnectingDB;
	$sql = "SELECT id FROM ongoing_completed_work WHERE gig_status='COMPLETED'";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->execute();
	$Result = $stmt->rowcount();
	if ($Result >= 1) {
		echo $Result;
	} else {
		echo '0';
	}
}

function checkCategory($categoryName)
{
	global $ConnectingDB;
	$sql = "SELECT ctgy_name FROM categories WHERE ctgy_name =:categoryName";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':categoryName', $categoryName);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
	} else {
		return false;
	}
}

function checkSkill($skillName)
{
	global $ConnectingDB;
	$sql = "SELECT skill_name FROM skills WHERE skill_name =:skillName";
	$stmt = $ConnectingDB->prepare($sql);
	$stmt->bindValue(':skillName', $skillName);
	$stmt->execute();
	if (($stmt->rowcount()) >= 1) {
		return true;
	} else {
		return false;
	}
}
?>