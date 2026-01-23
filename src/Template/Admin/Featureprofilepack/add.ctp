
<style type="text/css">
	.msg1, .msg2, .msg3{
		color: red;
	}
</style>
<div class="content-wrapper">
  	<!-- Content Header (Page header) -->
  	<section class="content-header">
  		<h1>
  			Featured Profile Package 
  		</h1>
  	</section>
  	<!-- Main content -->
  	<section class="content">
  		<div class="row">
  			<!-- right column -->
  			<div class="col-md-12">
  				<!-- Horizontal Form -->
  				<div class="box box-info">
  					<div class="box-header with-border">
  						<h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Recruiter Package'; }else{ echo 'Add Profile package';} ?></h3>
  					</div>
  					<!-- /.box-header -->
  					<!-- form start -->
  					<?php echo $this->Flash->render(); ?>
  					<?php echo $this->Form->create($packentity, array(

  						'class'=>'form-horizontal',
  						'id' => 'sevice_form',
  						'enctype' => 'multipart/form-data'
  						)); ?>

  						<div class="box-body">

  							<div class="form-group">
  								<label class="col-sm-3 control-label">Package Name</label>
  								<div class="field col-sm-6">
  									<?php echo $this->Form->input('name', array('class' => 
  									'longinput form-control','maxlength'=>'20','required','placeholder'=>'Package name','required','label'=>false)); ?></div>
  								</div>
							  <?php 
							 	if($packentity['validity_days']==1){
									$readonly = "readonly";
								 } 
							  ?>
  								<div class="form-group">
  									<label class="col-sm-3 control-label">Valid for(Number of Days)</label>
  									<div class="field col-sm-6">
  										<?php echo $this->Form->input('validity_days', array('class' => 
  										'longinput form-control','maxlength'=>'20','required','placeholder'=>'Days','required','label'=>false,'id'=>'txt3','type'=>'text',$readonly)); ?>
  										<span class="msg3" >Please Enter Valid Numeric Value!! </span>
  									</div>
  								</div>

  								<div class="form-group">
  									<label class="col-sm-3 control-label">Price </label>
  									<div class="field col-sm-6">
  										<?php echo $this->Form->input('price', array('class' => 
  										'longinput form-control','maxlength'=>'5','required','placeholder'=>'Price in USD','required','label'=>false,'id'=>'txt2','type'=>'text','autocomplete'=>'off')); ?>
  										<span class="msg2" >Please Enter Valid Numeric Value!! </span>
  									</div>
  								</div>

  								<div class="form-group">
  									<label class="col-sm-3 control-label">Visibility Priority</label>
  									<div class="field col-sm-6">
  										<?php echo $this->Form->input('priorites', array('class' => 
  										'longinput form-control ','maxlength'=>'3','required','placeholder'=>'Priorites','required','label'=>false,'id'=>'txt1','type'=>'text')); ?>
  										<span class="msg1" >Please Enter Valid Numeric Value!! </span>
  									</div>
  								</div>

  								<div class="form-group">
  									<label class="col-sm-3 control-label">Default</label>
  									<div class="field col-sm-6">
  										<input type="checkbox" value="Y" <?php if($packentity['is_default']=='Y'){echo "checked";} ?> name="is_default">
  									</div>
  								</div>
  							</div><!--content-->

  							<!-- /.form group -->
  						</div>
  						<!-- /.box-body -->
  						<div class="box-footer">
  							<?php
  							echo $this->Html->link('Back', [
  								'action' => 'index'

  								],['class'=>'btn btn-default']); ?>

  							<?php
  							if(isset($transports['id'])){
  								echo $this->Form->submit(
  									'Update', 
  									array('class' => 'btn btn-info pull-right', 'title' => 'Update')
  									); 
  							}else{ 
  								echo $this->Form->submit(
  									'Add', 
  									array('class' => 'btn btn-info pull-right', 'title' => 'Add')
  									);
  								}
  								?>
  							</div>
  							<!-- /.box-footer -->
  							<?php echo $this->Form->end(); ?>
  						</div>

  					</div>
  					<!--/.col (right) -->
  				</div>
  				<!-- /.row -->
  			</section>
  			<!-- /.content -->
  		</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.msg1').hide();
	$('.msg2').hide();
	$('.msg3').hide();

	$('#txt1').keyup(function(){
		var val = parseFloat($('#txt1').val());
		if (isNaN(val) || (val === 0))
		{
		    $('.msg1').show();
		    //alert("Please Enter Correct value");
		    $('#txt1').val('');
		    return false;
		}else{
			$('.msg1').hide();
			return true;
		}
	});

	$('#txt2').keyup(function(){
		var val = parseFloat($('#txt2').val());
		if (isNaN(val) || (val === 0))
		{
		    $('.msg2').show();
		    //alert("Please Enter Correct value");
		    $('#txt2').val('');
		    return false;
		}else{
			$('.msg2').hide();
			return true;
		}
	});

	$('#txt3').keyup(function(){
		var val = parseFloat($('#txt3').val());
		if (isNaN(val) || (val === 0))
		{
		    $('.msg3').show();
		    //alert("Please Enter Correct value");
		    $('#txt3').val('');
		    return false;
		}else{
			$('.msg3').hide();
			return true;
		}
	});
})
</script>