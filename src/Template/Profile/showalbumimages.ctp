<style>
    /* 
    .modal-backdrop.in {
    
        opacity: 1.5 !important;
    } */
    .social_icon {
        position: relative;
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

    .item {
        display: none;
    }

    .item.active {
        display: block;
    }
    .likeimage.active {
        color: red;
    }

    .licount.active {
        color: red;
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

    /* .share_caption textarea {
    padding: 5px;
    width: 107%;
    border: 5px double gray;
    font-size: 10px;
    height: 100px;
    } */

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

    .captionContainer {
        position: static !important;
        background: #ccc4;
        margin-right: 15px;
    }

    .captionContainer a {
        color: #fff !important;
        background: #f84941 !important;
    }

    .captionContainer textarea {
        padding: 5px;
        width: 100%;
        border: none;
        background: none;
        height: 100px;
    }

    #images .modal-dialog img {
        margin-bottom: 0px;
        text-align: right;
        width: 100%;
        height: 80vh;
    }
</style>
<button type="button" class="close" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i></button>
<div id="modal-carousel" class="carousel">
    <div class="carousel-inner" id="slides">
        <?php
        $albumid = $galleryalbumname['id'];
        $counter = 1;
        foreach ($galleryimages as $images) {
            $imagecountcheck = count($galleryimages); ?>
            <?php $user_id = $this->request->session()->read('Auth.User.id'); ?>
            <?php $country = $this->Comman->findlikedislike($images['id'], $user_id); 
            $totalimagelike = $this->Comman->totalimagelike($images['id']);
            $totaluserimagelike = $this->Comman->totaluserimagelike($images['id']);

            ?>
            <div class="item <?php if ($images->id == $imageid) {
                                    echo 'active';
                                } ?>" id="image-<?php echo $counter; ?>">
                <ul class="gal_contant">
                    <li class="gal_img"><img class="thumbnail img-responsive" title="Image 11"
                            src="<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>">

                        <div class="slide_arrow">
                            <a class="carousel-control left" href="#modal-carousel" data-slide="prev"><?php if ($imagecountcheck > 1) { ?><i class="glyphicon glyphicon-chevron-left"></i><?php } ?></a>

                            <a class="carousel-control center rg-image-nav-next" href="#modal-carousel"
                                data-slide="autoplay">
                            </a>
                            <span class="countpostition"><?php echo $counter; ?>/<?php echo count($galleryimages); ?></span>

                            <a class="carousel-control right" href="#modal-carousel" data-slide="next"><?php if ($imagecountcheck > 1) { ?><i class="glyphicon glyphicon-chevron-right"></i><?php } ?></a>
                        </div>

                    </li>
                    <li class="gal_text">
                        <div class="gallery_img_option">
                            <ul class="list-unstyled">
                                <li class="ownername" style="margin-top:10px">
                                    <span><b><?php echo ucfirst($images['user']['user_name']); ?></b></span>
                                </li>
                                <li>
                                    <div id="imagescap<?php echo $images['id']; ?>">
                                        <b><?php echo $country['caption']; ?></b>
                                    </div>
                                </li>
                                <li class="created"><span><?php echo date("M d,Y", strtotime($images['created'])); ?></span>
                                </li>

                                <?php if ($user_id == $images['user']['id']) { ?>
                                    <li class="caption">
                                        <a href="javascript:void(0);" data-toggle="tooltip" title="Caption"
                                            onclick="toggleCaption(<?php echo $counter; ?>)">
                                            <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                            <?php echo ($country['caption']) ? "Edit Caption" : "Write Caption"; ?>
                                        </a>
                                        <div class="captionContainer share_caption caption-share-toggle" id="caption-<?php echo $counter; ?>" style="display: none;">
                                            <textarea placeholder="Write Caption" maxlength="75" class="caption-text" id="caption-text-<?php echo $counter; ?>"><?php echo htmlspecialchars($country['caption']); ?></textarea>
                                            <a href="javascript:void(0);" type="button" onclick="saveCaption(<?php echo $images['id']; ?>, <?php echo $counter; ?>)" class="btn btn-xs">Save</a>
                                        </div>
                                        <span class="caption-saved" id="caption-saved-<?php echo $counter; ?>" style="display:none; color:red; font-size:12px;">Caption saved.</span>
                                    </li>
                                <?php } ?>

                                <script>
                                    function toggleCaption(counter) {
                                        $('.caption-share-toggle').not('#caption-' + counter).slideUp(); // Hide other captions
                                        $('#caption-' + counter).slideToggle(); // Toggle the clicked caption box
                                    }

                                    function saveCaption(imageId, counter) {
                                        var captionValue = $('#caption-text-' + counter).val().trim();
                                        $.post('<?php echo SITE_URL; ?>/profile/checkcaption', {
                                            cap: captionValue,
                                            id: imageId
                                        }, function(data) {
                                            $('#caption-' + counter).slideUp(); // Hide the caption box after saving
                                            $('#caption-saved-' + counter).fadeIn().delay(2000).fadeOut();
                                            $("#imagescap" + imageId).html(data); // Update caption text dynamically
                                        });
                                    }
                                </script>


                                <li
                                    style="<?php if ($this->request->session()->read('Auth.User.id') == $images['user']['id']) { ?>margin-top:0px <?php } ?>">
                                    <?php $user_idimages = $this->request->session()->read('Auth.User.id'); ?>
                                    <a href="javascript:void(0)"
                                        class="likeimage <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"
                                        id="likeimage<?php echo $images['id']; ?>" data-toggle="tooltip"
                                        data-val="<?php echo ($user_idimages) ? $user_idimages : '0' ?>"
                                        data-imageid="<?php echo $images['id']; ?>"
                                        data-imagename="<?php echo $images['imagename']; ?>"
                                        data-userid="<?php echo $images->user->id; ?>" title="Like"><i
                                            class="fa fa-thumbs-up"></i> Like</a>

                                    (<div class="like totallikes" style="display: inline;"> <a
                                            href="<?php echo SITE_URL ?>/profile/likedusers/<?php echo $images['id']; ?>"
                                            data-toggle="modal" class='m-top-5 singlevideoimage likeimage' id="">

                                            <span
                                                class="totallikecount<?php echo $images['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>

                                        </a></div>)
                                </li>
                                <li class="social_icon">
                                    <a href="javascript:void(0);" class="share-clk<?php echo $likecount; ?>"
                                        data-toggle="tooltip" id="<?php echo $counter; ?>" onclick="share(this.id)"
                                        title="Share">
                                        <i class="fa fa-share-alt" aria-hidden="true"></i> Shares</a>

                                    <div class="share_button share-toggle<?php echo $counter; ?>" style="display: none;">
                                        <ul class="list-unstyled list-inline text-center">

                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>"
                                                    onclick="notification('facebook')" class="fb-share-button"
                                                    data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $images['imagename']; ?>"
                                                    target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>"
                                                    target="_blank"><i class="fa fa-google-plus fa-lg"></i></a>
                                            </li>
                                            <li>
                                                <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>"
                                                    target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                            </li>
                                            <li>
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>"
                                                    target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">
                                                </a>
                                            </li>

                                            <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps"
                                                    data-wh="<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <script>
                                    function share(e) {
                                        var count = e;
                                        $('.share-toggle' + count).slideToggle();
                                    }

                                    function notification(e) {
                                        alert(e);
                                    }
                                </script>
                                <!--<li><a href="#" data-toggle="tooltip" title="Send"><i class="fa fa-share" aria-hidden="true"></i>Send</a></li>-->
                                <li><?php if ($this->request->session()->read('Auth.User.id') != $images['user']['id']) {   ?>
                                        <a data-toggle="modal" class='m-top-5 videoreport'
                                            href="<?php echo SITE_URL ?>/profile/reportspammedia/<?php echo $images->id; ?>/image"><i
                                                class="fa fa-flag" aria-hidden="true"></i>Report</a>
                                    <?php } else { ?>
                                        <!-- <a href="javascript:void(0);" data-toggle="tooltip" class='m-top-5' onclick="showerror('You cannot Report for yourself.')"><i class="fa fa-flag" aria-hidden="true"></i>Report</a> -->
                                    <?php } ?>
                                </li>
                                <li class="full_icon"><a href="javascript:void(0);" data-toggle="tooltip"
                                        onclick="openFullscreen()" title="Full-Screen"
                                        id="btnFullscreen<?php echo $counter; ?>" data-val="test"
                                        class="fullscreendesktop"><i class="fa fa-expand" aria-hidden="true"></i> <i
                                            class="fa fa-compress" aria-hidden="true"
                                            style="display:none;  font-size=18px; "></i> Full-Screen</a>
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
    var cnum = '<?php echo count($galleryimages); ?>';
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
</script>




<script>
    /*
	var cnum='<?php //echo count($galleryimages); 
                ?>';
	var i;
for(i = 1; i < cnum; i++ ){
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
	document.getElementById('btnFullscreen'+i).addEventListener('click', function() {
		toggleFullscreen();
	});
}
*/
</script>

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
</script>


<script>
    /*
	$('.carousel-control.center .fa.fa-forward').click(function() {
		$('.carousel-control.center ').addClass('play_pouse_icon');
	});
	$('.carousel-control.center .fa.fa-pause').click(function() {
		$('.carousel-control.center ').removeClass('play_pouse_icon');
		$('.carousel-control.center ').removeClass('rg-image-nav-next');
	});
*/
</script>

<input type="hidden" name="clearInterval" id="checktest" value="0">
<button class="controls" id="pause">
    <i class="fa fa-forward" aria-hidden="true" style="display:none"></i>
    <i class="fa fa-pause" aria-hidden="true"></i>
</button>
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
        slideInterval = setInterval(nextSlide, 4000);
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
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile
                .Windows());
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