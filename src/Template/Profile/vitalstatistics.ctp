<!----------------------editprofile-strt----------------------->

<section id="edit_profile">
	<div class="container">
		<h2>Vital<span> Statistics</span></h2>
		<p class="m-bott-50">Here You Can Manage Your Vital Statistics</p>
		<div class="row">
			<?php echo  $this->element('editprofile') ?>
			<div class="tab-content">
				<?php foreach ($uservitals as $userdata) { //pr($userdata); 
				?>
					<?php
					$question_id = $userdata['vs_question_id'];
					$checkeduser['answer'][$question_id] = $userdata['option_value_id'];
					$checkeduser['vitals'][$question_id] = $userdata['id'];
					$checkeduser['textvalue'][$question_id] = $userdata['value'];
					?>
				<?php } ?>
				<?php echo $this->Flash->render(); ?>
				<div class="profile-bg m-top-20">
					<div id="Perfo-Des" class="">
						<div class="container m-top-60">
							<?php echo $this->Form->create($uservitals, array('url' => array('controller' => 'profile', 'action' => 'vitalstatistics'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

							<?php $i = 0;
							foreach ($vitalsquestion as $vitalss) {   //pr($vitalss);
								$question_id = $vitalss->id;
							?>

								<?php echo $this->Form->input('vitalid', array('class' => 'form-control', 'placeholder' => 'VitalQuestions', 'maxlength' => '100', 'type' => 'hidden', 'label' => false, 'readonly' => 'readonly', 'value' => $checkeduser['vitals'][$question_id], 'name' => "data[$i][vitalid]")); ?>

								<div class="form-group">
									<label for="" class="col-sm-1 control-label"></label>
									<label for="" class="col-sm-3 control-label"><?php echo $vitalss->question; ?>:</label>
									<?php echo $this->Form->input('vs_question_id', array('class' => 'form-control', 'placeholder' => 'VitalQuestions', 'maxlength' => '100', 'type' => 'hidden', 'label' => false, 'readonly' => 'readonly', 'value' => $vitalss->id, 'name' => "data[$i][vs_question_id]")); ?>
									<?php echo $this->Form->input('vs_option_id', array('class' => 'form-control', 'placeholder' => 'VitalQuestions', 'maxlength' => '100', 'type' => 'hidden', 'label' => false, 'readonly' => 'readonly', 'value' => $vitalss->option_type_id, 'name' => "data[$i][vs_option_id]")); ?>



									<div class="col-sm-6">


										<?php $rs = 0;
										foreach ($vitalss['voption'] as $vitalanswer) { //pr($vitalanswer);
										?>


											<?php
											/// Dropdown
											if ($vitalss->option_type_id == '1') { ?>
												<input type="radio" name="data[<?php echo $i; ?>][value]" <?php if (in_array($vitalanswer['id'], $checkeduser['answer'])) { ?>checked <?php } ?>value="<?php echo $vitalanswer['id'] ?>"><?php echo $vitalanswer['value']; ?>

											<?php } else if ($vitalss->option_type_id == '3') { ?>


												<input type="text" name="data[<?php echo $i; ?>][value]" value="<?php echo $checkeduser['textvalue'][$question_id]; ?>" class="form-control">


											<?php } else if ($vitalss->option_type_id == '4') { ?>
												<?php echo $this->Form->input('value', array('class' => 'form-control', 'placeholder' => 'Vital Value', 'maxlength' => '200', 'id' => 'name', 'label' => false, 'type' => 'textarea', 'name' => "data[$i][value]", 'value' => $checkeduser['textvalue'][$question_id])); ?>
										<?php }
										} ?>

										<?php if ($vitalss->option_type_id == '5') { ?>
											<select id="dates-field2" class="multiselect-ui form-control" name="data[<?php echo $i; ?>][value]">
												<option value="0">--Select--</option>
												<?php foreach ($vitalss['voption'] as $vitalanswer) { //pr($value);
												?>

													<option value="<?php echo $vitalanswer['id']; ?>" <?php if (in_array($vitalanswer['id'], $checkeduser['answer'])) { ?> selected <?php } ?>><?php echo $vitalanswer['value']; ?></option>
												<?php } ?>
											</select>
										<?php } ?>

									</div>
									<div class="col-sm-4"></div>
								</div>

							<?php $i++;
							} ?>

<hr>
							<div class="form-group">
								<div class="col-sm-12 text-center">
									<button type="submit" class="btn btn-default">Submit</button>
								</div>
							</div>
							</form>
						</div>

					</div>
				</div>
			</div> <!---class profile-bg-->
		</div>
	</div>
</section>
<script>
	var $form = $('form'),
		origForm = $form.serialize();
	$('.popcheckconfirm').on('click', function() {
		if ($form.serialize() !== origForm) {
			var result = confirm('Do you want to leave this page? Changes that you made may not be saved');
			if (result) {
				return true;
			} else {
				return false;
			}
		}
	});
</script>