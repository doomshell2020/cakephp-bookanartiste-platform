  
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
                
                       
                      <div class="create-album-btn" style="margin: 5px;"><a href="#myalbum-Modal" class="btn btn-default" data-toggle="modal">Create New Album</a></div>
                			 <?php echo $this->Flash->render(); ?>

              <div class="tab-content">
                <div id="picture" class="tab-pane fade in active">
                  <div class="container m-top-60">
                    <div class="row">
			<?php foreach ($galleryprofile as $key=>$value){ pr($value);?>
                      <div class="col-sm-2">
			<?php if($value['galleryimage']['0']['imagename']!='') {?>
                        <figure class="imghvr-push-up my-album"><img src="<?php echo SITE_URL?>/gallery/<?php echo $value['galleryimage']['0']['imagename'] ?>">
                        
                        <?php }else{ ?>
					 <figure class="imghvr-push-up my-album"><img src="<?php echo SITE_URL?>/images/my-album-1.jpg">

							
							<?php } ?>
                        
                          <figcaption>
                            <p> <a class='golink' href='<?php echo SITE_URL?>/profile/images/<?php echo $value['id'];  ?>'><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></p>
                            <p><a href="<?php echo SITE_URL?>/profile/delete_directory/<?php echo $value['name'];  ?>/<?php echo $value['id'];  ?>"><i class="fa fa-times" aria-hidden="true"></i>Remove</a></p>
                          </figcaption>
                        </figure>
                        <div class="text-center">
                          <h4><?php echo $value['name'];  ?></h4>
                        </div>
                      </div>
                       <?php } ?>
                       </div>
                       <div class="row" style="margin-top:30px;">
                       <?php foreach ($singleimages as $images){ //pr($value);?>
                      <div class="col-sm-2">
			<?php if($images['imagename']!='') {?>
                        <figure class="imghvr-push-up my-album"><img src="<?php echo SITE_URL?>/gallery/<?php echo $images['imagename']; ?>">
                        
                        <?php }else{ ?>
					 <figure class="imghvr-push-up my-album"><img src="<?php echo SITE_URL?>/images/my-album-1.jpg">

							
							<?php } ?>
                        
                          <figcaption>
                            <p> <a class='golink' onclick="assignimageid('<?php echo $images['id'];?>')" href="#captionmodal" data-toggle="modal" '><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></p>
                            
                            <p> <a class='golink' href="<?php echo SITE_URL?>/profile/deleteimages/<?php echo $images['id'];?>"><i class="fa fa-trash" aria-hidden="true"></i>Remove</a></p>
                            
			
                           
                          </figcaption>
                        </figure>
                        <div class="text-center">
                          <h4><?php echo $images['caption'];  ?></h4>
                        </div>
                      </div>
                       <?php } ?>
                   
                    </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="clearfix">&nbsp;</div>
	    <?php echo $this->Form->create($galleryimage,array('url' => array('controller' => 'profile', 'action' => 'images/'.$id),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
	    <div class="input-file-container col-sm-2">
	    <input class="input-file" id="file" type="file" name="imagename[]" required onchange="return fileValidation()" multiple>
	    <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
	    <span id="ncpy" style= "display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
	    </div>
	    <p class="file-return"></p>
	    <div class="col-sm-4 col-sm-offset-6 text-right"><button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button></div>
	    <?php echo $this->Form->end(); ?>
                      
                  </div>
                </div>
             
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </div>
  </section>
    <!-- Modalfor new album -->
                      <div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title text-center" id="myModalLabel" >Create New Album</h4>
                            </div>
                            <div class="modal-body">
				<?php echo $this->Form->create($gallery,array('url' => array('controller' => 'profile', 'action' => 'galleries'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
                                <div class="form-group">
                                  <label class="control-label col-sm-2">Name :</label>
                                  <div class="col-sm-10">
                                  <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Name','maxlength'=>'25','id'=>'name','required','label' =>false)); ?>

                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="text-center col-sm-12">
									  <button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

                                  </div>
                                </div>
                          <?php echo $this->Form->end(); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                      
  <div class="modal fade" id="captionmodal" tabindex="-1" role="dialog" aria-labelledby="captionmodal">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title text-center" id="captionmodal" >Add Caption for Image</h4>
	</div>
	<div class="modal-body">
	    <?php echo $this->Form->create($gallery,array('url' => array('controller' => 'profile', 'action' => 'updateimagecaption'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
	    <div class="form-group">
		<label class="control-label col-sm-2">Caption :</label>
		<div class="col-sm-10">
		<?php echo $this->Form->input('caption',array('class'=>'form-control','placeholder'=>'Caption','maxlength'=>'25','id'=>'name','required','label' =>false)); ?>
		<input type="hidden" id="image_id" name="image_id" value="">
		<input type="hidden" name="album_id" name="album_id" value="<?php echo $galleryalbumname['id']; ?>">
		</div>
	    </div>
	    <div class="form-group">
		<div class="text-center col-sm-12">
	<button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

		</div>
	    </div>
	<?php echo $this->Form->end(); ?>
	</div>
	</div>
    </div>
    </div>
    
    
    
   
