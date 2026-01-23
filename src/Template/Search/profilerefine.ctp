<?php

if ($searchdata) {

  $agearray = array();
  $performancelan = array();
  $languageknownarray = array();
  $paymentfaqarray = array();
  $paymentfaqarray = array();
  $userskillarray = array();
  $querytionarray = array();
  foreach ($searchdata as $key => $value) {


    $birthdate = date("Y-m-d", strtotime($value['dateofbirth']));

    $from = new DateTime($birthdate);
    $to   = new DateTime('today');
    $age = $from->diff($to)->y;
    if (!in_array($age, $agearray))
      $agearray[] = $age;

    $performlanguage = $this->Comman->performainglanguage($value['user_id']);
    //pr($performlanguage);

    foreach ($performlanguage as $perlanguage) {
      $performancelan[$perlanguage['language']['id']] = $perlanguage['language']['name'];
    }

    $languageknown = $this->Comman->languageknown($value['user_id']);


    foreach ($languageknown as $language) {
      $languageknownarray[$language['language']['id']] = $language['language']['name'];
    }

    $paymentfaq = $this->Comman->paymentfaq($value['user_id']);

    foreach ($paymentfaq as $paymentfaq) {
      $paymentfaqarray[$paymentfaq['paymentfequency']['id']] = $paymentfaq['paymentfequency']['name'];
    }
    // pr($paymentfaq); 


    $userskill = $this->Comman->userskills($value['user_id']);

    foreach ($userskill as $userskill) {
      $userskillarray[$userskill['skill']['id']] = $userskill['skill']['name'];
    }
    $Enthicity[$value['ethnicity']] = $value['title'];



    $querytionarray = $this->Comman->vital($value['user_id']);


    //pr($querytionarray);
  }




?>
  <section id="page_search_result">
    <div class="container">
      <h2>Search <span>Result</span></h2>
      <p class="m-bott-50">Here You Can See Search Result</p>
    </div>
    <div class="srch-box">
      <div class="container">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              <label>Talent Name:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for..." value="<?php echo $title ?>">
            </div>
            <div class="col-sm-2">
              <label>Profile Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for..." value="<?php echo $title ?>">
            </div>
            <div class="col-sm-2">
              <label>Word Search:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2">
              <label>Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2">
              <label>Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2 btn_view_al">
              <a href="#" class="btn btn-default btn-block">View All</a>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2"> <a href="#" class="btn btn-default btn-block">Edit Search</a> </div>
            <div class="col-sm-2"> <a href="<?php echo SITE_URL  ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div>
          </div>
        </form>
      </div>
    </div>
    <div class="refine-search">
      <div class="container">
        <div class="row m-top-20">
          <div class="col-sm-3">
            <div class="panel panel-left">
              <h6>Refine Profile Search</h6>
              <form class="form-horizontal" id="telentrefine">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" placeholder="Name" value="<?php echo $title; ?>" name="name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">age </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="age">
                      <option value="0">Select age</option>
                      <?php for ($i = 0; $i < count($agearray); $i++) { ?>

                        <option value="<?php echo  $agearray[$i] ?>"><?php echo  $agearray[$i] ?></option>
                      <?php  } ?>


                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Gender</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="gender">
                      <option value="0">Select Gender</option>
                      <option value="m">Male</option>
                      <option value="f">Female</option>
                      <option value="o">Other</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">

                  <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="performancelan">
                      <option value="0">Select Language</option>
                      <?php foreach ($performancelan as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="language">
                      <option value="0">Select Language</option>
                      <?php foreach ($languageknownarray as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Online Now </label>
                  <div class="col-sm-12">
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio1" value="0">
                      All </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio2" value="1">
                      Online </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio3" value="2">
                      Offline </label>
                  </div>
                </div>
                <?php $vitalstatic = array(); //pr($querytionarray); 
                ?>
                <?php if ($querytionarray) {   ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label">Vital Statistics parameters </label>
                    <?php $i = 0;
                    foreach ($querytionarray as $key => $value) {
                      if ($value['option_value_id'] != 0) {   ?>


                        <p class="prc_sldr">
                          <label for="amount"><?php echo  $value['vque']['question']; ?></label>

                        </p>

                        <div class="col-sm-12">
                          <select class="form-control" name="vitalstats[<?php echo  $i; ?>]">
                            <option value="0">Select <?php echo  $value['vque']['question']; ?> </option>


                            <option value="<?php echo  $value['voption']['id']; ?>"><?php echo  $value['voption']['value']; ?></option>



                          </select>
                        </div>
                    <?php $i++;
                      }
                    } ?>
                  </div>
                <?php }  ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="activein">
                      <option value="0">Select Active in</option>
                      <option value="5"> 5 days</option>
                      <option value="10">10 days</option>
                      <option value="15">15 days</option>
                      <option value="20">20 days</option>
                      <option value="25">25 days</option>
                      <option value="30">30 days</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="paymentfaq">
                      <option value="0">Select Payment Frequency </option>
                      <?php foreach ($paymentfaqarray as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="skill">
                      <option value="0">Select Talent Type</option>
                      <?php foreach ($userskillarray as $key => $skillvalue) { ?>
                        <option value="<?php echo $key ?>"> <?php echo  $skillvalue; ?> </option>

                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Ethnicity</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="ethnicity">
                      <option value="0">Select Ethnicity </option>
                      <?php foreach ($Enthicity as $key => $Enthicity) { ?>
                        <option value="<?php echo $key ?>"> <?php echo  $Enthicity; ?> </option>

                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group Review">
                  <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>
                  <div class="col-sm-12">
                    <fieldset id='demo6' class="rating">





                      <input class="stars" type="radio" id="starr310" name="r3" value="10" />
                      <label class="review full" for="starr310" title="Excellent"></label>

                      <input class="stars" type="radio" id="starr39half" name="r3" value="9.5" />
                      <label class="review half" for="starr39half" title="Excellent"></label>

                      <input class="stars" type="radio" id="starr39" name="r3" value="9" />
                      <label class="review full" for="starr39" title="Excellent"></label>

                      <input class="stars" type="radio" id="starr38half" name="r3" value="8.5" />
                      <label class="review half" for="starr38half" title="Good"></label>

                      <input class="stars" type="radio" id="starr38" name="r3" value="8" />
                      <label class="review full" for="starr38" title="Good"></label>


                      <input class="stars" type="radio" id="starr37half" name="r3" value="7.5" />
                      <label class="review half" for="starr37half" title="Good"></label>

                      <input class="stars" type="radio" id="starr37" name="r3" value="7" />
                      <label class="review full" for="starr37" title="Good"></label>

                      <input class="stars" type="radio" id="starr36half" name="r3" value="6.5" />
                      <label class="review half" for="starr36half" title="Average"></label>


                      <input class="stars" type="radio" id="starr36" name="r3" value="6" />
                      <label class="review full" for="starr36" title="Average"></label>

                      <input class="stars" type="radio" id="starr35half" name="r3" value="5.5" />
                      <label class="review half" for="starr35half" title="Average"></label>

                      <input class="stars" type="radio" id="starr35" name="r3" value="5" />
                      <label class="review full" for="starr35" title="Average"></label>

                      <input class="stars" type="radio" id="starr34half" name="r3" value="4.5" />
                      <label class="review half" for="starr34half" title="Below average "></label>

                      <input class="stars" type="radio" id="starr34" name="r3" value="4" />
                      <label class="review full" for="starr34" title="Below average "></label>

                      <input class="stars" type="radio" id="starr33half" name="r3" value="3.5" />
                      <label class="review half" for="starr33half" title="Below average "></label>

                      <input class="stars" type="radio" id="starr33" name="r3" value="3" />
                      <label class="review full" for="starr33" title="Below average "></label>

                      <input class="stars" type="radio" id="starr32half" name="r3" value="2.5" />
                      <label class="review half" for="starr32half" title="Bad"></label>

                      <input class="stars" type="radio" id="starr32" name="r3" value="2" />
                      <label class="review full" for="starr32" title="Bad"></label>

                      <input class="stars" type="radio" id="starr31half" name="r3" value="1.5" />
                      <label class="review half" for="starr31half" title="Bad"></label>

                      <input class="stars" type="radio" id="starr31" name="r3" value="1" />
                      <label class="review full" for="starr31" title="Bad"></label>

                      <input class="stars" type="radio" id="starr3half" name="r3" value="0.5" />
                      <label class="review half" for="starr3half" title="Bad"></label>
                    </fieldset>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Working Style</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="workingstyle">
                      <option value="0">Select Working Style</option>
                      <option value="P">Professional</option>
                      <option value="A">Amateur</option>
                      <option value="PT">Part time</option>
                      <option value="H">Hobbyist</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12"> <a href="#" class="btn btn-default">Back to Search Result </a>

                    <input type="submit" value="Refine" class="btn btn-default">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-9" id="data">
            <div class="panel-right">



              <?php

              foreach ($searchdata as $value) {



                if (!in_array($value['id'], $_SESSION['profilesearch'])) {
              ?>


                  <div class="member-detail  box row">
                    <div class="col-sm-3">
                      <div class="member-detail-img"> <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                        <div class="img-top-bar"> <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user']['id'] ?>" class="fa fa-user"></a> </div>
                      </div>
                    </div>
                    <div class="col-sm-9 boc_gap">
                      <div class="row">
                        <ul class="col-sm-4 member-info">
                          <li>Name</li>
                          <li>Gender</li>
                          <li>Talent</li>
                          <li>Location</li>
                          <li>Experience</li>
                        </ul>
                        <ul class="col-sm-2">
                          <li>:</li>
                          <li>:</li>
                          <li>:</li>
                          <li>:</li>
                          <li>:</li>
                        </ul>
                        <ul class="col-sm-6">
                          <li><?php echo $value['name'] ?></li>
                          <li><?php
                              switch ($value['gender']) {
                                case 'm':
                                  echo "Male";
                                  break;
                                case 'f':
                                  echo "FeMale";
                                  break;
                                case 'o':
                                  echo "Other";
                                  break;
                              }

                              ?></li>
                          <li><?php

                              $userskill = $this->Comman->userskills($value['user_id']);

                              foreach ($userskill as $userskill) {
                                echo  $skill = $userskill['skill']['name'] . ",";
                              }
                              ?></li>
                          <li><?php echo $value['current_location'] ? $value['current_location'] : '-';  ?></li>
                          <li><?php if ($value['performing_year']) {
                                echo date('Y') - $value['performing_year'];
                                echo "Years";
                              } else {
                                echo "-";
                              };
                              ?></li>

                        </ul>
                      </div>
                      <?php if ($bookjob != "") { //pr($bookjob);
                      ?>
                        <span class="bookingmsg"><strong>You have Booked <?php echo $bookjob['user']['user_name']; ?> on <?php echo  date("Y-m-d H:s:i", strtotime($bookjob['created'])); ?></strong> </span>
                      <?php  } else { ?>
                        <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['id']  ?>" class="btn btn-default ad">Book Now</a>
                        <?php if ($askquote != "") { ?>
                          <br><span class="bookingmsg"><strong>You have Ask for Quote Sent <?php echo $askquote['user']['user_name']; ?> on <?php echo  date("Y-m-d H:s:i", strtotime($askquote['created'])); ?></strong> </span>

                        <?php } else { ?>

                          <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['id']  ?>" class="btn btn-default qot">Ask For Quote</a>
                        <?php } ?>
                      <?php }  ?>


                    </div>
                    <div class="icon-bar">
                      <a href="#" class="fa fa-thumbs-up"></a>
                      <a href="#" class="fa fa-share"></a>
                      <a href="#" class="fa fa-envelope"></a>
                      <a href="#" class="fa fa-paper-plane-o"></a>
                      <a href="#" class="fa fa-floppy-o"></a>
                      <a href="#" class="fa fa-download"></a>
                      <a href="#" class="fa fa-file-text-o"></a>
                      <a href="#" class="fa fa-ban"></a>
                    </div>
                    <div class="box_hvr_checkndlt">
                      <span class="pull-left"><input type="checkbox" value=""></span>

                      <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </div>
                  </div>



              <?php  }
              } ?>












              <script>
                $(document).ready(function() {
                  var site_url = '<?php echo SITE_URL; ?>/';
                  $('.delete_jobalerts').click(function() {
                    var profile_id = $(this).data('val');
                    // $("#"+job_id).remove();
                    var job_action = $(this).data('action');
                    $.ajax({
                      type: "post",
                      url: site_url + 'myalerts/alertsjob',
                      data: {
                        job: profile_id,
                        action: job_action
                      },
                      success: function(data) {
                        $("." + job_id).remove();
                      }

                    });


                  });
                });
              </script>


              <script type="text/javascript">
                var SITE_URL = '<?php echo SITE_URL; ?>/';
                $('#telentrefine').submit(function(event) {

                  event.preventDefault();
                  $.ajax({
                    dataType: "html",
                    type: "post",
                    evalScripts: true,
                    url: SITE_URL + 'search/Profilerefine',
                    data: $('#telentrefine').serialize(),
                    beforeSend: function() {
                      $('#clodder').css("display", "block");

                    },

                    success: function(response) {


                      if (response == "<h3 align='center'>No Talent's Found</h3>") {
                        $('#data').html(response)
                      } else {
                        $('#page_search_result').html(response)
                      }


                    },
                    complete: function() {
                      $('#clodder').css("display", "none");


                    },
                    error: function(data) {
                      alert(JSON.stringify(data));

                    }

                  });

                });
              </script>

            </div>
            <div class="row">
              <div class="col-sm-12"><a href="#" class="btn btn-default" data-toggle="modal" data-target="#saveprofilerefinetamplate"> Save Search Result </a></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

<?php  } else {
  echo "<h3 align='center' style='margin-top:350px'>No Talent's Found</h3>";
}   ?>



<div class="modal fade" id="saveprofilerefinetamplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Template </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" id="saverefinejobs" style="display:none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> Your Template is saved Successfully
        </div>
        <?php if ($_SESSION['Profilerefinedata']) { ?>
          <form id="savesearchresulttem" onsubmit="return profilesearchsave(this)">
            <div class="form-group">
              <label for="exampleInputEmail1">Enter Tamplate Name</label>
              <input type="text" class="form-control" placeholder="Enter Tamplate Name" name="template" id="template">
            </div>

            <button type="submit" class="btn btn-primary" <?php if ($_SESSION['Profilerefinedata']) { ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?>>Save</button>
      </div>
      <div class="modal-footer">


      </div>

      </form>
    <?php } else { ?>

      <div class="alert alert-secondary" role="alert">
        Nothing to Save
      </div>

    <?php } ?>


    </div>
  </div>
</div>




<script>
  function profilesearchsave(x) {
    //alert(x.template.value);
    event.preventDefault();

    var tem = x.template.value;

    var w = '1';

    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/saveprosearchresult',
      data: {
        template: tem,
        savewhere: w
      },
      beforeSend: function() {
        $('#clodder').css("display", "block");

      },

      success: function(response) {
        //alert(response);

        var myObj = JSON.parse(response);

        if (myObj.success == 1) {
          $('#saverefinejobs').css("display", "block");
        }


      },
      complete: function() {
        $('#clodder').css("display", "none");


      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });


  }
</script>