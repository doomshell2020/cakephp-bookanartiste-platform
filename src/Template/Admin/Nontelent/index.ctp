<?php
foreach ($country as $country_data) {
	$country_id = $country_data['Country']['id'];
	$countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<div class="content-wrapper">
	<!--breadcrumb -->
	<section class="content-header">
		<h1>
			Non Talent Manager
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo SITE_URL; ?>/admin/profile">Non Talent Manager</a></li>
		</ol>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-xs-12">

				<div class="box">
					<div class="box-header">
						<?php echo $this->Flash->render(); ?>


						<h3 class="box-title"> Advance Search </h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">

						<div class="manag-stu">

							<script inline="1">
								//<![CDATA[
								$(document).ready(function() {
									$("#TaskAdminCustomerForm").bind("submit", function(event) {
										$.ajax({
											async: true,
											data: $("#TaskAdminCustomerForm").serialize(),
											dataType: "html",

											success: function(data, textStatus) {

												$("#example2").html(data);
											},
											type: "POST",
											url: "<?php echo ADMIN_URL; ?>nontelent/search"
										});
										return false;
									});
								});
								//]]>
							</script>
							<?php echo $this->Form->create('Task', array('url' => array('controller' => 'products', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
							<div class="form-group">
								<div class="col-sm-2">
									<label>Name</label>
									<input type="text" class="form-control" name="name" placeholder="Enter Name">
								</div>

								<div class="col-sm-2">
									<label>Email</label>
									<input type="text" class="form-control" name="email" placeholder="Enter Email">
								</div>

								<div class="col-sm-2">
									<label>Country</label>

									<?php echo $this->Form->input('country', array('class' => 'form-control', 'placeholder' => 'Country', 'label' => false, 'id' => 'country_phone', 'empty' => '--Select Country--', 'options' => $countryarr)); ?>
								</div>

								<div class="col-sm-2">
									<label>Status</label>
									<select class="form-control" name="status">
										<option value="" selected="selected">-Select-</option>
										<option value="Y">Active</option>
										<option value="N">Inactive</option>
									</select>
								</div>

								<div class="col-sm-2">
									<label>Talent Status</label>
									<select class="form-control" name="tcstatus">
										<option value="" selected="selected">-Select-</option>
										<option value="TY">Has Talent Admin</option>
										<option value="TN">Has Not a Talent Admin</option>
									</select>
								</div>
								<div class="col-sm-2">
									<label>Renew Job</label>
									<select class="form-control" name="renewjob">
										<option value="" selected="selected">-Select-</option>
										<option value="N">Renew Jobs Due</option>
										<option value="Y">Renew Jobs Not Due</option>
									</select>
								</div>
								<div class="col-sm-3">
									</br>
									<button type="submit" class="btn btn-success">Search</button>
									<button type="reset" class="btn btn-primary">Reset</button>
									<a href="<?php echo ADMIN_URL; ?>nontelent/nontalentexcel" type="reset" class="btn btn-warning ">Export Excel</a>

								</div>
							</div>
							<?php
							echo $this->Form->end();
							?>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"> Non Talent List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="example" width="100%" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Name</th>
									<th>Contact Number</th>
									<th>Email</th>
									<th>Member Since</th>
									<th>Status</th>
									<th width="150px;">Action</th>
								</tr>
							</thead>
							<tbody id="example2">
								<?php
								if (isset($nontalent) && !empty($nontalent)) {
									$counter = 1;
									foreach ($nontalent as $talentdata) {  //pr($talentdata); die;

								?>
										<tr>
											<td><?php echo $counter; ?></td>
											<td>
												<!-- <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL 
																								?>nontelent/details/<?php //echo $talentdata['profile']['id']; 
																													?>" style="color:blue;"><?php //echo $talentdata['profile']['name']; 
																																			?></a> -->
												<a href="<?php echo SITE_URL; ?>/profiledetails/<?php echo $talentdata['id']; ?>" target="_blank" style="color:#278eda;">
													<?php if ($talentdata['profile']['name']) {
														echo $talentdata['profile']['name'];
													} else {
														echo $talentdata['user_name'];
													} ?>
												</a>

											</td>

											<td> <?php
													if ($talentdata['profile']['phone']) {
														echo '+' . $talentdata['profile']['phonecode'] . '-' . $talentdata['profile']['phone'];
														if (!empty($talentdata['profile']['altnumber'])) {
															$removespace = str_replace(' ', '', $talentdata['profile']['altnumber']);
															$altphone = explode(",", $removespace);
															foreach ($altphone as $altphonevalue) {
																echo ", +" . $talentdata['profile']['phonecode'] . "-" . $altphonevalue;
															}
														}
													} elseif ($talentdata['phone']) {
														echo $talentdata['profile']['phonecode'] . "-" . $talentdata['phone'];
													} else {
														echo "---";
													}
													?></td>
											<td>
												<?php echo $talentdata['email'];
												if (!empty($talentdata['profile']['altemail'])) {
													echo ", " . $talentdata['profile']['altemail'];
												}
												?>
											</td>
											<td>
												<?php echo date('d-M-Y', strtotime($talentdata['created'])); ?>
											</td>


											<td><?php if ($talentdata['status'] == 'Y') {
													echo $this->Html->link('Deactivate', [
														'action' => 'status',
														$talentdata['id'],
														$talentdata['status']
													], ['class' => 'label label-success']);
												} else {
													echo $this->Html->link('Activate', [
														'action' => 'status',
														$talentdata['id'],
														$talentdata['status']
													], ['class' => 'label label-primary']);
												} ?>
											</td>
											<td>
												<?php
												// pr($talentdata['packfeature']);exit;
												if ($talentdata['packfeature']['non_telent_number_of_job_post_used'] >= $talentdata['packfeature']['non_telent_number_of_job_post']) { ?> 

												<a href="<?php echo ADMIN_URL; ?>nontelent/renewfreejob/<?= $talentdata['id'] ?>"
												onclick="return confirm('Are you sure you want to renew free job post?');"
												>Renew Job</a>
												<?php } ?>

												<a href="<?php echo ADMIN_URL; ?>nontelent/delete/<?= $talentdata['id'] ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><img src="<?php echo SITE_URL; ?>/img/del.png"></a>
												<br>
												<?php if ($talentdata['is_talent_admin'] == 'N') { ?>
													<a class="action_btn" title="Make Talent Admin" href="<?php echo ADMIN_URL; ?>talentadmin/maketalentadmin/<?= $talentdata['id'] ?>" onClick="javascript:return confirm('Are you sure do you want to make this user talent admin')">Make Talent Admin</a>
												<?php } else { ?>
													<a class="action_btn" title="Make Talent Admin" href="<?php echo ADMIN_URL; ?>talentadmin/removetalentadmin/<?= $talentdata['id'] ?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from talent admin')">Remove Talent Admin</a>
												<?php } ?>

											</td>
										</tr>
									<?php $counter++;
									}
								} else { ?>
									<tr>
										<td colspan="11" align="center">No Data Available</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					</div>
					<!-- /.box-body -->

				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Daynamic modal -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">

		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->





<script>
	$('.data').click(function(e) {

		e.preventDefault();
		$('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
	});
</script>