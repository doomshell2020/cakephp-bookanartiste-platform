<style>
    .gall-det-img {
        position: relative;
    }

    .folder_icon {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>
<?php echo $this->element('viewprofile');  ?>
<div class="col-sm-9 vw-gall">
    <div class="col-sm-12 prsnl-det">
        <?php echo $this->element('viewgalleryprofile') ?>
        <div class="tab-content">

            <div id="picture" class="tab-pane fade in active">
                <div class="oldalbum">
                    <div class="row">
                        <?php if (count($galleryprofile) > 0) { ?>
                            <?php $counter = 0;
                            foreach ($galleryprofile as $albums) { //pr($albums);
                            ?>
                                <div class="col-sm-4 gall-det">
                                    <div class="gall-det-img">
                                        <?php if (count($albums->galleryimage) > 1) { ?>
                                            <img src="<?php echo SITE_URL; ?>/images/folder.png" class="folder_icon" width="40px" height="40px">
                                        <?php } ?>
                                        <?php $lastalbumimage = end($albums['galleryimage']);
                                        //pr($last);
                                        ?>
                                        <?php if ($albums->galleryimage[0]->imagename) { ?>
                                            <a href="<?php echo SITE_URL; ?>/viewimages/<?php echo $profile->user_id; ?>/<?php echo $albums['id']; ?>">
                                                <img class="show_images1" src="<?php echo SITE_URL ?>/gallery/<?php echo $lastalbumimage['imagename']; ?>">
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo SITE_URL; ?>/viewimages/<?php echo $profile->user_id; ?>/<?php echo $albums['id']; ?>">
                                                <img class="show_images1" src="<?php echo SITE_URL ?>/images/my-album-1.jpg">
                                            </a>
                                        <?php } ?>

                                        <div class="photoNo">
                                            <div class="text-center gall-img-top"><?php echo $albums->name; ?></div>

                                            <div class="text-center my-albm-Photos ">

                                                <?php foreach ($albums['galleryimage'] as $data) {
                                                    if ($data['status'] == 1) {
                                                        $total_price += $data;
                                                    }
                                                ?>
                                                <?php } ?>
                                                <?php echo $this->Comman->getGalleryImagesCount($albums['user_id'], $albums['id']); ?>Photos
                                            </div>
                                        </div>

                                    </div></a>
                                </div>

                            <?php $counter++;
                                if ($counter == 3) {
                                    break;
                                }
                            }
                            ?>
                        <?php  } ?>
                        <!-- else{?>
                              <div>No Albums available.</div>
                              <?php //} 
                                ?>
                            -->
                    </div>
                </div>
                <div class="fullalbum" style="display:none;">
                    <div class="row">
                        <?php
                        if (count($galleryprofile) > 0) {
                        ?>
                            <?php
                            foreach ($galleryprofile as $albums) { //pr($albums);
                            ?>
                                <div class="col-sm-4 gall-det">
                                    <div class="gall-det-img">
                                        <?php if (count($albums->galleryimage) > 1) { ?>
                                            <img src="<?php echo SITE_URL; ?>/images/folder.png" class="folder_icon" width="40px" height="40px">
                                        <?php } ?>
                                        <?php $lastalbumimage = end($albums['galleryimage']);
                                        //pr($last);
                                        ?>
                                        <?php if ($albums->galleryimage[0]->imagename) { ?>

                                            <a href="<?php echo SITE_URL; ?>/viewimages/<?php echo $profile->user_id; ?>/<?php echo $albums['id']; ?>">
                                                <img class="show_images1" src="<?php echo SITE_URL ?>/gallery/<?php echo $lastalbumimage['imagename'] ?>">
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo SITE_URL; ?>/viewimages/<?php echo $profile->user_id; ?>/<?php echo $albums['id']; ?>">
                                                <img class="show_images1" src="<?php echo SITE_URL ?>/images/my-album-1.jpg">
                                            </a>
                                        <?php } ?>

                                        <div class="text-center gall-img-top-bar"><?php echo $albums->name; ?></div>
                                        <div class="text-center my-albm-Photos">
                                            <?php foreach ($albums['galleryimage'] as $data) {
                                                if ($data['status'] == 1) {
                                                    $total_price += $data;
                                                }
                                            ?>
                                            <?php } ?>
                                            <?php echo $this->Comman->getGalleryImagesCount($albums['user_id'], $albums['id']); ?>
                                            Photos
                                        </div>
                                    </div>
                                </div>

                            <?php  } ?>
                        <?php  } ?>
                        <!-- else{?> <div>No Albums available.</div> <?php //} 
                                                                        ?> -->
                    </div>
                </div>
            </div>
            <?php if (count($galleryprofile) > 3) { ?>
                <div class="col-sm-12 vw-fldrs">
                    <a href="javascript:void(0);" class="btn btn-default showallalbum">
                        View All Folders
                    </a>
                </div>
        </div>
    <?php } ?>
    <script>
        $('.showallalbum').click(function(e) {
            $('.fullalbum').css('display', 'block');
            $('.oldalbum').css('display', 'none');
            $('.showallalbum').css('display', 'none');
        });
    </script>
    <?php if (count($singleimages) > 0) { ?>
        <div class="row view-photos">
            <div class="col-sm-12 gall-heading">
                <h2>Photos</h2>
            </div>

            <div class="oldshow">
                <?php $count = 0;
                foreach ($singleimages as $images) { //pr($images);
                ?>
                    <div class="col-sm-4">
                        <?php if ($images->imagename) { ?>
                            <img class="single_image" data-userid="<?php echo $profile->user_id; ?>" data-imageid="<?php echo $images->id; ?>" src="<?php echo SITE_URL ?>/gallery/<?php echo $images->imagename; ?>">
                        <?php } else { ?>
                            <img class="single_image" src="<?php echo SITE_URL ?>/images/my-album-1.jpg">
                        <?php } ?>
                        <div class="text-center"><?php echo $images->caption; ?>&nbsp;</div>
                    </div>
                <?php $count++;
                    if ($count == 6) {
                        break;
                    }
                }
                ?>
                <!--else{?><div>No Albums available.</div><?php //} 
                                                            ?>-->
            </div>

            <div class="fullshow" style="display:none;">
                <?php
                foreach ($singleimages as $images) { //pr($images);
                ?>
                    <div class="col-sm-4">
                        <?php if ($images->imagename) { ?>
                            <img class="single_image" data-userid="<?php echo $profile->user_id; ?>" data-imageid="<?php echo $images->id; ?>" src="<?php echo SITE_URL ?>/gallery/<?php echo $images->imagename; ?>">
                        <?php } else { ?>
                            <img class="single_image" src="<?php echo SITE_URL ?>/images/my-album-1.jpg">
                        <?php } ?>
                        <div class="text-center"><?php echo $images->caption; ?>&nbsp;</div>
                    </div>
            <?php }
            } ?>
            <!--else{?><div>No Albums available.</div>
                      <?php //} 
                        ?>
                    -->
            </div>

            <?php if (count($singleimages) > 6) { ?>
                <div class="col-sm-12 vw-fldrs">
                    <a href="javascript:void(0);" class="btn btn-default showallphoto">View All Photos</a>
                </div>
            <?php } ?>
        </div>
        
        <script>
            $('.showallphoto').click(function(e) {
                $('.fullshow').css('display', 'block');
                $('.oldshow').css('display', 'none');
                $('.showallphoto').css('display', 'none');
            });
        </script>
    </div>
</div>



<!-- Modal -->
<div id="images" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $('.show_images').click(function(e) {
        e.preventDefault();
        userid = $(this).data('userid');
        albumid = $(this).data('albumid');
        imageurl = '<?php echo SITE_URL; ?>/profile/showalbumimages/' + userid + '/' + albumid;
        $('#images').modal('show').find('.modal-body').load(imageurl);
    });

    $('.single_image').click(function(e) {
        e.preventDefault();
        userid = $(this).data('userid');
        //alert(userid);
        imageid = $(this).data('imageid');
        //alert(imageid);
        imageurl = '<?php echo SITE_URL; ?>/profile/showsingleimages/' + userid + '/' + imageid;
        $('#images').modal('show').find('.modal-body').load(imageurl);
    });
</script>
<style type="text/css">
    button.close {

        z-index: 99999 !important;
        right: 0px !important;
        top: 0px !important;
        position: absolute !important;
        background: #fff;
    }


    .full_box button.close {

        z-index: 99999 !important;
        right: 10px !important;
        top: 15px !important;
        position: absolute !important;
        background: transparent;
        color: #fff;
        text-shadow: none;
    }

    #images .modal-dialog.full_box .carousel-control.top {
        left: inherit;
        right: 40px;
        top: 7px;
    }

    .close {
        opacity: 1;
    }

    #images .modal-dialog {
        overflow: initial !important;
    }

    img.single_image:hover {
        cursor: pointer;
    }


    .modal-dialog {
        width: 70%;
    }
</style>


<!-- Modal -->

<div id="myModallikesvideo" class="modal fade">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body" id="skillsetsearch"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.modal -->






<div id="myModalreportvideo" class="modal fade">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body" id="videosreportuser"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>

</section>