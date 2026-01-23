<?php echo $this->element('viewprofile');  ?>
<div class="col-sm-9">
    <div class="col-sm-12 prsnl-det">
        <?php echo $this->element('viewgalleryprofile') ?>
        <h4><span> <?php echo $galleryalbumname['name']; ?> </span></h4>
        <div class="tab-content">
            <div id="picture" class="tab-pane fade in active">
                <div class="">
                    <?php
                    if (count($galleryimages) > 0) { ?>
                        <div class="clearfix demo-gallery">
                            <!-- <ul id="imagegallery" class="list-unstyled row"> -->
                            <ul id="" class="list-unstyled row">
                                <?php foreach ($galleryimages as $images) { //pr($images);die;
                                ?>
                                    <div class="col-sm-4">
                                        <!--<a class="col-sm-4" href="<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>" title="<?php echo $value['name'];  ?>">-->
                                        <img class="show_images" data-userid="<?php echo $profile->user_id; ?>"
                                            data-albumid="<?php echo $images->gallery_id; ?>"
                                            data-imageid="<?php echo $images->id; ?>"
                                            src="<?php echo SITE_URL ?>/gallery/<?php echo $images->imagename; ?>">
                                        <div class="text-center"><?php echo $images->caption; ?>&nbsp;</div>
                                        <!--</a>-->
                                    </div>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php  } else { ?>
                        <div>No Images available.</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
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
</section>
<script>
    $('.show_images').click(function(e) {
        e.preventDefault();
        userid = $(this).data('userid');
        //alert(userid);
        albumid = $(this).data('albumid');
        //alert(albumid);
        imageid = $(this).data('imageid');
        imageurl = '<?php echo SITE_URL; ?>/profile/showalbumimages/' + userid + '/' + albumid + '/' + imageid;
        $('#images').modal('show').find('.modal-body').load(imageurl);
    });
</script>
<style type="text/css">
    button.close {
        z-index: 99999 !important;
        right: 0px !important;
        top: -1px !important;
        position: absolute !important;
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

    img.show_images:hover {
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