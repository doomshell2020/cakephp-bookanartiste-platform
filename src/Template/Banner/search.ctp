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
        <a href="javascript:void(0);" class="btn btn-default" style="padding:10px 8px;">
          Amount Spent <?php echo "$" . $value['amount']; ?>
        </a>
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
?>


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