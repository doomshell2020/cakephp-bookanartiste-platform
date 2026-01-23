<style>
    /* .modal-backdrop.in {

        opacity: 1.5 !important;
        } */
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

    button.videopopclo.close {
        right: 3px !important;
        top: 1px !important;
    }

    .share_button ul li i {
        font-size: 16px;
        margin-right: 0px;
    }
</style>

<?php
$counter = 1;

foreach ($videos as $videos_data) { ?>

<?php if (preg_match('/vimeo/', $videos_data['video_type'])) {
        $url = '//player.vimeo.com/video/' . end(explode('/', $videos_data['video_type']));
        echo "<iframe src='$url' width='80%' height='100%' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
    } elseif (preg_match('/youtube/', $videos_data['video_type'])) {
        $url = '//www.youtube.com/embed/' . explode('=', $videos_data['video_type'])[1];
        echo "<iframe width='80%' height='100%' src='$url' frameborder='0' allowfullscreen></iframe>";
    } elseif (preg_match('/dailymotion/', $videos_data['video_type'])) {
        $url = 'http://www.dailymotion.com/embed/video/' . explode("_", end(explode('/', $videos_data['video_type'])))[0];
        echo "<iframe frameborder='0' width='80%' height='100%' src='$url' allowfullscreen></iframe>";
    }
} ?>

<div class="gallery_img_option">
    <ul class="list-unstyled">
        <li class="ownername" style="margin-top:22px"><i class="fa fa-user"
                aria-hidden="true"></i><span><b><?php echo ucfirst($videos_data['user']['user_name']); ?></b></span>
        </li>
        <li>
            <div id="videocap<?php echo $videos_data['id']; ?>" style=" display: inline;"><i class="fa fa-commenting-o"
                    aria-hidden="true"></i><strong><?php echo $videos_data['caption']; ?></strong>
            </div>
        </li>
        <li class="created"><i class="fa fa-calendar-o"
                aria-hidden="true"></i><span><?php echo date("M d,Y", strtotime($videos_data['created'])); ?></span>

        </li>

        <?php if ($this->request->session()->read('Auth.User.id') == $videos_data['user_id']) { ?>
            <li class="caption">
                <a href="javascript:void(0);" data-toggle="tooltip" title="Caption"
                    onclick="caption(this.id)" id="<?php echo $counter; ?>">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    <span class="checkcaptionedit">
                        <?php echo !empty($videos_data['caption']) ? "Edit Caption" : "Write Caption"; ?>
                    </span>
                </a>

                <div class="share_caption caption-share-toggle<?php echo $counter; ?>" style="display: none;">
                    <textarea maxlength="75" class="text" id="<?php echo $videos_data['id']; ?>"
                        <?php echo ($this->request->session()->read('Auth.User.id') != $videos_data['user_id']) ? 'readonly' : ''; ?>><?php echo htmlspecialchars($videos_data['caption']); ?></textarea>
                    <button type="button" id="<?php echo $videos_data['id']; ?>"
                        onclick="addcaption(this.id)" class="btn btn-success btn-xs pull-right">Save</button>
                </div>
                <span class="caption-saved" style="display:none; color:red; font-size:12px;">Caption Saved.</span>
            </li>
        <?php } ?>


        <script>
            function caption(e) {
                var count = e;
                $('.caption-share-toggle' + count).slideToggle();
            }

            function addcaption(videoid) {
                var value = $('textarea.text').val().trim();
                $.ajax({
                    type: "POST",
                    url: '<?php echo SITE_URL; ?>/profile/checkvideocaption',
                    data: {
                        'cap': value,
                        'id': videoid
                    },
                    success: function(data) {
                        //alert(data);
                        $('.caption-share-toggle').slideToggle();
                        $('.caption-saved').css('display', 'block');
                        $(".videomycap" + videoid).html(data);
                        $("#videocap" + videoid).html('<strong><i class="fa fa-commenting-o" aria-hidden="true"></i>' +
                            data + '</strong>');
                        //alert(data);
                        if (data) {
                            $(".checkcaptionedit").text('Edit Caption');
                        } else {
                            $("#videocap"+videoid).html('');
                            $(".checkcaptionedit").text('Write Caption');

                        }
                    }
                });
            }
        </script>

        <li
            style="<?php if ($this->request->session()->read('Auth.User.id') == $videos_data['user_id']) { ?><?php } ?>">
            <?php $user_idimages = $this->request->session()->read('Auth.User.id'); ?>
            <a href="javascript:void(0)"
                class="likeimage <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>"
                id="likeimage" data-toggle="tooltip" data-val="<?php echo ($user_idimages) ? $user_idimages : '0' ?>"
                data-videoid="<?php echo $videos_data['id']; ?>" data-vid="<?php echo $videos_data['video_type']; ?>"
                data-reciveid="<?php echo $videos_data['user_id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i>
                Like</a>

            (<div class="like totallikes" style="display: inline;"> <a
                    href="<?php echo SITE_URL ?>/profile/videolikedusers/<?php echo $videos_data->id; ?>"
                    data-toggle="modal" class="m-top-5 singlevideoimage likeimage" id=""> <span
                        class="totallikecount <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>"><?php echo $totallikes; ?></span></a>
            </div>)



        </li>
        <li class="social_icon"><a href="javascript:void(0);" class="share-clk<?php echo $counter; ?>"
                data-toggle="tooltip" id="<?php echo $counter; ?>" onclick="share(this.id)" title="Share"><i
                    class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
            <meta property="og:image"
                content="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" />
            <div class="share_button share-toggle<?php echo $counter; ?>" style="display: none;">
                <ul class="list-unstyled list-inline text-center">
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewvideos/<?php echo $videos_data['user_id']; ?>"
                            class="fb-share-button"
                            data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>"
                            target="_blank"
                            data-vid="<?php echo SITE_URL . "/profile/videosonline/" . $videos_data['id']; ?>"
                            id="notification<?php echo $counter; ?>"> <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li>


                        <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewvideos/<?php echo $videos_data['user_id']; ?>"
                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"
                            data-vid="<?php echo SITE_URL . "/profile/videosonline/" . $videos_data['id']; ?>"
                            id="notification<?php echo $counter; ?>"><i class="fa fa-google-plus fa-lg"></i></a>
                    </li>
                    <li>
                        <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewvideos/<?php echo $videos_data['user_id']; ?>"
                            target="_blank"
                            data-vid="<?php echo SITE_URL . "/profile/videosonline/" . $videos_data['id']; ?>"
                            id="notification<?php echo $counter; ?>"><i class="fa fa-twitter fa-lg"></i></a>
                    </li>

                    <li>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewvideos/<?php echo $videos_data['user_id']; ?>"
                            target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg"
                            data-vid="<?php echo SITE_URL . "/profile/videosonline/" . $videos_data['id']; ?>"
                            id="notification<?php echo $counter; ?>">

                        </a>
                    </li>


                    <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps"
                            data-wh="<?php echo SITE_URL; ?>viewimages/<?php echo $images['user']['id']; ?>/<?php echo $albumid; ?>"
                            data-vid="<?php echo SITE_URL . "/profile/videosonline/" . $videos_data['id']; ?>"
                            id="notification<?php echo $counter; ?>"></a></li>
                </ul>
            </div>
        </li>
        <script>
            function share(e) {
                //alert(e);
                var count = e;
                $('.share-toggle' + count).slideToggle();
            }

            $('#notification<?php echo $counter; ?>').click(function() {
                var user_id = '<?php echo $videos_data['user_id']; ?>';
                var share = "share video";
                var video = $(this).attr('data-vid');
                $.ajax({
                    type: "POST",
                    url: '<?php echo SITE_URL; ?>/profile/sharenotification',
                    data: {
                        user_id: user_id,
                        sharetype: share,
                        video: video
                    },
                    success: function(data) {

                    }
                });
            });
        </script>
        <li> <?php if ($this->request->session()->read('Auth.User.id') != $videos_data['user_id']) { ?>
                <a href="<?php echo SITE_URL ?>/profile/reportspammedia/<?php echo $videos_data->id; ?>/video/<?php echo $videos_data['user_id']; ?>"
                    data-toggle="modal" class="m-top-5 videoreport"><i class="fa fa-flag" aria-hidden="true"></i>Report</a>



            <?php } else { ?>
                <!-- <a href="javascript:void(0);" data-toggle="tooltip" class='m-top-5' onclick="showerror('You cannot Report for yourself.')"><i class="fa fa-flag" aria-hidden="true"></i>Report</a> -->
            <?php } ?>
        </li>
    </ul>

</div>

<script>
    $('.videoreport').click(function(e) { //alert();
        e.preventDefault();
        $('#myModalreportvideo').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>



<script>
    $('.singlevideoimage').click(function(e) { //alert();
        e.preventDefault();
        $('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
    });
    $('#closemodal').click(function() {
        $('#myModallikesvideo').modal('hide');
    });
</script>
<script>
    $('.likeimage').click(function() {
        // error_text = "You cannot Like yourself";
        user_id = $(this).data('val');
        videoid = $(this).data('videoid');
        video = $(this).data('vid');
        reciveid = $(this).data('reciveid');
        if (user_id > 0) {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>/profile/checkvideolike',
                data: {
                    user_id: user_id,
                    content_id: videoid,
                    video: video,
                    reciveid: reciveid
                },
                cache: false,
                success: function(data) {
                    obj = JSON.parse(data);
                    if (obj.error == 1) {
                        // showerror(error_text);
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
            //showerror(error_text);
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