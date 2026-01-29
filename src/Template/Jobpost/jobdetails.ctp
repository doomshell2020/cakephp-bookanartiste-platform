<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

<!-- stylis alert box design -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- stylis alert box design -->

<!-- stylis alert box design -->

<?php $haveskill = $this->Comman->userprofileskills(); ?>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>

<div id="page-wrapper">

  <?php echo $this->Flash->render(); ?>
  <?php if ($requirement_data) { //pr($requirement_data);exit;
  ?>
    <section id="page_job_profile" class="apply_job">

      <div class="job-profile-head-bar hea_der" id="myHeadbar">
        <div class="container">
          <div class="row apply_slider">
            <div class="col-sm-3">
              <div class="job-pro-img">
                <img src="<?php echo SITE_URL ?>/job/<?php echo $requirement_data['image'] ?>"
                  onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                <?php
                // echo $sub_data_re['package_id'];
                // echo $sub_data_pr['package_id'];
                // $ricon = $this->Comman->recpack($sub_data_re['package_id']);
                // $picon = $this->Comman->profilepack($sub_data_pr['package_id']);
                ?>

                <?php if ($requirementdatacheck['user']['role_id'] == 2) : ?>
                  <div class="img-top-bar">
                    <div class="profile_icons">
                      <img
                        style="height: 2%; width: 23%"
                        src="<?php echo SITE_URL ?>/img/<?= h($sub_data_pr['profilepack']['icon']) ?>"
                        title="<?= h($sub_data_pr['profilepack']['name']) . ' Package Profile' ?>">

                      <img
                        style="height: 2%; width: 23%"
                        src="<?php echo SITE_URL ?>/img/<?= h($sub_data_re['recuriter_pack']['icon']) ?>"
                        title="<?= h($sub_data_re['recuriter_pack']['title']) . ' Package Recruiter' ?>">

                    </div>
                    <span style="color:#fff">
                      <?= ($requirement_data['is_paid_post'] == 'Y') ? 'Paid Posting' : 'Free Posting' ?>
                    </span>
                  </div>
                <?php else : ?>
                  <div class="img-top-bar">
                    <div class="profile_icons">
                      <span style="color:#fff">
                        <?= ($requirement_data['is_paid_post'] == 'Y') ? 'Paid Posting' : 'Free Posting' ?>
                      </span>
                    </div>
                  </div>

                <?php endif; ?>

              </div>
            </div>
            <div class="col-sm-9">
              <div class="annual-fun-cnt">
                <h3><?php echo $requirement_data['title'] ?></h3>
                <?php if ($haveskill) { ?>

                  <div class="row m-top-10">

                    <?php
                    $id = $this->request->session()->read('Auth.User.id');
                    if ($requirement_data['user']['id'] != $id) {  ?>
                      <div class="col-sm-6">
                        <?php

                        if ($jobdquoteexit['amt'] != 0) { ?>
                          <?php echo '<h5 class="white">You have Sent Quote on ';
                          echo date('d F Y', strtotime($jobdquoteexit['created'])) . '</h5>'; ?>
                        <?php } else if ($applyjobdata['nontalent_aacepted_status'] == "Y" && $applyjobdata['talent_accepted_status'] == "Y") {
                          echo '<h5 style="color:#fff">You are Selected  on ';
                          echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>';
                        } else if ($jobdquoteexit['status'] == "R") {
                          echo '<h5 style="color:#fff">You are Rejected  on ';
                          echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>';
                        } else if ($jobdquoteexit['nontalent_satus'] == "Y" && $jobdquoteexit['status'] == "S") { ?>
                          <?php echo '<h5 style="color:#fff">You are Selected  on ';
                          echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>'; ?>

                        <?php } else if ($reviamt != 0) {   ?>

                          <h5 style="color:#fff">You received revised quote Would you like to </h5>

                          <a class='btn btn-primary' href="<?php echo SITE_URL; ?>/jobpost/applyjobsavebyquote/<?php echo $quoteid ?>/<?php echo $requirement_data['id'] ?>">Accept</a>

                          <a class="btn btn-danger" href="<?php echo SITE_URL; ?>/jobpost/quotereject/<?php echo $quoteid ?>/<?php echo $requirement_data['id'] ?>/<?php echo $userind; ?>" onclick="return confirm('Are You Sure You Want To Reject ');">Reject</a>
                        <?php } else if ($number_of_application == 0 && $talentstatus != "Y" && $booknowrequest != "Y") { ?>
                          <a href="#" class="btn btn-info" data-toggle="modal" data-target="#pingjob<?php echo $requirement_data['id'] ?>"> Ping </a>
                        <?php  } else if ($number_of_applicationmonth == 0 && $talentstatus != "Y" && $booknowrequest != "Y") { ?>
                          <a href="#" class="btn btn-info" data-toggle="modal" data-target="#pingjob<?php echo $requirement_data['id'] ?>"> Ping </a>
                        <?php } else if ($reviamt != 0) {
                        } else if ($number_of_applicationmonth == 0 && $number_of_application == 0 && $talentstatus != "Y" && $booknowrequest != "Y") { ?>

                          <a href="#" class="btn btn-info" data-toggle="modal" data-target="#pingjob<?php echo $requirement_data['id'] ?>"> Pings </a>

                        <?php } else if ($talentstatus == "Y" && $booknowrequest == "Y") { ?>



                          <?php if ($selectedbystatus == "SR") { ?> <?php echo '<h5 style="color:#fff">You are Selected  on ';
                                                                    echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>'; ?> <?php } else if ($selectedbystatus == "RR") { ?>
                            You have Rejected by Recruiter

                          <?php                   }  ?>
                        <?php  } else if ($booknowrequest == "Y" && $talentstatus == "N") {
                          $skill = $requirement_data['requirment_vacancy'][0]['skill']['name'];  ?>




                          <span style="color:#fff">You have Received request for <?php echo $skill ?> Would you Like Accept or Reject ?</span><br>
                          <a href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $applyjobid ?>/Y/<?php echo $requirement_data['id'] ?>" class="btn btn-primary">Accept</a>

                          <a href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $applyjobid ?>/R/<?php echo $requirement_data['id'] ?>" class="btn btn-warning" onclick="return confirm('Are you sure you want to Reject job ?');">Reject</a>

                        <?php } else if ($applyjobdata['ping'] == 1) { ?>

                          <?php echo '<h5 style="color:#fff">You have Pinged  on ';
                          echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>'; ?>

                        <?php   } else if ($talentstatus == "Y") {

                          $data = $this->Comman->getSkillname($applyjobdata['skill_id']);
                        ?>


                          <?php echo '<h5 style="color:#fff">You have Applied for ' . $data->name . ' Skill on ';
                          echo date('d F Y', strtotime($applyjobdata['created'])) . '</h5>'; ?>
                        <?php } else if ($talentstatus == "R") {  ?>

                          <a href="javascript:void(0);" class="btn btn-info">Rejected </a>
                        <?php } else if ($jobdquoteexit['amt'] && $jobdquoteexit['revision'] == 0 && $jobdquoteexit['status'] != "S") {
                        } else { ?>

                          <a href="#" class="btn btn-info" data-toggle="modal" data-target="#aply<?php echo $requirement_data['id'] ?>"> Apply </a>

                        <?php } ?>

                      </div>

                    <?php }

                    if ($requirement_data['user']['id'] != $id) { ?>


                      <div class="col-sm-6 text-right">

                        <?php

                        if ($talentstatus == "Y" && $booknowrequest == "Y") {
                        } else {


                          if ($number_quotemonth == 0 || $packfeature['number_of_quote_daily'] == 0) { ?>
                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#myModall<?php echo $requirement_data['id'] ?>">Paid Quote </a>
                          <?php } else if (empty($jobdquoteexit)) {  ?>
                            <a onclick="myFunction1()" href="javascript:void(0);" class="btn btn-primary sendquote" data-toggle="modal" data-target="#myModal<?php echo $requirement_data['id'] ?>" <?php if ($talentstatus == "R" || $talentstatus == "Y") { ?> style="display:none" <?php } ?>>Send Quote </a>
                          <?php } else if ($selectedbystatus == "SR") {
                          } else if ($reviamt != 0) { ?>

                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#aplyrejectjob<?php echo $requirement_data['id'] ?>" <?php if ($talentstatus == "R") { ?> style="display:none" <?php } ?>>Revised Quote</a>

                          <?php } else if ($jobdquoteexit['status'] == "R") {
                          ?>
                            <a href="javascript:void(0);" class="btn btn-primary" <?php if ($talentstatus == "R") { ?> style="display:none" <?php } ?>>Rejected</a>
                          <?php                 } else if ($jobdquoteexit['amt'] && $jobdquoteexit['revision'] == 0 && $jobdquoteexit['status'] != "S") { ?>



                          <?php } else if ($jobdquoteexit['nontalent_satus'] == "Y" && $jobdquoteexit['status'] == "S") { ?>


                          <?php   } else { ?>

                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $requirement_data['id'] ?>" <?php if ($talentstatus == "R") { ?> style="display:none" <?php } ?>>Respond Quote</a>
                        <?php }
                        } ?>

                      </div>

                    <?php } ?>
                  </div>

                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container cntnt_scroll">
        <div class="profile-bg">
          <div class="clearfix">
            <div class="col-sm-3">
              <div class="job-profile-det left-side-bar">

                <p>Venue Address</p>
                <?php if ($requirement_data['venue_address']) { ?>
                  <p><?php echo $requirement_data['venue_address'] ?></p>
                <?php } ?>
                <p><span><?php echo $requirement_data['landmark'];
                          ?></span></p>
                <p><?php echo $requirement_data['landmark']
                    ?></p>
                <p><a href="#" data-toggle="modal" data-target="#location<?php echo $requirement_data['id'] ?>" onclick="initMapjob()">View Location On Map</a></p>
                <p>Requirement posted by</p>
                <p><a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $requirement_data['user']['id']; ?>" target="blank"><?php echo $requirement_data['user']['user_name']; ?></a></p>

                <div class="m-top-20"><a href="#" data-toggle="modal" data-target="#question<?php echo $requirement_data['id']; ?>">View Questionnaire</a></div>
                <div class="act">
                  <style type="text/css">
                    .active i {
                      color: red !important;
                    }
                  </style>
                  <?php $jobid = $requirement_data['id']; ?>

                  <?php $jobliike = $this->Comman->jobliike($jobid); //pr($jobliike); 
                  ?>


                  <?php $reportcheck = $this->Comman->reportcheck($jobid); //pr($jobliike); 
                  ?>

                  <?php  ?>
                  <a href="javascript:void(0)" class="<?php echo (isset($jobliike) && $jobliike > 0) ? 'active' : ''; ?>" id="likeprofile" data-toggle="tooltip" data-val="<?php echo ($jobid) ? $jobid : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>


                  <?php  ?>
                  <div class="contact-detail-social-icon profile_action">
                    <ul class="list-unstyled">


                      <li>

                        <a href="javascript:void(0)" class="bg-blue <?php echo (isset($jobliike) && $jobliike > 0) ? 'active' : ''; ?>" id="likeprofile" data-toggle="tooltip" data-val="<?php echo ($jobid) ? $jobid : '0' ?>" data-userid="<?php echo $requirement_data['user']['id']; ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

                        <div class="like"><a href="https://www.bookanartiste.com/jobpost/likejobs/<?php echo $requirement_data['id']; ?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes"><?php echo $totallikes; ?> </a></div>
                      </li>

                      <script>
                        $('.singlelikeprofile').click(function(e) { //alert();
                          e.preventDefault();
                          $('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
                        });
                        $('#closemodal').click(function() {
                          $('#myModallikesvideo').modal('hide');
                        });
                      </script>


                      <li> <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue profileshare" title="Share"><i class="fa fa-share"></i></a>

                        <div class="share_button profileshare-toggle" style="display: none;">
                          <ul class="list-unstyled list-inline text-center">
                            <li>
                              <?php
                              echo $this->SocialShare->fa(
                                'facebook',
                                null,
                                ['icon_class' => 'fa fa-facebook fa-lg']
                              ); ?>

                            </li>
                            <li><?php echo $this->SocialShare->fa(
                                  'gplus',
                                  null,
                                  ['icon_class' => 'fa fa-google-plus fa-lg']
                                ); ?>
                            </li>
                            <li> <?php echo $this->SocialShare->fa(
                                    'twitter',
                                    null,
                                    ['icon_class' => 'fa fa-twitter fa-lg']
                                  ); ?>

                            </li>

                            <li> <?php echo $this->SocialShare->fa(
                                    'linkedin',
                                    null,
                                    ['icon_class' => 'fa fa-linkedin fa-lg']
                                  ); ?>

                            </li>
                            <li>
                              <?php echo $this->SocialShare->fa(
                                'whatsapp',
                                null,
                                ['icon_class' => 'fa fa-whatsapp fa-lg']
                              ); ?>


                            </li>

                          </ul>
                        </div>

                      </li>

                      <script>
                        $(document).ready(function() {
                          $(".profileshare").click(function() {
                            $(".profileshare-toggle").slideToggle();
                          });
                        });
                      </script>

                      <!-- <li> <a href="<?php echo SITE_URL; ?>/message/sendjobmessage/<?php echo $job_id; ?>" class="sendmessage bg-blue" data-toggle="tooltip" title="Send Job"><i class="fa fa-envelope"></i></a> -->

                      <!-- by rupam sir -->
                      <li> <a href="javascript:void(0)" class="sendmessage bg-blue" data-toggle="tooltip" title="Send Job"><i class="fa fa-envelope"></i></a>


                      </li>

                      <!-- Modal -->
                      <div id="sendmessages" class="modal fade">
                        <div class="modal-dialog">
                          <div class="modal-content send_job">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Send Job</h4>
                            </div>
                            <div class="modal-body"></div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->

                      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
                      <!-- Send Message  -->
                      <script>
                        $('.sendmessage').click(function(e) {
                          e.preventDefault();
                          messagingurl = '<?php echo SITE_URL; ?>/message/sendjobmessage/<?php echo $job_id; ?>';
                          $('#sendmessages').modal('show').find('.modal-body').load(messagingurl);
                        });
                      </script>

                      <!-- end code send message  -->

                      <!--<li><a href="#" class="bg-blue" data-toggle="tooltip" title="Send"><i class="fa fa-paper-plane-o"></i></a></li> -->

                      <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="bg-blue <?php echo (isset($reportcheck) && $reportcheck > 0) ? 'active' : ''; ?>" title="Report" id="reportcheck"><i class="fa fa-flag"></i></a>

                        <div class="report" id="reportlikes"></div>

                      </li>
                      <?php $savejob = $this->Comman->userjobsave($requirement_data['id']); ?>

                      <li> <a href="javascript:void(0)" id="savedjob" class="fa fa-floppy-o bg-blue <?php echo (isset($savejob) && $savejob > 0) ? 'active' : ''; ?>" data-job="<?php echo $requirement_data['id'] ?>" title="Save"></a></li>
                      <style>
                        #savedjob.fa-floppy-o.active:before {
                          color: red !important;
                        }
                      </style>
                      <div class="clearfix"> </div>
                    </ul>
                  </div>

                  <?php /* ?>

            <a href="#" class="fa fa-paper-plane" title="Send Job" ></a>
            <a href="#" class="fa fa-floppy-o" title="Save"></a> 
            <a href="#" class="fa fa-file" title="Report"></a> </div>
            <div class="social m-top-20"> <a href="#" class="fa fa-facebook-f bg-face" data-link="<?php echo SITE_URL ?>/applyjob/<?php echo $requirement_data['id']  ?>"></a>
            <?php /* ?>
            
            <meta property="og:title" content="Bookanartiste">
<meta property="og:image" content="https://www.bookanartiste.com/images/280bfdee8a5b9bd6f277335a8c248832.jpg">
<meta itemprop="image" content="https://www.bookanartiste.com/images/280bfdee8a5b9bd6f277335a8c248832.jpg">
<a href="javascript:void(0);" class="share_button_rgt fa fa-facebook-f bg-face" data-link="https://www.bookanartiste.com/applyjob/41" data-img="https://www.bookanartiste.com/images/280bfdee8a5b9bd6f277335a8c248832.jpg" data-title="Bookanartiste"></a>
            
            <?php */ ?>
                  <?php /* ?>

             <a href="http://twitter.com/intent/tweet?text=<?php echo $requirement_data['talent_requirement_description'] ?>&amp;url=<?php echo SITE_URL ?>/applyjob/<?php echo $requirement_data['id']  ?>" onclick="javascript:window.open(this.href,
             '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="fa fa-twitter bg-twt"></a>
             
             <a href="https://plus.google.com/share?url=<?php echo SITE_URL ?>/applyjob/<?php echo $requirement_data['id']  ?>" onclick="javascript:window.open(this.href, '',
             'menubar=no,toolbar=no,height=600,width=600');return false;" class="fa fa-google-plus bg-pin"></a>

             <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL ?>/applyjob/<?php echo $requirement_data['id']  ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin bg-link"></a>
             

             <a href="javascript:void(0)" class="fa fa-whatsapp bg-pin whatsapp"></a>


             <script type="text/javascript">
              $(document).ready(function() {
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
                $(document).on("click", '.whatsapp', function() {
                  if( isMobile.any() ) {
                    var text = $(this).attr("data-img");
                    var whatsapp_url = "whatsapp://send?text=" + text;
                    window.location.href = whatsapp_url;

                  } else {
                    alert("whatsup sharing allow only in mobile device");
                  }
                });
              });
            </script>
             */ ?>
                </div>

              </div>


              <div class="owl-carousel owl-theme owl-loaded advrtjob">
                <?php
                $user_id = $this->request->session()->read('Auth.User.id');
                $access_adds = $this->Comman->isaccessadds($user_id);
                if ($access_adds['access_adds'] == 'Y') {
                  foreach ($viewrequirads as $key => $value) {
                    $requirvacancyskill = $this->Comman->requimentskill($value['job_id']);

                ?>
                    <div class="owl-item jobadmain">
                      <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id']; ?>" target="_blank">
                        <div>
                          <?php if ($value['advrt_image']) { ?>
                            <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['advrt_image']; ?>">
                          <?php } else { ?>
                            <img src="<?php echo SITE_URL; ?>/job/jobadvrt.jpg">
                          <?php } ?>
                        </div>
                        <div class="advrttext">
                          <?php echo $value['advrtjob__title'] . "<br>";
                          foreach ($requirvacancyskill as $key => $skillvalue) {
                            echo $skillvalue['skill']['name'] . ",";
                          }

                          if ($value['continuejob'] == 'Y') {
                            echo "<br> Continuous Job" . "<br>";
                          } else {
                            echo "<br>" . $value['event_type'] . "<br>";
                          }
                          echo $value['job_location'] . "<br>";

                          ?>

                        </div>
                      </a>
                      <a href="<?php echo SITE_URL; ?>/advrtise-my-requirment" target="_blank" title="Advertise My Requirements" class="admyreqr">+</a>
                    </div>
                <?php }
                } ?>
              </div>
            </div>
            <script type="text/javascript">
              $(document).ready(function() {

                $('.fa-facebook-f ').click(function(e) {
                  var link = $(this).data('link');
                  window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(link), 'sharer', 'toolbar=0,status=0,width=626,height=436');
                  return false;
                });
              });
            </script>
            <div class="col-sm-9">
              <div class="col-sm-12">
                <div class="job-profile-det row">
                  <h4>Talent Requirement for <span>
                      <?php
                      // pr($requirement_data);
                      echo $requirement_data['eventtype']['name'];
                      ?>
                    </span>
                  </h4>
                </div>


                <div class="job-profile-det row">

                  <?php $count = 1;
                  foreach ($requirement_data['requirment_vacancy'] as $key => $value) {
                    // pr($value);
                    // exit;

                  ?>
                    <div class="col-sm-6">
                      <h6><?php if (count($requirement_data['requirment_vacancy']) > 1) {
                            echo $count . ". ";
                          } ?><?php echo $value['skill']['name'] ?></h6>
                      <div class="job-pro-innr clearfix">
                        <div class="col-sm-1 p-right-0"><img src="<?php echo SITE_URL ?>/images/job-profile.png"></div>
                        <div class="col-sm-5">
                          <p>Vacancy</p>
                          <p>Gender</p>
                          <p>Payment Amount</p>
                        </div>
                        <div class="col-sm-6">
                          <p><?php echo $value['number_of_vacancy'] ?></p>
                          <p><?php if ($value['sex'] == "m") {
                                echo "Male";
                              } elseif ($value['sex'] == "f") {
                                echo "Female";
                              } else if ($value['sex'] == "bmf") {
                                echo "Both Male and Female";
                              } else if ($value['sex'] == "a") {
                                echo "Any";
                              } else {
                                echo "Other";
                              } ?></p>

                          <?php if ($value['payment_freq'] == 10 || empty($value['payment_freq']) ||  empty($value['payment_amount'])) {  ?>

                            <p>Open to Negotiation</p>

                          <?php  } else { ?>

                            <p>
                              <?php echo $value['currency']['currencycode'] . "(" . $value['currency']['symbol'] . ") ";  ?><?php echo $value['payment_amount'] ?> for the Event
                            </p>

                          <?php } ?>

                        </div>
                      </div>
                    </div>
                  <?php $count++;
                  } ?>


                </div>

                <?php if ($requirement_data['talent_requirement_description'] != '' || $requirement_data['payment_description'] != '') { ?>
                  <div class="job-profile-det row">
                    <?php if ($requirement_data['talent_requirement_description'] != '') { ?>
                      <div class="col-sm-12">
                        <h4>Detail Description</h4>
                        <h5>Requirement Description :</h5>
                        <div class="job-pro-innr clearfix">
                          <p><?php echo $requirement_data['talent_requirement_description'] ?></p>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($requirement_data['payment_description'] != '') { ?>
                      <div class="col-sm-12">
                        <h5>Payment Description :</h5>
                        <div class="job-pro-innr clearfix">
                          <p><?php echo $requirement_data['payment_description'] ?></p>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } ?>
                <?php if ($requirement_data['number_attendees'] != '' || $requirement_data['venue_type'] != '' || $requirement_data['venue_description'] != '') { ?>
                  <div class="job-profile-det row">
                    <?php if ($requirement_data['number_attendees'] != '') { ?>
                      <div class="col-sm-12">
                        <h4>Venue Detail</h4>
                        <h5>Number of Attendees : </h5>
                        <div>
                          <p><?php echo $requirement_data['number_attendees']; ?></p>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($requirement_data['venue_type'] != '') { ?>
                      <div class="col-sm-12">
                        <h5>Venue Type : </h5>
                        <div>
                          <p><?php echo $requirement_data['venue_type']; ?></p>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($requirement_data['venue_description'] != '') { ?>

                      <div class="col-sm-12">
                        <h5>Venue Description : </h5>
                        <div class="job-pro-innr clearfix">
                          <p><?php echo $requirement_data['venue_description'] ?></p>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                <?php } ?>

                <div class="job-profile-det time-d row">
                  <div class="col-sm-12">
                    <?php if ($requirement_data['continuejob'] != "Y") { ?>
                      <h4>Time And Date</h4>
                      <h5>Job/Event Date And Time : </h5>
                      <p><b>From : </b> <?php echo date('l jS \of F Y h:i A', strtotime($requirement_data['event_from_date'])); ?> <br>
                        <b>To : </b> <?php echo date('l jS \of F Y h:i A', strtotime($requirement_data['event_to_date'])); ?>
                      </p>
                      <h5>Talent Required Date And Time : </h5>
                      <p><b>From : </b> <?php echo date('l jS \of F Y h:i A', strtotime($requirement_data['talent_required_fromdate'])); ?> <br> <b>To : </b> <?php echo date('l jS \of F Y h:i A', strtotime($requirement_data['talent_required_todate'])); ?></p>

                    <?php  } ?>
                    <h5>Last Date And Time of Application : </h5>
                    <p><?php echo date('l jS \of F Y h:i A', strtotime($requirement_data['last_date_app'])); ?></p>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--  Modal For Location -->
    <div id="location<?php echo $requirement_data['id']; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content loc_map">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Location </h4>
          </div>
          <div class="modal-body" style="width:100% ">
            <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBR5I2OIvmA-FiG39ZLjK70Hc8UsK9hCNY
        &q=<?php echo $requirement_data['location'] ?>" allowfullscreen>
            </iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>



    <!--  Modal For Location -->
    <div id="question<?php echo $requirement_data['id']; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content faq_sec">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="text-align:center;">Select the Correct Options - Questionnaire</h4>
          </div>
          <div class="modal-body">
            <?php if ($requirement_data['jobquestion']) { ?>
              <?php echo $this->Form->create($Userjobanswer, array('class' => 'form-horizontal', 'id' => 'sevice_form', 'enctype' => 'multipart/form-data')); ?>

              <?php $count = 1;
              foreach ($requirement_data['jobquestion'] as $valuequestion) {  ?>
                <input type="hidden" value="<?php echo $count ?>" name="countquestion" />
                <input type="hidden" value="<?php echo $valuequestion['id'] ?>" name="questionid<?php echo $count; ?>" />
                <b>Q<?php echo $count . " "; ?><?php echo $valuequestion['question_title']; ?></b>
                <br>
                <?php foreach ($valuequestion['jobanswer'] as $valueoption) { ?>
                  <label style="margin-right: 10px;">
                    <?php if ($valuequestion['option_type'] == 1) { ?> <input type="radio" name="radio<?php echo $count; ?>" value="<?php echo $valueoption['id'] ?>" style="margin-right: 3px;"><?php  } else { ?>
                      <input type="checkbox" name="check<?php echo $count; ?>[]" value="<?php echo $valueoption['id'] ?>" style="margin-right: 3px; vertical-align: -2px;"><?php } ?>
                    <?php echo $valueoption['answervalue'] ?>
                  </label>
                <?php } ?>

                <br>

              <?php $count++;
              } ?>


              <div class="question_submit" style="text-align: center;">
                <?php echo $this->Form->submit(
                  'Submit',
                  array('class' => 'btn btn-default', 'title' => 'Submit', 'style' => 'text-align: center;')
                );

                ?>
              </div>

            <?php echo $this->Form->end();
            } else { ?>

              <h4 align="center">No Questions are available on this job</h4>
            <?php  }
            ?>

          </div>

        </div>

      </div>
    </div>





    <!--Send quote -->
    <div id="myModall<?php echo $requirement_data['id'] ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Paid Quote </h4>
          </div>
          <div class="modal-body">
            <form action="<?php echo SITE_URL ?>/package/SendQoute" method="POST" onsubmit="return submitfalse(this);">
              <div class="form-group">

                <label for="comment">Skill</label>
                <select class="form-control" name="skill" onchange="return myfunction(this)" data-req="<?php echo $requirement_data['id'] ?>" required="true" id="skillid">
                  <option value="0">Select Skill</option>
                  <?php foreach ($requirement_data['requirment_vacancy'] as $value) { ?>
                    <option value="<?php echo $value['skill']['id'] ?>"><?php echo $value['skill']['name'] ?></option>
                  <?php  } ?>
                </select>
              </div>

              <div> Currency </div>
              <div style="margin-bottom: 20px">
                <input type="text" class="form-control" id="currency<?php echo $requirement_data['id'] ?>" name="currency<?php echo $a ?>" readonly>
              </div>

              <div> Offer Amount </div>
              <div style="margin-bottom: 20px">
                <input type="text" class="form-control" id="offeramt<?php echo $requirement_data['id'] ?>" name="offerecamt<?php echo $a ?>" readonly>
              </div>

              <div class="form-group">
                <label for="email">Your Quote</label>
                <div class="input-group">
                  <span class="input-group-addon" id="prefixcode"><?php echo $requirement_data['requirment_vacancy'][0]['currency']['symbol']  ?></span>
                  <input type="number" class="form-control" id="sendquouteamt" patten="^[0-9]*$" name="amt" required readonly="readonly">
                </div>
              </div>

              <input type="hidden" name="amount" value="<?php echo $paid_quotes_amt; ?>">
              <input type="hidden" name="payment_method" value="Paypal">
              <input type="hidden" name="user_id" value="<?php echo $this->request->session()->read('Auth.User.id'); ?>">

              <div class="form-group">
                <div class="col-sm-6">
                  <?php echo $this->Form->input('user_name', array('class' => 'form-control', 'placeholder' => 'Enter Your Name', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'readonly', 'label' => false, 'type' => 'text', 'value' => $this->request->session()->read('Auth.User.user_name'))); ?>
                </div>
                <div class="col-sm-6">
                  <?php echo $this->Form->email('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'required' => true, 'readonly', 'autocomplete' => 'off', 'id' => 'username', 'label' => false, 'value' => $this->request->session()->read('Auth.User.email'))); ?>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-6">
                  <?php echo $this->Form->input('card_name', array('class' => 'form-control', 'placeholder' => 'Name on Card', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                </div>
                <div class="col-sm-6">
                  <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'placeholder' => 'Card Number', 'pattern' => '[0-9 ]*', 'maxlength' => '16', 'min' => '16', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-6">
                  <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                </div>
                <?php
                for ($m = 1; $m <= 12; $m++) {
                  $months[] = $m;
                }

                $current_year = date('Y');
                $next_year = $current_year + 10;
                for ($y = $current_year; $y <= $next_year; $y++) {
                  $years[] = $y;
                } ?>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Month', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Month', 'options' => $months)); ?>
                </div>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Country', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Year', 'options' => $years)); ?>
                </div>
              </div>

              <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
              <?php if ($quoteid) { ?>
                <input type="hidden" name="job_idprimary" value="<?php echo $quoteid ?>" />
              <?php } ?>
              <button type="submit" class="btn btn-default sendquote">Send Quote</button>
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <!--end -->



    <!--Send quote -->
    <?php //pr($requirement_data); die; 
    ?>
    <!-- change the id myModal1 = myModal -->
    <div id="myModal<?php echo $requirement_data['id'] ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Send Quote </h4>
          </div>
          <div class="modal-body">
            <form action="<?php echo SITE_URL ?>/jobpost/SendQoute" method="POST" onsubmit="return submitfalse(this);">
              <div class="form-group">

                <label for="comment">Skill</label>
                <select class="form-control" name="skill" onchange="return myfunction(this)" data-req="<?php echo $requirement_data['id'] ?>" required="true" id="skillid">
                  <option value="">Select Skill</option>
                  <?php foreach ($requirement_data['requirment_vacancy'] as $value) { ?>
                    <option value="<?php echo $value['skill']['id'] ?>"><?php echo $value['skill']['name'] ?></option>
                  <?php  } ?>

                </select>
              </div>

              <div> Currency </div>
              <div style="margin-bottom: 20px">
                <!-- <input type="text" class="form-control" id="currency<?php echo $requirement_data['id'] ?>" name="currency<?php echo $a ?>" readonly> -->
                <input type="text" class="form-control" id="currency<?php echo $id ?>" name="currency<?php echo $a ?>" readonly value="<?php echo $requirement_data['requirment_vacancy'][0]['currency']['name']  ?>">
              </div>

              <div> Offer Amount </div>
              <div style="margin-bottom: 20px">
                <!-- <input type="text" class="form-control" id="offeramt<?php echo $requirement_data['id'] ?>" name="offerecamt<?php echo $a ?>" readonly> -->
                <input type="text" class="form-control" id="offeramt<?php echo $id ?>" name="offerecamt<?php echo $a ?>" readonly value="<?php echo $requirement_data['requirment_vacancy'][0]['payment_amount']  ?>">

              </div>

              <div class="form-group">
                <label for="email">Your Quote</label>

                <div class="input-group">
                  <span class="input-group-addon" id="prefixcode"><?php echo $requirement_data['requirment_vacancy'][0]['currency']['symbol']  ?></span>
                  <input type="number" class="form-control" id="sendquouteamt" patten="^[0-9]*$" name="amt" required>

                </div>

              </div>
              <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
              <?php if ($quoteid) { ?>
                <input type="hidden" name="job_idprimary" value="<?php echo $quoteid ?>" />
              <?php } ?>
              <div style="border-top: none; text-align: center;">
                <button type="submit" class="btn btn-default">Send Quote</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">

          </div>
        </div>

      </div>
    </div>

    <!--end -->


    <!--Apply Job -->
    <div id="aply<?php echo $requirement_data['id'] ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Apply Job </h4>
          </div>
          <div class="modal-body">
            <!-- <form action="<?php echo SITE_URL ?>/jobpost/applyjobsave" method="POST"> previous code -->
            <form action="<?php echo SITE_URL ?>/jobpost/aplysingleclone" method="POST">

              <div class="form-group">

                <label for="comment">Skill</label>
                <select class="form-control" name="skill" required>
                  <option value="">Select Talent Type</option>
                  <?php foreach ($requirement_data['requirment_vacancy'] as $value) { ?>
                    <option value="<?php echo $value['skill']['id'] ?>"><?php echo $value['skill']['name'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">

                <label for="comment">Cover Latter:</label>
                <textarea class="form-control" rows="5" id="comment" name="cover"></textarea>
              </div>
              <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
              <div style="text-align: center;">
                <button type="submit" class="btn btn-default">Submit</button>
              </div>
            </form>
          </div>


          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

      </div>
    </div>

    <!--end -->


    <!--Apply Job Rquest -->
    <div id="aplyreqyest<?php echo $requirement_data['id'] ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Apply Job </h4>
          </div>
          <div class="modal-body">
            <form action="<?php echo SITE_URL ?>/jobpost/applyjobsave" method="POST">
              <div class="form-group">
                <label for="comment">Cover Letter:</label>
                <textarea class="form-control" rows="5" id="comment" name="cover"></textarea>
              </div>
              <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
              <input type="hidden" name="job_idprimary" value="<?php echo $applyjobid ?>" />

              <button type="submit" class="btn btn-default">Accept</button>
              <a href="<?php echo SITE_URL; ?>/jobpost/jobreject/<?php echo $applyjobid ?>/<?php echo $requirement_data['id'] ?>/R" class="btn btn-default pull-right" onclick="return confirm('Are you sure you want to Reject job ?');">Reject</a>
            </form>
          </div>


          <div class="modal-footer">

          </div>
        </div>

      </div>
    </div>

    <!--end -->

    <!--Apply Job Rquest -->
    <div id="aplyrejectjob<?php echo $requirement_data['id'] ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Revised Quote</h4>
          </div>
          <div class="modal-body">
            <form action="<?php echo SITE_URL ?>/jobpost/applyjobsavebyquote" method="POST">
              <div class="form-group">
                <label for="comment">Job Title:-</label>
                <span class="pull-right" style="margin-right: 230px"> <?php echo $requirement_data['title'] ?></span>
              </div>



              <div class="form-group">
                <label for="comment">Payment Offered in Currency :</label>
                <span class="pull-right" style="margin-right: 230px"> <?php echo $value['currency']['name'] . " ";  ?></span>
              </div>

              <div class="form-group">
                <label for="comment">Payment Offered in Amount :</label>
                <span class="pull-right" style="margin-right: 230px"> <?php echo $value['payment_amount'] ?></span>
              </div>

              <div class="form-group">
                <label for="comment">Quote Received Amount:</label>
                <span class="pull-right" style="margin-right: 230px"> <?php echo $reviamt; ?></span>
              </div>
              <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
              <input type="hidden" name="user_id" value="<?php echo $userind; ?>" />
              <input type="hidden" name="quoteid" value="<?php echo $quoteid ?>" />



              <a href="<?php echo SITE_URL ?>/jobpost/applyjobsavebyquote/<?php echo $quoteid ?>/<?php echo $requirement_data['id'] ?>" class="btn btn-default">Accept</a>
              <a href="<?php echo SITE_URL; ?>/jobpost/quotereject/<?php echo $quoteid ?>/<?php echo $requirement_data['id'] ?>/<?php echo $userind; ?>" class="btn btn-default pull-right" onclick="return confirm('Are you sure you want to Reject Quote ?');">Reject</a>
            </form>
          </div>


          <div class="modal-footer">

          </div>
        </div>

      </div>
    </div>

    <!--end -->



    <!--Ping Job Rquest -->
    <div id="pingjob<?php echo $requirement_data['id'] ?>" class="pingJobModal modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Ping Job </h4>
          </div>
          <div class="pophead">
            <h3 class="text-center">Complete your Purchase</h3>
            <h4 class="text-center">Payment Information</h4>
            <h5 class="text-center">Package Details</h5>
          </div>
          <div class="modal-body">
            <section id="page_signup">
              <div class="row">
                <div class="col-sm-12">
                  <div class="signup-popup">

                    <div class="row signup-popupTbl">
                      <div class="col-sm-12">
                        <strong>Package Name:</strong> <span>Ping Job</span>
                      </div>

                      <div class="col-sm-12">
                        <strong> Amount:</strong> <span> $<?php echo $ping_amt; ?></span>
                      </div>

                    </div>

                    <?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'Pingpay'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'PackageIndexForm', 'autocomplete' => 'off')); ?>

                    <input type="hidden" name="amount" value="<?php echo $ping_amt; ?>">
                    <input type="hidden" name="payment_method" value="Paypal">
                    <input type="hidden" name="user_id" value="<?php $this->request->session()->read('Auth.User.id'); ?>">


                    <form class="form-horizontal">
                      <div class="form-group">

                        <div class="col-sm-6">
                          <?php echo $this->Form->input('user_name', array('class' => 'form-control', 'placeholder' => 'Enter Your Name', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'readonly', 'label' => false, 'type' => 'text', 'value' => $this->request->session()->read('Auth.User.user_name'))); ?>
                        </div>
                        <div class="col-sm-6">
                          <?php echo $this->Form->email('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'required' => true, 'readonly', 'autocomplete' => 'off', 'id' => 'username', 'label' => false, 'value' => $this->request->session()->read('Auth.User.email'))); ?>
                        </div>
                      </div>

                      <div class="form-group">

                        <div class="col-sm-6">
                          <?php echo $this->Form->input('card_name', array('class' => 'form-control', 'placeholder' => 'Name on Card', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                        </div>
                        <div class="col-sm-6">
                          <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'placeholder' => 'Card Number', 'pattern' => '[0-9 ]*', 'maxlength' => '16', 'min' => '16', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-6">
                          <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                        </div>
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                          $months[] = $m;
                        }

                        $current_year = date('Y');
                        $next_year = $current_year + 10;
                        for ($y = $current_year; $y <= $next_year; $y++) {
                          $years[] = $y;
                        }


                        ?>
                        <div class="col-sm-3">
                          <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Month', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Month', 'options' => $months)); ?>
                        </div>
                        <div class="col-sm-3">
                          <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Country', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Year', 'options' => $years)); ?>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-12 text-center"> </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="comment">Skill</label>
                          <select class="form-control" name="skill">
                            <?php foreach ($requirement_data['requirment_vacancy'] as $value) ?>
                            <option value="<?php echo $value['skill']['id'] ?>"><?php echo $value['skill']['name'] ?></option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="comment">Cover Letter:</label>
                          <textarea class="form-control" rows="5" id="comment" name="cover"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
                      <div class="form-group">
                        <div class="col-sm-12 text-center">
                          <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
                        </div>
                      </div>

                      <?php echo $this->Form->end(); ?>

                  </div>

                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>

    <!--end -->

  <?php  } else { ?>
    <div style="height:500px">

      <h3 style="color:#000;text-align:center;margin-top:170px;">No Records Found</h3>

    </div>
  <?php
  } ?>

  <!-------------------------------------------------->

</div>

<?php if (!empty($alertjobaccess)) { ?>
  <script>
    const messages = `<?= $alertjobaccess ?>`;
    // when load document then call error messages 
    $(document).ready(function() {
      // console.log("ready!");
      showerror(messages);
    });
  </script>
<?php } ?>

<script type="text/javascript">
  var site_url = '<?php echo SITE_URL; ?>/';

  window.onscroll = function() {
    myFunction()
  };

  var header = document.getElementById("myHeadbar");
  var sticky = header.offsetTop;

  function myFunction() {
    if (window.pageYOffset >= sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }

  /* Saved job */
  $('#savedjob').click(function() {
    error_text = "You cannot saved yourself";
    var job = $(this).data('job');

    $.ajax({
      type: "POST",
      url: '<?php echo SITE_URL; ?>/search/savejobs',
      data: {
        jobid: job
      },
      cache: false,
      success: function(data) {
        obj = JSON.parse(data);

        if (obj.success == '1') {
          $("#savedjob").addClass('active');
        } else {
          $("#savedjob").removeClass('active');
        }
        //$("#totallikes").html(obj.count);

      }
    });


  });

  /*  Like Profile profile*/
  $('#likeprofile').click(function() {
    error_text = "You cannot Like yourself";
    job_id = $(this).data('val');
    userid = $(this).data('userid');
    //alert(userid);
    if (job_id > 0) {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/search/likejobs',
        data: {
          jobid: job_id,
          userid: userid
        },
        cache: false,
        success: function(data) {
          obj = JSON.parse(data);

          if (obj.success == '1') {
            $("#likeprofile").addClass('active');
          } else {
            $("#likeprofile").removeClass('active');
          }
          $("#totallikes").html(obj.count);
        }

      });
    } else {
      showerror(error_text);
    }
  });


  function myfunction(x) {
    var reqid = x.getAttribute('data-req');

    var skillid = x.value;
    $(this).data("req");

    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: site_url + 'search/myfunctiondata',
      data: {
        skill: skillid,
        reqid: reqid
      },
      beforeSend: function() {
        $('#clodder').css("display", "block");
      },
      success: function(response) {
        var obj = JSON.parse(response);
        if (obj.payment_currency != 0) {
          $('#offeramt' + reqid).val(obj.payment_currency);
        } else {
          $('#offeramt' + reqid).val("Contact for Payment Details");
        }
        $('#currency' + reqid).val(obj.currency);
        $('#prefixcode').val(obj.currency);
        $('#sendquouteamt').removeAttr('readonly');
      },
      complete: function() {
        $('#clodder').css("display", "none");
      },
      error: function(data) {
        alert(JSON.stringify(data));

      }
    });
  }

  function submitfalse(x) {
    if (x.skillid.value == 0) {
      alert("Choose the skill type for which you want to Send Quote");
      return false;
    }
  }
</script>

<!-- Modal -->
<div class="modal fade " id="reportuser" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content report_job">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Report for this Job</h4>
      </div>
      <div class="modal-body">
        <span id="message" style="display: none; color: green"> Report Spam Sent Successfully...</span>
        <span id="wrongmessage" style="display: none; color: red"> Report Spam Not Sent...</span>
        <?php echo $this->Form->create('', array('url' => ['controller' => 'profile', 'action' => 'reportspam'], 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'submit-form', 'autocomplete' => 'off')); ?>


        <?php $reportoption = array('Pornography' => 'Pornography', 'Offensive Behaviour' => 'Offensive Behaviour', 'Fake Profile' => 'Fake Profile', 'Terms and Conditions Violation' => 'Terms and Conditions Violation', 'Spam' => 'Spam', 'Wrong Information displayed' => 'Wrong Information displayed', 'Public Display of Contact Information' => 'Public Display of Contact Information'); ?>
        <?php echo $this->Form->input('reportoption', array('class' => 'form-control', 'placeholder' => 'Country', 'maxlength' => '25', 'required', 'label' => false, 'type' => 'radio', 'options' => $reportoption)); ?>
        <?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'type' => 'textarea', 'required', 'label' => false)); ?>
        <?php echo
        $this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => 'job')); ?>
        <?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $requirement_data['id'])); ?>
        <?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $requirement_data['user_id'])); ?>


        <div class="text-center m-top-20"><button class="btn btn-default" id="bn_subscribe">Submit</button></div>
        <?php echo $this->Form->end(); ?>

      </div>

    </div>
  </div>
</div>

<script>
  $('#bn_subscribe').click(function() {
    $.ajax({
      type: "POST",
      url: site_url + '/profile/reportspam',
      data: $('#submit-form').serialize(),
      cache: false,
      success: function(data) {
        obj = JSON.parse(data);
        if (obj.status != 1) {
          $('#reportuser').modal('toggle');
          showerror(obj.error);
        } else {

          $("#reportcheck").addClass('active');
          $("#reportlikes").html(obj.count);
          $('#reportuser').modal('toggle');
          success = "You have been reported for this Job Successfully.";
          showerror(success);
        }
      }
    });
  });

  function showerror(error) {
    BootstrapDialog.alert({
      size: BootstrapDialog.SIZE_SMALL,
      title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
      message: "<h5>" + error + "</h5>"
    });
    return false;
  }
</script>


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

<script>
  $('#totallikes').click(function(e) { //alert();
    $('.singlelikeprofile').click(function(e) { //alert();
      e.preventDefault();
      $('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
    });
    $('#closemodal').click(function() {
      $('#myModallikesvideo').modal('hide');
    });
  });

  function myFunction1() {
    var number_quotemonth = '<?php echo $number_quotemonth; ?>';
    var packfeature = '<?php echo $packfeature['number_of_quote_daily']; ?>';

    let text = "This is the last request for this job. After this you can buy more request credits. Would you like to continue ?";

    if (number_quotemonth > 1 || packfeature > 1) {
      $('#myModal1<?php echo $requirement_data['id'] ?>').modal('show');
    } else {
      if (confirm(text) == true) {
        $('#myModal1<?php echo $requirement_data['id'] ?>').modal('show');
      } else {
        //  $('#myModal<?php echo $requirement_data['id'] ?>').modal('hide');
        $('#myModal1<?php echo $requirement_data['id'] ?>').modal('hide');
      }
    }
  }
</script>