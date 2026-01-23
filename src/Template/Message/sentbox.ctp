  <script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
  <section id="page_Messaging">

  	<div class="mess-box-container">
  		<div class="container">

  			<h2><span>Messaging</span></h2>
  			<?php echo $this->Flash->render(); ?>

  			<?php echo $this->Form->create($folderss, array('url' => array('controller' => 'message', 'action' => 'actions'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'folder_form', 'autocomplete' => 'off')); ?>
  			<div class="row profile-bg m-top-20">

  				<?php echo  $this->element('messaginmenuleft') ?>
  				<div class="col-sm-9">
  					<div class="ff">
  						<div class="row">
  							<div class="col-sm-3">
  								<h4 class="text-left">Sent Items</h4>
  							</div>
  							<div class="col-sm-9">
  								<span class="dropdown">
  									<button class="btn btn-default dropdown-toggle" type="button" title="Move to Folder" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  										<span class="fa fa-folder"></span>
  										<span class="caret"></span>
  									</button>


  									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  										<li><a href="Javascript:void(0)" class="changefolder" data-val="0"> Move to Sentbox</a></li>
  										<?php foreach ($folders as $folders_data) { ?>

  											<li><a href="Javascript:void(0)" class="changefolder" data-val="<?php echo $folders_data['id']; ?>">Move to <?php echo $folders_data['folder_name']; ?></a></li>
  										<?php } ?>
  									</ul>
  								</span>
  								<input type="hidden" name="folder_id" id="folder_id">
  								<a href="Javascript:void(0)" class="btn btn-primary" id="delete">Delete</a>
  								<a href="Javascript:void(0)" class="btn btn-primary" id="markread">Mark as Read</a>
  								<a href="Javascript:void(0)" class="btn btn-primary" id="markunread">Mark as Unread</a>
  								<input type="hidden" name="action" id="action" value="">
  								<input type="hidden" name="message_id" id="message_id" value="<?php echo ($messages[0]['id'] > 0) ? $messages[0]['id'] : '0'; ?>">
  								<input type="hidden" name="type" id="type" value="s">
  							</div>
  						</div>
  					</div>

  					<div class="messaging-cntnt-box">
  						<div class="msz-inbox">

  							<?php if (count($messages) > 0) {
									foreach ($messages as $messages_data) {   //pr($messages_data);
								?>
  									<div class="row inbox-row box" id="row_<?php echo $messages_data['id']; ?>">
  										<div class="col-sm-1"><input type="checkbox" name="thread_id[]" class="thread_id" id="thread_id" value="<?php echo $messages_data['thread_id']; ?>"></div>
  										<div class="col-sm-2">

  											<img class=" img-circle pull-left"
  												src="<?php echo !empty($messages_data['to_image']) ? SITE_URL . '/profileimages/' . $messages_data['to_image'] : SITE_URL . '/images/noimage.jpg'; ?>"
  												alt="Profile Image" />

  											<p class="pull-right">
  												<?php if ($messages_data['total'] > 1) { ?>
  													<a href="<?php echo SITE_URL; ?>/message/viewmessage/<?php echo $messages_data['thread_id']; ?>">
  													<?php } else { ?>
  														<a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['thread_id']; ?>">
  														<?php } ?>

  														<?php if ($messages_data['read_status'] == 'Y') { ?>
  															<?php echo $messages_data['to_name']; ?>
  														<?php } else { ?>
  															<?php echo $messages_data['to_name']; ?>
  														<?php } ?>


  														</a>
  											</p>
  										</div>

  										<div class="col-sm-6">
  											<p>
  												<?php if ($messages_data['total'] > 1) { ?>
  													<a href="<?php echo SITE_URL; ?>/message/viewmessage/<?php echo $messages_data['thread_id']; ?>">
  													<?php } else { ?>
  														<a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['id']; ?>">
  														<?php } ?>
  														<?php if ($messages_data['read_status'] == 'Y') { ?>
  															<?php echo $messages_data['subject']; ?> <?php if ($messages_data['total'] > 1) {
																											echo "(" . $messages_data['total'] . ")";
																										} ?>
  														<?php } else { ?>
  															<?php echo $messages_data['subject']; ?> <?php if ($messages_data['total'] > 1) {
																											echo "(" . $messages_data['total'] . ")";
																										} ?>
  														<?php } ?>

  														</a>
  											</p>
  										</div>

  										<div class="col-sm-3 time">
  											<p><?php echo date("d-m-y h:i", strtotime($messages_data['created'])); ?></p>
  										</div>
  									</div>

  								<?php }
								} else {     ?>
  								No Message available
  							<?php } ?>

  						</div>

  					</div>
  				</div>
  			</div>
  			<?php echo $this->Form->end(); ?>
  		</div>
  	</div>
  </section>


  <script>
  	// Moving message to folder
  	$(document).ready(function() {
  		$(".changefolder").click(function() {
  			if (!$('.thread_id:checked').length > 0) {
  				BootstrapDialog.alert({
  					size: BootstrapDialog.SIZE_SMALL,
  					title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
  					message: "<h5>No Message Selected for moving in folder</h5>"
  				});
  				return false;
  			} else {
  				folder_id = $(this).data('val');
  				$("#action").val('folders');
  				$("#folder_id").val(folder_id);
  				$("#folder_form").submit();
  			}
  		});
  	});

  	// Deleteing Message
  	$(document).ready(function() {
  		$("#delete").click(function() {
  			if (!$('.thread_id:checked').length > 0) {
  				BootstrapDialog.alert({
  					size: BootstrapDialog.SIZE_SMALL,
  					title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
  					message: "<h5>No Message Selected for delete</h5>"
  				});
  				return false;
  			} else {
  				BootstrapDialog.confirm({
  					title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
  					message: 'Are you sure to want to Delete the selected messages?',
  					draggable: true,
  					callback: function(result) {
  						if (result) {
  							$("#action").val('delete');
  							$("#folder_form").submit();
  						} else {
  							return false;
  						}
  					}
  				});
  			}
  		});
  	});


  	// Mark as Read
  	$(document).ready(function() {
  		$("#markread").click(function() {
  			if (!$('.thread_id:checked').length > 0) {
  				BootstrapDialog.alert({
  					size: BootstrapDialog.SIZE_SMALL,
  					title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
  					message: "<h5>No Message Selected</h5>"
  				});
  				return false;
  			} else {
  				$("#action").val('markread');
  				$("#folder_form").submit();
  			}
  		});
  	});


  	// Mark as Read
  	$(document).ready(function() {
  		$("#markunread").click(function() {
  			if (!$('.thread_id:checked').length > 0) {
  				BootstrapDialog.alert({
  					size: BootstrapDialog.SIZE_SMALL,
  					title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
  					message: "<h5>No Message Selected</h5>"
  				});
  				return false;
  			} else {
  				$("#action").val('markunread');
  				$("#folder_form").submit();
  			}
  		});
  	});
  </script>