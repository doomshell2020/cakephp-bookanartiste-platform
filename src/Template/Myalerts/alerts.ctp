<section id="page_alert">
  <div class="container">
    <h2>Alerts </h2>
    <p class="m-bott-50">Here You Can See Job alerts</p>
  </div>

  <div class="refine-search">
    <div class="container">
      <div class="row m-top-20 profile-bg">
        <div class="col-sm-3">
          <div class="panel panel-left">
            <ul class=" alrt-categry list-unstyled">

              <?php $allalerts = count($jobapplicationalerts) + count($bookingapplicationalerts) + count($quoteapplicationalerts) + count($quoteapplicationreceivedalerts) + count($quoterevisedalerts) + count($pingalerts) + count($applicationsentalerts) + count($sendaquotealerts) + count($bookingreceived) + count($quotereceive) + count($pingsent); ?>
              <li class="active"><a href="#" class="jobalerts" data-action="alerts">All</a><span class="noti_f"><?php echo $allalerts; ?></span></li>
              <?php //Non Talent Status 
              ?>
              <li><a href="#" class="jobalerts" data-action="applicationreceived">Application Received</a><span class="noti_f"><?php echo count($jobapplicationalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="bookingsent">Booking Sent</a><span class="noti_f"><?php echo count($bookingapplicationalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="quoterequest">Quote Request</a><span class="noti_f"><?php echo count($quoteapplicationalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="quotereceived">Quote Received</a><span class="noti_f"><?php echo count($quoteapplicationreceivedalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="quoterevised">Quote Revised</a><span class="noti_f"><?php echo count($quoterevisedalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="pingreceived">Ping Received</a><span class="noti_f"><?php echo count($pingalerts); ?></span></li>
              <?php //Talent Status 
              ?>
              <li><a href="#" class="jobalerts" data-action="applicatiosent">Application Sent</a><span class="noti_f"><?php echo count($applicationsentalerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="quotesent">Quote Sent</a><span class="noti_f"><?php echo count($sendaquotealerts); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="bookingreceived">Booking Received</a><span class="noti_f"><?php echo count($bookingreceived); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="quotereceived">Quote Received</a><span class="noti_f"><?php echo count($quotereceive); ?></span></li>
              <li><a href="#" class="jobalerts" data-action="pingsent">Ping sent</a><span class="noti_f"><?php echo count($pingsent); ?></span></li>

            </ul>

          </div>
          <img src="<?php echo SITE_URL; ?>/images/CB_Card.png">
        </div>


        <div class="col-sm-9">
          <div class="panel-right">
            <form>

              <?php //------------Start Non Talented-----------// 
              ?>
              <?php /////////////////////////////Application Received//////////////////////////
              ?>
              <?php foreach ($jobapplicationalerts as $applicationrec) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $applicationrec['id']; ?>" class="member-detail row alerts applicationreceived">

                  <?php if ($applicationrec['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $applicationrec['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>

                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $applicationrec['user']['id']; ?>"><?php echo $applicationrec['user']['profile']['name']; ?></a></li>

                        <li><?php if ($applicationrec['user']['skillset']) {
                              $knownskills = '';
                              foreach ($applicationrec['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $applicationrec['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $applicationrec['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $applicationrec['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-val="<?php echo $applicationrec['id'] ?>" data-action="jobapplication"> <i class="fa fa-times" aria-hidden="true"></i></a>

                  </div>
                </div>
              <?php } ?>



              <?php /////////////////////////////Booking Sent//////////////////////////
              ?>

              <?php foreach ($bookingapplicationalerts as $bookingrecapp) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $bookingrecapp['id']; ?>" class="member-detail row alerts bookingsent">

                  <?php if ($bookingrecapp['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $bookingrecapp['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>

                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bookingrecapp['user']['id']; ?>"><?php echo $bookingrecapp['user']['profile']['name']; ?></a></li>

                        <li><?php if ($bookingrecapp['user']['skillset']) {
                              $knownskills = '';
                              foreach ($bookingrecapp['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $bookingrecapp['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bookingrecapp['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bookingrecapp['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $bookingrecapp['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>





              <?php /////////////////////////////Quote Request//////////////////////////
              ?>

              <?php foreach ($quoteapplicationalerts as $quoterecapp) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $quoterecapp['id']; ?>" class="member-detail row alerts quoterequest">

                  <?php if ($quoterecapp['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $quoterecapp['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>

                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quoterecapp['user']['id']; ?>"><?php echo $quoterecapp['user']['profile']['name']; ?></a></li>

                        <li><?php if ($quoterecapp['user']['skillset']) {
                              $knownskills = '';
                              foreach ($quoterecapp['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $quoterecapp['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quoterecapp['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quoterecapp['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $quoterecapp['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>





              <?php /////////////////////////////Quote Receive//////////////////////////
              ?>

              <?php foreach ($quoteapplicationreceivedalerts as $quotereceialerts) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $quotereceialerts['id']; ?>" class="member-detail row alerts quotereceived">

                  <?php if ($quotereceialerts['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $quotereceialerts['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>

                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotereceialerts['user']['id']; ?>"><?php echo $quoterecapp['user']['profile']['name']; ?></a></li>

                        <li><?php if ($quotereceialerts['user']['skillset']) {
                              $knownskills = '';
                              foreach ($quotereceialerts['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $quotereceialerts['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotereceialerts['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotereceialerts['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $quotereceialerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>





              <?php /////////////////////////////Quote Revised//////////////////////////
              ?>

              <?php foreach ($quoterevisedalerts as $quotrevisedale) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $quotrevisedale['id']; ?>" class="member-detail row alerts quoterevised">

                  <?php if ($quotrevisedale['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $quotrevisedale['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>

                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotrevisedale['user']['id']; ?>"><?php echo $quotrevisedale['user']['profile']['name']; ?></a></li>

                        <li><?php if ($quotrevisedale['user']['skillset']) {
                              $knownskills = '';
                              foreach ($quotrevisedale['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $quotrevisedale['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotrevisedale['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotrevisedale['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $quotrevisedale['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>




              <?php /////////////////////////////Ping Received//////////////////////////
              ?>

              <?php foreach ($pingalerts as $pingreceivedalerts) { //pr($applicationrec); 
              ?>
                <div id="<?php echo $pingreceivedalerts['id']; ?>" class="member-detail row alerts pingreceived">

                  <?php if ($pingreceivedalerts['user']['profile']['profile_image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $pingreceivedalerts['user']['profile']['profile_image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li>Requirement</li>
                        <li>Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>

                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingreceivedalerts['user']['id']; ?>"><?php echo $pingreceivedalerts['user']['profile']['name']; ?></a></li>

                        <li><?php if ($pingreceivedalerts['user']['skillset']) {
                              $knownskills = '';
                              foreach ($pingreceivedalerts['user']['skillset'] as $skillquote) {
                                if (!empty($knownskills)) {
                                  $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                } else {
                                  $knownskills = $skillquote['skill']['name'];
                                }
                              }
                              $output .= str_replace(',', ' ', $knownskills) . ',';
                              //$output.=$knownskills.",";	
                              echo $knownskills;
                            }  ?></li>
                        <li><?php echo $pingreceivedalerts['user']['profile']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingreceivedalerts['user']['id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingreceivedalerts['user']['id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>

              <?php //------------End Non Talented-----------// 
              ?>



              <?php //------------Start Talented-----------// 
              ?>
              <?php /////////////////////////////Application Sent//////////////////////////
              ?>
              <?php foreach ($applicationsentalerts as $applicationsent) { //pr($applicationsent); 
              ?>
                <div class="member-detail row alerts applicatiosent">

                  <?php if ($applicationsent['requirement']['image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $applicationsent['requirement']['image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li> Venue Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>


                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $applicationsent['user']['id']; ?>"><?php echo $applicationsent['requirement']['title']; ?></a></li>

                        <li><?php echo $applicationsent['requirement']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $applicationsent['job_id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $applicationsent['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>

              <?php // Quote sent// 
              ?>

              <?php foreach ($sendaquotealerts as $sendquote) { //pr($applicationsent); 
              ?>
                <div class="member-detail row alerts quotesent">

                  <?php if ($sendquote['requirement']['image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $sendquote['requirement']['image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li> Venue Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>


                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $sendquote['user']['id']; ?>"><?php echo $sendquote['requirement']['title']; ?></a></li>

                        <li><?php echo $sendquote['requirement']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['job_id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>





              <?php // Quote sent// 
              ?>

              <?php foreach ($bookingreceived as $bookingrecalert) { //pr($applicationsent); 
              ?>
                <div class="member-detail row alerts bookingreceived">

                  <?php if ($bookingrecalert['requirement']['image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $bookingrecalert['requirement']['image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li> Venue Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>


                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bookingrecalert['user']['id']; ?>"><?php echo $bookingrecalert['requirement']['title']; ?></a></li>

                        <li><?php echo $bookingrecalert['requirement']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>


              <?php // Quote 	 Received// 
              ?>

              <?php foreach ($quotereceive as $quotereceivealert) { //pr($applicationsent); 
              ?>
                <div class="member-detail row alerts quotereceived">

                  <?php if ($quotereceivealert['requirement']['image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $quotereceivealert['requirement']['image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li> Venue Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>


                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotereceivealert['user']['id']; ?>"><?php echo $quotereceivealert['requirement']['title']; ?></a></li>

                        <li><?php echo $quotereceivealert['requirement']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quotereceivealert['job_id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quotereceivealert['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>





              <?php // Ping Received// 
              ?>

              <?php foreach ($pingsent as $pingsentalert) { //pr($applicationsent); 
              ?>
                <div class="member-detail row alerts pingsent">

                  <?php if ($pingsentalert['requirement']['image'] != '') { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $pingsentalert['requirement']['image']; ?>">
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-sm-3">
                      <div class="member-detail-img">
                        <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                        <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="col-sm-9 boc_gap">
                    <div class="row">
                      <!-- <h4>Has Send booking request for<span>yesterday</span></h4>-->
                      <ul class=" list-unstyled col-sm-4 member-info">
                        <li>Title</li>
                        <li> Venue Location </li>
                      </ul>
                      <ul class="col-sm-2 list-unstyled">
                        <li>:</li>
                        <li>:</li>


                      </ul>
                      <ul class="col-sm-6 list-unstyled">
                        <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingsentalert['user']['id']; ?>"><?php echo $pingsentalert['requirement']['title']; ?></a></li>

                        <li><?php echo $pingsentalert['requirement']['location']; ?></li>

                      </ul>
                    </div>
                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingsentalert['job_id']; ?>" class="btn btn-default ad">Accept</a>

                    <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingsentalert['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                  </div>

                  <div class="box_hvr_checkndlt">
                    <span class="pull-left"><input type="checkbox" value=""></span>
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $pingsentalert['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                  </div>
                </div>
              <?php } ?>

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
      var job_action = $(this).data('action');

      $.ajax({
        type: "post",
        url: site_url + 'myalerts/alertsjob',
        data: {
          data: job_id,
          action: job_action
        },
        success: function(data) {

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
  });
</script>
<!-------------------------------------------------->