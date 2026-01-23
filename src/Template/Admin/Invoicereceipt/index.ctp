<div class="content-wrapper">
  <!--breadcrumb -->
  <section class="content-header">
   <h1>
     Manage Invoice And Receipt
   </h1>
   <ol class="breadcrumb">
    <li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
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
      <!-- <a href="<?php //echo SITE_URL; ?>/admin/country/add">
        <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
          Add Country </button></a> -->

        </div>
        <div class="box-header">
          <h3 class="box-title"> Manage Invoice And Receipt </h3>   
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" width="100%"   class="table table-bordered table-striped">
           <thead>
            <tr>
             <th>S.no</th>
             <th>Tax</th>
             <th>Tax %</th>
             <th>Status</th>
             <th width="103px;">Action</th>
           </tr>
         </thead>
         <tbody>
          <?php 
          $counter =1;
          if(isset($invoicereceipt) && !empty($invoicereceipt)){ 
           foreach($invoicereceipt as $value){   ?>
           <tr>
             <td><?php echo $counter;?></td>
             <td>
              <?php echo $value['title']; ?>
            </td>
            <td><?php echo $value['tax_percentage']."%"; ?></td>



            <td><?php if($value['status']=='Y'){ 
              echo $this->Html->link('Deactivate', [
                'action' => 'status',
                $value['id'],
                $value['status']  
                ],['class'=>'label label-success']);

            }else{ 
              echo $this->Html->link('Activate', [
                'action' => 'status',
                $value['id'],
                $value['status']
                ],['class'=>'label label-primary']);

              } ?>
            </td>
            <td>
               <?php
               echo $this->Html->link('Edit', [
                'action' => 'add',
                $value->id
                ],['class'=>'btn btn-primary']); ?>
               
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




