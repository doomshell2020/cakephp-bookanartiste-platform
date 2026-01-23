	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title text-center" id="myModalLabel" >Update Payout Information</h4>
	</div>
	<div class="modal-body">
	    <?php  //pr($talenttraid); die;
	    echo $this->Form->create('payall',array('url' => array('controller' => 'talentadmin', 'action' => 'payallselected'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
	    <div class="form-group">
		<label class="control-label col-sm-3">Write Note :</label>
		<div class="col-sm-9">
		<?php echo $this->Form->input('write_notes',array('class'=>'form-control','placeholder'=>'Write the invoice raised by talent manager, or any observations','type'=>'textarea','required','label' =>false)); ?>
		</div>
	    </div>

		<?php //pr($talenttraids); die;
		foreach ($talenttraids as $key => $value) { //pr($value); ?>
	     <div class="form-group">

		<label class="control-label col-sm-3">
			<?php echo $value['talent_name']; ?>
			<?php echo $this->Form->input('id[]',array('class'=>'form-control','type'=>'hidden','value'=>$value['talent_admin_id'],'label' =>false)); ?>
		</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('total[]',array('class'=>'form-control','readonly'=>true,'type'=>'text','value'=>$value['total'],'label' =>false)); ?>
		</div>

	    </div>
		<?php } ?>

	    <div class="form-group">
		<div class="text-center col-sm-12">
	<button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

		</div>
	    </div>
	<?php echo $this->Form->end(); ?>
	</div>