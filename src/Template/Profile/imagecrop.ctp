<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="http://www.phpzag.com/demo/image-upload-image-crop-modal-php-jQuery/dist_files/jquery.imgareaselect.js" type="text/javascript"></script>
<script src="http://www.phpzag.com/demo/image-upload-image-crop-modal-php-jQuery/dist_files/jquery.form.js"></script>
<link rel="stylesheet" href="http://www.phpzag.com/demo/image-upload-image-crop-modal-php-jQuery/dist_files/imgareaselect.css">


<title>Serverside Countdown Timer </title>
</head>
<body>
<div>
<img class="img-circle" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="default.jpg"/>
<br><br>
<a type="button" class="btn btn-primary" id="change-profile-pic">Change Profile Picture</a>
</div>               



<div id="profile_pic_modal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3>Change Profile Picture</h3>
</div>
<div class="modal-body">
<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo SITE_URL; ?>/profile/changeProfilePic">
<strong>Upload Image:</strong> <br><br>
<input type="file" name="profile-pic" id="profile-pic" />
<?php $current_user_id = $this->request->session()->read('Auth.User.id'); ?>
<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value=<?php echo $current_user_id; ?>>
<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
<input type="hidden" name="action" value="" id="action" />
<input type="hidden" name="image_name" value="" id="image_name" />
<div id='preview-profile-pic'></div>
<div id="thumbs" style="padding:5px; width:600p"></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
</div>
</div>
</div>
</div>





<script>
jQuery(document).ready(function(){
	/* When click on change profile pic */	
	jQuery('#change-profile-pic').on('click', function(e){
        jQuery('#profile_pic_modal').modal({show:true});        
    });	
	jQuery('#profile-pic').on('change', function()	{ 
		jQuery("#preview-profile-pic").html('');
		jQuery("#preview-profile-pic").html('Uploading....');
		jQuery("#cropimage").ajaxForm(
		{
		target: '#preview-profile-pic',
		success:    function() { 
				jQuery('img#photo').imgAreaSelect({
				aspectRatio: '1:1',
				onSelectEnd: getSizes,
			});
			jQuery('#image_name').val(jQuery('#photo').attr('file-name'));
			}
		}).submit();

	});
	/* handle functionality when click crop button  */
	jQuery('#save_crop').on('click', function(e){
    e.preventDefault();
    params = {
            targetUrl: '<?php echo SITE_URL;?>/profile/changeimage',
            action: 'save',
            x_axis: jQuery('#hdn-x1-axis').val(),
            y_axis : jQuery('#hdn-y1-axis').val(),
            x2_axis: jQuery('#hdn-x2-axis').val(),
            y2_axis : jQuery('#hdn-y2-axis').val(),
            thumb_width : jQuery('#hdn-thumb-width').val(),
            thumb_height:jQuery('#hdn-thumb-height').val()
        };
        saveCropImage(params);
    });
    /* Function to get images size */
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
			jQuery('#hdn-x1-axis').val(x_axis);
			jQuery('#hdn-y1-axis').val(y_axis);
			jQuery('#hdn-x2-axis').val(x2_axis);
			jQuery('#hdn-y2-axis').val(y2_axis);
			jQuery('#hdn-thumb-width').val(thumb_width);
			jQuery('#hdn-thumb-height').val(thumb_height);
        } else {
            alert("Please select portion..!");
		}
    }
    /* Function to save crop images */
    function saveCropImage(params) { //alert(params);
		jQuery.ajax({
			url: params['targetUrl'],
			cache: false,
			dataType: "html",
			data: {
				action: params['action'],
				id: jQuery('#hdn-profile-id').val(),
				 t: 'ajax',
									w1:params['thumb_width'],
									x1:params['x_axis'],
									h1:params['thumb_height'],
									y1:params['y_axis'],
									x2:params['x2_axis'],
									y2:params['y2_axis'],
									image_name :jQuery('#image_name').val()
			},
			type: 'Post',
		   	success: function (response) { //alert(response);
					jQuery('#profile_pic_modal').modal('hide');
					jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
					
					jQuery("#profile_picture").attr('src', response);
					jQuery("#preview-profile-pic").html('');
					jQuery("#profile-pic").val();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
			}
		});
    }
});

</script>



</body>
</html>


