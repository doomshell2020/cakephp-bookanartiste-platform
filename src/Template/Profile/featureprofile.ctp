  <!----------------------page_search-strt------------------------>

  <section id="page_suggest_profile" class="featured_Profile">

  	<div class="refine-search">
  		<div class="container">
  			<div class="signup-popup my_info">
  				<?php echo $flash = $this->Flash->render(); ?>

  				<!-- My featured profile details -->
  				<?php if (isset($myfeaturedprofile) && !empty($myfeaturedprofile)) { //pr($myfeaturedprofile); die; 
					?>

  					<h2>Featured Details of <span>My Profile</span></h2>
  					<div class="clearfix">
  						<span class="pull-left"><a href="<?php echo SITE_URL; ?>/profile/earlierfeaturedprofile" data-toggle="modal" class="serviceview btn btn-default">Earlier Feature Profile</a> </span>

  						<span class="pull-right"> <a href="<?php echo SITE_URL; ?>/featuredartist" class="btn btn-default">View Featured Profile</a></span>
  					</div>
  					<br>
  					<table id="" class="table table-bordered table-striped">
  						<thead>
  							<tr>
  								<th>User Name</th>
  								<th>User Email Id</th>
  								<th>Feature Start Date</th>
  								<th>Feature End Date</th>
  								<th>Number of Days</th>
  								<th>Total Price Paid</th>
  								<th>Status</th>
  							</tr>
  						</thead>
  						<tbody id="example2">
  							<?php
								$featstart = date('Y-m-d H:m:s', strtotime($myfeaturedprofile['feature_pro_date']));
								$expiredate = date('Y-m-d H:m:s', strtotime($myfeaturedprofile['featured_expiry']));
								$currentdate = date('Y-m-d H:m:s');
								// echo $admin['feature_job_date'];
								?>
  							<tr>
  								<td>
  									<?php if (isset($myfeaturedprofile->user_name)) {
											echo ucfirst($myfeaturedprofile->user_name);
										} else {
											echo 'N/A';
										} ?>
  								</td>
  								<td><?php echo $myfeaturedprofile['email']; ?></td>
  								<td><?php if ($myfeaturedprofile['feature_pro_date']) {
											echo $featstart;
										} else {
											echo "N/A";
										} ?></td>
  								<td><?php if ($myfeaturedprofile['featured_expiry']) {
											echo $expiredate;
										} else {
											echo "N/A";
										} ?></td>
  								<td>
  									<?php
										echo $myfeaturedprofile['feature_pro_pack_numofday'] . " Days";
										?>
  								</td>
  								<td>
  									<?php if ($myfeaturedprofile['featuredprofile']) {
											echo "$" . $myfeaturedprofile['feature_pro_pack_numofday'] * $myfeaturedprofile['featuredprofile']['price'];
										} else {
											echo "0";
										}
										?>
  								</td>
  								<td class="status_btn">
  									<span class="label label-success">
  										<?php if ($expiredate > $currentdate) {
												echo "Featured";
											} else {
												echo "N/A";
											} ?>
  									</span>
  									<?php
										if ($myfeaturedprofile['feature_pro_status'] == 'Y') { ?>
  										<a class='label label-success' href="<?php echo SITE_URL ?>/profile/status/<?php echo $myfeaturedprofile['id']; ?>/N">Active</a>
  									<?php } ?>

  									<?php
										if ($myfeaturedprofile['feature_pro_status'] == 'N') { ?>
  										<a class='label label-danger' href="<?php echo SITE_URL ?>/profile/status/<?php echo $myfeaturedprofile['id']; ?>/Y">Inactive</a>
  									<?php } ?>
  								</td>


  							</tr>

  						</tbody>
  					</table>
  				<?php } else { ?>

  					<div class="col-sm-12">
  						<div class="panel-right">
  							<!--   Feature job posting start here...  -->

  							<?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'fprofilepayment'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'PackageIndexForm', 'autocomplete' => 'off', 'return validateform()')); ?>
  							<h2>Feature <span>My Profile</span></h2>
  							<h4 style="text-align: center;">Feature My Profile On Homepage</h4>
  							<table id="" class="table table-bordered table-striped">
  								<tbody>
  									<?php
										//pr($activejobs);
										$fromdate = date('Y-m-d h:i:s');
										$todate = date('Y-m-d h:i:s', strtotime($activejobs['last_date_app']));

										$date1 = date_create($fromdate);
										$date2 = date_create($todate);
										$diff = date_diff($date1, $date2);
										$daysleft = $diff->days;
										//echo $daysleft;
										$counter = 0;
										foreach ($featuredprofile as $key => $value) { // pr($value); 
											$packdays[] = $value['validity_days'];
										?>
  										<tr>
  											<?php if ($value['validity_days'] == 1) { ?>

  												<td style="text-align:center; width: 50px;">
  													<input type="radio" required name="fpackage_id" value="<?php echo $value['id']; ?>" <?php if ($value['is_default'] == "Y") { echo "checked";} ?>>
  												</td>
  												<td>
  													<strong>Customise Feature Days </strong><br>
  													<b>Pay</b> $<span id="custom_payment"><?php echo $value['price']; ?></span>
  													to feature on Homepage for <input required="required" type="text" min="1" name="number_of_days" id="number_of_days" value="1" onkeyup="update_custom_payment('<?php echo $value['price']; ?>',this);"> days.
  													<br><span id="numberdaysmsg"></span>
  													<br><span id="numberdaysmsgs"></span>
  												</td>

  											<?php } elseif ($value['validity_days'] <= $daysleft) { ?>
  												<td style="text-align:center; width: 50px;">
  													<input type="radio" required name="fpackage_id" value="<?php echo $value['id']; ?>" <?php if ($value['is_default'] == "Y") { echo "checked";} ?>>
  												</td>
  												<td><b>Pay</b> $<?php echo $value['price']; ?> to Appear for <?php echo $value['validity_days']; ?><b> days </b></td>
  											<?php } ?>
  											<input type="hidden" name="dayspack" class="dayspack<?php echo $counter; ?>" value="<?php echo $value['validity_days']; ?>">
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
  									<a href="<?php echo SITE_URL; ?>/viewprofile" class="btn btn-default pull-right"><?php echo __('Skip'); ?></a>
  								</div>
  							</div>

  							<?php echo $this->Form->end(); ?>

  							<!--   Feature job posting end here...  -->
  						</div>
  					</div>
  				<?php } ?>
  			</div>
  		</div>
  	</div>
  </section>

  <div class="modal fade" id="servicedetail">
  	<div class="modal-dialog" style="width: 88% !important;">
  		<div class="modal-content">
  			<!-- Modal Header -->
  			<div class="modal-header">
  				<button type="button" class="close" data-dismiss="modal">&times;</button>
  			</div>
  			<!-- Modal body -->
  			<div class="modal-body">
  			</div>
  		</div>
  	</div>
  </div>

  <script type="text/javascript">
  	$('.serviceview').click(function(e) {
  		e.preventDefault();
  		$('#servicedetail').modal('show').find('.modal-body').load($(this).attr('href'));
  	});
  </script>

  <script>
  	function update_custom_payment(price, values) {
  		var dayscount = '<?php echo $dayscount; ?>';
  		var i;
  		total_days = values.value;

  		for (i = 0; i < dayscount; i++) {
  			var dayss = $('.dayspack' + i).val();
  			//myarr.push(dayss);
  			if (parseInt(dayss) == parseInt(total_days)) {
  				if (total_days != 1) {
  					$("#numberdaysmsgs").html('Please select other number of days, ' + total_days + ' days already exists in Package');
  					$('#number_of_days').val('');
  				}

  				$('#custom_payment').val('0');
  				return false;
  			} else {
  				$("#numberdaysmsgs").html('');
  			}
  		}

  		if (parseInt(total_days) > 0) {
  			total_price = total_days * price;
  			$("#custom_payment").html(total_price);
  			$("#numberdaysmsg").html('');
  			return true;
  		} else {
  			//$("#numberdaysmsg").html('Please fill a value in the custom box for submission.');
  			$('#number_of_days').val('');
  			$('#custom_payment').val('0');
  			return false;
  		}
  	}
  </script>
  <script>
  	$('tr').click(function() {
  		$(this).find('td input:radio').prop('checked', true);
  	})

  	<?php if ($flash) {  ?>
  		setTimeout(function() {
  			$('.alert-success .close').trigger('click');
  		}, 5000);
  	<?php } ?>
  </script>