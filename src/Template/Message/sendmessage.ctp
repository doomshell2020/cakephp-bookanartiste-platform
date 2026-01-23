<?php if (!isset($error) && empty($error)) { //echo $error; 
?>
	<?php echo $this->Form->create($gallery, array('url' => array('controller' => 'profile', 'action' => 'updateimagecaption'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

	<div class="form-group">
		<label class="control-label col-sm-2">To :</label>
		<div class="col-sm-10">
			<?php echo $this->Form->input('to', array('class' => 'form-control', 'placeholder' => 'To', 'maxlength' => '50', 'id' => 'to', 'required', 'label' => false, 'value' => $userdetails['user_name'], 'readonly' => 'readonly')); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2">Subject :</label>
		<div class="col-sm-10">
			<?php echo $this->Form->input('subject', array('class' => 'form-control', 'placeholder' => 'Subject', 'maxlength' => '50', 'id' => 'subject', 'required', 'label' => false)); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2">Message :</label>
		<div class="col-sm-10">
			<?php echo $this->Form->input('message', array('class' => 'form-control', 'type' => 'textarea', 'placeholder' => 'Message', 'maxlength' => '250', 'id' => 'message', 'required', 'label' => false, 'name' => 'message')); ?>
			<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>">
		</div>
	</div>


	<div class="form-group">
		<div class="text-center col-sm-12">
			<input type="hidden" name="enter_send" value="0">
			<span style="margin-left:-188px; ">Send Message on Enter</span> <input type="checkbox" name="enter_send" id="enter_sendbtnsend" value="1">
			<br>
			<br>
			<a id="btn" class="btn btn-default sendmessagetouser">Send</a>
			<a id="btn" href="<?php echo SITE_URL; ?>/message/search/<?php echo $userid; ?>" class="btn btn-default">View All Messages to <?php echo $userdetails['user_name']; ?></a>

		</div>
	</div>
	<?php echo $this->Form->end(); ?>


	<script>
		$('#enter_sendbtnsend').click(function() {
			if ($(this).is(":checked")) {
				$("#message").keypress(function(event) {
					if (event.which == 13) {
						event.preventDefault();
						//$("form").submit();

						// subject = $("#subject").val();
						// message = $("#message").val();
						userid = $("#userid").val();
						jobid = $("#jobid").val();


						let subject = $("#subject");
						let message = $("#message");
						let isValid = true;

						// Reset previous styles
						subject.css("border", "");
						message.css("border", "");

						if (subject.val().trim() === "") {
							subject.css("border", "1px solid red").focus();
							isValid = false;
						}

						if (message.val().trim() === "") {
							message.css("border", "1px solid red");
							if (isValid) {
								message.focus();
							}
							isValid = false;
						}

						if (!isValid) {
							e.preventDefault(); // Prevent form submission
							return false;
						}

						if (!userid) {
							showerror('Please fill all fields.');
							return false
						}


						$.ajax({
							type: "POST",
							url: '<?php echo SITE_URL; ?>/message/sendmessage',
							data: {
								userid: userid,
								message: message.val().trim(),
								subject: subject.val().trim(),
								jobid: jobid
							},
							cache: false,
							success: function(data) {
								obj = JSON.parse(data);
								if (obj.status == 0) {
									showerror(obj.error);
								} else {
									$('#sendmessage').modal('toggle');
									BootstrapDialog.alert({
										size: BootstrapDialog.SIZE_SMALL,
										title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
										message: "<h5>Message has been sent successfully</h5>"
									});
									setTimeout(function() {
										location.reload();
									}, 3000);
								}
							}
						});
					}
				})
			}
		});
	</script>
	<script>
		/*  Manage friends  */
		$('.sendmessagetouser').click(function() {
			// subject = $("#subject").val();
			// message = $("#message").val();
			let userid = $("#userid").val();
			let subject = $("#subject");
			let message = $("#message");
			let isValid = true;

			// Reset previous styles
			subject.css("border", "");
			message.css("border", "");

			if (subject.val().trim() === "") {
				subject.css("border", "1px solid red").focus();
				isValid = false;
			}

			if (message.val().trim() === "") {
				message.css("border", "1px solid red");
				if (isValid) {
					message.focus();
				}
				isValid = false;
			}

			if (!isValid) {
				e.preventDefault(); // Prevent form submission
				return false;
			}

			if (!userid) {
				showerror('Please fill all fields.');
				return false
			}

			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL; ?>/message/sendmessage',
				data: {
					userid: userid,
					message: message.val().trim(),
					subject: subject.val().trim(),
				},
				cache: false,
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.status == 0) {
						showerror(obj.error);
					} else {
						$('#sendmessage').modal('toggle');
						BootstrapDialog.alert({
							size: BootstrapDialog.SIZE_SMALL,
							title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
							message: "<h5>Message has been sent successfully</h5>"
						});
						setTimeout(function() {
							location.reload();
						}, 3000);

					}
				}
			});
		});
	</script>
<?php } else {
	echo $error;
?>

<?php } ?>