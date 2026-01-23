  
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
                          <div class="col-sm-5">url</div>
                          <div class="col-sm-5">Caption</div>
                          <div class="col-sm-2"></div>
                        </div>
                        <div class="col-sm-12">
                        <?php echo $this->Form->create('Video',array('url' => array('controller' => 'profile', 'action' => 'video'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
                        <div class="multi-field-wrapper">

						<div class="video_container">
							<?php if(count($videoprofile)>0)
								{ ?>
							   <?php foreach($videoprofile as $prop){ ?>	
						<div class="video_details">	

                            <div class="row">
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('video_name', array('value'=>$prop['video_name'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_name][]','placeholder'=>'Enter url')); ?>
								  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>

                              </div>
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('video_type', array('value'=>$prop['video_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_type][]','placeholder'=>'Caption')); ?>
                              </div>
                                 <div class="col-sm-2 gall_audio-sec text-center">
                              <button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>
                              </div>
                            </div>
                          
                            </div>  
                          <?php }}else{ ?>
                          <div class="video_details">	

                            <div class="row">
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('video_name', array('value'=>$prop['video_name'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_name][]','placeholder'=>'Enter url')); ?>
								  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>

                              </div>
                              <div class="col-sm-5 gall_audio-sec">
								  <?php echo $this->Form->input('video_type', array('value'=>$prop['video_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_type][]','placeholder'=>'Caption')); ?>
                              </div>
                                <div class="col-sm-2 gall_audio-sec text-center">
                              <button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>
                              </div>
                              
                              
                            </div>
                          
                            </div> 
                          
                          
                          
                          <?php } ?>
                           </div>
                          
                          <div class="row">
                          <button type="button" class="btn-primary add-field pull-right">Add </button>

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
		var site_url='<?php echo SITE_URL;?>/';

function delete_detials(obj){

        $.ajax({
        type: "post",
        url: site_url+'profile/deletevideo',
        data:{datadd:obj},
       
        success:function(data){ 
	 	    }
           
        });
   }
</script>
<script>
	
    
	
	
$('.multi-field-wrapper').each(function() { 
    var $wrapper = $('.video_container', this);
    $(".add-field", $(this)).click(function(e) { 
        $('.video_details:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.remove-field', $wrapper).click(function() {
        if ($('.video_details', $wrapper).length > 1)
            $(this).closest('.video_details').remove();
    });
});
	</script>
	
 
