
<?php //pr($question_info); die;?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Vital Statistics
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
		      <h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Vital Statistics'; }else{ echo 'Add Vital Statistics';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->
		<?php echo $this->Flash->render(); ?>
		<?php echo $this->Form->create($packentity, array(
                       'class'=>'form-horizontal',
			'id' => 'content_admin',
                       'enctype' => 'multipart/form-data',
                     	'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>
		      <div class="box-body">
               <div class="form-group">
	    <label class="col-sm-3 control-label">Question</label>
	    <div class="field col-sm-6">
	    <?php echo $this->Form->input('question', array('class' => 
	    'form-control','required','placeholder'=>'Question','required','label'=>false,'type'=>'text','value'=>$question_info->question)); ?></div>
	    </div>
	    
	    <div class="form-group">
	    <label class="col-sm-3 control-label">Input Type</label>
	    <div class="field col-sm-6">
	    <?php echo $this->Form->input('category', array('class' => 
	    'longinput form-control','required','placeholder'=>'Name','required','label'=>false,'type'=>'select','options'=>$vsoptiontype,'empty'=>'--Select Type--','value'=>$question_info->option_type_id)); ?></div>
	    </div>
             
	      <div class="form-group">
	    <label class="col-sm-3 control-label">Options</label>
	    <div class="field col-sm-6">
	    
<div class="multi-field-wrapperpayment">
 <div class="option_container">
  
  <?php if($savedoptions && count($savedoptions) > 0){ 
  foreach($savedoptions as $options){
  ?>
  
  <div class="option_value">
   <div class="field col-sm-6">
    <input type="hidden" value="<?php echo $options['id'] ?>" name="datas[oid][]"/>
<div class="input text"><input type="text" name="datas[option_value][]" class="form-control" required="required" placeholder="Option Value" value="<?php echo htmlspecialchars($options['value']); ?>" id="question"></div>
</div>
 <div class="field col-sm-6">
  <button type="button" onclick="delete_option('<?php echo $options['id'] ?>');" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>
  </div>
  
  </div>
  
  <?php 
  }
  }else{?>
  
  <div class="option_value">
   <div class="field col-sm-6">

<div class="input text"><input type="text" name="datas[option_value][]" class="form-control" required="required" placeholder="Option Value" id="question"></div>
</div>
 <div class="field col-sm-6">
  <button type="button" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>
  </div>
  </div>
  <?php } ?>
   <div class="field col-sm-12"></div>
  </div>
   <div class="field col-sm-6"></div>
   
    <div class="field col-sm-6">
  <button type="button" class="btn add-paymentfield btn-danger btn-block"><i class="fa fa-add"></i> Add</button>
  </div>
  </div>
	    </div>
	    </div>

	        <div class="form-group">
	    <label class="col-sm-3 control-label">Gender</label>
	    <?php  $req= array('m'=>'Male','f'=>'Female','o'=>'All');?>
	    <div class="field col-sm-6">
	    <?php echo $this->Form->input('gender', array('class' => 
	    'longinput form-control','gender','placeholder'=>'Gender','required','label'=>false,'type'=>'radio','options'=>$req,'value'=>$question_info->gender)); ?></div>
	    </div>
	    
	    
	    
	    <div class="form-group">
	    <label class="col-sm-3 control-label">Required</label>
	    <?php  $req= array('Y'=>'Yes','N'=>'No');?>
	    <div class="field col-sm-6">
	    <?php echo $this->Form->input('required', array('class' => 
	    'longinput form-control','required','placeholder'=>'Name','required','label'=>false,'type'=>'radio','options'=>$req,'value'=>$question_info->required)); ?></div>
	    </div>
	    <label class="col-sm-3 control-label">OrderNumber</label>
	    <?php  $req= array('Y'=>'Yes','N'=>'No');?>
	    <div class="field col-sm-6">
	    <?php echo $this->Form->input('orderstrcture', array('class' => 
	    'longinput form-control','required','placeholder'=>'Order Number','required','label'=>false,'type'=>'number','value'=>$question_info->orderstrcture)); ?></div>
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
				if(isset($question_info->id)){
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
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end(); ?>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
   <script>
   
var site_url='<?php echo SITE_URL;?>/';
function delete_option(obj){
    $.ajax({
    type: "post",
    url: site_url+'admin/vitalstatistics/deleteoption',
    data:{datadd:obj},
    success:function(data){ 
    }
    });
}
   
   
   
$('.multi-field-wrapperpayment').each(function() { 
    var $wrapper = $('.option_container', this);
    $(".add-paymentfield", $(this)).click(function(e) { 
       var currentwork = $('.option_value:first-child', $wrapper).clone(true).appendTo($wrapper)
     currentwork.find('input').val('').focus();
     //   currentwork.find('select').val('').focus();
    currentwork.find('textarea').val('').focus();
    });
    
    
    $('.remove-field', $wrapper).click(function() {
        if ($('.option_value', $wrapper).length > 1)
            $(this).closest('.option_value').remove();
    });
});
	</script>

