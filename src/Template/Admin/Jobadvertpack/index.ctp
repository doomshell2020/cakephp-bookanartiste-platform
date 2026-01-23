<style type="text/css">
  .content {
    min-height: auto;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Job Advertisement</h1>
    <?php echo $this->Flash->render(); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Update Job Advertisement Price</h3>
          </div>

          <div class="row">
            <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              
                <?php echo $this->Flash->render(); ?>

                <?php echo $this->Form->create($Profilepack, array(

                 'class'=>'form-horizontal',
                 'action' => 'index',
                 'enctype' => 'multipart/form-data'
                 )); ?>

                 <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cost per day</label>
                        <div class="field col-sm-3">

                            <?php echo $this->Form->input('cost_per_day', array('class' => 
                            'longinput form-control','maxlength'=>'20','required','placeholder'=>'Cost per day','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>

                        </div>
                        <div class="col-sm-3">
                          <?php
                          if(isset($Profilepack['id'])){
                            echo $this->Form->submit(
                              'Update', 
                              array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                              ); }else{ 
                              echo $this->Form->submit(
                                'Add', 
                                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                                );
                            }
                            ?>
                        </div>
                    </div>

                </div>


            </div>
           
                <?php echo $this->Form->end(); ?>
            </div>
                    </div>
                    <!-- /.row -->
                  </section>
                  <!-- /.content -->

<section class="content">

<div class="row">
    <div class="col-xs-12">

     <div class="box">
      <div class="box-header">
       <?php echo $this->Flash->render(); ?>
       <h3 class="box-title"> Advance Search  </h3>
     </div>
     <!-- /.box-header -->
     <div class="box-body">

       <div class="manag-stu">

        <script inline="1">
//<![CDATA[
$(document).ready(function () {
  $("#TaskAdminCustomerForm").bind("submit", function (event) {
    $.ajax({
      async:true,
      data:$("#TaskAdminCustomerForm").serialize(),
      dataType:"html", 

      success:function (data, textStatus) {

        $("#example2").html(data);}, 
        type:"POST", 
        url:"<?php echo ADMIN_URL ;?>jobadvertpack/search"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('url'=>array('controller'=>'products','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


<div class="form-group">

<div class="col-sm-3">
   <label>From</label>
   <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
 </div> 

 <div class="col-sm-3">
   <label>To</label>
   <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
 </div> 

  <div class="col-sm-2">
   <label>Name</label>
   <input type="text" class="form-control" name="name" placeholder="Enter Name">
 </div> 

 <div class="col-sm-2">
   <label>Email</label>
   <input type="text" class="form-control" name="email" placeholder="Enter Email">
 </div> 

 <div class="col-sm-2">
   <label>Status</label>
   <select class="form-control" name="status" >
    <option value="" selected="selected">All</option>
    <option value="Y">Active</option>
    <option value="N">Inactive</option>
  </select>
</div>  


<div class="col-sm-3">
<br>
<button type="submit" class="btn btn-success">Search</button>
<button type="reset" class="btn btn-primary">Reset</button>
<a href="<?php echo ADMIN_URL; ?>jobadvertpack/advrtjobexcel"  class="btn btn-warning pull-right">Export Excel</a>

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
        <h3 class="box-title">Manage Job Advertisement</h3>
      </div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="clearfix">
      
        </div>
        <div class="box-body">
          <table id="" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Images</th>
                <th>User Name</th>
                <th>User E Mail</th>
                <th>Invoice Number</th>
                <th>Job Title</th>
                <th>Date of filling Ad form</th>
                <th>Ad Date From</th>
                <th>Ad Date To</th>
                <th>Number of Days</th>
                <th>Total Amount</th>
                <th>Total Bill Amount</th>
                <th>Status</th>
              </tr>
            </thead>
          <tbody id="example2">

            <?php 
            $counter=1;
            if(isset($alladvtpro) && !empty($alladvtpro)){ 
              foreach($alladvtpro as $pack){ //pr($pack); die;
              	$mytransactions=$this->Comman->myjobadtransactions($pack['id']);
              	//pr($mytransactions); die;
              	$crdate=date("M d, Y",strtotime($mytransactions['created']));
              	$invoicenum="INV-".$mytransactions['description']."-".$crdate."-".$mytransactions['id'];

                $currentdate=date('M d, Y H:m:s');
                $todates= date('M d, Y H:m:s',strtotime($pack['ad_date_to'])); 

                $fromdate= date('M d, Y',strtotime($pack['ad_date_from'])); 
                $todate= date('M d, Y',strtotime($pack['ad_date_to'])); 
                $date1 = date_create($fromdate);
                $date2 = date_create($todate);
                $diff = date_diff($date1,$date2);
                $bannerdays=$diff->days;
                ?>
                <tr>
                  <td>
                      <?php if(!empty($pack['job_image_change'])){ ?>
                      <img src="<?php echo SITE_URL; ?>/job/<?php echo $pack['job_image_change']; ?>" alt="" width="150" hight="150"> </td>
                      <?php }else{ ?>
                        <img src="<?php echo SITE_URL; ?>/images/job.jpg">
                      <?php } ?>
                  <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pack['user_id']; ?>" target="_blank">
                  <?php echo $pack['user']['user_name']; ?></a>
                      </td>
                  <td><?php echo $pack['user']['email']; ?></td>
                  <td>
                  <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $mytransactions['id']; ?>/1">
                  <?php if($mytransactions['id']){ echo $invoicenum; }else{ echo "N/A"; } ?>
                    </a>
                  </td>
                  <td><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pack['requirement']['id']; ?>" target="_blank">
                  <?php echo $pack['requirement']['title']; ?></a></td>
                  <td><?php echo date('M d, Y',strtotime($pack['created'])); ?></td>
                  <td><?php echo $fromdate; ?></td>
                  <td><?php echo $todate; ?></td>
                  <td><?php echo $bannerdays."days"; ?></td>                  
                  <td><?php if($mytransactions['before_tax_amt']){ echo "$".$mytransactions['before_tax_amt']." USD"; }else{ echo "$0 USD";} ?></td>               
                  <td><?php echo "$".$mytransactions['amount']." USD"; ?></td>                  
                 
                    <td><?php if($pack['status']=='Y'){ ?>
                    <span class="label label-info"> Ad Active</span>
                    
                    <?php
                      echo $this->Html->link('Deactivate Ad', [
                          'action' => 'status',
                            $pack['id'],
                           $pack['status']  
                      ],['class'=>'label label-success']); ?>
                    
                    <?php }else{ ?>
                      <span class="label label-success">Ad Inactive</span>
                    <?php } ?>
                    </td>
                   
                    </tr>
                    <?php $counter++; } } else{ ?>
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

<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script>
  $( function() {

    var dateFormat = 'dd-mm-yy',
    from = $( "#datepicker1" )
    .datepicker({
      dateFormat: 'dd-mm-yy',

      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      to.datepicker( "option", "minDate", getDate( this ) );
    }),
    to = $( "#datepicker2" ).datepicker({
      dateFormat: 'dd-mm-yy',

      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }
  } );
</script>