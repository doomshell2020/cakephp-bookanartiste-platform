
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Featured Profiles
   </h1>
   <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="#"> Featured Profiles</a></li>
  </ol> 
</section>

<!-- Main content -->
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
        url:"<?php echo ADMIN_URL ;?>featureprofilepack/search"});
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
<a href="<?php echo ADMIN_URL; ?>featureprofilepack/featureproexcel" type="reset" class="btn btn-warning pull-right">Export Excel</a>

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
        <h3 class="box-title">List</h3>
        
      </div>
      <!-- /.box-header -->
      <?php echo $this->Flash->render(); ?>


      <div class="box-body  table-responsive" >
       <table id="example" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Sr. No.</th>
          <th>User Name</th>
          <th>User Email Id</th>
          <th>Feature Start Date, Time</th>
          <th>Feature End Date, Time</th>
          <th>Number of Days</th>
          <th>Total Price Paid</th>
          <th>Status</th>
          
        </tr>
      </thead>

      <style>
        #example2 .pne{ position:relative; overflow:hidden;}
        #example2 .pne .p_new{    
          width: 87px;
          height: 71px;
          position: absolute;
          background: url(../images/newarrival-icon.PNG) no-repeat;
          z-index: 9999; left:-5px; top:-3px; 
        } 
      </style>        
      <tbody id="example2">
       <?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
                  foreach($Job as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['feature_pro_date']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['featured_expiry']));
                    $currentdate=date('Y-m-d H:m:s');
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                      <td><?php echo $counter;?></td>
                      
                       <td>
                        <?php if(isset($admin->user_name)){ ?> 
                          <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['id']; ?>" target="_blank"> <?php echo ucfirst($admin->user_name); }else{ echo 'N/A'; } ?>
                      </td>
                      <td><?php echo $admin['email']; ?></td>
                      <td><?php if($admin['feature_pro_date']){ echo date('M d,Y h:i a',strtotime($featstart)); }else{ echo "N/A"; } ?></td>
                      <td><?php if($admin['featured_expiry']){ echo date('M d,Y h:i a',strtotime($expiredate)); }else{ echo "N/A"; } ?></td>                      
                      <td>
                        <?php 
                          echo $admin['feature_pro_pack_numofday']." Days";
                         ?> 
                      </td>
                      <td>
                        <?php if ($admin['featuredprofile']) {
                          echo "$".$admin['feature_pro_pack_numofday']*$admin['featuredprofile']['price'];
                          }else{
                          echo "0";
                          }
                        ?> 
                      </td>
                      <td>
                        <span class="label label-success">
                          <?php if($expiredate > $currentdate){ echo "Featured"; }else{ echo "N/A"; } ?>
                        </span>
                      </td>
                      
                     
                    </tr>
                    <?php $counter++;} }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">No Featured Profiles Available.
                      </td>
                    </tr>
                    <?php } ?>
     </tbody>

   </table>
 </div>
 <!-- /.box-body -->
 <script>
  $(document).ready(function() {
    $(".globalModals").click(function(event){
      $('.modal-content').load($(this).attr("href"));
    });
  });






</script>
<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loader">
          <div class="es-spinner">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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

<script>
 $('.data').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

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