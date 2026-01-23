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
<section id="view_profile">
    <div class="container">
        <?php
        $userprof = $this->Comman->proff();
        ?>
        <?php
        $userskill = $this->Comman->userprofileskills($userid);
        ?>
        <?php if (count($userskill) > 0) { ?>
            <h2><?php echo ($userprof['professinal_info']['profile_title']) ? $userprof['professinal_info']['profile_title'] . "'s" : " "; ?>
                <span> <?php echo $profile->profiletitle; ?> Profile</span>
            </h2>
        <?php } else { ?>
            <?php if ($userprof['role_id'] == 3) { ?>
                <h2>Non Talent <span>Profile</span></h2>
            <?php  } else { ?>
                <h2>Talent <span>Profile</span></h2>
        <?php }
        } ?>
        <?php
        $vitalcount = count($uservitals['0']['id']);
        ?>
        <div class="row">
            <?php
            $video = $this->Comman->video($userid);
            $audio = $this->Comman->audio($userid);
            $gallery = $this->Comman->gallery($userid);
            $gallerysingimg = $this->Comman->gallerysingimg($userid);
            ?>
            <ul class="nav nav-tabs nav-justified" role="tablist" style="margin-bottom:20px;">
                <li <?php if ($this->request->params['action'] == 'viewprofile') { ?> class="active" <?php } ?>>
                    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '' ?>" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_personal_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_personal_blue.png">
                        Personal
                    </a>
                </li>
                <li <?php if ($this->request->params['action'] == 'viewgalleries' || $this->request->params['action'] == 'viewimages' || $this->request->params['action'] == 'viewvideos' || $this->request->params['action'] == 'viewaudios') { ?> class="active" <?php } ?>>
                    <a href="" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_gallery_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_gallery_blue.png">
                        Gallery
                    </a>
                </li>
                <li <?php if ($this->request->params['action'] == 'viewschedule') { ?> class="active" <?php } ?>>
                    <a href="" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_schedule_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_schedule_blue.png">
                        Schedule
                    </a>
                </li>
                <li <?php if ($this->request->params['action'] == 'viewreviews') { ?> class="active" <?php } ?>>
                    <a href="" class="">
                        <img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_review_black.png">
                        <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_review_blue.png">
                        Reviews
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="Personal" class="tab-pane fade in active">
                    <div class="container m-top-60">
                        <div class="row">
                            <div class="col-sm-3 profile-det">
                                <?php
                                $totalintroreceived = '0';
                                $totalrequet = '1';
                                if ($totalintroreceived >= $totalrequet) {
                                    echo "od";
                                }
                                ?>
                                <?php $downloadprofilecheck = $this->Comman->downloadprofile(($userid) ? $userid : '0'); ?>
                                <div class="profile-det-img">
                                    <?php if ($profile['social'] == 1 && $profile['profile_image'] != '') { ?>
                                        <img src="<?php echo $profile['profile_image']; ?>" title="<?php echo $profile->name; ?>">
                                    <?php } else if ($profile['profile_image'] != '') { ?>
                                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile->profile_image; ?>" title="<?php echo $profile->name; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo SITE_URL; ?>/images/noimage.jpg" title="<?php echo $profile->name; ?>">
                                    <?php } ?>
                                    <div class="img-top-bar">
                                        <?php $subprpa = $this->Comman->subscriprpack(null); //pr($subprpa); die; 
                                        ?>
                                        <?php if ($subprpa) { ?>
                                            <a href="<?php echo SITE_URL; ?>/profilepackage" title="<?php echo $subprpa['Profilepack']['name'] . " Profile Package"; ?>"><img src="<?php echo SITE_URL; ?>/images/profile-package.png"></a>
                                        <?php } ?>
                                        <?php $subrepa = $this->Comman->subscrirepack(null); //pr($subrepa); die; 
                                        ?>
                                        <?php if ($subrepa) { ?>
                                            <a href="<?php echo SITE_URL; ?>/recruiterepackage" title="<?php echo $subrepa['RequirementPack']['name'] . " Recruiter Package"; ?>"><img src="<?php echo SITE_URL; ?>/images/recruiter-package-.png"></a>
                                        <?php } ?>

                                    </div>
                                </div>
                                <?php $id = $this->request->session()->read('Auth.User.id');
                                $role_id = $this->request->session()->read('Auth.User.role_id');
                                ?>
                                <a href="<?php echo SITE_URL; ?>/profile/unblock/<?php echo $profile->user_id; ?>" class="btn btn-default book">Unblock </a>