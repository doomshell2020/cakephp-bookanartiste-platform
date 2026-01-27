<style>
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: 0.5s ease;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .my_img .overlay i {
        position: static;
        top: inherit;
        left: inherit;
        color: #fff;
        font-size: 16px;
        z-index: 9;

        transform: none !important;
    }
</style>

<?php //pr($packfeature); 
// if($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID){ // $videolimit = $packfeature['non_talent_video_list_total']; // }else{ // $videolimit = $packfeature['talent_video_list_total']; // } 

$videoLimit = 100;
// pr($total_limit_remaining);exit;
?>
<!----------------------editprofile-strt----------------------->
<section id="edit_profile" class="gallery_tab">
    <div class="container">
        <!-- <h2>Edit <span>Profile</span></h2>
          <p class="m-bott-50">Here You Can Create Your Profile</p> -->
        <h2><span>Videos</span></h2>
        <p class="m-bott-50">Here You Can Manage Your Videos</p>
        <?php echo $this->Flash->render(); ?>
        <div class="row">
            <?php echo  $this->element('editprofile') ?>

            <div class="tab-content">
                <div id="Gallery" class="galleryTabContainer">
                    <div class="container m-top-60">
                        <div class="galleryTopBar pva_tab">
                            <?php echo  $this->element('galleryprofile') ?>

                            <?php $uid = $this->request->session()->read('Auth.User.id'); ?>

                            <?php if ($total_limit_remaining > 0) { ?>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#addvideo">Add Videos</a>
                            <?php } else { ?>
                                <button
                                    class="btn btn-primary"
                                    onclick="showError('You have reached the limit of <?= $total_limit_remaining ?> videos. Please delete an existing video to create a new one');">Add Videos
                                </button>
                            <?php } ?>

                            <!-- <div style="margin-left: 15px;"> -->
                            <a style="margin-left: 15px;" class="btn btn-default pull-right" href="<?php echo SITE_URL; ?>/viewvideos/<?php echo $uid; ?>">
                                Already uploaded videos
                            </a>
                            <!-- </div> -->
                            <a class="btn btn-primary pull-right" style="margin-left: 15px; background: #f4434d !important;" data-toggle="modal" data-target="#videolist"> Videos Sites List</a>
                        </div>

                        <div class="tab-content">
                            <div id="picture" class="tab-pane fade in active">
                                <div>
                                    <div class="row">
                                        <?php if (!empty($videoprofile)) {
                                            foreach ($videoprofile as $index => $gall) {
                                                // pr($gall);exit;
                                                $isInvisible = $index + 1 > $videoLimit;
                                                $thumbnail = !empty($gall['thumbnail'])
                                                    ? SITE_URL . "/videothumb/" . $gall['thumbnail']
                                                    : SITE_URL . "/videothumb/vid-ico.png";
                                        ?>
                                                <div id="div1<?php echo $gall['id']; ?>">
                                                    <li class="col-xs-6 col-sm-4 col-md-2 my-album-images" style="list-style: none;">
                                                        <div class="my_img" style="text-align: center; position: relative;">
                                                            <?php if ($isInvisible) { ?>
                                                                <div class="invisble_audi" style="position: absolute; left: 0; right: 0; bottom: 0; top: 0; z-index: 99; background-color: rgba(0, 0, 0, 0.7);">
                                                                    <img src="<?php echo SITE_URL; ?>/images/invisible.png" />
                                                                </div>
                                                            <?php } ?>

                                                            <img src="<?php echo $thumbnail; ?>" height="125px" width="100%" />

                                                            <div class="overlay">
                                                                <a href="<?php echo SITE_URL; ?>/profile/detail/<?php echo $gall['id']; ?>"
                                                                    class="data editButton"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="<?php echo SITE_URL; ?>/profile/deletevideo/<?php echo $gall['id']; ?>"
                                                                    class="deleteButton"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Delete"
                                                                    onclick="return confirm('Are You Sure You Want To Delete <?php echo $gall['video_name'];  ?> Video');">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <div class="text-center">
                                                                <h4><?php echo $gall['video_name'];  ?></h4>
                                                            </div>
                                                        </div>
                                                        <div class="caption">
                                                            <?php echo htmlspecialchars($gall['caption'], ENT_QUOTES, 'UTF-8'); ?>
                                                        </div>
                                                    </li>
                                                </div>
                                            <?php
                                            }
                                        } else { ?>
                                            <span style="margin-left: 12px;">No Video Found</span>
                                        <?php } ?>
                                    </div>

                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="videolist" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Videos Sites List</h4>
            </div>
            <div class="modal-body">
                <?php $videolist = array('www.youtube.com', 'vimeo.com', 'www.dailymotion.com', 'www.veoh.com', 'myspace.com', 'vine.co', 'www.ustream.tv', 'www.kankan.com', 'www.break.com', 'www.metacafe.com', 'wwitv.com', 'www.tv.com', 'www.vh1.com', 'www.iqiyi.com', 'www.pptv.com', 'tv.sohu.com', 'yandex.com', 'youku.com', 'www.ku6.com', 'www.nicovideo.jp', 'www.pandora.tv', 'www.vbox7.com', 'tu.tv', 'fc2.com', 'www.babble.com');
                $count = 1;
                for ($i = 0; $i < count($videolist); $i++) { ?>
                    <p>
                        (<?php echo $count ?>)
                        <?php echo $videolist[$i]; ?>
                    </p>

                <?php $count++;
                } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="addvideo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Video</h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create($Video, array(
                    'url' => array('controller' => 'profile', 'action' => 'video'),
                    'type' => 'file',
                    'inputDefaults' => array('div' => false, 'label' => false),
                    'class' => 'form-horizontal',
                    'id' => 'user_form',
                    'autocomplete' => 'off'
                )); ?>

                <span id="videonotable" style="color:red; display:none; margin:0px 0px 12px 120px;">
                    Click on Videos Sites List to check acceptable sites list
                </span>

                <div class="form-group">
                    <label class="control-label col-sm-2">Title :</label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->input('video_name', array(
                            'class' => 'form-control',
                            'placeholder' => 'Title',
                            'maxlength' => '25',
                            'id' => 'name',
                            'required' => true,
                            'label' => false
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Url :</label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->input('videourl', array(
                            'class' => 'form-control videourl',
                            'placeholder' => 'Url',
                            // 'id' => 'videourl',
                            'oninput' => 'processVideoUrl()',
                            'required' => true,
                            'label' => false,
                            'type' => 'url'
                        )); ?>
                    </div>
                </div>

                <input type="hidden" value="" name="imagesrc" />
                <div class="form-group">
                    <label class="control-label col-sm-2 imglabel" style="display: none;">Image</label>
                    <div class="col-sm-10">
                        <div class="input-file-container col-sm-9 uploadbutton">
                            <input class="input-file" id="file" type="file" name="imagename" required onchange="return fileValidation()" />
                            <label tabindex="0" for="my-file" class="input-file-trigger" style="display: none;">Upload Image</label>
                            <span id="ncpy" style="display: none; color: red;"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
                        </div>
                        <img src="" class="imgupdate" height="150" width="150" style="display: none;" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="text-center col-sm-12">
                        <button id="submitbtn" type="submit" class="btn btn-default submitbtn" disabled><?php echo __('Submit'); ?></button>
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Daynamic modal -->
<div id="dynamyModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Video</h4>
            </div>
            <div class="modal-body"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
    var site_url = "<?php echo SITE_URL; ?>/";
    var isValid = false; // Flag to track AJAX response status

    // $(document).ready(function() {

    // $(".videourl").change(function() {
    //     var value = $(this).val();
    //     $.ajax({
    //         type: "post",
    //         url: site_url + "profile/getVideo",
    //         data: {
    //             url: value
    //         },
    //         success: function(data) {
    //             var obj = JSON.parse(data);
    //             if (obj.status == 1) {
    //                 $(".imgupdate").attr("src", obj.image).show();
    //                 $(".uploadbutton").hide();
    //                 $(".imglabel").show();
    //                 $(".input-file").removeAttr("required");
    //                 $("input[name='imagesrc']").val(obj.image);

    //                 $("#submitbtn").prop("disabled", false); // Enable the button
    //                 $("#videonotable").hide();
    //                 // $(".submitbtn").show();
    //             } else {
    //                 $("#submitbtn").prop("disabled", true); // Keep the button disabled
    //                 $("#videonotable").show();
    //                 $(".imgupdate, .imglabel").hide();
    //                 // $(".submitbtn").hide();
    //             }
    //         },
    //     });
    // });

    // Ensure form submission only when button is enabled
    // $("#user_form").submit(function(event) {
    //     if ($("#btn").prop("disabled")) {
    //         event.preventDefault(); // Prevent form submission
    //         alert("Invalid video URL. Please enter a valid video link.");
    //     }
    // });
    // });

    $(document).ready(function() {
        var value = $("input[name='videourl']").val();
        // console.log("Value using name attribute:", value);

    });

    function processVideoUrl() {
        let Urlvalue = $(".videourl").val(); // Get Urlvalue from #videourl
        // console.log('call this =>', Urlvalue);
        var value = $("input[name='videourl']").val();
        // console.log("Value using name attribute:", value);

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
    $(document).on("change", "#videourl", function() {
        processVideoUrl();
    });

    // Ensure form submission only when button is enabled
    $("#user_form").submit(function(event) {
        if ($("#btn").prop("disabled")) {
            event.preventDefault(); // Prevent form submission
            alert("Invalid video URL. Please enter a valid video link.");
        }
    });
</script>

<script>
    $(".data").click(function(e) {
        e.preventDefault();

        $("#dynamyModal").modal("show").find(".modal-body").load($(this).attr("href"), function() {
            // setTimeout(() => {
            //     processVideoUrl();
            // }, 1500);
        });
    });
</script>

<script>
    function showError(error) {
        BootstrapDialog.alert({
            size: BootstrapDialog.SIZE_SMALL,
            title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !",
            message: "<h5>" + error + "</h5>"
        });
        return false;
    }
</script>