<?php foreach ($onlines as $friendss) { //pr($friendss);
  $alldate[] = $friendss['dob'];
  $ethnicityfetch[$friendss['ethniid']] = $friendss['title'];
  $profileactivedetect[] = $friendss['active'];
}
usort($alldate, function ($a, $b) {
  $dateTimestamp1 = strtotime($a);
  $dateTimestamp2 = strtotime($b);

  return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
});

$maxage = $alldate[0];
$date1 = $maxage;
$date2 = date("Y-m-d");
$diff = abs(strtotime($date2) - strtotime($date1));
$maxyears = floor($diff / (365 * 60 * 60 * 24));


$minage = $alldate[count($alldate) - 1];
$date1 = $minage;
$date2 = date("Y-m-d");
$diff = abs(strtotime($date2) - strtotime($date1));
$minyears = floor($diff / (365 * 60 * 60 * 24));



$ethnicityfetch = array_unique($ethnicityfetch);
$profileactivedetect = array_unique($profileactivedetect);
?>


<?php echo $this->element('viewprofile') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="col-sm-9 my-info" id="conatact-all">
  <div class="col-sm-12 prsnl-det">
    <script inline="1">
      //<![CDATA[
      $(document).ready(function() { //alert();
        $("#refinesearch").bind("submit", function(event) { //alert();
          $.ajax({
            async: true,
            data: $("#refinesearch").serialize(),
            dataType: "html",
            success: function(data) { //alert(data);
              $(".prosrrc").html(data);
            },
            type: "POST",
            url: "<?php echo SITE_URL; ?>/profile/refinesearch"
          });
          return false;
        });
      });
      //]]>


      //<![CDATA[
      $(document).ready(function() { //alert();
        $("#searchForm").bind("keyup", function(event) {
          $.ajax({
            async: true,
            data: $("#searchForm").serialize(),
            dataType: "html",

            success: function(data) { //alert(data);

              $(".prosrrc").html(data);
            },
            type: "POST",
            url: "<?php echo SITE_URL; ?>/profile/search"
          });
          return false;
        });
      });
      //]]>


      function opentab() {
        $.ajax({
          async: true,
          data: $("#searchForm").serialize(),
          dataType: "html",

          success: function(data) { //alert(data);

            $(".prosrrc").html(data);
          },
          type: "POST",
          url: "<?php echo SITE_URL; ?>/profile/search"
        });
        return false;
      }
    </script>

    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create('', array('url' => array('controller' => 'profile', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'searchForm', 'class' => 'form-horizontal')); ?>


        <input type="text" class="form-control  chekallser" name="name" placeholder="search...">
        <input type="hidden" id="phonecode" class="form-control" name="tab" value="online">
        <?php echo $this->Form->end(); ?>
      </div>
    </div>

    <div class="talent_tab">

      <ul class="nav nav-pills">

        <li><a data-toggle="" href="<?php echo SITE_URL ?>/profile/allcontacts/<?php echo $profile['user']['id']; ?>" class="cnt" data-action="contacts">Contacts (<?php echo count($friends); ?>)</a></li>
        <?php

        $id = $this->request->session()->read('Auth.User.id');
        if ($profile['user']['id'] > 0 && $profile['user']['id'] != $id) { ?>
          <li><a data-toggle="" href="<?php echo SITE_URL ?>/profile/mutualcontacts/<?php echo $profile['user']['id']; ?>" class="cnt" data-action="mutual">Mutual Contacts (<?php echo count($mutualfrnd); ?>)</a></li>
        <?php } ?>
        <li class="active"><a data-toggle="" href="<?php echo SITE_URL ?>/profile/onlinecontacts/<?php echo $profile['user']['id']; ?>" class="cnt" data-action="online">Online Contacts (<?php echo count($onlines); ?>)</a></li>

        <?php

        if ($profile['user']['id'] > 0 && $profile['user']['id'] == $id) { ?>
          <li><a data-toggle="" href="<?php echo SITE_URL ?>/profile/followingcontacts/<?php echo $profile['user']['id']; ?>" class="cnt" data-action="following">Following (<?php echo count($following); ?>)</a></li>
          <li><a data-toggle="" href="<?php echo SITE_URL ?>/profile/followerscontacts/<?php echo $profile['user']['id']; ?>" class="cnt" data-action="followers">Followers (<?php echo count($followerd); ?>)</a></li>

        <?php } ?>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Refine Contacts<span class="caret"></span></a>
          <ul class="dropdown-menu contact_all_refine">
            <li>
              <div class="col-sm-12">
                <?php echo $this->Form->create('', array('url' => array('controller' => 'profile', 'action' => 'refinesearch'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'refinesearch', 'class' => 'form-horizontal')); ?>

                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Name :</label>
                  </div>

                  <div class="col-sm-12">
                    <input type="text" class="form-control" placeholder="Name" name="name">

                  </div>
                </div>

                <div class="form-group">
                  <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
                  <div class="col-sm-12">
                    <label>AGE :
                      <input type="text" id="amount" readonly style="border:0; background-color:#eeeeee; font-weight:normal;" name="age" class="auto_submit_item">
                    </label>
                  </div>
                  <div class="col-sm-12">
                    <div id="slider-range"></div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Gender :</label>
                  </div>
                  <?php $gen = array('m' => 'Male', 'f' => 'Female', 'o' => 'Other', 'bmf' => 'Male And Female'); ?>
                  <div class="col-sm-12">
                    <?php echo $this->Form->input('gender', array('class' => 'form-control', 'placeholder' => 'State', 'id' => '', 'label' => false, 'empty' => '--Select Gender--', 'options' => $gen, 'selected' => 'selected')); ?>

                  </div>
                </div>


                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Ethnicity :</label>
                  </div>

                  <div class="col-sm-12">

                    <select name="ethnicity" class="form-control">
                      <option value="">--Select Ethnicity--</option>
                      <?php foreach ($ethnicityfetch as $ky => $value) {  ?>
                        <option value="<?php echo $ky ?>"><?php echo $value ?></option>
                      <?php } ?>
                    </select>


                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12">
                    <label>country :</label>
                  </div>

                  <div class="col-sm-12">
                    <?php echo $this->Form->input('country_ids', array('class' => 'form-control', 'id' => 'country_ids', 'label' => false, 'empty' => '--Select Country--', 'options' => $country)); ?>

                  </div>
                </div>


                <div class="form-group">
                  <div class="col-sm-12">
                    <label>State :</label>
                  </div>

                  <div class="col-sm-12">
                    <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'id' => 'state', 'label' => false, 'empty' => '--Select State--', 'options' => $state)); ?>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12">
                    <label>City :</label>
                  </div>

                  <div class="col-sm-12">
                    <?php echo $this->Form->input('city_id', array('class' => 'form-control', 'id' => 'city', 'label' => false, 'empty' => '--Select City--', 'options' => $city)); ?>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Profile Active :</label>
                  </div>

                  <div class="col-sm-12">

                    <select name="profile_active" class="form-control" id="profileactivein">
                      <option value="">--Select Profile Active In--</option>
                      <?php foreach ($profileactivedetect as $ky => $value) {  ?>
                        <option value="<?php echo $value ?>"><?php echo $value ?></option>


                      <?php } ?>
                    </select>

                    <input type="hidden" id="phonecode" class="form-control" name="tab" value="online">
                  </div>
                </div>



                <div class="form-group">

                  <div class="col-sm-12">
                    <input type="submit" id="refinesearch" class="btn btn-info card-title" value="Refine Search">

                  </div>
                </div>
                <?php echo $this->Form->end(); ?>
                <script>
                  $(document).ready(function() {
                    $("#slider-range").slider({
                      range: true,
                      min: <?php echo $minyears;  ?>,
                      max: <?php echo $maxyears;  ?>,
                      values: [15, 28],
                      slide: function(event, ui) {
                        // alert(ui.values[ 0 ]);
                        $("#amount").val("" + ui.values[0] + " - " + ui.values[1]);

                        $("#sliderrangevalueset").val(ui.values[0] + " - " + ui.values[1]);

                      }
                    });

                    $("#amount").val("" + $("#slider-range").slider("values", 0) +
                      " - " + $("#slider-range").slider("values", 1));

                  });
                </script>

                <script>
                  $(document).ready(function() { //alert();
                    $(".cnt").click(function() {
                      var action = $(this).data('action');
                      $.ajax({
                        type: "POST",
                        url: '<?php echo SITE_URL; ?>/profile/tabget',
                        data: ({
                          action: action
                        }),
                        cache: false,
                        success: function(data) { //alert(data);
                          $('#phonecode').val(data);
                          opentab();

                        }
                      });


                    });
                  });
                </script>


              </div>
            </li>

          </ul>

        </li>
      </ul>

      <div class="tab-content">




        <?php //////////////-Onlines------------
        ?>
        <div id="Online" class="tab-pane fade in active">
          <div class="col-sm-12">
            <div class="row">
              <div class="prosrrc">
                <?php foreach ($onlines as $onlinesss) {   ?>
                  <div class="col-sm-3 profile-det">
                    <div class="profile-det-img">
                      <div class="hvr-icon"><input type="checkbox" name="profile[]" class="profilesavecontact"> <a href="#" class="fa fa-remove"></a></div>
                      <a target="_blank" style="Width:100%;" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> ">
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $onlinesss['profile_image'];  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                      </a>
                      <div class="img-top-bar">
                        <?php $subprpa = $this->Comman->subscriprpack($onlinesss['from_id']); ?>
                        <?php if ($subprpa) { ?>
                          <a href="<?php echo SITE_URL; ?>/profilepackage" title="Profile package"><img src="<?php echo SITE_URL; ?>/images/profile-package.png"></a>
                        <?php } ?>
                        <?php $subrepa = $this->Comman->subscrirepack($onlinesss['from_id']); ?>
                        <?php if ($subrepa) { ?>
                          <a href="<?php echo SITE_URL; ?>/recruiterepackage" title="Recruiter package"><img src="<?php echo SITE_URL; ?>/images/recruiter-package-.png"></a>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="allcontact-social">


                      <?php $contactrequest = $this->Comman->contactreqstatus($onlinesss['user_id']); ?>
                      <?php if ($contactrequest == 'R') { ?>
                        <a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus" title="Request Received"></a>

                      <?php } elseif ($contactrequest == 'S') { ?>
                        <a style="color: yellow" id="add_friend<?php echo $onlinesss['user_id']; ?>" class="managefriends fa fa-handshake-o" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $onlinesss['user_id']; ?>" data-action="cancel" title="Cancel Request"></a>

                      <?php } elseif ($contactrequest == 'C') { ?>
                        <a id="add_friend<?php echo $onlinesss['user_id']; ?>" class="managefriends fa fa-handshake-o" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $onlinesss['user_id']; ?>" data-action="remove" title="Cancel Request"></a>

                      <?php } else { ?>
                        <a id="add_friend<?php echo $onlinesss['user_id']; ?>" class="dropdown-toggle managefriends fa fa-user-plus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $onlinesss['user_id']; ?>" data-action="connect"> </a>
                      <?php
                      } ?>

                      <a href="<?php echo SITE_URL; ?>/message/sendmessage/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" data-val="<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" class="sendmessage" data-toggle="modal" data-target="#sendmessage" title="Send Message"><i class="fa fa-envelope"></i></a>
                      <a data-toggle="tooltip" href="javascript:void(0)" class="profileshare<?php echo $onlinesss['user_id']; ?>" data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a>

                      <div class="share_button profileshare-toggle<?php echo $onlinesss['user_id']; ?>" style="display: none;">
                        <ul class="list-unstyled list-inline text-center">
                          <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" class="fb-share-button" data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                            </a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                          </li>
                          <li>
                            <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                          </li>

                          <li>
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">
                            </a>
                          </li>

                          <li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>"></a></li>

                        </ul>
                      </div>

                      <a href="javascript:void(0)" class="likesactive <?php echo (isset($likesuser) && $likesuser > 0) ? 'active' : ''; ?>" id="likeprofile<?php echo $onlinesss['user_id']; ?>" data-toggle="tooltip" data-val="<?php echo ($onlinesss['user_id']) ? $onlinesss['user_id'] : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>
                      <!-- <a href="#" class="fa fa-send"></a> -->

                      <!-- 
<a href="#" class="fa fa-user"></a>
<a href="#" class="fa fa-thumbs-up"></a>
<a href="#" class="fa fa fa-share"></a>
<a href="#" class="fa fa-comment"></a>
     <a href="#" class="fa fa-send"></a>
    <a href="#" class="fa fa-download"></a>
<a href="#" class="fa fa-file"></a>
<a href="#" class="fa fa-ban"></a>
 -->


                    </div>
                    <div class="all-cnt-det">
                      <h5 class="text-center"><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $onlinesss['user_id']; ?>"><?php echo $onlinesss['name']; ?></a></h5>
                      <?php $skills = $this->Comman->userskills($onlinesss['user_id']); ?>
                      <p class="text-center"><a style="color:black;" target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> "><?php if ($skills) {
                                                                                                                                                                        $knownskills = '';
                                                                                                                                                                        foreach ($skills as $skillquote) {
                                                                                                                                                                          if (!empty($knownskills)) {
                                                                                                                                                                            $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                                                                                                                                                                          } else {
                                                                                                                                                                            $knownskills = $skillquote['skill']['name'];
                                                                                                                                                                          }
                                                                                                                                                                        }
                                                                                                                                                                        $output .= str_replace(',', ' ', $knownskills) . ',';
                                                                                                                                                                        //$output.=$knownskills.",";	
                                                                                                                                                                        echo $knownskills;
                                                                                                                                                                      }  ?></a></p>
                      <p class="text-center"><a style="color:black;" target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> "><?php echo $onlinesss['location']; ?></a></p>
                    </div>

                    <div class="btn-book text-center">
                      <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $onlinesss['user_id']; ?>" class="btn btn-default">Book</a>
                      <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $onlinesss['user_id']; ?>" class="btn btn-primary">Ask For Quote</a>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>




      </div>




    </div>
  </div>

</div>
</div>
</div>
</div>



</div>
</div>


</section>






<script>
  /*  Like Profile profile*/
  $('.likesactive').click(function() {
    error_text = "You cannot Like yourself";
    user_id = $(this).data('val');
    if (user_id > 0) {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/profile/likeprofile',
        data: {
          user_id: user_id
        },
        cache: false,
        success: function(data) {
          obj = JSON.parse(data);
          if (obj.error == 1) {
            showerror(error_text);
          } else {
            if (obj.status == 'like') {
              $("#likeprofile" + user_id).addClass('active');
            } else {
              $("#likeprofile" + user_id).removeClass('active');
            }
            $("#totallikes" + user_id).html(obj.count);
          }
        }
      });
    } else {
      showerror(error_text);
    }
  });
</script>

<style type="text/css">
  .likesactive.active {
    color: red !important;
  }

  .share_button.profileshare-toggle<?php echo $friendss['user_id']; ?> {
    position: absolute;
    top: 57%;
    width: 194px;
    background: #fff;
    padding: 6px;
    z-index: 9;
    border: 1px solid #ccc;
    left: 9px;
  }
</style>
<!-------------------------------------------------->