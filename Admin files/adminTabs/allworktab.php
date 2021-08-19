


<div class="container mycontainhide" id="All_work">
	<nav class="nav nav-tabs">
	    <a href="#" class="nav-item nav-link ordertabs active" onclick="orderTabs(event, 'every-work')">All work</a>
	    <a href="#" class="nav-item nav-link ordertabs" onclick="orderTabs(event, 'ongoing-work')">Ongoing</a>
	    <a href="#" class="nav-item nav-link ordertabs" onclick="orderTabs(event, 'work-under-review')">Under Review</a>
	    <a href="#" class="nav-item nav-link ordertabs" onclick="orderTabs(event, 'completed')"> Completed</a>

	</nav>
	

	<div >
		<div class="ordercontainhide container" id="every-work">
		   <p>these are all the available works</p>	
		   <hr>

		   <table class="table table-striped table-dark text-center">
			    <thead>
			        <tr>
			            <th>S/N</th>
			            <th>Name</th>
			            <th>Uploaded by:</th>
			            <th>Date uploaded</th>
			            <th>Due Date</th>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
			            <td>1</td>
			            <td>Clark</td>
			            <td>Kent</td>
			            <td>clarkkent@mail.com</td>
			            <td>clarkkent@mail.com</td>
			        </tr>         
			    </tbody>
			</table>
		</div>

		<div class="ordercontainhide mycontainhide container" id="ongoing-work">
		    <h4 class="mt-4">Ongoing Works</h4>
		    <hr>

		    <table class="table table-striped table-dark text-center">
			    <thead>
			    	<?php 
							global $ConnectingDB;
							$SN = 1;
							$ongoing_sql = "SELECT * FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND gig_status='ONGOING' ORDER BY ongoing_completed_work.id desc";
							$stmtongoing = $ConnectingDB->query($ongoing_sql);
							if(($stmtongoing->rowcount())>=1){
								while ($DataRows = $stmtongoing->fetch()){
									$ClintId 				= $DataRows['id'];
									$freelancerName 		= $DataRows['freelancer_name'];
									$DueDate 		= $DataRows['DueDate'];	
									$JobTitle 		= $DataRows['JobTitle'];
									$workCategory 		= $DataRows['WorkCategory'];
									$CompanyName 		= $DataRows['CompanyName'];
					?>
			        <tr>
			            <th>S/N</th>
			            <th>Category</th>
			            <th>Work Title</th>
			            <th>Uploaded by:</th>
			            <th>Outsourced to:</th>
			            <th>Date uploaded</th>
			            <th>Due Date</th>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
			            <td><?php echo $SN; ?></td>
			            <td><?php echo $workCategory;?></td>
			            <td><?php echo $JobTitle;?></td>
			            <td><?php echo $CompanyName; ?></td>
			            <td><?php echo $freelancerName;?></td>
			            <td><?php echo date('d M, Y',strtotime($DataRows['date']));?></td>
			            <td><?php echo $DueDate;?></td>
			        </tr>         
			    </tbody>
			    <?php }
			    	$SN++;
					}
			    	else{
							echo "OOPS!! You have no ongoing jobs. Go ahead and apply for jobs ;)";
						}
			    ?>
			</table>
		</div>

		<div class="ordercontainhide mycontainhide container" id="work-under-review">
		    <h4 class="mt-4">this is every work under review</h4>
		    <hr>

		    <table class="table table-striped table-dark text-center">
			    <thead>
			    	<?php 
							global $ConnectingDB;
							$SN = 1;
							$ongoing_sql = "SELECT * FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND gig_status='UNDER REVIEW' ORDER BY ongoing_completed_work.id desc";
							$stmtongoing = $ConnectingDB->query($ongoing_sql);
							if(($stmtongoing->rowcount())>=1){
								while ($DataRows = $stmtongoing->fetch()){
									$ClintId 				= $DataRows['id'];
									$freelancerName 		= $DataRows['freelancer_name'];
									$DueDate 		= $DataRows['DueDate'];	
									$JobTitle 		= $DataRows['JobTitle'];
									$workCategory 		= $DataRows['WorkCategory'];
									$CompanyName 		= $DataRows['CompanyName'];
					?>
			        <tr>
			            <th>S/N</th>
			            <th>Category</th>
			            <th>Work Title</th>
			            <th>Uploaded by:</th>
			            <th>Outsourced to:</th>
			            <th>Date uploaded</th>
			            <th>Due Date</th>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
			            <td><?php echo $SN; ?></td>
			            <td><?php echo $workCategory;?></td>
			            <td><?php echo $JobTitle;?></td>
			            <td><?php echo $CompanyName; ?></td>
			            <td><?php echo $freelancerName;?></td>
			            <td><?php echo date('d M, Y',strtotime($DataRows['date']));?></td>
			            <td><?php echo $DueDate;?></td>
			        </tr>         
			    </tbody>
			    <?php }
			    	$SN++;
					}
			    	else{
							echo "OOPS!! No work under review yet :(";
						}
			    ?>
			</table>	
		</div>

		<div class="ordercontainhide mycontainhide container" id="completed">
		    <h4 class="mt-4">this is completed work</h4>
		    <hr>

		    <table class="table table-striped table-dark text-center">
			    <thead>
			    	<?php 
							global $ConnectingDB;
							$SN = 1;
							$ongoing_sql = "SELECT * FROM `ongoing_completed_work`,`clientsgigsform` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id  AND gig_status='COMPLETED' ORDER BY ongoing_completed_work.id desc";
							$stmtongoing = $ConnectingDB->query($ongoing_sql);
							if(($stmtongoing->rowcount())>=1){
								while ($DataRows = $stmtongoing->fetch()){
									$ClintId 				= $DataRows['id'];
									$freelancerName 		= $DataRows['freelancer_name'];
									$DueDate 		= $DataRows['DueDate'];	
									$JobTitle 		= $DataRows['JobTitle'];
									$workCategory 		= $DataRows['WorkCategory'];
									$CompanyName 		= $DataRows['CompanyName'];
					?>
			        <tr>
			            <th>S/N</th>
			            <th>Category</th>
			            <th>Work Title</th>
			            <th>Uploaded by:</th>
			            <th>Outsourced to:</th>
			            <th>Date uploaded</th>
			            <th>Due Date</th>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
			            <td><?php echo $SN; ?></td>
			            <td><?php echo $workCategory;?></td>
			            <td><?php echo $JobTitle;?></td>
			            <td><?php echo $CompanyName; ?></td>
			            <td><?php echo $freelancerName;?></td>
			            <td><?php echo date('d M, Y',strtotime($DataRows['date']));?></td>
			            <td><?php echo $DueDate;?></td>
			        </tr>         
			    </tbody>
			    <?php }
			    	$SN++;
					}
			    	else{
							echo "OOPS!! No Completed work yet :(";
						}
			    ?>
			</table>		
		</div>
	</div>
	
</div>