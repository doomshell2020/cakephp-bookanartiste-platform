  <!----------------------editprofile-strt----------------------->
  <section id="edit_profile" class="gallery_tab">
      <div class="container">
          <div class="h_group">
              <h2> <span>Gallery Tab</span></h2>
              <p class="m-bott-50">Here You Can Manage Your Gallery Tab</p>
              <?php echo $this->Flash->render(); ?>
          </div>
          <div class="row">
              <?php echo  $this->element('editprofile') ?>
              <div class="tab-content">
                  <div id="Gallery" class="galleryTabContainer">
                      <div class="container m-top-60">
                          <div class="galleryTopBar pva_tab">
                              <?php echo  $this->element('galleryprofile') ?>
                              <div class="create-album-btn">
                                  <?php
                                    if ($album_limit_used >= $album_limit) { ?>
                                      <a href="#"
                                          onclick="showError('You have reached the limit of <?= $album_limit ?> albums. Please delete an existing album to create a new one');"
                                          class="btn redButton"
                                          data-toggle="modal">
                                          Create New Album
                                      </a>

                                  <?php } else { ?>

                                      <a href="#myalbum-Modal" class="btn redButton" data-toggle="modal">
                                          Create New Album
                                      </a>
                                  <?php } ?>

                              </div>

                              <a href="<?php echo SITE_URL; ?>/viewgalleries/<?php echo $id; ?>">
                                  <button class="btn btn-default">Already
                                      uploaded photos</button>
                              </a>
                          </div>

                          <div class="tab-content">
                              <div id="picture" class="tab-pane fade in active">
                                  <div class="">
                                      <div class="row">
                                          <?php $i = 1;
                                            //   pr($galleryprofile);exit;
                                            foreach ($galleryprofile as $key => $value) { //pr($value); die;  
                                            ?>

                                              <div class="col-md-2 col-sm-4 col-xs-6">
                                                  <?php $lastalbumimage = end($value['galleryimage']);
                                                    // pr($last); die;
                                                    ?>
                                                  <?php if ($value['galleryimage']['0']['imagename'] != '') { ?>
                                                      <!-- <figure class="imghvr-push-up my-album"> -->
                                                      <div class="albumTile">
                                                          <img src="<?php echo SITE_URL; ?>/gallery/<?php echo $lastalbumimage['imagename'] ?>">
                                                      <?php } else { ?>
                                                          <!-- <figure class="imghvr-push-up my-album"> -->
                                                          <div class="albumTile">
                                                              <img src="<?php echo SITE_URL; ?>/images/my-album-1.jpg">
                                                          <?php } ?>
                                                          <div class="tileButtonsContainer">
                                                              <a class="golink editButton" data-toggle="tooltip" data-placement="top" title="Edit" href='<?php echo SITE_URL; ?>/profile/images/<?php echo $value['id'];  ?>'>
                                                                  <i class="fa fa-pencil" aria-hidden="true"></i>
                                                              </a>
                                                              <a class="deleteButton" onclick="return confirm('Are You Sure You Want To Delete <?php echo $value['name'];  ?> Album')" data-toggle="tooltip" data-placement="top" title="Delete" href="<?php echo SITE_URL; ?>/profile/delete_directory/<?php echo urlencode($value['name']); ?>/<?php echo $value['id']; ?>">
                                                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                                              </a>

                                                          </div>
                                                          </div>
                                                          <!-- </figure> -->
                                                          <div class="text-center">
                                                              <h4><?php echo $value['name'];  ?></h4>
                                                          </div>
                                                      </div>
                                                      <!-- </figure> -->

                                                  <?php } ?>

                                              </div>

                                              <div class="row">

                                                  <?php foreach ($singleimages as $images) { //pr($images);exit; 
                                                    ?>
                                                      <div class="col-md-2 col-sm-4 col-xs-6">
                                                          <div class="albumTile">
                                                              <?php if ($images['status'] == 1) {
                                                                    $image = $images['imagename'];
                                                                    if ($image) {
                                                                        $imageSrc = SITE_URL . "/gallery/" . $image;
                                                                    } else {
                                                                        $imageSrc = SITE_URL . "/no-image-available.png";
                                                                    }


                                                                ?>
                                                                  <img src="<?php echo $imageSrc; ?>">

                                                              <?php } else { ?>
                                                                  <img src="<?php echo SITE_URL; ?>/images/my-album-1.jpg">
                                                              <?php } ?>

                                                              <div class="tileButtonsContainer">
                                                                  <a class="golink deleteButton" onclick="return confirm('Are You Sure You Want To Delete This Photo')" data-toggle="tooltip" data-placement="top" title="Delete Photo" href="<?php echo SITE_URL; ?>/profile/deleteimages/<?php echo urlencode($images['id']); ?>">
                                                                      <i class="fa fa-trash" aria-hidden="true"></i>
                                                                  </a>
                                                              </div>
                                                          </div>

                                                          <!-- Image Caption -->
                                                          <div class="text-center">
                                                              <h4><?php echo htmlspecialchars($images['caption']); ?></h4>
                                                          </div>
                                                      </div>
                                                  <?php } ?>

                                              </div>


                                              <!-- image upload form start  -->
                                              <div class="bottom-btn" style="margin-top: 20px;">
                                                  <?php
                                                    echo $this->Form->create($galleryimage, array(
                                                        'url' => array('controller' => 'profile', 'action' => 'images/' . $id),
                                                        'type' => 'file',
                                                        'inputDefaults' => array('div' => false, 'label' => false),
                                                        'class' => 'form-horizontal',
                                                        'id' => 'user_form',
                                                        'autocomplete' => 'off'
                                                    ));
                                                    ?>


                                                  <div style="display: flex;gap: 10px;">
                                                      <input
                                                          type="file"
                                                          class="form-control"
                                                          id="inputGroupFile04"
                                                          aria-describedby="inputGroupFileAddon04"
                                                          aria-label="Upload"
                                                          name="imagename[]"
                                                          required
                                                          multiple
                                                          accept=".jpg, .png, .jpeg">

                                                      <button
                                                          id="save_btn"
                                                          type="submit"
                                                          onclick='return validateImages();'
                                                          class="btn btn-primary"
                                                          onclick='this.form.action="profile/images/<?php echo empty($id) ? 0 : $id; ?>/save";'>
                                                          Upload Image
                                                      </button>
                                                  </div>


                                                  <script>
                                                      const fileInput = document.getElementById("inputGroupFile04");

                                                      fileInput.addEventListener("change", function() {
                                                          const files = this.files;
                                                          const maxSize = 5 * 1024 * 1024; // 5MB

                                                          for (let i = 0; i < files.length; i++) {
                                                              if (files[i].size > maxSize) {
                                                                  alert(`"${files[i].name}" is larger than 5MB. Please choose a smaller file.`);
                                                                  this.value = ""; // Reset input
                                                                  this.focus(); // Refocus input
                                                                  return;
                                                              }
                                                          }
                                                      });

                                                      function validateImages() {
                                                          const files = fileInput.files;
                                                          if (!files.length) {
                                                              alert("Please select at least one valid image.");
                                                              fileInput.focus(); // Focus again if nothing selected
                                                              return false;
                                                          }

                                                        //   const id = "<?php echo empty($id) ? 0 : $id; ?>";
                                                        //   fileInput.closest("form").action = `profile/images/${id}/save`;
                                                          return true;
                                                      }
                                                  </script>



                                                  <!-- <div class="upload_btn">
                                                      <div class="input-file-container pull-left">
                                                          <input class="input-file" id="file" type="file" name="imagename[]" required onchange="return fileValidation()" multiple accept=".jpg, .png, .jpeg">
                                                          <label tabindex="0" for="file" class="input-file-trigger">Upload Image</label>
                                                          <span id="fileuploadlength"></span>
                                                          <span id="ncpy" style="display: none; color: red">
                                                              Image Extension Allow .jpg|.jpeg|.png... Format Only
                                                          </span>
                                                      </div>
                                                      <p class="file-return"></p>
                                                  </div> -->

                                                  <div class="button_group">

                                                      <button id="save_btn" type="submit" class="btn btn-default"
                                                          onclick='this.form.action="profile/images/<?php echo empty($id) ? 0 : $id; ?>/save";'>
                                                          Save
                                                      </button>

                                                      <button id="submit_btn" type="button"
                                                          onclick="window.location.href='/viewgalleries'"
                                                          class="btn btn-default">
                                                          <?php echo __('Submit'); ?>
                                                      </button>

                                                  </div>


                                                  <?php echo $this->Form->end(); ?>
                                              </div>
                                              <!-- image upload form end  -->

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  </section>

  <!-- Modal for new album -->
  <div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title text-center" id="myModalLabel">Create New Album</h4>
              </div>
              <div class="modal-body">
                  <?php echo $this->Form->create($gallery, array('url' => array('controller' => 'profile', 'action' => 'galleries'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
                  <div class="form-group">
                      <label class="col-sm-12">Name :</label>
                      <div class="col-sm-12">
                          <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name', 'maxlength' => '25', 'id' => 'name', 'required', 'label' => false)); ?>

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
                  <h4 class="modal-title text-center" id="captionmodal">Add Caption for Image</h4>
              </div>
              <div class="modal-body">
                  <?php echo $this->Form->create($gallery, array('url' => array('controller' => 'profile', 'action' => 'updateimagecaption'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
                  <div class="form-group">
                      <label class="control-label col-sm-2">Caption :</label>
                      <div class="col-sm-10">
                          <?php echo $this->Form->input('caption', array('class' => 'form-control', 'placeholder' => 'Caption', 'maxlength' => '25', 'id' => 'name', 'required', 'label' => false)); ?>
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


  <script>
      function showError(error) {
          BootstrapDialog.alert({
              size: BootstrapDialog.SIZE_SMALL,
              title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !",
              message: "<h5>" + error + "</h5>"
          });
          return false;
      }
  </script>


  <script>
      $(document).ready(function() { //alert();
          $('#file').change(function() {
              var files = $(this)[0].files;
              $('#fileuploadlength').text('' + files.length + ' images Selected');
          });
      });

      //   var $form = $('form'),
      //       origForm = $form.serialize();
      //   $('.popcheckconfirm').on('click', function() {
      //       if ($form.serialize() !== origForm) {
      //           var result = confirm('Do you want to leave this page? Changes that you made may not be saved');
      //           if (result) {
      //               return true;
      //           } else {
      //               return false;
      //           }
      //       }
      //   });
  </script>