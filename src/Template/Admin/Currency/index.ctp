<div class="content-wrapper">
<!--breadcrumb -->
<section class="content-header">
   <h1>
 Currency Manager
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>/admin/profile">Currency </a></li>
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
                        <div class="clearfix">
<a href="<?php echo SITE_URL; ?>/admin/Currency/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Currency </button></a>

</div>
               <div class="box-header">
                  <h3 class="box-title">Currency Manager</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" width="100%"   class="table table-bordered table-striped">
                     <thead>
                        <tr>
                               <th>S.no</th>
                  <th>Currency Title</th>
                  <th>Currency Code</th>
                  <th>Status</th> 
                  <th>Action</th> 
                           
                           
                        </tr>
                     </thead>
                     <tbody>
                        <?php $page = $this->request->params['paging']['classes']['page'];
                           $limit = $this->request->params['paging']['classes']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           if(isset($Currency) && !empty($Currency)){ 
                           foreach($Currency as $Currency){    ?>
                        <tr>
                           <td><?php echo $counter;?></td>
                           <td>
                              <?php echo $Currency['name']; ?>
                           </td>
                      
                       <td><?php echo $Currency['currencycode']; ?></td>
                         
                        
                           
                           <td><?php if($Currency['status']=='Y'){ 
                              echo $this->Html->link('Activate', [
                                  'action' => 'status',
                                  $Currency['id'],
                                   $Currency['status']  
                              ],['class'=>'label label-success']);
                              
                               }else{ 
                                echo $this->Html->link('Deactivate', [
                                  'action' => 'status',
                                  $Currency['id'],
                                   $Currency['status']
                              ],['class'=>'label label-primary']);
                                
                               } ?>
                           </td>
                           <td>
                              <a href="<?php echo ADMIN_URL;?>currency/delete/<?= 
                                 $Currency['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
                                 <?php
      echo $this->Html->link('Edit', [
          'action' => 'add',
          $Currency->id
      ],['class'=>'btn btn-primary']); ?>
      <br>

      
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

 


