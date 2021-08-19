<?php
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");


$gigId = $_GET['gigId'];



?>

<!DOCTYPE html>
<html>

<head>
	<title>proposal views</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.css">
	<!-- <link rel="stylesheet" type="text/css" href="css-files/sellerdasboard.css"> -->
	<link rel="stylesheet" type="text/css" href="css-files/companydashboard.css">
	<link rel="stylesheet" type="text/css" href="css-files/proposalInformation.css">

</head>

<body>

	<div class="container prop-table mt-4" id="proposaldetails">

		<div class="text-center">
			<table class="table">
				<tr class="tableheader">
					<th>Name of Freelancer</th>
					<th> proposal details</th>
					<th>Stack</th>
					<th> date/time</th>
					<th>choose a Freelancer</th>
				</tr>

				<?php
				if (!isset($gigId)) {
					$_SESSION["ErrorMessage"] = "could not get page";
					Redirect_to('index.php');
				} else {
					global $ConnectingDB;

					$sql = "SELECT * FROM freelancers_proposals WHERE client_job_id ='" . $gigId . "'";

					$stmtfreelancergigs = $ConnectingDB->query($sql);
					while ($DataRows = $stmtfreelancergigs->fetch()) {
						$ProposalId = $DataRows['id'];
						$freelancerName = $DataRows['freelancerName'];
						$proposaldetails = $DataRows['Proposal'];
						$freelancerStack = $DataRows['freelancerStack'];
						$freelancer_id = $DataRows['freelancer_id'];
						$datesubmitted = $DataRows['date'];
				?>
						<tr>
							<td><?= $freelancerName ?></td>
							<td class="proposalcolumn">
								<?= $proposaldetails; ?>
							</td>
							<td><?= $freelancerStack; ?></td>
							<td><?= $datesubmitted; ?></td>
							<td><a href="proposalselection.php?InitialpropId=<?= $gigId ?>&propId=<?= $ProposalId ?>" class="checkboximg">SELECT</a></td>

						</tr>
				<?php
					}
				}
				?>
			</table>
		</div>
	</div>


</body>

</html>