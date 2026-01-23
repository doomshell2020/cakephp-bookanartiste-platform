	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Recruiter Package
			</h1>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">

				<!-- right column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?php if (isset($packentity['id'])) { echo 'Edit Recruiter Package';} else { echo 'Add Recruiter package'; } ?></h3>
						</div>
						<!-- /.box-header -->
						<!-- form start -->

						<?php echo $this->Flash->render();	?>
						<?php echo $this->Form->create($packentity, array(

							'class' => 'form-horizontal',
							'id' => 'sevice_form',
							'enctype' => 'multipart/form-data'
						)); ?>

						<div class="box-body">


							<div class="form-group">
								<label class="col-sm-3 control-label">Package Name</label>
								<div class="field col-sm-6">
									<?php echo $this->Form->input('title', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Package name', 'required', 'label' => false)); ?></div>
							</div>


							<div class="form-group">
								<label class="col-sm-3 control-label">Valid for(Number of Days)</label>
								<div class="field col-sm-5">
									<?php echo $this->Form->input('validity_days', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-3 control-label">Price </label>
								<div class="field col-sm-6">

									<?php echo $this->Form->input('price', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Price', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Package Text</label>
								<div class="field col-sm-5">
									<?php echo $this->Form->input('packagetext', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'placeholder' => 'Package Text', 'label' => false, 'type' => 'text')); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Number of Job Postings </label>
								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_job_post', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-3 control-label">Number of Job Postings simultaneously </label>
								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_job_simultancney', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number Of job Simuntantously', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>
							</div>

							<!-- <div class="form-group">

								<label class="col-sm-3 control-label">Visibility Priority</label>

								<div class="field col-sm-6">

									<?php //echo $this->Form->input('priorites', array('class' =>'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Priorites', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); 
									?>

								</div>

							</div> -->

							<div class="form-group">
								<label class="col-sm-3 control-label">Messagin to non-connection allowed</label>
								<div class="field col-sm-6">
									<?php $status = array('Y' => 'Yes', 'N' => 'No');
									echo $this->Form->input('Monthly_new_talent_messaging', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Multiple E Mail id logins', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?></div>
							</div>

							<div class="form-group">

								<label class="col-sm-3 control-label">Messaging Number of non-connection per month</label>

								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_message', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Message', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>

							</div>


							<div class="form-group">

								<label class="col-sm-3 control-label">Number of contact details access</label>

								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_contact_details', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Contact details', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>

							</div>

							<div class="form-group">

								<label class="col-sm-3 control-label">Icon</label>

								<div class="field col-sm-5">

									<?php echo $this->Form->input('Icon', array('class' => 'longinput form-control', 'label' => false, 'type' => 'file')); ?>

								</div>

							</div>


							<div class="form-group">

								<!-- <label class="col-sm-3 control-label">Number of Talent Searched</label> -->
								<label class="col-sm-3 control-label">Number of Profile Search limit</label>

								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_talent_search', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Talent Search', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>

							</div>



							<div class="form-group">

								<label class="col-sm-3 control-label">Number of suggested profiles after posting a Job</label>

								<div class="field col-sm-6">

									<?php echo $this->Form->input('nubmer_of_site', array('class' =>
									'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Sites', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

								</div>

							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Multiple logins allowed</label>
								<div class="field col-sm-6">
									<?php

									$status = array('Y' => 'Yes', 'N' => 'No');
									echo $this->Form->input('multipal_email_login', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?></div>
							</div>


							<div class="form-group numberofloginsallowed">
								<label class="col-sm-3 control-label">Number of Logins allowed</label>
								<div class="field col-sm-6">

									<?php echo $this->Form->input('number_of_email', array('class' =>
									'longinput form-control', 'maxlength' => '2', 'required', 'placeholder' => 'Number of Logins allowed', 'required', 'label' => false, 'type' => 'text')); ?>

								</div>
							</div>


						</div><!--content-->

						<!-- /.form group -->

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<?php
						echo $this->Html->link('Back', [
							'action' => 'index'

						], ['class' => 'btn btn-default']); ?>

						<?php
						if (isset($packentity['id'])) {
							echo $this->Form->submit(
								'Update',
								array('class' => 'btn btn-info pull-right', 'title' => 'Update')
							);
						} else {
							echo $this->Form->submit(
								'Add',
								array('class' => 'btn btn-info pull-right', 'title' => 'Add')
							);
						}
						?>
					</div>
					<!-- /.box-footer -->
					<?php echo $this->Form->end(); ?>
				</div>

			</div>
			<!--/.col (right) -->
	</div>
	<!-- /.row -->
	</section>
	<!-- /.content -->
	</div>

	<script>
		$(document).ready(function() {
			const multipal_email_login = '<?php echo $packentity['multipal_email_login']; ?>';
			if (multipal_email_login == 'N') {
				$('#number-of-email').prop('disabled', true);
				$('#number-of-email').attr('required', false);
			} else {
				$('#number-of-email').prop('disabled', false);
				$('#number-of-email').attr('required', true);
			}

		});

		$(function() {
			$("input[name='number_of_email']").on('input', function(e) {
				$(this).val($(this).val().replace(/[^1-9]/g, ''));
			});
		});


		jQuery($ => {
			let $checkBox = $('#multipal-email-login').on('change', e => {

				if (e.target.value == 'N') {
					// $('#number-of-email').prop('disabled', 'disabled');
					$('.numberofloginsallowed').hide();
					$('#number-of-email').attr('required', false);
					$('#number-of-email').val('');

				} else {
					$('#number-of-email').prop('disabled', false);
					$('.numberofloginsallowed').show();
					$('#number-of-email').attr('required', true);
				}

				// } else if(e.target.value == 'Y') {

			});
		});
	</script>