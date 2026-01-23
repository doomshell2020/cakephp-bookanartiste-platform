<?php echo $this->Form->create($messagess,array('url' => array('controller' => 'message', 'action' => 'reply'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'folder_form','autocomplete'=>'off')); ?>
    <div class="col-sm-8">
	<input type="hidden" name="parent_id" id="parent_id" value="<?php echo ($messages['parent_id'])?$messages['parent_id']:$messages['id']; ?>">
	<input type="hidden" name="thread_id" id="thread_id" value="<?php echo ($messages['thread_id'])?$messages['thread_id']:$messages['id']; ?>">
	<?php echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'Description','id'=>'description','required'=>true,'label' =>false,'type'=>'textarea','rows'=>'20')); ?>
    </div>
    <div class="col-sm-8">
    <br>
	<button type="submit" class="btn btn-default">Send</button>
    </div>
<?php echo $this->Form->end(); ?>


















