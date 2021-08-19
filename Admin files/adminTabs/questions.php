<script type="text/javascript">
	// deleteQuestion function
	function deleteQuestion(argument) {
		$.ajax({
			type: "POST",
			url: "./admin-functions.php",
			dataType: "json",
			data:{
		        deleteQuestion: argument,
		    },
			success: function (data) {
				Lobibox.notify(data.type, {
					position: 'top right',
					title: 'Hello',
					msg: data.message
				});
				// get updated question table
				getQuestions()
				// get updated question table
			},
			error: function (result) {
				alert("Error");
			}
		})
	}
</script>

<div class="container mycontainhide " id="Questions">
	
</div>

<div class="container mycontainhide " id="AddQuestion">
	<h3>Add Questions:</h3>
	<hr>
		<form action="adminDashboard.php" method="POST">
				<div class="row">
					<div class="col-md-4">
						<p>Enter Category name:</p>
						<div class="input-group">            
								<textarea class="form-control mb-2" name="question" placeholder="Enter your question" required=""></textarea>
						       <!-- <input type="text" class="form-control" name="question" placeholder="Enter your question" required="">     -->
						</div>
					</div>

					<div class="col-md-4">
						<p>Answer:</p>
						
						<div class="input-group">
							      <select class="form-control" name="optionAnswer" required="">
							      
							       <option> select correct option</option>
							       <option> option1</option>
							       <option> option2</option>
							       <option> option3</option>
							       <option> option4</option>
							      </select>            
							  </div>
					</div>

					<div class="col-md-4">
						<p>Category:</p>
						<div class="input-group">
							      <select class="form-control" name="workCategory" required="">
							       <option>choose category </option>
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
				<div class="row mt-4">
					<div class="col-md-3">
						<p>Enter option 1:</p>
						<div class="input-group">            
						       <input type="text" class="form-control" name="option1" placeholder="Enter your question" required="">    
						</div>
					</div>

					<div class="col-md-3">
						<p>Enter option 2:</p>
						<div class="input-group">            
						       <input type="text" class="form-control" name="option2" placeholder="Enter your question" required="">    
						</div>
					</div>

					<div class="col-md-3">
						<p>Enter option 3:</p>
						<div class="input-group">            
						       <input type="text" class="form-control" name="option3" placeholder="Enter your question" required="">    
						</div>
					</div>

					<div class="col-md-3">
						<p>Enter option 4:</p>
						<div class="input-group">            
						       <input type="text" class="form-control" name="option4" placeholder="Enter your question" required="">    
						</div>
					</div>
				</div>
				<input type="submit" name="AddQuestion" value="Add Question" class="btn btn-primary mt-4" style="width: 100%;">
			</form>
	</div>