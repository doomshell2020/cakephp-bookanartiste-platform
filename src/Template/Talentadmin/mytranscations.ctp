<!----------------------editprofile-strt------------------------>

<script inline="1">
	//<![CDATA[
	$(document).ready(function() {
		$("#TranscationSearchForm").bind("submit", function(event) {
			$.ajax({
				async: true,
				data: $("#TranscationSearchForm").serialize(),
				dataType: "html",

				success: function(data, textStatus) {

					$("#example2").html(data);
				},
				type: "POST",
				url: "<?php echo SITE_URL; ?>/talentadmin/searchtranscation"
			});
			return false;
		});
	});



	//]]>
</script>

<section id="page_signup">
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
			</div>

			<div class="col-sm-12">
				<div class="signup-popup">
					<h2>My Transactions and Earnings</h2>
					<p>You earn a revenue share of <?php echo $talentpartner['commision']; ?> percent for every transaction done by your referred profiles</p>
					<div class="clearfix">
						<a href="<?php echo SITE_URL; ?>/talentadmin/refertalent">
							<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
								Upload Profile</button></a>
					</div><br>


					<?php echo $this->Form->create('Task', array('url' => array('controller' => 'products', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TranscationSearchForm', 'class' => 'form-horizontal')); ?>

					<div class="form-group">
						<div class="col-sm-3">
							<?php echo $this->Form->input('from_date', array('class' => 'form-control', 'placeholder' => 'From Date', 'data-date-format' => 'yyyy-mm-dd', 'id' => 'datepicker1', 'autocomplete' => 'off', 'label' => false)); ?>
						</div>

						<div class="col-sm-3">
							<?php echo $this->Form->input('to_date', array('class' => 'form-control', 'placeholder' => 'To Date', 'data-date-format' => 'yyyy-mm-dd', 'id' => 'datepicker2', 'autocomplete' => 'off', 'label' => false)); ?>
						</div>

						<div class="col-sm-3">
							<button type="submit" class="btn btn-success">Search</button>
							<button type="reset" class="btn btn-success">Reset</button>
							<a class="btn btn-success" href="<?php echo SITE_URL; ?>/talentadmin/exporttalentadmin">Export to Excel</a>
						</div>
					</div>
					<?php
					echo $this->Form->end();
					?>

					<table id="" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sr. No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Invoice Number</th>
								<th>Date</th>
								<th>Transaction Carried out (Units/Days)</th>
								<th>Amount Earned</th>
								<th>Payout Status</th>
							</tr>
						</thead>
						<tbody id="example2">
							<?php
							$counter = 1;
							if (isset($transcations) && !empty($transcations)) {
								//pr($transcations); die;
								foreach ($transcations as $transcationsdata) { //pr($transcationsdata); die;
									//$transaction=$this->Comman->referreduserpurches($transcationsdata['transaction_id']);
									//pr($transaction); 
									$payoutdate = date('d-M-Y', strtotime($transcationsdata['paid_date']));
									if ($transcationsdata['description'] == 'PAR') {
										$packtype = "Post a Requirement";
									} elseif ($transcationsdata['description'] == 'PP') {
										$packtype = "Profile Package";
									} elseif ($transcationsdata['description'] == 'RP') {
										$packtype = "Recruiter Package";
									} elseif ($transcationsdata['description'] == 'PG') {
										$packtype = "Ping";
									} elseif ($transcationsdata['description'] == 'PQ') {
										$packtype = "Paid Quote Sent";
									} elseif ($transcationsdata['description'] == 'AQ') {
										$packtype = "Ask for Quote";
									} elseif ($transcationsdata['description'] == 'PA') {
										$packtype = "Profile Advertisement";
									} elseif ($transcationsdata['description'] == 'JA') {
										$packtype = "Job Advertisement";
									} elseif ($transcationsdata['description'] == 'BNR') {
										$packtype = "Banner";
									} elseif ($transcationsdata['description'] == 'FJ') {
										$packtype = "Feature Job";
									} elseif ($transcationsdata['description'] == 'FP') {
										$packtype = "Feature Profile";
									}
							?>
									<tr>
										<td><?php echo $counter; ?></td>
										<td><?php if ($transcationsdata['user']['profile']['name']) {
												echo $transcationsdata['user']['profile']['name'];
											} elseif ($transcationsdata['user']['user_name']) {
												echo $transcationsdata['user']['user_name'];
											} else {
												echo '-';
											} ?>
										</td>

										<td><?php if (isset($transcationsdata['user']['email'])) {
												echo $transcationsdata['user']['email'];
											} else {
												echo '-';
											} ?>
										</td>

										<td><?php if ($transcationsdata['paid_date']) {
												echo "INV-" . $transcationsdata['description'] . "-" . $payoutdate . "-" . $transcationsdata['id'];
											} else {
												echo "-";
											}
											?></td>
										<td><?php if (isset($transcationsdata['paid_date'])) {
												echo date('M d, Y, H:i A', strtotime($transcationsdata['paid_date']));
											} else {
												echo '-';
											} ?>
										</td>

										<td>
											<?php
											if ($transcationsdata['transcation']['subscription']) {
												$namepack = $transcationsdata['transcation']['subscription']['profilepack']['name'];

												if ($transcationsdata['transcation']['subscription']['package_type'] == 'PR') {
													echo $namepack . " Profile Package (01 units)";
												} elseif ($transcationsdata['transcation']['subscription']['package_type'] == 'RC') {
													echo $namepack . " Recruiter Package (01 units)";
												} elseif ($transcationsdata['transcation']['subscription']['package_type'] == 'RE') {
													echo $namepack . " Requirement Package (01 units)";
												}
											} elseif ($transcationsdata['transcation']) {
												echo $packtype . " (" . $transcationsdata['transcation']['number_of_days'] . " Days)";
											} else {
												echo '-';
											}
											?>

										</td>

										<td>
											<?php if ($transcationsdata['amount'] > 0) {
												echo "$" . $transcationsdata['amount'];
											} else {
												echo '-';
											} ?>
										</td>
										<td>
											<?php if ($transcationsdata['payout_amount'] > 0) { ?>
												<button class="btn btn-success">
													<?php echo "$" . $transcationsdata['payout_amount'] . " Received"; ?>
												</button>
											<?php } else {
												echo '-';
											} ?>

										</td>
									</tr>
								<?php $counter++;

									$total_tranc = $total_tranc + $transcationsdata['transcation_amount'];
									$total_comm = $total_comm + $transcationsdata['amount'];
									$total_payout = $total_payout + $transcationsdata['payout_amount'];
								}
								?>


								<tr>
									<td></td>
									<td><b>Total</b></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><b><?php echo "$" . $total_comm; ?></b></td>
									<td><b><?php echo "$" . $total_payout; ?></b></td>
								</tr>

							<?php

							} else { ?>
								<tr>
									<td colspan="11" align="center">NO Data Available</td>
								</tr>
							<?php } ?>
						</tbody>

					</table>

				</div>
			</div>


		</div>
	</div>
	</div>
</section>


<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script>
	$(function() {

		var dateFormat = 'dd-mm-yy',
			from = $("#datepicker1")
			.datepicker({
				dateFormat: 'dd-mm-yy',

				changeMonth: true,
				numberOfMonths: 1
			})
			.on("change", function() {
				to.datepicker("option", "minDate", getDate(this));
			}),
			to = $("#datepicker2").datepicker({
				dateFormat: 'dd-mm-yy',

				changeMonth: true,
				numberOfMonths: 1
			})
			.on("change", function() {
				from.datepicker("option", "maxDate", getDate(this));
			});

		function getDate(element) {
			var date;
			try {
				date = $.datepicker.parseDate(dateFormat, element.value);
			} catch (error) {
				date = null;
			}

			return date;
		}
	});
</script>