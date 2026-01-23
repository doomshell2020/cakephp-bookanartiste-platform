  
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
                <div id="picture" class="tab-pane fade in active">
                  <div class="container m-top-60">
                    <div class="row">
						
						
						<?php foreach ($galleryprofile as $key=>$value){ //pr($value);?>
                      <div class="col-sm-2">
                        <figure class="imghvr-push-up my-album"><img src="<?php echo SITE_URL?>/images/my-album-1.jpg">
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
                    
                     
                      <div class="col-sm-12"><a href="#myalbum-Modal" class="btn btn-default" data-toggle="modal">Create New Album</a></div>
                      
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
  
