<?php
$login_user_id = $this->request->session()->read('Auth.User.id');
// pr($login_user_id);exit;

if ($is_block) { ?>
    <link href="<?php echo SITE_URL; ?>/css/lightbox.css" rel="stylesheet">
    <script src="<?php echo SITE_URL; ?>/js/lightbox.js"></script>
    <?php echo $this->element('blockuserprofile') ?>

<?php } else { ?>

    <script>
        var admin_id = parseInt('<?php echo $login_user_id; ?>',10);
        // console.log('>>>>>>>>>>>>',admin_id);
        
    </script>

    <link href="<?php echo SITE_URL; ?>/css/lightbox.css" rel="stylesheet">
    <script src="<?php echo SITE_URL; ?>/js/lightbox.js"></script>
    <?php echo $this->element('viewprofile') ?>
    <div class="owl-carousel owl-theme owl-loaded advrtjob">
        <?php foreach ($viewrequirads as $key => $value) { ?>
            <div class="owl-item jobadmain">
                <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id']; ?>" target="_blank">
                    <div>
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['advrt_image']; ?>">
                    </div>
                    <div class="advrttext">
                        <?php echo $value['advrtjob__title']; ?>
                    </div>
                </a>
                <a href="<?php echo SITE_URL; ?>/advrtise-my-requirment" target="_blank" title="Advertise My Requirements" class="admyreqr">+</a>
            </div>
        <?php } ?>
    </div>
    <?php if (count($profile) > 0) { ?>
        <div class="col-sm-9 my-info">
            <div class="col-sm-12 prsnl-det">
                <div class="clearfix">
                    <div class="flashmessage">
                        <?php echo $this->Flash->render(); ?>
                    </div>
                    <h4 class="pull-left"><span> <?php echo $profile->name; ?></span></h4>
                    <?php
                    if ($this->Session->read('Auth.User.id') == $profile->user->id) { ?>
                        <div class="pull-right">Online</div>
                    <?php } else { ?>
                        <div class="pull-right">Last Active on
                            <?php echo date("d M Y h:ia", strtotime($profile->user->last_login)); ?></div>
                    <?php } ?>

                </div>
                <div class="col-sm-6 personal-info">
                    <?php
                    if (!empty($profile_title->areyoua) && $profile_title->performing_month > 0) {
                        $indexes = $profile_title->areyoua;
                        $gen = array('P' => 'Professional', 'A' => 'Amateur', 'PT' => 'Part time', 'H' => 'Hobbyist');
                        $areYouA = isset($gen[$profile_title->areyoua]) ? $gen[$profile_title->areyoua] : '';
                    ?>
                        <p><i class="fa fa-clock-o m-right-5" aria-hidden="true"></i><?php echo $areYouA . ' ' . "Since"; ?></p>
                    <?php } ?>


                    <?php $skillcount = count($skillofcontaint); ?>
                    <?php if ($skillcount > 0) { ?>
                        <p><i class="fa fa-briefcase m-right-5" aria-hidden="true"></i>Skills</p>
                    <?php } ?>

                    <?php if ($profile->dob != '') { ?>
                        <p><i class="fa fa-birthday-cake m-right-5" aria-hidden="true"></i>Date of Birth</p>
                    <?php } ?>

                    <?php if ($profile->gender != '') { ?>
                        <p><i class="fa fa-mars m-right-5" aria-hidden="true"></i>Gender</p>
                    <?php } ?>


                    <?php if ($languageknow) { ?>
                        <p class="language"><i class="fa fa-globe m-right-5" aria-hidden="true"></i>Language(s) known</p>
                    <?php } ?>

                    <?php if ($profile->enthicity->title != '') { ?>
                        <p><i class="fa fa-user-circle m-right-5" aria-hidden="true"></i>ethnicity</p>
                    <?php } ?>

                    <?php if ($profile->country_ids != '' && $profile->location != '') { ?>
                        <p class="add-ress"><i class="fa fa-map-marker m-right-5 f-20" aria-hidden="true"></i>From Location</p>
                    <?php } elseif ($profile->country_ids != '') { ?>
                        <p class="add-loc"><i class="fa fa-map-marker m-right-5 f-20" aria-hidden="true"></i>Address Location</p>
                    <?php } elseif ($profile->location != '') { ?>
                        <p class="add-loc"><i class="fa fa-map-marker m-right-5 f-20" aria-hidden="true"></i>From Location</p>
                    <?php } ?>



                </div>
                <div class="col-sm-6">
                    <?php
                    if (!empty($profile_title->areyoua) && $profile_title->performing_month > 0) {
                        $formattedMonthArray = array(
                            "1" => "January",
                            "2" => "February",
                            "3" => "March",
                            "4" => "April",
                            "5" => "May",
                            "6" => "June",
                            "7" => "July",
                            "8" => "August",
                            "9" => "September",
                            "10" => "October",
                            "11" => "November",
                            "12" => "December",
                        ); ?>
                        <p>
                            <?php
                            echo $formattedMonthArray[$profile_title->performing_month];
                            echo $profile_title->performing_year;
                            ?>
                        </p>
                    <?php } ?>

                    <?php if ($skillcount > 0) { ?>
                        <p>

                            <?php
                            if ($skillofcontaint) {
                                foreach ($skillofcontaint as $skils) {
                            ?>
                                    <?php echo $skils->skill->name . ","; ?>
                            <?php }
                            }
                            ?>

                        </p>
                    <?php } ?>

                    <?php if ($profile->dob != '') { ?>
                        <?php $birthdate = date("Y-m-d", strtotime($profile->dob));
                        $from = new DateTime($birthdate);
                        $to   = new DateTime('today'); ?>
                        <p><?php echo date("d M Y", strtotime($profile->dob)); ?> (<?php echo $from->diff($to)->y, "Years"; ?>)</p>
                    <?php } ?>

                    <?php if ($profile->gender != '') { ?>
                        <p><?php if ($profile->gender == 'm') {
                                echo 'Male';
                            } else if ($profile->gender == 'f') {
                                echo 'Female';
                            } elseif ($profile->gender == 'o') {
                                echo 'Other';
                            } elseif ($profile->gender == 'bmf') {
                                echo "Male And Female";
                            }  ?>
                        </p> <?php  } ?>
                    <?php if ($languageknow) { ?>
                        <p>
                            <?php
                            if ($languageknow) {
                                $knownlanguages = '';
                                foreach ($languageknow as $language) {
                                    if (!empty($knownlanguages)) {
                                        $knownlanguages = $knownlanguages . ', ' . $language->language->name;
                                    } else {
                                        $knownlanguages = $language->language->name;
                                    }
                                }
                                echo $knownlanguages;
                            }

                            ?>
                        </p>
                    <?php } ?>
                    <?php if ($profile->enthicity->title != '') { ?>
                        <p><?php echo $profile->enthicity->title; ?></p>
                    <?php } ?>

                    <?php if ($profile->country_ids != '' && $profile->location != '') { ?>
                        <p class="add-loc"><?php echo $profile->location; ?></p>
                    <?php } else if ($profile->country_ids != '') { ?>
                        <p class="add-loc">
                            <?php echo $profile->country->name . ", " . $profile->state->name . ", " . $profile->city->name; ?>
                        </p>
                    <?php } else if ($profile->location != '') { ?>
                        <p class="add-ress"><?php echo $profile->location; ?></p>
                    <?php } ?>

                </div>
            </div>

            <div class="col-sm-12 prsnl-det m-top-20">
                <div class="clearfix">
                    <h4 class="pull-left"><span>Images</span></h4>
                    <?php if (count($totalimages) > 6) { //pr($galleryimages); 
                    ?>
                        <div class="pull-right"><a href="<?php echo SITE_URL; ?>/viewgalleries">View All</a></div>
                    <?php } ?>
                </div>
                <div class="contact-friend">
                    <?php
                    if (count($galleryimages) > 0) { ?>
                        <div class="demo-gallery">
                            <ul id="" class="list-unstyled row" style="display: flex;flex-wrap: wrap;row-gap: 9px;">
                                <?php
                                foreach ($galleryimages as $images) { //pr($images);  
                                ?>
                                    <a class="col-sm-2" href="#">
                                        <img class="single_image" data-userid="<?php echo $profile->user_id; ?>" data-imageid="<?php echo $images->id; ?>" src="<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>">
                                    </a>

                                <?php }
                                ?>
                                <!-- <script>
                                    lightbox.option({
                                        'resizeDuration': 200,
                                        'wrapAround': true,
                                    })
                                </script> -->
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-12">
                            No Images available
                        </div>

                    <?php } ?>
                </div>
            </div>
            <!-- Button trigger modal -->
            <div class="col-sm-12 prsnl-det m-top-20">
                <div class="clearfix">
                    <h4 class="pull-left"><span> Activites</span> </h4>
                    <?php
                    $url = $this->request->here();
                    $visitor_id =  trim($url, "/viewprofile/");
                    $user_id = $this->request->session()->read('Auth.User.id');

                    $currentPackage =  $this->Comman->currentprpackv1();
                    // pr($visitor_id);exit;
                    if ($this->request->session()->read('Auth.User.role_id') == TALANT_ROLEID && $currentPackage['personal_page'] == 'Y') {  ?>
                        <div class="pull-right">

                            <?php if (empty($visitor_id)) { ?>
                                <a href="<?php echo SITE_URL; ?>/personalpage">
                                    <img src="<?php echo SITE_URL; ?>/images/Personal-Page.png" alt="edit_profile_icon">Create a
                                    page</a>
                            <?php } ?>

                            <?php if ($viewpage) { ?>
                                <a href="<?php echo SITE_URL; ?>/viewpersonalpage/<?php echo $user_id; ?>" target="_blank"> View Page</a>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
                <?php
                // pr($activities);die;
                $loginid = $this->request->session()->read('Auth.User.id');
                if ($activities && count($activities) > 0) {
                    foreach ($activities as $activity_data) { //pr($activity_data);

                        // Calculate time 
                        /*
                            $datetime = $activity_data->date;
                            $actualdate=date('Y-m-d',strtotime($datetime));
                            $now = new DateTime;
                            $ago = new DateTime($datetime);
                            $diff = $now->diff($ago);
                            $diff->w = floor($diff->d / 7);
                            $diff->d -= $diff->w * 7;
                            $string = array(
                            'y' => 'year',
                            'm' => 'month',
                            'w' => 'week',
                            'd' => 'day',
                            'h' => 'hour',
                            'i' => 'minute',
                            's' => 'second',
                            );
                            foreach ($string as $k => &$v) {
                            if ($diff->$k) {
                                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                            } else {
                                unset($string[$k]);
                            }
                            }
                            //pr($string);

                            //if (!$full) $string = array_slice($string, 0, 1);
                            $time_diff = $string ? implode(', ', $string) . ' ago' : 'today';
                            //print_r($time_diff);
                            */
                ?>
                        <div class="row activites-blog Act_info">
                            <?php if ($profile->profile_image != '') { ?>
                                <div class="col-sm-2">
                                    <div class="pro_img">
                                        <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile->user_id; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile->profile_image; ?>"></a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-2">
                                    <div class="pro_img">
                                        <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile->user_id; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg"></a>
                                    </div>
                                </div>

                            <?php } ?>

                            <!--=========================update album photo section start =========================-->
                            <?php if ($activity_data->activity_type == 'update_album') { ?>


                                <!-- Update Profile -->
                                <div class="col-sm-8 activites" style="margin-top: 10px;">

                                    <p><span><?php echo $profile->name; ?></span> Uploaded a Photo Album.</p>
                                    <div><i class="fa fa-clock-o"></i><em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>
                                        </em>
                                    </div>
                                </div>
                                <div class="col-sm-12 up-image" style="margin-top: 8px;">

                                    <img
                                        class="show_images"
                                        data-userid="<?php echo $activity_data->user_id; ?>"
                                        data-albumid="<?php echo $activity_data->galleryimage->gallery_id; ?>" height="350px"
                                        width="100%"
                                        data-imageid="<?php echo $activity_data->galleryimage->id; ?>"
                                        src="<?php echo SITE_URL; ?>/gallery/<?php echo $activity_data->galleryimage->imagename; ?>">

                                    <?php
                                    $totalimagelike = $this->Comman->totalimagelike($activity_data['photo_id']); //pr($country); 
                                    $totaluserimagelike = $this->Comman->totaluserimagelike($activity_data['photo_id']); //pr($activity_data); die;
                                    ?>

                                    <div class="activity-detail-social-icon profile_action">
                                        <ul class="list-unstyled">

                                            <li>
                                                <a href="javascript:void(0)" class="bg-blue likeimage <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>" data-toggle="tooltip" data-val="<?php echo ($loginid) ? $loginid : '0' ?>" id="likeimage<?php echo $activity_data['galleryimage']['id']; ?>" data-imageid="<?php echo $activity_data['galleryimage']['id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

                                                <div class="totallikecount">
                                                    <a href="<?php echo SITE_URL ?>/profile/likedusers/<?php echo ($activity_data->photo_id) ? $activity_data->photo_id : '0' ?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes">
                                                        <span class="totallikecount<?php echo $activity_data['galleryimage']['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li>
                                                <!-- <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue activityshare"
                                                data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a> -->

                                                <div class="share_button activityshare-toggle" style="display: none;">
                                                    <ul class="list-unstyled list-inline text-center">
                                                        <li>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button" data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                        </li>

                                                        <li>
                                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

                                                            </a>
                                                        </li>


                                                        <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <!-- <div class="like"><a href="#">18</a></div> -->
                                            </li>

                                            <?php if ($userid > 0) { ?>
                                                <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a></li>
                                            <?php } ?>
                                            <div class="clearfix"> </div>
                                        </ul>
                                    </div>


                                </div>

                                <!--update album photo section end -->



                                <!--========================================update photo section start ==========================-->

                            <?php } elseif ($activity_data->activity_type == 'update_photos') { ?>
                                <!-- Update Profile -->
                                <div class="col-sm-8 activites" style="margin-top: 10px;">

                                    <p><span><?php echo $profile->name; ?></span> Uploaded a Photo.</p>
                                    <div><i class="fa fa-clock-o"></i><em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>



                                        </em>

                                    </div>
                                </div>

                                <?php //pr($activity_data->galleryimage);  
                                ?>

                                <div class="col-sm-12 up-image" style="margin-top: 8px;">
                                    <a href="#"> <img src="<?php echo SITE_URL; ?>/gallery/<?php echo $activity_data->galleryimage->imagename; ?>" height="350px" width="100%" class="single_image" data-userid="<?php echo $profile->user_id; ?>" data-imageid="<?php echo $activity_data->galleryimage->id; ?>"></a>

                                    <?php
                                    $totalimagelike = $this->Comman->totalimagelike($activity_data['photo_id']); //pr($country); 
                                    $totaluserimagelike = $this->Comman->totaluserimagelike($activity_data['photo_id']); //p
                                    ?>
                                    <div class="activity-detail-social-icon profile_action">
                                        <ul class="list-unstyled">

                                            <li>
                                                <a href="javascript:void(0)" class="bg-blue likeimage <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>" data-toggle="tooltip" data-val="<?php echo ($loginid) ? $loginid : '0' ?>" id="likeimage<?php echo $activity_data['galleryimage']['id']; ?>" data-imageid="<?php echo $activity_data['galleryimage']['id']; ?>" data-userid="<?php echo $profile->user_id; ?>" data-imagena="<?php echo $activity_data['galleryimage']['imagename']; ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>


                                                <div class="totallikecount">
                                                    <a href="<?php echo SITE_URL ?>/profile/likedusers/<?php echo ($activity_data->photo_id) ? $activity_data->photo_id : '0' ?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes">
                                                        <span class="totallikecount<?php echo $activity_data['galleryimage']['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>
                                                    </a>
                                                </div>
                                            </li>

                                            <li>
                                                <!-- <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue activityshare"
                                data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a> -->

                                                <div class="share_button activityshare-toggle" style="display: none;">
                                                    <ul class="list-unstyled list-inline text-center">
                                                        <li>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button" data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                        </li>

                                                        <li>
                                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

                                                            </a>
                                                        </li>


                                                        <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <!-- <div class="like"><a href="#">18</a></div> -->
                                            </li>

                                            <?php if ($userid > 0) { ?>
                                                <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a></li>
                                            <?php } ?>
                                            <div class="clearfix"> </div>
                                        </ul>
                                    </div>


                                </div>

                                <!--update photo section end -->
                                <!--========================================update audio section start============================== -->

                            <?php } elseif ($activity_data->activity_type == 'upload_audio') { ?>
                                <!-- Update Profile -->
                                <div class="col-sm-8 activites" style="margin-top: 10px;">

                                    <p><span><?php echo $profile->name; ?></span> Uploaded a Audio.</p>
                                    <div><i class="fa fa-clock-o"></i><em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>
                                        </em>

                                    </div>
                                </div>
                                <div class="col-sm-12 up-image" style="margin-top: 8px;">
                                    <a data-toggle="modal" class='m-top-5 audio' href="<?php echo SITE_URL ?>/profile/audiosonline/<?php echo $activity_data['audio']['id']; ?>" data-val="<?php echo $activity_data['audio']['audio_link']; ?>"><img src="<?php echo SITE_URL; ?>/images/Audio-icon.png"></a>
                                    <?php
                                    $totalimagelike = $this->Comman->totalaudiolike($activity_data['photo_id']); //pr($totalimagelike); 
                                    $totaluserimagelike = $this->Comman->totaluseraudiolike($activity_data['photo_id']); //pr($totaluserimagelike);
                                    ?>

                                    <div class="activity-detail-social-icon profile_action">
                                        <ul class="list-unstyled">

                                            <li>

                                                <a href="javascript:void(0)" class="bg-blue likeaudio <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>" data-toggle="tooltip" data-val="<?php echo ($loginid) ? $loginid : '0' ?>" id="likeaudio<?php echo $activity_data['audio']['id']; ?>" data-videoid="<?php echo $activity_data['audio']['id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>


                                                <div class="totallikecount ">
                                                    <a href="<?php echo SITE_URL ?>/profile/audiolikedusers/<?php echo ($activity_data->photo_id) ? $activity_data->photo_id : '0' ?>" data-toggle="modal" class="m-top-5 singlelikeprofile likeaudio" id="totallikes">
                                                        <span class="totallikecount<?php echo $activity_data['audio']['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>
                                                    </a>
                                                </div>


                                            </li>




                                            <li>
                                                <!-- <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue activityshare"
                                data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a> -->

                                                <div class="share_button activityshare-toggle" style="display: none;">
                                                    <ul class="list-unstyled list-inline text-center">
                                                        <li>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button" data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                        </li>

                                                        <li>
                                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

                                                            </a>
                                                        </li>


                                                        <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <!-- <div class="like"><a href="#">18</a></div> -->
                                            </li>
                                            <?php if ($userid > 0) { ?>
                                                <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a></li>
                                            <?php } ?>
                                            <div class="clearfix"> </div>
                                        </ul>
                                    </div>


                                </div>
                                <!--===============================update  audio  section end ======================-->


                                <!--=============================update video section start========================== -->

                            <?php } elseif ($activity_data->activity_type == 'upload_video') { ?>
                                <!-- Update Profile -->
                                <div class="col-sm-8 activites" style="margin-top: 10px;">

                                    <p><span><?php echo $profile->name; ?></span> Uploaded a Video.</p>
                                    <div><i class="fa fa-clock-o"></i><em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>
                                        </em>

                                    </div>
                                </div>
                                <div class="col-sm-12 up-image" style="margin-top: 8px;">

                                    <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL ?>/profile/videosonline/<?php echo $activity_data['video']['id']; ?>">
                                        <?php if (!empty($activity_data['video']['thumbnail'])) { ?>
                                            <img src="<?php echo SITE_URL ?>/videothumb/<?php echo $activity_data['video']['thumbnail'];  ?>" height="350" width="850px">
                                        <?php } else { ?>
                                            <img src="<?php echo SITE_URL ?>/videothumb/vid-ico.png" height="185px" width="100%" style="border:1px solid black">
                                        <?php } ?>
                                    </a>
                                    <?php
                                    $totalimagelike = $this->Comman->totalvideolike($activity_data['photo_id']); //pr($totalimagelike); 
                                    $totaluserimagelike = $this->Comman->totaluservideolike($activity_data['photo_id']); //pr($totaluserimagelike);
                                    ?>

                                    <div class="activity-detail-social-icon profile_action">
                                        <ul class="list-unstyled">

                                            <li>

                                                <a href="javascript:void(0)" class="bg-blue likevideo <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>" data-toggle="tooltip" data-val="<?php echo ($loginid) ? $loginid : '0' ?>" id="likevideo<?php echo $activity_data['video']['id']; ?>" data-videoid="<?php echo $activity_data['video']['id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>


                                                <div class="totallikecount">
                                                    <a href="<?php echo SITE_URL ?>/profile/videolikedusers/<?php echo ($activity_data->photo_id) ? $activity_data->photo_id : '0' ?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes">
                                                        <span class="totallikecount<?php echo $activity_data['video']['id']; ?>  licount <?php echo (isset($totaluserimagelike) && $totaluserimagelike > 0) ? 'active' : ''; ?>"><?php echo $totalimagelike; ?></span>
                                                    </a>
                                                </div>
                                            </li>



                                            <li>
                                                <!-- <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue activityshare"
                                data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a> -->

                                                <div class="share_button activityshare-toggle" style="display: none;">
                                                    <ul class="list-unstyled list-inline text-center">
                                                        <li>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button" data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                        </li>

                                                        <li>
                                                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

                                                            </a>
                                                        </li>


                                                        <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <!-- <div class="like"><a href="#">18</a></div> -->
                                            </li>
                                            <?php if ($userid > 0) { ?>
                                                <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a></li>
                                            <?php } ?>

                                            <div class="clearfix"> </div>
                                        </ul>
                                    </div>


                                </div>
                                <!--update video section end -->

                                <!--update profile section start -->

                            <?php } elseif ($activity_data->activity_type == 'update_profile') { ?>
                                <div class="col-sm-8 activites">
                                    <p><span><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile->user_id; ?>"><?php echo $profile->name; ?></a></span>
                                        Updated Profile.</p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                                <!--update profile section end -->

                                <!--like profile section start -->
                            <?php } elseif ($activity_data->activity_type == 'like_profile') { ?>
                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> has liked the profile of <a target="_blank" href="<?php echo SITE_URL . '/viewprofile/' . $activity_data['profile_id']; ?>">
                                            <?php echo $activity_data->user->user_name; ?></a></p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                                <!--unlike profile section end -->

                                <!--unlike profile section start -->
                            <?php } elseif ($activity_data->activity_type == 'unlike_profile') { ?>
                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> Unlike <a target="_blank" href="<?php echo SITE_URL . '/viewprofile/' . $activity_data['profile_id']; ?>">
                                            <?php echo $activity_data->user->user_name; ?>'s Profile.</a></p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                                <!--unlike profile section end -->
                            <?php } elseif ($activity_data->activity_type == 'like_job') {
                                $unlikeimage = $this->Comman->unlikejob($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> has liked the
                                        <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $unlikeimage['id']; ?>">
                                            <?php echo $unlikeimage['title']; ?></a> Job
                                    </p>
                                    <div>
                                        <i class="fa fa-clock-o"></i>
                                        <em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>
                                        </em>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 up-image" style=" margin-top: 8px; ">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $unlikeimage['image']; ?>" height="350px" width="100%">
                                </div> -->

                            <?php } elseif ($activity_data->activity_type == 'unlike_job') {
                                $unlikeimage = $this->Comman->unlikejob($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites" style="">
                                    <p><span><?php echo $profile->name; ?></span> Unlike
                                        <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $unlikeimage['id']; ?>"><?php echo $unlikeimage['title']; ?></a>
                                        Job
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                                <!-- <div class="col-sm-12 up-image" style=" margin-top: 8px; ">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $unlikeimage['image']; ?>" height="350px" width="100%">
                                </div> -->

                            <?php } elseif ($activity_data->activity_type == 'like_image') {
                                $unlikeimage = $this->Comman->unlikeimage($activity_data['user_id'], $activity_data['profile_id']);
                                // pr($unlikeimage);exit;

                            ?>

                                <div class="col-sm-8 activites">

                                    <?php if ($unlikeimage['gallery_id'] != '0') { ?>
                                        <p><span><?php echo $profile->name; ?></span> has liked the
                                            <a href="#" class="show_images" data-userid="<?php echo $unlikeimage['user_id']; ?>" data-albumid="<?php echo $unlikeimage['gallery_id']; ?>" data-imageid="<?php echo $unlikeimage['id']; ?>"> gallery image</a>
                                        </p>
                                    <?php } else { ?>
                                        <p><span><?php echo $profile->name; ?></span> has liked the
                                            <a href="#" class="single_image" data-userid="<?php echo $unlikeimage['user_id']; ?>" data-imageid="<?php echo $unlikeimage['id']; ?>">image</a>
                                        </p>
                                    <?php } ?>

                                    <div>
                                        <i class="fa fa-clock-o"></i>
                                        <em>
                                            <?php
                                            $todaydate =   date("Y-m-d");
                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                            if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?>
                                        </em>
                                    </div>
                                </div>

                            <?php } elseif ($activity_data->activity_type == 'unlike_image') {
                                $unlikeimage = $this->Comman->unlikeimage($activity_data['user_id'], $activity_data['profile_id']);

                            ?>

                                <div class="col-sm-8 activites">
                                    <?php if ($unlikeimage['gallery_id'] != '0') { ?>
                                        <p><span><?php echo $profile->name; ?></span> Unlike
                                            <a href="#" class="show_images" data-userid="<?php echo $unlikeimage['user_id']; ?>" data-albumid="<?php echo $unlikeimage['gallery_id']; ?>" data-imageid="<?php echo $unlikeimage['id']; ?>"> gallery image</a>
                                        </p>
                                    <?php } else { ?>
                                        <p><span><?php echo $profile->name; ?></span> Unlike
                                            <a href="#" class="single_image" data-userid="<?php echo $unlikeimage['user_id']; ?>" data-imageid="<?php echo $unlikeimage['id']; ?>">image</a>
                                        </p>
                                    <?php } ?>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>

                            <?php } elseif ($activity_data->activity_type == 'like_video') {
                                $unlikeimage = $this->Comman->unlikevideo($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites" style="">
                                    <p><span><?php echo $profile->name; ?></span> has liked the
                                        <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL ?>/profile/videosonline/<?php echo $unlikeimage['id']; ?>">Video
                                        </a>
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                            <?php } elseif ($activity_data->activity_type == 'unlike_video') {
                                $unlikeimage = $this->Comman->unlikevideo($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites" style="">
                                    <p><span><?php echo $profile->name; ?></span> Unlike <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL ?>/profile/videosonline/<?php echo $unlikeimage['id']; ?>">Video
                                        </a></p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                            <?php } elseif ($activity_data->activity_type == 'like_audio') {
                                $unlikeimage = $this->Comman->unlikeaudio($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> has liked the
                                        <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL . '/profile/audiosonline/' . $unlikeimage['id']; ?>"> Audio</a>
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                            <?php } elseif ($activity_data->activity_type == 'unlike_audio') {
                                $unlikeimage = $this->Comman->unlikeaudio($activity_data['user_id'], $activity_data['profile_id']);
                            ?>

                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> Unlike
                                        <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL . '/profile/audiosonline/' . $unlikeimage['id']; ?>"> Audio</a>
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                            <?php } elseif ($activity_data->activity_type == 'block_profile') { ?>
                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> Blocked <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $activity_data['user']['id']; ?>"><?php echo $activity_data->user->user_name; ?>.</a>
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>

                            <?php } elseif ($activity_data->activity_type == 'unblock_profile') { ?>
                                <div class="col-sm-8 activites">
                                    <p><span><?php echo $profile->name; ?></span> Unblocked <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $activity_data['user']['id']; ?>"><?php echo $activity_data->user->user_name; ?>.</a>
                                    </p>
                                    <div><i class="fa fa-clock-o"></i><em> <?php
                                                                            $todaydate =   date("Y-m-d");
                                                                            $previusdate = date('Y-m-d', strtotime("-1 days"));
                                                                            ?>
                                            <?php if ($todaydate ==  date_format($activity_data['date'], "Y-m-d")) {
                                                echo   "Today, " . date_format($activity_data['date'], "H:i");
                                            } else if ($previusdate ==  date_format($activity_data['date'], "Y-m-d")) {

                                                echo "Yesterday, " . date_format($activity_data['date'], "H:i");
                                            } else {
                                                echo date_format($activity_data['date'], "M d, Y H:i");
                                            }
                                            ?> </em></div>
                                </div>
                            <?php } else {
                            } ?>

                        </div>
                    <?php } ?>
                    <!--<div class="col-sm-12"><a href="#" class="btn btn-default">View All</a></div>-->
                <?php } else { ?>
                    No Activity available.
                <?php } ?>
            </div>
        </div>
        </div>
    <?php } else { ?>
        <div class="col-sm-9 my-info">
            <div class="col-sm-12 prsnl-det">
                <div class="clearfix">
                    <h4 class="text-center">Profile hasn't been created.</h4>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    </div>

    </div>
    </div>
    </div>
    </section>
<?php } ?>



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
    $(".activityshare").click(function(e) {
        e.preventDefault();
        $(".activityshare-toggle").slideToggle();
    });
</script>

<style>
    .share_button.activityshare-toggle {
        position: absolute;
        top: 29px;
        width: 152px;
        background: #fff;
        padding: 10px;
        z-index: 9;
        border: 1px solid #ccc;
        left: 6px;
        padding-bottom: 0px;
    }

    .share_button.activityshare-toggle li a {
        font-size: 14px;
        color: #3c3c3c;
    }

    .activity-detail-social-icon ul li {
        /* display: inline-block; */
        position: relative;
        padding-bottom: 8px;
        float: left;
        text-align: center;
    }
</style>

<script>
    $('.single_image').click(function(e) { //alert();
        e.preventDefault();
        userid = $(this).data('userid');
        imageid = $(this).data('imageid');
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

    /* .modal-dialog {
        width: 70%;
    } */
</style>

<!-------------------------------------------------->
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


<!-- <div id="myModalreportvideo" class="modal fade">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body" id="videosreportuser"></div>
        </div>
         /.modal-content -->
<!-- </div> -->
<!-- /.modal-dialog -->

<!-- </div>  -->


<!-- ==================================modal for video pop-up showing========================= -->
<div id="myModal" class="modal">
    <div class="modal-dialog">

        <div class="modal-content">
            <button type="button" class="videopopclo close" data-dismiss="modal">&times;</button>
            <div class="modal-body" id="videosearch"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.modal -->
<script>
    $('.videos').click(function(e) {
        e.preventDefault();
        $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>


<script>
    $('.audio').click(function(e) {
        e.preventDefault();
        var val = $(this).data('val');
        window.open(val, '_blank');
        $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>

<style>
    /* .modal-dialog {
        width: 80%;
    } */

    button.close {
        z-index: 99999 !important;
        right: 0px !important;
        top: -1px !important;
        position: absolute !important;
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
</style>


<!--======================gallery images pop-up=================-->

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

    img.show_images:hover {
        cursor: pointer;
    }

    /* .modal-dialog {
        width: 70%;
    } */
</style>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".flashmessage").css("display", "none");
        }, 7000);

    });
</script>

<script>
    // $('.likeimage').click(function() {
    //     // error_text = "You cannot Like yourself";
    //     user_id = $(this).data('val');
    //     imageid = $(this).data('imageid');
    //     image_name = $(this).data('imagena');
    //     reciveid = $(this).data('userid');
    //     //alert(reciveid); 
    //     if (user_id > 0) {
    //         $.ajax({
    //             type: "POST",
    //             url: '<?php echo SITE_URL; ?>/profile/checklike',
    //             data: {
    //                 user_id: user_id,
    //                 content_id: imageid,
    //                 imagename: image_name,
    //                 reciveid: reciveid
    //             },
    //             cache: false,
    //             success: function(data) {
    //                 obj = JSON.parse(data);
    //                 if (obj.error == 1) {
    //                     showerror(error_text);
    //                 } else {
    //                     //  alert(obj.count);
    //                     if (obj.status == 'like') {
    //                         $("#likeimage" + imageid).addClass('active');
    //                         $(".totallikecount" + imageid).addClass('active');

    //                     } else {
    //                         $("#likeimage" + imageid).removeClass('active');
    //                         $(".totallikecount" + imageid).removeClass('active');
    //                     }
    //                     $(".totallikecount" + imageid).html(obj.count);
    //                 }
    //             }
    //         });
    //     } else {
    //         //  showerror(error_text);
    //     }
    // });
</script>

<script>
    // $('.likevideo').click(function() {
    //     // error_text = "You cannot Like yourself";
    //     user_id = $(this).data('val');
    //     videoid = $(this).data('videoid');
    //     //alert(videoid);
    //     if (user_id > 0) {
    //         $.ajax({
    //             type: "POST",
    //             url: '<?php echo SITE_URL; ?>/profile/checkvideolike',
    //             data: {
    //                 user_id: user_id,
    //                 content_id: videoid
    //             },
    //             cache: false,
    //             success: function(data) {
    //                 obj = JSON.parse(data);
    //                 if (obj.error == 1) {
    //                     // showerror(error_text);
    //                 } else {
    //                     if (obj.status == 'like') {
    //                         $("#likevideo" + videoid).addClass('active');
    //                         $(".totallikecount" + videoid).addClass('active');

    //                     } else {
    //                         $("#likevideo" + videoid).removeClass('active');
    //                         $(".totallikecount" + videoid).removeClass('active');
    //                     }
    //                     $(".totallikecount" + videoid).html(obj.count);
    //                 }
    //             }
    //         });
    //     } else {
    //         //showerror(error_text);
    //     }
    // });
</script>

<script>
    // $('.likeaudio').click(function() {
    //     //error_text = "You cannot Like yourself";
    //     user_id = $(this).data('val');
    //     videoid = $(this).data('videoid');

    //     if (user_id > 0) {
    //         $.ajax({
    //             type: "POST",
    //             url: '<?php echo SITE_URL; ?>/profile/checkaudiolike',
    //             data: {
    //                 user_id: user_id,
    //                 content_id: videoid
    //             },
    //             cache: false,
    //             success: function(data) {
    //                 obj = JSON.parse(data);
    //                 if (obj.error == 1) {
    //                     showerror(error_text);
    //                 } else {
    //                     if (obj.status == 'like') {
    //                         $("#likeaudio" + videoid).addClass('active');
    //                         $(".totallikecount" + videoid).addClass('active');
    //                     } else {
    //                         $("#likeaudio" + videoid).removeClass('active');
    //                         $(".totallikecount" + videoid).removeClass('active');
    //                     }

    //                     $(".totallikecount" + videoid).html(obj.count);
    //                 }

    //             }
    //         });
    //     } else {
    //         //	showerror(error_text);
    //     }
    // });
</script>

<style>
    .likeimage.active,
    .likevideo.active,
    .likeaudio.active {
        color: red;
    }

    .licount.active {
        color: red;
    }

    a:focus,
    a:active,
    a:hover {
        color: #e6e6e6;
    }
</style>


<!-- show activity photo video audio like user  -->
<script>
    $('.singlelikeprofile').click(function(e) { //alert();
        e.preventDefault();
        $('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
    });
    $('#closemodal').click(function() {
        $('#myModallikesvideo').modal('hide');
    });
</script>