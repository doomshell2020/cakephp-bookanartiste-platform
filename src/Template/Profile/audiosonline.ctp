<style>
	.modal-backdrop.in {

		opacity: 1.5 !important;
	}

	.likeimage.active {
		color: red;
	}

	.totallikecount.active {
		color: red;
	}

	.social_icon {
		position: relative;
	}

	.share_button {
		position: absolute;
		background: #fff;
		border: 1px solid #ccc;
		padding: 5px;
		right: 2%;
		top: 24px;
		min-width: 100px;
	}

	.caption {
		position: relative;
	}

	li .share_caption {
		position: absolute;
		padding: 5px;
		margin-top: 6px;
		right: 0px;
		top: 100%;
		left: -9px;
		z-index: 999;
	}

	button.videopopclo.close {
		right: 3px !important;
		top: 1px !important;
	}

	.share_caption textarea {
		padding: 5px;
		width: 100%;
		border: 2px solid gray;
		font-size: 10px;
		height: 80px;
		margin-left: 3px;
		margin-bottom: 5px;

	}

	.share_button ul {
		margin-bottom: 0px;
	}

	.share_button ul li i {
		font-size: 16px;
		margin-right: 0px;
	}
</style>

<?php
$counter = 1;
foreach ($audioes as $audioes_data) { //pr($audioes_data);  die;
?>
	<?php $user_id = $this->request->session()->read('Auth.User.id'); ?>
	<div class="clearfix" style="margin:51px 40px; width: 70%;">
		<div class="pull-left">
			<a href="<?php echo $audioes_data['audio_link']; ?>" target="_blank"><img src="<?php echo SITE_URL; ?>/images/Audio-icon.png"></a>
		</div>
		<div class="pull-left">

		</div>
	</div>
	<div class="gallery_img_option">
		<ul class="list-unstyled">
			<li class="ownername" style=""><i class="fa fa-user" aria-hidden="true"></i><span><b><?php echo ucfirst($audioes_data['user']['user_name']); ?></b></span></li>
			<?php if ($audioes_data['caption']) { ?>
				<li>
					<div id="audiocap" style=" display: inline;">
						<i class="fa fa-commenting-o" aria-hidden="true"></i>
						<strong><?php echo $audioes_data['caption']; ?></strong>
					</div>
				</li>
			<?php } ?>
			<li class="created"><i class="fa fa-calendar-o" aria-hidden="true"></i><span><?php echo date("M d,Y", strtotime($audioes_data['created'])); ?></span></li>
			<?php if ($user_id == $audioes_data['user']['id']) { ?>
				<li class="caption">

					<a href="javascript:void(0);"
						data-toggle="tooltip"
						title="Caption"
						onclick="caption('<?php echo $counter; ?>')" id="<?php echo $counter; ?>">
						<i class="fa fa-commenting-o" aria-hidden="true"></i>
						<span class="checkcaptionedit">
							<?php echo ($audioes_data['caption'] != '') ? "Edit Caption" : "Write Caption"; ?>
						</span>
					</a>

					<div class="share_caption caption-share-toggle<?php echo $counter; ?>" style="display: none;">
						<textarea maxlength="75" class="text" id="textarea-<?php echo $audioes_data['id']; ?>"><?php echo $audioes_data['caption']; ?></textarea>
						<a href="javascript:void(0);" type="button" id="<?php echo $audioes_data['id']; ?>" onclick="addcaption(this.id,'')" class="btn btn-success btn-xs pull-right">Save</a>
					</div>
					<span class="caption-saved caption-saved-<?php echo $counter; ?>" style="display:none; color:red; font-size:12px;">Caption saved.</span>
				</li>
			<?php } ?>

			<script>
				function caption(counter) {
					$('.caption-share-toggle' + counter).slideToggle();
				}

				function addcaption(audioId,counter) {
					var textarea = $('#textarea-' + audioId);
					if (textarea.length === 0) {
						console.error("Textarea not found for audio ID:", audioId);
						return;
					}

					var captionValue = textarea.val().trim();

					$.ajax({
						type: "POST",
						url: '<?php echo SITE_URL; ?>/profile/checkaudiocaption',
						data: {
							'cap': captionValue,
							'id': audioId
						},
						success: function(data) {

							// $('.caption-share-toggle' + audioId).slideUp();
							// $('.caption-saved-' + audioId).fadeIn().delay(2000).fadeOut();

							// if (data.trim()) {
							// 	$(".checkcaptionedit").text('Edit Caption');
							// } else {
							// 	$(".checkcaptionedit").text('Write Caption');
							// }


							// $('.caption-share-toggle').slideUp();
							$('.caption-share-toggle' + counter).slideUp();
							$('.caption-saved').css('display', 'block');
							$("#audiocap").html('<strong><i class="fa fa-commenting-o" aria-hidden="true"></i>' +
								data + '</strong>');
							if (data) {
								$(".checkcaptionedit").text('Edit Caption');
							} else {
								$("#audiocap").html('');
								$(".checkcaptionedit").text('Write Caption');
							}

						},
						error: function() {
							alert("Error saving caption. Please try again.");
						}
					});
				}
			</script>


			<li style="<?php if ($user_id == $audioes_data['user']['id']) { ?> <?php } ?>">
				<?php $user_idimages = $this->request->session()->read('Auth.User.id'); ?>
				<a href="javascript:void(0)" class="likeimage <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>" id="likeimage" data-toggle="tooltip" data-val="<?php echo ($user_idimages) ? $user_idimages : '0' ?>" data-videoid="<?php echo $audioes_data['id']; ?>" data-aud="<?php echo $audioes_data['audio_link']; ?>" data-reciveid="<?php echo $audioes_data['user_id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i> Like</a>
				(<div class="like totallikes" style="display: inline;"> <a href="<?php echo SITE_URL ?>/profile/audiolikedusers/<?php echo $audioes_data->id; ?>" data-toggle="modal" class='m-top-5 singleaudioimage likeimage' id=""><span class="totallikecount <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>"><?php echo $totallikes; ?></span> </a></div>)


				<div id="no"></div>
			<li class="social_icon"><a href="javascript:void(0);" class="share-clk<?php echo $counter; ?>" data-toggle="tooltip" id="<?php echo $counter; ?>" onclick="share(this.id)" title="Share"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
				<meta property="og:image" content="<?php echo SITE_URL; ?>/gallery/<?php echo $images['imagename']; ?>" />
				<div class="share_button share-toggle<?php echo $counter; ?>" style="display: none;">
					<ul class="list-unstyled list-inline text-center">
						<li>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewaudios/<?php echo $audioes_data['user']['id']; ?>" class="fb-share-button"
								data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank" data-aud="<?php echo $audioes_data['audio_link']; ?>" id="notification<?php echo $counter; ?>"> <i class="fa fa-facebook fa-lg"></i>
							</a>
						</li>
						<li>
							<a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewaudios/<?php echo $audioes_data['user']['id']; ?>" target="_blank" data-aud="<?php echo $audioes_data['audio_link']; ?>" id="notification<?php echo $counter; ?>"><i class="fa fa-google-plus fa-lg"></i>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewaudios/<?php echo $audioes_data['user']['id']; ?>" target="_blank" data-aud="<?php echo $audioes_data['audio_link']; ?>" id="notification<?php echo $counter; ?>"><i class="fa fa-twitter fa-lg"></i>
							</a>
						</li>

						<li>
							<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewaudios/<?php echo $audioes_data['user']['id']; ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg" data-aud="<?php echo $audioes_data['audio_link']; ?>" id="notification<?php echo $counter; ?>">
							</a>
						</li>


						<li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>" data-aud="<?php echo $audioes_data['audio_link']; ?>" id="notification<?php echo $counter; ?>"></a></li>

					</ul>

			</li>
			<script>
				function share(e) {
					//alert(e);
					var count = e;
					$('.share-toggle' + count).slideToggle();
				}

				$('#notification<?php echo $counter; ?>').click(function() {
					var user_id = '<?php echo $audioes_data['user']['id']; ?>';
					var share = "share audio";
					var audio = $(this).attr('data-aud');
					//alert($(this).attr('data-img'));
					$.ajax({
						type: "POST",
						url: '<?php echo SITE_URL; ?>/profile/sharenotification',
						data: {
							user_id: user_id,
							sharetype: share,
							audio: audio
						},
						success: function(data) {

						}
					});
				});
			</script>
			<li><?php if ($this->request->session()->read('Auth.User.id') != $audioes_data['user_id']) {   ?>
					<a data-toggle="modal" class='m-top-5 singleaudioimage' href="<?php echo SITE_URL ?>/profile/reportspammedia/<?php echo $audioes_data->id; ?>/audio/<?php echo $audioes_data['user_id']; ?>"><i class="fa fa-flag" aria-hidden="true"></i>Report</a>
				<?php } else { ?>
					<!-- <a href="javascript:void(0);" data-toggle="tooltip" class='m-top-5' onclick="showerror('You cannot Report for yourself.')"><i class="fa fa-flag" aria-hidden="true"></i>Report</a> -->
				<?php } ?>
		</ul>



	</div>

<?php $counter++;
} ?>

<!-- Modal -->

<script>
	$('.singleaudioimage').click(function(e) { //alert();
		e.preventDefault();
		$('#myModallikesaudio').modal('show').find('.modal-body').load($(this).attr('href'));
	});
	$('#closemodal').click(function() {
		$('#myModallikesaudio').modal('hide');
	});
</script>
<script>
	$('.likeimage').click(function() {
		//error_text = "You cannot Like yourself";
		user_id = $(this).data('val');
		videoid = $(this).data('videoid');
		audio = $(this).data('aud');
		reciveid = $(this).data('reciveid');

		if (user_id > 0) {
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL; ?>/profile/checkaudiolike',
				data: {
					user_id: user_id,
					content_id: videoid,
					audio: audio,
					reciveid: reciveid
				},
				cache: false,
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.error == 1) {
						showerror(error_text);
					} else {
						if (obj.status == 'like') {
							$("#likeimage").addClass('active');
							$(".totallikecount").addClass('active');
						} else {
							$("#likeimage").removeClass('active');
							$(".totallikecount").removeClass('active');
						}

						$(".totallikecount").html(obj.count);
					}

				}
			});
		} else {
			//	showerror(error_text);
		}
	});
</script>
<script type="text/javascript">
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};
	$(document).on("click", '.whatsapps', function() {

		if (isMobile.any()) {
			var text = $(this).attr("data-wh");
			var whatsapp_url = "whatsapp://send?text=" + text;
			window.location.href = whatsapp_url;

		} else {
			alert("whatsup sharing allow only in mobile device");
		}
	});
</script>