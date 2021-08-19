
	<?php
		require_once("../includes/DB.php");
		require_once("../includes/sessions.php");
		require_once("../includes/functions.php");
	?>

	

<div class="container mycontainhide " id="Skills">
					<form action="adminDashboard.php" method="POST">
						<div class="row">
							<div class="col-md-6">
								<p>Enter Category name:</p>
								<div class="input-group">            
						        	<input type="text" class="form-control" name="skillName" placeholder="eg. Html">    
								</div>
							</div>
							<div class="col-md-6">
								<p>Category:</p>
								<div class="input-group">
							       	<select class="form-control" name="workCategory">
							         <!-- <option>choose </option> -->
							         <?php 
										global $ConnectingDB;
										$sql = "SELECT * FROM categories";
										$stmtgigs = $ConnectingDB->query($sql);
										while ($DataRows = $stmtgigs->fetch()){
										$CategoryId 			= $DataRows['ctgy_id'];
										$categoryName	 		= $DataRows['ctgy_name'];
									?>
							         <option value="<?php echo $CategoryId; ?>"><?php echo $categoryName;?></option>
							         <?php }?>
							        </select>            
							    </div>
							</div>
						</div>
						<input type="submit" name="AddSkills" value="Add Skills" class="mt-3 btn btn-primary">
					</form>
					<hr>

					<table class="table table-striped table-dark text-center">
						<form action="adminDashboard.php" method="POST">
					    <thead>
					        <tr>
					            <th>S/N</th>
					            <th>Skill Name</th>
					            <th>Associated Category</th>
					            <th>Date Added</th>
					            <th>------</th>
					        </tr>
					    </thead>
					    <tbody>

					    	<?php 
								global $ConnectingDB;
								$sql = "SELECT * FROM skills, categories WHERE skills.skill_category=categories.ctgy_id";
								$SN++;
								$stmtgigs = $ConnectingDB->query($sql);
								while ($DataRows = $stmtgigs->fetch()){
								$SkillId 				= $DataRows['skill_id'];
								$skillName	 			= $DataRows['skill_name'];
								$skillCategory	 		= $DataRows['skill_category'];
								$time_created	 		= $DataRows['time_created'];
								$categoryName	 		= $DataRows['ctgy_name'];
							?>
							
					        <tr>
					            <td><?php echo $SN;?></td>
					            <td><?php echo $skillName; ?></td>
					         	<td> <?php echo $categoryName; ?></td>
					         	<td><?php echo date("d M, Y", strtotime($time_created));?></td>
					            <!-- <td><button class="btn-danger" id="deleteCategory"> Drop</button></td> -->
					            <td><a href="deleteCategory-Skills.php?SkillId=<?=$SkillId;?>" class="btn btn-danger">Drop</a></td>
					        </tr>  
					        <?php $SN++; } ?> 
					         
					    </tbody>
						</form>
					</table>
				</div>

	<script type="text/javascript" src="../../popper/docs/js/jquery.min.js"></script>
	<script type="text/javascript" src="../../popper/docs/js/main.js"></script>
	<script type="text/javascript" src="../../bootstrap/dist/js/bootstrap.js"></script>