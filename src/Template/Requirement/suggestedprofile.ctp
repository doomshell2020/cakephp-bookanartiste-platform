  <!----------------------page_search-strt------------------------>

  <section id="page_signup">
  	<div class="container">

  	</div>

  	<div class="container">
  		<!-- <h2>Suggested <span>Profiles </span></h2> -->
  		<div class="signup-popup" style="margin-top :30px;">
  			<h2>Feature <span>Your Job </span></h2>

  			<div class="row ">
  				<div class="col-sm-12">
  					<div class="panel-right">
  						<?php echo $this->Flash->render(); ?>
  						<!--   Feature job posting start here...  -->
  						<?php if ($featured == 0) { ?>
  							<?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'fjobpayment'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'PackageIndexForm', 'autocomplete' => 'off', 'return validateform()')); ?>
  							<h4 style="text-align: center;">Feature this Requirement on Homepage</h4>

  							<table id="" class="table table-bordered table-striped">
  								<tbody>
  									<?php
										$fromdate = date('Y-m-d H:i:s');
										$todate = date('Y-m-d H:i:s', strtotime($activejobs['last_date_app']));
										$date1 = date_create($fromdate);
										$date2 = date_create($todate);
										$diff = date_diff($date1, $date2);
										if ($diff->i > 0) {
											$daysleft = $diff->days + 1;
										} else {
											$daysleft = $diff->days;
										}


										// echo $daysleft;die;
										$counter = 0;
										// pr($featuredjob);exit;
										foreach ($featuredjob as $key => $value) { //pr($value); die;
											$packdays[] = $value['validity_days'];
											$is_default = $value['is_default'] == "Y";
											$price = $value['price'];
											$id = $value['id'];
											$validity_days = $value['validity_days'];
										?>

  										<tr>
  											<?php /* if ($validity_days == 1) { ?>
  												<td style="text-align:center; width: 50px;">
  													<input type="radio" required name="fpackage_id" value="<?php echo $value['id']; ?>" <?php echo $is_default ? "checked" : ""; ?>>
  												</td>
  												<td>
  													<strong>Customise Feature Days</strong><br>
  													<b>Pay</b> $<span id="custom_payment"><?php echo $price; ?></span>
  													to feature on Homepage for <input required="required" type="text" min="1" name="number_of_days" id="number_of_days" value="1" onkeyup="update_custom_payment('<?php echo $price; ?>',this);"> days.
  													<br><span id="numberdaysmsg"></span>
  													<br><span id="numberdaysmsgs"></span>
  												</td>

  											<?php } else */

												if ($validity_days <= $daysleft) { ?>
  												<td style="text-align:center; width: 50px;">
  													<input type="radio" required name="fpackage_id" value="<?php echo $value['id']; ?>" <?php echo $is_default ? "checked" : ""; ?>>
  												</td>
  												<td>
  													<b>Pay</b> $<?php echo $price; ?> to Appear for <?php echo $validity_days; ?><b> days </b>
  												</td>
  												<input type="hidden" name="dayspack" class="dayspack<?php echo $counter; ?>" value="<?php echo $validity_days; ?>">
  											<?php } ?>
  										</tr>
  									<?php $counter++;
										}
										$dayscount = count($packdays); ?>
  								</tbody>
  							</table>


  							<div class="form-group">
  								<div class="col-sm-12 ">

  									<input type="hidden" name="job_id" id="job_id" value="<?php echo $job_id; ?>">
  									<button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
  									<a href="<?php echo SITE_URL; ?>/myrequirement" class="btn btn-default pull-right"><?php echo __('Skip'); ?></a>
  								</div>
  							</div>

  							<?php echo $this->Form->end(); ?>

  						<?php } ?>

  						<hr>

  						<?php // pr($profiles); die;
							if (count($profiles) > 0) {
								foreach ($profiles as $profile_data) { ?>

  								<div class="member-detail row profiles_box">
  									<div class="col-sm-3">
  										<div class="member-detail-img">
  											<a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_data['user_id']; ?>">
  												<img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile_data['profile_image']; ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/no-image.jpg';"> </a>
  											<div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
  										</div>
  									</div>
  									<div class="col-sm-9">
  										<div class="row">
  											<ul class="col-sm-4 member-info list-unstyled">
  												<li>Name</li>
  												<li>Gender</li>
  												<li>Talent</li>
  												<li>Location</li>
  												<li>Experience</li>
  											</ul>
  											<ul class="col-sm-2 list-unstyled">
  												<li>:</li>
  												<li>:</li>
  												<li>:</li>
  												<li>:</li>
  												<li>:</li>
  											</ul>
  											<ul class="col-sm-6 list-unstyled">
  												<li><?php echo $profile_data['name']; ?></li>
  												<li><?php
														if ($profile_data['gender'] == 'm') {
															echo "Male";
														} elseif ($profile_data['gender'] == 'f') {
															echo "Female";
														} elseif ($profile_data['gender'] == 'o') {
															echo "Other";
														}
														?></li>

  												<?php $userskills = $this->comman->userskills($profile_data['user_id']);
													$userskillsdata = array();
													foreach ($userskills as $user_skills) {
														$userskillsdata[] = $user_skills['skill']['name'];
													}
													?>
  												<li><?php echo implode(", ", $userskillsdata); ?></li>
  												<li><?php echo $profile_data['city_name']; ?> <?php echo $profile_data['state_name']; ?> <?php echo $profile_data['country']; ?></li>
  												<li>
  													<?php $experienceyear = date("Y") - $profile_data['performing_year'];
														echo $experienceyear; ?> Years</li>
  											</ul>
  										</div>
  										<a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_data['user_id']; ?>" class="btn btn-default ad">Book <?php echo $profile_data['name']; ?></a>
  										<a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_data['user_id']; ?>" class="btn btn-default ad">Ask For Quote</a>


  									</div>

  									<!-- <div class="box_hvr_checkndlt">
										<span class="pull-left"><input type="checkbox" value=""></span>
										<a href="#" class="pull-right dlt_prfl_box"><i class="fa fa-times" aria-hidden="true"></i></a>
									</div>-->

  								</div>


  							<?php
								}
							} else { ?>
  							<!-- <h5> There are no profile suggestions for this requirement as of now. </h5> -->
  							<h5> There are no profile suggestion for the job posted . </h5>

  						<?php }  ?>


  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </section>

  <script>
  	function update_custom_payment(price, values) {
  		const daysleft = parseInt('<?php echo $daysleft; ?>');
  		const dayscount = parseInt('<?php echo $dayscount; ?>');
  		const total_days = parseInt(values.value);

  		for (let i = 0; i < dayscount; i++) {
  			const packageDays = parseInt($(`.dayspack${i}`).val());

  			if (packageDays == total_days) {
  				$("#numberdaysmsg").html(`Please select another number of days, ${total_days} days already exist in the package.`);
  				$('#number_of_days').val('');
  				$('#custom_payment').html('0');
  				return false;
  			}
  		}

  		$("#numberdaysmsgs").html('');

  		if (total_days > 0 && total_days <= daysleft) {
  			const total_price = total_days * price;
  			$("#custom_payment").html(total_price);
  			$("#numberdaysmsg").html('');
  			return true;
  		}

  		if (total_days <= 0) {
  			$("#numberdaysmsg").html('You cannot select less than 1 day.');
  		} else {
  			$("#numberdaysmsg").html(`Do not select a value higher than ${daysleft}. This job will be inactive in ${daysleft} days.`);
  		}

  		$('#number_of_days').val('');
  		$('#custom_payment').html('0');
  		return false;
  	}

  	// Enable clicking on table rows to select corresponding radio button
  	$('tr').on('click', function() {
  		$(this).find('input:radio').prop('checked', true);
  	});
  </script>