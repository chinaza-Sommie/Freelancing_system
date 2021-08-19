<?php
require_once("includes/DB.php");
require_once("includes/sessions.php");
require_once("includes/functions.php");

?>

<!-- <div class="row"> -->

<?php

global $ConnectingDB;
// $Search = $_GET['search-text'];
$sql = "SELECT * FROM freelancergigform 
		WHERE freelancecategory LIKE :search 
		OR Proposal LIKE :search OR workType LIKE :search ORDER BY id desc";
$stmtfreelancergigs = $ConnectingDB->prepare($sql);
$stmtfreelancergigs->bindValue(':search', '%' . $_POST['name'] . '%');
$stmtfreelancergigs->execute();
while ($DataRows = $stmtfreelancergigs->fetch()) {
	$detail_work_id   	= $DataRows['id'];
	$workType   	= $DataRows['workType'];
	$GigProposal 		= $DataRows['Proposal'];
	$GigPictureOne		= $DataRows['pictureOne'];
	$GigPictureTwo 		= $DataRows['pictureTwo'];
	$GigAmount 			= $DataRows['amount'];
	$freelancecategory 	= $DataRows['freelancecategory'];

?>
	<div class="col-md-4 mb-4">
		<div class="availbletab-item">
			<div class="availabletabimage">
				<img src="images/freelancer_workImages/<?php echo $GigPictureOne; ?>">
				<div>
					<h6 class="freelancername"><?php echo $workType; ?></h6>
				</div>
			</div>

			<p class="worktitle">category:<span><?php echo $freelancecategory; ?></span></p>
			<p class="priceofwork">Amount: N <span class="priceofworkmoney"><?php echo number_format($GigAmount); ?></span></p>

			<div class="availbletab-details mb-3">
				<p>
					<?php
					if (strlen($GigProposal) > 20) {
						$GigProposal = substr($GigProposal, 0, 20) . "...";
					}
					?>
					<?php echo $GigProposal; ?>
				</p>

			</div>
			<a href="work_detail_byFreelancer.php?detail_of_work=<?php echo $DataRows['id']; ?>">
				<div class="available-apply text-center"> View </div>
			</a>
		</div>
	</div>
<?php } ?>
<!-- </div>				 -->