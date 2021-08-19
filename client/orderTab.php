<div class="mycontainhide orderstab" id="orders">
	<!-- <p> OOPS!There are no orders yet..</p> -->
	<div class="container onCompleted">
		<div class="ordertab1 py-2 px-4 text-center" style="border:1px solid grey; width: 99%" onclick="orderTabs(event, 'ongoingOrder')" id="ongoingTab">
			ongoing
		</div>

		<div class="ordertab1 py-2 px-4 text-center" style="border:1px solid grey;width: 99%;" onclick="orderTabs(event, 'completedOrder')">
			completed
		</div>
	</div>


	<div>
		<div class="ordercontainhide py-4 px-3" id="ongoingOrder">
			<table class="table table-striped mt-4 text-center">


				<?php
				if (!check_ongoing_jobsTable_client($UserId)) {
					echo "OOPS!! You have no ongoing jobs. Go ahead and apply for jobs ;)";
				} else {
					global $ConnectingDB;
					$sqlongoing = "SELECT *,ongoing_completed_work.id as workid FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id AND ongoing_completed_work.gig_status='ONGOING'  AND clientsgigsform.clients_reg_id='$UserId' ORDER BY ongoing_completed_work.id desc";
					$stmtongoing = $ConnectingDB->query($sqlongoing);
				?>
					<tr>
						<th>Order By:</th>
						<th>job</th>
						<th>Date gotten</th>
						<th>Due Date</th>
						<th>status</th>

					</tr>
					<?php foreach ($stmtongoing as $key => $DataRows) : ?>
						<tr>
							<td><?php echo $DataRows['CompanyName']; ?></td>
							<td><?php echo $DataRows['WorkCategory']; ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['date'])); ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['DueDate'])); ?></td>
							<td class="jobstatus notcompleted"><?php echo $DataRows['gig_status']; ?></td>

						</tr>
					<?php endforeach; ?>
				<?php } ?>
			</table>
		</div>

		<div class="ordercontainhide mycontainhide py-4 px-3" id="completedOrder">
			<p class="pr-3">This is your completed Order</p>
			<table class="table table-striped mt-4">
				<?php
				if (!check_notOngoing_jobsTable_client($UserId)) {
					echo "OOPS!! You have no completed jobs. Go ahead and apply for jobs ;)";
				} else {
					global $ConnectingDB;
					$sql = "SELECT *,ongoing_completed_work.id as workid FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND clientsgigsform.clients_reg_id='$UserId' AND ongoing_completed_work.gig_status!='ONGOING' ORDER BY ongoing_completed_work.id desc";
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
						<tr>
							<td><?php echo $DataRows['CompanyName']; ?></td>
							<td><?php echo $DataRows['WorkCategory']; ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['date'])); ?></td>
							<td><?php echo date('d M, Y', strtotime($DataRows['DueDate'])); ?></td>
							<td class="jobstatus notcompleted"><?php echo $DataRows['gig_status']; ?></td>
							<?php if ($DataRows['gig_status'] === "COMPLETED") : ?>
								<td><span>Paid</span></td>
							<?php else : ?>
								<td><a class="btn btn-info" href="client/review.php?workid=<?php echo $DataRows['workid']; ?>"><i class="fa fa-eye"></i> View</a></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
			</table>
		</div>
	</div>
</div>