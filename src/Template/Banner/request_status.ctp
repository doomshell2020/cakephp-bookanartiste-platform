<style>
  #page_alert .member-detail .btn-primary {
    margin-top: 0;
  }

  .member-detail .btn-default {
    margin-top: 0;
    width: 100%;
  }

  ul.job-r-skill {
    position: relative;
  }

  ul.job-r-skill li.deletebutton {
    position: absolute;
    top: 0px;
    right: 0px;
  }

  .money_spent {
    padding: 10px 8px;
    margin-top: 0;
    width: 100%;
    background-color: #078fe8;
    color: aliceblue;
    margin: 0px 0 0px
  }
</style>
<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>

<section id="page_signup">
  <div class="container">

  </div>

  <div class="refine-search">
    <div class="container">

      <div class="row m-top-20 profile-bg signup-popup">
        <div class="job_search_heading">
          <h2 id="bannerheading">Banner <span>Request Status</span></h2>
        </div>
        <?php echo $this->Flash->render(); ?>
        <div class="col-sm-3">
          <div style="padding-bottom:0px;" class="panel panel-left">
            <ul style="margin-bottom:0px;" class="alrt-categry list-unstyled navff">

              <?php $allalerts = count($approvedbanner) + count($declinebanner) + count($previousbanner); ?>
              <li id="all" style="padding:0px;">
                <a href="javascript:void(0);" style="display:block; padding: 8px 15px;" class="jobalerts" data-action="all">Pending, ActiveBanners<span class="noti_f"><?php echo count($allbanner); ?></span>
                </a>
              </li>

              <li id="approved" style="padding:0px;">
                <a href="javascript:void(0);" style="display:block; padding: 8px 15px;" class="jobalerts" data-action="approved">Approved<span class="noti_f"><?php echo count($approvedbanner); ?></span>
                </a>
              </li>


              <li id="declined" style="padding:0px;">
                <a href="javascript:void(0);" style="display:block; padding: 8px 15px;" class="jobalerts" data-action="declined">Declined<span class="noti_f declinebannercount"><span><?php echo count($declinebanner); ?></span></span>
                </a>
              </li>

              <li id="previous" style="padding:0px;">
                <a href="javascript:void(0);" style="display:block; padding: 8px 15px;" class="jobalerts pbanners" data-action="previousbanners">Previous Banners<span class="noti_f previousbannerscount"><span><?php echo count($previousbanner); ?></span></span></a>
              </li>

            </ul>

          </div>
          <!-- <img src="<?php //echo SITE_URL; 
                          ?>/images/CB_Card.png"> -->
        </div>


        <div class="col-sm-9">
          <!-- <?php // if(count($allbanner)> 0 || count($approvedbanner)> 0 || count($declinebanner) > 0 || count($previousbanner) > 0){ 
                ?>
        
        <?php // }else{
        ?>
        <?php // echo "No Alerts for you at the moment"; 
        ?>

        <?php // } 
        ?> -->
          <div class="panel-right">

            <?php //------------Start All banner request-----------// 
            ?>
            <?php if (count($allbanner) > 0) { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts1 all">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <?php
                          foreach ($allbanner as $value) {
                            //  pr($value); //die;
                          ?>
                            <div class="col-sm-12  box job-card">
                              <div class="remove-top">
                              </div>
                              <div class="col-sm-2">
                                <div class="profile-det-img1">
                                  <?php //pr($value);
                                  if (!empty($value['bannerurl'])) { ?>
                                    <a target="_blank" href="<?php echo $value['bannerurl']; ?>">
                                      <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                    </a>
                                  <?php } else {  ?>
                                    <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                  <?php } ?>
                                  <?php $currentdate = date('Y-m-d');
                                  if ($value['is_approved'] == 1 && $value['status'] == 'N') { ?>
                                    <a href="<?php echo SITE_URL; ?>/package/bannerpayment/<?php echo $value['id']; ?>" class="btn btn-default" style="padding:10px 8px;">
                                      Pay <?php echo "$" . $value['amount']; ?> to publish
                                    </a>
                                  <?php } elseif ($value['status'] == 'Y' && $value['banner_status'] == 'Y') { ?>
                                    <a href="javascript:void(0);" class="btn btn-primary" style="padding:10px 8px; pointer-events: none; cursor: default;">
                                      Published
                                    </a>
                                  <?php } ?>
                                </div>
                              </div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a target="_blank" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['title'] ?></a>
                                    <span data-toggle="tooltip" title="Date of Request"><?php echo date('M d Y', strtotime($value['created']));  ?></span>
                                  </h3>
                                  <p><?php echo $value['location'] ?></p>
                                  <ul class="list-unstyled job-r-skill">
                                    <?php if (!empty($value['bannerurl'])) { ?>
                                      <li><a href="#" class="fa fa-link"></a>
                                        <a target="_blank" style="width: auto;" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['bannerurl']; ?></a>
                                      </li>
                                    <?php } ?>

                                    <li><a href="#" class=" fa fa-calendar"></a> From
                                      <?php echo date('M d Y || h:s a', strtotime($value['banner_date_from']));  ?>
                                    </li>
                                    <li><a href="#" class=" fa fa-calendar"></a> To
                                      <?php echo date('M d Y || h:s a', strtotime($value['banner_date_to']));  ?>
                                    </li>

                                    <?php
                                    if ($value['is_approved'] == 1) { ?>
                                      <li><a href="#" class="fa fa-calendar-check-o"></a> Approved
                                        <?php echo date('M d Y', strtotime($value['approval_date'])); ?>
                                      </li>

                                    <?php } else { ?>
                                      <li><a href="#" style="color: red; font-size: 17px;" class="fa fa-times-circle-o"></a> Pending
                                      </li>
                                    <?php } ?>

                                    <?php
                                    if ($value['status'] == 'Y' && $value['banner_status'] == 'Y' && date('Y-m-d', strtotime($value['banner_date_to'])) < date('Y-m-d')) { ?>
                                      <li class="deletebutton"><a class='label label-warning' href="<?php echo SITE_URL ?>/banner/delete/<?php echo $value['id']; ?>">Delete</a></li>
                                    <?php }
                                    ?>

                                    <?php
                                    if ($value['status'] == 'Y' && $value['banner_status'] == 'Y') { ?>
                                      <li class="deletebutton"><a class='label label-success' href="<?php echo SITE_URL ?>/banner/status/<?php echo $value['id']; ?>/N">Active</a></li>
                                    <?php } ?>

                                    <?php
                                    if ($value['status'] == 'N' && $value['banner_status'] == 'Y') { ?>
                                      <li class="deletebutton"><a class='label label-danger' href="<?php echo SITE_URL ?>/banner/status/<?php echo $value['id']; ?>/Y">Inactive</a></li>
                                    <?php } ?>

                                  </ul>
                                </div>
                              </div>
                            </div>
                          <?php    }
                          ?>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts1 all">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <h5> There are no approved and published banners at the moment</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php  } ?>


            <?php //------------Start approved banner request-----------// 
            ?>
            <?php if (count($approvedbanner) > 0) { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  approved">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">

                          <div class="searching">
                            <?php echo $this->Form->create('approvedsearch', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm1', 'autocomplete' => 'off')); ?>

                            <div class="form-group">

                              <div class="col-sm-3">
                                <label>Dates activated on from</label>
                                <?php echo $this->Form->input('fromdate', array('class' => 'form-control fromdate', 'autocomplete' => 'off', 'id' => 'datepicker1', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY', 'value' => '')); ?>
                              </div>

                              <div class="col-sm-3">
                                <label>Dates activated on to</label>
                                <?php echo $this->Form->input('todate', array('class' => 'form-control todate', 'autocomplete' => 'off', 'id' => 'datepicker2', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY')); ?>
                              </div>

                              <button type="submit" class="btn btn-success" style="margin-top:28px;">Search</button>
                              <button type="submit" class="btn btn-success clear" style="margin-top:28px;">Reset</button>
                            </div>

                            <?php echo $this->Form->end(); ?>
                          </div>
                          <div id="example3">
                            <?php
                            foreach ($approvedbanner as $value) {
                              //  pr($value); //die;
                            ?>
                              <div class="col-sm-12  box job-card">
                                <div class="remove-top">
                                </div>
                                <div class="col-sm-2">
                                  <div class="profile-det-img1">
                                    <?php //pr($value);
                                    if (!empty($value['bannerurl'])) { ?>
                                      <a target="_blank" href="<?php echo $value['bannerurl']; ?>">
                                        <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                      </a>
                                    <?php } else {  ?>
                                      <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                    <?php } ?>
                                    <?php $currentdate = date('Y-m-d');
                                    if ($value['is_approved'] == 1 && $value['status'] == 'N') { ?>
                                      <a href="<?php echo SITE_URL; ?>/package/bannerpayment/<?php echo $value['id']; ?>" class="btn btn-default" style="padding:10px 8px;">
                                        Pay <?php echo "$" . $value['amount']; ?> to publish
                                      </a>
                                    <?php } elseif ($value['status'] == 'Y' && $value['banner_status'] == 'Y') { ?>
                                      <a href="javascript:void(0);" class="btn btn-primary" style="padding:10px 8px; pointer-events: none; cursor: default;">
                                        Published
                                      </a>
                                    <?php } ?>
                                  </div>
                                </div>
                                <div class="col-sm-10">
                                  <div class="box_dtl_text">
                                    <h3 class="heading">
                                      <a target="_blank" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['title'] ?></a>
                                      <span data-toggle="tooltip" title="Date of Request"><?php echo date('M d Y', strtotime($value['created']));  ?></span>
                                    </h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <?php if (!empty($value['bannerurl'])) { ?>
                                        <li><a href="#" class=" fa fa-link"></a>
                                          <a target="_blank" style="width: auto;" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['bannerurl']; ?></a>
                                        </li>
                                      <?php } ?>

                                      <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('M d Y || h:s a', strtotime($value['banner_date_from']));  ?>
                                      </li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('M d Y || h:s a', strtotime($value['banner_date_to']));  ?>
                                      </li>

                                      <?php
                                      if ($value['approval_date']) { ?>
                                        <li><a href="#" class="fa fa-calendar-check-o"></a> Approved
                                          <?php echo date('M d Y', strtotime($value['approval_date'])); ?>
                                        </li>
                                      <?php } ?>



                                      <!-- <?php
                                            //if($value['status']=='Y' && $value['banner_status']=='Y'){ 
                                            ?>
                                          <li class="deletebutton"><a class='label label-warning' href="<?php //echo SITE_URL 
                                                                                                        ?>/banner/delete/<?php echo $value['id']; ?>" >Delete</a></li>
                                        <?php //} 
                                        ?> -->

                                      <?php
                                      if ($value['status'] == 'Y' && $value['banner_status'] == 'Y') { ?>
                                        <li class="deletebutton"><a class='label label-success' href="<?php echo SITE_URL ?>/banner/status/<?php echo $value['id']; ?>/N">Active</a></li>
                                      <?php } ?>

                                      <?php
                                      if ($value['status'] == 'N' && $value['banner_status'] == 'Y') { ?>
                                        <li class="deletebutton"><a class='label label-danger' href="<?php echo SITE_URL ?>/banner/status/<?php echo $value['id']; ?>/Y">Inactive</a></li>
                                      <?php } ?>

                                    </ul>
                                  </div>
                                </div>
                              </div>
                            <?php    }
                            ?>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  approved">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <h5> There are no banners available for you on this page</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php  } ?>


            <?php //------------Start decline banner request-----------// 
            ?>
            <?php if (count($declinebanner) > 0) { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  declined">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">

                          <div class="searching">
                            <?php echo $this->Form->create('declinesearch', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm2', 'autocomplete' => 'off')); ?>

                            <div class="form-group">

                              <div class="col-sm-3">
                                <label>Request sent on from</label>
                                <?php echo $this->Form->input('fromdate', array('class' => 'form-control fromdate', 'autocomplete' => 'off', 'id' => 'datepicker3', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY')); ?>
                              </div>

                              <div class="col-sm-3">
                                <label>Date requested on to</label>
                                <?php echo $this->Form->input('todate', array('class' => 'form-control todate', 'autocomplete' => 'off', 'id' => 'datepicker4', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY')); ?>
                              </div>

                              <button type="submit" class="btn btn-success" style="margin-top:28px;">Search</button>
                              <button type="submit" class="btn btn-success clear" style="margin-top:28px;">Reset</button>
                            </div>

                            <?php echo $this->Form->end(); ?>
                          </div>
                          <div id="example4">
                            <?php
                            foreach ($declinebanner as $value) {
                            ?>
                              <div class="col-sm-12  box job-card deleteclass<?php echo $value['id']; ?>">
                                <div class="remove-top">
                                </div>
                                <div class="col-sm-2">
                                  <div class="profile-det-img1">
                                    <?php //pr($value);
                                    if (!empty($value['bannerurl'])) { ?>
                                      <a target="_blank" href="<?php echo $value['bannerurl']; ?>">
                                        <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                      </a>
                                    <?php } else {  ?>
                                      <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                    <?php } ?>
                                    <!-- <a id="popoverOption<?php //echo $value['id']; 
                                                              ?>" onclick="decline(<? php // echo $value['id']; 
                                                                                                              ?>);" class="btn btn-primary" style="padding:10px 8px;" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">View Decline Reason</a> -->

                                  </div>
                                </div>
                                <script>
                                  $(document).ready(function() {
                                    $('#popoverData').popover();
                                    $('#popoverOption<?php echo $value['id']; ?>').popover({
                                      trigger: "click"
                                    });
                                  });
                                </script>
                                <div class="col-sm-10">
                                  <div class="box_dtl_text">
                                    <h3 class="heading">
                                      <a target="_blank" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['title'] ?></a>
                                      <span data-toggle="tooltip" title="Date of Request"><?php echo date('M d Y', strtotime($value['created']));  ?></span>
                                    </h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <?php if (!empty($value['bannerurl'])) { ?>
                                        <li><a href="#" class="fa fa-link"></a>
                                          <a target="_blank" style="width: auto;" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['bannerurl']; ?></a>
                                        </li>
                                      <?php } ?>

                                      <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('M d Y || h:s a', strtotime($value['banner_date_from']));  ?>
                                      </li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('M d Y || h:s a', strtotime($value['banner_date_to']));  ?>
                                      </li>
                                      <li><a href="#" class=" fa fa-comment"></a> Reason for decline <b>:</b>
                                        <?php echo $value['decline_reason'];  ?>
                                      </li>
                                      <li class="deletebutton"><a class='label label-warning delete_btn' href="javascript:void(0)" data-val="<?php echo $value['id']; ?>" data-action="declined">Delete</a></li>

                                      <!-- <li class="deletebutton"><a class='label label-warning' href="<?php //echo SITE_URL 
                                                                                                          ?>/banner/delete/<?php //echo $value['id']; 
                                                                                                                                                ?>/declined" >Delete</a></li> -->
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            <?php    }
                            ?>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  declined">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <h5>No declined banner requests to show at the moment.</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php  } ?>


            <?php //------------Start preivous banner request-----------// 
            ?>
            <?php if (count($previousbanner) > 0) { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  previousbanners">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <!-- <h5>Your Previous Banners Published in the last 90 days</h5> -->
                          <div class="searching">
                            <?php echo $this->Form->create('search', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm', 'autocomplete' => 'off')); ?>

                            <div class="form-group">

                              <div class="col-sm-3">
                                <label>Banner Published On From</label>
                                <?php echo $this->Form->input('fromdate', array('class' => 'form-control datetimepicker1 fromdate', 'autocomplete' => 'off', 'id' => 'event_from_date', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY')); ?>
                              </div>

                              <div class="col-sm-3">
                                <label>Banner Published On To</label>
                                <?php echo $this->Form->input('todate', array('class' => 'form-control datetimepicker2 todate', 'autocomplete' => 'off', 'id' => 'event_to_date', 'label' => false, 'type' => 'text', 'require' => true, 'placeholder' => 'MM/DD/YYYY')); ?>
                              </div>

                              <button type="submit" class="btn btn-success" style="margin-top:28px;">Search</button>
                              <button type="submit" class="btn btn-success clear" style="margin-top:28px;">Reset</button>
                            </div>

                            <?php echo $this->Form->end(); ?>
                          </div>



                          <?php
                          if ($bannerdays < 90) {
                          ?>
                            <div id="example2">
                              <?php
                              foreach ($previousbanner as $value) {
                                //$fromdate=date('Y-m-d',strtotime($value['banner_date_from']));
                                $todate = date('Y-m-d', strtotime($value['banner_date_to']));
                                $currentdate = date('Y-m-d');

                                $date1 = date_create($currentdate);
                                $date2 = date_create($todate);
                                $diff = date_diff($date2, $date1);

                                $bannerdays = $diff->days;


                              ?>
                                <div class="col-sm-12  box job-card deleteclass<?php echo $value['id']; ?>">
                                  <div class="remove-top"> </div>
                                  <div class="col-sm-2">
                                    <div class="profile-det-img1">
                                      <?php //pr($value);
                                      if (!empty($value['bannerurl'])) { ?>
                                        <a target="_blank" href="<?php echo $value['bannerurl']; ?>">
                                          <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                        </a>
                                      <?php } else {  ?>
                                        <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 150px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $value['banner_image']; ?>" />
                                      <?php } ?>

                                      <p class="money_spent">
                                        Amount Spent <?php echo "$" . $value['amount']; ?>
                                      </p>
                                    </div>
                                  </div>
                                  <div class="col-sm-10">
                                    <div class="box_dtl_text">
                                      <h3 class="heading">
                                        <a target="_blank" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['title'] ?></a>
                                        <span data-toggle="tooltip" title="Date of Request"><?php echo date('M d Y', strtotime($value['created']));  ?></span>
                                      </h3>
                                      <p><?php echo $value['location'] ?></p>
                                      <ul class="list-unstyled job-r-skill">
                                        <?php if (!empty($value['bannerurl'])) { ?>
                                          <li><a href="#" class="fa fa-link"></a>
                                            <a target="_blank" style="width: auto;" href="<?php echo $value['bannerurl']; ?>"><?php echo $value['bannerurl']; ?></a>
                                          </li>
                                        <?php } ?>

                                        <li><a href="#" class=" fa fa-calendar"></a> From
                                          <?php echo date('M d, Y || h:s a', strtotime($value['banner_date_from']));  ?>
                                        </li>
                                        <li><a href="#" class=" fa fa-calendar"></a> To
                                          <?php echo date('M d, Y || h:s a', strtotime($value['banner_date_to']));  ?>
                                        </li>
                                        <!-- <?php
                                              //if($value['approval_date']){ 
                                              ?>
                                      <li><a href="#" class="fa fa-calendar-check-o"></a> Approved
                                   <?php  //echo date('M d Y',strtotime($value['approval_date'])); 
                                    ?> 
                                   </li>  
                                    <?php //} 
                                    ?> -->

                                        <?php
                                        if ($value['is_approved'] == 0) { ?>
                                          <li><a href="#" style="color: red; font-size: 17px;" class="fa fa-times-circle-o"></a> Pending
                                          </li>
                                        <?php } ?>

                                        <?php if ($value['status'] == 'Y' && $value['banner_status'] == 'Y') { ?>
                                          <li><a href="#" style="color: #42b3f6; font-size: 17px;" class="fa fa-money"></a>
                                            $<?php echo $value['amount']; ?>
                                          </li>
                                        <?php } ?>
                                        <li class="deletebutton"><a class='label label-warning delete_btn' href="javascript:void(0)" data-val="<?php echo $value['id']; ?>" data-action="previousbanners">Delete</a></li>
                                        <!-- <li class="deletebutton"><a class='label label-warning deletebutton' href="<?php //echo SITE_URL 
                                                                                                                        ?>/banner/delete/<?php //echo $value['id']; 
                                                                                                                                                                ?>" >Delete</a></li> -->
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                            <?php   }
                            }
                            ?>
                            </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php } else { ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail alerts  previousbanners">
                <div class="">
                  <div class="profile-bg job_rslt_bg">
                    <div class="clearfix">
                      <div class="col-sm-12">
                        <div class="clearfix job-box">
                          <h5> There are no previous banners toshow. Please <a target="_blank" href="<?php echo SITE_URL; ?>/banner">initiate a request</a></h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php  } ?>

          </div>

        </div>
      </div>
    </div>
  </div>

</section>

<!-- Modal -->
<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      </div> 
    </div>
  </div> -->

<!-- Modal content-->
<!-- <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Decline Reason</h4>
        </div>
        <div class="modal-body">
          <p class="modal_decline_reason"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div> -->



<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  $(function() {

    var dateFormat = 'dd-mm-yy',
      from = $("#datepicker1").datepicker({
        dateFormat: 'dd-mm-yy',

        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
        startDate: "-3M",

      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }).val('');
    to = $("#datepicker2").datepicker({
        dateFormat: 'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      }).val('');

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }
  });
</script>

<script>
  $(function() {

    var dateFormat = 'dd-mm-yy',
      from = $("#datepicker3").datepicker({
        dateFormat: 'dd-mm-yy',

        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
        startDate: "-3M",

      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }).val('');
    to = $("#datepicker4").datepicker({
        dateFormat: 'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      }).val('');

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }
  });
</script>

<script type="text/javascript">
  $(function() {
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today);
    $("#totalamt").val('0');
    $('#event_from_date').datetimepicker({
      format: 'mm dd, yyyy hh:ii',
      startDate: tomorrow,
      autoclose: true
    });

    $('#event_to_date').datetimepicker({
      format: 'mm dd, yyyy hh:ii',
      startDate: tomorrow,
      autoclose: true
    });
  });
</script>
<script>
  function validateform() {
    error = '';
    //alert('0');
    event_from_date = new Date($('#event_from_date').val());
    event_to_date = new Date($('#event_to_date').val());
    alert(event_from_date);

    var todatenew = event_to_date.getTime();
    var fromdatenew = event_from_date.getTime();
    //console.log(todatenew);
    //console.log(todatenew-fromdatenew);
    var difrence = todatenew - fromdatenew;
    if (difrence < 86400000) {
      $("#totalamt").val('0');
      error = error + "Banner End date cannot be less than Banner start date.<br>";
    } else {
      var start = $('#event_from_date').val();
      var end = $('#event_to_date').val();
      // end - start returns difference in milliseconds 
      var diff = new Date(event_to_date - event_from_date);
      // get days
      var days = diff / 1000 / 60 / 60 / 24;
      var daydiff = Math.round(days);
      var amt = '<?php echo $bannerpackid['cost_per_day']; ?>';
      var totalamt = amt * daydiff;
      //alert(totalamt);
      if (isNaN(totalamt)) {
        $("#totalamt").val('');
      } else {
        $("#totalamt").val(totalamt);
      }
    }

    if (error != '') {
      BootstrapDialog.alert({
        size: BootstrapDialog.SIZE_SMALL,
        title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Banner !!",
        message: "<h5>" + error + "</h5>"
      });
      $('#event_to_date').val('');
      return false;
    }
  }
</script>

<script inline="1">
  //<![CDATA[
  $(document).ready(function() {
    $("#TaskAdminCustomerForm").bind("submit", function(event) {
      $.ajax({
        async: true,
        data: $("#TaskAdminCustomerForm").serialize(),
        dataType: "html",
        type: "POST",
        url: "<?php echo SITE_URL; ?>/banner/search",
        success: function(data, textStatus) {
          console.log(data);
          $("#example2").html(data);
        }
      });
      return false;
    });
  });
  //]]>
</script>

<script>
  $(document).ready(function() {
    $(".delete_btn").on('click', function() {
      var banner_id = $(this).data('val');
      //alert(banner_id);
      var className = ".deleteclass" + banner_id;
      var action = $(this).data('action');
      //  alert(val);
      //  alert(className);
      $(className).hide();
      $.ajax({
        type: 'POST',
        url: '<?php echo SITE_URL; ?>/banner/delete',
        data: {
          'banner_id': banner_id,
          'action': action
        },
        success: function(data) {

          var obj = JSON.parse(data);
          // alert(obj.action);
          if (obj.action == "declined") {
            $('.declinebannercount span').html(obj.count);
          }
          if (obj.action == "previousbanners") {
            $('.previousbannerscount span').html(obj.count);
          }
          // alert('hello');

          toastr.success('The banner has been successfully deleted')
        },
      });
    });
  });
</script>

<script inline="1">
  //<![CDATA[
  $(document).ready(function() {
    $("#TaskAdminCustomerForm1").bind("submit", function(event) {
      $.ajax({
        async: true,
        data: $("#TaskAdminCustomerForm1").serialize(),
        dataType: "html",
        type: "POST",
        url: "<?php echo SITE_URL; ?>/banner/approvedsearch",
        success: function(data, textStatus) {
          console.log(data);
          $("#example3").html(data);
        }
      });
      return false;
    });
  });
  //]]>
</script>

<script inline="1">
  $(document).ready(function() {
    $("#TaskAdminCustomerForm2").bind("submit", function(event) {
      $.ajax({
        async: true,
        data: $("#TaskAdminCustomerForm2").serialize(),
        dataType: "html",
        type: "POST",
        url: "<?php echo SITE_URL; ?>/banner/declinesearch",
        success: function(data, textStatus) {
          console.log(data);
          $("#example4").html(data);
        }
      });
      return false;
    });
  });
</script>


<script>
  $(document).ready(function() {
    var site_url = '<?php echo SITE_URL; ?>/';
    $('.delete_jobalerts').click(function() {
      var job_id = $(this).data('val');
      // alert(job_id);
      // $("#"+job_id).remove();
      var job_action = $(this).data('action');
      //alert(job_action);
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
    $(".alerts").hide();
    $(".searching").hide();
    $(".jobalerts").click(function() {
      var val = $(this).data('action');
      //alert(val);
      $(".alerts").hide();
      $(".alerts1").hide();
      $("." + val).show();
      if (val == "alerts") {
        $(".searching").hide();
      } else {
        $(".searching").show();
      }

    });

    var selector = '.navff li';

    $(selector).on('click', function() {
      $(selector).removeClass('active');
      $(this).addClass('active');
    });

  });
</script>

<script>
  $(".clear").click(function() {
    $(".fromdate").val('');
    $(".todate").val('');
  });
</script>


<script>
  $(document).ready(function() {
    $("ul.alrt-categry li").click(function() {
      var myId = $(this).attr("id");

      if (myId == "previous") {
        jQuery('#bannerheading').html("Previous <span>Banners</span>");
      } else {
        jQuery('#bannerheading').html("Banner <span>Request Status</span>");
      }
    });


  });


  function decline(e) {
    //alert(e);
    var data = '<?php echo json_encode($declinebanner); ?>';
    var dec = JSON.parse(data);
    var reason = dec.filter(a => a.id == e);
    //alert(reason[0]['decline_reason']);
    console.log(reason);
    jQuery('.modal_decline_reason').html(reason[0]['decline_reason']);
  }
</script>