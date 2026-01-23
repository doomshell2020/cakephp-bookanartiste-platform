  <script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
  <section id="page_Messaging">
   
<div class="mess-box-container">
      <div class="container">
       <h2><span>Messaging</span></h2>
       <?php echo $this->Form->create($folders,array('url' => array('controller' => 'message', 'action' => 'actions'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'folder_form','autocomplete'=>'off')); ?>
       <div class="row profile-bg m-top-20">
           <?php echo  $this->element('messaginmenuleft') ?>
	    
          <div class="col-sm-9">
          
          <div class="ff"> 
        
        <div class="row">
       <div class="col-sm-3">
       <h4 class="text-left">Draft</h4>
       </div> 
	 <div class="col-sm-9">
     <a href="Javascript:void(0)" class="btn btn-primary" id="delete">Delete</a>
	<input type="hidden" name="action" id="action" value="">
	<input type="hidden" name="message_id" id="message_id" value="<?php echo ($messages[0]['id'] > 0)?$messages[0]['id']:'0'; ?>">
	 <input type="hidden" name="type" id="type" value="d">
     </div>
    </div> 
	   </div>
          
            <div class="messaging-cntnt-box">
             <div class="msz-inbox">
             
             <?php if(count($messages) > 0){ 
		foreach($messages as $messages_data){   //pr($messages_data);
             ?>
             <div class="row inbox-row box" id="row_<?php echo $messages_data['id']; ?>">
             <div class="col-sm-1"><input type="checkbox" name="thread_id[]" class="thread_id" id="thread_id" value="<?php echo $messages_data['thread_id']; ?>"></div>
             <div class="col-sm-2"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $messages_data['to_image']; ?>" class=" img-circle pull-left"><p class="pull-right"><a href="<?php echo SITE_URL; ?>/message/compose/draft/<?php echo $messages_data['id']; ?>"><?php echo $messages_data['to_name']; ?></a></p></div>
             <div class="col-sm-6"><p><a href="<?php echo SITE_URL; ?>/message/compose/draft/<?php echo $messages_data['id']; ?>"><?php echo $messages_data['subject']; ?></a></p></div>
             <div class="col-sm-3 time"><p><?php echo date("d-m-y h:i",strtotime($messages_data['created'])); ?></p></div>
             </div>
             
             <?php }
             }else{     ?>
             No Message available
             <?php } ?>
             
             </div> 
              
            </div>
          </div>
        </div>
         <?php echo $this->Form->end(); ?>
      </div>
</div>
  </section>
  
  
<script>
// Moving message to folder
$(document).ready(function() { 
    $("#folders").change(function() {
	 if (!$('.thread_id:checked').length > 0)
	 {
	    BootstrapDialog.alert({
	    size: BootstrapDialog.SIZE_SMALL,
	    title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	    message: "<h5>No Message Selected for moving in folder</h5>"
	    });
	    return false;
	 }
	 else
	 {
	    $("#action").val('folders');
	    $("#folder_form").submit();
	 }
    }); 	
});

// Deleteing Message
$(document).ready(function() { 
    $("#delete").click(function() { 
	if (!$('.thread_id:checked').length > 0)
	{
	    BootstrapDialog.alert({
	    size: BootstrapDialog.SIZE_SMALL,
	    title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	    message: "<h5>No Message Selected for delete</h5>"
	    });
	    return false;
	}
	else
	{
	   BootstrapDialog.confirm({
		title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
		message: 'Are you sure to want to Delete the selected messages?',
		draggable: true, 
		callback: function(result) {
		    if(result) {
			 $("#action").val('delete');
			$("#folder_form").submit();
		    }else {
			return false;
		    }
		}
	    });
	}
    }); 	
});

</script>