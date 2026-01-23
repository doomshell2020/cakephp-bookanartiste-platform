<script>
  navigator.geolocation.getCurrentPosition(function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    // console.log("🚀 ~ file: profilesearch.ctp:4 ~ navigator.geolocation.getCurrentPosition ~ latitude:", latitude)
    // console.log("🚀 ~ file: profilesearch.ctp:5 ~ navigator.geolocation.getCurrentPosition ~ longitude:", longitude)

    // Store latitude and longitude in cookies
    document.cookie = 'latitude=' + latitude;
    document.cookie = 'longitude=' + longitude;

    // Set latitude and longitude in session using JavaScript
    sessionStorage.setItem('latitude', latitude);
    sessionStorage.setItem('longitude', longitude);
    // console.log("Location updated successfully!");

  }, function() {
    // Handle error or denial here
  });

  function newSearchButton() {
    $("#newrefinejob").submit();
  }
</script>

<style>
  .member-detail .chkprofile {
    position: absolute;
    top: 0px;
    left: 0px;
    z-index: 999;
  }

  .panel-right .member-detail {
    background: #fff;
    /* border: 20px; */
    padding: 15px;

    margin-bottom: 10px;
    border-bottom: 1px;
  }

  .member-detail-img img {

    width: 160px;
    height: 160px;
    object-fit: cover;
  }

  .icon-bar {
    right: 10px;
  }

  .member-detail .img-top-bar {
    background-color: rgba(0, 0, 0, 0.5);
    left: 0;
    bottom: 0;
    right: 0;
    padding: 5px;
    text-align: center;

  }

  .member-detail .box_hvr_checkndlt input[type="checkbox"] {
    margin: 5;
    padding: 0px;
    margin: 0px;
    border-radius: 0px;
    margin: 5px;
  }

  input[type=checkbox] {
    margin: 5;
    padding: 0px;
    margin: 0px;
    border-radius: 0px;
    margin: 5px;
  }

  .fa {
    display: inline-block;
    margin: 5px;
    font: normal normal normal 14px / 1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
</style>

<style>
  .job-link {
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
    display: flex;
    align-items: center;
    position: relative;
  }

  .info-icon {
    color: #888;
    cursor: pointer;
    margin-left: 8px;
    transition: color 0.3s ease;
    position: relative;
  }

  .info-icon:hover {
    color: #ff5722;
  }

  /* Tooltip styling */
  .info-icon::after {
    content: attr(data-tooltip);
    visibility: hidden;
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 5px 10px;
    border-radius: 4px;
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    font-size: 12px;
  }

  .info-icon:hover::after {
    visibility: visible;
    opacity: 1;
  }
</style>

<?php
// Retrieve latitude and longitude from cookies
$latitude = $_COOKIE['latitude'] ?? null;
$longitude = $_COOKIE['longitude'] ?? null;
$req_data['latitude'] = $latitude;
$req_data['longitude'] = $longitude;
$session = $this->request->session();
$session->delete('user_location');
$session->write("user_location", $req_data);
// pr($app);exit;
// pr($_SESSION['advanceprofiesearchdata']);exit;

?>

<?php
$user_idd = $this->request->session()->read('Auth.User.id');
// $session = $this->request->session();
// $session->read("user_location")
// pr($_SESSION); die;


$querytionarray = array();
$output = array_unique(array_column($refineparameterprofile, 'active'));
sort($output);

$active = [];
$gendaray = [];
$agearray = [];
$performancelan = [];
$languageknownarray = [];
$paymentfaqarray = [];
$userskillarray = [];
$profilepackagearray = [];
$recpackagearray = [];
$Enthicity = [];
$are = [];

// pr($refineparameterprofile);exit;
foreach ($refineparameterprofile as $value) {
  $data = $this->Comman->userskills($value['id']);
  if (!$data) continue; // Skip iteration if no skills found

  if ($value['active'] > 0) {
    $active[] = $value['active'];
  }

  if (!in_array($value['gender'], $gendaray)) {
    $gendaray[] = $value['gender'];
  }

  // Calculate Age
  $age = date_diff(date_create($value['dateofbirth']), date_create('today'))->y;
  if (!in_array($age, $agearray)) {
    $agearray[] = $age;
  }

  // Performing Languages
  foreach ($this->Comman->performainglanguage($value['user_id']) as $perlanguage) {
    $performancelan[$perlanguage['language']['id']] = $perlanguage['language']['name'];
  }

  // Known Languages
  foreach ($this->Comman->languageknown($value['user_id']) as $language) {
    $languageknownarray[$language['language']['id']] = $language['language']['name'];
  }

  // Payment Frequency
  foreach ($this->Comman->paymentfaq($value['user_id']) as $paymentfaq) {
    $paymentfaqarray[$paymentfaq['paymentfequency']['id']] = $paymentfaq['paymentfequency']['name'];
  }

  // User Skills
  foreach ($this->Comman->userskills($value['user_id']) as $userskill) {
    $userskillarray[$userskill['skill']['id']] = $userskill['skill']['name'];
  }

  // Packages
  foreach ($this->Comman->package($value['user_id']) as $packagedata) {
    if ($packagedata['package_type'] === "PR") {
      $packname = $this->Comman->profilepackagename($packagedata['package_id']);
      $profilepackagearray[$packname['id']] = $packname['name'];
    } elseif ($packagedata['package_type'] === "RC") {
      $packname = $this->Comman->recpackagename($packagedata['package_id']);
      $recpackagearray[$packname['id']] = $packname['title'];
    }
  }

  // Ethnicity
  if (!empty($value['title'])) {
    $Enthicity[$value['ethnicity']] = $value['title'];
  }

  // "Are You A" Field
  if (!empty($value['areyoua']) && !in_array($value['areyoua'], $are)) {
    $are[] = $value['areyoua'];
  }
}

// Min and Max Age
$minimumage = !empty($agearray) ? min($agearray) : 0;
$maxage = !empty($agearray) ? max($agearray) : 0;
// pr($minimumage);
// pr($maxage);exit;

if ($searchdata) {

  $agearray = array();
  $performancelan = array();
  $languageknownarray = array();
  $paymentfaqarray = array();
  $paymentfaqarray = array();
  $userskillarray = array();
  $querytionarray = array();
  $gendaray = array();
  $online = array();
  $rate = array();

  foreach ($refineparameterprofile as $key => $value) {
    //pr($value);
    if (date("Y-m-d h:i", strtotime($value['last_login'])) == date('Y-m-d h:i')) {
      $online[] = 1;
    } else {
      $online[] = 0;
    }
    if ($value['avgrating']) {
      $rate[] = $value['avgrating'];
    } else {
    }

    $data = $this->Comman->userskills($value['id']);
    if ($data) {
      $gen = $value['gender'];
      if (!in_array($gen, $gendaray))
        $gendaray[] = $value['gender'];

      $birthdate = date("Y-m-d", strtotime($value['dateofbirth']));

      $from = new DateTime($birthdate);
      $to   = new DateTime('today');
      $age = $from->diff($to)->y;
      if (!in_array($age, $agearray))
        $agearray[] = $age;

      $performlanguage = $this->Comman->performainglanguage($value['user_id']);


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

      //  pr($paymentfaq); 
      $userskill = $this->Comman->userskills($value['user_id']);

      foreach ($userskill as $userskill) {
        $userskillarray[$userskill['skill']['id']] = $userskill['skill']['name'];
      }
      if ($value['title']) {
        $Enthicity[$value['ethnicity']] = $value['title'];
      }
    }
  }

  //pr($areyouarray);
  $agearray = array();
  foreach ($refineparameterprofile as $key => $value) {

    // pr($value);die;
    $data = $this->Comman->userskills($value['id']);
    if ($data) {
      $birthdate = date("Y-m-d", strtotime($value['dateofbirth']));
      $from = new DateTime($birthdate);
      $to   = new DateTime('today');
      $age = $from->diff($to)->y;

      if (!in_array($age, $agearray))
        $agearray[] = $age;
    }
  }

  $minimumage = min($agearray);
  $maxage = max($agearray);
  //$maxage=$maxage+1;

?>

  <section id="page_search_result">
    <div id="askaplybutton" style="visibility:hidden;">
      <div class="container">
        <div class="pull-left top-three-but">
          <button type="button" class="btn btn-default m-right-20" data-toggle="modal" data-target="#multiplebooknow">Book Now</button>
        </div>
        <div class="pull-right top-three-but">
          <button type="button" class="btn btn-primary m-right-20" data-toggle="modal" data-target="#multipleaskquote">Ask For Quote</button>
        </div>
      </div>
    </div>

    <div class="container">
      <h2>Profile <span>Search Results</span></h2>
      <p class="m-bott-50">Here You Can See Search Result</p>
    </div>
    <?php echo $this->Flash->render(); ?>
    <span class="quotepurchasemessage"> </span>
    <div class="srch-box">
      <div class="container">


        <?php $c = 0;

        $count = 0;
        foreach ($_SESSION['advanceprofiesearchdata'] as $key => $value) {
          //echo $key;
          if ($key == "skillshow" || $key == "currentlocunit" || $key == "form" || $key == "optiontype" || $key == "unit") {
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

        <form class="form-horizontal">
          <div class="form-group">
            <?php if (!$_SESSION['advanceprofiesearchdata']) { ?>
              <?php if ($d) { ?>
                <div class="col-sm-2">
                  <label for="" class=" control-label">Word Search:</label>
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $d  ?>">
                </div>

              <?php } ?>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a>
            </div>
            <div class="col-sm-2">
              <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a>
            </div>
            <div class="col-sm-2">
              <?php
              if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                echo '<a style="background-color: #8B0000 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
              } else {

                echo '<a style="background-color: #e13580 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
              }
              ?>
            </div>
            <div class="col-sm-2">
              <?php
              if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
              } else {
                echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
              }
              ?>
              <!-- <button <?php
                            if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                              echo 'style="background-color: #228B22 !important;"';
                            } else {
                              echo 'style="background-color: #008B8B !important;"';
                            }
                            ?>
                class="btn btn-primary btn-block">Refine Search
              </button> -->
            </div>

          </div>
        </form>

      <?php } ?>

      <?php if ($count > 5) { ?> <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip" style="    position: absolute;
          right: 5px;
          top: 230px;">Show Less</a> <?php } ?>
      <div class="row" id="panel">

        <?php if (empty($_SESSION['advanceprofiesearchdata']['name']) && $_SESSION['advanceprofiesearchdata']['optiontype'] == 2) { ?>
          <form class="form-horizontal">
            <div class="form-group">
              <div class="col-sm-2">

                <label for="" class=" control-label">Talent Name:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
              </div>
              <div class="col-sm-2">
                <label for="" class=" control-label">Profile Title:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
              </div>
              <div class="col-sm-2">
                <label for="" class=" control-label">Word Search:</label>
                <input type="text" class="form-control" id="inputEmail3" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
              </div>
              <div class="col-sm-2">
                <label for="" class=" control-label">Talent Type:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
              </div>
              <div class="col-sm-2">
                <label for="" class=" control-label">Location:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
              </div>
            </div>
          </form>
        <?php } ?>

        <form class="form-horizontal">

          <div class="form-group">
            <?php if ($_SESSION['advanceprofiesearchdata']['name']) { ?>
              <div class="col-sm-2">

                <label for="" class=" control-label">Talent Name:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>" readonly>
              </div>
            <?php } ?>

            <?php if ($_SESSION['advanceprofiesearchdata']['profiletitle']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Profile Title:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['wordsearch']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Word Search:</label>
                <input type="text" class="form-control" id="inputEmail3" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['wordsearch'];  ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['skillshow']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Talent Type:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['location']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Location:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>" readonly>
              </div>
            <?php } ?>


            <?php if ($_SESSION['advanceprofiesearchdata']['within']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">With in :</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['within'];  ?>" readonly>
              </div>
            <?php } ?>


            <?php if ($_SESSION['advanceprofiesearchdata']['unit'] && $_SESSION['advanceprofiesearchdata']['within']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">unit :</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['unit'];  ?>" readonly>
              </div>
            <?php } ?>

            <?php if (!empty($_SESSION['advanceprofiesearchdata']['gender'])) { ?>
              <div class="col-sm-2">
                <label for="" class="control-label">Gender:</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly
                  value="<?php
                          $genderLabels = [
                            "m" => "Male",
                            "f" => "Female",
                            "bmf" => "Both Male and Female",
                            "a" => "Any"
                          ];

                          $selectedGenders = array_map(function ($gender) use ($genderLabels) {
                            return $genderLabels[$gender] ?? $gender;
                          }, $_SESSION['advanceprofiesearchdata']['gender']);

                          echo implode(", ", array_filter($selectedGenders));
                          ?>">
              </div>
            <?php } ?>


            <?php if ($_SESSION['advanceprofiesearchdata']['positionname']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Position Name :</label>

                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php echo $_SESSION['advanceprofiesearchdata']['positionname'] ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['country_id']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Country:</label>
                <?php $countrydata = $this->Comman->cnt($_SESSION['advanceprofiesearchdata']['country_id']);


                ?>
                <input type="text" class="form-control" id="inputEmail3" value="<?php if ($countrydata) {
                                                                                  echo $countrydata['name'];
                                                                                } ?>" readonly />
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['state_id']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">State :</label>
                <?php $statedata = $this->Comman->state($_SESSION['advanceprofiesearchdata']['state_id']);  ?>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($statedata) {
                                                                                                  echo $statedata['name'];
                                                                                                } ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['city_id']['0'] != "") { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">City:</label>

                <?php for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['city_id']); $i++) {

                  $citydata = $this->Comman->city($_SESSION['advanceprofiesearchdata']['city_id'][$i]);

                  $cityarray[] = $citydata['name'];
                } ?>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo implode(",", $cityarray); ?>" readonly>
              </div>
            <?php } ?>


            <?php if ($_SESSION['advanceprofiesearchdata']['clocation']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Current Location :</label>

                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['clocation'];  ?>" readonly>
              </div>
            <?php } ?>

            <?php if ($_SESSION['advanceprofiesearchdata']['cwithin']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Within :</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['cwithin'];  ?>" readonly>
              </div>
            <?php } ?>


            <?php if ($_SESSION['advanceprofiesearchdata']['currentlocunit'] && $_SESSION['advanceprofiesearchdata']['cwithin']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Unit :</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['currentlocunit'];  ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['currentlyworking']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Currently Working</label>

                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                  echo $_SESSION['advanceprofiesearchdata']['currentlyworking'];
                                                                                                } ?>" readonly>
              </div>
            <?php } ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['experyear']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Year of Experience </label>

                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                  echo str_replace(",", " to ", $_SESSION['advanceprofiesearchdata']['experyear']);
                                                                                                } ?>" readonly>
              </div>
            <?php } ?>

            <?php
            if (!empty($_SESSION['advanceprofiesearchdata']['active'])) {
              $activeOptions = [
                1 => "Last 15 days",
                2 => "Last 30 days",
                3 => "Last 45 days",
                4 => "Last 60 days",
                5 => "Last 3 Months",
                6 => "Last 6 Months"
              ];

              $activeLabel = $activeOptions[$_SESSION['advanceprofiesearchdata']['active']] ?? '';

              if ($activeLabel) {
            ?>
                <div class="col-sm-2">
                  <label class="control-label">Active In:</label>
                  <input type="text" class="form-control" readonly value="<?php echo $activeLabel; ?>">
                </div>
            <?php
              }
            }
            ?>


          </div>
          <?php if ($_SESSION['advanceprofiesearchdata']) { ?>
            <div class="form-group">
              <div class="col-sm-2">
                <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a>
              </div>
              <div class="col-sm-2">
                <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a>
              </div>
              <div class="col-sm-2">
                <!-- <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/profilesearch/reset" class="btn btn-primary btn-block">Refine Search</a> -->
                <?php
                if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                  echo '<a style="background-color: #8B0000 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
                } else {

                  echo '<a style="background-color: #e13580 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
                }
                ?>
              </div>
              <div class="col-sm-2">
                <?php
                if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                  echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                } else {
                  echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                }
                ?>
              </div>
            </div>


          <?php } ?>
        </form>

      </div>
      </div>
  </section>

  <div class="refine-search">
    <div class="container">
      <div class="row m-top-20">
        <div class="col-sm-4">
          <div class="panel panel-left">
            <h6>Refine Profile Search</h6>

            <!-- <form class="form-horizontal" method="get" action="<?php echo SITE_URL ?>/search/profilesearch" id="ajexrefine"> -->
            <form class="form-horizontal" method="get" action="<?php echo SITE_URL ?>/search/profilesearch" id="newrefinejob">

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                <div class="col-sm-12">
                  <input type="text" class="form-control auto_submit_item" placeholder="Name" value="<?php echo $refinename; ?>" name="name">
                </div>
              </div>

              <input type="hidden" class="form-control auto_submit_item" placeholder="words" value="<?php echo $d; ?>" name="words">
              <div class="form-group salry">
                <label for="inputEmail3" class="col-sm-12 control-label">Age </label>
                <p class="prc_sldr">
                  <label for="amount">Age</label>
                  <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="age" class="auto_submit_item">
                </p>
                <div id="slider-range"></div>

              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Gender</label>
                <div class="col-sm-12">

                  <select class="form-control auto_submit_item" name="gender">
                    <option value="">Select Gender</option>
                    <?php
                    $genderLabels = [
                      'a' => 'Any',
                      "m" => "Male",
                      "f" => "Female",
                      "o" => "Other",
                      "bmf" => "Both Male and Female"
                    ];

                    foreach ($gendaray as $gender) {
                      // $selected = ($gender == $gen) ? 'selected' : '';
                      echo "<option value='$gender' $selected>{$genderLabels[$gender]}</option>";
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="form-group">

                <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
                <div class="col-sm-12">
                  <select class="form-control auto_submit_item" name="performancelan[]" multiple="">
                    <option value="0">Select Language</option>
                    <?php foreach ($performancelan as $key => $value) { ?>
                      <option value="<?php echo $key; ?>" <?php if (in_array($key, $performancelansel)) {
                                                            echo "selected";
                                                          } ?>><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                <div class="col-sm-12">
                  <select class="form-control auto_submit_item" name="language[]" multiple="">
                    <option value="0">Select Language</option>
                    <?php foreach ($languageknownarray as $key => $value) { ?>
                      <option value="<?php echo $key; ?>" <?php if (in_array($key, $languagesel)) {
                                                            echo "selected";
                                                          } ?>><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php if ($user_idd) { ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Online Now </label>
                  <div class="col-sm-12">
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio1" value="0" class="auto_submit_item" <?php if ($live == 0) {
                                                                                                                echo "checked";
                                                                                                              } ?>>
                      All </label>

                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio2" value="1" <?php if ($live == 1) {
                                                                                      echo "checked";
                                                                                    } ?> class="auto_submit_item">
                      Online </label>

                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio3" value="2" <?php if ($live == 2) {
                                                                                      echo "checked";
                                                                                    } ?> class="auto_submit_item">
                      Offline </label>
                  </div>
                </div>
              <?php } ?>



              <?php $vitalstatic = array();  ?>
              <?php if ($myvital) {  ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Vital Statistics parameters </label>
                  <?php $i = 0;
                  foreach ($myvital as $key => $value) {   ?>


                    <p class="prc_sldr">
                      <label for="amount"><?php echo  $key; ?></label>

                    </p>

                    <?php if ($key != '') { ?>

                      <div class="col-sm-12">
                        <select class="form-control auto_submit_item" name="vitalstats[<?php echo  $key; ?>][]" multiple="">
                          <option value="0">Select <?php echo  $key; ?> </option>
                          <?php foreach ($value as $key => $opt) { ?>

                            <option value="<?php echo $key ?>" <?php if (in_array($key, $vitalarray)) {
                                                                  echo "selected";
                                                                } ?> class="auto_submit_item"><?php echo $opt ?></option>

                          <?php } ?>

                        </select>
                      </div>

                    <?php } ?>

                  <?php $i++;
                  } ?>
                </div>
              <?php }  ?>


              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
                <div class="col-sm-12">
                  <!--        <select class="form-control auto_submit_item" name="activein">
                              <option value="0">Select Active in</option>
                              <option value="5" <?php if ($day == 5) {
                                                  echo "selected";
                                                } ?> >5 days</option>
                              <option value="10" <?php if ($day == 10) {
                                                    echo "selected";
                                                  } ?> >10 days</option>
                              <option value="15" <?php if ($day == 15) {
                                                    echo "selected";
                                                  } ?> >15 days</option>
                              <option value="20" <?php if ($day == 20) {
                                                    echo "selected";
                                                  } ?> >20 days</option>
                              <option value="25" <?php if ($day == 25) {
                                                    echo "selected";
                                                  } ?> >25 days</option>
                              <option value="30" <?php if ($day == 30) {
                                                    echo "selected";
                                                  } ?> >30 days</option>
                            </select> -->

                  <!-- <select class="form-control auto_submit_item" name="activein"   >
                              <option value="0" >Select Active in</option>
                              <?php foreach ($output as $key => $value) {
                                //pr($value);   
                              ?>
                                <option value="<?php echo $value['active']; ?>"<?php if ($day == $value) {
                                                                                  echo "selected";
                                                                                } ?> ><?php echo $value; ?> days</option>
                              <?php } ?>
                            </select> -->

                  <select class="form-control auto_submit_item" name="activein">
                    <option value="0">Select Active In</option>
                    <?php foreach ($output as  $value) {  ?>
                      <option value="<?php echo $value; ?>" <?php if ($day == $value) {
                                                              echo "selected";
                                                            } ?>><?php echo $value; ?> days</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
                <div class="col-sm-12">
                  <select class="form-control auto_submit_item" name="paymentfaq">
                    <option value="0">Select Payment Frequency </option>
                    <?php foreach ($paymentfaqarray as $key => $value) { ?>
                      <option value="<?php echo $key; ?>" <?php if ($payment == $key) {
                                                            echo "selected";
                                                          } ?>><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                <div class="col-sm-12">

                  <select class="form-control auto_submit_item" name="skill">
                    <option value="0">Select Talent Type</option>
                    <?php foreach ($userskillarray as $key => $skillvalue) { ?>
                      <option value="<?php echo $key ?>" <?php if ($skill == $key) {
                                                            echo "selected";
                                                          } ?>> <?php echo  $skillvalue; ?> </option>

                    <?php } ?>
                  </select>
                </div>
              </div>
              <input type="hidden" name="refine" value="2">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Ethnicity</label>
                <div class="col-sm-12">
                  <select class="form-control auto_submit_item" name="ethnicity[]" multiple="">
                    <option value="0">Select Ethnicity </option>
                    <?php foreach ($Enthicity as $key => $Enthicity) { ?>
                      <option value="<?php echo $key ?>" <?php if (in_array($key, $ethnicity)) {
                                                            echo "selected";
                                                          } ?>><?php echo  $Enthicity; ?> </option>

                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group Review">
                <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>
                <?php if ($rate) { ?>
                  <input type="radio" style="margin-left: 10px;" name="allrated" value="rate" class="auto_submit_item" <?php if ($rated == "rate") {
                                                                                                                          echo "checked";
                                                                                                                        } ?> /> All Rated
                <?php } ?>
                <input type="radio" name="allrated" value="unrate" class="auto_submit_item" <?php if ($rated == "unrate") {
                                                                                              echo "checked";
                                                                                            } ?> /> Not Reviewed

                <input type="radio" name="allrated" value="all" class="auto_submit_item" <?php if ($rated == "") {
                                                                                            echo "checked";
                                                                                          } ?> /> All
                <?php if ($rate) { ?>
                  <?php if (max($rate) >= 9) { ?>
                    <a href="javascript:void(0)" class="review" rel="9">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>

                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>

                  <?php if (max($rate) >= 8) { ?>
                    <a href="javascript:void(0)" class="review" rel="8">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <?php if (max($rate) >= 7) { ?>
                    <a href="javascript:void(0)" class="review" rel="7">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <?php if (max($rate) >= 6) { ?>
                    <a href="javascript:void(0)" class="review" rel="6">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <?php if (max($rate) >= 5) { ?>
                    <a href="javascript:void(0)" class="review" rel="5">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <?php if (max($rate) >= 4) { ?>
                    <a href="javascript:void(0)" class="review" rel="4">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <br>
                  <?php if (max($rate) >= 3) { ?>
                    <a href="javascript:void(0)" class="review" rel="3">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <br>
                  <?php if (max($rate) >= 2) { ?>
                    <a href="javascript:void(0)" class="review" rel="2">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                  <br>
                  <?php if (max($rate) >= 1) { ?>
                    <a href="javascript:void(0)" class="review" rel="1" id="my">
                      <span class="fa fa-star" style="color: orange"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      <span class="fa fa-star"></span>
                      & up
                    </a>
                  <?php } ?>
                <?php  } ?>
                <input type="hidden" name="r3" id="rvi" value="<?php if ($r3) {
                                                                  echo $r3;
                                                                } ?>" class="auto_submit_item" />
                <script type="text/javascript">
                  var array = [];
                  $(".review").click(function() {
                    array = $(this).attr('rel');
                    //alert"Tes");
                    $('#rvi').val(array[0])

                    $("#ajexrefine").submit();
                    //alert(array[0]);
                  });
                </script>

              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Membership type</label>
                <div class="col-sm-12">
                  <select class="form-control auto_submit_item" name="workingstyle[]" multiple="">
                    <option value="0" disabled>Select Membership type</option>
                    <?php for ($i = 0; $i < count($are); $i++) { ?>
                      <option value="<?php echo $are[$i] ?>" <?php if (in_array($are[$i], $workingstyleasel)) {
                                                                echo "selected";
                                                              } ?>>
                        <?php if ($are[$i] == "P") {
                          echo "Professional";
                        } else if ($are[$i] == "A") {
                          echo "Amateur";
                        } elseif ($are[$i] == "PT") {
                          echo "Part time";
                        } else if ($are[$i] == "H") {
                          echo "Hobbyist";
                        } ?>



                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Search By Package</label>
                <?php foreach ($searchdata as $key => $value) {



                  $data = $this->Comman->userskills($value['id']);
                  if ($data) {

                    //pr($value);
                    if ($value['areyoua']) {

                      $areyou = $value['areyoua'];
                      if (!in_array($areyou, $are)) {
                        $are[] = $value['areyoua'];
                      }
                    }
                  }
                }


                ?>
                <div class="col-sm-12">

                  <select class="form-control auto_submit_item" name="profilepackage">
                    <option value="0">Profile Membership package</option>
                    <?php foreach ($profilepackagearray as $key => $skillvalue) { ?>
                      <option value="<?php echo $key ?>" <?php if ($pid == $key) {
                                                            echo "selected";
                                                          } ?>> <?php echo  $skillvalue; ?> </option>

                    <?php } ?>
                  </select>


                  <select class="form-control auto_submit_item" name="recpackage">
                    <option value="0">Recruiter Membership package</option>
                    <?php foreach ($recpackagearray as $key => $skillvalue) { ?>
                      <option value="<?php echo $key ?>" <?php if ($rid == $key) {
                                                            echo "selected";
                                                          } ?>> <?php echo  $skillvalue; ?> </option>

                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <!-- 
                  <?php if ($backtorefine == 1) { ?>

                    <a href=" <?php echo SITE_URL; ?>/search/profilesearch?<?php echo $this->request->session()->read('backtorefinesearchprofile'); ?>" class="btn btn-default">Back to Search Result </a>
                  <?php } else {  ?>
                    <a href="javascript:void(0)" class="btn btn-default" ?>Back to Search Result </a>
                  <?php } ?> -->

                  <?php
                  if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                    echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                  } else {
                    echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                  }
                  ?><br />

                  <?php if ($backtorefine == 1) { ?>
                    <a href="javascript:void(0)" style="background-color: #8B0000 !important;" class="btn btn-default" onclick="window.history.back()">Back to Search Result</a>
                  <?php } else { ?>
                    <a href="javascript:void(0)" class="btn btn-default">Back to Search Result</a>
                  <?php } ?>

                </div>


              </div>



            </form>


          </div>
          <?php
          $id = $this->request->session()->read('Auth.User.id');
          $advrtprofile = $this->Comman->advertisedprofile($id);
          $access_adds = $this->Comman->isaccessadds($id);
          //pr($advrtprofile); die; 
          if ($access_adds['access_adds'] == 'Y') { ?>
            <div class="owl-carousel owl-theme owl-loaded advrtpro" id="adproprofile">
              <?php foreach ($advrtprofile as $key => $value) {
                $userskills = $this->Comman->userskills($value['pro_id']);

              ?>
                <div class="owl-item proadmain">
                  <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['pro_id']; ?>" target="_blank">
                    <div>
                      <?php if ($value['advrt_image']) { ?>
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $value['advrt_image']; ?>">
                      <?php } else { ?>
                        <img src="<?php echo SITE_URL; ?>/images/noimage.jpg">
                      <?php } ?>
                    </div>
                    <div class="advrttext">
                      <?php
                      echo $value['advrtpro__title'] . "<br>";
                      foreach ($userskills as $key => $skillvalue) {
                        echo $skillvalue['skill']['name'] . ",";
                      }
                      echo "<br>" . $value['location'] . "<br>";
                      ?>
                    </div>

                  </a>
                  <?php if ($access_adds['role_id'] == TALANT_ROLEID) { ?>
                    <a href="<?php echo SITE_URL; ?>/advertiseprofile" target="_blank" class="admyreqr" data-toggle="popover" data-trigger="hover" title="Advertise My Profile">+</a>
                  <?php } ?>

                </div>
              <?php } ?>
            </div>
          <?php } ?>

          <script>
            $('#adproprofile').owlCarousel({
              loop: false,
              margin: 10,
              nav: true,
              dots: false,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 1
                },
                1000: {
                  items: 1
                }
              }
            })
          </script>

          <style type="text/css">
            .advrtpro.owl-carousel .owl-nav .owl-next,
            .advrtpro.owl-carousel .owl-nav .owl-prev {
              font-size: 0px;
              position: absolute;
              top: 42%;
            }


            .advrtpro.owl-carousel .owl-nav .owl-prev:before {
              content: '\f104';
              color: #0c8fe7;
              font: normal normal normal 28px/1 FontAwesome;
              font-weight: bold;
            }

            .advrtpro.owl-carousel .owl-nav .owl-prev {
              left: 5px;
              background-color: rgba(176, 170, 170, 0.6);
              padding: 2px 8px;
            }

            .advrtpro.owl-carousel .owl-nav .owl-next:before {
              content: '\f105';
              color: #0c8fe7;
              font: normal normal normal 28px/1 FontAwesome;
              font-weight: bold;
            }

            .advrtpro.owl-carousel .owl-nav .owl-next {
              right: 5px;
              background-color: rgba(176, 170, 170, 0.6);
              padding: 2px 8px;
            }

            .proadmain {
              margin-top: 15px;
              width: 100%;
              position: relative;

            }

            .proadmain img {
              min-height: 265px !important;
              border-bottom: 4px #1a8fe4 solid;
            }

            .advrtpro {
              box-shadow: 1px 1px 11px 0px #a2a2a2;
            }

            .proadmain a {
              width: 100%;
            }

            .proadmain img {
              width: 100%;
            }

            .advrttext {
              text-align: center;
              color: #000000;
              font-size: 16px;
            }

            .admyreqr {
              display: none;
            }

            .advrtpro .proadmain:hover .admyreqr {
              z-index: 9;
              display: block;
              position: absolute;
              top: -5;
              left: 92%;
              color: #0798f7;
              font-size: 26px;
              font-weight: bold;
              padding: 0px 6px;
              background-color: rgba(0, 0, 0, 0.6);
            }
          </style>
        </div>

        <div class="col-sm-8" id="data">
          <div class="panel-right">
            <div class="clearfix job-box">

              <?php
              $isset = 0;
              foreach ($searchdata as $value) {  // pr($value); die;

                $picon = $this->Comman->profilepack($value['p_package']);
                $ricon = $this->Comman->recpack($value['r_package']);

                $data = $this->Comman->userskills($value['id']);
                if ($data) {

                  if ($rated == "unrate") {
                    if ($value['avgrating']) continue;
                  }


                  if (!in_array($value['id'], $_SESSION['profilesearch'])) {
              ?>

                    <?php

                    //pr($this->request->query);
                    if (!empty($this->request->query['within']) ||  !empty($_SESSION['advanceprofiesearchdata']['within'])) {

                      if ($this->request->query['location']) {
                        $location = $this->request->query['location'];
                      } else {
                        $location = $_SESSION['advanceprofiesearchdata']['location'];
                      }

                      $locationcl = $this->Comman->get_driving_information($location, $value['location']);

                      if ($this->request->query['unit']) {
                        $claculationunit = $this->request->query['unit'];
                      } else {
                        $claculationunit = $_SESSION['advanceprofiesearchdata']['unit'];
                      }
                      if ($claculationunit == "mi") {
                        $dis = (int)(preg_replace("/[a-zA-Z]/", "", $locationcl)) * (0.621371);
                      } else {
                        $locationcl = str_replace(",", " ", $locationcl);
                        $locationcl = str_replace(" ", " ", $locationcl);
                        $dis = (int)preg_replace("/[a-zA-Z]/", "", $locationcl);
                      }
                      //$distance=(int)preg_replace("/[a-zA-Z]/","",$locationcl);
                      if ($this->request->query['within']) {
                        $within = $this->request->query['within'];
                      } else {
                        $within = $_SESSION['advanceprofiesearchdata']['within'];
                      }
                      if ($dis <= $within) {
                        $isset = 1; ?>


                        <div class="member-detail  box row">
                          <div class="box_hvr_checkndlt chkprofile">
                            <?php
                            $bookjob = $this->Comman->bookjob($value['user_id']);
                            $askquote = $this->Comman->askquote($value['user_id']);

                            ?>
                            <input type="checkbox" name="profile[]" value="<?php echo $value['user_id']; ?>" class="chkask askqoute" data-val="<?php echo $value['user_id']; ?>" id="myask<?php echo $value['id'] ?>">


                            <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                          </div>

                          <div class="col-sm-3">
                            <div class="member-detail-img">
                              <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank">
                                <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']; ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                              </a>
                              <div class="img-top-bar">
                                <?php if ($ricon['id']) { ?>
                                  <img
                                    src="<?php echo SITE_URL ?>/img/<?php echo $picon['icon'] ?>"
                                    style="height: 2%; width: 15%"
                                    title="<?php echo $picon['name'] ?> Profile" />

                                  <img
                                    src="<?php echo SITE_URL ?>/img/<?php echo $ricon['icon'] ?>"
                                    style="height: 2%; width: 15%"
                                    title="<?php echo $ricon['title'] ?> Recruiter" />

                                <?php }  ?>

                                <!-- <a href="<?php //echo SITE_URL;  
                                              ?>/viewprofile/<?php //echo $value['user_id']; 
                                                              ?>" class="fa fa-user"> -->
                                </a>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-9 boc_gap">
                            <div class="row">
                              <ul class="col-sm-4 member-info list-unstyled">
                                <li>Name</li>
                                <li>Gender</li>
                                <li>Talent</li>
                                <li>Current Location</li>
                                <li>From Location</li>
                                <li>Experience</li>
                              </ul>
                              <ul class="col-sm-2 list-unstyled">
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                              </ul>
                              <ul class="col-sm-6 list-unstyled">
                                <li><a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank"><?php echo $value['name'] ?></a></li>
                                <li><?php
                                    switch ($value['gender']) {
                                      case 'm':
                                        echo "Male";
                                        break;
                                      case 'f':
                                        echo "Female";
                                        break;
                                      case 'bmf':
                                        echo "Male and Female";
                                        break;
                                      case 'o':
                                        echo "Other";
                                        break;
                                    }

                                    ?></li>
                                <li><?php foreach ($data as $skillvalue) {

                                      echo  $skill = $skillvalue['skill']['name'] . ",";
                                    }  ?></li>
                                <li><?php echo $value['current_location'] ? $value['current_location'] : '-';  ?></li>
                                <li><?php echo $value['location'] ? $value['location'] : '-';  ?></li>
                                <li><?php if ($value['pyear']) {
                                      //pr($value);
                                      echo $value['pyear'];

                                      //echo date('Y')-abs($type) ;
                                      //echo date('Y',date('Y')-strtotime($value['yearexpe'])); 
                                      echo " Years";
                                    } else {
                                      echo "-";
                                    };
                                    ?></li>

                              </ul>
                            </div>

                            <?php if ($user_idd) { ?>
                              <a href="#" class="btn btn-default ad singlebooknow" data-toggle="modal" data-profile="<?php echo $value['id'] ?>" data-target="#singlebooknow">Book Now</a>
                              <a href="#" class="btn btn-default qot singleaskquote" data-profile="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#singleaskquote">Ask For Quote</a>

                            <?php } else { ?>
                              <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Book Now</a>
                              <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Ask For Quote</a>
                            <?php } ?>

                          </div>

                          <?php $totaluserlikes = $this->Comman->likess($value['user_id']);
                          $profilesave = $this->Comman->profilesave($value['user_id']);
                          ?>
                          <div class="icon-bar">
                            <?php if ($user_idd) { ?>
                              <a href="javascript:void(0)" class="likeprofile<?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>" id="likeprofile<?php echo $value['user_id'] ?>" data-toggle="tooltip" data-val="<?php echo ($value['user_id']) ? $value['user_id'] : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

                              <a href="#" class="fa fa-share"></a>

                              <a href="javascript:void(0)" data-val="<?php echo $value['user_id']; ?>" class="sendmessage" data-toggle="tooltip" title="Send Message"><i class="fa fa-envelope"></i></a>

                              <!-- <a href="#" class="fa fa-paper-plane-o"></a>                  -->
                              <a href="#" class="fa fa-floppy-o saveprofile" id="<?php echo $value['id'] ?>" data-profile="<?php echo $value['id'] ?>" <?php if ($profilesave) { ?> style="color:red" <?php  } ?>></a>
                              <a href="<?php echo SITE_URL; ?>/profile/profilecountersearch/<?php echo $value['id'] ?>" class="fa fa-download"></a>
                              <a href="<?php echo SITE_URL ?>/profile/reportspamsearch/<?php echo $value['id']; ?>" class="report fa fa-flag" data-target="#reportuser" title="Report"></a>
                              <!--<a href="#" class="fa fa-ban"></a>  -->

                            <?php } else { ?>
                              <a href="<?php echo SITE_URL; ?>/login" title="Like"><i class="fa fa-thumbs-up"></i></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-share"></a>
                              <a href="<?php echo SITE_URL; ?>/login" title="Send Message"><i class="fa fa-envelope"></i></a>
                              <!-- <a href="#" class="fa fa-paper-plane-o"></a>                  -->
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-floppy-o saveprofile"></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-download"></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="report fa fa-flag" title="Report"></a>
                              <!--<a href="#" class="fa fa-ban"></a>  -->

                            <?php } ?>
                          </div>

                        </div>

                      <?php }
                    } else if (!empty($this->request->query['cwithin']) || !empty($_SESSION['advanceprofiesearchdata']['cwithin'])) { ?>
                      <?php
                      if ($this->request->query['clocation']) {
                        $clocation = $this->request->query['clocation'];
                      } else {
                        $clocation = $_SESSION['advanceprofiesearchdata']['clocation'];
                      }
                      $locationcl = $this->Comman->get_driving_information($clocation, $value['current_location']);
                      if ($this->request->query['currentlocunit']) {
                        $claculationunit = $this->request->query['currentlocunit'];
                      } else {
                        $claculationunit = $_SESSION['advanceprofiesearchdata']['currentlocunit'];
                      }
                      if ($claculationunit == "mi") {
                        $cdis = (int)(preg_replace("/[a-zA-Z]/", "", $locationcl)) * (0.621371);
                      } else {
                        $locationcl = str_replace(",", " ", $locationcl);
                        $locationcl = str_replace(" ", " ", $locationcl);
                        $cdis = (int)preg_replace("/[a-zA-Z]/", "", $locationcl);
                      }
                      //pr($this->request->query);
                      if ($this->request->query['cwithin']) {
                        $cwithin = $this->request->query['cwithin'];
                      } else {
                        $cwithin = $_SESSION['advanceprofiesearchdata']['cwithin'];
                      }
                      if ($cdis <= $cwithin) {
                        $isset = 1; ?>

                        <div class="member-detail  box row">
                          <div class="box_hvr_checkndlt chkprofile">
                            <?php
                            $bookjob = $this->Comman->bookjob($value['user_id']);
                            $askquote = $this->Comman->askquote($value['user_id']);

                            ?>


                            <input type="checkbox" name="profile[]" value="<?php echo $value['user_id']; ?>" class="chkask askqoute" data-val="<?php echo $value['user_id']; ?>" id="myask<?php echo $value['id'] ?>" title="Select multiple profile for single click Book Now and Ask For Quote">


                            <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                          </div>

                          <div class="col-sm-3">
                            <div class="member-detail-img">
                              <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank">

                                <?php if (strpos($value['profile_image'], '.png') || strpos($value['profile_image'], '.jpg')) { ?>
                                  <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                                <?php } else { ?>
                                  <img src="<?php echo $value['profile_image'];  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                                <?php } ?>
                              </a>
                              <div class="img-top-bar">
                                <!-- <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" class="fa fa-user"></a>  -->
                                <?php if ($ricon['id']) { ?>
                                  <img
                                    src="<?php echo SITE_URL ?>/img/<?php echo $picon['icon'] ?>"
                                    style="height: 2%; width: 15%"
                                    title="<?php echo $picon['name'] ?> Profile" />

                                  <img
                                    src="<?php echo SITE_URL ?>/img/<?php echo $ricon['icon'] ?>"
                                    style="height: 2%; width: 15%"
                                    title="<?php echo $ricon['title'] ?> Recruiter" />

                                <?php }  ?>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-9 boc_gap">
                            <div class="row">
                              <ul class="col-sm-4 member-info list-unstyled">
                                <li>Name</li>
                                <li>Gender</li>
                                <li>Talent</li>
                                <li>Current Location</li>
                                <li>From Location</li>

                                <li>Experience</li>
                              </ul>
                              <ul class="col-sm-2 list-unstyled">
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                                <li>:</li>
                              </ul>
                              <ul class="col-sm-6 list-unstyled">
                                <li><a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank"><?php echo $value['name'] ?></a></li>
                                <li><?php
                                    switch ($value['gender']) {
                                      case 'm':
                                        echo "Male";
                                        break;
                                      case 'f':
                                        echo "Female";
                                        break;
                                      case 'bmf':
                                        echo "Male and Female";
                                        break;
                                      case 'o':
                                        echo "Other";
                                        break;
                                    }

                                    ?></li>
                                <li><?php foreach ($data as $skillvalue) {



                                      echo  $skill = $skillvalue['skill']['name'] . ",";
                                    }  ?></li>
                                <li><?php echo $value['current_location'] ? $value['current_location'] : '-';  ?></li>
                                <li><?php echo $value['location'] ? $value['location'] : '-';  ?></li>
                                <li><?php if ($value['pyear']) {
                                      //pr($value);
                                      echo $value['pyear'];

                                      //echo date('Y')-abs($type) ;
                                      //echo date('Y',date('Y')-strtotime($value['yearexpe'])); 
                                      echo " Years";
                                    } else {
                                      echo "-";
                                    };
                                    ?></li>

                              </ul>
                            </div>




                            <!-- <a href="#"  class="btn btn-default ad singlebooknow"  data-toggle="modal" data-profile="<?php echo $value['id'] ?>"  data-target="#singlebooknow">Book Now</a>
  
  
  
                          <a href="#"  class="btn btn-default qot singleaskquote" data-profile="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#singleaskquote">Ask For Quote</a> -->

                            <?php if ($user_idd) { ?>
                              <a href="#" class="btn btn-default ad singlebooknow" data-toggle="modal" data-profile="<?php echo $value['id'] ?>" data-target="#singlebooknow">Book Now</a>

                              <!-- <a href="javascript:void(0)" data-val="<?php echo $value['id'] ?>"  data-action="book" class="btn btn-default book">Book Now </a>  -->

                              <!-- <a href="javascript:void(0)" data-val="<?php echo $profile->user_id; ?>" data-action="book" class="btn btn-default book">Book <?php echo $profile->name; ?> </a> -->

                              <a href="#" class="btn btn-default qot singleaskquote" data-profile="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#singleaskquote">Ask For Quote</a>

                            <?php } else { ?>
                              <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Book Now</a>
                              <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Ask For Quote</a>
                            <?php } ?>

                          </div>

                          <?php $totaluserlikes = $this->Comman->likess($value['user_id']);
                          $profilesave = $this->Comman->profilesave($value['user_id']);
                          ?>
                          <div class="icon-bar">
                            <?php if ($user_idd) { ?>
                              <a href="javascript:void(0)" class="likeprofile  <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>" id="likeprofile<?php echo $value['user_id'] ?>" data-toggle="tooltip" data-val="<?php echo ($value['user_id']) ? $value['user_id'] : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>
                              <!-- comment share -->
                              <!-- <a href="#" class="fa fa-share"></a> -->
                              <a href="javascript:void(0)" class="fa fa-share fb" data-link="http://bookanartiste.com/applyjob/<?php echo $value['id'] ?>" data-img="<?php echo SITE_URL . "/job/" . $value['image'];  ?>" data-title="BookAnArtiste"></a>
                              <script type="text/javascript">
                                $(document).ready(function() {

                                  $('.fb').click(function(e) {
                                    var link = $(this).data('link');
                                    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(link), 'sharer', 'toolbar=0,status=0,width=626,height=436');
                                    return false;
                                  });
                                });
                              </script>

                              <a href="javascript:void(0)" data-val="<?php echo $value['user_id']; ?>" class="sendmessage " data-toggle="tooltip" title="Send Message"><i class="fa fa-envelope"></i></a>
                              <!-- <a href="<?php echo SITE_URL; ?>/message/sendmessage/<?php echo $value['user_id']; ?>" data-toggle="tooltip" title="Send message"><i class="fa fa-envelope"></i></a> -->
                              <!-- 
                                <a href="#" class="fa fa-paper-plane-o"></a>                  -->
                              <a href="#" class="fa fa-floppy-o saveprofile" id="<?php echo $value['id'] ?>" data-profile="<?php echo $value['id'] ?>" <?php if ($profilesave) { ?> style="color:red" <?php  } ?>></a>
                              <a href="<?php echo SITE_URL; ?>/profile/profilecountersearch/<?php echo $value['id'] ?>" class="fa fa-download"></a>
                              <!-- by rupam sir -->
                              <a href="<?php echo SITE_URL; ?>/profile/reportspamsearch/<?php echo $value['id']; ?>" class="report fa fa-flag" title="Report"></a>

                              <!-- <a href="<?php echo SITE_URL; ?>/profile/reportspamsearch/<?php echo $value['id']; ?>" class="fa fa-flag" title="Report"></a> -->
                              <!--<a href="#" class="fa fa-ban"></a>  -->
                            <?php } else { ?>
                              <a href="<?php echo SITE_URL; ?>/login" title="Like"><i class="fa fa-thumbs-up"></i></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-share"></a>
                              <a href="<?php echo SITE_URL; ?>/login" title="Send Message"><i class="fa fa-envelope"></i></a>
                              <!-- <a href="#" class="fa fa-paper-plane-o"></a>                  -->
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-floppy-o saveprofile"></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="fa fa-download"></a>
                              <a href="<?php echo SITE_URL; ?>/login" class="report fa fa-flag" title="Report"></a>
                              <!--<a href="#" class="fa fa-ban"></a>  -->

                            <?php } ?>
                          </div>

                        </div>

                      <?php $isset = 1;
                      }
                    } else {
                      $isset = 1; ?>
                      <div class="member-detail  box row">
                        <div class="box_hvr_checkndlt chkprofile">
                          <?php
                          $bookjob = $this->Comman->bookjob($value['user_id']);
                          $askquote = $this->Comman->askquote($value['user_id']);

                          ?>


                          <input type="checkbox" name="profile[]" value="<?php echo $value['user_id']; ?>" class="chkask askqoute" data-val="<?php echo $value['user_id']; ?>" id="myask<?php echo $value['id'] ?>">


                          <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>


                        <div class="col-sm-3">
                          <div class="member-detail-img">
                            <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank">
                              <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                            </a>
                            <div class="img-top-bar">
                              <?php if ($ricon['id']) { ?>
                                <img
                                  src="<?php echo SITE_URL ?>/img/<?php echo $picon['icon'] ?>"
                                  style="height: 2%; width: 15%"
                                  title="<?php echo $picon['name'] ?> Profile" />

                                <img
                                  src="<?php echo SITE_URL ?>/img/<?php echo $ricon['icon'] ?>"
                                  style="height: 2%; width: 15%"
                                  title="<?php echo $ricon['title'] ?> Recruiter" />

                              <?php }  ?>
                              <!-- <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" class="fa fa-user">
                              </a>  -->
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-9 boc_gap">
                          <div class="row">
                            <ul class="col-sm-4 member-info list-unstyled">
                              <li>Name</li>
                              <li>Gender</li>
                              <li>Talent</li>
                              <li>Current Location</li>
                              <li>From Location</li>
                              <li>Experience</li>
                            </ul>
                            <ul class="col-sm-2 list-unstyled">
                              <li>:</li>
                              <li>:</li>
                              <li>:</li>
                              <li>:</li>
                              <li>:</li>
                              <li>:</li>
                            </ul>
                            <ul class="col-sm-6 list-unstyled">
                              <li><a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank"><?php echo $value['name'] ?></a></li>
                              <li><?php
                                  switch ($value['gender']) {
                                    case 'm':
                                      echo "Male";
                                      break;
                                    case 'f':
                                      echo "Female";
                                      break;
                                    case 'bmf':
                                      echo "Male and Female";
                                      break;
                                    case 'o':
                                      echo "Other";
                                      break;
                                  }

                                  ?></li>
                              <li><?php foreach ($data as $skillvalue) {



                                    echo  $skill = $skillvalue['skill']['name'] . ",";
                                  }  ?></li>
                              <li><?php echo $value['current_location'] ? $value['current_location'] : '-';  ?></li>
                              <li><?php echo $value['location'] ? $value['location'] : '-';  ?></li>
                              <li><?php if ($value['pyear']) {
                                    //pr($value);
                                    echo $value['pyear'];

                                    //echo date('Y')-abs($type) ;
                                    //echo date('Y',date('Y')-strtotime($value['yearexpe'])); 
                                    echo " Years";
                                  } else {
                                    echo "-";
                                  };
                                  ?></li>

                            </ul>
                          </div>



                          <?php if ($user_idd) { ?>
                            <a href="#" class="btn btn-default ad singlebooknow" data-toggle="modal" data-profile="<?php echo $value['id'] ?>" data-target="#singlebooknow">Book Now</a>
                            <a href="#" class="btn btn-default qot singleaskquote" data-profile="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#singleaskquote">Ask For Quote</a>
                          <?php } else { ?>
                            <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Book Now</a>
                            <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default">Ask For Quote</a>
                          <?php } ?>

                        </div>

                        <?php $totaluserlikes = $this->Comman->likess($value['user_id']);
                        $profilesave = $this->Comman->profilesave($value['user_id']);
                        ?>
                        <div class="icon-bar">
                          <?php if ($user_idd) { ?>
                            <a href="javascript:void(0)" class="likeprofile  <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>" id="likeprofile<?php echo $value['user_id'] ?>" data-toggle="tooltip" data-val="<?php echo ($value['user_id']) ? $value['user_id'] : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

                            <!-- <a href="#" class="fa fa-share"></a> -->
                            <a href="javascript:void(0)" class="fa fa-share fb" data-link="http://bookanartiste.com/applyjob/<?php echo $value['id'] ?>" data-img="<?php echo SITE_URL . "/job/" . $value['image'];  ?>" data-title="BookAnArtiste"></a>
                            <script type="text/javascript">
                              $(document).ready(function() {

                                $('.fb').click(function(e) {
                                  var link = $(this).data('link');
                                  window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(link), 'sharer', 'toolbar=0,status=0,width=626,height=436');
                                  return false;
                                });
                              });
                            </script>

                            <a href="javascript:void(0)" data-val="<?php echo $value['user_id']; ?>" class="sendmessage" data-toggle="tooltip" title="Send Message"><i class="fa fa-envelope"></i></a>

                            <!-- <a href="#" class="fa fa-paper-plane-o"></a>                  -->
                            <a href="#" class="fa fa-floppy-o saveprofile" id="<?php echo $value['id'] ?>" data-profile="<?php echo $value['id'] ?>" <?php if ($profilesave) { ?> style="color:red" <?php  } ?>></a>
                            <a href="<?php echo SITE_URL; ?>/profile/profilecountersearch/<?php echo $value['id'] ?>" class="fa fa-download"></a>
                            <a href="<?php echo SITE_URL ?>/profile/reportspamsearch/<?php echo $value['id']; ?>" class="report fa fa-flag" data-target="#reportuser" title="Report"></a>
                            <!--<a href="#" class="fa fa-ban"></a>  -->
                          <?php } else { ?>
                            <a href="<?php echo SITE_URL; ?>/login" class="likeprofile" title="Like"><i class="fa fa-thumbs-up"></i></a>
                            <a href="<?php echo SITE_URL; ?>/login" class="fa fa-share"></a>
                            <a href="<?php echo SITE_URL; ?>/login" class="sendmessage" title="Send Message"><i class="fa fa-envelope"></i></a>
                            <a href="<?php echo SITE_URL; ?>/login" class="fa fa-floppy-o saveprofile"></a>
                            <a href="<?php echo SITE_URL; ?>/login" class="fa fa-download"></a>
                            <a href="<?php echo SITE_URL ?>/login" class="report fa fa-flag" title="Report"></a>
                          <?php } ?>
                        </div>

                      </div>


                    <?php  } ?>




              <?php  }
                }

                //loopclosed

              } ?>
              <script>
                $('.singleaskquote').click(function() {
                  var profile = $(this).data('profile');
                  $('.singleaskquotechekprofileid').val(profile);
                });

                $('.singlebooknow').click(function() {
                  var profile = $(this).data('profile');
                  $('.singlebooknowchekprofileid').val(profile);

                });
              </script>



              <?php /*--------------------------------Start Singlebooknow--------------------------*/ ?>

              <!-- Modal -->
              <div class="modal fade" id="singlebooknow" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title text-center">Select Job(s) To Send Request</h4>
                    </div>
                    <div class="modal-body">
                      <?= $this->Form->create($requirement, [
                        // 'url' => ['controller' => 'jobpost', 'action' => 'insBook'],
                        'url' => ['controller' => 'search', 'action' => 'mutiplebooknow'],
                        'type' => 'file',
                        'class' => 'form-horizontal',
                        'id' => 'booknowsubmitddd',
                        'autocomplete' => 'off'
                      ]); ?>

                      <span id="booknownoselect" style="display: none">Select at least one job</span>
                      <input type="hidden" name="user_id" class="singlebooknowchekprofileid">

                      <?php if (!empty($activejobs)) : ?>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Job</th>
                              <th>Skills</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $pendingjob = []; ?>
                            <?php foreach ($activejobs as $jobs) : ?>
                              <?php if (!in_array($jobs['id'], $app)) : ?>
                                <tr>
                                  <td>
                                    <input type="checkbox" name="job_id[<?= $jobs['id']; ?>]" value="<?= $jobs['id']; ?>" onclick="toggleSelect(<?= $jobs['id']; ?>)" id="bookingselectsingle<?= $jobs['id']; ?>" class="bookingselectsingle">
                                    <a href="<?= SITE_URL ?>/applyjob/<?= $jobs['id']; ?>" target="_blank"> <?= $jobs['title']; ?> </a>
                                  </td>
                                  <td>
                                    <select name="job_id[<?= $jobs['id']; ?>][]" class="form-control bookingselectsingle<?= $jobs['id']; ?>" disabled required>
                                      <option value="">--Select--</option>
                                      <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) : ?>
                                        <option value="<?= $skillsreq['skill']['id']; ?>"><?= $skillsreq['skill']['name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </td>
                                </tr>
                                <?php $pendingjob[] = $jobs['id']; ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </tbody>
                        </table>

                        <?php if (!empty($pendingjob)) : ?>
                          <div class="text-center">
                            <button type="submit" class="btn btn-default booknowsingle" onclick="return validateJobSelection2();">Book Now</button>
                          </div>
                        <?php else : ?>
                          <p class="text-center">No Jobs Available For Booking</p>
                        <?php endif; ?>
                      <?php else : ?>
                        <p>No jobs found</p>
                      <?php endif; ?>

                      <?= $this->Form->end(); ?>
                    </div>
                  </div>

                  <script>
                    function validateJobSelection2() {
                      var checkboxes = document.querySelectorAll('.bookingselectsingle:checked');
                      if (checkboxes.length === 0) {
                        alert('Please select at least one job to book');
                        document.getElementById('booknownoselect').style.display = 'block';
                        return false;
                      }
                      document.getElementById('booknownoselect').style.display = 'none';
                      return true;
                    }


                    function toggleSelect(jobId) {
                      const checkbox = document.getElementById(`bookingselectsingle${jobId}`);
                      const selectBox = document.querySelector(`.bookingselectsingle${jobId}`);
                      selectBox.disabled = !checkbox.checked;
                      selectBox.required = checkbox.checked;
                    }
                  </script>


                </div>
              </div>

            </div>

            <?php //pr($__SESSION); die;

            /*--------------------------------End Singlebooknow--------------------------*/ ?>
            <?php /*--------------------------------start Singleaskquote--------------------------*/ ?>
            <div class="modal fade" id="singleaskquote" role="dialog">
              <div class="modal-dialog modal-lg custom-modal-width">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" style="text-align: center;">Select Job(s) To Send Ask For Quote Request.</h4>

                  </div>
                  <div class="modal-body">
                    <div id="mulitpleaskquoteinvited" style="display: none">

                      <?php foreach ($_SESSION['askquotenotinvite'] as $key => $result) { ?>
                        <?php echo $result; ?> Avilable Quotes <?php echo $key; ?> Credit Left.
                      <?php  } ?>
                    </div>
                    <?php
                    echo $this->Form->create(
                      $requirement,
                      array('url' => array('controller' => 'search', 'action' => 'mutipleaskQuote'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'askquotesubmit', 'autocomplete' => 'off')
                    );
                    ?>
                    <span id="noselect" style="display: none">Select Atleast one Skills</span>
                    <input type="hidden" name="user_id" value="" class="singleaskquotechekprofileid">
                    <div class="">
                      <?php if (count($activejobs) > 0) { ?>

                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th><strong>Job</strong></th>
                              <th><strong>Skills</strong></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $count = 1;
                            foreach ($activejobs as $jobs) { //pr($jobs);

                            ?>
                              <tr>
                                <?php if (!in_array($jobs['id'], $app)) { ?>
                                  <td style="width: 200px;">
                                    <?php
                                    if ($jobs['askquotedata'] < 1) { ?>

                                      <!--<a href="<?php //echo SITE_URL; 
                                                    ?>/package/buyquote/<?php //echo $jobs['id']; 
                                                                        ?>"> Buy Quote </a>-->
                                    <?php  } else { ?>
                                      <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" onclick="checkedJobs(this);" data-totallimit="<?= $jobs['askquotedata']; ?>" id="jobselectsingle<?php echo $jobs['id']; ?>" class="jobselectsingle jobselectsinglechecked">

                                  <?php }
                                  } ?>

                                  <?php if (!in_array($jobs['id'], $app)) {
                                    $pendingjob[] = $job['id']; ?>

                                    <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a>
                                    <i class="fa fa-info-circle info-icon job-link" data-tooltip="<?= $jobs['askquotedata'] > 0 ? 'Ask Quote Limit: ' . $jobs['askquotedata'] : 'No Ask Quote Left. Buy More!' ?>"></i>
                                  </td>
                                <?php  } ?>

                                <?php if (!in_array($jobs['id'], $app)) { ?>
                                  <td>
                                    <?php
                                    if ($jobs['askquotedata'] < 1) { ?>
                                      <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote For <?php echo $jobs['title']; ?></a>
                                    <?php  } else { ?>
                                      <select name="job_id[<?php echo $jobs['id']; ?>][]" required onchange="return myfunctionsingle(this)" class="form-control jobselectsingle<?php echo $jobs['id']; ?>" data-req="<?php echo $jobs['id'] ?>" disabled required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);
                                        ?>
                                          <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>

                                      <?php }
                                      } ?>

                                      </select>

                                      <?php if ($jobs['askquotedata'] >= 1):
                                        $currencyFieldId = "currencysingle" . $jobs["id"];
                                      ?>

                                        <?= $this->Form->control('payment_currency', [
                                          'type' => 'select', // 🔑 This tells CakePHP to render a <select>
                                          'class' => 'form-control',
                                          'label' => false,
                                          'empty' => 'Select Currency',
                                          'options' => $currencies,
                                          // 'selected' => 'selected',
                                          'id' => $currencyFieldId,
                                          'disabled' => true, // ❗ This makes it non-editable
                                          'title' => 'Select Currency'
                                        ]); ?>

                                        <input
                                          type="text"
                                          class="form-control"
                                          id="offeramtsingle<?= $jobs['id']; ?>"
                                          placeholder="Open to Negotiation"
                                          readonly />

                                      <?php endif; ?>

                                  </td>
                                <?php } ?>

                              </tr>
                            <?php $count++;
                            } ?>
                            <?php if ($pendingjob) { ?>

                            <?php } else { ?>
                              <td colspan="2" rowspan="2" style="text-align: center;">
                                <?php echo "No Jobs Available For Quote "; ?>
                              </td>
                            <?php } ?>
                          </tbody>

                        </table>


                      <?php } else {

                        echo "No jobs Found";
                      } ?>


                      <?php if ($pendingjob && ($jobs['askquotedata'] > 0)) { ?>

                        <div style="text-align: center;">
                          <!-- <button type="submit" class="btn btn-default askquotesave">Ask for Quote</button> -->
                          <button type="submit" class="btn btn-default askquotesaves">Ask for Quote</button>
                        </div>

                      <?php } ?>
                    </div>
                    </form>
                  </div>

                </div>

              </div>
            </div>

          </div>
        </div>
        <?php /*--------------------------------End Singleaskquote--------------------------*/ ?>

        <!-- Modal -->
        <div class="modal fade" id="multiplebooknow" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title text-center">Select Job(s) To Send Request</h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create($requirement, [
                  'url' => ['controller' => 'search', 'action' => 'mutiplebooknow'],
                  'type' => 'file',
                  'inputDefaults' => ['div' => false, 'label' => false],
                  'class' => 'form-horizontal',
                  'id' => 'booknowsubmit',
                  'autocomplete' => 'off'
                ]); ?>

                <span id="booknownoselect2" class="text-danger" style="display: none;">Select at least one Job</span>
                <input type="hidden" name="user_id" value="<?= $userid ?>" class="chekprofileid">

                <?php if (!empty($activejobs)) : ?>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Job</th>
                        <th>Skills</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $pendingjob = []; ?>
                      <?php foreach ($activejobs as $jobs) : ?>
                        <?php if (!in_array($jobs['id'], $app)) : ?>
                          <tr>
                            <td>
                              <input type="checkbox" name="job_id[<?= $jobs['id']; ?>]" value="<?= $jobs['id']; ?>" id="bookingselectmultiple<?= $jobs['id']; ?>" class="bookingselectmultiple">
                              <a href="<?= SITE_URL ?>/applyjob/<?= $jobs['id'] ?>" target="_blank"><?= $jobs['title']; ?></a>
                            </td>
                            <td>
                              <select name="job_id[<?= $jobs['id']; ?>][]" class="form-control bookingselectmultiple<?= $jobs['id']; ?>" disabled required>
                                <option value="">--Select--</option>
                                <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) : ?>
                                  <option value="<?= $skillsreq['skill']['id']; ?>"><?= $skillsreq['skill']['name']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </td>
                          </tr>
                          <?php $pendingjob[] = $jobs['id']; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>

                      <?php if (empty($pendingjob)) : ?>
                        <tr>
                          <td colspan="2" class="text-center">No Jobs Available For Booking</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>

                  <?php if (!empty($pendingjob)) : ?>
                    <button type="submit" class="btn btn-default" onclick="return validateJobSelection();">Book Now</button>
                  <?php endif; ?>
                <?php else : ?>
                  <p>No jobs found</p>
                <?php endif; ?>

                <?= $this->Form->end(); ?>
              </div>
            </div>

            <script>
              function validateJobSelection() {
                var checkboxes = document.querySelectorAll('.bookingselectmultiple:checked');
                if (checkboxes.length === 0) {
                  alert('Please select at least one job to book');
                  document.getElementById('booknownoselect2').style.display = 'block';
                  return false;
                }
                document.getElementById('booknownoselect2').style.display = 'none';
                return true;
              }
            </script>


          </div>
        </div>

        <div class="row">
          <?php if ($isset == 1) { ?>
            <?php if ($user_idd) { ?>
              <a href="#" class="btn btn-default" style="margin-top: 40px" data-toggle="modal" data-target="#saveprofilerefinetamplate"> Save Search Result </a>
            <?php } else { ?>
              <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default" style="margin-top: 40px"> Save Search Result </a>
            <?php } ?>

          <?php } else { ?><h3 style=" position: relative;left: 264px;top: 301px;">No Profile Found</h3> <?php } ?>

        </div>
      </div>


      <!-- Modal for select multiplse profile -->
      <div class="modal fade" id="multipleaskquote" role="dialog">
        <div class="modal-dialog modal-lg custom-modal-width">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;">Select Job(s) To Send Ask For Quote Request</h4>
              <p id="totalSelectedProfiles" style="text-align: center; font-size: 14px; color: #666;"></p>
            </div>

            <div class="modal-body">

              <div id="mulitpleaskquoteinvited" style="display: none">
                <?php foreach ($_SESSION['askquotenotinvite'] as $key => $result) { ?>
                  <?php echo $result; ?> Avilable Quotes <?php echo $key; ?> Credit Left.
                <?php  } ?>
              </div>

              <?php
              echo $this->Form->create($requirement, array('url' => array('controller' => 'search', 'action' => 'mutipleaskQuote'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'askquotesubmit', 'autocomplete' => 'off'));
              ?>

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
                              <?php  } else { ?>
                                <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" onclick="checkedJobs(this);" data-totallimit="<?= $jobs['askquotedata']; ?>" id="jobselect<?php echo $jobs['id']; ?>" class="jobselect jobselectsinglechecked">
                            <?php }
                            } ?>

                            <?php if (!in_array($jobs['id'], $app)) {
                              $pendingjob[] = $job['id']; ?>


                              <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id'] ?>" target="_blank">
                                <?php echo $jobs['title']; ?>
                              </a>
                              <i class="fa fa-info-circle info-icon job-link" data-tooltip="<?= $jobs['askquotedata'] > 0 ? 'Ask Quote Limit: ' . $jobs['askquotedata'] : 'No Ask Quote Left. Buy More!' ?>"></i>
                            </td>
                          <?php  } ?>

                          <?php if (!in_array($jobs['id'], $app)) { ?>
                            <td>
                              <?php
                              if ($jobs['askquotedata'] < 1) { ?>
                                <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote </a>
                              <?php  } else { ?>
                                <select name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunction(this)" class="form-control jobselect<?php echo $jobs['id']; ?>" data-req="<?php echo $jobs['id'] ?>" disabled required>
                                  <option value="">--Select--</option>
                                  <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq); 
                                  ?>

                                    <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>

                                <?php }
                                } ?>

                                </select>

                                <?php if ($jobs['askquotedata'] >= 1):
                                  $currencyFieldId = "currency" . $jobs["id"];
                                ?>

                                  <?= $this->Form->control('payment_currency', [
                                    'type' => 'select', // 🔑 This tells CakePHP to render a <select>
                                    'class' => 'form-control',
                                    'label' => false,
                                    'empty' => 'Select Currency',
                                    'options' => $currencies,
                                    // 'selected' => 'selected',
                                    'id' => $currencyFieldId,
                                    'disabled' => true, // ❗ This makes it non-editable
                                    'title' => 'Select Currency'
                                  ]); ?>

                                  <!-- <input class="form-control" type="text" id="currency<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly /> -->

                                  <input class="form-control" type="text" id="offeramt<?php echo $jobs['id']; ?>" placeholder="Open to Negotiation" readonly />

                                <?php endif; ?>

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

                <?php if ($pendingjob) { ?>
                  <button type="submit" class="btn btn-default askquotesaves">Ask for Quote</button>
                <?php } ?>

              </div>
              </form>
            </div>

          </div>

        </div>
      </div>

    </div>


    <script>
      $(document).ready(function() {
        $(".jobselect").click(function(evt) {
          var id = $(this).attr("id");
          if ($(this).is(":checked")) {
            $("." + id).removeAttr('disabled');
          } else {
            //$("."+id).removeAttr('disabled');
            $("." + id).prop('disabled', 'disabled');
          }
        });
      });
    </script>

    <script>
      $(document).ready(function() {

        $(".askquotesaves").prop('disabled', 'disabled');

        $(".jobselectsingle, .jobselectsinglechecked").click(function(evt) {
          var id = $(this).attr("id");
          if ($(this).is(":checked")) {
            $("." + id).removeAttr('disabled');
            // askquotesaves class button disable
            $(".askquotesaves").removeAttr('disabled');
          } else {
            //$("."+id).removeAttr('disabled');
            $("." + id).prop('disabled', 'disabled');
            $(".askquotesaves").prop('disabled', 'disabled');

          }
        });
      });

      $(document).ready(function() {
        $('#multipleaskquote').on('shown.bs.modal', function() {
          let totalSelectedMember = $(".chekprofileid").val().split(",").length;
          let totalLimit = parseInt($(".jobselectsinglechecked").first().data("totallimit"), 10) || 0;

          $("#totalSelectedProfiles").text("Total Profiles Selected: " + totalSelectedMember);
          $(".jobselectsinglechecked").each(function() {
            if (totalSelectedMember > totalLimit) {
              $(this).prop("checked", false);
              $(this).prop("disabled", true);
            } else {
              $(this).prop("disabled", false);
            }
          });
        });
      });

      function checkedJobs(event) {
        var checkbox = $(event);
        var totalSelectedMember = $(".chekprofileid").val().split(",").length;
        var totalLimit = parseInt(checkbox.attr("data-totallimit"), 10) || 0;
        var checkedCount = $(".jobselectsingle:checked").length;

        if (totalLimit === 0) {
          alert("No ask quote limit available for this job.");
          checkbox.prop("checked", false);
          return;
        }

        if (totalSelectedMember > totalLimit) {
          alert("You can only select up to " + totalLimit + " jobs.");
          checkbox.prop("checked", false);
        } else if (checkedCount > totalLimit) {
          alert("You can only select up to " + totalLimit + " job(s).");
          checkbox.prop("checked", false);
        }
      }
    </script>

    <script>
      $(document).ready(function() {
        $(".bookingselectsingle").click(function(evt) {
          var id = $(this).attr("id");
          if ($(this).is(":checked")) {
            $("." + id).removeAttr('disabled');
          } else {
            //$("."+id).removeAttr('disabled');
            $("." + id).prop('disabled', 'disabled');
          }
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        $(".bookingselectmultiple").click(function(evt) {
          var id = $(this).attr("id");
          if ($(this).is(":checked")) {
            $("." + id).removeAttr('disabled');
          } else {
            //$("."+id).removeAttr('disabled');
            $("." + id).prop('disabled', 'disabled');
          }
        });
      });
    </script>

    <script>
      var SITE_URL = '<?php echo SITE_URL; ?>/';
      $('.askquotesave').click(function(e) { //alert();
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: SITE_URL + 'search/mutipleaskQuote',
          data: $('#askquotesubmit').serialize(),
          cache: false,
          success: function(data) { //alert(data); 
            location.reload();
            var myObj = JSON.parse(data);
            if (myObj.success == 'noselect') {
              $("#noselect").css("display", "block");
              setTimeout(function() {
                $("#noselect").fadeOut('fast');
              }, 5000);
            } else if (myObj.success == 'requestnotsent') {
              $('input:checkbox').removeAttr('checked');
              location.reload();
            } else if (myObj.success == 'requestsent') {
              $("#multipleaskquote").modal('toggle');
              $('input:checkbox').removeAttr('checked');
              location.reload();
            }

          }
        });
      });

      $('.booknowsave').click(function(e) { //alert();
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: SITE_URL + 'search/mutiplebooknow',
          data: $('#booknowsubmit').serialize(),
          cache: false,
          success: function(data) {
            var myObj = JSON.parse(data);
            if (myObj.success == 'booknownoselect') {
              $("#booknownoselect").css("display", "block");
              setTimeout(function() {
                $("#booknownoselect").fadeOut('fast');
              }, 1000);
            } else if (myObj.success == 'bookingrequestnotsent') {

              $('input:checkbox').removeAttr('checked');
              location.reload();
              $('input:checkbox').removeAttr('checked');
            } else if (myObj.success == 'bookingrequestsent') {
              $('input:checkbox').removeAttr('checked');
              location.reload();
            }
            //
            //$("#multiplebooknow").modal('toggle');
            // $('input:checkbox').removeAttr('checked');
            //location.reload();

          }
        });
      });

      $('.booknowsavesingle').click(function(e) { //alert();
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: SITE_URL + 'search/mutiplebooknow',
          data: $('#booknowsubmitddd').serialize(),
          cache: false,
          success: function(data) {
            var myObj = JSON.parse(data);
            if (myObj.success == 'booknownoselect') {
              $("#booknownoselect").css("display", "block");
              setTimeout(function() {
                $("#booknownoselect").fadeOut('fast');
              }, 1000);
            } else if (myObj.success == 'bookingrequestnotsent') {

              $('input:checkbox').removeAttr('checked');
              location.reload();
              $('input:checkbox').removeAttr('checked');
            } else if (myObj.success == 'bookingrequestsent') {
              $('input:checkbox').removeAttr('checked');
              location.reload();
            }
            //
            //$("#multiplebooknow").modal('toggle');
            // $('input:checkbox').removeAttr('checked');
            //location.reload();

          }
        });
      });
    </script>

    <?php

    if (empty($minselsss)) {
      $minisels = $minimumage;
    } else {
      $minisels = $minselsss;
    }

    if (empty($maxselsss)) {
      $maxsels = $maxage;
    } else {
      $maxsels = $maxselsss;
    }
    // pr($maxage);exit;

    ?>

    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>
      $(function() {
        $("#slider-range").slider({
          range: true,
          min: <?php echo $minimumage;  ?>,
          max: <?php echo $maxage;  ?>,
          values: [<?php echo $minisels;  ?>, <?php echo $maxsels;  ?>],
          slide: function(event, ui) {
            $("#amount").val("" + ui.values[0] + " - " + ui.values[1]);
          },
          change: function(event, ui) {
            $("#ajexrefine").submit();
          }
        });

        $("#amount").val("" + $("#slider-range").slider("values", 0) +
          " - " + $("#slider-range").slider("values", 1));
      });
    </script>

    <script>
      $('.askquotemultiple').click(function(e) {
        e.preventDefault();
        action = $(this).data('action');
        userid = $(this).data('val');
        bookingurl = '<?php echo SITE_URL; ?>/search/askquotemultiple/' + userid + '/' + action;
        $('#askquotemultiple').modal('show').find('.modal-body').load(bookingurl);
      });
    </script>

    <!-- <input type="checkbox" name="profile[]" value="<?php echo $value['user_id']; ?>" class="chkask askqoute" data-val="1472" id="myask1472"> -->

    <script>
      $(document).ready(function() {
        var site_url = '<?php echo SITE_URL; ?>/';
        $('.chkask').click(function() {
          // alert('chkask');
          var profile_id = $(this).data('val');
          var selected = $(".chkask:checked").map(function() {
            return $(this).data('val');
          }).get();
          var chkprofile_id = selected.join(",");
          $('.chekprofileid').val(chkprofile_id);

          if ($(this).is(':checked')) {
            $(this).parent('div').removeClass('box_hvr_checkndlt');
            $('#askaplybutton').css("visibility", "visible");
          } else {
            $(this).parent('div').addClass('box_hvr_checkndlt');
          }
          var numberOfChecked = $('input:checkbox:checked').length;
          // console.log('>>>',numberOfChecked);
          
          if (numberOfChecked == 0) {
            $('#askaplybutton').css("visibility", "hidden");
          }
        });
      });
    </script>

    <!-- <script>
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
    </script> -->

    <script>
      $(document).ready(function() {
        $('.delete_jobalerts').click(function() {
          var profile_id = $(this).data('val');
          var checkbox = $('#myask' + profile_id);
          // Check if the checkbox is checked
          if (checkbox.prop('checked')) {
            checkbox.prop('checked', false); // Disable the checkbox
          }
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
            //alert(response);
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

  </div>
  </div>
  </div>
  </div>

  </section>

<?php  } else {

  $c = 0;
  $count = 0;
  foreach ($_SESSION['advanceprofiesearchdata'] as $key => $value) {

    if ($key == "skillshow" || $key == "currentlocunit" || $key == "form" || $key == "optiontype" || $key == "unit") {
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

  <div class="srch-box">
    <div class="container">
      <form class="form-horizontal">
        <div class="form-group">
          <?php if (!$_SESSION['advanceprofiesearchdata']) { ?>
            <?php if ($d) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Word Search:</label>
                <input type="text" class="form-control" id="inputEmail3" value="<?php echo $d; ?>" placeholder="Enter your search keyword">
              </div>

            <?php } ?>
        </div>
        <div class="form-group">
          <div class="col-sm-2">
            <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a>
          </div>
          <div class="col-sm-2">
            <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a>
          </div>
          <div class="col-sm-2">
            <!-- <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/profilesearch/reset" class="btn btn-primary btn-block">Refine Search</a> -->
            <?php
            if (isset($_GET['refine']) && $_GET['refine'] == 2) {
              echo '<a style="background-color: #8B0000 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
            } else {

              echo '<a style="background-color: #e13580 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
            }
            ?>
          </div>
          <div class="col-sm-2">
            <?php
            if (isset($_GET['refine']) && $_GET['refine'] == 2) {
              echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
            } else {
              echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
            }
            ?>
          </div>
        </div>
      </form>



    <?php } ?>
    <?php $c = 0;

    $count = 0;
    foreach ($_SESSION['advanceprofiesearchdata'] as $key => $value) {
      //echo $key;
      if ($key == "skillshow" || $key == "currentlocunit" || $key == "form" || $key == "optiontype" || $key == "unit") {
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
    <?php if ($count > 5) { ?> <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip">View All</a> <?php } ?>
    <?php if (empty($_SESSION['advanceprofiesearchdata']['name']) && $_SESSION['advanceprofiesearchdata']['optiontype'] == 2) { ?>
      <form class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-2">

            <label for="" class=" control-label">Talent Name:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Profile Title:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
            <input type="text" class="form-control" id="inputEmail3" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Talent Type:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Location:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
          </div>
        </div>
      </form>
    <?php }  ?>
    <form class="form-horizontal">
      <div class="form-group">
        <?php
        if ($_SESSION['advanceprofiesearchdata']['name']) { ?>
          <div class="col-sm-2">

            <label for="" class=" control-label">Talent Name:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>" readonly>
          </div>
        <?php } ?>

        <?php if ($_SESSION['advanceprofiesearchdata']['profiletitle']) { ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Profile Title:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
          </div>
        <?php } ?>
        <?php if ($_SESSION['advanceprofiesearchdata']['wordsearch']) { ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
            <input type="text" class="form-control" id="inputEmail3" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['wordsearch'];  ?>" readonly>
          </div>
        <?php } ?>
        <?php if ($_SESSION['advanceprofiesearchdata']['skillshow']) { ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Talent Type:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>" readonly>
          </div>
        <?php } ?>
        <?php if ($_SESSION['advanceprofiesearchdata']['location']) { ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Location:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>" readonly>
          </div>
        <?php } ?>

        <?php if ($_SESSION['advanceprofiesearchdata']['within']) { ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">With in :</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['within'];  ?>" readonly>
          </div>
        <?php } ?>



        <div class="row" id="panel">
          <?php if ($_SESSION['advanceprofiesearchdata']['gender']) { ?>
            <div class="col-sm-2">

              <label for="" class=" control-label">Gender:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly value="<?php if ($_SESSION['advanceprofiesearchdata']) { ?> <?php for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['gender']); $i++) {
                                                                                                                                                              if ($_SESSION['advanceprofiesearchdata']['gender'][$i] == "m") echo "Male,";
                                                                                                                                                              else if ($_SESSION['advanceprofiesearchdata']['gender'][$i] == "f") echo "Female,";
                                                                                                                                                              else if ($_SESSION['advanceprofiesearchdata']['gender'][$i] == "bmf") echo "Both Male and Female";
                                                                                                                                                              else if ($_SESSION['advanceprofiesearchdata']['gender'][$i] == "a") echo "Any,";
                                                                                                                                                            } ?> <?php } ?>">
            </div>
          <?php } else { ?>
          <?php } ?>
          <?php if ($_SESSION['advanceprofiesearchdata']['positionname']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Position Name :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php echo $_SESSION['advanceprofiesearchdata']['positionname'] ?>" readonly>
            </div>
          <?php } ?>



          <?php if ($_SESSION['advanceprofiesearchdata']['country_id']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Country:</label>
              <?php $countrydata = $this->Comman->cnt($_SESSION['advanceprofiesearchdata']['country_id']);


              ?>
              <input type="text" class="form-control" id="inputEmail3" value="<?php if ($countrydata) {
                                                                                echo $countrydata['name'];
                                                                              } ?>" readonly />
            </div>
          <?php } ?>



          <?php if ($_SESSION['advanceprofiesearchdata']['cwithin']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Within :</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['cwithin'];  ?>" readonly>
            </div>
          <?php } ?>

          <?php if ($_SESSION['advanceprofiesearchdata']['cwithin']) { ?>
            <?php if ($_SESSION['advanceprofiesearchdata']['currentlocunit']) { ?>
              <div class="col-sm-2">
                <label for="" class=" control-label">Units :</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['currentlocunit'];  ?>" readonly>
              </div>
            <?php } ?>

          <?php } ?>
          <?php if ($_SESSION['advanceprofiesearchdata']['state_id']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">State :</label>
              <?php $statedata = $this->Comman->state($_SESSION['advanceprofiesearchdata']['state_id']);  ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($statedata) {
                                                                                                echo $statedata['name'];
                                                                                              } ?>" readonly>
            </div>
          <?php } ?>
          <?php if ($_SESSION['advanceprofiesearchdata']['city_id']['0'] != "") { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">City:</label>

              <?php for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['city_id']); $i++) {

                $citydata = $this->Comman->city($_SESSION['advanceprofiesearchdata']['city_id'][$i]);

                $cityarray[] = $citydata['name'];
              } ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) echo implode(",", $cityarray); ?>" readonly>
            </div>
          <?php } ?>


          <?php if ($_SESSION['advanceprofiesearchdata']['clocation']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Current Location :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['clocation'];  ?>" readonly>
            </div>
          <?php } ?>
          <?php if ($_SESSION['advanceprofiesearchdata']['currentlyworking']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Currently Working</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                echo $_SESSION['advanceprofiesearchdata']['currentlyworking'];
                                                                                              } ?>" readonly>
            </div>
          <?php } ?>
          <?php if ($_SESSION['advanceprofiesearchdata']['experyear']) { ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Year of Experience </label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                echo str_replace(",", " to ", $_SESSION['advanceprofiesearchdata']['experyear']);
                                                                                              } ?>" readonly>
            </div>
          <?php } ?>

          <?php
          if (!empty($_SESSION['advanceprofiesearchdata']['active'])) {
            $activeOptions = [
              1 => "Last 15 days",
              2 => "Last 30 days",
              3 => "Last 45 days",
              4 => "Last 60 days",
              5 => "Last 3 Months",
              6 => "Last 6 Months"
            ];

            $activeLabel = $activeOptions[$_SESSION['advanceprofiesearchdata']['active']] ?? '';

            if ($activeLabel) {
          ?>
              <div class="col-sm-2">
                <label class="control-label">Active In:</label>
                <input type="text" class="form-control" readonly value="<?php echo $activeLabel; ?>">
              </div>
          <?php
            }
          }
          ?>




        </div>
        <?php if ($_SESSION['advanceprofiesearchdata']) { ?>
          <div class="form-group">
            <div class="col-sm-2">
              <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a>
            </div>
            <div class="col-sm-2">
              <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a>
            </div>
            <div class="col-sm-2">
              <!-- <a style="background-color: #e13580 !important;" href="<?php echo SITE_URL ?>/search/profilesearch/reset" class="btn btn-primary btn-block">Refine Search</a> -->
              <?php
              if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                echo '<a style="background-color: #8B0000 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
              } else {

                echo '<a style="background-color: #e13580 !important;" href="' . SITE_URL . '/search/profilesearch/reset" class="btn btn-primary btn-block">Reset</a>';
              }
              ?>
            </div>
            <div class="col-sm-2">
              <?php
              if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
              } else {
                echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
              }
              ?>
            </div>
          </div>

        <?php } ?>

    </form>


    </div>
  </div>

  <!-- <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
  <?php

  if (empty($minselsss)) {

    $minisels = $minimumage;
  } else {

    $minisels = $minselsss;
  }

  if (empty($maxselsss)) {

    $maxsels = $maxage;
  } else {

    $maxsels = $maxselsss;
  }


  ?>
  <script>
    $(function() {
      $("#slider-range").slider({
        range: true,
        min: <?php echo $minimumage;  ?>,
        max: <?php echo $maxage;  ?>,
        values: [<?php echo $minisels;  ?>, <?php echo $maxsels;  ?>],
        slide: function(event, ui) {
          $("#amount").val("" + ui.values[0] + " - " + ui.values[1]);
        },
        change: function(event, ui) {
          $("#ajexrefine").submit();
        }
      });

      $("#amount").val("" + $("#slider-range").slider("values", 0) +
        " - " + $("#slider-range").slider("values", 1));
    });
  </script>

  <div class="row m-top-20">
    <div class="col-sm-4" style="margin-left: 10px;">
      <div>
        <div class="panel panel-left">
          <h6>Refine Profile Search</h6>

          <!-- <form class="form-horizontal" method="get" action="<?php echo SITE_URL; ?>/search/profilesearch" id="ajexrefine"> -->
          <form class="form-horizontal" method="get" action="<?php echo SITE_URL; ?>/search/profilesearch" id="newrefinejob">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
              <div class="col-sm-12">
                <input type="text" class="form-control auto_submit_item" placeholder="Name" value="<?php echo $refinename; ?>" name="name">
              </div>
            </div>
            <div class="form-group salry">
              <label for="inputEmail3" class="col-sm-12 control-label">Age </label>
              <p class="prc_sldr">
                <label for="amount">Age</label>
                <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="age" class="auto_submit_item">
              </p>
              <div id="slider-range"></div>

            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Gender</label>
              <div class="col-sm-12">

                <select class="form-control auto_submit_item" name="gender">
                  <option value="">Select Gender</option>
                  <?php
                  $genderLabels = [
                    'a' => 'Any',
                    "m" => "Male",
                    "f" => "Female",
                    "o" => "Other",
                    "bmf" => "Both Male and Female"
                  ];

                  foreach ($gendaray as $gender) {
                    // $selected = ($gender == $gen) ? 'selected' : '';
                    echo "<option value='$gender'>{$genderLabels[$gender]}</option>";
                  }
                  ?>
                </select>

              </div>
            </div>
            <h3 style="position: relative; left: 590px;">No Profile Found</h3>
            <div class="form-group">

              <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
              <div class="col-sm-12">
                <select class="form-control auto_submit_item" name="performancelan[]" multiple="">
                  <option value="0">Select Language</option>
                  <?php foreach ($performancelan as $key => $value) { ?>
                    <option value="<?php echo $key; ?>" <?php if (in_array($key, $performancelansel)) {
                                                          echo "selected";
                                                        } ?>><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <input type="hidden" class="form-control auto_submit_item" placeholder="words" value="<?php echo $d; ?>" name="words">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
              <div class="col-sm-12">
                <select class="form-control auto_submit_item" name="language[]" multiple="">
                  <option value="0">Select Language</option>
                  <?php foreach ($languageknownarray as $key => $value) { ?>
                    <option value="<?php echo $key; ?>" <?php if (in_array($key, $languagesel)) {
                                                          echo "selected";
                                                        } ?>><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>


            <?php if ($user_idd) { ?>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Online Now </label>
                <div class="col-sm-12">
                  <label class="radio-inline">
                    <input type="radio" name="online" id="inlineRadio1" value="0" class="auto_submit_item" <?php if ($live == 0) {
                                                                                                              echo "checked";
                                                                                                            } ?>>
                    All </label>

                  <label class="radio-inline">
                    <input type="radio" name="online" id="inlineRadio2" value="1" <?php if ($live == 1) {
                                                                                    echo "checked";
                                                                                  } ?> class="auto_submit_item">
                    Online </label>


                  <label class="radio-inline">
                    <input type="radio" name="online" id="inlineRadio3" value="2" <?php if ($live == 2) {
                                                                                    echo "checked";
                                                                                  } ?> class="auto_submit_item">
                    Offline </label>

                </div>
              </div>
            <?php } ?>


            <?php $vitalstatic = array();  ?>
            <?php if ($myvital) {   ?>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Vital Statistics parameters </label>
                <?php $i = 0;
                foreach ($myvital as $key => $value) {  ?>


                  <p class="prc_sldr">
                    <label for="amount"><?php echo  $key; ?></label>

                  </p>
                  <?php if ($key != '') { ?>
                    <div class="col-sm-12">
                      <select class="form-control auto_submit_item" name="vitalstats[<?php echo  $key; ?>][]" multiple="">
                        <option value="0">Select <?php echo  $key; ?> </option>
                        <?php foreach ($value as $key => $opt) { ?>

                          <option value="<?php echo $key ?>" <?php if (in_array($key, $vitalarray)) {
                                                                echo "selected";
                                                              } ?> class="auto_submit_item"><?php echo $opt ?></option>

                        <?php } ?>

                      </select>
                    </div>
                  <?php }  ?>
                <?php $i++;
                } ?>
              </div>
            <?php }  ?>


            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
              <div class="col-sm-12">


                <!-- <select class="form-control auto_submit_item" name="activein"   >
                        <option value="0" >Select Active in</option>
                        <?php foreach ($active as $key => $value) {  ?>
                          <option value="<?php echo $value; ?>"<?php if ($day == $value) {
                                                                  echo "selected";
                                                                } ?> ><?php echo $value; ?> days</option>
                        <?php } ?>
                      </select> -->


                <select class="form-control auto_submit_item" name="activein">
                  <option value="0">Select Active In</option>
                  <?php foreach ($output as  $value) {  ?>
                    <option value="<?php echo $value; ?>" <?php if ($day == $value) {
                                                            echo "selected";
                                                          } ?>><?php echo $value; ?> days</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
              <div class="col-sm-12">
                <select class="form-control auto_submit_item" name="paymentfaq">
                  <option value="0">Select Payment Frequency </option>
                  <?php foreach ($paymentfaqarray as $key => $value) { ?>
                    <option value="<?php echo $key; ?>" <?php if ($payment == $key) {
                                                          echo "selected";
                                                        } ?>><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
              <div class="col-sm-12">
                <select class="form-control auto_submit_item" name="skill">
                  <option value="0">Select Talent Type</option>
                  <?php foreach ($userskillarray as $key => $skillvalue) { ?>
                    <option value="<?php echo $key ?>" <?php if ($skill == $key) {
                                                          echo "selected";
                                                        } ?>> <?php echo  $skillvalue; ?> </option>

                  <?php } ?>
                </select>
              </div>
            </div>
            <input type="hidden" name="refine" value="2">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Ethnicity</label>
              <div class="col-sm-12">-
                <select class="form-control auto_submit_item" name="ethnicity[]" multiple="">
                  <option value="0">Select Ethnicity </option>
                  <?php foreach ($Enthicity as $key => $Enthicity) { ?>
                    <option value="<?php echo $key ?>" <?php if (in_array($key, $ethnicity)) {
                                                          echo "selected";
                                                        } ?>><?php echo  $Enthicity; ?> </option>

                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group Review">
              <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>

              <input type="radio" style="margin-left: 10px;" name="allrated" value="rate" class="auto_submit_item" <?php if ($rated == "rate") {
                                                                                                                      echo "checked";
                                                                                                                    } ?> /> All Rated

              <input type="radio" name="allrated" value="unrate" class="auto_submit_item" <?php if ($rated == "unrate") {
                                                                                            echo "checked";
                                                                                          } ?> /> Not Reviewed

              <input type="radio" name="allrated" value="all" class="auto_submit_item" <?php if ($rated == "") {
                                                                                          echo "checked";
                                                                                        } ?> /> All
              <?php if ($rate) { ?>
                <?php if (max($rate) >= 9) { ?>
                  <a href="javascript:void(0)" class="review" rel="9">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>

                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>

                <?php if (max($rate) >= 8) { ?>
                  <a href="javascript:void(0)" class="review" rel="8">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <?php if (max($rate) >= 7) { ?>
                  <a href="javascript:void(0)" class="review" rel="7">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <?php if (max($rate) >= 6) { ?>
                  <a href="javascript:void(0)" class="review" rel="6">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <?php if (max($rate) >= 5) { ?>
                  <a href="javascript:void(0)" class="review" rel="5">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <?php if (max($rate) >= 4) { ?>
                  <a href="javascript:void(0)" class="review" rel="4">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <br>
                <?php if (max($rate) >= 3) { ?>
                  <a href="javascript:void(0)" class="review" rel="3">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <br>
                <?php if (max($rate) >= 2) { ?>
                  <a href="javascript:void(0)" class="review" rel="2">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
                <br>
                <?php if (max($rate) >= 1) { ?>
                  <a href="javascript:void(0)" class="review" rel="1" id="my">
                    <span class="fa fa-star" style="color: orange"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star" "></span>
                        <span class=" fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    & up
                  </a>
                <?php } ?>
              <?php  } ?>
              <input type="hidden" name="r3" id="rvi" value="<?php if ($r3) {
                                                                echo $r3;
                                                              } ?>" class="auto_submit_item" />
              <script type="text/javascript">
                var array = [];
                $(".review").click(function() {
                  array = $(this).attr('rel');
                  //alert"Tes");
                  $('#rvi').val(array[0])

                  $("#ajexrefine").submit();
                  //alert(array[0]);
                });
              </script>

            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Membership type</label>
              <?php foreach ($searchdata as $key => $value) {



                $data = $this->Comman->userskills($value['id']);
                if ($data) {

                  //pr($value);
                  if ($value['areyoua']) {

                    $areyou = $value['areyoua'];
                    if (!in_array($areyou, $are)) {
                      $are[] = $value['areyoua'];
                    }
                  }
                }
              }


              ?>
              <div class="col-sm-12">



                <select class="form-control auto_submit_item" name="workingstyle[]" multiple="">
                  <option value="0" disabled>Select Membership type</option>
                  <?php for ($i = 0; $i < count($are); $i++) { ?>
                    <option value="<?php echo $are[$i] ?>" <?php if (in_array($are[$i], $workingstyleasel)) {
                                                              echo "selected";
                                                            } ?>>
                      <?php if ($are[$i] == "P") {
                        echo "Professional";
                      } else if ($are[$i] == "A") {
                        echo "Amateur";
                      } elseif ($are[$i] == "PT") {
                        echo "Part time";
                      } else if ($are[$i] == "H") {
                        echo "Hobbyist";
                      } ?>



                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-12 control-label">Search By Working Style</label>
              <?php foreach ($searchdata as $key => $value) {



                $data = $this->Comman->userskills($value['id']);
                if ($data) {

                  //pr($value);
                  if ($value['areyoua']) {

                    $areyou = $value['areyoua'];
                    if (!in_array($areyou, $are)) {
                      $are[] = $value['areyoua'];
                    }
                  }
                }
              }


              ?>
              <div class="col-sm-12">





                <select class="form-control auto_submit_item" name="profilepackage">
                  <option value="0">Profile Membership package</option>
                  <?php foreach ($profilepackagearray as $key => $skillvalue) { ?>
                    <option value="<?php echo $key ?>" <?php if ($pid == $key) {
                                                          echo "selected";
                                                        } ?>> <?php echo  $skillvalue; ?> </option>

                  <?php } ?>
                </select>


                <select class="form-control auto_submit_item" name="recpackage">
                  <option value="0">Recruiter Membership package</option>
                  <?php foreach ($recpackagearray as $key => $skillvalue) { ?>
                    <option value="<?php echo $key ?>" <?php if ($rid == $key) {
                                                          echo "selected";
                                                        } ?>> <?php echo  $skillvalue; ?> </option>

                  <?php } ?>
                </select>
              </div>
            </div>


            <div class="form-group">
              <div class="col-sm-12">

                <?php
                if (isset($_GET['refine']) && $_GET['refine'] == 2) {
                  echo  '<a style="background-color: #228B22 !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                } else {
                  echo  '<a style="background-color: #008B8B !important;" class="btn btn-primary btn-block" href="javascript:void(0)" onclick="newSearchButton();">Refine Search</a>';
                }
                ?><br />

                <?php if ($backtorefine == 1) { ?>

                  <a style="background-color: #8B0000 !important;" class="btn btn-default" onclick="window.history.back()">Back to Search Result </a>
                <?php } else {  ?>
                  <a href="javascript:void(0)" class="btn btn-default" ?>Back to Search Result </a>
                <?php } ?>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-9" id="data">
    <div class="panel-right">
    </div>
  </div>

<?php } ?>

<script type="text/javascript">
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  $('.saveprofile').click(function() {
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
      success: function(response) {
        var myObj = JSON.parse(response);
        if (myObj.success == 1) {
          $('#' + profile + '').css('color', 'red');
        } else {
          $('#' + profile + '').css('color', 'white');
        }
      },
      complete: function() {},
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
      url: SITE_URL + 'search/savesearchprofileresult',
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

<script type="text/javascript">
  var site_url = '<?php echo SITE_URL; ?>/';

  function myfunctionsingle(x) {
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
        $('#cloddersingle').css("display", "block");

      },
      success: function(response) {
        var obj = JSON.parse(response);
        // console.log('>>>>>>>>',obj);
        // Set currency name in the readonly text field
        $('#currencysingle' + reqid).val(obj.currency);

        // Set offer amount or blank if null/0
        if (!obj.payment_currency || obj.payment_currency == 0) {
          $('#offeramtsingle' + reqid).val('');
          $('#offeramtsingle' + reqid).attr("placeholder", "Open to Negotiation");
        } else {
          $('#offeramtsingle' + reqid).val(obj.payment_currency);
        }

        // Set the selected currency in the <select> dropdown
        if (obj.currency_id) {
          $('#currencysingle' + reqid).val(obj.currency_id);
        } else {
          $('#currencysingle' + reqid).val(''); // default to empty
        }
      },
      complete: function() {
        $('#cloddersingle').css("display", "none");
      },
      error: function(data) {
        showerror(JSON.stringify(data))
      }
    });
  }

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
        // console.log(obj);
        // Set currency name in the readonly text field
        $('#currency' + reqid).val(obj.currency);
        // Set offer amount or blank if null/0
        if (!obj.payment_currency || obj.payment_currency == 0) {
          $('#offeramt' + reqid).val('');
          $('#offeramt' + reqid).attr("placeholder", "Open to Negotiation");
        } else {
          $('#offeramt' + reqid).val(obj.payment_currency);
        }
        // Set the selected currency in the <select> dropdown
        if (obj.currency_id) {
          $('#currency' + reqid).val(obj.currency_id);
        } else {
          $('#currency' + reqid).val(''); // default to empty
        }
      },
      // success: function(response) {
      //   var obj = JSON.parse(response);
      //   $('#offeramt' + reqid).val(obj.payment_currency);
      //   $('#currency' + reqid).val(obj.currency);
      // },
      complete: function() {
        $('#clodder').css("display", "none");
      },
      error: function(data) {
        // alert(JSON.stringify(data));
        showerror(JSON.stringify(data))

      }
    });
  }
</script>

<script type="text/javascript">
  $(function() {
    $(".auto_submit_item").change(function() {
      //  alert("Test");
      $("#ajexrefine").submit();
    });
  });
</script>

<script>
  <?php if ($this->Flash->render('job_fail')) {  ?>
    // $(document).ready(function() { //alert();
    //   $('#jobrefer').modal('show');
    // });
  <?php } ?>
</script>

<script>
  <?php if ($this->Flash->render('booking_fail')) {  ?>
    $(document).ready(function() { //alert();
      $('#bookingrefer').modal('show');
    });
  <?php } ?>
</script>

<script>
  <?php if ($this->Flash->render('alreadyask_job_fail')) {  ?>
    $(document).ready(function() { //alert();
      $('#askquotealreadyrefrer').modal('show');
    });
  <?php } ?>
</script>

<script>
  <?php if ($this->Flash->render('alreadybooknow_job_fail')) {  ?>
    $(document).ready(function() { //alert();
      $('#booknowalreadyrefrer').modal('show');
    });
  <?php } ?>
</script>


<div class="modal fade" id="bookingrefer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('', array('url' => array('controller' => 'search', 'action' => 'bookingquoterpeat'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>

            <?php
            foreach ($_SESSION['booknownotinvite'] as $key => $value) { ?>
              <?php $jobdetailbooking = $this->Comman->repeatbooking($key);  ?>
              <?php $alreadybooking = $this->Comman->bookingalready($key, $value);  ?>

              <td>
                <input type="hidden" name="jobselectedprofile" value="<?php echo $_SESSION['bookingselectedprofile']['profile']; ?>">
                <input type="checkbox" name="job_idss[<?php echo $key; ?>][]" value="<?php echo $value; ?>">
              </td>
              <td><?php echo $jobdetailbooking['title'] . " job  you book now available data only " . ($jobdetailbooking['booknowdata']) . " are you Book Now" ?></td>

              <tr>

                <?php  /*if ($alreadybooking== $jobdetailbooking['requirment_vacancy'][0]['number_of_vacancy']){ ?>  
                <td></td>
                <td><?php echo $jobdetailbooking['title']."already Booked"; ?></td>
                
              <?php echo "test"; }else{ echo "tesddt";   ?>
              

              <?php  } */ ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <button type="submit" class="btn btn-default" id="">Yes</button>
        </form>
        <button type="submit" class="btn btn-default" id="jobselectno">No</button>

      </div>

    </div>

  </div>
</div>

<div class="modal fade" id="jobrefer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('', array('url' => array('controller' => 'search', 'action' => 'askquoterpeat'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>
            <?php foreach ($_SESSION['askquotenotinvite'] as $key => $value) { ?>
              <tr>
                <?php $jobdetail = $this->Comman->repeatjob($key);  ?>
                <td>
                  <input type="hidden" name="jobselectedprofile" value="<?php echo $_SESSION['jobselectedprofile']['profile']; ?>">
                  <input type="checkbox" name="job_idss[<?php echo $key; ?>][]" value="<?php echo $value; ?>">
                  <!--<input type="hidden"  name="job_idss[<?php //echo $key; 
                                                            ?>][]" value="<?php //echo $value; 
                                                                          ?>">-->
                </td>
                <td><?php echo $jobdetail['title'] . " your ask quote data available only " . $jobdetail['askquotedata'] . " are you send data" ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <button type="submit" class="btn btn-default" id="">Yes</button>
        </form>
        <button type="submit" class="btn btn-default" id="jobselectno">No</button>

      </div>

    </div>

  </div>
</div>

<script>
  $('#jobselectno').click(function() {
    location.reload();
  });
</script>


<script>
  /*  Like Profile profile*/
  $('.likeprofile').click(function() {

    var profile = $(this).data('val');
    event.preventDefault();
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: '<?php echo SITE_URL; ?>/profile/likeprofile',
      data: {
        user_id: profile
      },
      beforeSend: function() {},
      success: function(response) {
        var myObj = JSON.parse(response);
        if (myObj.status == 'like') {
          $('#likeprofile' + profile + '').css('color', 'red');
        } else {
          $('#likeprofile' + profile + '').css('color', 'white');
        }
      },
      complete: function() {},
      error: function(data) {
        // alert(JSON.stringify(data));
        showerror(JSON.stringify(data))
      }

    });

  });

  /*  Block Profile profile*/
  $('#blockprofile').click(function() {
    error_text = "You cannot Block yourself";
    user_id = $(this).data('val');
    if (user_id > 0) {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/profile/blockprofile',
        data: {
          user_id: user_id
        },
        cache: false,
        success: function(data) {
          obj = JSON.parse(data);
          if (obj.error == 1) {
            showerror(error_text);
          } else {
            if (obj.status == 'block') {
              $("#blockprofile").addClass('active');
            } else {
              $("#blockprofile").removeClass('active');
            }
          }
        }
      });
    } else {
      showerror(error_text);
    }
  });
  //profile counter
  function profilecounter(obj) {
    $.ajax({
      type: "post",
      url: '<?php echo SITE_URL; ?>/profile/profilecounter',
      data: {
        data: obj
      },
      success: function(data) {
        obj = JSON.parse(data);
        if (obj.status == 1) {
          var div = document.getElementById("newpost");
          div.style.display = "block";
        } else {
          showerror(obj.error);
        }
      }
    });
  }

  function showerror(error) {
    BootstrapDialog.alert({
      size: BootstrapDialog.SIZE_SMALL,
      title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
      message: "<h5>" + error + "</h5>"
    });
    return false;
  }
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

<script>
  $('.report').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>


<div id="sendmessage" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal -->
<script>
  $('.sendmessage').click(function(e) {
    e.preventDefault();
    userid = $(this).data('val');
    messagingurl = '<?php echo SITE_URL; ?>/message/sendmessage/' + userid;
    $('#sendmessage').modal('show').find('.modal-body').load(messagingurl);
  });
</script>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Report for this User</h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->



</div>
<!-- /.modal -->


<!-- <script>
			$('.book').click(function(e){
				e.preventDefault();
				action = $(this).data('action');

				userid = $(this).data('val');
        alert(userid)
				bookingurl = '<?php //echo SITE_URL; 
                      ?>/jobpost/book/'+userid+'/'+action;
				$('#bookbooking').modal('show').find('.modal-body').load(bookingurl);
			});
		</script> -->


<!-- Modal -->

<div id="bookbooking" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
      </div>
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->