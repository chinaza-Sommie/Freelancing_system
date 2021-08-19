
 <?php
							$sql = "SELECT * FROM `clientsgigsform`,`ongoing_completed_work`,`registerfreelancer` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id AND ongoing_completed_work.freelancer_id=registerfreelancer.id and clientsgigsform.clients_reg_id=$UserId GROUP BY ongoing_completed_work.freelancer_id";
								$messages = $ConnectingDB->query($sql);
								
?>
<script>
	function Get_Message_By_Id(freelancerId,freelancerName){
		$("#"+freelancerId).addClass('active');
		$("#currentClient").html(freelancerName);
		$("#freelancerId").val(freelancerId);
		$("#freelancerName").val(freelancerName);
		var values="";
		$.ajax({
			type: "POST",
			url: "client/getMessages.php",
			dataType: "json",
			data:{
		        freelancerId: freelancerId,
		        userID: "<?php echo $UserId;?>"
		    },
			success: function (data) {
				
				console.log(data.length);
				var n = data.length;
		    	if (data.length === 0) {
		    		 values=" ";
		    	} else {
		    		for (var i in data) {
		    			if (data[i].sender === "client") {
		    				values +='<div class="holddiv-sent">'
							+'<div class="message-sent">'	
								+'<p class="chat-text-sent" id="chat-text">'+ data[i].message +'</p>'
							+'</div>'
						+'</div>';
		    			} else {
		    				
		    				values +='<div class="holddiv-received">'
							+'<div class="message-received">'	
								+'<p class="chat-text-received" id="chat-text">'+ data[i].message +'</p>'
							+'</div>'
						+'</div>';
		    			}
		    			
		    		}
		    	}

		    		$("#myInbox").html(values);
			},
			error: function (result) {
				alert("Error");
			}
		})
		// $.post("client/getMessages.php",
		//     {
		//         freelancerId: freelancerId
		//     },
		//     function(messages, status){
		//     	console.log(messages.d.length);
		//     	if (messages.d.length === 0) {
		//     		alert('nothing in the array');
		//     	} else {
		//     		alert('Array contains data');
		//     	}
		//     });
	}
</script>
 <div class="mycontainhide" id="Messages">
					<div class="message-box">
						<div class="message-box-inner">
							<div class="message-contacts">
								<h4> my inbox</h4>
								<?php foreach ($messages as $key => $DataRow): ?>
									<?php $freelancerName= $DataRow['firstname'].' '.$DataRow['lastname']; ?>
									<a href="#!"  onClick="Get_Message_By_Id('<?php echo $DataRow['freelancer_id']; ?>','<?php echo $freelancerName; ?>')"><p class="username" id="<?php echo $DataRow['freelancer_id']; ?>" > <?php echo $freelancerName ?></p></a>
								<?php endforeach; ?>
							</div>

				<div class="message-space">
					<div class="message-space-nav">
						<p class="username" id="currentClient"> </p>
					</div>
					<div class="message-inbox-container" id="myInbox">
						<br>
						<center>Welcome to Our Chatting Platform</center>
					</div>

					<div >
						<form class="message-space-input" id="sendMessage">
							<input type="hidden" name="UserId" value="<?php echo $UserId ?>" />
							<input type="hidden" name="freelancerId" id="freelancerId" />
							<input type="hidden" name="freelancerName" id="freelancerName" />
							<input type="text" name="messages" id="message-text-box" required="" placeholder="write message...">
						
							<button type="submit"> Send</button>
						</form>
						<script type="text/javascript">

										$('#sendMessage').submit(function(event) {

															// stop the form refreshing the page
															event.preventDefault();

															$('.form-group').removeClass('has-error'); // remove the error class
															$('.help-block').remove(); // remove the error text

													$.ajax({
															url: 'client/sendMessage.php',
															data: $(this).serialize(),
															type: "POST",
															dataType: "json",
															success: function (data) {
																if (data.type === 'success') {
																	Get_Message_By_Id(data.freelancerId,data.freelancerName)
																$('#message-text-box').val('');
																} else {
																	Lobibox.notify(data.type, {
																	position: 'top right',
																	title: 'Hi',
																	msg: 'Hello '+data.freelancerName+ ' , an error occurred'
																});
																}
															}
													});
										});
								</script>
					</div>
			</div>
		</div>
	</div>
				</div>