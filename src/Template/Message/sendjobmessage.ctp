<style type="text/css">
	#suggesstion-box2 ul.message-contacts li {
		display: inline-block;
		position: relative;
		padding-bottom: 3px;
		float: none;
		width: 100%;
	}

	.sendmessagetouser,
	.alls {
		color: #fff !important;
	}
</style>

<?php if (!isset($error) && empty($error)) { //echo $error; 
?>
	<?php echo $this->Form->create($gallery, array('url' => array('controller' => 'profile', 'action' => 'updateimagecaption'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

	<div class="form-group">
		<label class="control-label col-sm-2">To :</label>
		<div class="col-sm-10">
			<?php //echo $this->Form->input('to',array('class'=>'form-control','placeholder'=>'To','maxlength'=>'50','id'=>'to','required','label' =>false,'value'=>$userdetails['user_name'])); 
			echo $this->Form->input('to', array('class' => 'form-control', 'placeholder' => 'To', 'id' => 'asearch-box2', 'required' => true, 'label' => false, 'type' => 'text', 'value' => ($messages) ? $messages['to_name'] : '')); ?>
			<input type="hidden" id="to_id" name="to_id" value="<?php echo ($messages['to_id'] > 0) ? $messages['to_id'] : '0'; ?>" />
			<input type="hidden" name="message_id" id="message_id" value="<?php echo ($messages['id'] > 0) ? $messages['id'] : '0'; ?>">
			<input type="hidden" id="jobid" name="jobid" value="<?php echo $jobid; ?>">
			<div id="suggesstion-box2"></div>
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

		</div>
	</div>


	<div class="form-group">
		<div class="text-center col-sm-12">
			<div class="text-left">
				<input type="hidden" name="enter_send" value="0">
				<input type="checkbox" name="enter_send" id="enter_sendbtnsend" value="1"> <span>Send Message on Enter</span>
			</div>
			<br>
			<br>
			<a id="btn" class="btn btn-default sendmessagetouser">Send</a>
			<a id="btn" href="<?php echo SITE_URL; ?>/message/search/<?php echo $userid; ?>" class="btn btn-default alls">View All Messages to <?php echo $userdetails['user_name']; ?></a>

		</div>
	</div>
	<?php echo $this->Form->end(); ?>
<?php } else {
	echo $error;
?>

<?php } ?>


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
							subject: subject.val().trim()
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

	/*  Manage friends  */
	$('.sendmessagetouser').click(function() {

		// subject = $("#subject").val();
		// message = $("#message").val();
		userid = $("#to_id").val();
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


		//alert(userid);
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
	});

	// $(document).ready(function() {
	$("#asearch-box2").keyup(function() {
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_URL; ?>/message/fetchcontactstalent",
			data: 'keyword=' + $(this).val(),
			beforeSend: function() {
				$("#asearch-box2").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data) {
				$("#suggesstion-box2").show();
				$("#suggesstion-box2").html(data);
				$("#search-box").css("background", "#FFF");
			}
		});
	});
	// });

	function selectUser(val, text) {
		//alert(val,text)
		$("#asearch-box2").val(text);
		$("#to_id").val(val);
		$("#suggesstion-box2").hide();
		savedraft();
	}

	// Saving Message to draft
	function savedraft() {
		to_id = $("#to_id").val();
		message_id = $("#message_id").val();
		subject = $("#subject").val();
		description = $("#description").val();
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_URL; ?>/message/savetodraft",
			data: 'to_id=' + to_id + '&message_id=' + message_id + '&subject=' + subject + '&description=' + description,
			success: function(data) {
				obj = JSON.parse(data);
				if (obj.message_id > 0) {
					$("#message_id").val(obj.message_id);
				}
			}
		});
	}

	function validateform() {

	}
</script>