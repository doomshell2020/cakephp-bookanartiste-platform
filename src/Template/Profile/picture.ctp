
<?php echo $this->Form->create($gallery,array('url' => array('controller' => 'profile', 'action' => 'picture'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>


<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Name','maxlength'=>'25','id'=>'name','required','label' =>false)); ?>





<button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
<?php echo $this->Form->end(); ?>


<?php foreach ($galleryprofile as $key=>$value){ ?>
	<a class='golink' href='<?php echo SITE_URL?>/profile/images/<?php echo $value['id'];  ?>'><img src="<?php echo SITE_URL?>/images/folder-icon.png" height="100px" width="100px"></a>
<?php echo $value['name'];  ?>
	
 <?php } ?>
 
 <script>
jQuery(function($) {
    $('.golink').click(function() {
        return false;
    }).dblclick(function() {
        window.location = this.href;
        return false;
    });
});
</script>
