<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Talent Admin Transcation
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title"> Transcation</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">
<a href="Javascript:void(0)" class="payout" onclick="assigntalentadminid('<?php echo $talent_admin_id;?>')">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Update Payout </button></a>

</div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
		<th>Date</th>
		<th>Name</th>
		<th>Description</th>
		<th>Transcation amount</th>
		<th>Commission Amount</th>
		<th>Payout Amount</th>
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(isset($transcations) && !empty($transcations)){ 
		foreach($transcations as $transcationsdata){
		?>
                <tr>
		<td><?php if(isset($transcationsdata['created_date'])){ echo $transcationsdata['created_date'];}else{ echo '-'; } ?></td>
		<td><?php if(isset($transcationsdata['user_id'])){ echo $transcationsdata->user['user_name'];}else{ echo '-'; } ?></td>
		<td><?php if(isset($transcationsdata['description'])){ echo $transcationsdata['description'];}else{ echo '-'; } ?></td>
		<td><?php if($transcationsdata['transcation_amount']>0){ echo "$".$transcationsdata['transcation_amount'];}else{ echo '-'; } ?></td>
		<td><?php if($transcationsdata['amount']>0){ echo "$".$transcationsdata['amount'];}else{ echo '-'; } ?></td>
		<td><?php if($transcationsdata['payout_amount']>0){ echo "$".$transcationsdata['payout_amount'];}else{ echo '-'; } ?></td>
                </tr>
		<?php $counter++;
		$total_tranc = $total_tranc+$transcationsdata['transcation_amount'];
		$total_comm = $total_comm+$transcationsdata['amount'];
		$total_payout = $total_payout+$transcationsdata['payout_amount'];
		
		} 
		?>
		<tr>
		<td><b>Total</b></td>
		<td></td>
		<td></td>
		<td><b><?php  echo "$".$total_tranc; ?></b></td>
		<td><b><?php  echo "$".$total_comm; ?></b></td>
		<td><b><?php  echo "$".$total_payout; ?></b></td>
                </tr>
		<?php }    
		

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
	    <?php echo $this->Form->create($packentity,array('url' => array('controller' => 'talentadmin', 'action' => 'updatepayout'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
	    <div class="form-group">
		<label class="control-label col-sm-2">Amount :</label>
		<div class="col-sm-10">
		<?php echo $this->Form->input('payout_amount',array('class'=>'form-control','placeholder'=>'Amount ($)','maxlength'=>'25','id'=>'name','required','label' =>false)); ?>
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
    function assigntalentadminid(talent_admin_id)
    {
	$('#talent_admin_id').val(talent_admin_id);
    }
  
    $('.payout').click(function(e){
	e.preventDefault();
	$('#myalbum-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>
