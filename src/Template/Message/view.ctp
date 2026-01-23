<section id="page_Messaging">
	<div class="container">
		<h2><span>Messaging</span></h2>
	</div>
	<div class="mess-box-container">
		<div class="container">
			<div class="row profile-bg m-top-20">
				<h4 class="text-center">
					<?php echo !empty($messages[0]['subject']) ? $messages[0]['subject'] : ''; ?>
				</h4>

				<?php echo $this->element('messaginmenuleft'); ?>

				<div class="col-sm-9">
					<div class="messaging-cntnt-box">
						<div class="msz-frm row">
							<!-- Sender Details -->
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3"><strong>From:</strong></div>
									<div class="col-sm-9"><?php echo !empty($messages[0]['from_name']) ? $messages[0]['from_name'] : ''; ?></div>

									<div class="col-sm-3"><strong>To:</strong></div>
									<div class="col-sm-9"><?php echo !empty($messages[0]['to_name']) ? $messages[0]['to_name'] : ''; ?></div>

									<div class="col-sm-3"><strong>Time:</strong></div>
									<div class="col-sm-9">
										<?php
										if (!empty($messages[0]['created'])) {
											echo date("d M Y, h:i A", strtotime($messages[0]['created']));
										}
										?>
									</div>

									<div class="col-sm-3"><strong>Message:</strong></div>
									<div class="col-sm-9"><?php echo !empty($messages[0]['description']) ? nl2br($messages[0]['description']) : ''; ?></div>
								</div>
							</div>

							<!-- Folder Form -->
							<div class="col-sm-3"></div>
							<div class="col-sm-3">
								<?php
								echo $this->Form->create(
									$foldersv,
									[
										'url' => ['controller' => 'message', 'action' => 'movetofolder'],
										'type' => 'file',
										'inputDefaults' => ['div' => false, 'label' => false],
										'class' => 'form-horizontal',
										'id' => 'folder_form',
										'autocomplete' => 'off'
									]
								);
								?>
								<input type="hidden" name="message_id" id="message_id" value="<?php echo !empty($messages[0]['id']) ? $messages[0]['id'] : '0'; ?>">

								<input type="hidden" name="type" id="type" value="<?php
																					if (!empty($messages[0])) {
																						if ($messages[0]['from_id'] == $this->request->session()->read('Auth.User.id') && $messages[0]['from_box'] != 'trash') {
																							echo "s"; // Sent
																						} else {
																							echo ($messages[0]['from_box'] != 'trash') ? "i" : "t"; // Inbox or Trash
																						}
																					}
																					?>">
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="action_buttons text-center m-top-20">
					<a href="<?php echo SITE_URL; ?>/message/viewmessage/<?php echo !empty($messages[0]['thread_id']) ? $messages[0]['thread_id'] : '0'; ?>" class="btn btn-primary">
						Reply
					</a>
					<a href="<?php echo SITE_URL; ?>/message/compose/forward/<?php echo !empty($messages[0]['id']) ? $messages[0]['id'] : '0'; ?>" class="btn btn-primary">
						Forward
					</a>
				</div>

				<div id="reply_message"></div>
			</div>
		</div>
	</div>
</section>



<script>
	$(document).ready(function() {
		$("#folders").change(function() {
			$("#folder_form").submit();
		});
	});
</script>



<script>
	/*
 
    $('.reply').click(function() {  
	message_id = $(this).data('val');
	$.ajax({
	    url: '<?php echo SITE_URL; ?>/message/reply/'+message_id,
	    cache:false,
	    success:function(data){ 
		$("#reply_message").html(data);
	    }
	});
    });
    
    
 
    $('.forward').click(function() {  
	message_id = $(this).data('val');
	$.ajax({
	    url: '<?php echo SITE_URL; ?>/message/forward/'+message_id,
	    cache:false,
	    success:function(data){ 
		$("#reply_message").html(data);
	    }
	});
    });
*/
</script>