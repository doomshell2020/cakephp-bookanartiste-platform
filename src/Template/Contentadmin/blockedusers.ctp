
<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="row">
 <div class="col-sm-2">
 </div>
 
 <div class="col-sm-12">
 <div class="signup-popup">
 <h2>Bloked<span> Users</span></h2>
   
<table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>Name</th>
                  <th>Email</th>
				  <th>Block Attempts</th>
                  <th>Number of Reports</th>
                    <th>Status</th>	
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(isset($blockedusers) && !empty($blockedusers)){ 
		foreach($blockedusers as $blockedusers_data){
		
			
		?>
	<tr>
		<td><?php echo $counter;?></td>
	<td>
		<?php if(isset($blockedusers_data->profile['name'])){ echo $blockedusers_data->profile['name'];}else{ echo 'N/A'; } ?>
	
	</td>
	<td><?php if(isset($blockedusers_data['email'])){ echo $blockedusers_data['email'];}else{ echo 'N/A'; } ?></td>
	
	<td><?php if(isset($blockedusers_data['blocked_attempts'])){ echo $blockedusers_data['blocked_attempts'];}else{ echo '0'; } ?>   </td>
	<?php  $total_reports = $this->Comman->totalprofilereports($blockedusers_data['id']); ?>

	<td><?php if(isset($total_reports)){ echo $total_reports;}else{ echo '0'; } ?>   </td>
	<td>
		<a href="<?php echo SITE_URL; ?>/contentadmin/removebprofile/<?php echo $blockedusers_data['id']; ?>" class="label label-danger">Remove</a>
		<a href="<?php echo SITE_URL; ?>/contentadmin/editbprofile/<?php echo $blockedusers_data['id']; ?>" class="label label-primary">Edit</a>
		<a href="<?php echo SITE_URL; ?>/contentadmin/ignoreblocking/<?php echo $blockedusers_data['id']; ?>" class="label label-warning">Ignore</a>
		<a href="<?php echo SITE_URL; ?>/contentadmin/approveblocking/<?php echo $blockedusers_data['id']; ?>" class="label label-success">Approve</a>
	</td>
	</tr>
		<?php $counter++;} }
     else{ ?>
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