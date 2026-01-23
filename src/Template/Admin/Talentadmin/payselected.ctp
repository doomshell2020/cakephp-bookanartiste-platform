	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title text-center" id="myModalLabel" >Update Payout Information</h4>
	</div>
	<div class="modal-body">
	    <?php  //pr($talenttraid); die;
	    echo $this->Form->create($talenttraid,array('url' => array('controller' => 'talentadmin', 'action' => 'payselected'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
	    <div class="form-group">
		<label class="control-label col-sm-3">Write Note :</label>
		<div class="col-sm-9">
		<?php echo $this->Form->input('write_notes',array('class'=>'form-control','placeholder'=>'Write the invoice raised by talent manager, or any observations','type'=>'textarea','required','label' =>false)); ?>
		</div>
	    </div>

		<?php foreach ($talenttraid as $key => $value) {
		if ($value['description']=='PAR') {
          $packtype="Post a Requirement";
        }elseif ($value['description']=='PP') {
          $packtype="Profile Package";
        }elseif ($value['description']=='RP') {
          $packtype="Recruiter Package";
        }elseif ($value['description']=='PG') {
          $packtype="Ping";
        }elseif ($value['description']=='PQ') {
          $packtype="Paid Quote Sent";
        }elseif ($value['description']=='AQ') {
          $packtype="Ask for Quote";
        }elseif ($value['description']=='PA') {
          $packtype="Profile Advertisement";
        }elseif ($value['description']=='JA') {
          $packtype="Job Advertisement";
        }elseif ($value['description']=='BNR') {
          $packtype="Banner";
        }elseif ($value['description']=='FJ') {
          $packtype="Feature Job";
        }elseif ($value['description']=='FP') {
          $packtype="Feature Profile";
        }
		 ?>
	     <div class="form-group">

		<label class="control-label col-sm-3">
			<?php echo $packtype; ?>
			<?php echo $this->Form->input('id[]',array('class'=>'form-control','type'=>'hidden','value'=>$value['id'],'label' =>false)); ?>
		</label>
		<div class="col-sm-9">
			<?php echo $this->Form->input('payout_amount[]',array('class'=>'form-control','readonly'=>true,'type'=>'text','value'=>$value['amount'],'label' =>false)); ?>
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