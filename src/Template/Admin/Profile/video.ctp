<div class="content-wrapper">
<!--breadcrumb -->
<section class="content-header">
   <h1>
 Video List
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>/admin/profile">Audio List</a></li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            
               <?php echo $this->Flash->render(); ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Video List</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example" width="100%"   class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>S.no</th>
                           <th>Video Caption</th>
                           <th>Video Link</th>
                          
                         
                           <th width="103px;">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $page = $this->request->params['paging']['classes']['page'];
                           $limit = $this->request->params['paging']['classes']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           if(isset($skill) && !empty($skill)){ 
                           foreach($skill as $skill){   ?>
                        <tr>
                           <td><?php echo $counter;?></td>
                           <td>
                              <?php echo $skill['video_name']; ?>
                           </td>
                           <td>
                           
                            <a class="action_btn" href="<?php echo $skill['video_type']; ?>" target="_blank">View video</a> 
                           
                           </td>

                           
                           
                          
                          
                           <td>
                              <a href="<?php echo ADMIN_URL;?>profile/videodelete/<?= 
                                 $skill['id']?>/<?= $id ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
                           </td>
                        </tr>
                        <?php $counter++;} }else{ ?>
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
 $('.order_details').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.performance').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.skill').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>