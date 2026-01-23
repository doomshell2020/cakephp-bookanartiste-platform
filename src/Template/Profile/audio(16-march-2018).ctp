  
<!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2>Edit <span>Profile</span></h2>
      <p class="m-bott-50">Here You Can Create Your Profile</p>
      <div class="row">
          <?php echo  $this->element('editprofile') ?>
        <div class="tab-content">
          <div id="Gallery" class="">
            <div class="container m-top-60">
            <?php echo  $this->element('galleryprofile') ?>
                			 <?php echo $this->Flash->render(); ?>

              <div class="tab-content">
               
                <div id="Video" class="">
                  <div class="container m-top-60">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="col-sm-12 gall-bg">
                          <div class="col-sm-5">URL</div>
                          <div class="col-sm-5">Title</div>
                          <div class="col-sm-2"></div>
                        </div>
                        <div class="col-sm-12">
                        <?php echo $this->Form->create('Audio',array('url' => array('controller' => 'profile', 'action' => 'audio'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
                        <div class="multi-field-wrapper">

						<div class="video_container">
							<?php if(count($videoprofile)>0)
								{ ?>
							   <?php foreach($videoprofile as $prop){ ?>	
						<div class="video_details">	

                            <div class="row">
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('audio_link', array('value'=>$prop['audio_link'],'class' => 'form-control','type'=>'url','required'=>'true','label' =>false,'name'=>'data[audio_link][]','placeholder'=>'URL')); ?>
								  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>

                              </div>
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('audio_type', array('value'=>$prop['audio_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[audio_type][]','placeholder'=>'title')); ?>
                              </div>
                                 <div class="col-sm-2 gall_audio-sec text-center">
                            		<a href="javascript:void(0);" class="delete_detials btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a>		
                              </div>
                            </div>
                          
                            </div>  
                          <?php }}else{ ?>
                          <div class="video_details">	

                            <div class="row">
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('audio_link', array('value'=>$prop['audio_link'],'class' => 'form-control','type'=>'url','required'=>'true','label' =>false,'name'=>'data[audio_link][]','placeholder'=>'URL')); ?>
								  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>

                              </div>
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('audio_type', array('value'=>$prop['audio_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[audio_type][]','placeholder'=>'Title')); ?>
                              </div>
                                <div class="col-sm-2 gall_audio-sec text-center">
									
						<a href="javascript:void(0);" class="delete_detials btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a>			
								
                              </div>
                              
                              
                            </div>
                          
                            </div> 
                          
                          
                          
                          <?php } ?>
                           </div>
                          
                          <div class="row">
                          <a type="button" class="btn-primary add-field pull-right">Add </a>

                          </div>
                          </div> 
                          <input type="submit" value="Save" class="btn-primary pull-left">   

                      <?php echo $this->Form->end();?>   

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
           
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </div>
  </section>

<script>
	$('.delete_detials').click(function() { //alert();
 paymentcurrent_id = $(this).data('val');
   $.ajax({
        type: "post",
        url: site_url+'profile/deleteaudio',
        data:{datadd:paymentcurrent_id},
       
        success:function(data){ 
	 	    }
        });
 
 
});


    
	
	
$('.multi-field-wrapper').each(function() { 
    var $wrapper = $('.video_container', this);
    $(".add-field", $(this)).click(function(e) { 
        var manageport= $('.video_details:first-child', $wrapper).clone(true).appendTo($wrapper)
        
        manageport.find('input').val('').focus();
         manageport.find('[data-val]').attr("data-val" , '');
        
        
    });
    $('.remove-field', $wrapper).click(function() {
        if ($('.video_details', $wrapper).length > 1)
            $(this).closest('.video_details').remove();
    });
});
	</script>
	
 
