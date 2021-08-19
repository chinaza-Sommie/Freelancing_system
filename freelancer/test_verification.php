
<style>
	.t{/*
       background-color: black;*/
       position: relative;
       font-size: 40px;
       text-align: center;
       font-family: 'digital-7';
       position: relative;
       display: block;
       font-style: normal;
       font-weight: bolder;
       -webkit-font-smoothing: antialiased;
       -moz-osx-font-smoothing: grayscale;
	   color: #000066;
    }
</style>
<div class="mycontainhide" id="verification">
	<?php
		if(check_verification_stat($UserId)){
	?>
		<div>
		<h4> Account verification</h4>
		<hr>
		<p class="text-center">The following questions are test questions based on your stack. Finish the questions before the timer runs out.</p>
		<p } class="text-center"><i>click on the start button below to begin your verification test.</i></p>

		<div class="text-center">
			<div class="btn btn-primary" onclick="startTest()"> Start Test</div>
		</div>
	</div>
	<?php
		}elseif(check_test_result($UserId)) {
	?>
				<div class='text-center'>
					<div class='alert alert-success alert-dismissible fade show'>
	    			<strong>Congrats!</strong> You are already verified
					</div>
				</div>
	<?php }else{ 
		$takenExamTime=isset($_SESSION["takenExamTime"]) ? $_SESSION["takenExamTime"]:0;
				if(((int)((time() - $takenExamTime)/60))>=2){
			?>
			<div>
			<h4> Account verification</h4>
			<hr>
			<p class="text-center">The following questions are test questions based on your stack. Finish the questions before the timer runs out.</p>
			<p } class="text-center"><i>click on the start button below to begin your verification test.</i></p>

			<div class="text-center">
				<div class="btn btn-primary" onclick="startTest()"> Retake Test</div>
			</div>
		</div>
		<?php

				}else{
			?>

			<!-- <div> please check back in the 2 minutes for another test.</div> -->
			<div class='text-center'>
					<div class='alert alert-success alert-dismissible fade show'>
	    			<strong>Congrats!</strong> please check back in the 2 minutes for another test.
					</div>
				</div>
		<?php

			}
		}
	?>


</div>


	<!-- this displays the test questions -->

<div class="mycontainhide" id="Test-Questions">
	<div class="container">
		<div class="d-flex justify-content-between">
			<h5><b>Test Question for : </b><span><i><?php echo $ExistingCategory?></i></span></h5>
			<p class="mr-3 t" id="time"> <i id="min"></i>:<i id="sec"></i> </p>
		</div>
		<hr>

		<div>
			<form id="ver_questions" action="freelancerdashboard.php" method="post">
				  <?php 
					global $ConnectingDB;
					$sql = "SELECT * FROM `verification_questions`, `categories` WHERE categories.ctgy_id= verification_questions.que_category AND categories.ctgy_name='$ExistingCategory'";
					$Count = 1;
					$stmtgigs = $ConnectingDB->query($sql);
					while ($DataRows = $stmtgigs->fetch()){
					$QuestionId 			= $DataRows['id'];
					$Question 			= $DataRows['question'];
					$QuestionAnswer	 		= $DataRows['que_answer'];
					$QuestionCategory	 	= $DataRows['que_category'];
					$option1		 		= $DataRows['option1'];
					$option2		 		= $DataRows['option2'];
					$option3		 		= $DataRows['option3'];
					$option4		 		= $DataRows['option4'];
					$questionname			= "question".$Count;
				?>
				<div>
					<p class="pb-2" style="border-bottom: 1px solid grey; display: inline-block;"><b>Question <?php echo $Count++;?>: </b><span><em><?php echo $Question;?></em></span>?</p>
					<div>
						<div class="form-group">
						    <label class="d-block">
						        <input type="radio" name="<?php echo $questionname;?>" value="option1" style="width: 1;width:10% !important;"> <?php echo $option1;?>
						    </label>
						    <label class="d-block">
						        <input type="radio" name="<?php echo $questionname;?>" value="option2" style="width: 1;width:10% !important;"> <?php echo $option2;?>
						    </label>

						    <label class="d-block">
						        <input type="radio" name="<?php echo $questionname;?>" value="option3" style="width: 1;width:10% !important;"> <?php echo $option3;?>
						    </label>

						    <label class="d-block">
						        <input type="radio" name="<?php echo $questionname;?>" value="option4" style="width: 1;width:10% !important;"> <?php echo $option4;?>
						    </label>
						    <label class="d-block" style="display: none !important;">
						        <input type="radio" name="<?php echo $questionname;?>" value="option5" style="width: 1;width:10% !important;" checked > empty
						    </label>
						</div>
					</div>
				</div>
				<hr>
				<?php } $Count++;?>

				<input type="hidden" name="finishTest" value="yes">
				<input type="submit" name="finishTest" value="Finish Test" class="btn btn-primary">
			</form>
			<script type="text/javascript">
			let time=60*2 ;
				function startTest() {
					openTabs(event, 'Test-Questions');
					timer();
				}
				function submitQuestions(){
					$("#ver_questions").submit();
				}
				function timer() {
					if(time > 0){

						var now = time - 1;
						var min,sec;
						if(now < time && now >= 60){
							min=1;
						}else if(now < 60){
							min=0;
						}
						if(now < time && now >= 60){
							sec = time - 60;
						}else if(now < 60){
							sec = time;
						}
						sec = sec - 1;
						$("#min").html(`0${min}`);
						$("#sec").html(sec);
						console.log(`${min}:${sec}`);
						if (now <=0) {
							submitQuestions();
						} else {
							time = now;
							setTimeout(timer, 1000);
						}
						
					}
				}
				
			</script>
		</div>
	</div>
</div>