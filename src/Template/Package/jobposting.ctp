<?php
// pr($pack_feature_data);
// pr($number_of_job_simultancney);

// pr($totalUsedLimit);exit;

// $roleId = $this->request->session()->read('Auth.User.role_id');
// $eligibleJobPostRoleWise = ($roleId == TALANT_ROLEID) ? $pack_feature_data['number_of_job_simultancney'] : $pack_feature_data['non_telent_number_of_job_post'];



// Get the active package details by Rupam 17 Jan 2025
$user_id = $this->request->session()->read('Auth.User.id');
$roleType = $this->request->session()->read('Auth.User.role_id');
// $activePackage = $this->Comman->activePackage('RC');
// $totalPostTodayLimit = $this->Comman->getTodayPostJob($activePackage['id']) ?? 0;

// $totalPostSimultaneously = $activePackage['number_of_job_simultancney'] ?? 0;
// if ($roleType == NONTALANT_ROLEID) {
// 	$totalLimitJobPost = $activePackage['non_telent_number_of_job_post'];
// 	$totalUsedLimit = $activePackage['non_telent_number_of_job_post_used'];
// } else {
// 	$totalLimitJobPost = $activePackage['number_of_job_post'];
// 	$totalUsedLimit = $activePackage['number_of_job_post_used'];
// }

// pr($totalPostSimultaneously); //1
// pr($totalUsedLimit); // 0
// pr($totalLimitJobPost);exit; // 2

//if ($number_of_job_simultancney <= $eligibleJobPostRoleWise) { 
if (true) { ?>
	<section id="edit_profile">
		<div class="container">
			<h2>Select your <span>posting options</span></h2>
			<div class="row">
				<div class=" m-top-20">
					<?php $this->Flash->render(); ?>
					<div id="Personal_page" class="tab-pane fade in active">
						<div class="">
							<div class="prsnl_page_dtl posting_options profile-bg ">
								<?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'jobpayment'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'PackageIndexForm', 'autocomplete' => 'off')); ?>

								<h5>Choose any options from the list in order to posting a job. </h5>
								<table id="" class="table table-bordered table-striped">
									<tbody>

										<?php
										// pr($packFeature);exit;
										if ($totalLimitJobPost > $totalUsedLimit) { ?>
											<tr>
												<input type="hidden" name="isFree" value="FR" onclick="updatePackagePrice('<?php echo $value['price']; ?>')">
												<td style="text-align:center">
													<input type="radio" required name="package_id" onclick="updatePackagePrice('0')" value="0" checked="checked">
												</td>
												<td style="color:#078fe8;">Free Hire <?php echo $packFeature['number_of_talent_free_jobpost']; ?> talent type. Post valid for <?php echo $packFeature['number_of_days_free_jobpost']; ?> days</td>
											</tr>
										<?php } else { ?>
											<tr>
												<td colspan="2">
													<h5>You have used your all Job Posting limit</h5>
												</td>
											</tr>

										<?php } ?>

										<?php foreach ($requirement_packages as $key => $value) { ?>

											<tr>
												<input type="hidden" name="package_type" value="RE" onclick="updatePackagePrice('<?php echo $value['price']; ?>')">
												<td style="text-align:center">
													<input type="radio" required name="package_id" onclick="updatePackagePrice('<?php echo $value['price']; ?>')" value="<?php echo $value['id']; ?>">
												</td>
												<td><span style="color:#078fe8;"> $ <?php echo $value['price']; ?></span> Hire <?php echo $value['number_of_talent_type']; ?> talent type. Post valid for <?php echo $value['number_of_days']; ?> days</td>

											</tr>

										<?php } ?>
									</tbody>
								</table>

								<div class="form-group">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="package_price" id="package_price" value="0">
										<input type="hidden" name="package_price" id="fpackage_price" value="0">
										<input type="hidden" name="total_price" id="total_price" value="0">
										<button type="submit" class="btn btn-default"><?php echo __('Next'); ?></button>
									</div>
								</div>
								<?php echo $this->Form->end(); ?>
								<?php if ($roleType == TALANT_ROLEID) { ?>
									<h5>Buy <a href="<?php echo SITE_URL; ?>/package/allpackages/recruiterepackage">Recruiter packages</a> for more visibility and higher response. </h5>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } else { ?>
	<section id="edit_profile">
		<div class="container">
			<h2>Select your <span>posting options</span></h2>
			<div class="row">
				<div class="profile-bg m-top-20">
					<?php $this->Flash->render(); ?>
					<div id="Personal_page" class="tab-pane fade in active">
						<div class="container">
							<div class="prsnl_page_dtl">
								<h5>
									You have reached your total job posting limit. Maximum allowed:
									<b><?php echo $totalLimitJobPost; ?></b>, Currently used:
									<b><?php echo $totalUsedLimit; ?></b>.
									Please <a href="/package/allpackages" style="color: #007bff; text-decoration: underline;">upgrade your package</a>
									or <a href="/myrequirement" style="color: #007bff; text-decoration: underline;">delete/inactivate existing jobs</a>
									to post a new requirement.
								</h5>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

<script>
	$('tr').click(function() {
		$(this).find('td input:radio').prop('checked', true);
	})

	function updatePackagePrice(price) {
		$('#package_price').val(price);
		$('#fpackage_price').val(price);
		$('#total_price').val(price);
	}
</script>