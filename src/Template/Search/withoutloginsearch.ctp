<?php
// echo $title; die;
//pr($continue);
//$haveskill=$this->Comman->userprofileskills(); 
?>

<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
<div id="page-wrapper">
  <?php if ($searchdata) { ?>

    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <section id="page_search-job_result">

      <?php
      if ($month != 0 && $daily != 0 && $quote != 0) { ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
            </div>

            <div class="pull-right top-three-but">
              <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send">Send Quote</button>
            </div>
          </div>
        </div>

      <?php } ?>

      <?php if ($month == 0 && $daily == 0 && $quote == 0) {  ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
            </div>
          </div>
        </div>
      <?php } ?>



      <?php if ($month != 0 && $daily == 0 && $quote == 0) {  ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
            </div>
          </div>
        </div>
      <?php } ?>


      <?php if ($month == 0 && $daily != 0 && $quote != 0) {  ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
            </div>
            <div class="pull-right top-three-but">
              <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send">Send Quote</button>
            </div>
          </div>
        </div>
      <?php } ?>



      <?php if ($month == 0 && $daily != 0 && $quote == 0) { ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
            </div>

            <div class="pull-right top-three-but">
              <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send">Send Quote</button>
            </div>
          </div>
        </div>

      <?php } ?>

      <?php if ($month != 0 && $daily == 0 && $quote != 0) { ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
            </div>
            <div class="pull-right top-three-but">
              <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send">Send Quote</button>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if ($month != 0 && $daily != 0 && $quote == 0) { ?>
        <div id="aplybutton" style="display:none;">
          <div class="container">
            <div class="pull-left top-three-but">
              <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
            </div>

            <div class="pull-right top-three-but">
              <!-- <button type="submit"  value="2" class="btn btn-primary m-right-20 actbut send" >Send Quote (Paid)</button>-->
            </div>
          </div>
        </div>

      <?php } ?>


      <h2>Job <span>Search Results</span></h2>
      <p class="m-bott-50">Here You Can Search Job Result with View, Refine and Take Action on Job Search Results</p>
      <div class="alert alert-warning alert-dismissible singapl" style="display: none">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span id="singleapply"></span>
      </div>

      <div class="alert alert-success alert-dismissible fade in" style="display:none" id="singleskillnumber">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h5 id="numberofapp"></h5>
      </div>
      <?php $c = 0;

      $count = 0;
      foreach ($_SESSION['advancejobsearch'] as $key => $value) {
        //echo $key;
        if ($key == "skillshow" || $key == "unit" || $key == "from" || $key == "optiontype") {
        } else {
          if ($value) {
            if ($key == "city_id") {

              if ($value['0']) {
                $count++;
              }
            } else {
              $count++;
            }
          }
        }
      }

      ?>

</div>

<?php $c = 0;  ?>
<div class="srch-box">
  <div class="container">
    <?php if ($title) { ?>
      <div class="col-sm-2">
        <label for="" class=" control-label">Word Search:</label>
        <input type="text" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" readonly>
      </div>
    <?php } ?>

    <?php if ($count > 5) { ?> <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip" style="    position: absolute;
   right: 5px;
   top: 243px;">Show Less</a> <?php } ?>


    <?php if (empty($_SESSION['advancejobsearch']) && $_SESSION['advancejobsearch']['optiontype'] != 1) { ?>

    <?php } ?>
    <div class="row" id="panel">
      <form class="form-horizontal">
        <?php  ?>
        <div class="form-group">
          <?php if ($_SESSION['advancejobsearch']['keyword']) { ?>
            <div class="col-sm-2">

              <label for="" class=" control-label">Job Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo $_SESSION['advancejobsearch']['keyword'];   ?>" readonly>
            </div>

          <?php } ?>
          <?php if ($_SESSION['advancejobsearch']['eventshow']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Event:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo $_SESSION['advancejobsearch']['eventshow'];  ?>" readonly>
            </div>

          <?php } ?>


          <?php if ($_SESSION['advancejobsearch']['skillshow']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['skillshow'];   ?>" readonly>
            </div>

          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['locationlat']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['locationlat'];  ?>" readonly>
            </div>
          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['within']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">within:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['within'];  ?>" readonly>
            </div>
          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['unit'] && $_SESSION['advancejobsearch']['within']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">unit:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['unit'];  ?>" readonly>
            </div>
          <?php } ?>


          <?php if ($_SESSION['advancejobsearch']['gender']) { ?>
            <div class="col-sm-2">

              <label for="" class=" control-label">Gender:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly value="<?php if ($_SESSION['advancejobsearch']) { ?> <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['gender']); $i++) {
                                                                                                                                                      if ($_SESSION['advancejobsearch']['gender'][$i] == "m") echo "Male,";
                                                                                                                                                      else if ($_SESSION['advancejobsearch']['gender'][$i] == "f") echo "Female,";
                                                                                                                                                      else if ($_SESSION['advancejobsearch']['gender'][$i] == "bmf") echo "Both Male and Female";
                                                                                                                                                      else if ($_SESSION['advancejobsearch']['gender'][$i] == "a") echo "Any,";
                                                                                                                                                    } ?> <?php } ?>">
            </div>
          <?php } ?>
          <?php if ($_SESSION['advancejobsearch']['Paymentfequency']) { ?>

            <div class="col-sm-2">
              <label for="" class=" control-label">Payment offer :</label>
              <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['Paymentfequency']); $i++) {

                $data = $this->Comman->mypaymentfaq($_SESSION['advancejobsearch']['Paymentfequency'][$i]);
                $payment[] = $data['name'];
              } ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo implode(",", $payment); ?>" readonly>
            </div>

          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['country_id']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Country:</label>
              <?php $countrydata = $this->Comman->cnt($_SESSION['advancejobsearch']['country_id']); ?>
              <input type="text" class="form-control" id="inputEmail3" value="<?php if ($countrydata) {
                                                                                echo $countrydata['name'];
                                                                              } ?>" readonly />
            </div>

          <?php } ?>
          <?php if ($_SESSION['advancejobsearch']['state_id']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">State :</label>
              <?php $statedata = $this->Comman->state($_SESSION['advancejobsearch']['state_id']);  ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($statedata) {
                                                                                                echo $statedata['name'];
                                                                                              } ?>" readonly>
            </div>
          <?php } ?>


          <?php if ($_SESSION['advancejobsearch']['city_id']['0'] != "") { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">City:</label>

              <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['city_id']); $i++) {

                $citydata = $this->Comman->city($_SESSION['advancejobsearch']['city_id'][$i]);

                $cityarray[] = $citydata['name'];
              } ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo implode(",", $cityarray); ?>" readonly>
            </div>
          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['role_id']) { ?>


            <div class="col-sm-2">
              <label for="" class=" control-label">Posted by :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                if ($_SESSION['advancejobsearch']['role_id'] == 2) {
                                                                                                  echo "Artists";
                                                                                                } elseif ($_SESSION['advancejobsearch']['role_id'] == 3) {
                                                                                                  echo "Non-Telant";
                                                                                                }
                                                                                              } ?>" readonly>
            </div>
          <?php } ?> <?php if ($_SESSION['advancejobsearch']['recname']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Posted by name :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['recname'];
                                                                                              } ?>" readonly>
            </div>
          <?php } ?>

          <?php if ($_SESSION['advancejobsearch']['event_from_date']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Event From :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['event_from_date'];
                                                                                              } ?>" readonly>
            </div>
          <?php  } ?>


          <?php if ($_SESSION['advancejobsearch']['time']) {   ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Continuous Job</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']['time'] == "Y") {
                                                                                                echo "YES";
                                                                                              } else if ($_SESSION['advancejobsearch']['time'] == "a") {
                                                                                                echo "All";
                                                                                              } else {
                                                                                                echo "NO";
                                                                                              }  ?>" readonly>
            </div>
          <?php  } ?>
          <?php if ($_SESSION['advancejobsearch']['event_to_date']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Event To :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['event_to_date'];
                                                                                              } ?>" readonly>
            </div>
          <?php  } ?>

          <?php if ($_SESSION['advancejobsearch']['talent_required_fromdate']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Talent To :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['talent_required_fromdate'];
                                                                                              } ?>" readonly>
            </div>
          <?php  } ?>

          <?php if ($_SESSION['advancejobsearch']['talent_required_todate']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Talent From :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['talent_required_todate'];
                                                                                              } ?>" readonly>
            </div>
          <?php  } ?>


          <?php if ($_SESSION['advancejobsearch']['last_date_app']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Last Date After :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['last_date_app'];
                                                                                              } ?>" readonly>
            </div>
          <?php  } ?>

          <?php if ($_SESSION['advancejobsearch']['last_date_appbefore']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Last Date Before :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                echo $_SESSION['advancejobsearch']['last_date_appbefore'];
                                                                                              } ?>" readonly>
            </div>

          <?php  } ?>
        </div>


        <div class="form-group">

        </div>

      </form>

    </div>


    <div class="col-sm-2">
      <a href="<?php echo SITE_URL ?>/search/advanceJobsearch/1" class="btn btn-default btn-block" <?php if (empty($_SESSION['advancejobsearch']['name']) && $_SESSION['advancejobsearch']['optiontype'] == 1) { ?> style="margin-left: 30px" <?php } ?>>Edit Search</a>
    </div>
    <div class="col-sm-2">
      <a href="<?php echo SITE_URL ?>/search/advanceJobsearch" class="btn btn-primary btn-block" <?php if (empty($_SESSION['advancejobsearch']['name']) && $_SESSION['advancejobsearch']['optiontype'] == 1) { ?> style="margin-left: 10px" <?php } ?>>Advance Search</a>
    </div>
    <div class="col-sm-2">
      <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/withoutloginsearch/reset" class="btn btn-primary btn-block">Refine Search</a>
    </div>
  </div>


  <div id="update">

    <?php  //if($haveskill){ 
    ?>
    <div class="refine-search m-top-60">
      <div class="container">
        <!-- <?php if ($month == 0) { ?>
                <a href="http://bookanartiste.com/package/allpackages/profilepackage/" style="margin-left:33%">Your Month Or Daily Limit Exceed For Apply Job click here to upgrade Your package</a>

              <?php } else if ($daily == 0) { ?>
                <a href="http://bookanartiste.com/package/allpackages/profilepackage/" style="margin-left:33%">Your Month Or Daily Limit Exceed For Apply Job click here to upgrade Your package</a>

              <?php  } else if ($quote == 0) { ?>
                <a href="http://bookanartiste.com/package/allpackages/profilepackage/" style="margin-left:33%">Your Quote send Limit Exceed For Apply Job click here to upgrade Your package</a>
              <?php } ?> -->
        <div class="profile-bg">
          <div class="clearfix m-top-20">
            <div class="col-sm-3">
              <div class="panel panel-left">
                <h6>Refine Job Search</h6>
                <form class="form-horizontal" action="<?php echo SITE_URL ?>/search/withoutloginsearch" method="get" id="myajexfrom">
                  <input type="hidden" name="refine" value="1" />

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label"> Job type </label>
                    <div class="col-sm-12">
                      <label class="">
                        <input type="radio" name="time" id="inlineRadio2" value="a" class="auto_submit_item" <?php if ($time == "a") {
                                                                                                                echo "checked";
                                                                                                              } else {
                                                                                                                echo "checked";
                                                                                                              } ?>>
                        All </label><br>
                      <label class="">
                        <?php if (in_array("N", $continue)) { ?>
                          <input type="radio" name="time" id="inlineRadio1" value="N" class="auto_submit_item" <?php if ($time == "N") {
                                                                                                                  echo "checked";
                                                                                                                } ?>>
                          Fixed Time Jobs</label>
                    <?php } ?>

                    <?php if (in_array("Y", $continue)) { ?>
                      <label class="">
                        <input type="radio" name="time" id="inlineRadio2" value="Y" class="auto_submit_item" <?php if ($time == "Y") {
                                                                                                                echo "checked";
                                                                                                              } ?>>
                        Continuous Job </label>

                    <?php } ?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label">Currency </label>
                    <div class="col-sm-12">
                      <select class="form-control auto_submit_item" name="currency[]" multiple="">
                        <option value="0">Select Currency</option>
                        <?php $i = 0;
                        foreach ($currencyarray as $key => $value) { ?>
                          <option value="<?php echo $key ?>" <?php if (in_array($key, $currencyarrayset)) {
                                                                echo "selected";
                                                              } ?>> <?php echo  $value; ?> </option>

                        <?php $i++;
                        } ?>



                      </select>
                    </div>
                  </div>

                  <input type="hidden" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" name="keyword">
                  <div class="form-group salry">
                    <label for="inputEmail3" class="col-sm-12 control-label">Salary </label>
                    <p class="prc_sldr">
                      <label for="amount">Salary</label>
                      <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="salaryrange" class="auto_submit_item">
                    </p>
                    <div id="slider-range"></div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label">Payment Offered (Per) </label>
                    <div class="col-sm-12">

                      <select class="form-control auto_submit_item" name="payment[]" multiple="">
                        <option value="0">Select Payment</option>
                        <?php $i = 0;
                        foreach ($payemntfaq as $key => $paymentfaqvalue) { ?>
                          <option value="<?php echo $key ?>" <?php if (in_array($key, $paymentselarray)) {
                                                                echo "selected";
                                                              } ?>> <?php echo  $paymentfaqvalue; ?> </option>

                        <?php $i++;
                        } ?>
                      </select>
                    </div>
                  </div>
                  <?php if ($_SESSION['advancejobsearch']['within']) { ?>
                    <input type="hidden" value="<?php echo $_SESSION['advancejobsearch']['within'] ?>" name="within" />
                  <?php } ?>
                  <?php if ($_SESSION['advancejobsearch']['locationlat']) { ?>
                    <input type="hidden" value="<?php echo $_SESSION['advancejobsearch']['locationlat'] ?>" name="locationlat" />
                  <?php } ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label">Location </label>
                    <div class="col-sm-12">

                      <select class="form-control auto_submit_item" name="location[]" multiple="">
                        <option value="1">Select Location</option>
                        <?php $i = 0;
                        foreach ($location as $key => $locationvalue) { ?>
                          <option value="<?php echo $key ?>" <?php if (in_array($key, $loc)) {
                                                                echo "selected";
                                                              } ?>> <?php echo  $locationvalue; ?> </option>

                        <?php $i++;
                        } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label auto_submit_item">Talent Type</label>
                    <div class="col-sm-12">
                      <select class="form-control  auto_submit_item" name="telenttype[]" multiple="">
                        <option value="0">Select Talent Type</option>
                        <?php $i = 0;
                        foreach ($talentype as $key => $talentypevalue) { ?>
                          <option value="<?php echo $key ?>" <?php if (in_array($key, $ttype)) {
                                                                echo "selected";
                                                              } ?>> <?php echo  $talentypevalue; ?> </option>

                        <?php $i++;
                        } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label auto_submit_item">Event Type</label>
                    <div class="col-sm-12">
                      <select class="form-control  auto_submit_item" name="eventtype[]" multiple="">
                        <option value="0">Select Event</option>
                        <?php $i = 0;
                        foreach ($eventtype as $key => $eventtypevalue) { ?>

                          <option value="<?php echo $key ?>" <?php if (in_array($key, $eventtypearray)) {
                                                                echo "selected";
                                                              } ?>> <?php echo  $eventtypevalue; ?> </option>

                        <?php $i++;
                        } ?>
                      </select>
                    </div>
                  </div>

                  <?php if ($backtorefine == 1) { ?>

                    <a href=" <?php echo SITE_URL; ?>/search/withoutloginsearch?<?php echo $this->request->session()->read('backtorefinesearch'); ?>" class="btn btn-default">Back to Search Result </a>
                  <?php } else {  ?>
                    <a href="javascript:void(0)" class="btn btn-default" ?>Back to Search Result </a>
                  <?php } ?>
                  <input type="hidden" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" name="keyword">



                  <div class="form-group">
                    <div class="col-sm-12">

                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-9" id="nof">
              <div class="panel panel-right">
                <div class="clearfix job-box">



                  <?php if (!empty($targetlocation) && !empty($targetwithin)) { ?>
                    <form id="multiple" method="POST">

                      <input type="hidden" id="btuuonpress" name="buttonpresstype" value="5" />
                      <?php
                      $date = date('Y-m-d H:i:s');
                      $max = 0;
                      $min = 0;
                      $salryarray = array();
                      $jobarray = array();
                      $isdata = 0;
                      foreach ($searchdata as $value) {
                        // pr($value['Posting_type']);
                        // exit;
                        // pr($value['role_id']);
                        // exit;

                        // if ($value['role_id'] == 3) {
                        //   pr($value);
                        //   // exit;

                        // }

                        // $picon = $this->Comman->profilepack($value['p_package']);
                        // $ricon = $this->Comman->recpack($value['r_package']);

                        $riconPaid = null;
                        $picon = $this->Comman->profilepack($value['profile_package_id']);
                        if ($value['is_paid_post'] == 'Y') {
                          $riconPaid = $this->Comman->recpack($value['req_package_id'], 'Y');
                        } else {
                          $ricon = $this->Comman->recpack($value['req_package_id']);
                        }
                        // pr($ricon);
                        // exit;
                        // $location=$this->Comman->get_driving_information("",$value['location']); 
                        //  $min=$value['payment_amount']; 

                        if (!in_array($value['id'], $jobarray)) {

                          $jobarray[] = $value['id'];


                          if (!in_array($value['id'], $_SESSION['jobsearchdata'])) {


                            if ($date < $value['last_date_app']) {



                              $locationcl = $this->Comman->get_driving_information($targetlocation, $value['location']);
                              if ($claculationunit == "mi") {
                                $dis = (int)(preg_replace("/[a-zA-Z]/", "", $locationcl)) * (0.621371);
                              } else {
                                $dis = (int)preg_replace("/[a-zA-Z]/", "", $locationcl);
                              }
                              //$distance=(int)preg_replace("/[a-zA-Z]/","",$locationcl);
                              if ($dis <= $targetwithin) {
                                $isdata = 1;
                      ?>



                                <div class="col-sm-12  box job-card">

                                  <div class="check_hide">

                                    <?php
                                    $appliedjob = $this->Comman->appliedjob($value['id']);

                                    $sentquote = $this->Comman->sentquote($value['id']);

                                    //pr($sentquote);
                                    if (!$appliedjob) {
                                      if (!$sentquote) {
                                    ?>
                                        <input type="checkbox" name="job[]" value="<?php echo $value['id'] ?>" class="chkbox sendquoute" data-val="<?php echo $value['id'] ?>" id="mycke<?php echo $value['id']; ?>">
                                    <?php }
                                    } ?>
                                    <div class="remove-top">


                                      <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </div>
                                  </div>


                                  <div class="col-sm-3">
                                    <div class="profile-det-img1">
                                      <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"> 
                                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                      </a>

                                      <!-- <div class="img-top-bar">

                                        <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"></a>
                                        <?php
                                        if ($value['role_id'] == 2) { ?>

                                          <a href="<?php echo SITE_URL ?>#col_package">
                                            <img src="<?php echo SITE_URL ?>/img/<?php echo $picon['icon'] ?>" style="height: 2%; width: 15%" title="<?php echo $picon['name'] ?> Profile" />

                                            <img src="<?php echo SITE_URL ?>/img/<?php echo $ricon['icon'] ?>" style="height: 2%; width: 15%" title="<?php echo $ricon['title'] ?> Recruiter" />

                                          </a>

                                        <?php } else { ?>
                                          <span style="color:#fff"><?php echo ($value['Posting_type'] != 'Free Posting') ? 'Paid Posting' : 'Free Posting' ?></span>
                                        <?php } ?>
                                      </div> -->

                                      <div class="img-top-bar">
                                        <!-- <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"></a> -->

                                        <?php if ($ricon['id'] != 1 && $value['is_paid_post'] == 'N') : ?>
                                          <img src="<?= SITE_URL ?>/img/<?= $picon['icon'] ?>"
                                            style="height: 2%; width: 15%"
                                            title="<?= $picon['name'] ?> Profile Package" />

                                          <img src="<?= SITE_URL ?>/img/<?= $ricon['icon'] ?>"
                                            style="height: 2%; width: 15%"
                                            title="<?= ($riconPaid['name'] && $value['is_paid_post'] == 'Y')
                                                      ? $riconPaid['name'] . ' Requirement Package'
                                                      : $ricon['title'] . ' Recruiter Package' ?>" />
                                        <?php else : ?>
                                          <span style="color:#fff">
                                            <?= ($value['is_paid_post'] == 'Y') ? 'Paid Posting' : 'Free Posting' ?>
                                          </span>
                                        <?php endif; ?>


                                      </div>

                                    </div>
                                  </div>
                                  <div class="col-sm-9">
                                    <h3 class="heading"><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"><?php echo $value['title'] ?></a><span title="Last date of application"><?php echo date('d M Y', strtotime($value['last_date_app']));  ?></span></h3>

                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="javascript:void(0)" class="fa fa-globe"></a><?php echo $value['location'] ?></li>
                                      <li><a href="<?php echo SITE_URL ?>/viewprofile/<?php echo  $value['user_id'] ?>" class="fa fa-user"> </a> Posted by
                                        <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo  $value['user_id'] ?>"><?php echo $value['user_name'] ?></a>
                                      </li>

                                      <li><a href="#" class="fa fa-american-sign-language-interpreting"></a>

                                        <?php

                                        $skill = $this->Comman->requimentskill($value['id']);
                                        //pr($skill);

                                        ?>
                                        <?php
                                        $count = 0;

                                        foreach ($skill as $vacancy) {

                                          if ($vacancy['skill']['name']) {
                                            $count++;
                                          }

                                          echo  $vacancy['skill']['name'];
                                          echo ",";
                                        }  ?>


                                      </li>

                                      <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['eventname'] ?></li>
                                    </ul>
                                    <div class="row">
                                      <div class="col-sm-8">

                                        <a class='btn btn-default' href="<?php echo SITE_URL; ?>/login
                                         ">Apply</a>

                                      </div>

                                      <div class="col-sm-4 text-right">
                                        <div class="icon-bar srh-icon-bar">

                                          <a href="<?php echo SITE_URL; ?>/login" class="fa fa-thumbs-up"></a>
                                          <a href="<?php echo SITE_URL; ?>/login" title="Share" class="fa fa-share"></a>
                                          <a href="<?php echo SITE_URL; ?>/login" title="Report"><i class="fa fa-flag"></i></a>
                                          <a href="<?php echo SITE_URL; ?>/login" title="Save Jobs" class="fa fa-floppy-o"></a>
                                          <a href="<?php echo SITE_URL; ?>/login" title="Block Jobs" class="fa fa-ban block"></a>

                                        </div>


                                      </div>
                                    </div>
                                  </div>
                                </div>


                      <?php    }
                            }
                          }
                        }
                      }  ?>


                    </form>


                  <?php } else { ?>

                    <form id="multiple" method="POST">

                      <input type="hidden" id="btuuonpress" name="buttonpresstype" value="5" />
                      <?php
                      $date = date('Y-m-d H:i:s');
                      $max = 0;
                      $min = 0;
                      $salryarray = array();
                      $jobarray = array();
                      $isdata = 0;

                      foreach ($searchdata as $value) {

                        // $picon = $this->Comman->profilepack($value['p_package']);
                        // $ricon = $this->Comman->recpack($value['r_package']);
                        $riconPaid = null;
                        $picon = $this->Comman->profilepack($value['profile_package_id']);
                        if ($value['is_paid_post'] == 'Y') {
                          $riconPaid = $this->Comman->recpack($value['req_package_id'], 'Y');
                        } else {
                          $ricon = $this->Comman->recpack($value['req_package_id']);
                        }

                        // $location=$this->Comman->get_driving_information("",$value['location']); 
                        //  $min=$value['payment_amount']; 

                        if (!in_array($value['id'], $jobarray)) {

                          $jobarray[] = $value['id'];


                          if (!in_array($value['id'], $_SESSION['jobsearchdata'])) {


                            if ($date < $value['last_date_app']) {

                              $isdata = 1;

                      ?>

                              <div class="col-sm-12  box job-card">

                                <div class="check_hide">

                                  <?php

                                  $appliedjob = $this->Comman->appliedjob($value['id']);
                                  $sentquote = $this->Comman->sentquote($value['id']);

                                  //pr($sentquote);
                                  if (!$appliedjob) {
                                    if (!$sentquote) {
                                  ?>
                                      <input type="checkbox" name="job[]" value="<?php echo $value['id'] ?>" class="chkbox sendquoute" data-val="<?php echo $value['id'] ?>" id="mycke<?php echo $value['id']; ?>">
                                  <?php }
                                  } ?>
                                  <div class="remove-top">


                                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                  </div>
                                </div>


                                <div class="col-sm-3">
                                  <div class="profile-det-img1">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"> <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';"></a>

                                    <!-- <div class="img-top-bar"> <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"></a>

                                      <?php if ($ricon['id'] != 1) { ?>

                                        <img src="<?php echo SITE_URL ?>/img/<?php echo $picon['icon'] ?>" style="height: 2%; width: 15%" title="<?php echo $picon['name'] ?> Profile" />

                                        <img src="<?php echo SITE_URL ?>/img/<?php echo $ricon['icon'] ?>" style="height: 2%; width: 15%" title="<?php echo $ricon['title'] ?> Recruiter" /> <br>
                                        <span style="color:#fff">Paid Posting</span>
                                      <?php } else { ?>
                                        <?php echo ($value['Posting_type'] != 'Free Posting') ? 'Paid Posting' : 'Free Posting' ?>
                                      <?php } ?>

                                    </div> -->

                                    <div class="img-top-bar">
                                      <!-- <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"></a> -->

                                      <?php if ($ricon['id'] != 1 && $value['is_paid_post'] == 'N') : ?>
                                        <img src="<?= SITE_URL ?>/img/<?= $picon['icon'] ?>"
                                          style="height: 2%; width: 15%"
                                          title="<?= $picon['name'] ?> Profile Package" />

                                        <img src="<?= SITE_URL ?>/img/<?= $ricon['icon'] ?>"
                                          style="height: 2%; width: 15%"
                                          title="<?= ($riconPaid['name'] && $value['is_paid_post'] == 'Y')
                                                    ? $riconPaid['name'] . ' Requirement Package'
                                                    : $ricon['title'] . ' Recruiter Package' ?>" />
                                      <?php else : ?>
                                        <span style="color:#fff">
                                          <?= ($value['is_paid_post'] == 'Y') ? 'Paid Posting' : 'Free Posting' ?>
                                        </span>
                                      <?php endif; ?>


                                    </div>

                                  </div>
                                </div>
                                <div class="col-sm-9">
                                  <h3 class="heading"><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"><?php echo $value['title'] ?></a><span title="Last date of application"><?php echo date('d M Y', strtotime($value['last_date_app']));  ?></span></h3>

                                  <ul class="list-unstyled job-r-skill">
                                    <li><a href="javascript:void(0)" class="fa fa-globe"></a><?php echo $value['location'] ?></li>
                                    <li><a href="<?php echo SITE_URL ?>/viewprofile/<?php echo  $value['user_id'] ?>" class="fa fa-user"> </a> Posted by
                                      <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo  $value['user_id'] ?>"><?php echo $value['user_name'] ?></a>
                                    </li>

                                    <li><a href="#" class="fa fa-american-sign-language-interpreting"></a>

                                      <?php
                                      $skill = $this->Comman->requimentskill($value['id']);
                                      $count = 0;
                                      foreach ($skill as $vacancy) {
                                        if ($vacancy['skill']['name']) {
                                          $count++;
                                        }

                                        echo  $vacancy['skill']['name'];
                                        echo ",";
                                      }  ?>


                                    </li>

                                    <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['eventname'] ?></li>
                                  </ul>
                                  <div class="row">
                                    <div class="col-sm-8">


                                      <a class='btn btn-default' href="<?php echo SITE_URL; ?>/login">Apply</a>


                                    </div>

                                    <div class="col-sm-4 text-right">
                                      <div class="icon-bar srh-icon-bar">

                                        <a href="<?php echo SITE_URL; ?>/login" class="fa fa-thumbs-up"></a>
                                        <a href="<?php echo SITE_URL; ?>/login" title="Share" class="fa fa-share"></a>
                                        <a href="<?php echo SITE_URL; ?>/login" title="Report"><i class="fa fa-flag"></i></a>
                                        <a href="<?php echo SITE_URL; ?>/login" title="Save Jobs" class="fa fa-floppy-o"></a>
                                        <a href="<?php echo SITE_URL; ?>/login" title="Block Jobs" class="fa fa-ban block"></a>


                                      </div>


                                    </div>
                                  </div>
                                </div>
                              </div>


                      <?php    }
                          }
                        }
                      }  ?>


                    </form>
                  <?php  } ?>
                </div>

                <div class="row">
                  <div class="col-sm-12 m-top-20">
                    <?php if ($isdata == 1) { ?>
                      <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default m-right-20">Save Search Result </a>
                    <?php } else { ?>
                      <h3 style="margin-top: 316px;margin-left: 300px;"> NO JOBS FOUND</h3>

                    <?php } ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php //} else{  echo "<div><h3 align='center'>You Don't Have Any Skill</h3></div>";  } 
    ?>

  </div>
  </section>



</div>


<script>
  $('.data').click(function(e) {

    e.preventDefault();
    $('#singlemodel').modal('show').find('#single').load($(this).attr('href'));
  });
</script>

<script>
  $('.sendquote').click(function(e) {

    e.preventDefault();
    $('#applysinglequote').modal('show').find('#singlequote').load($(this).attr('href'));
  });
</script>

<script>
  $('.pingmy').click(function(e) {

    e.preventDefault();
    $('#singlepingjobmodal').modal('show').find('#singlepingupdate').load($(this).attr('href'));
  });
</script>


<!-- For Single ping -->
<!-- Modal -->
<div id="singlepingjobmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ping jobs</h4>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'Pingpay'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'singlepignpay', 'autocomplete' => 'off')); ?>

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
              <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CSV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
            </div>
            <?php
            for ($m = 0; $m <= 12; $m++) {
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
            <br><br><br>
            <div class="col-sm-3">
              <?php echo $this->Form->input('amount', array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => true, 'label' => false, 'id' => '', 'readonly', 'value' => $ping_amt)); ?>
            </div>
          </div>
          <input type="hidden" name="count" id="pingcount">


          <div class="form-group">
            <div class="col-sm-12 text-center"> </div>
          </div>
          <div class="form-group" style="
          margin-left:  0px;
          margin-right: 23px;
          ">

            <div id="singlepingupdate"></div>
            <br>
            <div>
              <label> Invoice Address</label>
              <textarea name="invoice_address" class="form-control" placeholder="Invoice Address" required="required" id="address" rows="5"><?php $invoicedata = $this->Comman->proff();

                                                                                                                                            echo $invoicedata['profile']['location'];
                                                                                                                                            ?></textarea>
            </div>

            <div class="form-group" style="margin-top: 45px;">
              <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>

    </div>
  </div>
</div>

<!-- End Single Ping -->



<!--- Purchese quote -->
<!-- For Single ping -->
<!-- Modal -->
<div id="purcheasequote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Purchease Quote</h4>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'Pingpay'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'singlepignpay', 'autocomplete' => 'off')); ?>

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
              <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CSV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
            </div>
            <?php
            for ($m = 0; $m <= 12; $m++) {
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
            <br><br><br>
            <div class="col-sm-3">
              <?php echo $this->Form->input('amount', array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => true, 'label' => false, 'id' => '', 'readonly', 'value' => $ping_amt)); ?>
            </div>
          </div>
          <input type="hidden" name="count" id="pingcount">
          <input type="hidden" value="2" name="senqquote">

          <div class="form-group">
            <div class="col-sm-12 text-center"> </div>
          </div>
          <div class="form-group" style="
        margin-left:  0px;
        margin-right: 23px;
        ">

            <div id="singlepingupdate"></div>
            <br>
            <div>
              <label> Invoice Address</label>
              <textarea name="invoice_address" class="form-control" placeholder="Invoice Address" required="required" id="address" rows="5"><?php $invoicedata = $this->Comman->proff();

                                                                                                                                            echo $invoicedata['profile']['location'];
                                                                                                                                            ?></textarea>
            </div>

            <div class="form-group" style="margin-top: 45px;">
              <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>

    </div>
  </div>
</div>

<!-- End -->




<script>
  $(document).ready(function() {
    $(".btn").click(function() {
      $(".exp-cnt").toggleClass("show");
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  $('#refinesearch').submit(function(event) {


    var urllog = $('#refinesearch').serialize();
    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/jobrefine',
      data: $('#refinesearch').serialize(),
      beforeSend: function() {


      },

      success: function(response) {



        if (response == 1) {
          $('#nof').html("<h3 align='center' style='margin-top:300px'>No job's Found</h3>");

        } else {
          $('#update').html(response);
        }


      },
      complete: function() {
        $('#clodder').css("display", "none");
        var curl = window.location.href;
        var win = window.open(curl + "&" + urllog, "_self");

      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });

  });
</script>

<script type="text/javascript">
  $(document).ready(function() {

    $('.fb').click(function(e) {
      var link = $(this).data('link');
      console.log(link);
      window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(link), 'sharer', 'toolbar=0,status=0,width=626,height=436');
      return false;
    });
  });
</script>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  $('.actbut').click(function() {
    // alert($(this).val());

    // $('#btuuonpress').value='1';
    var v = $(this).val();
    $('#btuuonpress').val(v);

    console.log('testdfsdf');
  });


  $('#multiple').submit(function(event) {
    console.log('testd');
    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/aplyjobmultiple',
      data: $('#multiple').serialize(),
      beforeSend: function() {
        $('#clodder').css("display", "block");

      },

      success: function(response) {

        var myObj = JSON.parse(response);

        if (myObj.success == 2) {
          location.reload();
          q = 0;
          // var obj = jQuery.parseJSON(response);

          //console.log('#apply'+myObj.job_id);

          $.each(myObj.jobarray, function(key, value) {
            //alert(value);

            $('#apply' + value).remove();
            $('#aplymsz' + value).css('display', 'block');
            $('#mycke' + value).css('display', 'none');
            $('#mycke' + value).prop('checked', false);
            $('#Send' + value).css('display', 'none');

            //alert('#multiplejob #job-'+value);
            $('#multiplejob #job-' + value).remove();
            $('#multiplequote #job-' + value).remove();
          });
          window.scrollTo(0, 50);
          $('#aplybutton').css("visibility", "hidden");
          //window.location = SITE_URL+"showjob/applied";
        } else if (myObj.success == 1) {
          $("#applymultiplejob").modal('show');
          $("#limitalert").css('display', 'none');
        } else if (myObj.success == 3) {

          $("#applymultiplequote").modal('show');
          $('#sendquotelimitalert').css("display", "none");
        } else if (myObj.monthlimit == 1) {
          window.scrollTo(0, 50);
          $('.singapl').css('display', 'block');
          $('#singleapply').text('You have exceed Month limit you have left only  ' + myObj.monthcount + ' For apply please upgrade your package');
        } else if (myObj.dailylimit == 1) {
          window.scrollTo(0, 50);
          $('.singapl').css('display', 'block');
          $('#singleapply').text('You have exceed Daily limit you have left only ' + myObj.daycount + 'For apply please upgrade your package');
        }



      },
      complete: function() {
        $('#clodder').css("display", "none");

        a = 0;


      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });

  });
</script>

<script>
  $(function() {
    $("#slider-range").slider({
      range: true,
      min: <?php $session = $this->request->session();
            echo $session->read('mini'); ?>,
      max: <?php $session = $this->request->session();
            echo $session->read('maxi');; ?>,
      values: [<?php echo $selmini ?>, <?php echo $selmaxi; ?>],
      slide: function(event, ui) {
        $("#amount").val("" + ui.values[0] + " - " + ui.values[1]);

      },
      change: function(event, ui) {
        $("#myajexfrom").submit();
      }
    });
    $("#amount").val("" + $("#slider-range").slider("values", 0) +
      " - " + $("#slider-range").slider("values", 1));
  });
</script>

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
          jobsearch: job_id,
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
  var checkclick = 0;
  $(document).ready(function() {
    var site_url = '<?php echo SITE_URL; ?>/';
    $('.chkbox').click(function() {


      var job_id = $(this).data('val');
      if ($(this).is(':checked')) {

        ++checkclick;
        mypingfunction(job_id, checkclick);
        console.log(checkclick);
        var status = "chek";
        $(this).parent('div').removeClass('check_hide');
        $.ajax({
          type: 'POST',
          url: site_url + 'search/applymultiple',
          data: {
            jobsearch: job_id,
            dyid: checkclick,
            status: status
          },

          beforeSend: function() {


          },
          success: function(data) {
            $("#multiplejob").append(data);

            //$('#update').html(data);

          },
          complete: function() {

            $('#aplybutton').css("display", "block");


          },
          error: function(data) {
            alert(JSON.stringify(data));

          }
        });

      } else {
        $(this).parent('div').addClass('check_hide');
        checkclick--;
        $("#job-" + job_id).remove();
        $("#myping" + job_id).remove();
        if (checkclick == 0) {
          $('#aplybutton').css("display", "none");
        }



      }


    });



  });
</script>

<script>
  var quote = 0;

  $(document).ready(function() {

    var pop = 0;
    var site_url = '<?php echo SITE_URL; ?>/';
    $('.sendquoute').click(function() {


      var job_id = $(this).data('val');

      if ($(this).is(':checked')) {


        var status = "chek";

        console.log(quote);

        $.ajax({
          type: "post",
          url: site_url + 'search/sendquotemultiple',
          data: {
            jobsearch: job_id,
            a: quote,
            status: status
          },
          success: function(data) {

            $("#multiplequote").append(data);


          }


        });
        quote++;
        console.log("here");



        pop++;

        //alert(pop);

        if (pop >= 1) {


          //$('#aplybutton').css("visibility","visible");
          //$("#aplybutton").attr("data-toggle","modal");

        }

      } else {
        quote--;
        console.log(quote);

        pop--;

        //jQuery(this).parent('li').addClass('yourClass');
        $(this).parent('div').removeClass('Active');

        if (pop < 1) {



        }

        $("#job-" + job_id).remove();
      }


    });
  });
</script>

<script type="text/javascript">
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

  function mypingfunction(job_id, count) {



    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/pingjobs',
      data: {
        jobid: job_id,
        count: count
      },
      beforeSend: function() {


      },

      success: function(response) {

        $('#updateping').append(response);
        var amt = <?php echo $ping_amt ?>;

        $('#pingamount').val(amt * count);
        $('#pingcount').val(count);
      },
      complete: function() {



      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });




  }
</script>

<!-- Modal -->
<div id="applymultiplejob" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Apply Job</h4>
      </div>

      <div class="modal-body">
        <div class="alert alert-warning alert-dismissible" id="limitalertbox" style="display: none">

          <strong id="limittextbox"></strong>
        </div>
        <form id="multiplejob" method="POST">
        </form>
      </div>

      <div class="modal-footer" style="border-top: none">
        <button type="submit" class="btn btn-default" form="multiplejob">Apply</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="applymultiplequote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Quote</h4>
      </div>

      <div class="modal-body">
        <div class="alert alert-warning alert-dismissible" id="sendquotelimitalert" style="display: none">
          <strong id="sendlimittext"></strong>
        </div>
        <form id="multiplequote" method="POST">
        </form>
      </div>

      <div class="modal-footer" style=" border-top:none; ">
        <button type="submit" class="btn btn-default" form="multiplequote">Send Quote</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="applysinglequote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Quote</h4>
      </div>

      <div class="modal-body">
        <div class="alert alert-warning alert-dismissible" id="sendquotelimitalert" style="display: none">
          <strong id="sendlimittext"></strong>
        </div>
        <form id="singlequote" method="POST">
        </form>
      </div>
      <div class="modal-footer" style=" border-top:none; ">
        <button type="submit" class="btn btn-default" form="singlequote">Send Quote</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';

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
</script>
<!-- Modal -->

<div id="pingjobmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ping jobs</h4>
      </div>
      <div class="modal-body">
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
              <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CSV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
            </div>
            <?php
            for ($m = 0; $m <= 12; $m++) {
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
            <br><br><br>
            <div class="col-sm-3">
              <?php echo $this->Form->input('amount', array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => true, 'label' => false, 'id' => 'pingamount', 'readonly')); ?>
            </div>
          </div>



          <div class="form-group">
            <div class="col-sm-12 text-center"> </div>
          </div>
          <div class="form-group" style="
        margin-left:  0px;
        margin-right: 23px;
        ">
            <div id="updateping"></div>

            <div class="form-group">
              <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $('#PackageIndexForm').submit(function(event) {

    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'package/Pingpaybymultiple',
      data: $('#PackageIndexForm').serialize(),
      beforeSend: function() {


      },

      success: function(response) {

        var myObj = JSON.parse(response);
        if (myObj.success == 1) {
          $('#updateping').empty();
          $('#multiplequote').empty();
          $('#pingbutton').css("visibility", "hidden");
          $('#quote').css("visibility", "hidden");

          var count = 0;
          $.each(myObj.jobarray, function(key, value) {


            //$('#apply'+value).text('Applied');
            $('#mycke' + value).css('display', 'none');

            $('#mycke' + value).prop('checked', false);
            $('#Send' + value).css('display', 'none');
            //alert('#multiplejob #job-'+value);
            $('#multiplejob #job-' + value).remove();
            count++;
            //$('#multiplejob').find('#job-'+value).remove();
            //$('#job-'+value).remove();
          });
          $('#singleskillnumber').css('display', 'block');

          //window.location = SITE_URL+"showjob/applied";

          $('#pingjobmodal').modal('toggle');
          window.scrollTo(0, 50);
          $('#pingbutton').css("visibility", "hidden");
        } else {
          $("#applymultiplejob").modal('show');
        }

        $('#pingamount').val('');

      },
      complete: function() {

        // alert(a);
        //  a=0;
        location.reload();


      },
      error: function(data) {
        alert(JSON.stringify(data));

      }

    });

  });
</script>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';



  $('#multiplequote').submit(function(event) {

    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'jobpost/aplysendquotemultiple',
      data: $('#multiplequote').serialize(),
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
          $.each(myObj.jobarray, function(key, value) {
            //alert(value);


            $('#Send' + value).text('Quote Send');
            // $('#mycke'+value).css('display','none');

            $('#mycke' + value).prop('checked', false);
            //$('#Send'+value).css('display','none');
            //alert('#multiplejob #job-'+value);

            $('#multiplequote #job-' + value).remove();
            $('#multiplejob #job-' + value).remove();
            count++;
            //$('#multiplejob').find('#job-'+value).remove();
            //$('#job-'+value).remove();

          });


          $('#applymultiplequote').modal('toggle');
          window.scrollTo(0, 50);
          location.reload();
          $('#aplybutton').css("visibility", "hidden");

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
</script>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';



  $('#multiplejob').submit(function(event) {

    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'jobpost/aplymultiple',
      data: $('#multiplejob').serialize(),
      beforeSend: function() {

        console.log($('#multiplejob').serialize());
      },

      success: function(response) {
        quote = 0;
        var myObj = JSON.parse(response);


        if (myObj.daily == 1) {
          $('#limitalertbox').css('display', 'block');
          $('#limittextbox').text(myObj.message);

        }
        if (myObj.month == 1) {
          $('#limitalertbox').css('display', 'block');
          $('#limittextbox').text(myObj.message);

        } else if (myObj.success == 2) {

          // var obj = jQuery.parseJSON(response);

          $('#multiplequote').empty();

          //console.log('#apply'+myObj.job_id);
          var count = 0;
          $.each(myObj.jobarray, function(key, value) {
            //alert(value);

            // $('#apply'+value).text('Applied');
            $('#mycke' + value).css('display', 'none');

            $('#mycke' + value).prop('checked', false);
            $('#Send' + value).css('display', 'none');
            //alert('#multiplejob #job-'+value);
            $('#multiplejob #job-' + value).remove();
            count++;
            //$('#multiplejob').find('#job-'+value).remove();
            //$('#job-'+value).remove();
          });
          //$('#singleskillnumber').css('display','block');
          $('#numberofapp').text('Application to ' + count + ' jobs sent Successfully');
          //window.location = SITE_URL+"showjob/applied";

          $('#applymultiplejob').modal('toggle');
          window.scrollTo(0, 50);
          $('#aplybutton').css("visibility", "hidden");
          location.reload();

        } else {
          $("#applymultiplejob").modal('show');
        }



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
</script>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';



  $('#single').submit(function(event) {

    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'jobpost/aplysingle',
      data: $('#single').serialize(),
      beforeSend: function() {

        //  alert("Tet");
      },

      success: function(response) {
        quote = 0;
        var myObj = JSON.parse(response);


        if (myObj.daily == 1) {
          $('#limitalert').css('display', 'block');
          $('#limittext').text(myObj.message);

        } else if (myObj.success == 2) {


          location.reload();

        } else {
          // $("#applymultiplejob").modal('show');
        }



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
</script>

<script>
  function test(x) {
    //alert(x.template.value);
    event.preventDefault();

    var tem = x.template.value;

    var w = '1';

    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/savesearchresult',
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
        setTimeout(function() {
          $('#savejobrefinetamplate').modal('toggle');
        }, 7000);


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


<!-- Modal -->
<div class="modal fade" id="multiplebooknow" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">



        <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'jobpost', 'action' => 'insBook'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'booknowsubmit', 'autocomplete' => 'off')); ?>
        <span id="booknownoselect" style="display: none">Select Atleast one Job</span>
        <input type="hidden" name="user_id" value="<?php echo $userid ?>" class="chekprofileid">

        <div class="">
          <?php if (count($activejobs) > 0) { ?>



            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Job</th>
                  <th>Skills</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($activejobs as $jobs) { //pr($jobs);
                ?>
                  <tr>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>
                        <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>">
                      <?php } ?>
                      <?php if (!in_array($jobs['id'], $app)) {
                        $pendingjob[] = $job['id']; ?>


                        <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a>
                      </td>
                    <?php  } ?>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>

                        <select class="form-control" name="job_id[<?php echo $jobs['id']; ?>][]">
                          <option value="">--Select--</option>
                          <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);
                          ?>
                            <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    <?php } ?>
                  </tr>
                <?php } ?>
                <?php if ($pendingjob) { ?>

                <?php } else { ?>
                  <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Booking "; ?></td>
                <?php } ?>
              </tbody>

            </table>

          <?php
          } else {

            echo "No jobs Found";
          }

          ?>



          <?php if ($pendingjob) { ?> <button type="submit" class="btn btn-default" id="booknowsave">Book Now</button> <?php } ?>
        </div>
        </form>
      </div>

    </div>

  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="multipleaskquote" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
        <div id="mulitpleaskquoteinvited" style="display: none">

          <?php foreach ($_SESSION['askquotenotinvite'] as $key => $result) { ?>
            <?php echo $result; ?> Available Quotes <?php echo $key; ?> Credit Left.

          <?php  } ?>
        </div>
        <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'search', 'action' => 'mutipleaskQuote'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'askquotesubmit', 'autocomplete' => 'off')); ?>
        <span id="noselect" style="display: none">Select Atleast one Skills</span>
        <input type="hidden" name="user_id" value="<?php echo $userid ?>" class="chekprofileid">
        <div class="">
          <?php if (count($activejobs) > 0) { ?>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Job</th>
                  <th>Skills</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;
                foreach ($activejobs as $jobs) { //pr($jobs);

                ?>
                  <tr>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>




                        <?php
                        if ($jobs['askquotedata'] < 1) { ?>

                          <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote </a>
                        <?php  } else { ?>
                          <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>">
                      <?php }
                      } ?>

                      <?php if (!in_array($jobs['id'], $app)) {
                        $pendingjob[] = $job['id']; ?>


                        <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a>
                      </td>
                    <?php  } ?>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>

                        <select class="form-control" name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunction(this)" data-req="<?php echo $jobs['id'] ?>">
                          <option value="">--Select--</option>
                          <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);
                          ?>

                            <option value="<?php echo $skillsreq['skill']['id']; ?>" <?php if ($jobs['askquotedata'] < 1) {
                                                                                        echo "disabled";
                                                                                      } ?>><?php echo $skillsreq['skill']['name']; ?></option>
                          <?php } ?>
                        </select>
                        <input class="form-control" type="text" id="currency<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly />
                        <input class="form-control" type="text" id="offeramt<?php echo $jobs['id']; ?>" style="width: 38%" placeholder=" Offer Payment" readonly />
                      </td>
                    <?php } ?>
                  </tr>
                <?php $count++;
                } ?>
                <?php if ($pendingjob) { ?>

                <?php } else { ?>
                  <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Quote "; ?></td>
                <?php } ?>
              </tbody>

            </table>


          <?php } else {

            echo "No jobs Found";
          } ?>







        </div>
        </form>
      </div>

    </div>

  </div>
</div>

</div>


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


</div>


</div>
</div>
</div>
</div>
</section>

<?php   } else {  ?>
  <?php $c = 0;

    $count = 0;
    foreach ($_SESSION['advancejobsearch'] as $key => $value) {
      //echo $key;
      if ($key == "skillshow" || $key == "unit" || $key == "from" || $key == "optiontype") {
      } else {
        if ($value) {


          if ($key == "city_id") {

            if ($value['0']) {
              $count++;
            }
          } else {

            $count++;
          }
        }
      }
    }

  ?>
  <?php
    unset($_SESSION['advancejobsearch']['name']);
    unset($_SESSION['advancejobsearch']['optiontype']);


    if ($title && empty($_SESSION['advancejobsearch'])) {
  ?>
    <div class="row" id="panel">

      <div class="srch-box">
        <div class="container">
          <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
            <input type="text" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" readonly>
          </div>
        </div>
        <br>
        <div class="form-group">
          <div class="col-sm-2">
            <a href="<?php echo SITE_URL ?>/search/advanceJobsearch/1" class="btn btn-default btn-block">Edit Search</a>
          </div>
          <div class="col-sm-2">
            <a href="<?php echo SITE_URL ?>/search/advanceJobsearch" class="btn btn-primary btn-block">Advance Search</a>
          </div>
          <div class="col-sm-2">
            <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/withoutloginsearch/reset" class="btn btn-primary btn-block">Refine Search</a>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>


  <?php if ($count > 5) { ?> <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip" style="    position: absolute;
    right: 5px;
    top: 94px;">Show Less</a> <?php } ?>
  <div class="row" id="panel">
    <?php if ($_SESSION['advancejobsearch']) { ?>
      <div class="srch-box">
        <div class="container">

          <form class="form-horizontal">
            <div class="form-group">
              <?php if ($_SESSION['advancejobsearch']['keyword']) { ?>
                <div class="col-sm-2">

                  <label for="" class=" control-label">Job Title:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo $_SESSION['advancejobsearch']['keyword'];   ?>" readonly>
                </div>

              <?php } ?>
              <?php if ($_SESSION['advancejobsearch']['eventshow']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Event:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo $_SESSION['advancejobsearch']['eventshow'];  ?>" readonly>
                </div>

              <?php } ?>
              <?php if ($title) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Word Search:</label>
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" readonly>
                </div>
              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['skillshow']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Talent Type:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['skillshow'];   ?>" readonly>
                </div>

              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['locationlat']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Location:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['locationlat'];  ?>" readonly>
                </div>
              <?php } ?>



              <?php if ($_SESSION['advancejobsearch']['within']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">within:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['within'];  ?>" readonly>
                </div>
              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['unit'] && $_SESSION['advancejobsearch']['within']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">unit:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch'])  echo $_SESSION['advancejobsearch']['unit'];  ?>" readonly>
                </div>
              <?php } ?>




              <?php if ($_SESSION['advancejobsearch']['gender']) { ?>
                <div class="col-sm-2">

                  <label for="" class=" control-label">Gender:</label>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly value="<?php if ($_SESSION['advancejobsearch']) { ?> <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['gender']); $i++) {
                                                                                                                                                          if ($_SESSION['advancejobsearch']['gender'][$i] == "m") echo "Male,";
                                                                                                                                                          else if ($_SESSION['advancejobsearch']['gender'][$i] == "f") echo "Female,";
                                                                                                                                                          else if ($_SESSION['advancejobsearch']['gender'][$i] == "bmf") echo "Both Male and Female";
                                                                                                                                                          else if ($_SESSION['advancejobsearch']['gender'][$i] == "a") echo "Any,";
                                                                                                                                                        } ?> <?php } ?>">
                </div>
              <?php } ?>
              <?php if ($_SESSION['advancejobsearch']['Paymentfequency']) { ?>

                <div class="col-sm-2">
                  <label for="" class=" control-label">Payment offer :</label>
                  <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['Paymentfequency']); $i++) {

                    $data = $this->Comman->mypaymentfaq($_SESSION['advancejobsearch']['Paymentfequency'][$i]);
                    $payment[] = $data['name'];
                  } ?>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo implode(",", $payment); ?>" readonly>
                </div>

              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['country_id']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Country:</label>
                  <?php $countrydata = $this->Comman->cnt($_SESSION['advancejobsearch']['country_id']);


                  ?>
                  <input type="text" class="form-control" id="inputEmail3" value="<?php if ($countrydata) {
                                                                                    echo $countrydata['name'];
                                                                                  } ?>" readonly />
                </div>

              <?php } ?>
              <?php if ($_SESSION['advancejobsearch']['state_id']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">State :</label>
                  <?php $statedata = $this->Comman->state($_SESSION['advancejobsearch']['state_id']);  ?>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($statedata) {
                                                                                                    echo $statedata['name'];
                                                                                                  } ?>" readonly>
                </div>
              <?php } ?>


              <?php if ($_SESSION['advancejobsearch']['city_id']['0'] != "") { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">City:</label>

                  <?php for ($i = 0; $i < count($_SESSION['advancejobsearch']['city_id']); $i++) {

                    $citydata = $this->Comman->city($_SESSION['advancejobsearch']['city_id'][$i]);

                    $cityarray[] = $citydata['name'];
                  } ?>
                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) echo implode(",", $cityarray); ?>" readonly>
                </div>
              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['role_id']) { ?>


                <div class="col-sm-2">
                  <label for="" class=" control-label">Posted by :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    if ($_SESSION['advancejobsearch']['role_id'] == 2) {
                                                                                                      echo "Artists";
                                                                                                    } elseif ($_SESSION['advancejobsearch']['role_id'] == 3) {
                                                                                                      echo "Non-Telant";
                                                                                                    }
                                                                                                  } ?>" readonly>
                </div>
              <?php } ?> <?php if ($_SESSION['advancejobsearch']['recname']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Posted by name :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['recname'];
                                                                                                  } ?>" readonly>
                </div>
              <?php } ?>

              <?php if ($_SESSION['advancejobsearch']['event_from_date']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Event From :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['event_from_date'];
                                                                                                  } ?>" readonly>
                </div>
              <?php  } ?>
              <?php if ($_SESSION['advancejobsearch']['event_to_date']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Event To :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['event_to_date'];
                                                                                                  } ?>" readonly>
                </div>
              <?php  } ?>

              <?php if ($_SESSION['advancejobsearch']['talent_required_fromdate']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Talent To :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['talent_required_fromdate'];
                                                                                                  } ?>" readonly>
                </div>
              <?php  } ?>

              <?php if ($_SESSION['advancejobsearch']['talent_required_todate']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Talent From :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['talent_required_todate'];
                                                                                                  } ?>" readonly>
                </div>
              <?php  } ?>

              <?php if ($_SESSION['advancejobsearch']['time']) {   ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Continuous Job</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']['time'] == "Y") {
                                                                                                    echo "YES";
                                                                                                  } else if ($_SESSION['advancejobsearch']['time'] == "a") {
                                                                                                    echo "All";
                                                                                                  } else {
                                                                                                    echo "NO";
                                                                                                  }  ?>" readonly>
                </div>
              <?php  } ?>
              <?php if ($_SESSION['advancejobsearch']['last_date_app']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Last Date After :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['last_date_app'];
                                                                                                  } ?>" readonly>
                </div>
              <?php  } ?>

              <?php if ($_SESSION['advancejobsearch']['last_date_appbefore']) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Last Date Before :</label>

                  <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advancejobsearch']) {
                                                                                                    echo $_SESSION['advancejobsearch']['last_date_appbefore'];
                                                                                                  } ?>" readonly>
                </div>

              <?php  } ?>



            </div>

            <div class="form-group">
              <div class="col-sm-2">
                <a href="<?php echo SITE_URL ?>/search/advanceJobsearch/1" class="btn btn-default btn-block">Edit Search</a>
              </div>
              <div class="col-sm-2">
                <a href="<?php echo SITE_URL ?>/search/advanceJobsearch" class="btn btn-primary btn-block">Advance Search</a>
              </div>
              <div class="col-sm-2">
                <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/withoutloginsearch/reset" class="btn btn-primary btn-block">Refine Search</a>
              </div>
            </div>


          </form>
        </div>
      </div>
  </div>
<?php } ?>

<div id="update">

  <div class="refine-search m-top-60">
    <div class="container">
      <div class="profile-bg">
        <div class="clearfix m-top-20">
          <div class="col-sm-3">
            <div class="panel panel-left">
              <h6>Refine Job Search</h6>
              <form class="form-horizontal" action="<?php echo SITE_URL ?>/search/withoutloginsearch" method="get" id="myajex">

                <input type="hidden" name="refine" value="1" />
                <div class="form-group">


                  <div class="col-sm-12">
                    <label class="">
                      <input type="radio" name="time" id="inlineRadio2" value="a" class="auto_submit" <?php if ($time == "a") {
                                                                                                        echo "checked";
                                                                                                      } ?>>
                      All </label><br>
                    <?php if (in_array("N", $continue)) { ?>
                      <label class="">
                        <input type="radio" name="time" id="inlineRadio1" value="N" class="auto_submit" <?php if ($time == "N") {
                                                                                                          echo "checked";
                                                                                                        } ?>>
                        Fixed Time Jobs</label>

                    <?php } ?>

                    <?php if (in_array("Y", $continue)) { ?>
                      <label class="">
                        <input type="radio" name="time" id="inlineRadio2" value="Y" class="auto_submit" <?php if ($time == "Y") {
                                                                                                          echo "checked";
                                                                                                        } ?>>
                        Continuous Job </label>
                    <?php } ?>

                  </div>
                </div>

                <?php if ($_SESSION['advancejobsearch']['within']) { ?>
                  <input type="hidden" value="<?php echo $_SESSION['advancejobsearch']['within'] ?>" name="within" />
                <?php } ?>
                <?php if ($_SESSION['advancejobsearch']['locationlat']) { ?>
                  <input type="hidden" value="<?php echo $_SESSION['advancejobsearch']['locationlat'] ?>" name="locationlat" />
                <?php } ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Currency </label>
                  <div class="col-sm-12">
                    <select class="form-control auto_submit" name="currency[]" multiple="">
                      <?php if ($currencyarray) { ?>
                        <option value="0">Select Currency</option>
                      <?php } ?>
                      <?php $i = 0;
                      foreach ($currencyarray as $key => $value) { ?>
                        <option value="<?php echo $key ?>" <?php if (in_array($key, $currencyarrayset)) {
                                                              echo "selected";
                                                            } ?>> <?php echo  $value; ?> </option>

                      <?php $i++;
                      } ?>



                    </select>
                  </div>
                </div>
                <div class="form-group salry">
                  <label for="inputEmail3" class="col-sm-12 control-label">Salary </label>
                  <p class="prc_sldr">
                    <label for="amount">Salary</label>
                    <input type="text" id="amo" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="salaryrange" class="auto_submit">
                  </p>
                  <div id="slider"></div>
                </div>

                <h3 style="position: relative;
                   left: 550px;display:inline "> NO JOBS FOUND</h3>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment Offered (Per) </label>
                  <div class="col-sm-12">

                    <select class="form-control auto_submit" name="payment[]" multiple="">
                      <?php if ($payemntfaq) { ?>
                        <option value="0">Select Payment</option>
                      <?php  } ?>
                      <?php $i = 0;
                      foreach ($payemntfaq as $key => $paymentfaqvalue) { ?>
                        <option value="<?php echo $key ?>" <?php if (in_array($key, $paymentselarray)) {
                                                              echo "selected";
                                                            } ?>> <?php echo  $paymentfaqvalue; ?> </option>

                      <?php $i++;
                      } ?>
                    </select>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Location </label>
                  <div class="col-sm-12">

                    <select class="form-control auto_submit" name="location[]" multiple="">
                      <?php if ($location) { ?>
                        <option value="1">Select Location</option>
                      <?php } ?>
                      <?php $i = 0;
                      foreach ($location as $key => $locationvalue) { ?>
                        <option value="<?php echo $key ?>" <?php if (in_array($key, $loc)) {
                                                              echo "selected";
                                                            } ?>> <?php echo  $locationvalue; ?> </option>

                      <?php $i++;
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                    <select class="form-control auto_submit" name="telenttype[]" multiple="">
                      <?php if ($talentype) { ?>
                        <option value="0">Select Talent Type</option>
                      <?php } ?>
                      <?php $i = 0;
                      foreach ($talentype as $key => $talentypevalue) { ?>
                        <option value="<?php echo $key ?>" <?php if (in_array($key, $ttype)) {
                                                              echo "selected";
                                                            } ?>> <?php echo  $talentypevalue; ?> </option>

                      <?php $i++;
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Event Type</label>
                  <div class="col-sm-12">
                    <select class="form-control auto_submit" name="eventtype[]" multiple="">
                      <?php if ($eventtype) { ?>
                        <option value="0">Select Event</option>
                      <?php } ?>
                      <?php $i = 0;
                      foreach ($eventtype as $key => $eventtypevalue) { ?>

                        <option value="<?php echo $key ?>" <?php if (in_array($key, $eventtypearray)) {
                                                              echo "selected";
                                                            } ?>> <?php echo  $eventtypevalue; ?> </option>

                      <?php $i++;
                      } ?>
                    </select>
                  </div>
                </div>









                <?php if ($backtorefine == 1) { ?>

                  <a href=" <?php echo SITE_URL; ?>/search/withoutloginsearch?<?php echo $this->request->session()->read('backtorefinesearch'); ?>" class="btn btn-default">Back to Search Result </a>
                <?php } else {  ?>
                  <a href="javascript:void(0)" class="btn btn-default" ?>Back to Search Result </a>
                <?php } ?>
                <input type="hidden" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" name="keyword">



                <div class="form-group">
                  <div class="col-sm-12">
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-9" id="nof">
      <div class="panel panel-right">
        <div class="clearfix job-box">


        </div>
      </div>
    </div>



    <script type="text/javascript">
      $(function() {


        $(".auto_submit").change(function() {

          $("#myajex").submit();
        });
      });
    </script>


    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
      $(function() {

        $("#slider").slider({
          range: true,
          min: <?php $session = $this->request->session();
                echo $session->read('mini'); ?>,
          max: <?php $session = $this->request->session();
                echo $session->read('maxi');; ?>,
          values: [<?php echo $selmini ?>, <?php echo $selmaxi; ?>],
          slide: function(event, ui) {
            $("#amo").val("" + ui.values[0] + " - " + ui.values[1]);

          },
          change: function(event, ui) {
            $("#myajex").submit();
          }
        });
        $("#amo").val("" + $("#slider").slider("values", 0) +
          " - " + $("#slider").slider("values", 1));
      });
    </script>










  <?php  } ?>

  <script type="text/javascript">
    var SITE_URL = '<?php echo SITE_URL; ?>/';
    $('.saveprofile').click(function() {
      console.log('test');
      var profile = $(this).data('profile');

      event.preventDefault();
      $.ajax({
        dataType: "html",
        type: "post",
        evalScripts: true,
        url: SITE_URL + 'search/saveprofile',
        data: {
          p_id: profile
        },
        beforeSend: function() {


        },

        success: function(response) {

          var myObj = JSON.parse(response);

          if (myObj.success == 1) {


            $('#' + profile + '').css('color', 'reds');
          } else {
            $('#' + profile + '').css('color', 'white');
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
  <!-- Modal -->
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
            <?php } else { ?>
              <div class="alert alert-secondary" role="alert">
                Nothing to Save
              </div>

            <?php } ?>

        </div>
        <div class="modal-footer">

          <button type="submit" class="btn btn-primary" <?php if ($_SESSION['Profilerefinedata']) { ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?>>Save</button>
        </div>

        </form>


      </div>
    </div>
  </div>



  <script type="text/javascript">
    var site_url = '<?php echo SITE_URL; ?>/';

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

          $('#offeramt' + reqid).val(obj.payment_currency);
          $('#currency' + reqid).val(obj.currency);


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
  <script type="text/javascript">
    $(function() {

      $(".auto_submit_item").change(function() {

        $("#myajexfrom").submit();
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#flip").click(function() {

        var text = $(this).text();
        if (text == "View All") {
          $(this).text("Show Less");
        } else {

          $(this).text("View All");
        }

        $("#panel").slideToggle("slow");
      });
    });
  </script>


  <div class="modal fade" id="reportuser" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
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
          <?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $profile['user_id'])); ?>
          <?php echo $this->Form->end(); ?>
          <div class="text-right m-top-20"><button class="btn btn-default" id="bn_subscribe">Submit</button></div>


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