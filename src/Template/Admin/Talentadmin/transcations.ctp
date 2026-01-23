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
      Transaction Manager
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
        url:"<?php echo ADMIN_URL ;?>talentadmin/searchtranscation/<?php echo $talentadmin['id']; ?>"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('url'=>array('controller'=>'products','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


<div class="form-group">
  <div class="col-sm-3">
   <?php echo $this->Form->input('from_date',array('class'=>'form-control','placeholder'=>'From Date','data-date-format'=>'yyyy-mm-dd','id'=>'from_date','label' =>false)); ?>
 </div> 

 <div class="col-sm-3">
  <?php echo $this->Form->input('to_date',array('class'=>'form-control','placeholder'=>'To Date', 'data-date-format'=>'yyyy-mm-dd', 'id'=>'to_date','label' =>false)); ?>
</div> 

 <div class="col-sm-3">
  <?php echo $this->Form->input('invoice',array('class'=>'form-control','placeholder'=>'Invoice Number','label' =>false)); ?>
</div> 

</div>
<div class="form-group">
<div class="col-sm-6">

<button type="submit" class="btn btn-success">Search</button>
<button type="reset" class="btn btn-primary">Reset</button>
<a class="btn btn-success" href="<?php echo ADMIN_URL; ?>talentadmin/exporttranscation">Export to Excel</a>
</div>
</div>
<?php
echo $this->Form->end();
?>   

</div>
</div>
</div>	
<div class="box">
  <div>
    <h3 class="text-center"> 
    <a data-toggle="modal" class='bankdata' href="<?php echo SITE_URL; ?>/admin/talentadmin/bankdetails/<?php echo $talent_admin_id; ?>">
    <?php echo ucfirst($talentadmin['user_name'])." (".$talentadmin['email'].")"; ?> </a> Pending Transactions
    </h3>           
  </div>

  <!-- /.box-header -->

  <div class="row">
    <div class="col-xs-12">
     <div class="box">
       <div class="clearfix">

        <a href="Javascript:void(0)" class="quik">
          <button class="btn btn-success pull-right "><i class="fa fa-plus" aria-hidden="true"></i>
            Update Payout </button></a>
          <a href="<?php echo ADMIN_URL; ?>talentadmin/comissionmanager">
          <button class="btn btn-primary pull-left ">
            Commission Manager</button>
          </a>


          </div>
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

            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>
                      <input type="checkbox" id="select_all" class="selectcheck" name="check[]" value="<?php echo $value['id']; ?>"></th>
                      <th>Sr. No</th>
                      <th>Invoice Number</th>
                      <th>Date of Invoice</th>
                      <th>Invoice Type</th>
                      <th>Invoice Total</th>
                      <th>Revenue Share Due</th>
                      <th>Date of Payout</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="example2">
                    <?php 
                    $counter = 1;
                    if(isset($transcations) && !empty($transcations)){ 
		//pr($transcations); die;
                      foreach($transcations as $transcationsdata){
                        if ($transcationsdata['description']=='PAR') {
                          $packtype="Post a Requirement";
                        }elseif ($transcationsdata['description']=='PP') {
                          $packtype="Profile Package";
                        }elseif ($transcationsdata['description']=='RP') {
                          $packtype="Recruiter Package";
                        }elseif ($transcationsdata['description']=='PG') {
                          $packtype="Ping";
                        }elseif ($transcationsdata['description']=='PQ') {
                          $packtype="Paid Quote Sent";
                        }elseif ($transcationsdata['description']=='AQ') {
                          $packtype="Ask for Quote";
                        }elseif ($transcationsdata['description']=='PA') {
                          $packtype="Profile Advertisement";
                        }elseif ($transcationsdata['description']=='JA') {
                          $packtype="Job Advertisement";
                        }elseif ($transcationsdata['description']=='BNR') {
                          $packtype="Banner";
                        }elseif ($transcationsdata['description']=='FJ') {
                          $packtype="Feature Job";
                        }elseif ($transcationsdata['description']=='FP') {
                          $packtype="Feature Profile";
                        }
                        ?>
                        <tr>
                          <td>
                          <?php if($transcationsdata['payout_amount']==0){ ?>
                            <input type="checkbox" class="selectcheck mycheckbox" name="check[]" value="<?php echo $transcationsdata['id']; ?>">
                            <?php }else{ ?>
                            <input type="checkbox" disabled="disabled">
                              <?php } ?>
                          </td>
                          <td><?php echo $counter; ?></td>
                          <td><?php echo $transcationsdata['transaction_id']; ?></td>
                          <td><?php if(isset($transcationsdata['created_date'])){ echo $transcationsdata['created_date']; }else{ echo '-'; } ?></td>
                          <td><?php if(isset($transcationsdata['description'])){ echo $packtype;}else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']>0){ echo "$".$transcationsdata['payout_amount'];}else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']<1){ echo "$".$transcationsdata['amount'];}else{ echo '-'; } ?></td>
                          <td><?php if(isset($transcationsdata['paid_date'])){ echo $transcationsdata['paid_date']; }else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']>0){ ?>
                            
                           <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminids('<?php echo $transcationsdata['id']; ?>','<?php echo $transcationsdata['write_notes']; ?>')">
                           <button  class="btn btn-primary">
                           Paid</button>
                          </a>
                          <?php }else{ ?>
                          <a href="<?php echo SITE_URL ?>/admin/talentadmin/payselected/<?php echo $transcationsdata['id']; ?>" class="quiks">
                            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                              Update Payout 
                            </button>
                          </a>
                          <?php } ?>
                          </td>
                          

                        </tr>
                        <?php $counter++;
		//$total_tranc = $total_tranc+$transcationsdata['transcation_amount'];
                        $total_comm = $total_comm+$transcationsdata['payout_amount'];
                        
                      } 
                      ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>

                      <tr>
                        <td></td>
                        <td><b>Total</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?php echo "$".$total_comm; ?></b></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php 

                    }
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

    <!-- Dynamic modal -->

<div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title text-center" id="myModalLabel" >Update Payout Information</h4>
     </div>
     <div class="modal-body">
       <?php echo $this->Form->create($packentity,array('url' => array('controller' => 'talentadmin', 'action' => 'paidtransaction'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
       <div class="form-group">
        <label class="control-label col-sm-2">Change Note :</label>
        <div class="col-sm-10">
          <?php echo $this->Form->input('write_notes',array('class'=>'form-control','placeholder'=>'Write the invoice raised by talent manager, or any observations','type'=>'text','required','id'=>'wrnote','label' =>false)); ?>
          <input type="hidden" id="talent_admin_id" name="talent_admin_id" value="">
        </div>
      </div>
      <div class="form-group">
        <div class="text-center col-sm-12">
         <button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

       </div>
     </div>
     <?php echo $this->Form->end(); ?>
   </div>
 </div>
</div>
</div>
 <!-- /.modal -->


 <script>
  function assigntalentadminids(talent_admin_id,note)
  {
   $('#talent_admin_id').val(talent_admin_id);
   $('#wrnote').val(note);
 }

 $('.payout').click(function(e){
   e.preventDefault();
   $('#myalbum-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
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
  $(".quik").click(function(){
   var t_length=$('.mycheckbox:checked').length;
    //event.preventDefault();
       //alert(t_length);
       if(t_length >0)
       {
        var favorite = [];
        $.each($('.mycheckbox:checked'), function(){            
          favorite.push($(this).val());
        });
        var gr_id=favorite.join(",");
        var url='<?php echo SITE_URL."/admin/talentadmin/payselected/" ?>'+encodeURIComponent(gr_id);
        $('.modal-body').load(url);
        $('#myModals').modal('show').find('.modal-body').load($(this).attr('href'));
      }
      else{
        alert('Select at least one checkbox');  
        return false;  
      }

    });
  </script>


  <script>
    $('.quiks').click(function(e){ 
      e.preventDefault();
      $('#myModals').modal('show').find('.modal-body').load($(this).attr('href'));
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

  <script >
$(document).ready(function () { //alert();
  $( "#from_date" ).datepicker();
  $( "#to_date" ).datepicker();
});

</script>

