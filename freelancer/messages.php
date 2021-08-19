<?php
$sql = "SELECT * FROM `clientsgigsform`,`ongoing_completed_work`,`registerpage` WHERE ongoing_completed_work.client_gig_id=clientsgigsform.id AND clientsgigsform.clients_reg_id=registerpage.id and ongoing_completed_work.freelancer_id=$UserId GROUP BY clientsgigsform.clients_reg_id";
$messages = $ConnectingDB->query($sql);

?>
<script>
	// getting messages from database taking the client id and client name as parameters
	function Get_Message_By_Id(clientid, clientName) {
		$("#" + clientid).addClass('active');
		$("#currentClient").html(clientName);
		$("#clientid").val(clientid);
		$("#clientName").val(clientName);
		var values = "";
		$.ajax({
			type: "POST",
			url: "freelancer/getMessages.php",
			dataType: "json",
			data: {
				clientID: clientid,
				userID: "<?php echo $UserId; ?>"
			},
			success: function(data) {

				// console.log(data.length);
				// console.log(data);

				var n = data.length;
				if (data.length === 0) {
					values = " ";
				} else {
					// looping through the array (data)
					for (var i in data) {
						if (data[i].sender === "freelancer") {
							values += '<div class="holddiv-sent">' +
								'<div class="message-sent">' +
								'<p class="chat-text-sent" id="chat-text">' + data[i].message + '</p>' +
								'</div>' +
								'</div>';
						} else {

							values += '<div class="holddiv-received">' +
								'<div class="message-received">' +
								'<p class="chat-text-received" id="chat-text">' + data[i].message + '</p>' +
								'</div>' +
								'</div>';
						}

					}
				}

				$("#myInbox").html(values);
			},
			error: function(result) {
				alert("Error");
			}
		})
	}
</script>
<div class="mycontainhide" id="messages">
	<div class="message-box">
		<div class="message-box-inner">
			<div class="message-contacts">
				<h4> my inbox</h4>
				<?php foreach ($messages as $key => $DataRow) : ?>
					<?php $clientName = $DataRow['firstname'] . ' ' . $DataRow['lastname']; ?>
					<a href="#!" onClick="Get_Message_By_Id('<?php echo $DataRow['clients_reg_id']; ?>','<?php echo $clientName; ?>')">
						<p class="username" id="<?php echo $DataRow['client_gig_id']; ?>"> <?php echo $clientName ?></p>
					</a>
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

				<div>
					<form class="message-space-input" id="sendMessage">
						<input type="hidden" name="UserId" value="<?php echo $UserId ?>" />
						<input type="hidden" name="clientid" id="clientid" />
						<input type="hidden" name="clientName" id="clientName" />
						<input type="text" name="messages" id="message-text-box" required="" placeholder="write message...">

						<button type="submit"> Send</button>
					</form>
					<script type="text/javascript">
						$('#sendMessage').submit(function(event) {

							// stop the form refreshing the page
							event.preventDefault();

							$.ajax({
								url: 'freelancer/sendMessage.php',
								data: $(this).serialize(),
								type: "POST",
								dataType: "json",
								success: function(data) {
									if (data.type === 'success') {
										Get_Message_By_Id(data.clientid, data.clientName)
										$('#message-text-box').val('');
									} else {
										Lobibox.notify(data.type, {
											position: 'top right',
											title: 'Hi',
											msg: 'Hello ' + data.clientName + ' , an error occurred'
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