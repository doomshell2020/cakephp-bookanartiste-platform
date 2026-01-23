<?php //pr($approvedbanner); die;
foreach ($approvedbanner as $value) {
  //  pr($value); die;
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
                                          ?>                                   -->
        </ul>
      </div>
    </div>
  </div>
<?php    }
?>