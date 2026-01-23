<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
<style>
    #page_alert .member-detail .btn-primary {
    margin-top: 0;
    }
    .member-detail .btn-default {
    margin-top: 0;
    }
</style>
<section id="page_alert">
    <div class="container">
        <h2>Alerts</h2>
        <p class="m-bott-50">Here You Can See Job alerts</p>
    </div>
    <div class="refine-search">
        <div class="container">
        <?php 
        // pr('skjhksjhk');exit;
        echo $this->Flash->render(); 
        ?>
            <div class="row m-top-20 profile-bg">
                <div class="col-sm-3">
                    <div class="panel panel-left">
                        <ul class=" alrt-categry list-unstyled navff"> 
                        <?php
                        $allalerts = count($quotereceive) + count($bookingreceived) + count($quoteapplicationalerts) + count($viewjobalerts); ?> 
                        <li class="active">
                          <a href="javascript:void(0);" class="jobalerts" data-action="alerts">All<span class="noti_f">
                            <?php echo $allalerts; ?></span>
                          </a>
                       </li> 

                        <?php //Non Talent Status 
                        ?> <?php /* ?> <li><a href="javascript:void(0);" class="jobalerts" data-action="applicationreceived">Application Received</a><span class="noti_f"><?php echo count($jobapplicationalerts); ?></span></li>
                            <li><a href="javascript:void(0);" class="jobalerts" data-action="quotereceived"> Quote Received</a><span class="noti_f"><?php echo count($quoteapplicationreceivedalerts); ?></span></li> <?php */ ?>
                            <!--<li><a href="javascript:void(0);" class="jobalerts" data-action="pingreceived">Ping Received</a><span class="noti_f"><?php //echo count($pingalerts); 
                        ?></span></li>-->
                            <!-- <li><a href="javascript:void(0);" class="jobalerts" data-action="pingsent">Ping sent</a><span class="noti_f"><?php //echo count($pingsent); 
                        ?></span></li> --> <?php //Talent Status 
                        ?> 
                        <li><a href="javascript:void(0);" class="jobalerts" data-action="jobalertss">Job Alerts<span class="noti_f"><?php echo count($viewjobalerts); ?></span></a></li>
                            <li><a href="javascript:void(0);" class="jobalerts" data-action="bookingreceived">Booking Received<span class="noti_f"><?php echo count($bookingreceived); ?></span></a></li>
                            <li><a href="javascript:void(0);" class="jobalerts" data-action="quoterequest">Quote Request Received<span class="noti_f"><?php echo count($quoteapplicationalerts); ?></span></a></li>
                            <li><a href="javascript:void(0);" class="jobalerts" data-action="quotesent">Revised Quote Received<span class="noti_f"><?php echo count($quotereceive); ?></span></a></li>
                        </ul>
                    </div> 
                    <img src="<?php echo SITE_URL; ?>/images/CB_Card.png">
                </div>

                <div class="col-sm-9"> 
                  <?php if (count($quotereceive) > 0 || count($bookingreceived) > 0 || count($quoteapplicationalerts) > 0 || count($viewjobalerts) > 0) { ?> <?php  } else { ?>
                     <?php echo "No Alerts for you at the moment"; ?> 
                     <?php } ?> <div class="panel-right">

                        <form> 
                          <?php //------------Start Non Talented-----------// ?> 
                        <?php /////////////////////////////job alerts////////////////////////// ?> 
                        <?php 
                        foreach ($viewjobalerts as $jobalertsss) {
                        if (empty($jobalertsss['user_id']) && empty($jobalertsss['id'])) {
                          continue;
                        }
                        // pr($jobalertsss);exit; 
                        ?> 
                        <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail row alerts jobalertss <?php if ($applicationrec['viewedstatus'] == 'Y') { ?>jobviewed<?php } else { ?>jobnotviewed <?php } ?>">
                                <div class="box job-card"> <?php if ($jobalertsss['image'] != '') { ?> <div class="col-sm-3">
                                        <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/job/<?php echo $jobalertsss['image']; ?>">
                                            <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                        </div>
                                    </div> <?php } else { ?> <div class="col-sm-3">
                                        <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/images/job.jpg" />
                                            <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                        </div>
                                    </div> <?php } ?> <div class="col-sm-9 ">
                                        <div class="row">
                                            <a target="_blank" href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobalertsss['id'] ?>"><h3 class="heading"><?php echo $jobalertsss['title']; ?>
                                            &nbsp;
                                            <span><?php echo date('Y-m-d h:m A', strtotime($jobalertsss['created'])) ?> </span>
                                          </h3></a>
                                            <ul class=" list-unstyled">
                                                <li><a href="javascript:void(0)" class="fa fa-globe"></a> <?php echo $jobalertsss['location']; ?></li>
                                                <li> <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $jobalertsss['user_id']; ?>" class="fa fa-user"> </a> Posted by <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $jobalertsss['user_id']; ?>"> <?php echo $jobalertsss['postedby']; ?> </a> </li>
                                                <li><a href="#" class="fa fa-american-sign-language-interpreting"></a> <?php echo $jobalertsss['skillname']; ?></li>
                                                <li><a href="#" class="fa fa-suitcase"></a><?php echo $jobalertsss['event_type']; ?> </li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8"> <?php
                                       $appliedjob = $this->Comman->appliedjob($jobalertsss['id']);
                                       $sentquote = $this->Comman->sentquote($jobalertsss['id']);
                                       $skill = $this->Comman->requimentskill($jobalertsss['id']);
                                       $count = 0;
                                       foreach ($skill as $vacancy) {
                                          if ($vacancy['skill']['name']) {
                                           $count++;
                                         }
                                       }
                                       // pr($count);exit;
                                       
                                       $data = $this->Comman->getSkillname($appliedjob->skill_id);

                                       if ($appliedjob['nontalent_aacepted_status'] == "N" && $appliedjob['talent_accepted_status'] == "Y") {                                       
                                         if ($appliedjob->ping == 1) {
                                           echo '<h5>You have Pinged  on ';
                                           echo date('d F Y', strtotime($appliedjob['created'])) . '</h5>';
                                         } else {
                                           echo '<h5>You have Applied for ' . $data->name . ' Skill on ';
                                           echo date('d F Y', strtotime($appliedjob['created'])) . '</h5>';
                                         }
                                       } else if ($appliedjob['nontalent_aacepted_status'] == "Y" && $appliedjob['talent_accepted_status'] == "N") {
                                         $data = $this->Comman->getSkillname($appliedjob->skill_id);
                                       
                                       ?> <span style="display:block ">You have Received request for <?php echo $data->name ?> Would you Like Accept or Reject ?</span> <a href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $appliedjob->id ?>/Y/<?php echo $appliedjob['job_id'] ?>" class="btn btn-primary">Accept</a> <a href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $appliedjob->id ?>/R/<?php echo $appliedjob['job_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to Reject job ?');">Reject</a> <?php  } elseif ($appliedjob['nontalent_aacepted_status'] == "Y" && $appliedjob['talent_accepted_status'] == "Y") {
                                       echo '<h5>You are Selected  on ';
                                       echo date('d F Y', strtotime($appliedjob['created'])) . '</h5>';
                                       } else {  ?> <?php if ($month == 0 || $daily == 0) { ?> <?php if ($sentquote['revision'] == 0 && $sentquote['status'] == "N" && $sentquote['nontalent_satus'] == "Y" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") { ?> <?php } else if ($sentquote['status'] == "S" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {

                                       } else if ($sentquote['revision'] != 0 && $sentquote['status'] == "N" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else { ?> 

                                       <a data-toggle="modal" class='data btn btn-default pingmy' href="<?php echo SITE_URL; ?>/search/singleApply/<?php echo $jobalertsss['id'] ?>">Apply</a>
                                       
                                       <!-- <a data-toggle="modal" class='data btn btn-default' href="<?php echo SITE_URL; ?>/search/singleApply/<?php echo $value['id'] ?>">Pings Job</a> -->

                                       <?php   } ?> <?php } else { ?> <?php if ($sentquote['revision'] == 0 && $sentquote['status'] == "N" && $sentquote['nontalent_satus'] == "Y" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['status'] == "S" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['revision'] != 0 && $sentquote['status'] == "N" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['status'] == "R" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($appliedjob['nontalent_aacepted_status'] == "R" and $appliedjob['talent_accepted_status'] == "Y") { ?>
                                        <h5 id="aplymsz<?php echo $jobalertsss['id'] ?>" style="display: block">You have Rejected by Requiter on <?php echo date('d F Y'); ?></h5> 
                                        <?php  } else if ($count == 1) { ?> 

                                        <a class='btn btn-default' href="<?php echo SITE_URL; ?>/jobpost/applyjobbyid/<?php echo $jobalertsss['id'] ?>/<?php echo $vacancy['skill']['id'] ?>">Apply</a> 

                                        <?php } else { ?> <?php if ($sentquote['revision'] == 0 && $sentquote['status'] == "N" && $sentquote['nontalent_satus'] == "Y" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['status'] == "S" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['revision'] != 0 && $sentquote['status'] == "N" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else if ($sentquote['status'] == "R" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       } else { ?> <a data-toggle="modal" class='data btn btn-default' href="<?php echo SITE_URL; ?>/search/singleApply/<?php echo $jobalertsss['id'] ?>">Apply</a> <?php }
                                       } ?> <?php } ?> <h5 id="aplymsz<?php echo $jobalertsss['id'] ?>" style="display: none">You have Applied on <?php echo date('d F Y'); ?></h5> <?php }  ?> <?php if ($sentquote['revision'] == 0 && $sentquote['amt'] == 0 && $sentquote['status'] == "N" && $sentquote['nontalent_satus'] == "Y" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       $data = $this->Comman->getSkillname($sentquote->skill_id);
                                       // pr($data);
                                       ?> 
                                       <h5 id="sendquotemsz<?php echo $jobalertsss['id'] ?>" style="display: block">You have Received Request For Quote For <?php echo $data->name ?> On <?php echo date('d F Y', strtotime($sentquote['created'])); ?>
                                       </h5> <?php } else if ($sentquote['revision'] == 0 && $sentquote['amt'] != 0 && $sentquote['status'] == "N" && $sentquote['nontalent_satus'] == "Y" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") {
                                       $data = $this->Comman->getSkillname($sentquote->skill_id);
                                       ?> <h5 id="sendquotemsz<?php echo $jobalertsss['id'] ?>" style="display: block">You have Sent Quotes for <?php echo $data->name ?> on <?php echo date('d F Y', strtotime($sentquote['created'])); ?></h5> <?php } else if ($sentquote['revision'] != 0 && $sentquote['status'] == "N" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") { ?> <h5 id="sendquotemsz<?php echo $jobalertsss['id'] ?>" style="display: block">You received revised quote on <?php echo date('d F Y', strtotime($sentquote['created'])); ?> Would you like to </h5> <a class='btn btn-primary' href="<?php echo SITE_URL; ?>/jobpost/applyjobsavebyquote/<?php echo $sentquote['id']; ?>/<?php echo $jobalertsss['id'] ?>">Accept</a> <a class="btn btn-danger" href="<?php echo SITE_URL ?>/jobpost/quotereject/<?php echo $sentquote['id'] ?>/<?php echo $sentquote['job_id'] ?>/<?php echo $sentquote['user_id'] ?>" onclick="return confirm('Are You Sure You Want To Reject ');">Reject</a> <?php  } else if ($sentquote['status'] == "R" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") { ?> <h5 id="sendquotemsz<?php echo $jobalertsss['id'] ?>" style="display: block"> You have Rejected job on <?php echo date('d F Y', strtotime($sentquote['created'])); ?> </h5> <?php  } else if ($sentquote['status'] == "S" && $appliedjob['nontalent_aacepted_status'] != "N" && $appliedjob['talent_accepted_status'] != "Y") { ?> <h5 id="sendquotemsz<?php echo $jobalertsss['id'] ?>" style="display: block">You Have Selected by Requiter on <?php echo date('d F Y', strtotime($sentquote['created'])); ?></h5> <?php } else {
                                       if ($quote == 0) {
                                       
                                         if ($appliedjob['nontalent_aacepted_status'] == "N" && $appliedjob['talent_accepted_status'] == "Y") {
                                         } else if ($appliedjob['nontalent_aacepted_status'] == "Y" && $appliedjob['talent_accepted_status'] == "N") {
                                         } else {
                                       ?>
                                                <!-- <a class=' btn btn-primary' href="#" >Send Quote (Paid)</a> --> <?php  }
                                       } else {
                                         if ($appliedjob['nontalent_aacepted_status'] == "N" && $appliedjob['talent_accepted_status'] == "Y") {
                                         } else if ($appliedjob['nontalent_aacepted_status'] == "Y" && $appliedjob['talent_accepted_status'] == "Y") {
                                         } else if ($appliedjob['nontalent_aacepted_status'] == "Y" && $appliedjob['talent_accepted_status'] == "N") {
                                         } else {
                                         ?> <a data-toggle="modal" class='sendquote btn btn-primary' href="<?php echo SITE_URL; ?>/search/sendquotebysingle/<?php echo $jobalertsss['id'] ?>">Send Quote</a> <?php }
                                       }
                                       } ?>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <div class="icon-bar srh-icon-bar"> <a href="javascript:void(0)" class="fa fa-thumbs-up likejobs" data-job="<?php echo $jobalertsss['id'] ?>" id="like<?php echo $jobalertsss['id'] ?>" <?php if (in_array($jobalertsss['id'], $likejobarray)) { ?> style="color:red" <?php  } ?> alt="Likes Jobs"></a>
                                                    <meta property="og:title" content="Book an Artiste">
                                                    <meta property="og:image" content="<?php echo SITE_URL . '/job/' . $jobalertsss['image'];  ?>">
                                                    <meta property="og:url" content="<?php echo SITE_URL ?>/applyjob/<?php echo $jobalertsss['id'] ?>" />
                                                    <meta property="og:description" content="<?php echo $jobalertsss['talent_requirement_description'] ?>" />
                                                    <meta itemprop="image" content="<?php echo SITE_URL . "/job/" . $jobalertsss['image'];  ?>"> <a href="javascript:void(0)" class="fa fa-share fb" data-link="<?php echo SITE_URL;?>/applyjob/<?php echo $jobalertsss['id'] ?>" data-img="<?php echo SITE_URL . "/job/" . $jobalertsss['image'];  ?>" data-title="BookAnArtiste"></a> <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a> <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $jobalertsss['id'] ?>" id="savedjobs<?php echo $jobalertsss['id'] ?>" <?php if (in_array($jobalertsss['id'], $savejobarray)) { ?> style="color:red" <?php  } ?> alt="Save Jobs"></a> <a href="javascript:void(0)" class="fa fa-ban block" data-job="<?php echo $jobalertsss['id'] ?>" id="block<?php echo $jobalertsss['id'] ?>" <?php if (in_array($jobalertsss['id'], $blockjobarray)) { ?> style="color:red" <?php  } ?> alt="Block Jobs"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_hvr_checkndlt">
                                    <!--  <span class="pull-left"><input type="checkbox" value=""></span>--> <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-val="<?php echo $jobalertsss['id'] ?>" data-widget="remove" data-action="jobalerts"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                            </div> <?php } ?> <?php //------------------ Revised Quote Received-------------// 
                        ?> 
                        <?php foreach ($quotereceive as $sendquote) { //pr($sendquote); die; ?> 

                          <div id="<?php echo $sendquote['id']; ?>" class="box member-detail row alerts quotesent <?php if ($sendquote['viewedstatus'] == 'Y') { ?>jobviewed<?php } else { ?>jobnotviewed <?php } ?>"> 

                          <?php if ($sendquote['requirement']['image'] != '') { ?> 
                            
                            <div class="col-sm-3">
                                    <div class="member-detail-img"> 
                                      <a class="alertsimg" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['requirement']['id']; ?>"> 
                                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $sendquote['requirement']['image']; ?>"> 
                                    </a>
                                        <div class="img-top-bar"> 
                                          <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['requirement']['id']; ?>" class="fa fa-user"></a> 
                                    </div>
                                    </div>
                                </div> <?php } else { ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } ?> 

                                <div class="col-sm-9 job-card">
                                  <a target="_blank" style="font-size: 20px;padding-bottom: 5px;font-weight: 600;color: #4f84c4;" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['requirement']['id']; ?>">
                                      <h3>
                                    <?php echo $sendquote['requirement']['title']; ?>
                                    <span class="text-muted" style="font-size: 14px;">
                                      <?php echo date('Y-m-d H:i:s', strtotime($sendquote['created'])); ?>
                                    </span>
                                  </h3>
                                </a>

                                      <div class="row">
                                        <ul class="list-unstyled col-sm-4 member-info">
                                          <li>Posted By</li>
                                          <li>Quote Sent For</li>
                                          <li>Payment Offered</li>
                                          <li>Quote Sent</li>
                                          <li>Revised Quote Received</li>
                                          <li>Requirement</li>
                                          <li>Location</li>
                                        </ul>

                                        <ul class="col-sm-1 list-unstyled">
                                          <li>:</li>
                                          <li>:</li>
                                          <li>:</li>
                                          <li>:</li>
                                          <li>:</li>
                                          <li>:</li>
                                          <li>:</li>
                                        </ul>

                                        <ul class="col-sm-7 list-unstyled">
                                          <li><?php echo $sendquote['requirement']['user']['user_name']; ?></li>
                                          <li><?php echo $sendquote['skill']['name']; ?></li>
                                          <li>
                                            <?php
                                              echo $sendquote['requirement']['requirment_vacancy'][0]['currency']['symbol'] . ' ' .
                                                  $sendquote['requirement']['requirment_vacancy'][0]['payment_amount'];
                                            ?>
                                          </li>
                                          <li>
                                            <?php
                                              echo $sendquote['requirement']['requirment_vacancy'][0]['currency']['symbol'] . ' ' .
                                                  $sendquote['amt'];
                                            ?>
                                          </li>
                                          <li>
                                            <?php
                                              echo $sendquote['requirement']['requirment_vacancy'][0]['currency']['symbol'] . ' ' .
                                                  $sendquote['revision'];
                                            ?>
                                          </li>
                                          <li>
                                            <?php
                                              $knownskills = '';
                                              if (!empty($sendquote['requirement']['requirment_vacancy'])) {
                                                foreach ($sendquote['requirement']['requirment_vacancy'] as $skillquote) {
                                                  $knownskills .= (!empty($knownskills) ? ', ' : '') . $skillquote['skill']['name'];
                                                }
                                                echo $knownskills;
                                              }
                                            ?>
                                          </li>
                                          <li><?php echo $sendquote['requirement']['location']; ?></li>
                                        </ul>
                                      </div>

                                    <div class="mt-3">
                                      <a target="_blank" href="<?php echo SITE_URL; ?>/jobpost/applyjobsavebyquote/<?php echo $sendquote['id']; ?>/<?php echo $sendquote['job_id']; ?>" class="btn btn-success btn-sm me-2">Accept</a>

                                      <a target="_blank" href="<?php echo SITE_URL; ?>/jobpost/quotereject/<?php echo $sendquote['id']; ?>/<?php echo $sendquote['job_id']; ?>/<?php echo $sendquote['user_id']; ?>" class="btn btn-danger btn-sm">Decline</a>
                                    </div>
                                  </div>


                                <div class="box_hvr_checkndlt">
                                    <!--  <span class="pull-left"><input type="checkbox" value=""></span>--> <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="jobquote" data-val="<?php echo $sendquote['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                          </div> 
                          
                          <?php } ?> 

                            <?php //------------------ Booking Received-------------// ?> 
                            <?php foreach ($bookingreceived as $bookingrecalert) { //pr($bookingrecalert);die;?> 
                              <div id="<?php echo $bookingrecalert['id']; ?>" class="box member-detail row alerts bookingreceived <?php if ($bookingrecalert['viewedstatus'] == 'Y') { ?>jobviewed<?php } else { ?>jobnotviewed <?php } ?>"> <?php if ($bookingrecalert['requirement']['image'] != '') { ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/job/<?php echo $bookingrecalert['requirement']['image']; ?>">
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } else { ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } ?> <div class="col-sm-9 job-card">
                                    <div class="row">
                                        <h4><a href="<?php SITE_URL ?>/applyjob/<?php echo $sendquote['requirement']['id']; ?>"><?php echo $bookingrecalert['requirement']['title']; ?></a><span><?php echo date('Y-m-d H:m:s', strtotime($bookingrecalert['created'])) ?> </span></h4>
                                        <ul class=" list-unstyled col-sm-4 member-info">
                                            <li>Quote Sent For</li>
                                            <li>Requirement</li>
                                            <li>Location</li>
                                        </ul>
                                        <ul class="col-sm-2 list-unstyled">
                                            <li>:</li>
                                            <li>:</li>
                                            <li>:</li>
                                        </ul>
                                        <ul class="col-sm-6 list-unstyled">
                                            <li><?php echo $bookingrecalert['skill']['name']; ?></li>
                                            <li> <?php if ($bookingrecalert['requirement']['requirment_vacancy']) {
                                       $knownskills = '';
                                       foreach ($bookingrecalert['requirement']['requirment_vacancy'] as $skillquote) {
                                         if (!empty($knownskills)) {
                                           $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                         } else {
                                           $knownskills = $skillquote['skill']['name'];
                                         }
                                       }
                                       $output .= str_replace(',', ' ', $knownskills) . ',';
                                       //$output.=$knownskills.",";	
                                       echo $knownskills;
                                       }  ?> </li>
                                            <li><?php echo $bookingrecalert['requirement']['location']; ?></li>
                                        </ul>
                                    </div> <a target="_blank" href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $bookingrecalert['id']; ?>/Y/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default ad">Accept</a> <a target="_blank" href="<?php echo SITE_URL; ?>/jobpost/aplyrejectjob/<?php echo $bookingrecalert['id']; ?>/R/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default cnt">Decline</a>
                                </div>
                                <div class="box_hvr_checkndlt">
                                    <!--  <span class="pull-left"><input type="checkbox" value=""></span>--> <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="jobapplication" data-val="<?php echo $bookingrecalert['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                            </div> <?php } ?> 
                            
                            
                     <?php //------------------ Quote Request Received-------------//?> 


                        <?php foreach ($quoteapplicationalerts as $quoterecapp) { //pr($quoterecapp); die;?> 
                        <div style="border-bottom: none;border: 1px solid #e7e7e7;background: #fff;padding: 10px;margin-bottom:20px;" id="<?php echo $quoterecapp['id']; ?>" class="job-card box member-detail row alerts quoterequest <?php if ($quoterecapp['viewedstatus'] == 'Y') { ?>jobviewed<?php } else { ?>jobnotviewed <?php } ?>"> <?php if ($quoterecapp['requirement']['image'] != '') { ?> 
                          <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/job/<?php echo $quoterecapp['requirement']['image']; ?>">
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } else { ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } ?> <div class="col-sm-9 ">


                                <div class="row">
                                  <h3>
                                    <a target="_blank" style="font-size: 20px;padding-bottom: 5px;font-weight: 600;color: #4f84c4;" href="<?php echo SITE_URL ?>/applyjob/<?php echo $quoterecapp['requirement']['id']; ?>">
                                      <?php echo $quoterecapp['requirement']['title']; ?>
                                      <span style="font-size: 14px;font-weight: normal;color: #999;margin-top: 5px;">
                                        <?php echo date('Y-m-d h:i A', strtotime($quoterecapp['created'])) ?>
                                      </span>
                                    </a>
                                  </h3>

                                    <ul class="list-unstyled col-sm-4 member-info">
                                      <li>Quote Sent For</li>
                                      <li>Requirement</li>
                                      <li>Location</li>
                                      <li>Currency</li>
                                      <li>Payment Offer</li>
                                    </ul>

                                    <ul class="col-sm-2 list-unstyled">
                                      <li>:</li>
                                      <li>:</li>
                                      <li>:</li>
                                      <li>:</li>
                                      <li>:</li>
                                    </ul>

                                    <ul class="col-sm-6 list-unstyled">
                                      <li><?php echo $quoterecapp['skill']['name']; ?></li>

                                      <li>
                                        <?php
                                          $knownskills = '';
                                          if (!empty($quoterecapp['requirement']['requirment_vacancy'])) {
                                            foreach ($quoterecapp['requirement']['requirment_vacancy'] as $skillquote) {
                                              if (!empty($knownskills)) {
                                                $knownskills .= ', ' . $skillquote['skill']['name'];
                                              } else {
                                                $knownskills = $skillquote['skill']['name'];
                                              }
                                            }
                                            echo $knownskills;
                                          }
                                        ?>
                                      </li>

                                      <li><?php echo $quoterecapp['requirement']['location']; ?></li>

                                      <!-- Currency -->
                                      <li>
                                        <?php
                                          $currencyDisplay = '';
                                          $amountDisplay = 'Open to Negotiation';

                                          if (!empty($quoterecapp['requirement']['requirment_vacancy'])) {
                                            foreach ($quoterecapp['requirement']['requirment_vacancy'] as $vacancy) {
                                              if ($vacancy['skill']['id'] == $quoterecapp['skill_id']) {
                                                if (!empty($vacancy['currency']['symbol'])) {
                                                  $currencyDisplay = $vacancy['currency']['symbol'] . ' (' . $vacancy['currency']['name'] . ')';
                                                  $amountDisplay = !empty($vacancy['payment_amount']) ? $vacancy['payment_amount'] : '';
                                                } else {
                                                  $currencyDisplay = '-';
                                                  // $amountDisplay = '';
                                                }
                                                break; // stop after matching skill_id
                                              }
                                            }
                                          } else {
                                            $currencyDisplay = '-';
                                            // $amountDisplay = '';
                                          }

                                          echo $currencyDisplay;
                                        ?>
                                      </li>

                                      <!-- Payment Amount -->
                                      <li>
                                        <?php echo $amountDisplay; ?>
                                      </li>

                                    </ul>
                                </div>

                                    <a data-toggle="modal" class="data btn btn-default ad" href="<?php echo SITE_URL; ?>/jobpost/respondQuote/<?php echo $quoterecapp['job_id']; ?>">Send <?php ($quoterecapp['revision'] > 0 )?'Revise':''; ?> Quote</a>

                                </div>
                                <div class="box_hvr_checkndlt">
                                    <!--  <span class="pull-left"><input type="checkbox" value=""></span>--> <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="jobquote" data-val="<?php echo $quoterecapp['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                            </div> <?php } ?> 
                            <?php /* foreach($pingsent as $pingsentalert) { //pr($pingsentalert); ?> <div id="<?php echo $pingsentalert['id']; ?>" class="member-detail row alerts pingsent"> <?php if($pingsentalert['requirement']['image']!=''){ ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL;?>/job/<?php echo $pingsentalert['requirement']['image']; ?>">
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php }else{ ?> <div class="col-sm-3">
                                    <div class="member-detail-img"> <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                                    </div>
                                </div> <?php } ?> <div class="col-sm-9 boc_gap">
                                    <div class="row">
                                        <h4><span><?php echo date('Y-m-d',strtotime($pingsentalert['created']))?> </span></h4>
                                        <ul class=" list-unstyled col-sm-4 member-info">
                                            <li>Title</li>
                                            <li> Venue Location </li>
                                        </ul>
                                        <ul class="col-sm-2 list-unstyled">
                                            <li>:</li>
                                            <li>:</li>
                                        </ul>
                                        <ul class="col-sm-6 list-unstyled">
                                            <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingsentalert['user']['id']; ?>"><?php echo $pingsentalert['requirement']['title'];?></a></li>
                                            <li><?php echo $pingsentalert['requirement']['location'];?></li>
                                        </ul>
                                    </div> <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingsentalert['job_id']; ?>" class="btn btn-default ad">Accept</a> <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingsentalert['job_id']; ?>" class="btn btn-default cnt">Decline</a>
                                </div>
                                <div class="box_hvr_checkndlt">
                                    <!--  <span class="pull-left"><input type="checkbox" value=""></span>--> <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $pingsentalert['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                            </div> <?php } */ ?> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
      var site_url = '<?php echo SITE_URL; ?>/';
      $('.delete_jobalerts').click(function() {
        var job_id = $(this).data('val');
        // $("#"+job_id).remove();
        var job_action = $(this).data('action');
        $.ajax({
          type: "post",
          url: site_url + 'myalerts/alertsjob',
          data: {
            job: job_id,
            action: job_action
          },
          success: function(data) {
            $("." + job_id).remove();
          }
    
        });    
    
      });
    });
</script>

<script>
    $(document).ready(function() {
      $(".jobalerts").click(function() {
        var val = $(this).data('action');
        $(".alerts").hide();
        $("." + val).show();
      });    
      var selector = '.navff li';    
      $(selector).on('click', function() {
        $(selector).removeClass('active');
        $(this).addClass('active');
      });
    
    });
</script>
<!-------------------------------------------------->
<script>
    $('.data').click(function(e) {
      e.preventDefault();
      $('#singlemodel').modal('show').find('#single').load($(this).attr('href'));
    });
</script> <!-- Modal -->

<div id="singlemodel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Apply Job</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-dismissible" id="limitalert" style="display: none"> 
                  <strong id="limittext"></strong> 
              </div>

              <div id="single"></div>
                <!-- <form id="single" method="POST"> 
                </form> -->
            </div>
            <div class="modal-footer" style="border-top: none"> 
              <!-- <button type="submit" class="btn btn-default" form="single">Apply</button>  -->
            </div>
        </div>
    </div>
</div>

<!-- sendquote -->
<script>
    $('.sendquote').click(function(e) {
      e.preventDefault();
      $('#applysinglequote').modal('show').find('#singlequote').load($(this).attr('href'));
    });
</script> <!-- Modal -->

<div id="applysinglequote" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Quote</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-dismissible" id="sendquotelimitalert" style="display: none"> <strong id="sendlimittext"></strong> </div>
                <form id="singlequote" method="POST"> </form>
            </div>
            <div class="modal-footer" style=" border-top:none; "> <button type="submit" class="btn btn-default" form="singlequote">Send Quote</button> </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var SITE_URL = '<?php echo SITE_URL; ?>/';
    
    // $('#single').submit(function(event) {
    
    //   event.preventDefault();
    //   $.ajax({
    //     dataType: "html",
    //     type: "post",
    //     evalScripts: true,
    //     url: SITE_URL + 'jobpost/aplysingle',
    //     data: $('#single').serialize(),
    //     beforeSend: function() {
    //     },    
    //     success: function(response) {
    //       var myObj = JSON.parse(response);  
    //       if (myObj.success) {
    //          location.reload();   
    //       }else{
    //          $('#limitalert').css('display', 'block');
    //          $('#limittext').text(myObj.message);
    //       }           
    //     },
    //     complete: function() {
    //       $('#clodder').css("display", "none");
    //       a = 0;
    //       // alert(a);
    //     },
    //     error: function(data) {
    //       alert(JSON.stringify(data));    
    //     }
    
    //   });
    
    // });

    
    $('#singlequote').submit(function(event) {    
      event.preventDefault();
      $.ajax({
        dataType: "html",
        type: "post",
        evalScripts: true,
        url: SITE_URL + 'jobpost/aplysendquotesingle',
        data: $('#singlequote').serialize(),
        beforeSend: function() {
          $('#clodder').css("display", "block");    
        },
        success: function(response) {    
          var myObj = JSON.parse(response);    
          if (myObj.daily == 1) {
            $('#sendquotelimitalert').css('display', 'block');
            $('#sendlimittext').text(myObj.message);
          }    
          if (myObj.success == 2) {    
            quote = 0;    
            $('#updateping').empty();
            $("#pingamount").val('');      
            var count = 0;    
            location.reload();    
            window.scrollTo(0, 50);
            //location.reload();  
          } else {
            $("#applymultiplequote").modal('show');
            // $('#sendquotelimitalert').css("display","none");
          }    
          $('#quote').css("visibility", "hidden");    
        },
        complete: function() {
          $('#clodder').css("display", "none");
          a = 0;    
          // alert(a);    
        },
        error: function(data) {
          alert(JSON.stringify(data));    
        }
    
      });
    
    });

    $('.savejobs').click(function() {
      //console.log('test');
      var job = $(this).data('job');    
      event.preventDefault();
      $.ajax({
        dataType: "html",
        type: "post",
        evalScripts: true,
        url: SITE_URL + 'search/savejobs',
        data: {
          jobid: job
        },
        beforeSend: function() {   
        },    
        success: function(response) {
          var myObj = JSON.parse(response);
          if (myObj.success == 1) {   
            $('#savedjobs' + job + '').css('color', 'red');
          } else {
            $('#savedjobs' + job + '').css('color', 'white');
          }   
    
        },
        complete: function() {      
        },
        error: function(data) {
          alert(JSON.stringify(data));
    
        }
    
      });
    
    });
    
    $('.likejobs').click(function() {    
      var job = $(this).data('job');    
      event.preventDefault();
      $.ajax({
        dataType: "html",
        type: "post",
        evalScripts: true,
        url: SITE_URL + 'search/likejobs',
        data: {
          jobid: job
        },
        beforeSend: function() {  
        },    
        success: function(response) {    
          var myObj = JSON.parse(response);    
          if (myObj.success == 1) {   
            $('#like' + job + '').css('color', 'red');
          } else {
            $('#like' + job + '').css('color', 'white');
          }
    
        },
        complete: function() {     
        },
        error: function(data) {
          alert(JSON.stringify(data));
    
        }
    
      });
    
    });
    
    $('.block').click(function() {    
      var job = $(this).data('job');    
      event.preventDefault();
      $.ajax({
        dataType: "html",
        type: "post",
        evalScripts: true,
        url: SITE_URL + 'search/blockjobs',
        data: {
          jobid: job
        },
        beforeSend: function() {   
        },    
        success: function(response) {    
          var myObj = JSON.parse(response);    
          if (myObj.success == 1) {   
                $('#block' + job + '').css('color', 'red');
          } else {
            $('#block' + job + '').css('color', 'white');
          }
        
        },
        complete: function() {       
        },
        error: function(data) {
          alert(JSON.stringify(data));
    
        }
    
      });
    
    });

</script>

<div class="modal fade" id="reportuser" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Report for this Job</h4>
            </div>
            <div class="modal-body"> <span id="message" style="display: none; color: green"> Report Spam Sent Successfully...</span> <span id="wrongmessage" style="display: none; color: red"> Report Spam Not Sent...</span> <?php echo $this->Form->create('', array('url' => ['controller' => 'profile', 'action' => 'reportspam'], 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'submit-form', 'autocomplete' => 'off')); ?> <?php $reportoption = array('Pornography' => 'Pornography', 'Offensive Behaviour' => 'Offensive Behaviour', 'Fake Profile' => 'Fake Profile', 'Terms and Conditions Violation' => 'Terms and Conditions Violation', 'Spam' => 'Spam', 'Wrong Information displayed' => 'Wrong Information displayed', 'Public Display of Contact Information' => 'Public Display of Contact Information'); ?> <?php echo $this->Form->input('reportoption', array('class' => 'form-control', 'placeholder' => 'Country', 'maxlength' => '25', 'required', 'label' => false, 'type' => 'radio', 'options' => $reportoption)); ?> <?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'type' => 'textarea', 'required', 'label' => false)); ?> <?php echo
               $this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => 'profile')); ?> <?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $profile['user_id'])); ?> <?php echo $this->Form->end(); ?> <div class="text-right m-top-20"><button class="btn btn-default" id="bn_subscribe">Submit</button></div>
            </div>
        </div>
    </div>
</div>

<script>
    var site_url = '<?php echo SITE_URL; ?>/';
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

<script type="text/javascript">
    $(document).ready(function() {    
      $('.fb').click(function(e) {
        var link = $(this).data('link');
        // console.log(link);
        window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(link), 'sharer', 'toolbar=0,status=0,width=626,height=436');
        return false;
      });
    });
</script>