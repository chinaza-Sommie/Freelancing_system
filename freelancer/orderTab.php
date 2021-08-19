<div class="mycontainhide orderstab" id="orders">
	<!-- <p> OOPS!There are no orders yet..</p> -->
	<div class="container onCompleted">
		<div class="ordertab1 py-2 px-4 text-center" style="border:1px solid grey; width: 99%" onclick="orderTabs(event, 'requestOrder')" id="requestsTab">
			Work Request
		</div>
		<div class="ordertab1 py-2 px-4 text-center" style="border:1px solid grey; width: 99%" onclick="orderTabs(event, 'ongoingOrder')" id="ongoingTab">
			ongoing
		</div>

		<div class="ordertab1 py-2 px-4 text-center" style="border:1px solid grey;width: 99%;" onclick="orderTabs(event, 'completedOrder')">
			completed
		</div>
	</div>

	<div>
		<div class="ordercontainhide py-4 px-3" id="requestOrder">
			<table class="table table-striped mt-4 text-center">


				<?php
				if (!check_requested_jobsTable($UserId)) {
					echo "<div class='text-center'>
											<div class='alert alert-warning alert-dismissible fade show'>
	    									<strong>Warning!</strong> OOPS!! You have no job requests. Go ahead and apply for jobs ;)
											</div>
										</div>";
				} else {
					global $ConnectingDB;
					$sql = "SELECT * FROM `freelancergigform`, `registerpage`, `ongoing_completed_work` WHERE ongoing_completed_work.freelancer_id='$UserId' AND ongoing_completed_work.gig_status='REQUESTED' AND freelancergigform.freelancer_reg_id='$UserId' AND ongoing_completed_work.client_id=registerpage.id ORDER BY ongoing_completed_work.id desc";
					$stmtrequests = $ConnectingDB->query($sql);
					while ($DataRows = $stmtrequests->fetch()) {
						$requestId 				= $DataRows['id'];
						$clientsFirstname		= $DataRows['firstname'];
						$clientsLastname 		= $DataRows['lastname'];
						$workType 				= $DataRows['workType'];
						$date 					= $DataRows['date'];

				?>
						<tr>
							<th>Order By:</th>
							<th>job:</th>
							<th>Date requested:</th>

							<th>Action</th>

						</tr>

						<tr>
							<td><?php echo $clientsFirstname . " " . $requestId . " " . $clientsLastname; ?></td>
							<td><?php echo $workType; ?></td>
							<td><?php echo date('d M, Y', strtotime($date)); ?></td>
							<td><a class="btn btn-success" href="freelancer/accept-rejectwork.php?acceptWork=<?php echo $requestId; ?>"> Accept </a> <a class="btn btn-warning" href="freelancer/accept-rejectwork.php?deleteWork=<?php echo $requestId; ?>">Decline</a></td>
						</tr>
				<?php }
				} ?>
			</table>
		</div>


		<!-- ONGING TAB STARTS HERE -->
		<div class="ordercontainhide py-4 px-3" id="ongoingOrder">
			<table class="table table-striped mt-4 text-center">


				<?php
				$pending_earnings = 0;
				if (!check_ongoing_jobsTable($UserId)) {
					echo "OOPS!! You have no ongoing jobs. Go ahead and apply for jobs ;)";
				} else {
					global $ConnectingDB;
					$sql = "SELECT *,ongoing_completed_work.id as workID FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND ongoing_completed_work.freelancer_id='$UserId' AND ongoing_completed_work.gig_status='ONGOING' ORDER BY ongoing_completed_work.id desc";
					$stmtongoing = $ConnectingDB->query($sql);


				?>
					<tr>
						<th>Order By:</th>
						<th>job</th>
						<th>Date gotten</th>
						<th>Due Date</th>
						<th>status</th>
						<th>Submit/Complete work</th>

					</tr>
					<?php foreach ($stmtongoing as $key => $DataRows) : ?>
						<?php $pending_earnings = $pending_earnings + $DataRows['AmountforWork']; ?>
						<tr>
							<td><?php echo $DataRows['CompanyName']; ?></td>
							<td><?php echo $DataRows['WorkCategory']; ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['date'])); ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['DueDate'])); ?></td>
							<td class="jobstatus notcompleted"><?php echo $DataRows['gig_status']; ?></td>
							<td><a class="btn btn-primary" href="freelancer/edit-work.php?submitWork=<?php echo $DataRows['workID']; ?>"> Submit </a></td>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
			</table>
		</div>

		<div class="ordercontainhide mycontainhide py-4 px-3" id="completedOrder">
			<table class="table table-striped mt-4">
				<?php
				$earnings = 0;
				if (!check_notOngoing_jobsTable($UserId)) {
					echo "<div class='text-center'>
											<div class='alert alert-warning alert-dismissible fade show'>
	    									<strong>Warning!</strong> OOPS!! You have no completed jobs. Go ahead and apply for jobs ;)
											</div>
										</div>";
				} else {
					global $ConnectingDB;
					$sql = "SELECT *,ongoing_completed_work.id as workid FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND ongoing_completed_work.freelancer_id='$UserId' AND ongoing_completed_work.gig_status!='ONGOING' ORDER BY ongoing_completed_work.id desc";
					$stmtongoing = $ConnectingDB->query($sql);

				?>
					<tr>
						<th>Order By:</th>
						<th>job</th>
						<th>Date gotten</th>
						<th>Due Date</th>
						<th>status</th>
						<th>Action</th>

					</tr>

					<?php foreach ($stmtongoing as $key => $DataRows) : ?>

						<?php $earnings = $earnings + $DataRows['AmountforWork']; ?>
						<tr>
							<td><?php echo $DataRows['CompanyName']; ?></td>
							<td><?php echo $DataRows['WorkCategory']; ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['date'])); ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['DueDate'])); ?></td>
							<td class="jobstatus notcompleted"><?php echo $DataRows['gig_status']; ?></td>
							<?php if ($DataRows['gig_status'] === "COMPLETED") : ?>
								<td><span class="text-success">Paid</span></td>
							<?php else : ?>
								<td><a href="freelancer/edit-work.php?submitWork=<?php echo $DataRows['workid'] ?>" class="btn btn-info">Edit</a></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
			</table>
		</div>
	</div>
</div>