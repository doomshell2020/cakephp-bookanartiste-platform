

 <section id="page_signup">
 <div class="container">
 <div class="row">
 <div class="col-sm-2">
 </div>
 
 <div class="col-sm-12">
 <div class="signup-popup">
 <h2> Saved <span>Profile</span></h2>
      

             				<div class="clearfix">

</div>
      
        <?php echo $this->Flash->render(); ?>
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>User Name</th>
                  <th>Saved Date</th>
                   <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(isset($savedprfile) && !empty($savedprfile)){ 
		foreach($savedprfile as $value){  //pr($value);  //die;
		
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td>
                  
                 
                 <?php echo $value['user']['user_name']; ?>
                  </a>
                  
                  
                  </td>
                  <td><?php echo date("M d,Y", strtotime($value['created'])); ?></td>
                 
                   <td><a target="_blank" title="View Pofile" href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['p_id'] ?>"><i class="fa fa-eye" aria-hidden="true" style="font-size: 15px;"></i></a>
                 

<a title="Delete" href="<?php echo SITE_URL ?>/profile/savedprofiledelete/<?php echo $value['id'] ?>" onclick="javascript: return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" aria-hidden="true" style="font-size: 15px; color:red; margin-left: 10px;"></i></a>

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
