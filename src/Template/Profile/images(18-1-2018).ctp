 <!---------------------gallery----------------------->
  
  <div class="container m-top-60">
    <h2>Images</h2>
    <div class="row single-page-gall">
		
      <div class="text-right m-bott-50 col-sm-12"><a href="<?php echo SITE_URL;?>/galleries" class="btn btn-default">Back to Album</a></div>
      
      <?php echo $this->Flash->render(); ?>
      
      <div class="demo-gallery">
            <ul id="lightgallery" class="list-unstyled row">
            
      <?php foreach($galleryprofileimage['galleryimage'] as $gall){ //pr($gall);	
?><div id="div1<?php echo $gall['id'] ?>" >



      <li class="col-xs-6 col-sm-4 col-md-2 my-album-images" data-src="<?php echo SITE_URL?>/gallery/<?php echo $galleryprofileimage['name'];?>/<?php echo $gall['imagename'];?>">
  
      <img src="<?php echo SITE_URL?>/gallery/<?php echo $galleryprofileimage['name'];?>/<?php echo $gall['imagename'];?>">

   
      
      <div class="remove-img">
		  

   
  
		
      <a href="#" class="btn btn-default">View all</a>
      
      
      </div>
      <button type="button" onclick="delete_images(<?php echo $gall['id'] ?>,<?php echo $gall['gallery_id'] ?>);" class="btn btn-primary btn-block">Remove</button>
      </li>
      
       <?php } ?>
      </ul>
      </div>
 </div>
      
     

    </div>
   <div class="clearfix"> <div class="col-sm-2 m-bott-20">
		       
		
<?php echo $this->Form->create($galleryimage,array('url' => array('controller' => 'profile', 'action' => 'images/'.$id),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
        <div class="input-file-container">

      <input class="input-file" id="file" type="file" name="imagename[]" onchange="return fileValidation()" multiple>
          <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                          <span id="ncpy" style= "display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

        </div>
        <p class="file-return"></p>
        <button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

<?php echo $this->Form->end(); ?>
      
      <!--<form>
          <input type="file">
        </form>--> 
    </div></div>
  </div>
  <script type="text/javascript">
        $(document).ready(function(){
            $('#lightgallery').lightGallery();
        });
        </script> 
  <script>
		var site_url='<?php echo SITE_URL;?>/';

function delete_images(obj,id){
	//alert(id);
        $.ajax({
        type: "post",
        url: site_url+'profile/deleteimages',
        data:{datadd:obj,imageid:id},
       
        success:function(data){ 
			$("#div1"+data).remove();
	 	    }
           
        });
   }
</script>
<script  type="text/javascript">
function fileValidation(){
	
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    //alert(allowedExtensions);
    if(!allowedExtensions.exec(filePath)){
       $("#ncpy").css("display", "block");
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>
