<?php



echo $this->Form->create($Video, array('url' => array('controller' => 'profile', 'action' => 'video'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>


<div class="form-group">
	<label class="control-label col-sm-2">Title :</label>
	<div class="col-sm-10">
		<?php echo $this->Form->input('video_name', array('class' => 'form-control', 'placeholder' => 'Title', 'maxlength' => '25', 'id' => 'name', 'required', 'label' => false, 'value' => $video['video_name'])); ?>

	</div>
</div>


<input type="hidden" value="<?php echo $video['id'] ?>" name="id" />
<div class="form-group">
	<label class="control-label col-sm-2">Url :</label>
	<div class="col-sm-10">
		<?php echo $this->Form->input('videourl', array('class' => 'form-control videourlajax', 'placeholder' => 'Url', 'id' => 'videourlajax', 'required', 'label' => false, 'value' => $video['video_type'])); ?>


	</div>
</div>

<input type="hidden" value="" name="imagesrc" />
<div class="form-group">
	<label class="control-label col-sm-2">Image</label>
	<div class="col-sm-10">
		<div class="input-file-container col-sm-9 uploadbutton">

			<input class="input-file" id="file" type="file" name="imagename" onchange="return fileValidation()">
			<label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
			<span id="ncpy" style="display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
		</div>
		<img src="" class="imgupdate" height="150" width="150" style="display:none; " />
	</div>
</div>
<div class="form-group">
	<div class="text-center col-sm-12">
		<button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

	</div>
</div>


<?php echo $this->Form->end(); ?>

<script type="text/javascript">
	var site_url = '<?php echo SITE_URL; ?>/';
	// $(document).ready(function() {
	// 	$(".videourl").change(function() {

	// 		var value = $(this).val();

	// 		$.ajax({
	// 			type: "post",
	// 			url: site_url + 'profile/getVideo',
	// 			data: {
	// 				url: value
	// 			},

	// 			success: function(data) {

	// 				var obj = JSON.parse(data);

	// 				if (obj.status == 1) {

	// 					$('.imgupdate').attr('src', obj.image);
	// 					$('.uploadbutton').css('display', 'none');
	// 					$('.imgupdate').css('display', 'block');
	// 					$('.input-file').removeAttr('required');
	// 					$("input[name~='imagesrc']").val(obj.image);




	// 				}
	// 			}

	// 		});
	// 	});
	// });

	function processVideoUrl() {
		let Urlvalue = $(".videourlajax").val(); // Get Urlvalue from #videourl

		$.ajax({
			type: "post",
			url: site_url + "profile/getVideo",
			data: {
				url: Urlvalue
			},
			success: function(data) {
				var obj = JSON.parse(data);
				if (obj.status == 1) {
					$(".imgupdate").attr("src", obj.image).show();
					$(".uploadbutton").hide();
					$(".imglabel").show();
					$(".input-file").removeAttr("required");
					$("input[name='imagesrc']").val(obj.image);

					$("#submitbtn").prop("disabled", false); // Enable the button
					$("#videonotable").hide();
					// $(".submitbtn").show();
				} else {
					$("#submitbtn").prop("disabled", true); // Keep the button disabled
					$("#videonotable").show();
					$(".imgupdate, .imglabel").hide();
					// $(".submitbtn").hide();
				}
			},
		});
	}

	// Call the function on change event
	$(document).ready(function() {
		processVideoUrl();
	});

	// Call the function on change event
	$(document).on("change", "#videourlajax", function() {
		processVideoUrl();
	});
</script>