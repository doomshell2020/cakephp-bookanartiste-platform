<!----------------------editprofile-strt------------------------>
<section id="edit_profile">
  <div class="container">
    <h2>Featured<span> Job</span></h2>
    <div class="row">


      <div class="tab-content job_box_info">
        <div class="profile-bg m-top-20">
          <?php echo $this->Flash->render(); ?>
          <div id="Personal" class="tab-pane fade in active jobdescription">
            <div class="container m-top-60">
              <?php //////////////-Following------------
              ?>
              <div id="" class="">
                <div class="col-sm-12">
                  <div class="row">
                    <?php
                    $count = 1;
                    foreach ($viewrequirement as $requirement) { //pr($requirement);die;
                      $userid = $requirement['Requirement__user_id'];
                      $role_id = $this->request->session()->read('Auth.User.role_id');
                      $profilepackage = $this->Comman->profilepackage($userid); //pr($profilepackage); die; 
                      $recruiterpackage = $this->Comman->recruiterpackage($userid); //pr($recruiterpackage); die; 
                    ?>
                      <script>
                        $(".jobdescriptionpage<?php echo $count; ?>").click(function() {
                          window.location = $(this).find("a").attr("href");
                          return false;
                        });
                      </script>
                      <div class="col-sm-12 job-card jobdescriptionpage<?php echo $count; ?>">
                        <div class="col-sm-3">
                          <div class="fea-img">
                            <?php if ($profilepackage) {
                              $currentdate = date("Y-m-d h:i:s");
                              $prpackdatestart = date("Y-m-d h:i:s", strtotime($profilepackage['subscription_date']));
                              $prpackdateend = date("Y-m-d h:i:s", strtotime($profilepackage['expiry_date']));
                              if ($prpackdatestart < $currentdate && $prpackdateend > $currentdate) { ?>
                                <img src="<?php echo SITE_URL ?>/job/<?php echo $requirement['Requirement__image']; ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <div class="arist-circle">
                                  <div class="artist-inner-circle">
                                    <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
                                  </div>
                                </div>
                              <?php } ?>
                              <?php } elseif ($recruiterpackage) {
                              $currentdate = date("Y-m-d h:i:s");
                              $rcpackdatestart = date("Y-m-d h:i:s", strtotime($recruiterpackage['subscription_date']));
                              $rcpackdateend = date("Y-m-d h:i:s", strtotime($recruiterpackage['expiry_date']));
                              if ($rcpackdatestart < $currentdate && $rcpackdateend > $currentdate) { ?>
                                <img src="<?php echo SITE_URL ?>/job/<?php echo $requirement['Requirement__image']; ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <div class="arist-circle">
                                  <div class="artist-inner-circle">
                                    <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
                                  </div>
                                </div>

                              <?php }
                            } else { ?>
                              <img src="<?php echo SITE_URL; ?>/images/job.jpg">
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-sm-9">
                          <h3 class="heading"><a href="<?php echo SITE_URL ?>/applyjob/<?php echo $requirement['Requirement__id']; ?>"><?php echo $requirement['Requirement__title']; ?> </a><span> <a href="javascript:void(0)" data-toggle="tooltip" title="Last Date and Time of Application" data-placement="top"><?php echo date('M d,Y h:i:a', strtotime($requirement['Requirement__last_date_app'])); ?> </a></span></h3>

                          <script>
                            $(document).ready(function() {
                              $('[data-toggle="tooltip"]').tooltip();
                            });
                          </script>

                          <p><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $requirement['Requirement__user_id']; ?>"><?php echo $requirement['name']; ?></a> <span class="color-a"> | <?php echo $requirement['Requirement__location']; ?></span></p>
                          <?php $talenttype = $this->Comman->requiredetail($requirement['Requirement__id']); //pr($talenttype); 
                          ?>
                          <p class="selected"><?php
                                              $i = 0;
                                              foreach ($talenttype as $value) {
                                                //pr($value);
                                                if ($i == 0) {
                                                  echo $value['skill']['name'];
                                                } else {
                                                  echo ", " . $value['skill']['name'];
                                                }

                                                $i++;
                                              }
                                              //echo $requirement['Requirement__talent_requirement_description']; 

                                              ?></p>
                          <div class="featured_btns">
                            <div class="icons_btn">
                              <div class="icon-bar srh-icon-bar">

                                <a href="javascript:void(0)" class="fa fa-thumbs-up likejobs" data-job="<?php echo $requirement['Requirement__id'] ?>" id="like<?php echo $requirement['Requirement__id'] ?>" <?php if (in_array($requirement['Requirement__id'], $likejobarray)) { ?> style="color:red" <?php  } ?> alt="Likes Jobs"></a>

                                <meta property="og:title" content="Book an Artiste">
                                <meta property="og:image" content="<?php echo SITE_URL . "/job/" . $requirement['Requirement__image'];  ?>">
                                <meta property="og:url" content="<?php echo SITE_URL ?>/applyjob/<?php echo $requirement['Requirement__id'] ?>" />
                                <meta property="og:description" content="<?php echo $requirement['Requirement__talent_requirement_description'] ?>" />
                                <meta itemprop="image" content="<?php echo SITE_URL . "/job/" . $requirement['Requirement__image'];  ?>">

                                <a href="javascript:void(0)" class="fa fa-share fb profileshare" data-link="http://bookanartiste.com/applyjob/<?php echo $requirement['Requirement__id'] ?>" data-img="<?php echo SITE_URL . "/job/" . $requirement['Requirement__image'];  ?>" data-title="BookAnArtiste"></a>

                                <div class="share_button profileshare-toggle" style="display: none; top:40px;">
                                  <ul class="list-unstyled list-inline text-center">
                                    <li class="pull-left">
                                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/applyjob/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button"
                                        data-href="<?php echo SITE_URL; ?>/applyjob/<?php echo $requirement['Requirement__id']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
                                      </a>
                                    </li>
                                    <li class="pull-left">
                                      <a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/applyjob/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>
                                    </li>
                                    <li class="pull-left">
                                      <a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/applyjob/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                    </li>

                                    <li class="pull-left">
                                      <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/applyjob/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

                                      </a>
                                    </li>


                                    <li class="pull-left"> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a></li>

                                  </ul>
                                </div>

                                <script>
                                  $(document).ready(function() {
                                    $(".profileshare").click(function() {
                                      $(".profileshare-toggle").slideToggle();
                                    });
                                  });
                                </script>

                                <a href="javascript:void(0)" data-toggle="modal" data-target="#reportuser" class="" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a>

                                <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $requirement['Requirement__id'] ?>" id="<?php echo $requirement['Requirement__id'] ?>" <?php if (in_array($requirement['Requirement__id'], $savejobarray)) { ?> style="color:red" <?php  } ?> alt="Save Jobs"></a>


                                <a href="javascript:void(0)" class="fa fa-ban block" data-job="<?php echo $requirement['Requirement__id'] ?>" id="block<?php echo $requirement['Requirement__id'] ?>" <?php if (in_array($requirement['Requirement__id'], $blockjobarray)) { ?> style="color:red" <?php  } ?> alt="Block Jobs"></a>


                              </div>



                              <!--<div id="popoverbtn"></div>-->
                              <!--<button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>-->
                            </div>
                            <?php if ($role_id == TALANT_ROLEID) { ?>
                              <div class="apply_btn">
                                <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $requirement['Requirement__id']; ?>" class="btn btn-default">Apply</a>
                              </div>

                              <div class="quote_btn">
                                <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $requirement['Requirement__id']; ?>" class="btn btn-default">Send Quote</a>
                              </div>
                            <?php } ?>
                          </div>
                        </div>


                      </div>
                    <?php $count++;
                    } ?>



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
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  $('.savejobs').click(function() {
    console.log('test');
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


          $('#' + job + '').css('color', 'red');
        } else {
          $('#' + job + '').css('color', 'white');
        }


      },
      complete: function() {



      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });

  });


  var SITE_URL = '<?php echo SITE_URL; ?>/';
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

  var SITE_URL = '<?php echo SITE_URL; ?>/';
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