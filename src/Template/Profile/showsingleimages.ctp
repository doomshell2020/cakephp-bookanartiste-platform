<style>
	/*.modal-dialog {
			top: 15%;
		}*/

	.modal-backdrop.in {

		opacity: 1.5 !important;
	}

	.likeimage.active {
		color: red;
	}

	.licount.active {
		color: red;
	}

	.social_icon {
		position: relative;
	}

	.item {
		display: none;
	}

	.item.active {
		display: block;
	}

	.share_button {
		position: absolute;
		background: #fff;
		border: 1px solid #ccc;
		padding: 5px;
		right: 0;
		top: 20px;
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

	.share_caption textarea {
		padding: 5px;
		width: 107%;
		border: 5px double gray;
		font-size: 10px;
		height: 100px;
	}

	.share_button ul {
		margin-bottom: 0px;
	}

	.share_button ul li i {
		font-size: 16px;
		margin-right: 0px;
	}

	#myModalsingleimage {
		padding-left: 0px !important;
		z-index: 999999;
		overflow: inherit;
	}

	#myModalsingleimage .modal-dialog {
		margin-top: 0px;
	}
</style>

<button type="button" class="close" data-dismiss="modal" id="close"><i class="fa fa-window-close" aria-hidden="true"></i></button>

<div id="modal-carousel" class="carousel">
	<div class="carousel-inner" id="slides">
		<?php
		$counter = 1;

		// pr($singleimages);
		// die;
		foreach ($singleimages as $images) {
			$imagecountcheck = count($singleimages);
		?>
			<?php $user_id = $this->request->session()->read('Auth.User.id'); ?>
			<?php $country = $this->Comman->findlikedislike($images['id']);
			$totalimagelike = $this->Comman->totalimagelike($images['id']);
			$totaluserimagelike = $this->Comman->totaluserimagelike($images['id']);
			$imageSrc = !empty($images->imagename) ? SITE_URL . "/gallery/" . $images->imagename : SITE_URL . "/no-image-available.png";
			?>

			<div class="item <?= ($images->id == $imageid) ? 'active' : ''; ?>" id="image-<?= $counter; ?>">
				<ul class="gal_contant">
					<li class="gal_img">
						<img class="thumbnail img-responsive" title="Image <?= $counter; ?>" src="<?= $imageSrc; ?>">

						<div class="slide_arrow">
							<a id="prev" class="carousel-control left" href="#modal-carousel" data-slide="prev"><?php if ($imagecountcheck > 1) { ?><i class="glyphicon glyphicon-chevron-left"></i><?php } ?></a>
							<?php if ($imagecountcheck > 1) { ?>
								<a class="carousel-control center rg-image-nav-next" href="#modal-carousel" data-slide="autoplay">
								</a>
							<?php } ?>
							<span class="countpostition"><?php echo $counter; ?>/<?php echo count($singleimages); ?></span>
							<a id="next" class="carousel-control right" href="#modal-carousel" data-slide="next"><?php if ($imagecountcheck > 1) { ?> <i class="glyphicon glyphicon-chevron-right"></i> <?php } ?></a>

						</div>

					</li>
					<li class="gal_text">
						<div class="gallery_img_option">
							<ul class="list-unstyled">
								<li class="ownername" style="margin-top:10px"><i class="fa fa-user" aria-hidden="true"></i><span><b><?php echo ucfirst($images['user']['user_name']); ?></b></span></li>

								<?php if ($country['caption']) { ?>
									<li>
										<div class="imagemycap" id="imagescap<?php echo $images['id']; ?>"><i class="fa fa-commenting-o" aria-hidden="true"></i><strong><?php echo $country['caption']; ?></strong></div>
									</li>
								<?php } ?>

								<li class="created">
									<i class="fa fa-calendar-o" aria-hidden="true"></i>
									<span><?php echo date("M d, Y", strtotime($images['created'])); ?></span>
								</li>

								<?php if ($user_id == $images['user']['id']) { ?>
									<li class="caption">
										<a href="javascript:void(0);" data-toggle="tooltip" title="Caption" onclick="toggleCaption(<?php echo $counter; ?>)">
											<i class="fa fa-commenting-o" aria-hidden="true"></i>
											<span class="caption-edit-text-<?php echo $counter; ?>">
												<?php echo !empty($country['caption']) ? "Edit Caption" : "Write Caption"; ?>
											</span>
										</a>
										<div class="share_caption caption-container" id="caption-box-<?php echo $counter; ?>" style="display: none;">
											<textarea maxlength="75" class="caption-text" id="caption-input-<?php echo $counter; ?>"><?php echo htmlspecialchars($country['caption']); ?></textarea>
											<a href="javascript:void(0);" class="btn btn-success btn-xs pull-right" onclick="saveCaption('<?php echo $images['id']; ?>', '<?php echo $counter; ?>')">Save</a>
										</div>
										<span class="caption-saved" id="caption-saved-<?php echo $counter; ?>" style="display:none; color:red; font-size:12px;">Caption saved.</span>
									</li>
								<?php } ?>

								<script>
									function toggleCaption(counter) {
										$('.caption-container').not('#caption-box-' + counter).slideUp(); // Hide other captions
										$('#caption-box-' + counter).slideToggle(); // Toggle current caption box
									}

									function saveCaption(imageId, counter) {
										var captionValue = $('#caption-input-' + counter).val().trim();

										$.post('<?php echo SITE_URL; ?>/profile/checkcaption', {
											cap: captionValue,
											id: imageId
										}, function(response) {
											if (response.trim() !== "") {
												$('#imagescap' + imageId).html(`<i class="fa fa-commenting-o" aria-hidden="true"></i> <strong>${response}</strong>`);
											} else {
												$('#imagescap' + imageId).html('');
											}

											$('#caption-box-' + counter).slideUp();
											$('#caption-saved-' + counter).fadeIn().delay(2000).fadeOut();
											$(".caption-edit-text-" + counter).text(response ? 'Edit Caption' : 'Write Caption');
										});
									}
								</script>


								<?php /* ?>
						<li style="<?php if($user_id==$images['user']['id']){ ?>margin-top:50px <?php } ?>">							
							<?php if($country['image_like']==0){ ?>
								<a href="javascript:void(0);" data="<?php echo $counter; ?>" id="<?php echo $images['id'].'/'.$counter; ?>" onclick="fgh(this.title,this.id)" class="active like<?php echo $counter; ?>" title="Like"><i class="fa fa-thumbs-up"></i> Like</a>
								
								<a href="javascript:void(0);" style="display:none" data="<?php echo $counter; ?>" id="<?php echo $images['id'].'/'.$counter; ?>" onclick="fgh(this.title,this.id)" class="unlike<?php echo $counter; ?>" title="Unlike"><i style="color:red" class="fa fa-thumbs-up"></i> Like</a>
								
							<?php }else{ ?>
								<a href="javascript:void(0);" style="display:none" data="<?php echo $counter; ?>" id="<?php echo $images['id'].'/'.$counter; ?>" onclick="fgh(this.title,this.id)" class="like<?php echo $counter; ?>" title="Like"><i class="fa fa-thumbs-up"></i> Like</a>
								
								<a href="javascript:void(0);" id="<?php echo $images['id'].'/'.$counter; ?>" data="<?php echo $counter; ?>" onclick="fgh(this.title,this.id)" class="unlike<?php echo $counter; ?>" title="Unlike"><i style="color:red" class="fa fa-thumbs-up"></i> Like</a>
								
							<?php } ?>
							<?php $likecount=$this->Comman->findlikecount($images->id); //pr($country);?>
							<a href="<?php echo SITE_URL?>/profile/likedusers/<?php echo $images->id; ?>" data-toggle="modal" data-value="<?php $likecount; ?>" class='m-top-5 singlevideoimage' > (<span class="likecount<?php echo $counter; ?>"><?php echo $likecount; ?></span>)</a>
						</li>
						<?php */ ?>

								<li style="<?php if ($this->request->session()->read('Auth.User.id') == $videos_data['user_id']) { ?>margin-top:90px <?php } ?>">
									<?php $user_idimages = $this->request->session()->read('Auth.User.id'); ?>
									<a href="javascript:void(0)" class="likeimage <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>" id="likeimage<?php echo $images['id']; ?>" data-toggle="tooltip" data-val="<?php echo ($user_idimages) ? $user_idimages : '0' ?>" data-imageid="<?php echo $images['id']; ?>" data-imagename="<?php echo $images['imagename']; ?>" data-userid="<?php echo $images->user->id; ?>" title="Like"><i class="fa fa-thumbs-up"></i> Like</a>

									(<div class="like totallikes" style="display: inline;"> <a href="<?php echo SITE_URL ?>/profile/likedusers/<?php echo $images['id']; ?>" data-toggle="modal" class='m-top-5 singlevideoimage likeimage' id="">

											<span class="totallikecount<?php echo $images['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>

										</a></div>)
								</li>


								<li class="social_icon">
									<a href="javascript:void(0);" class="share-clk<?php echo $likecount; ?>" data-toggle="tooltip" id="<?php echo $counter; ?>" onclick="share(this.id)" title="Share">
										<i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>

									<div class="share_button share-toggle<?php echo $counter; ?>" style="display: none;">
										<ul class="list-unstyled list-inline text-center">
											<li>
												<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewgalleries/<?php echo $images['user']['id']; ?>" class="fb-share-button"
													data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $images['imagename']; ?>" target="_blank" data-img="<?php echo $images['imagename']; ?>" id="notification<?php echo $counter; ?>"> <i class="fa fa-facebook fa-lg"></i>
												</a>
											</li>
											<li>
												<a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>viewgalleries/<?php echo $images['user']['id']; ?>" target="_blank" data-img="<?php echo $images['imagename']; ?>" id="notification<?php echo $counter; ?>"><i class="fa fa-google-plus fa-lg"></i></a>
											</li>
											<li>
												<a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>viewgalleries/<?php echo $images['user']['id']; ?>" target="_blank" data-img="<?php echo $images['imagename']; ?>" id="notification<?php echo $counter; ?>"><i class="fa fa-twitter fa-lg"></i>
												</a>
											</li>

											<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>viewgalleries/<?php echo $images['user']['id']; ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg" data-img="<?php echo $images['imagename']; ?>" id="notification<?php echo $counter; ?>"></a></li>
											<li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>viewgalleries/<?php echo $images['user']['id']; ?>" data-img="<?php echo $images['imagename']; ?>" id="notification<?php echo $counter; ?>"></a>
											</li>
										</ul>
									</div>
								</li>
								<script>
									function share(e) {
										//alert(e);
										var count = e;
										$('.share-toggle' + count).slideToggle();
									}

									//   $('#notification<?php echo $counter; ?>').click(function () {

									//       var user_id = '<?php echo $images['user']['id']; ?>';
									//       var share="share photo";
									//       var image=$(this).attr('data-img');
									//       //alert($(this).attr('data-img'));
									//       $.ajax({
									//                                 type: "POST",
									//                                 url: '<?php echo SITE_URL; ?>/profile/sharenotification',
									//                                 data: {user_id: user_id,sharetype:share,image:image},
									//                                 success:function(data){ 

									//                                 }
									//                             });
									//   });
								</script>
								<!--<li><a href="#" data-toggle="tooltip" title="Send"><i class="fa fa-share" aria-hidden="true"></i>Send</a></li>-->
								<li><?php if ($this->request->session()->read('Auth.User.id') != $images['user']['id']) {   ?>
										<a data-toggle="modal" class='m-top-5 videoreport' href="<?php echo SITE_URL ?>/profile/reportspammedia/<?php echo $images->id; ?>/image/<?php echo $images['user']['id']; ?>"><i class="fa fa-flag" aria-hidden="true"></i>Report</a>
									<?php } else { ?>
										<!-- <a href="javascript:void(0);" data-toggle="tooltip" class='m-top-5' onclick="showerror('You cannot Report for yourself.')"><i class="fa fa-flag" aria-hidden="true"></i>Report</a> -->
									<?php } ?>
								</li>
								<li class="full_icon"><a href="javascript:void(0);" data-toggle="tooltip" title="Full-Screen" id="btnFullscreen<?php echo $counter; ?>" data-val="test" class="fullscreendesktop"><i class="fa fa-expand" aria-hidden="true"></i> <i class="fa fa-compress" aria-hidden="true" style="display:none;  font-size=18px; "></i> Full-Screen</a>
									<!--<button id="btnFullscreen" type="button"><i class="fa fa-expand" aria-hidden="true"></i> Full-Screen</button>-->
								</li>
							</ul>

							<!--<span class="countpostition" ><?php //echo $counter; 
																?>/<?php //echo count($singleimages); 
																	?></span>-->






						</div>
					</li>
					<div style="clear:both;"></div>
				</ul>

			</div>


		<?php
			$counter++;
		} ?>
	</div>
	<!--<div class="slide_arrow">
	<a class="carousel-control left" href="#modal-carousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
	<a class="carousel-control center rg-image-nav-next" href="#modal-carousel" data-slide="autoplay">
		<i class="fa fa-forward" aria-hidden="true"></i>
		<i class="fa fa-pause" aria-hidden="true"></i>
	</a>
	<a class="carousel-control right" href="#modal-carousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
</div>-->
	<!--<a class="carousel-control top remove_full_screen_img" onclick="closeFullscreen()" href="#"><i class="fa fa-compress" aria-hidden="true"></i></a>-->
</div>

<script>
	$(document).on("keyup", function(e) {
		var $activeslide = $(".item.active"),
			$targetslide = null;

		if (e.keyCode === 39) { // Right arrow key
			$targetslide = $activeslide.next(".item").length ? $activeslide.next(".item") : $(".item:first");
		} else if (e.keyCode === 37) { // Left arrow key
			$targetslide = $activeslide.prev(".item").length ? $activeslide.prev(".item") : $(".item:last");
		}

		if ($targetslide) {
			$activeslide.removeClass("active");
			$targetslide.addClass("active");
		}
	});


	var cnum = '<?php echo count($singleimages); ?>';
	var i;
	for (i = 1; i < cnum; i++) {
		function toggleFullscreen(elem) {
			elem = elem || document.documentElement;
			if (!document.fullscreenElement && !document.mozFullScreenElement &&
				!document.webkitFullscreenElement && !document.msFullscreenElement) {
				if (elem.requestFullscreen) {
					elem.requestFullscreen();
				} else if (elem.msRequestFullscreen) {
					elem.msRequestFullscreen();
				} else if (elem.mozRequestFullScreen) {
					elem.mozRequestFullScreen();
				} else if (elem.webkitRequestFullscreen) {
					elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
				}
			} else {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				}
			}
		}
		document.getElementById('btnFullscreen' + i).addEventListener('click', function() {
			toggleFullscreen();
		});



	}

	document.addEventListener("fullscreenchange", function(event) {
		if (document.fullscreenElement) {
			//alert('fullscreen is activated');
			$('.modal-dialog').addClass('full_box');
			$(".fa-expand").css("display", "none");
			$(".fa-compress").css("display", "inline-block");

		} else {
			//alert('fullscreen is cancelled');
			$('.modal-dialog').removeClass('full_box');

			$(".fa-expand").css("display", "inline-block");
			$(".fa-compress").css("display", "none");
		}
	});

	$('#close').click(function() {
		screenfull.exit();
	});
</script>
<input type="hidden" name="clearInterval" id="checktest" value="0">
<button class="controls" id="pause">
	<i class="fa fa-forward" aria-hidden="true" style="display:none"></i>
	<i class="fa fa-pause" aria-hidden="true"></i></button>
<script>
	var slides = document.querySelectorAll('#slides .item');
	var currentSlide = 0;
	var bla = $('#checktest').val();
	if (bla) {

	} else {
		var slideInterval = setInterval(nextSlide, 5000);
	}

	function nextSlide() {
		slides[currentSlide].className = 'item';
		currentSlide = (currentSlide + 1) % slides.length;
		$(".item").removeClass('active');
		slides[currentSlide].className = 'item active';

	}

	var playing = false;
	var pauseButton = document.getElementById('pause');

	function pauseSlideshow() {
		//pauseButton.innerHTML = 'Play';
		$("#pause .fa-forward").css("display", "none");
		$("#pause .fa-pause").css("display", "block");
		playing = false;
		clearInterval(slideInterval);
	}

	function playSlideshow() {
		$("#pause .fa-forward").css("display", "block");
		$("#pause .fa-pause").css("display", "none");
		//	pauseButton.innerHTML = 'Pause';
		playing = true;
		slideInterval = setInterval(nextSlide, 5000);
	}

	pauseButton.onclick = function() {
		if (playing) {
			$('#checktest').val('0');
			pauseSlideshow();
		} else {
			$('#checktest').val('');
			playSlideshow();
		}
	};

	<?php /* ?>

	$('.carousel-control.center .fa.fa-forward').click(function() {
		$('.carousel-control.center ').addClass('play_pouse_icon');
	});
	$('.carousel-control.center .fa.fa-pause').click(function() {
		$('.carousel-control.center ').removeClass('play_pouse_icon');
		$('.carousel-control.center ').removeClass('rg-image-nav-next');
	});


<?php */ ?>
</script>



<!-- <script>
  $('.singleimage').click(function(e){ //alert();
  	e.preventDefault();
  	$('#myModalsingleimage').modal('show').find('.modal-body').load($(this).attr('href'));
  });
  $('#closemodal').click(function() {
  	$('#myModalsingleimage').modal('hide');
  });
</script> -->

<script>
	$('.singlevideoimage').click(function(e) { //alert();
		e.preventDefault();
		$('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
	});
	$('#closemodal').click(function() {
		$('#myModallikesvideo').modal('hide');
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
<!--Gallery Image Full size-->

<script>
	$('.videoreport').click(function(e) { //alert();
		e.preventDefault();
		$('#myModalreportvideo').modal('show').find('.modal-body').load($(this).attr('href'));
	});
</script>


<script>
	$('.likeimage').click(function() {
		// error_text = "You cannot Like yourself";
		user_id = $(this).data('val');
		imageid = $(this).data('imageid');
		imagename = $(this).data('imagename');
		reciveid = $(this).data('userid');
		if (user_id > 0) {
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL; ?>/profile/checklike',
				data: {
					user_id: user_id,
					content_id: imageid,
					imagename: imagename,
					reciveid: reciveid
				},
				cache: false,
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.error == 1) {
						showerror(error_text);
					} else {
						//  alert(obj.count);
						if (obj.status == 'like') {
							$("#likeimage" + imageid).addClass('active');
							$(".totallikecount" + imageid).addClass('active');

						} else {
							$("#likeimage" + imageid).removeClass('active');
							$(".totallikecount" + imageid).removeClass('active');
						}
						$(".totallikecount" + imageid).html(obj.count);
					}
				}
			});
		} else {
			//  showerror(error_text);
		}
	});
</script>