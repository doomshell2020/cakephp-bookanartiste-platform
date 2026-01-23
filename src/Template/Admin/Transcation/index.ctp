 <?php 
 foreach($country as $country_data)
 {
  $country_id = $country_data['Country']['id'];
  $countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Payment Transaction Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="#"> Payment Transaction Manager</a></li>
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
  $("#loading").hide();
  $("#TaskAdminCustomerForm").bind("submit", function (event) {
    $.ajax({
      async:true,
      data:$("#TaskAdminCustomerForm").serialize(),
      dataType:"html", 
      beforeSend: function(){
        $("#loading").show();
      },
      success:function (data, textStatus) {
       $("#loading").hide();
       $("#example2").html(data);
     }, 
     type:"POST", 
     url:"<?php echo ADMIN_URL ;?>transcation/search"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('url'=>array('controller'=>'subscription','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>

<div class="form-group">

  <div class="col-sm-3">
   <label>Country</label>
   <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','label' =>false,'empty'=>'--Select Country--','options'=>$countryarr)); ?>
 </div> 

 <div class="col-sm-3">
   <label>State</label>
   <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
 </div> 

 <div class="col-sm-3">
   <label>City</label>
   <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','options'=>$cities)); ?>
 </div> 

 <div class="col-sm-3">
   <label>Payment Status</label>
   <select class="form-control" name="paystatus" >
    <option value="" selected="selected">-Select-</option>
    <option value="Y">Completed</option>
    <option value="N">Failed</option>
  </select>
</div>  
</div>

<div class="form-group">

  <div class="col-sm-3">
   <label>Status</label>
   <select class="form-control" name="packsts" >
    <option value="" selected="selected">-Select-</option>
    <option value="Y">Active</option>
    <option value="N">Inactive</option>
  </select>
</div> 

<div class="col-sm-3">
 <label>Transaction By</label>
 <select class="form-control" name="transactionby" >
  <option value="" selected="selected">-Select-</option>
  <option value="2">Talent</option>
  <option value="3">Non Talent</option>
</select>
</div> 

<div class="col-sm-3">
 <label>Invoice Number</label>
 <?php echo $this->Form->input('invoicenum',array('class'=>'form-control','placeholder'=>'Invoice Numbers','label' =>false)); ?>
</div> 

<div class="col-sm-3">
 <label>Transaction Type</label>
 <select class="form-control" name="transcationtype" >
  <option value="" selected="selected">-Select-</option>
  <option value="PP">Profile package</option>
  <option value="RP">Recruiter package</option>
  <option value="PAR">Post a Requirement Option</option>
  <option value="PG">Ping</option>
  <option value="PQ">Paid Quote Sent</option>
  <option value="AQ">Ask for Quote</option>
  <option value="PA">Profile Advertisement</option>
  <option value="JA">Job Advertisement</option>
  <option value="BNR">Banner</option>
  <option value="FJ">Feature Job</option>
  <option value="FP">Feature Profile</option>
</select>
</div>  
</div>


<div class="form-group">

  <div class="col-sm-3">
   <label>From</label>
   <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
 </div> 

 <div class="col-sm-3">
   <label>To</label>
   <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
 </div> 
 <div class="col-sm-3">
   <label>Name</label>
   <input type="text" class="form-control" name="name" placeholder="Enter Name">
 </div> 

 <div class="col-sm-3">
   <label>Email</label>
   <input type="text" class="form-control" name="email" placeholder="Enter Email">
 </div> 



 <div class="col-sm-3">
  
  <br>
  <button id="loading" class="btn btn-warning">loading...</button>
  <button type="submit" class="btn btn-success">Search</button>
  <button type="reset" class="btn btn-primary">Reset</button>
  <a href="<?php echo ADMIN_URL; ?>transcation/exporttransaction" class="btn btn-primary" >Export Excel</a>

</div>
</div>
<?php
echo $this->Form->end();
?>   
</div>
</div>
</div>	</div>	</div>
<div class="row">
  <div class="col-xs-12">
   <div class="box">
    <!-- /.box-header -->
    <div class="box-body  table-responsive" >
     <table id="" class="table table-bordered table-striped">
      <thead>
       <tr>
        <th>S.no</th>
        <th>Name</th>
        <th>Email Id</th>
        <th>Transaction Date</th>
        <th>Transaction Id</th>
        <th>Invoice Numbers</th>
        <th>Payment Gateway</th>
        <th>Amount</th>
        <th>Transaction Details</th>
        <th>Payment Status</th>
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
      $counter=1;
      if(isset($transcation) && !empty($transcation)){ 
       foreach($transcation as $transcationdata){   
        $crdate=date("d-M-Y",strtotime($transcationdata['created']));
                          // $packagedetails = $this->Comman->packagedetails($transcationdata['package_type'],$transcationdata['package_id']);
                          // pr($packagedetails);
        ?>
        <tr>
         <td><?php echo $counter;?></td>
         <td>

           <!--  <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL ?>profile/details/<?php //echo $transcationdata['user_id']; ?>" style="color:blue;"> -->
           <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $transcationdata['user_id']; ?>" target="_blank" style="color:#278eda;">
            <?php echo $transcationdata['user']['user_name']; ?></a>
          </td>
          <td>
            <?php echo $transcationdata['user']['email']; ?>
          </td>
          <td>
           <?php echo $crdate;  ?>
         </td>
         <td><?php echo $transcationdata['transcation_id'];  ?></td>

         <td>
         <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $transcationdata['id']; ?>">
         <?php echo "INV-".$transcationdata['description']."-".$crdate."-".$transcationdata['id']; ?>
         </a>
         </td>

          <td><?php echo $transcationdata['payment_method'];  ?></td>
          <td><?php echo "$".$transcationdata['amount'];  ?></td>
          <td><a data-toggle="modal" class='data' href="<?php echo ADMIN_URL ?>transcation/details/<?php echo $transcationdata['id']; ?>" style="">Details</a></td>
          <td>
           <?php 
           if($transcationdata['status']=='Y'){?>
           <a class='label label-success' href="Javascript:void(0)" style="color:blue;">
             Completed</a>
             <?php
           }else
           { ?>
           <a class='label label-primary' href="Javascript:void(0)" style="color:blue;">
             Failed</a>
             <?php
           }
           ?>
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
 <script>
  $(document).ready(function() {
    //prepare the dialog
    //respond to click event on anything with 'overlay' class
    $(".globalModals").click(function(event){
        $('.modal-content').load($(this).attr("href"));  //load content from href of link
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
 $('.data').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>



<script type="text/javascript">
  $(document).ready(function() {
    $("#country_ids").on('change',function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id='+ id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/admin/transcation/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("Select State").appendTo($("#state"));
            $.each(html, function(key, value) {        
              $('<option>').val(key).text(value).appendTo($("#state"));
            });
          } 
        });
      }
    });

    $("#state").on('change',function() {
      var id = $(this).val();
      $("#city").find('option').remove();
      if (id) {
        var dataString = 'id='+ id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/admin/transcation/getcities',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("Select City").appendTo($("#city"));
            $.each(html, function(key, value) {              
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          } 
        });
      } 
    });
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
