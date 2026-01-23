<?php 
foreach($country as $country_data)
{
	$country_id = $country_data['Country']['id'];
	$countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Commission Manager

    </h1>
    <?php echo $this->Flash->render(); ?>
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
        url:"<?php echo ADMIN_URL ;?>talentadmin/searchcommission"});
    return false;
  });
});
//]]>

</script>
<style>
  .dataTables_filter, .dataTables_info { display: none; }
</style>

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
   <input type="text" class="form-control" name="talent_name" placeholder="Enter Name">
 </div> 

 <div class="col-sm-2">
   <label>Email</label>
   <input type="text" class="form-control" name="email" placeholder="Enter Email">
 </div> 
 </div>
<div class="form-group">

<div class="col-sm-4">

<button type="submit" class="btn btn-success">Search</button>
<button type="reset" class="btn btn-primary">Reset</button>
<a class="btn btn-primary label-success" href="<?php echo SITE_URL; ?>/admin/talentadmin/exportcommission">Export to Excel</a>
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
     <div class="clearfix">
      <a href="<?php echo SITE_URL; ?>/admin/talentadmin/paidtransaction">
          <button class="btn btn-success">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Payment Made 
          </button></a>

          <!-- <a href="Javascript:void(0)" class="quik">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Update All Payout </button></a> -->
</div>

<div class="box-body">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
      <!-- <th>
        <input type="checkbox" id="select_all" class="selectcheck" name="check[]" value="<?php //echo $value['id']; ?>">
        </th> -->
        <th>S.no</th>
        <th>Talent Partner Name</th>
        <th>Email id</th>
        <th>Creator Name</th>
        <th>Creator Email id</th>
        <th>Membership from</th>
        <th>Talent Partner from</th>
        <th>Banking Details</th>
        <th>Revenue Share Due</th>
        <th>Action</th>	
      </tr>
    </thead>
    <tbody id="example2">
      <?php 
      $counter = 1;

		//pr($talents); die;

      if(isset($talents) && !empty($talents)){ 
		foreach($talents as $admin){   //pr($admin); 

			$talent_admin_id=$admin['user_id'];
      ?>
      <tr>
      <!-- <td>
      <?php /*if ($admin['total']>0) { ?>
        <input type="checkbox" class="selectcheck mycheckbox" name="check[]" value="<?php echo $talent_admin_id; ?>">
        <?php }else{ ?>
        <input type="checkbox" disabled="disabled">
          <?php }*/ ?>
        </td> -->
        <td><?php echo $counter;?></td>
        <td>
          <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
        </td>
        <td>
          <?php if(isset($admin['email'])){ echo $admin['email'];}else{ echo 'N/A'; } ?>
        </td>

        <td>
          <?php if(isset($admin['talentname'])){ echo $admin['talentname']; }else{ echo 'Admin'; } ?>
        </td>
        <td>
          <?php if(isset($admin['talentemail'])){ echo $admin['talentemail']; }else{ echo 'Admin'; } ?>
        </td>
        <td><?php if(isset($admin['membership_from'])){ echo $admin['membership_from'];}else{ echo 'N/A'; } ?></td>
        <td><?php if(isset($admin['talent_from'])){ echo $admin['talent_from'];}else{ echo 'N/A'; } ?></td>
        <td>
          <?php if ($admin['bank_name'] && $admin['bank_account_no']) { ?>
          <a data-toggle="modal" class='bankdata' href="<?php echo SITE_URL; ?>/admin/talentadmin/bankdetails/<?php echo $talent_admin_id; ?>" style="color:blue;">
            <?php echo "Banking Detail";
        //if(isset($admin['commissionearned'])){ echo round($admin['commissionearned'],2);}else{ echo 'N/A'; } ?>
      </a>
      <?php }else{
        echo "N/A";
      } ?></td>
      <td>
      <?php 
      if(isset($admin['total']) >0){ 
          echo round($admin['total'],2);
        }else if(isset($admin['total']) < 1){ 
          echo 'N/A'; 
        }else{ 
          echo 'N/A'; 
        } ?>
        </td>
      <td>
        <?php if ($admin['total'] > 0) {
         
        echo $this->Html->link('Transaction', [
         'action' => 'transcations',
         $admin['user_id']
         ],['class'=>'btn btn-primary']); 
         ?>

         <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminid('<?php echo $talent_admin_id;?>','<?php echo round($admin['total'],2);?>')">
          <button class="btn btn-success">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Update Payout 
          </button></a>
          <?php }elseif($admin['total'] !=''){ 
            echo $this->Html->link('Transaction', ['action' => 'transcations',$admin['user_id']],['class'=>'btn btn-primary']); 
          }else{ ?>
          <button class="btn btn">
            <i class="fa fa-minus" aria-hidden="true"></i>
            No Earnings
          </button>
          <?php } ?>
			<?php /*
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $admin['id']
         ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); */ ?>
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


<div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel" >Update Payout Information</h4>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create($packentity,array('url' => array('controller' => 'talentadmin', 'action' => 'updatepayout'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
        <div class="form-group">
        <label class="control-label col-sm-2">Note:</label>
          <div class="col-sm-10">
            <?php echo $this->Form->input('write_notes',array('class'=>'form-control','placeholder'=>'Write the invoice raised by talent manager, or any observations','required','label' =>false)); ?>
            <input type="hidden" id="talent_admin_id" name="talent_admin_id" value="">
            <input type="text" readonly="readonly" id="total" name="payout_amount" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="text-center col-sm-12">
            <button id="btn" type="submit" class="btn btn-default"><?php echo __('Change Status to Paid'); ?></button>

          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>




<script>
  function assigntalentadminid(talent_admin_id,total)
  {
    $('#talent_admin_id').val(talent_admin_id);
    $('#total').val(total);
  }
  
  $('.payout').click(function(e){
    e.preventDefault();
    $('#myalbum-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>


<div id="globalModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
 <script>
       $('.bankdata').click(function(e){
        e.preventDefault();
        $('#globalModal').modal('show').find('.modal-body').load($(this).attr('href'));
      });

    </script>

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
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getStates',
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
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getcities',
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


<script>  
  //for quick edit....
  $(document).ready(function () { 
    $("#select_all").change(function(){ 
      if($(this).prop("checked")==true) { 
        $(".mycheckbox").prop('checked', true);
      }
      else{
        $(".mycheckbox").prop('checked', false);
      }
    });

    $('.mycheckbox').click(function(){ 
      $(this).attr('checked',true);
      $("#select_all").attr('checked',false);
      if ($(".mycheckbox:checked").length == $(".mycheckbox").length ){ 
        $("#select_all").prop('checked', true);
      }
    });
  });
</script> 

<div class="modal fade" id="myModals">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <!-- Modal body -->
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(".quik").click(function(event){
     var t_length=$('.mycheckbox:checked').length;
       //alert(t_length);
    if(t_length >0)
    {
      var favorite = [];
      $.each($('.mycheckbox:checked'), function(){            
        favorite.push($(this).val());
      });
      var gr_id=favorite.join(",");
      var url='<?php echo SITE_URL."/admin/talentadmin/payallselected/" ?>'+encodeURIComponent(gr_id);
        $('.modal-body').load(url);
        $('#myModals').modal('show').find('.modal-body').load($(this).attr('href'));
    }
    else{
      alert('Select at least one checkbox');  
      return false;  
    }

    });
</script>


<!-- <script>
  $('.quik').click(function(e){ 
    e.preventDefault();
    $('#myModals').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script> -->



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
