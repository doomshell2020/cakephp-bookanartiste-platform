  <script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
  <section id="page_Messaging">
    
<div class="mess-box-container">
      <div class="container">
      <h2><span>Messaging</span></h2>
        <div class="row profile-bg m-top-20">
        <?php echo $this->Flash->render(); ?>
           <?php echo  $this->element('messaginmenuleft') ?>
       
          <div class="col-sm-9">
          <h4 class="text-left">Folders</h4>
            <div class="messaging-cntnt-box">
             <div class="msz-inbox">
             
             <?php if(count($folders) > 0){ 
		foreach($folders as $folders_data){   //pr($folders_data);
             ?>
             <div class="inbox-row box folders_list" id="row_<?php echo $folders_data['id']; ?>">
             <div class="row">
             <div class="col-sm-2"><p class="pull-left"><a href="<?php echo SITE_URL; ?>/message/folderview/<?php echo $folders_data['id']; ?>"><span class="fa fa-folder folder_icon"></span><?php echo $folders_data['folder_name']; ?></a></p></div>
             <div class="col-sm-7"><p></p></div>
             <div class="col-sm-3 time"><p><?php echo date("d-m-y h:i",strtotime($folders_data['created'])); ?></p><a href="Javascript:void(0)" data-val="<?php echo $folders_data['id']; ?>" class="fa fa-remove deletefolder"></a></div>
             </a>
             </div>
             </div> 
             <?php }
             }else{     ?>
             No Folders available
             <?php } ?>
             
             
              
            </div>
          </div>
        </div>
      </div>
</div>
  </section>
  
  
  <script>
    /*  Block Profile profile*/
$('.deletefolder').click(function() {  
    folder_id = $(this).data('val');
    $.ajax({
	    type: "POST",
	    url: '<?php echo SITE_URL;?>/message/deletefolder',
	    data: {folder_id: folder_id},
	    cache:false,
	    success:function(data){ 
		obj = JSON.parse(data);
		if(obj.status==1)
		{
		    $("#row_"+folder_id).remove();
        location.reload();
		}
		else
		{
		   showerror(obj.error_text);
		}
	    }
	});
});


function showerror(error)
{
    BootstrapDialog.alert({
	size: BootstrapDialog.SIZE_SMALL,
	title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	message: "<h5>"+error+"</h5>"
	});
    return false;
}
  </script>