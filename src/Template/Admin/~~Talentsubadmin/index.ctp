<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Talent Sub Admin
       
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title"> Talent Sub Admin</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">
<a href="<?php echo SITE_URL; ?>/admin/talentsubadmin/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Talent Sub Admin </button></a>

</div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Status</th>
                    <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(isset($contentadmin) && !empty($contentadmin)){ 
		foreach($contentadmin as $admin){
		
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td>
                  
                 
                  <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
                  </a>
                  
                  
                  </td>
                  <td><?php if(isset($admin['email'])){ echo $admin['email'];}else{ echo 'N/A'; } ?></td>
                 
                   
              
                    <td><?php if($admin['status']=='Y'){ 
                              echo $this->Html->link('Activate', [
                                  'action' => 'status',
                                  $admin['id'],
                                   $admin['status']	
                              ],['class'=>'label label-success']);
                              
                               }else{ 
                              	echo $this->Html->link('Deactivate', [
                                  'action' => 'status',
                                  $admin['id'],
                                   $admin['status']
                              ],['class'=>'label label-primary']);
                              	
                               } ?></td>
                  
		<td><?php
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $admin->id
			],['class'=>'btn btn-primary']); ?>
	
			<?php
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $admin->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
      <br>
   
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
 $('.skill').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>
