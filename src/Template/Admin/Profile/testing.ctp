<div class="content-wrapper">
<!--breadcrumb -->
<section class="content-header">
   <h1>
  Talent Person
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>/admin/profile">Talented Person</a></li>
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
                  <h3 class="box-title">Telent List</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" width="100%"   class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>S.no</th>
                           <th>Name</th>
                           <th>Contact Naumber</th>
                           <th>Profession</th>
                           <th>Performance</th>
                           <th>Skill</th>
                           <th>Email</th>
                           <th>Skype ID</th>
                           <th>Gender</th>
                           <th>Status</th>
                           <th width="103px;">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $page = $this->request->params['paging']['classes']['page'];
                           $limit = $this->request->params['paging']['classes']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           if(isset($talent) && !empty($talent)){ 
                           foreach($talent as $talentdata){   ?>
                        <tr>
                           <td><?php echo $counter;?></td>
                           <td>
                              <?php echo $talentdata['user_name']; ?>
                           </td>
                           <td>
                           
                             <?php echo $talentdata['profile'][0]['phone']; ?>
                           
                           </td>
                           <td>
                            <a data-toggle="modal" class='order_details' href="<?php echo ADMIN_URL?>profile/professiondata/<?php echo $talentdata['id']; ?>" style="color:blue;">Details</a>
                           </td>
                           <td> <a  data-toggle="modal" class='performance' href="<?php echo ADMIN_URL?>profile/performancedata/<?php echo $talentdata['id']; ?>" style="color:blue;">Details</a></td>
                           
                           <td><a data-toggle="modal" class='skill'  href="<?php echo ADMIN_URL?>profile/skill/<?php echo $talentdata['id']; ?>" style="color:blue;">Details</a></td>
                           <td> <?php  echo $talentdata['profile'][0]['altemail']; ?></td>
                           <td>
                           <?  echo $talentdata['profile'][0]['skypeid'] ?>
                           </td>
                           <td><?php if($talentdata['gender']=="m"){echo "Male";}else if($talentdata['gender']=="f"){echo"Female";} else{echo "other"; }  ?></td>
                           <td><?php if($talentdata['status']=='Y'){ 
                              echo $this->Html->link('Activate', [
                                  'action' => 'status',
                                  $talentdata['id'],
                                   $talentdata['status']	
                              ],['class'=>'label label-success']);
                              
                               }else{ 
                              	echo $this->Html->link('Deactivate', [
                                  'action' => 'status',
                                  $talentdata['id'],
                                   $talentdata['status']
                              ],['class'=>'label label-primary']);
                              	
                               } ?>
                           </td>
                           <td>
                              <a href="<?php echo ADMIN_URL;?>profile/delete/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
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