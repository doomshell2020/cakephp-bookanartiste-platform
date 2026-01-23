 <!---------------------gallery----------------------->

 <div class="container" style="margin-top:60px;">
     <h2><?php echo $galleryalbumname['name']; ?>  </h2>
     <div class="row">
         <div class="single-page-gall" style="margin-bottom:40px;">

             <?php echo $this->Flash->render(); ?>

             <ul id="" class="list-unstyled row">
                 <?php foreach ($galleryprofileimage['galleryimage'] as $gall) { //pr($galleryprofileimage);die;
                    ?>
                     <div class="col-sm-2">
                         <?php if ($gall['status'] == 1) { ?>
                             <?php if ($gall['imagename'] != '') { ?>
                                 <div class="albumTile">
                                     <img src="<?php echo SITE_URL; ?>/gallery/<?php echo $gall['imagename']; ?>">
                                 <?php } else { ?>
                                     <div class="albumTile">
                                         <img src="<?php echo SITE_URL; ?>/images/my-album-1.jpg">
                                     <?php } ?>
                                 <?php } else {  ?>
                                     <div class="invisble_audi" style="position: absolute;left: 0;right: 0; bottom: 0; top: 0; z-index: 99; background-color: rgba(0,0,0,0.7);">
                                         <img src="<?php echo SITE_URL; ?>/images/invisible.png">
                                     </div>
                                     <?php if ($gall['imagename'] != '') { ?>
                                         <div class="albumTile">
                                             <img src="<?php echo SITE_URL; ?>/gallery/<?php echo $gall['imagename']; ?>">

                                         <?php } else { ?>
                                             <div class="invisble_audi" style="position: absolute;left: 0;right: 0; bottom: 0; top: 0; z-index: 99; background-color: rgba(0,0,0,0.7);">
                                                 <img src="<?php echo SITE_URL; ?>/images/invisible.png">

                                             </div>
                                             <div class="albumTile">
                                                 <img src="<?php echo SITE_URL; ?>/images/my-album-1.jpg">
                                             <?php } ?>
                                         <?php } ?>
                                         <div class="tileButtonsContainer">
                                             <!-- <a class="golink editButton" data-toggle="tooltip" data-placement="top"
                                             title="Edit" onclick="assignimageid('<?php //echo $gall['id']; 
                                                                                    ?>')"
                                             href="#captionmodal" data-toggle="modal"><i class="fa fa-pencil"
                                                 aria-hidden="true"></i>
                                         </a> -->

                                             <a
                                                 class="golink deleteButton"
                                                 data-toggle="tooltip"
                                                 data-placement="top"
                                                 title="Delete"
                                                 href="javascript:void(0);"
                                                 onclick="delete_images('<?php echo $gall['id']; ?>');">
                                                 <i class="fa fa-trash" aria-hidden="true"></i>
                                             </a>


                                         </div>
                                             </div>
                                             <div class="text-center">
                                                 <h4><?php echo $gall['caption'];  ?></h4>
                                             </div>
                                         </div>
                                     <?php } ?>

             </ul>


             <?php echo $this->Form->create($galleryimage, array('url' => array('controller' => 'profile', 'action' => 'images/' . $id), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

             <div class="d-flex justify-content-between align-items-between album_btns">
                 <div class="input-file-container">
                     <div style="display: flex; align-items: center; position: relative;">
                         <input class="input-file" id="file" type="file" name="imagename[]" required onchange="return fileValidation()" multiple>
                         <label tabindex="0" for="my-file" class="input-file-trigger" style="margin-bottom:0px;">Upload Image</label>
                         <span id="fileuploadlength" class="pl"></span>
                         <span id="ncpy" style="display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png...
                             Format
                             Only</span>
                     </div>
                 </div>
                 <p class="file-return"></p>
                 <div class="" style="display: flex;">
                     <div class="text-right">
                         <a href="<?php echo SITE_URL; ?>/galleries" class="btn backButton">Back to Album</a>
                     </div>
                     <div class="text-right" style="margin-left: auto;">
                         <button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
                     </div>
                 </div>

             </div>

             <?php echo $this->Form->end(); ?>
         </div>
     </div>
 </div>


 <div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title text-center" id="myModalLabel">Add Caption for Image</h4>
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
     function assignimageid(image_id) {
         $('#image_id').val(image_id);
     }

     var site_url = '<?php echo SITE_URL; ?>/';

     function delete_images(id) {
         if (confirm('Are You Sure You Want To Delete?')) {
             $.ajax({
                 type: "GET",
                 url: site_url + 'profile/deleteimages/' + id,
                 success: function(data) {
                     $("#div1" + id).remove();
                     alert('Photo deleted successfully');
                     location.reload();
                 },
                 error: function() {
                     alert("An error occurred while deleting the image.");
                 }
             });
         }
     }



     function fileValidation() {

         var fileInput = document.getElementById('file');
         var filePath = fileInput.value;
         var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
         //alert(allowedExtensions);
         if (!allowedExtensions.exec(filePath)) {
             $("#ncpy").css("display", "block");
             fileInput.value = '';
             return false;
         } else {
             //Image preview
             if (fileInput.files && fileInput.files[0]) {
                 var reader = new FileReader();
                 reader.onload = function(e) {
                     document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '"/>';
                 };
                 reader.readAsDataURL(fileInput.files[0]);
             }
         }
     }


     $(document).ready(function() { //alert();
         $('#file').change(function() {
             var files = $(this)[0].files;
             $('#fileuploadlength').text('' + files.length + ' images Selected. Click on Submit button to upload.');
         });
     });
 </script>