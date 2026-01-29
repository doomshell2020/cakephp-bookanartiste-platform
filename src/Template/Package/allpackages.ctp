<?php
/*
$role_id = $this->request->session()->read('Auth.User');

//$role_id = $this->comman->proff();
$user = $this->comman->proff();
//pr($role_id); die;
$role_id = $user['role_id'];
?>
<section id="col_package">
	<div class="container">
		<h2> <span>Packages</span></h2>
		<p class="m-bott-50">Here You Can See</p>
		<?php echo $this->Flash->render(); ?>
		<div class="row">
			<ul class="nav nav-pills text-center">
				<li class="<?php echo ($package == '' || $package == 'profilepackage') ? 'active' : ''; ?>"><a data-toggle="tab" href="#Profile" class="hvr-bubble-bottom">Profile</a></li>
				<?php /* ?>
				<li class="<?php echo ($package=='requirementpackage')?'active':''; ?>"><a data-toggle="tab" href="#Requirement" class="hvr-bubble-bottom">Requirement</a></li
				<?php  ?>

				<li class="<?php echo ($package == 'recruiterepackage') ? 'active' : ''; ?>"><a data-toggle="tab" href="#Recruiter" class="hvr-bubble-bottom">Recruiter</a></li>
			</ul>
			<div class="col-sm-12" style="color: #088fe8; text-align: center; padding-top: 25px;  margin-bottom: -25px;">

				<?php if ($role_id == 2) {
					// pr($currentpackanme);exit;
				?>

					<?php if ($currentpackanme['PR'] != "Free" && $currentpackanme['RC'] == "Default") { ?>

						<span> <b>Current Membership:</b>
							<?php //echo "You are a " . $currentpackanme['PR'] . " profile member"; 
							?>
							<?php echo "<a href='#'>You are a Free Talent Member</a>"; ?>
						</span>
						<br>
						<!-- <span><b>Expiry Date:</b>
							<?php //echo "Your " . $currentpackanme['PR'] . " profile expires on  " . date("M d,Y", strtotime($currentpackanme[0]));  
							?>
						</span> -->
					<?php } else if ($currentpackanme['PR'] != "Default" && $currentpackanme['PR'] == "Free") { ?>

						<span> <b>Current Membership:</b>
							<?php echo "You are a " . $currentpackanme['RC'] . " recruiter member"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['RC'] . " recruiter expires on  " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } else if ($currentpackanme['PR'] != "Free" && $currentpackanme['PR'] != "Default") { ?>

						<span> <b>Current Membership:</b>
							<?php echo "You are a " . $currentpackanme['PR'] . " profile and " . $currentpackanme['RC'] . " recruiter member"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['PR'] . " profile," . $currentpackanme['RC'] . " recruiter expires on  " . date("M d,Y", strtotime($currentpackanme[0])) . " and " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } ?>


				<?php } else { ?>
					<span> <b>Current Membership:</b> You are a Free Non Talent Member</span>
				<?php } ?>
			</div>
			<div class="tab-content">
				<div id="Profile" class="tab-pane fade in <?php echo ($package == '' || $package == 'profilepackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">


						<?php foreach ($Profilepack as $key => $value) { //pr($value);
							$show_on_package_page = $value['show_on_package_page'];
							// echo $value['show_on_home_page'];
							$show_on_package_page = unserialize($show_on_package_page);
						?>
							<div class="col-sm-4">

								<div class="package silver">
									<h5><?php echo $value['name']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span></span><br>for <?php echo $value['validity_days']; ?> days</small></div>
									<ul class="list-unstyled">
										<?php if (in_array('number_audio', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_audio']; ?></b> Upload Audio </li>
										<?php } ?>
										<?php if (in_array('number_video', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_video']; ?></b> Upload Video</li>
										<?php } ?>
										<?php if (in_array('website_visibility', $show_on_package_page)) { ?>
											<li>Visibility Of Personal Website-<b><?php if ($value['website_visibility'] == 'Y') {
																						echo "Yes";
																					} else {
																						echo "No";
																					} ?></b></li>
										<?php } ?>
										<?php if (in_array('private_individual', $show_on_package_page)) { ?>
											<li><b><?php echo $value['private_individual']; ?></b> Private Messages</li>
										<?php } ?>
										<?php if (in_array('access_job', $show_on_package_page)) { ?>
											<li><b><?php echo $value['access_job']; ?></b> Job Access</li>
										<?php } ?>
										<?php if (in_array('privacy_setting_access', $show_on_package_page)) { ?>
											<li>Privacy Setting Access-<b><?php if ($value['privacy_setting_access'] == 'Y') {
																				echo "Yes";
																			} else {
																				echo "No";
																			} ?></b></li>
										<?php } ?>
										<?php if (in_array('access_to_ads', $show_on_package_page)) { ?>
											<li>Access To Advertise-<b><?php if ($value['access_to_ads'] == 'Y') {
																			echo "Yes";
																		} else {
																			echo "No";
																		} ?></b></li>
										<?php } ?>
										<?php if (in_array('number_job_application', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_job_application']; ?></b> Job Application Per Month</li>
										<?php } ?>
										<?php if (in_array('number_search', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_search']; ?></b> Searches Other Profile</li>
										<?php } ?>
										<?php if (in_array('ads_free', $show_on_package_page)) { ?>
											<li>AD Free Experience-<b><?php if ($value['ads_free'] == 'Y') {
																			echo "Yes";
																		} else {
																			echo "No";
																		} ?></b></li>
										<?php } ?>
										<?php if (in_array('number_albums', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_albums']; ?></b> Photos Albums</li>
										<?php } ?>
										<?php if (in_array('number_of_photo', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_photo']; ?></b> Photos </li>
										<?php } ?>
										<?php if (in_array('number_of_jobs_alerts', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_jobs_alerts']; ?></b> Job Alerts Per Month </li>
										<?php } ?>
										<?php if (in_array('introduction_sent', $show_on_package_page)) { ?>
											<li><b><?php echo $value['introduction_sent']; ?></b> Total No. of Introductions Sent</li>
										<?php } ?>
										<?php if (in_array('number_of_intorduction_send', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_intorduction_send']; ?></b> Total No. of Introductions Sent Per Day</li>
										<?php } ?>
										<?php if (in_array('number_of_introduction', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_introduction']; ?></b> Total No. of Introductions Recieved</li>
										<?php } ?>
										<?php if (in_array('nubmer_of_jobs', $show_on_package_page)) { ?>
											<li><b><?php echo $value['nubmer_of_jobs']; ?></b> Job Posting</li>
										<?php } ?>
										<?php if (in_array('ping_price', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['ping_price']; ?></b> Ask for Quote’ Request Per Job</li>
										<?php } ?>
										<?php if (in_array('introduction_sent', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['introduction_sent']; ?></b> No. of Introduction Send Per Day</li>
										<?php } ?>
										<?php if (in_array('ping_price', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['ping_price']; ?></b> No. of Search Profile</li>
										<?php } ?>
										<?php if (in_array('job_alerts_month', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['job_alerts_month']; ?></b> No. of Jobs Alerts Per Month</li>
										<?php } ?>
										<?php if (in_array('job_alerts', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['job_alerts']; ?></b> No. of Jobs Alerts in Package</li>
										<?php } ?>
										<?php if (in_array('proiorties', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['proiorties']; ?></b> Proiorties</li>
										<?php } ?>
										<?php if (in_array('number_of_free_quote_month', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_free_quote_month']; ?></b> Free Quote Month</li>
										<?php } ?>
										<?php if (in_array('number_of_free_day', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_free_day']; ?></b> Ask for Quote’ Request Per Day</li>
										<?php } ?>
										<?php if (in_array('message_folder', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['message_folder']; ?></b> Message Folder</li>
										<?php } ?>
										<?php if (in_array('number_of_booking', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_booking']; ?></b> Booking Requests Request Per Job</li>
										<?php } ?>
										<?php if (in_array('profile_likes', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['profile_likes']; ?></b> Total No. of Profile Likes Given Per Day</li>
										<?php } ?>
										<?php if (in_array('number_categories', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_categories']; ?></b> Skills</li>
										<?php } ?>
										<?php if (in_array('Visibility_Priority', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['Visibility_Priority']; ?></b> Visibility Priority</li>
										<?php } ?>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">

										</form>
									</div>
									<div class="text-center">

										<?php if ($role_id != 3) { ?>
											<a href="<?php echo SITE_URL; ?>/package/buy/profilepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
										<?php } else { ?>
											<a href="javascript:void(0)" class="btn btn-default">Choose Plan</a>
										<?php } ?>
									</div>
								</div>
							</div>

						<?php } ?>

					</div>
				</div>
				<div id="Requirement" class="tab-pane fade in <?php echo ($package == 'requirementpackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">
						<?php foreach ($RequirementPack as $key => $value) { //pr($value);
						?>
							<div class="col-sm-4">
								<div class="package silver">
									<h5><?php echo $value['name']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span>/</span>Requirement</small></div>
									<ul class="list-unstyled">
										<li>Requirement for <b><?php echo $value['number_of_days']; ?> </b> Days</li>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">
										</form>
									</div>
									<div class="text-center"><a href="<?php echo SITE_URL; ?>/package/buy/requirementpackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div id="Recruiter" class="tab-pane fade in <?php echo ($package == 'recruiterepackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">
						<?php foreach ($RecuriterPack as $key => $value) { //pr($value);
						?>
							<div class="col-sm-4">
								<div class="package silver">
									<h5><?php echo $value['title']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span></span><br>for <?php echo $value['validity_days']; ?> days</small></div>
									<ul class="list-unstyled">
										<li><b><?php echo $value['number_of_job_post']; ?></b> Job post </li>
										<li><b> <?php echo $value['number_of_job_simultancney']; ?></b> Job Simultancney</li>
										<li><b> <?php echo $value['priorites']; ?></b> Job Priorites</li>
										<li><b> <?php echo $value['nubmer_of_site']; ?></b> Website</li>
										<li><b> <?php echo $value['number_of_message']; ?></b> Private Message </li>
										<li><b><?php echo $value['number_of_contact_details']; ?></b> Contact Details </li>
										<li><b><?php echo $value['number_of_talent_search']; ?></b> Talent Search </li>
										<li><b> <?php echo $value['lengthofpackage']; ?></b> Length of Package</li>
										<li><b> <?php echo $value['multiple_email_login']; ?></b> Multiple email login</li>
										<li><b> <?php echo $value['number_of_email']; ?></b> Emails</li>
										<li><b> <?php echo $value['creadit_limit']; ?></b> Credit Limit</li>
										<li><b> <?php echo $value['ping_price']; ?> </b> Ping Price</li>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">
										</form>
									</div>
									<div class="text-center"><a href="<?php echo SITE_URL; ?>/package/buy/recruiterepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
									</div>

								</div>
							</div>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


*/ ?>




<!-- Commpented by Rupam on 10-05-2023  -->

<?php

// $role_id = $this->request->session()->read('Auth.User');
$user = $this->comman->proff();
//pr($role_id); die;
$role_id = $user['role_id'];
// pr($user);exit;
?>
<section id="col_package">
	<div class="container">
		<h2> <span>Packages</span></h2>
		<p class="m-bott-50">Here You Can See</p>
		<?php echo $this->Flash->render(); ?>
		<div class="row">
			<ul class="nav nav-pills text-center">
				<li class="<?php echo ($package == '' || $package == 'profilepackage') ? 'active' : ''; ?>"><a data-toggle="tab" href="#Profile" class="hvr-bubble-bottom">Profile</a></li>
				<?php /* ?>
				<li class="<?php echo ($package=='requirementpackage')?'active':''; ?>"><a data-toggle="tab" href="#Requirement" class="hvr-bubble-bottom">Requirement</a></li
				<?php */ ?>

				<li class="<?php echo ($package == 'recruiterepackage') ? 'active' : ''; ?>"><a data-toggle="tab" href="#Recruiter" class="hvr-bubble-bottom">Recruiter</a></li>
			</ul>
			<div class="col-sm-12 " style="text-align: center; padding-top: 25px;  margin-bottom: -25px;">
				<div class="current-Packages">

					<?php /* if ($role_id == TALANT_ROLEID) { ?>

					<?php if ($currentpackanme['PR'] != "Free" && $currentpackanme['RC'] == "Default") { ?>

						<span> <b>Current Membership:</b>
							<?php echo "<a href='#'>You are a Free Talent Member</a>"; ?>
							<?php echo "and " . $currentpackanme['PR'] . " Profile member";
							?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['PR'] . " Profile expires on  " . date("M d,Y", strtotime($currentpackanme[0]));
							?>
						</span>
					<?php } else if ($currentpackanme['PR'] != "Default" && $currentpackanme['PR'] == "Free") { ?>

						<span> <b>Current Membership:</b>
							<?php echo "You are a " . $currentpackanme['RC'] . " Recruiter member"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['RC'] . " Recruiter expires on  " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } else if ($currentpackanme['PR'] != "Free" && $currentpackanme['PR'] != "Default") { ?>

						<span> <b>Current Membership:</b>
							<?php echo "You are a " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter member"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['PR'] . " Profile," . $currentpackanme['RC'] . " Recruiter expires on  " . date("M d,Y", strtotime($currentpackanme[0])) . " and " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } ?>

				<?php } else { ?>
					<span> <b>Current Membership:</b> You are a Free Non Talent Member</span>

					<?php

					if ($currentpackanme['PR'] == "Default" && $currentpackanme['RC'] == "Default") { ?>

						<span>
							<?php //echo "<a href='#'>You are a Free Talent Member</a>"; 
							?>
							<?php echo "and " . $currentpackanme['PR'] . " Profile Package";
							?>
						</span>
						<br>
						<!-- <span><b>Expiry Date:</b>
							<?php //echo "Your " . $currentpackanme['PR'] . " Profile expires on  " . date("M d,Y", strtotime($currentpackanme[0]));
							?>
						</span> -->

					<?php } else if ($currentpackanme['PR'] != "Free" && $currentpackanme['RC'] == "Default") {  ?>

						<span>
							<?php //echo "<a href='#'>You are a Free Talent Package</a>"; 
							?>
							<?php echo "and " . $currentpackanme['PR'] . " Profile Package";
							?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['PR'] . " Profile expires on  " . date("M d,Y", strtotime($currentpackanme[0]));
							?>
						</span>

					<?php } else if ($currentpackanme['PR'] != "Default" || $currentpackanme['PR'] == "Free") { ?>

						<span>
							<?php echo "You have a " . $currentpackanme['RC'] . " Recruiter Package"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['RC'] . " Recruiter expires on  " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } else if ($currentpackanme['PR'] != "Free" || $currentpackanme['PR'] != "Default") { ?>

						<span>
							<?php echo "You have a " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter Package"; ?>
						</span>
						<br>
						<span><b>Expiry Date:</b>
							<?php echo "Your " . $currentpackanme['PR'] . " Profile," . $currentpackanme['RC'] . " Recruiter Package expires on  " . date("M d,Y", strtotime($currentpackanme[0])) . " and " . date("M d,Y", strtotime($currentpackanme[1]));   ?>
						</span>
					<?php } ?>
				<?php } */ ?>

					<?php
					if ($role_id == TALANT_ROLEID) { ?>

						<?php if ($currentpackanme['PR'] == "Free") { ?>
							<span> <b>Current Membership:</b>
								<?php echo "<a href='#'>You are a Free Talent Member</a>"; ?>
							</span>
							<br>
							<span><b>Expiry Date:</b>
								<?php echo "Your Free Talent Membership is valid until " . $currentpackanme[0]->format('M d, Y'); ?>
							</span>

						<?php } else { ?>
							<span> <b>Current Membership:</b>
								<?php echo "You are a " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter member"; ?>
							</span>
							<br>
							<span><b>Expiry Date:</b>
								<!-- code change packange  -->
								<?php 
								$date1 = new DateTime($currentpackanme[0]);
								$date2 = new DateTime($currentpackanme[1]);

								// Output formatted dates
								echo "Your Talent " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter membership expire on " . $date1->format('M d, Y') . " and " . $date2->format('M d, Y'); ?>
								<!-- end code  -->
							</span>

						<?php } ?>


					<?php } else { ?>

						<!-- <span class=""> <b>Current Membership:</b> <br> You are currently a Non-Talent Member. These profile packages can only be purchased by Talent Members. To upgrade, edit your profile and select your talent to become a Talent Member Only then can you purchase profile packages.</span> -->

						<span class="">
							<b>Current Membership:</b> <br>
							You are currently a Non-Talent Member. These profile packages are available only to Talent Members. To upgrade, edit your profile and select a talent to become a Talent Member. Only then will you be able to purchase profile packages.
						</span>


						<?php
						// pr($currentpackanme);exit;
						if ($currentpackanme['PR'] == "Default" && $currentpackanme['RC'] == "Default") { ?>
							<span>
								<?php echo "and " . $currentpackanme['PR'] . " Profile Package"; ?>
							</span>
							<br>

						<?php } else if ($currentpackanme['PR'] != "Free" && $currentpackanme['RC'] == "Default") {  ?>
							<span>
								<?php echo "and " . $currentpackanme['PR'] . " Profile Package"; ?>
							</span>
							<br>
							<span><b>Expiry Date:</b>
								<?php echo "Your " . $currentpackanme['PR'] . " Profile expires on " . $currentpackanme[0]->format('M d, Y'); ?>
							</span>

						<?php } else if ($currentpackanme['PR'] == "Default" && $currentpackanme['RC'] != "Default") { ?>
							<span>
								<?php echo "You have a " . $currentpackanme['RC'] . " Recruiter Package"; ?>
							</span>
							<br>
							<span><b>Expiry Date:</b>
								<?php echo "You have a " . $currentpackanme['RC'] . " Recruiter Package"; ?>
							</span>

						<?php } else if ($currentpackanme['PR'] != "Free" && $currentpackanme['RC'] != "Default") { ?>
							<span>
								<?php echo "You have a " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter Package"; ?>
							</span>
							<br>
							<span>
								<b>Expiry Date:</b>
								<?php
								if ($currentpackanme[0] && $currentpackanme[1]) {
									echo "Your " . $currentpackanme['PR'] . " Profile and " . $currentpackanme['RC'] . " Recruiter membership expire on " . $currentpackanme[0]->format('M d, Y') . " and " . $currentpackanme[1]->format('M d, Y');
								}
								?>
							</span>


						<?php } ?>
					<?php } ?>

				</div>
			</div>
			<div class="tab-content">
				<div id="Profile" class="tab-pane fade in <?php echo ($package == '' || $package == 'profilepackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">


						<?php foreach ($Profilepack as $key => $value) { //pr($value);
							$show_on_package_page = $value['show_on_package_page'];
							// echo $value['show_on_home_page'];
							$show_on_package_page = unserialize($show_on_package_page);
							// pr($show_on_package_page);exit;
						?>
							<div class="col-sm-4">

								<div class="package silver">
									<h5><?php echo $value['name']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span></span><br>for <?php echo $value['validity_days']; ?> days</small></div>
									<ul class="list-unstyled">
										<?php if (in_array('number_audio', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_audio']; ?></b> Upload Audio </li>
										<?php } ?>
										<?php if (in_array('number_video', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_video']; ?></b> Upload Video</li>
										<?php } ?>
										<?php if (in_array('website_visibility', $show_on_package_page)) { ?>
											<li>Visibility Of Personal Website-<b><?php if ($value['website_visibility'] == 'Y') {
																						echo "Yes";
																					} else {
																						echo "No";
																					} ?></b></li>
										<?php } ?>
										<?php if (in_array('private_individual', $show_on_package_page)) { ?>
											<li><b><?php echo $value['private_individual']; ?></b> Private Messages</li>
										<?php } ?>
										<?php if (in_array('access_job', $show_on_package_page)) { ?>
											<li><b><?php echo $value['access_job']; ?></b> Job Access</li>
										<?php } ?>
										<?php if (in_array('privacy_setting_access', $show_on_package_page)) { ?>
											<li>Privacy Setting Access-<b><?php if ($value['privacy_setting_access'] == 'Y') {
																				echo "Yes";
																			} else {
																				echo "No";
																			} ?></b></li>
										<?php } ?>
										<?php if (in_array('access_to_ads', $show_on_package_page)) { ?>
											<li>Access To Advertise-<b><?php if ($value['access_to_ads'] == 'Y') {
																			echo "Yes";
																		} else {
																			echo "No";
																		} ?></b></li>
										<?php } ?>
										<?php if (in_array('number_of_application_day', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_application_day']; ?></b> Job Application Daily</li>
										<?php } ?>

										<?php if (in_array('number_job_application', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_job_application']; ?></b> Job Application Per Month</li>
										<?php } ?>

										<?php if (in_array('number_search', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_search']; ?></b> Searches Other Profile</li>
										<?php } ?>
										<?php if (in_array('ads_free', $show_on_package_page)) { ?>
											<li>AD Free Experience-<b><?php if ($value['ads_free'] == 'Y') {
																			echo "Yes";
																		} else {
																			echo "No";
																		} ?></b></li>
										<?php } ?>
										<?php if (in_array('number_albums', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_albums']; ?></b> Photos Albums</li>
										<?php } ?>
										<?php if (in_array('number_of_photo', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_photo']; ?></b> Photos </li>
										<?php } ?>
										<?php if (in_array('number_of_jobs_alerts', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_jobs_alerts']; ?></b> Job Alerts Per Month </li>
										<?php } ?>
										<?php if (in_array('introduction_sent', $show_on_package_page)) { ?>
											<li><b><?php echo $value['introduction_sent']; ?></b> Total No. of Introductions Sent</li>
										<?php } ?>
										<?php if (in_array('number_of_intorduction_send', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_intorduction_send']; ?></b> Total No. of Introductions Sent Per Day</li>
										<?php } ?>
										<?php if (in_array('number_of_introduction', $show_on_package_page)) { ?>
											<li><b><?php echo $value['number_of_introduction_recived']; ?></b> Total No. of Introductions Received</li>
										<?php } ?>
										<?php if (in_array('nubmer_of_jobs', $show_on_package_page)) { ?>
											<li><b><?php echo $value['nubmer_of_jobs']; ?></b> Job Posting</li>
										<?php } ?>
										<?php if (in_array('ping_price', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['ping_price']; ?></b> Ask for Quote’ Request Per Job</li>
										<?php } ?>
										<?php if (in_array('introduction_sent', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['introduction_sent']; ?></b> No. of Introduction Send Per Day</li>
										<?php } ?>
										<?php if (in_array('ping_price', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['ping_price']; ?></b> No. of Search Profile</li>
										<?php } ?>
										<?php if (in_array('job_alerts_month', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['job_alerts_month']; ?></b> No. of Jobs Alerts Per Month</li>
										<?php } ?>
										<?php if (in_array('job_alerts', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['job_alerts']; ?></b> No. of Jobs Alerts in Package</li>
										<?php } ?>
										<?php if (in_array('proiorties', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['proiorties']; ?></b> Proiorties</li>
										<?php } ?>
										<?php if (in_array('number_of_free_quote_month', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_free_quote_month']; ?></b> Free Quote Month</li>
										<?php } ?>
										<?php if (in_array('number_of_free_day', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_free_day']; ?></b> Ask for Quote’ Request Per Day</li>
										<?php } ?>
										<?php if (in_array('message_folder', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['message_folder']; ?></b> Message Folder</li>
										<?php } ?>
										<?php if (in_array('number_of_booking', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_of_booking']; ?></b> Booking Requests Request Per Job</li>
										<?php } ?>
										<?php if (in_array('profile_likes', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['profile_likes']; ?></b> Total No. of Profile Likes Given Per Day</li>
										<?php } ?>
										<?php if (in_array('number_categories', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['number_categories']; ?></b> Skills</li>
										<?php } ?>
										<?php if (in_array('Visibility_Priority', $show_on_package_page)) { ?>
											<li><b> <?php echo $value['Visibility_Priority']; ?></b> Visibility Priority</li>
										<?php } ?>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">

										</form>
									</div>
									<div class="text-center">

										<?php if ($role_id == TALANT_ROLEID) { ?>
											<a href="<?php echo SITE_URL; ?>/package/buy/profilepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
										<?php } else { ?>
											<a href="javascript:void(0)"
											onclick="return alert('You are not allowed to buy this package. You need to become a Talent Member to purchase it. Please update your profile and select a talent to upgrade your membership.')"
											class="btn btn-default">Choose Plan</a>
										<?php } ?>
									</div>
								</div>
							</div>

						<?php } ?>

					</div>
				</div>
				<div id="Requirement" class="tab-pane fade in <?php echo ($package == 'requirementpackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">
						<?php foreach ($RequirementPack as $key => $value) { //pr($value);die;
						?>
							<div class="col-sm-4">
								<div class="package silver">
									<h5><?php echo $value['name']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span>/</span>Requirement</small></div>
									<ul class="list-unstyled">
										<li>Requirement for <b><?php echo $value['number_of_days']; ?> </b> Days</li>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">
										</form>
									</div>
									<div class="text-center">
										<a href="<?php echo SITE_URL; ?>/package/buy/requirementpackage/<?php echo $value['id']; ?>"
										class="btn btn-default">Choose Plan</a>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div id="Recruiter" class="tab-pane fade in <?php echo ($package == 'recruiterepackage') ? 'active' : ''; ?>">
					<div class="col-sm-12 clearfix m-top-60">
						<?php foreach ($RecuriterPack as $key => $value) { //pr($value);
						?>
							<div class="col-sm-4">
								<div class="package silver">
									<h5><?php echo $value['title']; ?> Package</h5>
									<div style="text-align:center;"> <strong><?php echo $value['packagetext']; ?></strong></div>
									<div class="price"><?php echo "$" . $value['price'] . ".00"; ?><small><span></span><br>for <?php echo $value['validity_days']; ?> days</small></div>
									<ul class="list-unstyled">
										<li><b><?php echo $value['number_of_job_post']; ?></b> Job post </li>
										<li><b> <?php echo $value['number_of_job_simultancney']; ?></b> Job Simultancney</li>
										<li><b> <?php echo $value['priorites']; ?></b> Job Priorites</li>
										<li><b> <?php echo $value['nubmer_of_site']; ?></b> Website</li>
										<li><b> <?php echo $value['number_of_message']; ?></b> Private Message </li>
										<li><b><?php echo $value['number_of_contact_details']; ?></b> Contact Details </li>
										<li><b><?php echo $value['number_of_talent_search']; ?></b> Talent Search </li>
										<li><b> <?php echo $value['lengthofpackage']; ?></b> Length of Package</li>
										<li><b> <?php echo $value['multiple_email_login']; ?></b> Multiple email login</li>
										<li><b> <?php echo $value['number_of_email']; ?></b> Emails</li>
										<li><b> <?php echo $value['creadit_limit']; ?></b> Credit Limit</li>
										<li><b> <?php echo $value['ping_price']; ?> </b> Ping Price</li>
									</ul>
									<div class="text-center">
										<form class="form-horizontal">
										</form>
									</div>

									<div class="text-center">

										<!-- <a href="<?php echo SITE_URL; ?>/package/buy/recruiterepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a> -->

										<?php if ($role_id == TALANT_ROLEID) { ?>
											<a href="<?php echo SITE_URL; ?>/package/buy/recruiterepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
										<?php } else { ?>
											<a href="javascript:void(0)"
												onclick="return alert('You are not allowed to buy this package. You need to become a Talent Member to purchase it. Please update your profile and select a talent to upgrade your membership.')"
												class="btn btn-default">Choose Plan
											</a>
										<?php } ?>

									</div>

								</div>
							</div>

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>