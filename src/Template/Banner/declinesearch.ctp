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