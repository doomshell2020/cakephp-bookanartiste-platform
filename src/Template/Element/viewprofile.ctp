<style>
    #view_profile .nav-tabs>li>a img {
        display: block;
        text-align: center;
        margin: auto;
        width: 24px !important;
        margin-top: 20px;
        height: auto !important;
    }
</style>

<section id="view_profile" class="view_info">
    <div class="container">
        <?php
        $userprof = $this->Comman->proff();
        // pr($userprof);exit;
        $userskill = $this->Comman->userprofileskills($userid);
        ?>


        <?php if (count($userskill) > 0) { ?>
            <h2>
                <?php //echo ($userprof['professinal_info']['profile_title']) ? $userprof['professinal_info']['profile_title'] . "'s" : " "; 
                ?>
                <span> <?php echo $profile->profiletitle; ?></span>
            </h2>

        <?php } else { ?>

            <?php if ($userprof['role_id'] == NONTALANT_ROLEID) { ?>
                <h2>Non Talent <span>Profile</span></h2>
            <?php  } else { ?>
                <h2>Talent <span>Profile</span></h2>
        <?php }
        } ?>

        <?php
        $vitalcount = count($uservitals['0']['id']);
        //pr($user_check);
        ?>
        <div class="row">
            <?php

            $video = $this->Comman->video($userid);
            $audio = $this->Comman->audio($userid);
            $gallery = $this->Comman->gallery($userid);
            $gallerysingimg = $this->Comman->gallerysingimg($userid);

            ?>
            <ul class="view_tab nav nav-tabs nav-justified" role="tablist" style="margin-bottom:20px;">
                <li <?php if ($this->request->params['action'] == 'viewprofile') { ?> class="active" <?php } ?>>
                    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '' ?>" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic1_personal_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic1_personal_blue.png">
                        Personal
                    </a>
                </li>

                <?php //if($video  || $audio || $gallery || $gallerysingimg  ) { 
                // pr('fff');exit;
                ?>
                <li <?php if ($this->request->params['action'] == 'viewgalleries' || $this->request->params['action'] == 'viewimages' || $this->request->params['action'] == 'viewvideos' || $this->request->params['action'] == 'viewaudios') { ?> class="active" <?php } ?>>
                    <a href="<?php echo SITE_URL; ?>/viewgalleries/<?php echo ($userid) ? $userid : '' ?>" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_gallery_black.jpg">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_gallery_blue.png">
                        Gallery
                    </a>
                </li>
                <?php //} 
                ?>

                <?php //if($user_check['role_id']==TALANT_ROLEID){ 
                ?>

                <?php //if($vitalcount > 0){ 
                ?>

                <?php if (count($userskill) > 0) { ?>

                    <?php if (count($profile_title) > 0) { ?>

                        <li <?php if ($this->request->params['action'] == 'viewprofessionalsummary') { ?> class="active" <?php } ?>>
                            <a href="<?php echo SITE_URL; ?>/viewprofessionalsummary/<?php echo ($userid) ? $userid : '' ?>" class=""><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_2.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_2.png">Professional
                                Summary<?php if ($this->request->params['action'] == 'viewschedule') { ?><?php } ?></a>
                        </li>

                    <?php } ?>

                <?php } else { ?>

                    <?php if (count($profile_title) > 0) { ?>

                        <li <?php if ($this->request->params['action'] == 'viewprofessionalsummary') { ?> class="active" <?php } ?>>
                            <a href="<?php echo SITE_URL; ?>/viewprofessionalsummary/<?php echo ($userid) ? $userid : '' ?>" class=""><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_2.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_2.png">Professional
                                Summary</a>
                        </li>

                    <?php } ?>
                <?php } ?>


                <?php if (count($userskill) > 0) { ?>
                    <?php if (count($perdes) > 0) { ?>
                        <li <?php if ($this->request->params['action'] == 'viewperformance') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/viewperformance/<?php echo ($userid) ? $userid : '' ?>" class=""><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_3.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_3.png">Work,Charges Description</a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <?php if (count($perdes) > 0) { ?>
                        <li <?php if ($this->request->params['action'] == 'viewperformance') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/viewperformance/<?php echo ($userid) ? $userid : '' ?>" class=""><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_3.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_3.png">Work,Charges Description</a>
                        </li>
                    <?php } ?>

                <?php } ?>



                <?php if (count($userskill) > 0) {
                    // pr($userskill);
                ?>
                    <?php if ($vitalcount > 0) { ?>
                        <li <?php if ($this->request->params['action'] == 'viewvitalstatistics') { ?> class="active" <?php } ?>>
                            <a href="<?php echo SITE_URL; ?>/viewvitalstatistics/<?php echo ($userid) ? $userid : '' ?>" class="">
                                <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_staristics_black.png">
                                <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_staristics_blue.png">
                                Vital Statistics Parameter
                            </a>
                        </li>

                    <?php } ?>

                <?php } else { ?>
                    <?php if ($vitalcount > 0) { ?>
                        <li <?php if ($this->request->params['action'] == 'viewvitalstatistics') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/viewvitalstatistics/<?php echo ($userid) ? $userid : '' ?>" class="">
                                <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_staristics_black.png">
                                <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_staristics_blue.png" height="44px">
                                Vital Statistics Parameter
                            </a>
                        </li>

                    <?php } ?>
                <?php } ?>

                <li <?php if ($this->request->params['action'] == 'viewschedule') { ?> class="active" <?php } ?>>
                    <a href="<?php echo SITE_URL; ?>/viewschedule/<?php echo ($userid) ? $userid : '' ?>" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_schedule_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_schedule_blue.png">
                        Schedule
                    </a>
                </li>

                <li <?php if ($this->request->params['action'] == 'viewreviews') { ?> class="active" <?php } ?>>
                    <a href="<?php echo SITE_URL; ?>/viewreviews/<?php echo ($userid) ? $userid : '' ?>" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_review_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_review_blue.png">
                        Reviews
                    </a>
                </li>
                <?php //} 
                ?>

            </ul>
            <?php //}else{ 
            ?>



            <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="myModaltab" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-body">
                                <p> You Are a Non-Talent As You Haven't Selected Any Skills. Please Select At least One
                                    Skills to Become a Talent</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-content">
                <div id="Personal" class="tab-pane fade in active">
                    <div class="container m-top-60">
                        <div class="row">
                            <?php echo  $this->element('viewprofileleft') ?>