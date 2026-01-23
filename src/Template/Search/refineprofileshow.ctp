

 <section id="page_signup">
 <div class="container">
 <div class="row">
 <div class="col-sm-2">
 </div>
 
 <div class="col-sm-12">
 <div class="signup-popup">
 <h2>Filtter Saved <span>Profile</span></h2>
      

             				<div class="clearfix">

</div>
      
      
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>Template Name</th>
                  <th>Created</th>
                   <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(isset($savedata) && !empty($savedata)){ 
		foreach($savedata as $admin){  
		
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td>
                  
                 
                  <?php if(isset($admin->template)){ echo $admin->template;}else{ echo 'N/A'; } ?>
                  </a>
                  
                  
                  </td>
                  <td><?php if(isset($admin->created)){ echo date('d-m-Y',strtotime($admin->created));}else{ echo 'N/A'; } ?></td>
                 
                   <td><a href="<?php echo SITE_URL ?>/search/viewrefineprofile/<?php echo $admin->id ?>" class="btn btn-primary">View</a>
                 

<a href="<?php echo SITE_URL ?>/search/deletesave/<?php echo $admin->id ?>" class="btn btn-danger" onclick="javascript: return confirm('Are you sure do you want to delete this')">Delete</a>

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
<script>
 $(function () {
   $("#example1").DataTable();
   $('#example2').DataTable({
     "paging": true,
     "lengthChange": false,
     "searching": false,
     "ordering": true,
     "info": true,
     "autoWidth": false
   });
 });
</script>
