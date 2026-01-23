<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Featured job Package</h1>
    <?php echo $this->Flash->render(); ?>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
       <div class="box">
        <div class="box-header">
          <h3 class="box-title">Package List</h3>           
        </div>
        <!-- /.box-header -->
        <div class="row">
          <div class="col-xs-12">
           <div class="box">
             <div class="clearfix">
              <a href="<?php echo SITE_URL; ?>/admin/featurejobpack/add">
                <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                  Add Featured job Package </button></a>

                </div>
                <div class="box-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.no</th>
                        <th>Package name</th>
                        <th>Number Of Days</th>
                        <th>Package Price (USD)</th>
                        <th>Visibility Priority</th>
                        <th>Status</th>
                        <th>Action</th>	
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $counter = 1;
                      if(isset($Featuredjob) && !empty($Featuredjob)){ 
                        foreach($Featuredjob as $pack){
                        
                          ?>
                          <tr>
                            <td><?php echo $counter;?></td>
                            <td> <?php if(isset($pack['id'])){ if($pack['is_default']=='Y'){ echo "Default "; } echo ucfirst($pack['name']); }else{ echo 'N/A'; } ?> </td>
                            <td><?php if(isset($pack['validity_days'])){ echo $pack['validity_days'];}else{ echo '0'; } ?></td>
                            <td>$<?php if(isset($pack['price'])){ echo $pack['price'];}else{ echo '0'; } ?></td>
                            <td><?php if(isset($pack['priorites'])){ echo $pack['priorites'];}else{ echo '0'; } ?></td>
                            <td><?php if($pack['status']=='Y'){ 
                              echo $this->Html->link('Activate', [
                                'action' => 'status',
                                $pack['id'],
                                $pack['status']	
                                ],['class'=>'label label-success']);
                              
                            }else{ 
                             echo $this->Html->link('Deactivate', [
                              'action' => 'status',
                              $pack['id'],
                              $pack['status']
                              ],['class'=>'label label-primary']);

                            } ?></td>
                            <td><?php
                             echo $this->Html->link('Edit', [
                               'action' => 'add',
                               $pack->id
                               ],['class'=>'btn btn-primary']); ?>
			<?php  /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $pack->id
         ],['class'=>'btn btn-success']); */ ?>
         <?php if($pack['validity_days']!=1){
         echo $this->Html->link('Delete', [
           'action' => 'delete',
           $pack->id
           ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]);

          } ?></td>
         </tr>
         <?php $counter++;} } else{ ?>
         <tr>
          <td>NO Data Available</td>
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
 $('.pack').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>
