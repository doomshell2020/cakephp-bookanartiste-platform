<!----------------------editprofile-strt------------------------>
<section id="edit_profile">
	<div class="container">
		<h2>Professional<span> Summary</span></h2>
		<p class="m-bott-50">Here You Can Manage Your Professional Summary</p>
		<div class="row">
			<?php echo  $this->element('editprofile') ?>

			<div class="tab-content">
				<div class="profile-bg m-top-20">
					<?php echo $this->Flash->render(); ?>
					<div id="Pro-Summary" class="">
						<div class="container m-top-60">
							<?php echo $this->Form->create($proff, array('url' => array('controller' => 'profile', 'action' => 'professionalsummary'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
							<?php  // pr($proff); 
							?>
							<?php /* ?>
								<div class="form-group">
								<label for="" class="col-sm-2 control-label">Profile Title</label>
								<div class="col-sm-6">
								<?php echo $this->Form->input('profile_title',array('class'=>'form-control','placeholder'=>'Profile Title', 'id'=>'name','label' =>false)); ?>	
								</div>
								<div class="col-sm-4"></div>
								</div>
								<?php */ ?>

							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Performing Since Month:</label>
								<?php
								// set the month array
								$formattedMonthArray = array(
									"1" => "January",
									"2" => "February",
									"3" => "March",
									"4" => "April",
									"5" => "May",
									"6" => "June",
									"7" => "July",
									"8" => "August",
									"9" => "September",
									"10" => "October",
									"11" => "November",
									"12" => "December",
								); ?>
								<div class="col-sm-2">
									<?php echo $this->Form->input('performing_month', array('class' => 'form-control', 'label' => false, 'empty' => '--Select Month--', 'options' => $formattedMonthArray)); ?>

								</div>
								<label for="" class="col-sm-1 control-label">Year:</label>
								<div class="col-sm-3">
									<?php $userdob = date('Y', strtotime($profile['dob']));
									$yearArray = range($userdob, date("Y"));
									?>
									<select name="performing_year" class="form-control">
										<option value="">--Select Year--</option>
										<?php
										foreach ($yearArray as $year) {
											// if you want to select a particular year
											$selected = ($year == $proff['performing_year']) ? 'selected' : '';
											echo '<option ' . $selected . ' value="' . $year . '">' . $year . '</option>';
										}
										?>
									</select>
								</div>
								<div class="col-sm-4"></div>
							</div>



							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Are You A :</label>
								<?php $gen = array('P' => 'Professional', 'A' => 'Amateur', 'PT' => 'Part time', 'H' => 'Hobbyist'); ?>
								<div class="col-sm-10 col-xs-12">
									<?php echo $this->Form->input('areyoua', array('class' => '', 'id' => 'gender', 'type' => 'radio', 'options' => $gen, 'label' => false, 'legend' => false, 'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'])); ?>
								</div>
								<div class="col-sm-4"></div>
							</div>

							<!-- <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Profile Title :</label>
                                <div class="col-sm-10">

                                    ?php echo $this->Form->input('profiletitle', array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'altemail', 'label' => false, 'type' => 'text', 'readonly' => 'readonly' ,'value' => $profile['profiletitle'] )); ?>
                                </div>
                            </div> -->

							<div class="form-group">
								<label for="" class="col-sm-12 control-label">Currently Working At:</label>
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<div class="table-responsive">
										<div class="multi-field-wrapperpayment">

											<div class="table table-bordered">
												<div class="tab_header">
													<ul class="tab_hade_menu">
														<li>Where</li>
														<li>Page link</li>
														<li>Role</li>
														<li>Location</li>
														<li>Date From</li>
													</ul>
												</div>

												<div class="payment_container">
													<?php if (count($currentworking) > 0) {
														// pr($currentworking);exit;
														$currentexpcounter = 1;
														foreach ($currentworking as $current) {
															//pr($currentworking);
													?>
															<div class="removecurrentworking">
																<ul class="payment_details">
																	<li>
																		<?php echo $this->Form->input('name', array('value' => $current['name'], 'class' => 'form-control', 'placeholder' => 'Where', 'id' => '', 'label' => false, 'name' => 'current[name][]', 'type' => 'text')); ?>
																		<input type="hidden" value="<?php echo $current['id'] ?>" name="current[hid][]" id="<?php echo $currentexpcounter; ?>" class="ccounter" />
																	</li>

																	<li>
																		<?php
																		// echo $this->Form->input('bookenartist', array(
																		// 	'value' => $current['bookenartist'],
																		// 	'class' => 'form-control',
																		// 	'placeholder' => 'Bookanartiste link',
																		// 	'label' => false,
																		// 	'name' => 'current[bookenartist][]',
																		// 	'type' => 'url',
																		// 	'pattern' => '^(https?:\/\/www\.bookanartiste\.com\/.+)$',
																		// 	'oninvalid' => "this.setCustomValidity('URL should start with http://www.bookanartiste.com or https://www.bookanartiste.com')",
																		// 	"oninput" => "setCustomValidity('')"
																		// )); 

																		echo $this->Form->input('bookenartist', array(
																			'value' => $current['bookenartist'],
																			'class' => 'form-control',
																			'placeholder' => 'Bookanartiste link',
																			'label' => false,
																			'name' => 'current[bookenartist][]',
																			'type' => 'text'
																		));

																		?>


																	</li>
																	<li><?php echo $this->Form->input('role', array('value' => $current['role'], 'class' => 'form-control', 'placeholder' => 'Role', 'id' => '', 'label' => false, 'name' => 'current[role][]',)); ?>
																	</li>
																	<li><?php echo $this->Form->input('location', array('value' => $current['location'], 'class' => 'form-control', 'placeholder' => 'Location', 'id' => '', 'label' => false, 'name' => 'current[location][]')); ?>
																	</li>

																	<li class="date-frm">
																		<?php $cfromdate = date('Y-m', strtotime($current['date_from'])); ?>
																		<?php
																		//echo $this->Form->input('date_from', array('value' => $cfromdate, 'class' => 'form-control cdate_from monthpicker', 'placeholder' => 'Date From', 'id' => $currentexpcounter, 'label' => false, 'name' => 'current[date_from][]', 'type' => 'text')); 
																		?>

																		<input type="month" value="<?php echo $cfromdate; ?>" class="form-control" name="current[date_from][]" placeholder="Date From">
																	</li>
																</ul>

																<ul class="payment_details_desc pmnt_dtln_btn">
																	<li><?php echo $this->Form->input('description', array('value' => $current['description'], 'class' => 'form-control', 'placeholder' => 'Description', 'id' => '', 'label' => false, 'name' => 'current[description][]', 'type' => 'textarea')); ?></li>
																	<li>
																		<a href="javascript:void(0);" class="delete_paymentcurrent btn remove-field btn-danger btn-block" data-val="<?php echo $current['id'] ?>"><i class="fa fa-remove"></i> Delete</a>
																	</li>
																</ul>
															</div>
														<?php
															$currentexpcounter++;
														}
													} else { ?>
														<div class="removecurrentworking">
															<ul class="payment_details">

																<li><?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name', 'id' => '', 'label' => false, 'empty' => '--Select Payment Frequency--', 'options' => $pay_freq, 'name' => 'current[name][]', 'type' => 'text')); ?>
																	<input type="hidden" value="<?php echo $current['id'] ?>" name="current[hid][]" id="1" class="ccounter" />
																</li>

																<li>
																	<?php //echo $this->Form->input('bookenartist', array('class' => 'form-control', 'placeholder' => 'Bookanartiste link', 'id' => '', 'label' => false, 'empty' => '--Select Payment Frequency--', 'options' => $pay_freq, 'name' => 'current[bookenartist][]', 'type' => 'url', 'pattern' => 'http://www\.bookanartiste\.com\/(.+)|https://www\.bookanartiste\.com\/(.+)',  'oninvalid' => "this.setCustomValidity('URL should start from http://www.bookanartiste.com')", "oninput" => "setCustomValidity('')")); 
																	?>

																	<?php echo $this->Form->input('bookenartist', array(
																		'class' => 'form-control',
																		'placeholder' => 'Bookanartiste link',
																		'label' => false,
																		'name' => 'current[bookenartist][]',
																		'type' => 'text'
																	)); ?>

																</li>

																<li><?php echo $this->Form->input('role', array('class' => 'form-control', 'placeholder' => 'Role', 'id' => '', 'label' => false, 'name' => 'current[role][]',)); ?>
																</li>

																<li><?php echo $this->Form->input('location', array('class' => 'form-control', 'placeholder' => 'Location', 'id' => '', 'label' => false, 'name' => 'current[location][]')); ?>
																</li>

																<li> <?php
																		//echo $this->Form->input('date_from', array('value' => '', 'class' => 'form-control cdate_from monthpicker', 'placeholder' => 'Date From', 'id' => '1', 'label' => false, 'name' => 'current[date_from][]', 'type' => 'text')); 
																		?>
																	<input type="month" class="form-control" name="current[date_from][]" placeholder="Date From">

																</li>

															</ul>
															<ul class="payment_details_desc pmnt_dtln_btn">
																<li><?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'Description', 'id' => '', 'label' => false, 'name' => 'current[description][]', 'type' => 'textarea')); ?></li>
																<li><a href="javascript:void(0);" class="delete_paymentcurrent btn remove-field btn-danger btn-block" data-val="<?php echo $current['id'] ?>"><i class="fa fa-remove"></i> Delete</a></li>

															</ul>
														</div>
													<?php } ?>
												</div>
												<div>
													<ul class="tab_foot_btn_add">
														<li style="text-align:right"><a type="button" class="btn-primary add-paymentfield pull-right">Add </a></li>

													</ul>


												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-12 control-label">Earlier Experience:</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="table-responsive">
										<div class="multi-field-wrapperdesc">

											<div class="table table-bordered">
												<div>
													<ul class="tab_hade_menu_2">
														<li>Where</li>
														<li>Page link</li>
														<li>Role</li>
														<li>Location</li>
														<li>Date From</li>
														<li>Date To</li>
													</ul>
												</div>

												<div class="payment_containerdesc">
													<?php if (count($profexp) > 0) { ?>
														<?php
														$expcounter = 1;
														foreach ($profexp as $profexperience) { //pr($profexperience);
														?>
															<div class="removeexperienceworking">
																<ul class="payment_detailsdesc">

																	<li><?php echo $this->Form->input('name', array('value' => $profexperience['name'], 'class' => 'form-control', 'placeholder' => 'Where', 'id' => '', 'label' => false, 'name' => 'exp[name][]', 'type' => 'text')); ?>
																		<input type="hidden" value="<?php echo $profexperience['id'] ?>" name="exp[hid][]" id="<?php echo $expcounter; ?>" class="ecounter" />
																	</li>


																	<li><?php echo $this->Form->input('bookenartist', array('value' => $profexperience['bookenartist'], 'class' => 'form-control', 'placeholder' => 'Bookanartiste link', 'id' => '', 'label' => false, 'name' => 'exp[bookenartist][]')); ?>

																	</li>

																	<li><?php echo $this->Form->input('role', array('value' => $profexperience['role'], 'class' => 'form-control', 'placeholder' => 'Role', 'id' => '', 'label' => false, 'name' => 'exp[role][]',)); ?>
																	</li>

																	<li><?php echo $this->Form->input('location', array('value' => $profexperience['location'], 'class' => 'form-control', 'placeholder' => 'Location', 'id' => '', 'label' => false, 'name' => 'exp[location][]')); ?>
																	</li>

																	<?php $fefromdate = date('Y-m', strtotime($profexperience['from_date'])); ?>
																	<?php $tefromdate = date('Y-m', strtotime($profexperience['to_date'])); ?>

																	<!-- <li class="date-frm">
																		<?php //echo $this->Form->input('date_from', array('value' => (!empty($profexperience['from_date'])) ? $fefromdate : '', 'class' => 'form-control  edate_from monthpicker', 'placeholder' => 'From', 'id' => $expcounter, 'label' => false, 'name' => 'exp[date_from][]', 'type' => 'text')); 
																		?>
																	</li>

																	<li class="date-frm"> <?php //echo $this->Form->input('date_to', array('value' => (!empty($profexperience['from_date'])) ? $tefromdate : '', 'class' => 'form-control  edate_to monthpicker', 'placeholder' => 'To', 'id' => $expcounter, 'label' => false, 'name' => 'exp[date_to][]', 'type' => 'text')); 
																							?>
																	</li> -->

																	<li class="date-frm">
																		<input type="month"
																			class="form-control"
																			name="exp[date_from][]"
																			value="<?= $fefromdate; ?>"
																			data-id="<?= $expcounter; ?>"
																			onchange="updateToMonth(this)">
																	</li>

																	<li class="date-frm">
																		<input type="month"
																			class="form-control"
																			name="exp[date_to][]"
																			value="<?= $tefromdate; ?>"
																			data-id="<?= $expcounter; ?>">
																	</li>


																</ul>
																<ul class="payment_details_desc pmnt_dtln_btn">
																	<li><?php echo $this->Form->input('description', array('value' => $profexperience['description'], 'class' => 'form-control', 'placeholder' => 'Description', 'id' => '', 'label' => false, 'name' => 'exp[description][]', 'type' => 'textarea')); ?></li>
																	<li>
																		<a href="javascript:void(0);" class="earlierexp btn remove-field btn-danger btn-block" data-val="<?php echo $profexperience['id'] ?>"><i class="fa fa-remove"></i> Delete</a>
																	</li>

																</ul>
															</div>
														<?php
															$expcounter++;
														}
													} else { ?>
														<div class="removeexperienceworking">
															<ul class="payment_detailsdesc">
																<li><?php echo $this->Form->input('name', array('value' => $profexperience['name'], 'class' => 'form-control', 'placeholder' => 'Name', 'id' => '', 'label' => false, 'name' => 'exp[name][]', 'type' => 'text')); ?>
																	<input type="hidden" value="<?php echo $profexperience['id'] ?>" name="exp[hid][]" id="1" class="ecounter" />
																</li>
																<li><?php echo $this->Form->input('bookenartist', array('value' => $profexperience['bookenartist'], 'class' => 'form-control', 'placeholder' => 'Bookanartiste link', 'id' => '', 'label' => false, 'name' => 'exp[bookenartist][]', 'type' => 'text')); ?>
																</li>
																<li><?php echo $this->Form->input('role', array('value' => $profexperience['role'], 'class' => 'form-control', 'placeholder' => 'Role', 'id' => '', 'label' => false, 'name' => 'exp[role][]',)); ?>
																</li>
																<li><?php echo $this->Form->input('location', array('value' => $profexperience['location'], 'class' => 'form-control', 'placeholder' => 'Location', 'id' => '', 'label' => false, 'name' => 'exp[location][]')); ?>
																</li>


																<?php
																// $fefromdate = date('Y-m', strtotime($profexperience['from_date'])); 
																?>
																<!-- <li class="date-frm"> 
																	<?php
																	echo $this->Form->input('date_from', array('class' => 'form-control  edate_from monthpicker', 'placeholder' => 'From', 'label' => false, 'name' => 'exp[date_from][]', 'type' => 'text'));
																	?>
																</li>
																<?php
																// $tefromdate = date('Y-m', strtotime($profexperience['to_date'])); 
																?>
																<li class="date-frm"> 
																	<?php
																	echo $this->Form->input('date_to', array('class' => 'form-control  edate_to monthpicker', 'placeholder' => 'To', 'label' => false, 'name' => 'exp[date_to][]', 'type' => 'text'));
																	?>
																</li> -->

																<?php
																// $fefromdate = date('Y-m', strtotime($profexperience['from_date']));
																// $tefromdate = date('Y-m', strtotime($profexperience['to_date']));
																?>

																<li class="date-frm">
																	<input type="month"
																		class="form-control datepeakervalidation"
																		name="exp[date_from][]"
																		data-id="100"
																		onchange="updateToMonth(this)">
																</li>

																<li class="date-frm">
																	<input type="month"
																		class="form-control"
																		name="exp[date_to][]"
																		data-id="100">
																</li>

															</ul>
															<ul class="payment_details_desc pmnt_dtln_btn">
																<li><?php echo $this->Form->input('description', array('value' => $profexperience['description'], 'class' => 'form-control', 'placeholder' => 'Description', 'label' => false, 'name' => 'exp[description][]', 'type' => 'textarea')); ?></li>
																<li><a href="javascript:void(0);" class="earlierexp btn remove-field btn-danger btn-block" data-val="<?php echo $profexperience['id'] ?>"><i class="fa fa-remove"></i> Delete</a></li>

															</ul>
														</div>
													<?php } ?>
												</div>
												<div>
													<ul class="tab_foot_btn_add">
														<li colspan="12" style="text-align:right"><a type="button" class="btn-primary add-paymentfielddesc pull-right">Add </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<script>
								// function updateToMonth(id) {
								// 	var fromMonth = document.querySelector(`[name="exp[date_from][]"][data-id="${id}"]`).value;
								// 	var toMonth = document.querySelector(`[name="exp[date_to][]"][data-id="${id}"]`);
								// 	if (fromMonth) {
								// 		toMonth.min = fromMonth;
								// 	}
								// }

								function updateToMonth(event) {
									let fromDateInput = event;
									let fromDateValue = fromDateInput.value;
									let toDateInput = fromDateInput.closest('li').nextElementSibling?.querySelector('input[name="exp[date_to][]"]');
									if (toDateInput) {
										toDateInput.min = fromDateValue;
									}
								}
							</script>


							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Agency Name :</label>
								<div class="col-sm-6">
									<?php echo $this->Form->input('agency_name', array('class' => 'form-control', 'placeholder' => 'Agency Name', 'label' => false)); ?>

								</div>
								<div class="col-sm-4"></div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Talent Manager Name :</label>
								<div class="col-sm-6">
									<?php echo $this->Form->input('talent_manager', array('class' => 'form-control', 'placeholder' => 'Talent Manager Name', 'label' => false)); ?>
								</div>
								<div class="col-sm-4"></div>
							</div>


							<?php
							$currentpackage = $this->Comman->currentprpackv1();
							// pr($currentpackage);exit;

							if ($currentpackage['website_visibility'] == 'Y') { ?>
								<div class="form-group">

									<label for="" class="col-sm-12 control-label">Website Portfolio:</label>

								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="table-responsive">
											<div class="multi-field-wrapper">
												<?php $typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog'); ?>
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>URL</th>
															<th>Type</th>
															<th></th>

														</tr>
													</thead>

													<tbody class="video_container">
														<?php if (count($videoprofile) > 0) { ?>
															<?php foreach ($videoprofile as $prop) { //pr($prop);
															?>
																<tr class="video_details">

																	<td> <?php echo $this->Form->input('weblink', array('value' => $prop['web_link'], 'class' => 'form-control', 'placeholder' => 'URL', 'id' => 'name', 'type' => 'text', 'label' => false, 'name' => 'data[weblink][]')); ?>
																		<input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]" />
																	</td>
																	<td><?php echo $this->Form->input('webtype', array('value' => $prop['web_type'], 'class' => 'form-control', 'placeholder' => 'State', 'id' => '', 'label' => false, 'empty' => '--Select Type--', 'options' => $typ, 'selected' => 'selected', 'name' => 'data[webtype][]')); ?></td>

																	<td class="text-right"><a href="javascript:void(0);" class="delete_detials btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a></td>

																</tr>
															<?php }
														} else { ?>


															<tr class="video_details">

																<td> <?php echo $this->Form->input('weblink', array('class' => 'form-control', 'placeholder' => 'URL', 'id' => 'name', 'type' => 'text', 'label' => false, 'name' => 'data[weblink][]')); ?>
																	<input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]" />
																</td>
																<td><?php echo $this->Form->input('webtype', array('class' => 'form-control', 'placeholder' => 'State', 'id' => '', 'label' => false, 'empty' => '--Select Type--', 'options' => $typ, 'selected' => 'selected', 'name' => 'data[webtype][]')); ?></td>

																<td class="text-right"><a href="javascript:void(0);" class="delete_detials btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a></td>

															</tr>
														<?php } ?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="7" style="text-align:right"><a class="btn-primary add-field pull-right">Add </a></td>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
									<div class="col-sm-4"></div>
								</div>

							<?php } ?>

							<?php //if ($skillofcontaint) { 
							?>
							<div class="form-group">
								<label for="" class="col-sm-12 control-label">Manage Talent Portfolio:</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="table-responsive">
										<div class="multi-field-wrappertalentport">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Talent Name</th>
														<th>URL</th>
														<th></th>
													</tr>
												</thead>
												<tbody class="video_containertalentport">
													<?php if (count($videoprofiletalentpro) > 0) { ?>
														<?php foreach ($videoprofiletalentpro as $proptalent) { //pr($prop);
														?>
															<tr class="video_detailstalentport">

																<td> <?php echo $this->Form->input('name', array('value' => $proptalent['name'], 'class' => 'form-control', 'placeholder' => 'Name of artiste managed by you', 'id' => 'name', 'label' => false, 'name' => 'datatalentport[talentport][]')); ?>
																	<input type="hidden" value="<?php echo $proptalent['id'] ?>" name="datatalentport[hid][]" />
																</td>
																</td>

																<td> <?php echo $this->Form->input('url', array(
																			'value' => $proptalent['url'],
																			'class' => 'form-control',
																			'placeholder' => 'Bookanartiste link',
																			'id' => 'url',
																			'type' => 'text',
																			'label' => false,
																			'name' => 'datatalentport[talentporturl][]',
																			'pattern' => 'http://www\.bookanartiste\.com\/(.+)|https://www\.bookanartiste\.com\/(.+)',
																			'oninvalid' => "this.setCustomValidity('URL should start from http://www.bookanartiste.com')",
																			"oninput" => "setCustomValidity('')"
																		)); ?></td>
																<td>
																	<a href="javascript:void(0);" class="deletepersonaltalentpro btn remove-fieldtalentport btn-danger btn-block" data-val="<?php echo $proptalent['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

																	<!--<button type="button" onclick="delete_detials(<?php //echo $prop['id'] 
																														?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>-->

																</td>

															</tr>
														<?php }
													} else { ?>
														<tr class="video_detailstalentport">

															<td> <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name of artiste managed by you', 'id' => 'name', 'label' => false, 'name' => 'datatalentport[talentport][]')); ?>
															</td>

															<td> <?php echo $this->Form->input('url', array(
																		'class' => 'form-control',
																		'placeholder' => 'bookanartiste link',
																		'id' => 'url',
																		'type' => 'text',
																		'label' => false,
																		'name' => 'datatalentport[talentporturl][]',
																		'pattern' => 'http://www\.bookanartiste\.com\/(.+)|https://www\.bookanartiste\.com\/(.+)',
																		'oninvalid' => "this.setCustomValidity('URL should start from http://www.bookanartiste.com')",
																		"oninput" => "setCustomValidity('')"
																	)); ?></td>

															<td>
																<a href="javascript:void(0);" class="deletepersonaltalentpro btn remove-fieldtalentport btn-danger btn-block" data-val="<?php echo $proptalent['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

															</td>
														</tr>

													<?php } ?>

												</tbody>


												<tfoot>
													<tr>
														<td colspan="7" style="text-align:right"><a type="button" class="btn-primary add-fieldtalentport pull-right">Add </a></td>

													</tr>


												</tfoot>
											</table>
										</div>

									</div>
								</div>
								<div class="col-sm-4"></div>
							</div>

							<?php //} 
							?>

							<?php // Start Manage Talent portfolio 
							?>
							<script>
								$('.multi-field-wrappertalentport').each(function() {
									var $wrapper = $('.video_containertalentport', this);
									$(".add-fieldtalentport", $(this)).click(function(e) { //alert(e);
										var manageporttalentport = $('.video_detailstalentport:first-child', $wrapper).clone(true).appendTo($wrapper)
										manageporttalentport.find('input').val('').focus();
										manageporttalentport.find('[data-val]').attr("data-val", '');
									});
									$('.remove-fieldtalentport', $wrapper).click(function() {
										if ($('.video_detailstalentport', $wrapper).length > 1)
											$(this).closest('.video_detailstalentport').remove();
									});
								});

								$('.deletepersonaltalentpro').click(function() { //alert();
									paymentcurrent_id = $(this).data('val');
									$.ajax({
										type: "post",
										url: site_url + 'profile/deletepersonneltalentpro',
										data: {
											datadd: paymentcurrent_id
										},

										success: function(data) {}
									});
								});
							</script>

							<?php // End Manage Talent portfolio 
							?>


							<?php //if ($contentadminskillsetpersonnel) { 
							?>
							<div class="form-group">

								<label for="" class="col-sm-12 control-label">Personnel Details:</label>

							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="table-responsive">
										<div class="multi-field-wrapperpersonneldet">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Talent Name</th>
														<th>URL</th>
														<th></th>
													</tr>
												</thead>
												<tbody class="video_containerpersonneldet">
													<?php if (count($videoprofilepersoneeldet) > 0) { ?>
														<?php foreach ($videoprofilepersoneeldet as $proppersonal) { //pr($prop);
														?>
															<tr class="video_detailspersonneldet">

																<td> <?php echo $this->Form->input('name', array('value' => $proppersonal['name'], 'class' => 'form-control', 'placeholder' => 'Member of band, group, team', 'id' => 'name', 'label' => false, 'name' => 'datapersonneldet[personaldetname][]')); ?>
																	<input type="hidden" value="<?php echo $proppersonal['id'] ?>" name="datapersonneldet[hid][]" />
																</td>
																</td>

																<td>
																	<?php
																	echo $this->Form->input('url', [
																		'value' => $proppersonal['url'],
																		'class' => 'form-control',
																		'name' => 'datapersonneldet[personaldeturl][]',
																		'placeholder' => 'https://www.bookanartiste.com/your-profile',
																		'id' => 'url',
																		'type' => 'url',
																		'label' => false,
																		'pattern' => '^https?:\/\/www\.bookanartiste\.com\/.+$',
																		'oninvalid' => "this.setCustomValidity('URL must start with https://www.bookanartiste.com/')",
																		'oninput' => "this.setCustomValidity('')"
																	]);
																	?>

																</td>
																<td>
																	<a href="javascript:void(0);" class="deletepersonaldet btn remove-fieldpersonneldet btn-danger btn-block" data-val="<?php echo $proppersonal['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

																	<!--<button type="button" onclick="delete_detials(<?php //echo $prop['id'] 
																														?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>-->

																</td>

															</tr>
														<?php }
													} else { ?>
														<tr class="video_detailspersonneldet">

															<td> <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Member of band, group, team', 'id' => 'name', 'label' => false, 'name' => 'datapersonneldet[personaldetname][]')); ?>
															</td>

															<td> <?php echo $this->Form->input('url', array(
																		'class' => 'form-control',
																		'placeholder' => 'Bookanartiste link',
																		'name' => 'datapersonneldet[URLpersonaldeturl',
																		'id' => 'url',
																		'type' => 'url',
																		'label' => false,
																		'pattern' => '^https?:\/\/www\.bookanartiste\.com\/.+$',
																		'oninvalid' => "this.setCustomValidity('URL must start with https://www.bookanartiste.com/')",
																		'oninput' => "this.setCustomValidity('')"
																	)); ?></td>

															<td>
																<a href="javascript:void(0);" class="deletepersonaldet btn remove-fieldpersonneldet btn-danger btn-block" data-val="<?php echo $proppersonal['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

															</td>
														</tr>

													<?php } ?>

												</tbody>


												<tfoot>
													<tr>
														<td colspan="7" style="text-align:right"><a type="button" class="btn-primary add-fieldpersonneldet pull-right">Add </a></td>

													</tr>


												</tfoot>
											</table>
										</div>

									</div>
								</div>
								<div class="col-sm-4"></div>
							</div>

							<?php //} 
							?>



							<?php // Start Personnel Details Talent portfolio 
							?>
							<script>
								$('.multi-field-wrapperpersonneldet').each(function() {
									var $wrapper = $('.video_containerpersonneldet', this);
									$(".add-fieldpersonneldet", $(this)).click(function(e) { //alert(e);
										var manageport = $('.video_detailspersonneldet:first-child', $wrapper).clone(true).appendTo($wrapper)

										manageport.find('button').val('').focus();
										manageport.find('input').val('').focus();
										manageport.find('select').val('').focus();
										manageport.find('[data-val]').attr("data-val", '');
									});
									$('.remove-fieldpersonneldet', $wrapper).click(function() {
										if ($('.video_detailspersonneldet', $wrapper).length > 1)
											$(this).closest('.video_detailspersonneldet').remove();
									});
								});



								$('.deletepersonaldet').click(function() { //alert();
									paymentcurrent_id = $(this).data('val');
									$.ajax({
										type: "post",
										url: site_url + 'profile/deletepersonneldet',
										data: {
											datadd: paymentcurrent_id
										},

										success: function(data) {}
									});


								});
							</script>
							<?php // End Personnel Details Talent portfolio 
							?>


							<div class="d-flex justify-content-center p" style="text-align: center;">
								<!-- <div class="col-sm-4 text-left"> -->
								<button id="btn" type="submit" class="btn btn-default mr" onclick='this.form.action="profile/professionalsummary/save";'>Save</button>
								<!-- </div> -->
								<!-- <div class="col-sm-4 text-center"> -->

								<!-- </div> -->
								<!-- <div class="col-sm-4 text-right"> -->
								<!-- <div class="text-right"> -->
								<button id="btn" type="submit" onclick='this.form.action="profile/professionalsummary/submit";' class="btn btn-default redButton">Submit</button>
								<!-- </div> -->
								<!-- </div> -->
							</div>

							</form>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- jQuery UI Month Picker addon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.monthpicker.min.js"></script>

<script>
	$(document).ready(function() {
		$('.monthpicker').datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'mm-yy',
			viewMode: "months",
			minViewMode: "months",
			onClose: function(dateText, inst) {
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));
			}
		});
	});
</script>



<!-- <script>
    // Ensure that the document is fully loaded before executing JavaScript
    $(document).ready(function() {
        // Initialize the datepicker for elements with the class 'monthpicker'
        $('.monthpicker').datepicker({
            format: 'yyyy-mm',
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });
    });
</script> -->
<!--
<script type="text/javascript">
    $("#datelimit").click(function(){

        var isd='<?php //echo  $userdob = date('Y', strtotime($profile['dob'])); 
					?>';
        var year = $(".monthpicker").val();
        var splitString = year.slice(0,4);
        
        if (isd<=splitString) {
            //alert("Yes");
        }else{
            $(".monthpicker").val("");
            alert("Please select vailed date");
           return false;
        }
    })
</script>-->

<script>
	// $('.monthpicker').datepicker({
	// 	dateFormat: 'yyyy-mm',

	// });

	// var site_url='<?php //echo SITE_URL;
						?>/';


	$('.delete_paymentcurrent').click(function() { //alert();
		delete_detials_id = $(this).data('val');
		$.ajax({
			type: "post",
			url: site_url + 'profile/deleteproffessionalcurrent',
			data: {
				datadd: delete_detials_id
			},

			success: function(data) {}
		});


	});

	$('.earlierexp').click(function() { //alert();
		earlierexp_id = $(this).data('val');
		$.ajax({
			type: "post",
			url: site_url + 'profile/deleteproffessionalexp',
			data: {
				datadd: earlierexp_id
			},

			success: function(data) {}
		});


	});




	$('.delete_detials').click(function() { //alert();
		paymentcurrent_id = $(this).data('val');
		$.ajax({
			type: "post",
			url: site_url + 'profile/deleteproffessional',
			data: {
				datadd: paymentcurrent_id
			},

			success: function(data) {}
		});


	});
</script>




<script>
	$('.multi-field-wrapper').each(function() {
		var $wrapper = $('.video_container', this);
		$(".add-field", $(this)).click(function(e) { //alert(e);
			var manageport = $('.video_details:first-child', $wrapper).clone(true).appendTo($wrapper)

			manageport.find('button').val('').focus();
			manageport.find('input').val('').focus();
			manageport.find('select').val('').focus();
			manageport.find('[data-val]').attr("data-val", '');
		});
		$('.remove-field', $wrapper).click(function() {
			if ($('.video_details', $wrapper).length > 1)
				$(this).closest('.video_details').remove();
		});
	});
</script>


<script>
	$('.multi-field-wrapperdesc').each(function() {
		lasttr = $(".removeexperienceworking:last-child li:first-child");
		var $wrapper = $('.payment_containerdesc', this);
		$(".add-paymentfielddesc", $(this)).click(function(e) {
			var currentwork = $('.removeexperienceworking:first-child', $wrapper).clone(true).appendTo($wrapper)

			currentwork.find('input').val('').focus();
			currentwork.find('select').val('').focus();
			currentwork.find('textarea').val('').focus();
			currentwork.find('[data-val]').attr("data-val", '');

			ccounter = lasttr.find('.ccounter').attr('id');
			ccounter++
			$lastinput = $(".removeexperienceworking:last-child li:nth-last-child(2) .edate_from");
			$lastinput.attr('id', 'edate_from' + ccounter);
			$lastinput
				.removeClass('hasDatepicker')
				.removeData('datepicker')
				.unbind()
				.datepicker({
					autoclose: true,
					minViewMode: 1,
					format: 'yyyy-mm'
				});

			ccounter = lasttr.find('.ccounter').attr('id');
			ccounter++
			$lastinput = $(".removeexperienceworking:last-child li:nth-last-child(1) .edate_to");
			$lastinput.attr('id', 'edate_to' + ccounter);
			$lastinput
				.removeClass('hasDatepicker')
				.removeData('datepicker')
				.unbind()
				.datepicker({
					autoclose: true,
					minViewMode: 1,
					format: 'yyyy-mm'
				});

		});
		$('.remove-field', $wrapper).click(function() {
			if ($('.removeexperienceworking', $wrapper).length > 1)
				$(this).closest('.removeexperienceworking').remove();
		});
	});
</script>



<script>
	$(document).ready(function() {

		$(".add-paymentfielddesc").click(function() {
			$(".datepicker-orient-left").css("display", "none");
			$(".datepicker-orient-right").css("display", "none");

			//$(".datepicker-months").addClass("intro");
		});
	});
</script>

<script>
	$('.multi-field-wrapperpayment').each(function() {
		lasttr = $(".removecurrentworking:last-child li:first-child");
		var $wrapper = $('.payment_container', this);
		$(".add-paymentfield", $(this)).click(function(e) {
			var currentwork = $('.removecurrentworking:first-child', $wrapper).clone(true).appendTo($wrapper)

			currentwork.find('input').val('').focus();
			currentwork.find('select').val('').focus();
			currentwork.find('textarea').val('').focus();
			currentwork.find('[data-val]').attr("data-val", '');

			ccounter = lasttr.find('.ccounter').attr('id');
			ccounter++
			$lastinput = $(".removecurrentworking:last-child li:nth-last-child(1) .cdate_from");
			$lastinput.attr('id', 'cdate_from' + ccounter);
			$lastinput
				.removeClass('hasDatepicker')
				.removeData('datepicker')
				.unbind()
				.datepicker({
					autoclose: true,
					minViewMode: 1,
					format: 'yyyy-mm'
				});

		});
		$('.remove-field', $wrapper).click(function() {
			if ($('.removecurrentworking', $wrapper).length > 1)
				$(this).closest('.removecurrentworking').remove();
		});
	});
</script>

<script>
	$(document).ready(function() {
		$(".add-paymentfield").click(function() { //alert('test');
			$(".datepicker-orient-left").css("display", "none");

			//$(".datepicker-months").addClass("intro");
		});

	});
</script>
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