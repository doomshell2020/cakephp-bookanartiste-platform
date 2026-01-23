<span style="color:red;display:none" id="videonfffotable">Invalid Audio URL Plese see the list of audios supported by clicking audio url list button </span>

<?php
echo $this->Form->create('$audio', array('url' => array('controller' => 'profile', 'action' => 'audio'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

<div class="form-group">
	<label class="control-label col-sm-2">Title :</label>
	<div class="col-sm-10">
		<?php echo $this->Form->input('audio_type', array('class' => 'form-control', 'placeholder' => 'Title', 'id' => 'name', 'required', 'label' => false, 'value' => $audio['audio_type'])); ?>

	</div>
</div>


<input type="hidden" value="<?php echo $audio['id'] ?>" name="id" />
<div class="form-group">
	<label class="control-label col-sm-2">Url :</label>
	<div class="col-sm-10">
		<?php echo $this->Form->input('audio_link', array('class' => 'form-control audiourl', 'placeholder' => 'Url', 'id' => 'audiourl', 'required', 'label' => false, 'value' => $audio['audio_link'])); ?>


	</div>
</div>

<div class="form-group">
	<div class="text-center col-sm-12">
		<button id="btnedit" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

	</div>
</div>


<?php echo $this->Form->end(); ?>


<script type="text/javascript">
	var site_url = '<?php echo SITE_URL; ?>/';
	$(document).ready(function() {
		$(".audiourl").change(function() {

			var value = $(this).val();

			$.ajax({
				type: "post",
				url: site_url + 'profile/getAudio',
				data: {
					url: value
				},

				success: function(data) { //alert(data);

					var obj = JSON.parse(data);

					if (obj.status == 1) {
						$('.imgupdate').css('display', 'block');
						$('.imgupdate').attr('src', obj.image);
						$('.uploadbutton').css('display', 'none');
						$('.imgupdate').css('display', 'block');
						$('.input-file').removeAttr('required');
						$("input[name~='imagesrc']").val(obj.image);
						$('#btnedit').removeAttr('disabled');
						$('#videonfffotable').css('display', 'none');

					} else {
						$('#btnedit').attr('disabled', 'true');
						$('#videonfffotable').css('display', 'block');
						$('.imgupdate').css('display', 'none');
					}
				}

			});
		});
	});
</script>