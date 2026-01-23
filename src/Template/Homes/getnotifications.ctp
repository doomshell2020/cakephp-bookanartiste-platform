<style>
    .N,
    .Y {
        cursor: pointer;
    }

    .N {
        background-color: #f8f7f7;
    }

    .Y {
        background-color: white;
    }
</style>

<?php
//pr($requirementfeatured); die;
//$today_brithday = $this->Comman->todaybrithday();
// pr($currentpackanme[1]);
// die;
$pr_pack = $this->Comman->getPackageNameById($subscriptions['PR']['package_id']);
$rc_pack = $this->Comman->getPackageNameById($subscriptions['RC']['package_id']);
// pr($authUser['role_id']==2);
// pr($rc_pack);
// die;

if (count($notification) > 0 || count($today_brithday) > 0 || count($profile_pack) > 0 || count($recruiter_pack) > 0) { ?>


    <?php
    $expiryDate = strtotime($currentpackanme[0]);
    $today = strtotime(date('Y-m-d'));

    // Difference in days (negative means it's already expired)
    $diffDays = floor(($expiryDate - $today) / (60 * 60 * 24));

    if ($expiryDate < $today && $authUser['role_id'] == 2) { // 🔥 Expired package
    ?>
        <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction('<?php echo $contact['id']; ?>','<?php echo $contact['view_status']; ?>')">
            <ul>
                <li class="request_left1 col-sm-2">
                    <ul class="row">
                        <?php if (!empty($profile_pack['user']['profile']['profile_image'])) { ?>
                            <li class="col-sm-4">
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>">
                                    <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile_pack['user']['profile']['profile_image']; ?>" alt="profile_image">
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="profile_img_cercle1 profile_slidedown">
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>">
                                    <img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image">
                                </a>
                                <span class="caret"></span>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="request_right1 col-sm-10">
                    <ul class="row">
                        <li class="col-sm-12">
                            <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>" style="font-size: 14px; color: #078fe8">
                                <?php echo $profile_pack['user']['user_name']; ?>
                            </a>
                            <span style="color: black;">
                                Your <?php echo $pr_pack['name']; ?> Profile Package
                                <strong style="color: red;">expired on <?php echo date("M d, Y", $expiryDate); ?></strong>.
                                <?php if (in_array($diffDays, [-15, -10, -7])) { ?>
                                    <span style="color: darkred;"> (It's been <?php echo abs($diffDays); ?> days since expiration.)</span>
                                <?php } ?>
                                Please <a href="<?php echo SITE_URL; ?>/package/allpackages/"><span style="color: black;">Renew or Upgrade your Membership</span></a>.
                            </span>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

    <?php } ?>

    <?php
    // Extract the expiration date from the second index
    $expiryDate = strtotime($currentpackanme[1]); // Assuming it's a valid date string

    // Difference in days (negative means already expired)
    $diffDays = floor(($expiryDate - $today) / (60 * 60 * 24));

    // If the package has expired (expiry date is earlier than today)
    if ($expiryDate < $today && $authUser['role_id'] == 2) {
    ?>
        <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction('<?php echo $contact['id']; ?>', '<?php echo $contact['view_status']; ?>')">
            <ul>
                <li class="request_left1 col-sm-2">
                    <ul class="row">
                        <?php if (!empty($profile_pack['user']['profile']['profile_image'])) { ?>
                            <li class="col-sm-4">
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>">
                                    <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile_pack['user']['profile']['profile_image']; ?>" alt="profile_image">
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="profile_img_cercle1 profile_slidedown">
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>">
                                    <img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image">
                                </a>
                                <span class="caret"></span>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="request_right1 col-sm-10">
                    <ul class="row">
                        <li class="col-sm-12">
                            <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>" style="font-size: 14px; color: #078fe8">
                                <?php echo $profile_pack['user']['user_name']; ?>
                            </a>
                            <span style="color: black;">
                                Your <?php echo $pr_pack['name']; ?> Profile Package
                                <strong style="color: red;">expired on <?php echo date("M d, Y", $expiryDate); ?></strong>.
                                <?php if (in_array($diffDays, [-15, -10, -7])) { ?>
                                    <span style="color: darkred;"> (It's been <?php echo abs($diffDays); ?> days since expiration.)</span>
                                <?php } ?>
                                Please <a href="<?php echo SITE_URL; ?>/package/allpackages/"><span style="color: black;">Renew or Upgrade your Membership</span></a>.
                            </span>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    <?php
    }
    ?>




    <?php if (!empty($requirementfeatured)) { ?>
        <?php foreach ($requirementfeatured as $value) {
            $currentdate = date("Y-m-d H:m:s");
            $lastdate_app = date('Y-m-d H:m:s', strtotime($data['requirement']['event_to_date']));
            if ($lastdate_app < $currentdate) { ?>
                <li class="row request_one frnd-rq">
                    <ul>
                        <li class="request_right1 col-sm-12">
                            <ul class="row">
                                <li class="col-sm-8"><span style="color: black;">Please</span> <a href="<?php echo SITE_URL ?>/requirement/talentrating/<?php echo $value['job_id']; ?>/<?php echo $value['user_id']; ?>" style="font-size: 14px; color: #078fe8">Write Review </a><span style="color: black;"> for <?php echo $value['user']['user_name']; ?> hired by you as <?php echo $value['skill']['name']; ?> for <?php echo $value['requirement']['title']; ?><span></li>
                            </ul>
                        </li>
                    </ul>
                </li>
        <?php }
        } ?>
    <?php } ?>


    <?php foreach ($today_brithday as $value) {

        if ($value['gender'] == 'm') {
            $usergender = 'his';
        } else if ($value['gender'] == 'f') {
            $usergender = 'her';
        }
        if ($value['gender'] == 'o') {
            $usergender = 'his/her';
        } else {
            $usergender = 'his/her';
        }
    ?>
        <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
            <ul>
                <li class="request_left1 col-sm-2">
                    <ul class="row">
                        <?php if ($value['profile_image'] != '') { ?>
                            <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $value['profile_image']; ?>" alt="profile_image"></a></li>
                        <?php } else { ?>
                            <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="request_right1 col-sm-10">
                    <ul class="row">
                        <li class="col-sm-12"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['user']['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $value['user']['user_name'];  ?> </a><span style="color: black;"> <?php echo $usergender; ?> birthday today. Wish Happy Birthday !!</span></li>
                    </ul>


                </li>

            </ul>
        </li>
    <?php } ?>


    <?php foreach ($notification as $contact) {
        //pr($contact);
        if ($contact['type'] == 'Alert') { ?>

            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo htmlspecialchars($contact['id']); ?>', '<?php echo htmlspecialchars($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                    </li>
                    <li class="request_right1 col-sm-10">
                        <!-- Notification Content -->
                        <span class="text-muted" style="font-size: 13px;">
                            <strong><?php echo htmlspecialchars($contact['type']); ?></strong>
                            <span style="font-size: 13px; color: black;">
                                <?php echo htmlspecialchars($contact['content']); ?>
                                <!-- <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>"
                                    class="text-primary" style="font-size: 14px;">
                                    <?php echo htmlspecialchars($contact['user']['user_name']); ?>
                                </a> -->
                            </span>
                        </span>
                    </li>
                </ul>
            </li>

        <?php  } else if ($contact['type'] == "photo like" || $contact['type'] == "audio like" || $contact['type'] == "video like") {
            //pr($contact);
            // if($contact->Users->id!=$userid)
            //{
        ?>
            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo htmlspecialchars($contact['id']); ?>', '<?php echo htmlspecialchars($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <?php if ($contact['user']['profile']['profile_image'] != '') { ?>
                                <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $contact['user']['profile']['profile_image']; ?>" alt="profile_image"></a></li>
                            <?php
                            } else { ?>

                                <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                            <?php
                            } ?>

                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <?php if ($contact['type'] == "photo like") { ?>
                                <li class="col-sm-9"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $contact['user']['user_name']; ?> </a><span style="color: black;"> likes your photo</span>
                                </li>
                                <li class="col-sm-3"><a href="<?php echo SITE_URL; ?>/viewgalleries"><img src="<?php echo SITE_URL; ?>/gallery/<?php echo $contact['content']; ?>" alt="like image"></a></li>
                            <?php
                            } elseif ($contact['type'] == "audio like") { ?>
                                <li class="col-sm-12"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $contact['user']['user_name']; ?> </a><span style="color: black;"> likes <a style="font-size: 14px; color: #078fe8;" href="<?php echo SITE_URL; ?>/viewaudios">Audio</a></span>
                                </li>
                            <?php
                            } elseif ($contact['type'] == "video like") { ?>
                                <?php $video = $this->Comman->videodetail($contact['content']); ?>
                                <li class="col-sm-9"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $contact['user']['user_name']; ?> </a><span style="color: black;"> likes your video </span>
                                </li>
                                <li class="col-sm-3"><a href="<?php echo SITE_URL; ?>/viewvideos" data-toggle="modal" class='m-top-5 videos'><img src="<?php echo SITE_URL; ?>/videothumb/<?php echo $video['thumbnail']; ?>" alt="like image"></a></li>
                            <?php
                            } ?>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "profile like" || $contact['type'] == "job like" || $contact['type'] == "request accept" || $contact['type'] == "request deleted") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
            //pr($sender); die;

        ?>
            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo addslashes($contact['id']); ?>', '<?php echo addslashes($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <?php if ($sender['profile']['profile_image'] != '') { ?>
                                <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $sender['profile']['profile_image']; ?>" alt="profile_image"></a></li>
                            <?php
                            } else { ?>

                                <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                            <?php
                            } ?>

                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <?php if ($contact['type'] == "profile like") { ?>
                                <li class="col-sm-10"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $sender['user_name']; ?> </a><span style="color: black;"> likes your profile</span></li>
                            <?php
                            } elseif ($contact['type'] == "job like") {
                                $job = $this->Comman->jobtitle($contact['content']);
                                //pr($job);

                            ?>
                                <li class="col-sm-10"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $sender['user_name']; ?> </a><span style="color: black; font-size:12px"> has liked your Job <i style="margin-right: 2px;" class="fa fa-suitcase" aria-hidden="true"></i><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $contact['content']; ?>"><?php echo $job['title']; ?></a></span></li>
                            <?php
                            } elseif ($contact['type'] == "request accept") { ?>
                                <li class="col-sm-12"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $sender['user_name']; ?> </a><span style="color: black;"> is now a connection</span></li>
                            <?php
                            } elseif ($contact['type'] == "request deleted") { ?>
                                <li class="col-sm-12"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $sender['user_name']; ?> </a><span style="color: black;"> has deleted the request</span></li>
                            <?php
                            } ?>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php
        } elseif ($contact['type'] == "job post") {
            $job = $this->Comman->jobtitle($contact['content']);
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
            //pr($sender); die;

        ?>
            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo htmlspecialchars($contact['id']); ?>', '<?php echo htmlspecialchars($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <?php if (!empty($sender['profile']['profile_image'])) { ?>
                                <li class="col-sm-4">
                                    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo htmlspecialchars($sender['id']); ?>">
                                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo htmlspecialchars($sender['profile']['profile_image']); ?>"
                                            alt="profile_image">
                                    </a>
                                </li>
                            <?php
                            } else { ?>
                                <li class="profile_img_cercle1 profile_slidedown">
                                    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo htmlspecialchars($sender['id']); ?>">
                                        <img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image">
                                    </a>
                                    <span class="caret"></span>
                                </li>
                            <?php
                            } ?>
                        </ul>
                    </li>

                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-12">
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo htmlspecialchars($sender['id']); ?>"
                                    style="font-size: 14px; color: #078fe8">
                                    <?php echo htmlspecialchars($sender['user_name']); ?>
                                </a>
                                <span style="color: black; font-size:12px"> has posted
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo htmlspecialchars($contact['content']); ?>">
                                        <?php echo htmlspecialchars($job['title']); ?>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "image report") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
        ?>
            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo addslashes($contact['id']); ?>', '<?php echo addslashes($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewgalleries/<?php echo $contact['notification_receiver']; ?>"><img src="<?php echo SITE_URL; ?>/gallery/<?php echo $contact['content']; ?>" alt=""></a></li>
                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"> has been reported by fellow members. Please edit or delete the photograph</span></li>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "audio report") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
        ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <li class="col-sm-4">
                                <img style="max-width: 40px; max-height: 70; border-radius: 50%;" src="<?php echo SITE_URL; ?>/images/Audio-icon.png" alt="like image">
                            </li>
                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"><a href="<?php echo SITE_URL; ?>/viewaudios/<?php echo $contact['notification_receiver']; ?>">Audio</a> has been reported by fellow members. Please edit or delete the audio</span></li>
                        </ul>


                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "video report") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
        ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>

                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <?php $video = $this->Comman->videodetail($contact['content']); //pr($video);

                            ?>
                            <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewvideos/<?php echo $contact['notification_receiver']; ?>"><img src="<?php echo SITE_URL; ?>/videothumb/<?php echo $video['thumbnail']; ?>" alt="like image"></a></a></li>
                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"> has been reported by fellow members. Please edit or delete the Video</span></li>
                        </ul>


                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "job report") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
            $job = $this->Comman->jobtitle($contact['content']);
        ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>

                    <li class="request_right1 col-sm-12">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $contact['content']; ?>"><?php echo $job['title']; ?></a> has been reported by fellow members. Please edit or delete the job</span></li>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "profile report") { ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>

                    <li class="request_right1 col-sm-12">
                        <ul class="row">
                            <li class="request_left1 col-sm-2">
                                <ul class="row">
                                    <?php if ($profile_pack['user']['profile']['profile_image'] != '') { ?>
                                        <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile_pack['user']['profile']['profile_image']; ?>" alt="profile_image"></a></li>
                                    <?php
                                    } else { ?>
                                        <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile_pack['user']['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                                    <?php
                                    } ?>
                                </ul>
                            </li>

                            <li class="request_right1 col-sm-10">
                                <ul class="row">
                                    <li class="col-sm-12"><span style="color: black; font-size:14px">Your <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8">Profile </a> has been reported by fellow members. Please edit your profile</span></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } elseif ($contact['type'] == "content delete") { ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>

                    <li class="request_right1 col-sm-12">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"><a target="_blank" href="<?php echo $contact['content']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $contact['content']; ?> </a> has been deleted by the content controller</span></li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php
        } elseif ($contact['type'] == "image delete") { ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>
                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewgalleries/<?php echo $contact['notification_receiver']; ?>"><img src="<?php echo SITE_URL; ?>/gallery/<?php echo $contact['content']; ?>" alt=""></a></li>
                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-12"><span style="color: black; font-size:14px"> has been deleted by the content controller</span></li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php
        } elseif ($contact['type'] == "view profile") {
            $sender = $this->Comman->notisenderdetail($contact['notification_sender']);
        ?>
            <li class="row request_one frnd-rq <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
                <ul>

                    <li class="request_left1 col-sm-2">
                        <ul class="row">
                            <?php if ($sender['profile']['profile_image'] != '') { ?>
                                <li class="col-sm-4"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $sender['profile']['profile_image']; ?>" alt="profile_image"></a></li>
                            <?php
                            } else { ?>

                                <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                            <?php
                            } ?>

                        </ul>
                    </li>
                    <li class="request_right1 col-sm-10">
                        <ul class="row">
                            <li class="col-sm-8"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sender['id']; ?>" style="font-size: 14px; color: #078fe8"><?php echo $sender['user_name']; ?> </a><span style="color: black; font-size:12px"> has viewed your profile</span></li>
                        </ul>
                    </li>
                </ul>
            </li>

        <?php
        } else { ?>

            <li class="row request_one frnd-rq <?php echo htmlspecialchars($contact['view_status']); ?>"
                id="id<?php echo htmlspecialchars($contact['id']); ?>"
                onclick="viewfunction('<?php echo htmlspecialchars($contact['id']); ?>', '<?php echo htmlspecialchars($contact['view_status']); ?>')">

                <ul>
                    <li class="request_left1 col-sm-2">
                    </li>
                    <li class="request_right1 col-sm-10">
                        <!-- Notification Content -->
                        <span class="text-muted" style="font-size: 13px;">
                            <strong><?php echo htmlspecialchars($contact['type']); ?></strong>
                            <span style="font-size: 13px; color: black;">
                                <?php echo htmlspecialchars($contact['content']); ?>
                                <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['user']['id']; ?>"
                                    class="text-primary" style="font-size: 14px;">
                                    <?php echo htmlspecialchars($contact['user']['user_name']); ?>
                                </a>
                            </span>
                        </span>
                    </li>
                </ul>
            </li>

    <?php }
    } ?>


<?php } else {
?>
    <li class="row request_one <?php echo $contact['view_status']; ?>" id="id<?php echo $contact['id']; ?>" onclick="viewfunction(<?php echo "'" . $contact['id'] . "','" . $contact['view_status'] . "'"; ?>)">
        <ul>
            <li class="request_left col-sm-5">
            <li style="color:black;" class="request_left col-sm-4">
                No Notification
            </li>
        </ul>
    </li>
<?php } ?>


<script>
    $('.videos').click(function(e) {
        e.preventDefault();
        $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });


    function viewfunction(e, s) {

        var id = e;
        var status = s;
        //alert(id);
        if (status == "N") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>/homes/updatenotification',
                data: {
                    id: id,
                    status: status
                }, // serializes the form's elements.
                success: function(data) {
                    //alert(data);
                    $('#id' + id).css("background-color", "white");
                }
            });
        }
    }
</script>