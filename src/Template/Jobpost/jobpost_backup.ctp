<script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
<link href=https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<!-- stylis alert box design -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style type="text/css">
  .input-file-container {
    position: relative;
    display: inline-block;
  }

  .input-file-trigger {
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    padding: 8px 15px;
    cursor: pointer;
    display: block;
    width: 100%;
  }

  #fileInput {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
  }
</style>
<?php
foreach ($requirementvacancy as $key => $value) { //pr($value);
  // $talentarray[] = $value['talent_requirement'];
  $talentarray[] = $value['telent_type'];
  $sillname = $this->Comman->getSkillname($value['telent_type']);
  // $sillname = $this->Comman->getSkillname($value['talent_requirement']);
  $array1[] = $sillname['name'];
  $array[] = $sillname['id'];
}
// pr($requirement);
// die;

?>
<?php //unset($_SESSION['eligible']['jobpost']); 
?>
<section id="page_post-req">
  <div class="container">
    <h2>Post Your <span>Requirement</span></h2>
    <p class="m-bott-50"> Fields With '*' Are Compulsory To Fill <!--Here You Can Fill Post Talent--> </p>
    <?php echo $this->Flash->render(); ?>
  </div>

  <?php if (!empty($jobposterror)) { ?>
    <section class="content-header">
      <div class="alert alert-danger alert-dismissible">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $jobposterror; ?>
      </div>
    </section>
  <?php } ?>

  <div class="post-talant-form">
    <div class="container profile-bg requirement ">
      <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'jobpost', 'action' => 'jobpost'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

      <!-- <script type="text/javascript">
        function initialize() {
          var latlng = new google.maps.LatLng(<?php //echo $requirement['latitude'] 
                                              ?>, <?php //echo $requirement['longitude'] 
                                                  ?>);
          var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 13
          });
          var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            draggable: false,
            anchorPoint: new google.maps.Point(0, -29)
          });
          var infowindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function() {
            var iwContent = '<div id="iw_container">' +
              '<div class="iw_title"><b>Location</b> : <?php //echo $requirement["location"]; 
                                                        ?></div></div>';
            // including content to the infowindow
            infowindow.setContent(iwContent);
            // opening the infowindow in the current map and at the current marker location
            infowindow.open(map, marker);
          });
        }

        google.maps.event.addDomListener(window, 'load', initialize);


        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else {
            console.log("Geolocation is not supported by this browser.");
          }
        }

        function showPosition(position) {
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;

          console.log("Latitude: " + latitude);
          console.log("Longitude: " + longitude);
        }

        // Call the getLocation() function to initiate the retrieval of the live location.
        // showPosition();
        getLocation();
      </script> -->

      <script>
        function initialize() {
          var defaultLat = 37.7749; // Default latitude value
          var defaultLng = -122.4194; // Default longitude value

          function showPosition(position) {
            var latitude = <?php echo isset($requirement['latitude']) ? $requirement['latitude'] : 'position.coords.latitude'; ?>;
            var longitude = <?php echo isset($requirement['longitude']) ? $requirement['longitude'] : 'position.coords.longitude'; ?>;

            var latlng = new google.maps.LatLng(latitude, longitude);
            var map = new google.maps.Map(document.getElementById('map'), {
              center: latlng,
              zoom: 13
            });

            var marker = new google.maps.Marker({
              map: map,
              position: latlng,
              draggable: false,
              anchorPoint: new google.maps.Point(0, -29)
            });

            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function() {
              // console.log("🚀 ~ file: jobpost.ctp:108 ~ showPosition ~ infowindow:", infowindow)

              var iwContent = '<div id="iw_container">' +
                '<div class="iw_title"><b>Location</b>: <?php echo isset($requirement["location"]) ? $requirement["location"] : "Default Location"; ?></div></div>';

              infowindow.setContent(iwContent);
              infowindow.open(map, marker);
            });
          }

          function getLocation() {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
            } else {
              console.log("Geolocation is not supported by this browser.");
            }
          }

          getLocation();
        }

        google.maps.event.addDomListener(window, 'load', initialize);
      </script>

      <link href="<?php echo SITE_URL; ?>/css/imgareaselect-default.css" rel="stylesheet" media="screen">
      <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery.awesome-cropper.css">
      <div class="form-group">


        <label for="inputEmail3" class="col-sm-2 control-label">Profile image :</label>
        <div class="col-sm-10 upload-img ">
          <?php if ($requirement['image'] != '') { ?>
            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/job/<?php echo $requirement['image']; ?>" />

          <?php } else { ?>
            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/images/job.jpg" />
          <?php } ?>
          <!-- code by rumapm sir -->
          <!-- <div class="pro_new_img"><a href="#">
                <div class="input-file-container">
                  <input id="sample_input" type="hidden" name="profile_image">
                  <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                  <span id="ncpyss" style="display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
                </div>
              </a>
            </div> -->
          <!-- new code  -->
          <div class="pro_new_img">
            <div class="input-file-container">
              <label tabindex="0" class="input-file-trigger" for="fileInput">Upload Image</label>
              <input type="file" name="image" id="fileInput" accept=".jpg, .jpeg, .png" onchange="previewImage(this)">
            </div>
            <span id="ncpyss" style="display: none; color: red;">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

            <script>
              function validateImage(input) {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (!allowedExtensions.exec(input.value)) {
                  document.getElementById('ncpyss').style.display = 'block';
                  input.value = '';
                } else {
                  document.getElementById('ncpyss').style.display = 'none';
                }
              }
            </script>

          </div>
        </div>


        <div class="col-sm-3">
          <!-- <input type="file" class="upload">-->
          <p class="file-return"></p>
        </div>
      </div>



      <div class="form-group">
        <label for="" class="col-sm-2 control-label" style="color: #078fe8;"><u>TITLE OF JOB/EVENT :</u> <span class="jobpostrequired">*</span></label>
        <div class="col-sm-10">
          <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Title of Job/Event', 'id' => 'name', 'required', 'label' => false)); ?>

        </div>
        <!-- <div class="col-sm-1"></div> -->
      </div>


      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Talent Requirement: <span class="jobpostrequired">*</span></label>
        <div class="col-sm-8">
          <!-- ?php echo $this->Form->input('telent_type', array('class' =>
          'longinput form-control skillsdata', 'maxlength' => '20', 'placeholder' => 'Skills', 'label' => false, 'value' => implode(", ", $array1), 'id' => 'skillshow', 'required' => true)); ?>
          <input type="hidden" name="data[telent_type][]" id="skill" value="<?php echo  implode(",", $array); ?>" /> -->
          <?php echo $this->Form->input('telent_type', array('class' =>
          'longinput form-control skillsdata', 'maxlength' => '20', 'placeholder' => 'Skills', 'label' => false, 'value' => implode(", ", $array1), 'id' => 'skillshow', 'required' => true)); ?>
          <input type="hidden" name="data[telent_type][]" id="skill" value="<?php echo  implode(",", $array); ?>" />
          <!--    <input type="text" class="form-control" placeholder="Skills">-->
        </div>
        <div class="col-sm-2">
          <a type="button" class="skill btn btn-success" data-toggle="modal" data-target="#totrequirement">Choose Skill</a>
        </div>
      </div>
      <script>
        $('.skillsdata').click(function(e) {
          e.preventDefault();
          $('#totrequirement').modal('show').find('.modal-body');
        });
      </script>

      <div class="modal fade" id="totrequirement" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
            <div class="modal-body clearfix" id="skillsetsearch">
              <section class="content-header hide" id="error_message">
                <div class="alert alert-danger alert-dismissible">
                  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <p id="skill_error"></p>
                </div>
              </section>

              <ul id="myUL" class="list-inline form-group col-sm-12 m-ad-req">
                <?php $i = 0;
                foreach ($Skill as $value) { ?>
                  <li>
                    <label>
                      <input
                        type="checkbox"
                        name="requirement"
                        value="<?php echo $value['id']; ?>"
                        onclick="addSkill(this)"
                        class="rooms"
                        id="silkk<?php echo $i; ?>"
                        data-skill-type="<?php echo $value['name']; ?>"
                        data-val="<?php echo $value['name']; ?>"
                        <?php if (in_array($value['id'], $talentarray)) {
                          echo "checked";
                        } ?> />
                      <?php echo $value['name']; ?>
                    </label>
                  </li>
                <?php $i++;
                } ?>

              </ul>
            </div>

          </div>

        </div>
      </div>

      <?php
      $user_role_id = $this->request->session()->read('Auth.User.role_id');

      // Determine the total eligible skills limit
      $total_eligible_skills = !empty($existing_subscription['number_of_talent_type'])
        ? $existing_subscription['number_of_talent_type']
        : ($packfeature['number_of_talent_free_jobpost'] ?? 1);

      // Determine the number of valid days based on user role
      $number_valid_of_days = !empty($existing_subscription['number_of_days'])
        ? $existing_subscription['number_of_days']
        : (
          $user_role_id == TALANT_ROLEID
          ? ($packfeature['number_of_days_free_jobpost_talent'] ?? 1)
          : ($packfeature['number_of_days_free_jobpost'] ?? 1)
        );


      // pr($number_valid_of_days);exit;

      ?>

      <script>
        var totalEligibleSkills = '<?php echo $total_eligible_skills; ?>';
        $("#skill_error").html(`You can only add ${totalEligibleSkills} skills to your job.`);
        $("#error_message").css("backgroud", "green").removeClass("hide");

        function addSkill(ele) {
          var selectedSkills = [];
          var selectedSkillTypes = [];
          $("input:checkbox[class=rooms]").each(function() {
            if ($(this).is(":checked")) {
              selectedSkills.push($(this).val());
              selectedSkillTypes.push(' ' + $(this).attr("data-skill-type"));
              var checkedSkillsCount = $('input:checkbox[class=rooms]:checked').length;
              if (checkedSkillsCount > totalEligibleSkills) {
                var skillError = `You can only add ${totalEligibleSkills} skills to your job. To increase this limit, please upgrade your Profile Package.`;
                $("#skill_error").html(skillError);
                $("#error_message").removeClass("hide");
                this.checked = false;
              }
            }
          });

          $("input:checkbox[class=rooms]").each(function() {
            if ($('input:checkbox[class=rooms]:checked').length >= totalEligibleSkills) {
              this.disabled = !this.checked;
            } else {
              this.disabled = false;
            }
          });

          $('#skill').val(selectedSkills);
          $('#skillshow').val(selectedSkillTypes);
        }
      </script>


      <script>
        function myFunction() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInput");

          filter = input.value.toUpperCase();
          ul = document.getElementById("myUL");
          li = ul.getElementsByTagName("li");
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("label")[0];

            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";

            }
          }
        }
      </script>

      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Continuous Job:</label>
        <div class="col-sm-8">
          <?php $cntjob = array('Y' => 'Yes', 'N' => 'No'); ?>

          <!-- Radio Button for Yes -->
          <label class="radio-inline">
            <input
              type="radio"
              name="continuejob"
              id="eventreminder"
              value="Y"
              onclick="changerefertype(this)"
              <?php echo ($requirement['continuejob'] == 'Y') ? 'checked' : ''; ?>>
            Yes
          </label>

          <!-- Radio Button for No -->
          <label class="radio-inline">
            <input
              type="radio"
              name="continuejob"
              id="eventtd"
              value="N"
              onclick="changerefertype(this)"
              <?php echo ($requirement['continuejob'] == 'N') ? 'checked' : ''; ?>>
            No
          </label>

          <!-- Popover Info -->
          <span class="pop-cnt">
            <a href="javascript:void(0)"
              data-toggle="popover"
              data-placement="bottom"
              data-content="Select Yes as an option if you are hiring for a Permanent job. A permanent job is one that does not have a fixed start and end date">
              <i class="fa fa-info"></i>
            </a>
          </span>

          <!-- Popover Initialization -->
          <script>
            $(document).ready(function() {
              $('[data-toggle="popover"]').popover();
            });
          </script>
        </div>
      </div>


      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Talent Requirement Description :</label>
        <div class="col-sm-10">
          <?php echo $this->Form->input('talent_requirement_description', array('class' => 'form-control', 'placeholder' => 'Explain in Details the Type of Skill and Talent that you need to hire. More the details the better it is', 'id' => 'name', 'label' => false, 'type' => 'textarea')); ?>
        </div>
        <div class="col-sm-1"></div>
      </div>

      <?php if (count($requirementvacancy) > 0) { ?>
        <span id="ncpy">
        <?php } else { ?>
          <span id="ncpy" style="display: none; color: red">
          <?php } ?>
          <div id="">
            <br clear="all" />
            <div class="form-group">
              <div class="col-sm-12">
                <div>
                  <div class="multi-field-wrapper">
                    <?php
                    $genderdef = 'ANY - Select ANY if the Gender of Talent that you are want to hire does not matter.
                      MALE - Select MALE if you are looking to hire an individual or groups who is/are Men. 
                      FEMALE - Select FEMALE if you are looking to hire an individual or groups who is/are Women. 
                      OTHERS - Select OTHERS if you are looking for a inter-sexual talent to hire
                      BOTH MALE AND FEMALE - Select this option when you are looking to hire a band that has members from both the sexes Male and Female '; ?>

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Talent Requirement</th>
                          <th>Vacancy <span class="jobpostrequired">*</span></th>
                          <th>Gender <span class="jobpostrequired">*</span> <span class="pop-cnt p"> <a href="javascript:void(0)" data-toggle="popovessr" data-placement="bottom" data-content="<?php echo $genderdef; ?>"><i class="fa fa-question"></i></a>

                              <script>
                                $(document).ready(function() {
                                  $('[data-toggle="popovessr"]').popover();
                                });
                              </script>
                            </span></th>
                          <th>Payment
                            Frequency</th>
                          <th>Payment
                            Currency</th>
                          <th>Payment
                            Amount</th>


                        </tr>
                      </thead>
                      <tbody class="video_container">
                        <?php if (count($requirementvacancy) > 0) { ?>

                          <?php $i = 1;
                          foreach ($requirementvacancy as $key => $value) { //pr($value); 

                            $skillname = $this->Comman->getSkillname($value[' telent_type']);
                            // $skillname = $this->Comman->getSkillname($value['talent_requirement']);

                          ?>

                            <tr class="video_details" id="room-<?php echo $i; ?>">
                              <td>
                                <?php echo $this->Form->input('requirementskills', array('class' => 'form-control', 'placeholder' => 'requirementvacancy', 'value' => $skillname['name'], 'required' => true, 'label' => false, 'type' => 'text', 'name' => 'data[requirementskills][]', 'readonly' => true)); ?>
                              </td>

                              <td>
                                <?php echo $this->Form->input('number_of_vacancy', array('class' => 'form-control', 'placeholder' => 'Number of Vacancy', 'required' => true, 'label' => false, 'type' => 'number', 'min' => 1, 'name' => 'data[number_of_vacancy][]', 'value' => $value['number_of_vacancy'])); ?>
                              </td>

                              <?php $gen = array('a' => 'Any', 'bmf' => 'Both Male And Female', 'm' => 'Male', 'f' => 'Female', 'o' => 'Other', 'required' => true); ?>

                              <td>
                                <?php echo $this->Form->input('sex', array('class' => 'form-control', 'placeholder' => 'Gender', 'label' => false, 'empty' => '--Select Gender--', 'options' => $gen, 'selected' => 'selected', 'name' => 'data[sex][]', 'value' => $value['sex'], 'required' => true)); ?>

                              </td>


                              <td>
                                <?php echo $this->Form->input('payment_freq', array('class' => 'form-control payfreq', 'placeholder' => 'Frequency', 'label' => false, 'empty' => '-- Select Frequency--', 'options' => $payfreq, 'name' => 'data[payment_freq][]', 'value' => $value['payment_freq'])); ?>
                              </td>


                              <td>
                                <?php echo $this->Form->input('payment_currency', array('class' => 'form-control paycur', 'placeholder' => 'Amount', 'label' => false, 'empty' => '--Select Currency--', 'options' => $Currency, 'selected' => 'selected', 'name' => 'data[payment_currency][]', 'value' => $value['payment_currency'], 'disabled', 'title' => 'Please select Payment Frequency (per) option')); ?>
                              </td>


                              <td> <?php echo $this->Form->input('payment_amount', array('class' => 'form-control payamt', 'placeholder' => 'Amount', 'id' => 'name', 'label' => false, 'type' => 'number', 'min' => 1, 'name' => 'data[payment_amount][]', 'value' => $value['payment_amount'], 'disabled', 'title' => 'Please select Payment Frequency (per) option')); ?></td>

                            </tr>
                          <?php $i++;
                          }
                        } else { ?>

                          <tr class="video_details" id="room-1">
                            <td>
                              <?php echo $this->Form->input('requirementskills', array('class' => 'form-control', 'placeholder' => 'requirementvacancy', 'label' => false, 'type' => 'text', 'name' => 'data[requirementskills][]', 'readonly'
                              => true)); ?>
                            </td>
                            <td>
                              <?php echo $this->Form->input('number_of_vacancy', array('class' => 'form-control', 'placeholder' => 'Number of Vacancy', 'label' => false, 'required' => true, 'type' => 'number', 'min' => 1, 'name' =>
                              'data[number_of_vacancy][]')); ?>
                            </td>
                            <?php $gen = array('a' =>
                            'Any', 'bmf' => 'Both Male And Female', 'm' => 'Male', 'f' => 'Female', 'o' => 'Other',); ?>
                            <td>
                              <?php echo $this->Form->input('sex', array('class' => 'form-control', 'placeholder' => 'Gender', 'label' => false, 'required' => true, 'empty' => '--Select Gender--', 'options' => $gen, 'selected' => 'selected', 'name' =>
                              'data[sex][]')); ?>
                            </td>

                            <td>
                              <?php echo $this->Form->input('payment_freq', array('class' => 'form-control payfreq', 'placeholder' => 'Frequency', 'label' => false, 'empty' => '-- Select Frequency--', 'options' => $payfreq, 'name' =>
                              'data[payment_freq][]')); ?>
                            </td>

                            <td>
                              <?php echo $this->Form->input('payment_currency', array(
                                'class' => 'form-control paycur',
                                'placeholder' => 'Amount',
                                'label' => false,
                                'empty' => '--Select Currency--',
                                'options' => $Currency,
                                'selected' => 'selected',
                                'name' => 'data[payment_currency][]',
                                'disabled',
                                'title' => 'Please select Payment Frequency (per) option'
                              )); ?>
                            </td>

                            <td>
                              <?php echo $this->Form->input('payment_amount', array(
                                'class' => 'form-control payamt',
                                'placeholder' => 'Amount',
                                'label' => false,
                                'type' => 'number',
                                'min' => 1,
                                'name' => 'data[payment_amount][]',
                                'disabled',
                                'title' => 'Payment Amount'
                              )); ?>
                            </td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </span>

          <script>
            // $(document).ready(function() {
            $(document).on('change', '.payfreq', function() {
              var id = $(this).find('option:selected').val();
              // console.log(id, '>>>>>>...');

              if (id) {
                $('.payamt').removeAttr('disabled');
                $('.paycur').removeAttr('disabled');
                $('.paycur').removeAttr('title');
                $('.payamt').removeAttr('title');
              } else {
                $('.payamt').prop('disabled', true);
                $('.paycur').prop('disabled', true);
                $('.payamt').prop('title', 'Please select Payment Frequency (per) option');
                $('.paycur').prop('title', 'Please select Payment Frequency (per) option');
              }
            });

            // });
          </script>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Payment Description :</label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('payment_description', array('class' => 'form-control', 'placeholder' => 'Describe your Terms and Conditions of Payment including Food, Lodging, Travel etc.', 'id' => 'name', 'label' => false, 'type' => 'textarea')); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>
          <!--
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Time:</label>
                  <div class="col-sm-8">
            <?php $type = array('Part Time' => 'Part Time', 'Full Time' => 'Full Time'); ?>
                   <?php //echo $this->Form->input('time',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'--Select Type--','options'=>$type,'selected'=>'selected')); 
                    ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
              -->


          <div class="form-group">
            <label for="" class="col-sm-2 control-label" style="color: #078fe8;"><u> JOB/EVENT TYPE : </u><span class="jobpostrequired">*</span></label>
            <div class="col-sm-8">
              <?php $eventname = $this->Comman->getEventname($requirement['event_type']); //pr($eventname); 
              ?>
              <?php echo $this->Form->input('eventtype', array('class' =>
              'longinput form-control eventdata', 'placeholder' => 'Event type', 'label' => false, 'value' => $eventname['name'], 'id' => 'event_typ', 'required' => true)); ?>
            </div>
            <div class="col-sm-2"> <a type="button" class="skills btn btn-success" data-toggle="modal" data-target="#eventrequirement">Select Job/Event</a></div>
          </div>

          <script>
            $('.eventdata').click(function(e) {
              e.preventDefault();
              $('#eventrequirement').modal('show').find('.modal-body');
            });
          </script>
          <div class="modal fade" id="eventrequirement" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <input id="myInputeventtype" onkeyup="myFunctionevent(this)" placeholder="Search from list..." type="text">
                <div class="modal-body clearfix" id="skillsetsearch">

                  <section class="content-header hide" id="error_message_event">
                    <div class="alert alert-danger alert-dismissible">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <p id="skill_error_event"></p>
                    </div>
                  </section>
                  <ul id="myULevent" class="list-inline form-group col-sm-12 m-ad-req">
                    <?php $i = 1; ?>
                    <?php foreach ($eventtype as $value): ?>
                      <li>
                        <label>
                          <input
                            type="checkbox"
                            name="event_type"
                            value="<?php echo htmlspecialchars($value['id']); ?>"
                            id="event<?php echo $i; ?>"
                            class="chk"
                            data-event-type="<?php echo htmlspecialchars($value['name']); ?>"
                            data-val="<?php echo htmlspecialchars($value['name']); ?>"
                            onclick="addevent(this)"
                            <?php echo $value['id'] == $requirement['event_type'] ? 'checked' : ''; ?> />
                          <?php echo htmlspecialchars($value['name']); ?>
                        </label>
                      </li>
                      <?php $i++; ?>
                    <?php endforeach; ?>

                  </ul>
                </div>

              </div>

            </div>
          </div>


          <script>
            function addevent(ele) {
              var fruits = [];
              var other = [];
              var total_elegible_skills = 1;

              var ckName = document.getElementsByName(ele.name);
              var checked = document.getElementById(ele.id);
              $("input:checkbox[class=chk]").each(function() {
                if ($(this).is(":checked")) {

                  var checkedskills = $('input:checkbox[class=chk]:checked').length;

                  if (checkedskills > total_elegible_skills) {
                    skill_error = "You can only add " + total_elegible_skills + " Event in your Job";
                    $("#skill_error_event").html(skill_error);
                    $("#error_message_event").removeClass("hide");
                    //  $(this).is(":unchecked");
                    $(checked).removeAttr('checked');
                    //  $(this).checked = false;
                  }

                  for (var i = 0; checkedskills > total_elegible_skills; i++) {
                    if (!ckName[i].checked) {
                      ckName[i].disabled = true;

                    } else {
                      ckName[i].disabled = false;

                    }
                  }
                  fruits.push($(this).val());
                  other.push(' ' + $(this).attr("data-event-type"));
                } else {
                  for (var i = 0; i < ckName.length; i++) {
                    ckName[i].disabled = false;
                  }
                }

              });

              $('#skill-event').val(fruits);
              $('#event_typ').val(other);
            }
          </script>

          <script>
            function myFunctionevent() {
              var input, filter, ul, li, a, i;
              input = document.getElementById("myInputeventtype");

              filter = input.value.toUpperCase();
              ul = document.getElementById("myULevent");
              li = ul.getElementsByTagName("li");
              for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("label")[0];

                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                  li[i].style.display = "";
                } else {
                  li[i].style.display = "none";

                }
              }
            }
          </script>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Number of Attendees :</label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('number_attendees', array('class' => 'form-control', 'placeholder' => 'Number', 'id' => '', 'label' => false, 'type' => 'number', 'min' => 1)); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group talentevent">
            <label for="" class="col-sm-2 control-label">Event Date, Time From: <span class="jobpostrequired">*</span></label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-5 date">

                  <?php echo $this->Form->input('event_from_date', array('class' => 'form-control datetimepicker1', 'placeholder' => 'MM DD,YYYY', 'required' => true, 'type' => 'text', 'required' => true, 'label' => false, 'value' => (!empty($requirement['event_from_date'])) ? '' : '')); ?>

                </div>

                <label for="" class="col-sm-2 control-label" style="text-align:center">To :</label>
                <div class="col-sm-5 date">
                  <?php echo $this->Form->input('event_to_date', array('class' => 'form-control datetimepicker2', 'placeholder' => 'MM DD,YYYY', 'type' => 'text', 'required' => true, 'label' => false, 'value' => (!empty($requirement['event_from_date'])) ? '' : '')); ?>
                </div>
              </div>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Last Date of Application Date/Time:</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-5 date">

                  <?php echo $this->Form->input('last_date_app', array('class' => 'form-control datetimepicker3', 'readonly' => true, 'placeholder' => 'MM DD,YYYY', 'type' => 'text', 'id' => 'datepicker', 'required' => true, 'label' => false, 'value' => (!empty($requirement['last_date_app'])) ? '' : '')); ?>

                </div>

                <label for="" class="col-sm-2 control-label" style="text-align:center"></label>
                <div class="col-sm-5 date">
                </div>
              </div>
            </div>

            <!-- <div class="col-sm-1"></div> -->

          </div>

          <div class="form-group talentreq">
            <label for="" class="col-sm-2 control-label">Talent Required Date, Time From:</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-5 date">

                  <?php
                  echo $this->Form->input('talent_required_fromdate', array('class' => 'form-control datetimepicker4', 'readonly' => true, 'placeholder' => 'MM DD,YYYY', 'type' => 'text', 'id' => 'talentrequiredfrom', 'required' => true, 'label' => false, 'value' => (!empty($requirement['event_from_date'])) ? '' : '')); ?>

                </div>

                <label for="" class="col-sm-2 control-label" style="text-align:center">To :</label>

                <div class="col-sm-5 date">

                  <?php
                  echo $this->Form->input('talent_required_todate', array('class' => 'form-control datetimepicker5', 'readonly' => true, 'placeholder' => 'MM DD,YYYY', 'type' => 'text', 'id' => 'talentrequiredto', 'required' => true, 'label' => false, 'value' => (!empty($requirement['event_from_date'])) ? '' : '')); ?>

                  <?php if ($requirement['continuejob'] == 'Y') { ?>
                    <script>
                      //$('#csv_file').removeAttr('disabled');
                      $('#talentrequiredfrom').attr('disabled', 'disabled');
                      $('#talentrequiredto').attr('disabled', 'disabled');
                      $('#talentrequiredto').val('');
                      $('#talentrequiredfrom').val('');

                      $('#event-to-date').attr('disabled', 'disabled');
                      $('#event-from-date').attr('disabled', 'disabled');
                      $('#event-to-date').val('');
                      $('#event-from-date').val('');
                      //$('#mobile').attr('disabled','disabled');
                      $(".talentreq").hide();
                      $(".talentevent").hide();

                      $('#event-to-date').prop('title', 'Fill in Event From Date Time column');
                    </script>
                  <?php } ?>

                  <script type="text/javascript">
                    // Change refer type
                    function changerefertype(values) {
                      type = values.value;
                      if (type == 'Y') {
                        //$('#csv_file').removeAttr('disabled');
                        $('#talentrequiredfrom').attr('disabled', 'disabled');
                        $('#talentrequiredto').attr('disabled', 'disabled');
                        $('#talentrequiredto').val('');
                        $('#talentrequiredfrom').val('');
                        $('#event-to-date').attr('disabled', 'disabled');
                        $('#event-from-date').attr('disabled', 'disabled');
                        $('#event-to-date').val('');
                        $('#event-from-date').val('');
                        //$('#mobile').attr('disabled','disabled');
                        $(".talentreq").hide();
                        $(".talentevent").hide();
                        $('#event-to-date').prop('title', 'Fill in Event From Date Time column');
                        $('.datetimepicker3').datetimepicker('setStartDate', new Date());
                      } else {
                        $('#talentrequiredto').removeAttr('disabled');
                        $('#talentrequiredfrom').removeAttr('disabled');
                        $('#event-to-date').removeAttr('disabled');
                        $('#event-from-date').removeAttr('disabled');
                        $(".talentreq").show();
                        $(".talentevent").show();
                        $('#event-to-date').removeAttr('title');
                      }
                    }

                    var max_days = <?php echo $number_valid_of_days; ?>;
                    // console.log('>>>>>>>>>>>>', max_days);

                    $(function() {
                      var start = new Date();
                      // set end date to max one year period:
                      var end = new Date(new Date().setYear(start.getFullYear() + 1));
                      $('.datetimepicker1').datetimepicker({
                        format: 'MM dd,yyyy hh:ii',
                        startDate: start,
                        endDate: end
                        // update "toDate" defaults whenever "fromDate" changes
                      }).on('changeDate', function() {
                        // set the "toDate" start to not be later than "fromDate" ends:
                        var lastapplicationform = $(this).val();

                        var selectedDate = new Date($(this).val());
                        var endDateForPicker2 = new Date(selectedDate);
                        endDateForPicker2.setDate(selectedDate.getDate() + max_days);
                        // console.log("🚀 ~ file: jobpost.ctp:752 ~ endDateForPicker2:", endDateForPicker2)
                        // Set the endDate option for datetimepicker2
                        $('.datetimepicker2').datetimepicker('setEndDate', new Date(endDateForPicker2));
                        $('.datetimepicker2').datetimepicker('setStartDate', new Date(lastapplicationform));

                        // $('.datetimepicker2').datetimepicker('setStartDate', new Date($(this).val()));
                        $('.datetimepicker3').datetimepicker('setStartDate', new Date($(this).val()));
                        $('.datetimepicker5').datetimepicker('setStartDate', new Date($(this).val()));

                        document.getElementById("talentrequiredfrom").defaultValue = lastapplicationform;
                        //$('.datetimepicker4').defaultValue(lastapplicationform);
                        $(this).datetimepicker('hide');
                      });


                      $('.datetimepicker2').datetimepicker({
                        format: 'MM dd,yyyy hh:ii',
                        startDate: start,
                        endDate: end
                        // update "fromDate" defaults whenever "toDate" changes
                      }).on('changeDate', function() {
                        // set the "fromDate" end to not be later than "toDate" starts:
                        $('.datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));
                        $('.datetimepicker3').datetimepicker('setEndDate', new Date($(this).val()));
                        $('.datetimepicker3').datetimepicker('setDate', new Date($(this).val()));
                        $('.datetimepicker4').datetimepicker('setEndDate', new Date($(this).val()));
                        var lastapplicationto = $(this).val();
                        document.getElementById("talentrequiredto").defaultValue = lastapplicationto;
                        $(this).datetimepicker('hide');
                      });

                      <?php

                      // $sitesettings = $this->Comman->sitesettings();
                      // pr($sitesettings);
                      // exit;
                      //if($this->request->session()->read('eligible.job_validity'))  { 
                      if ($number_valid_of_days != 0) { ?>

                        var todayDate = new Date().getDate();
                        $('.datetimepicker3').datetimepicker({
                          format: 'MM dd,yyyy hh:ii',
                          language: 'en',
                          pickTime: false,
                          pick12HourFormat: true,
                          startDate: start,
                          endDate: new Date(new Date().setDate(todayDate + max_days))
                        });

                        var date7 = $('.datetimepicker3').datetimepicker('getDate', max_days);
                        date7.setDate(date7.getDate() + max_days);
                        $('.datetimepicker3').datetimepicker('setDate', date7);
                      <?php } else { ?>
                        var max_days = 90;
                        var todayDate = new Date().getDate();
                        $('.datetimepicker3').datetimepicker({
                          format: 'MM dd,yyyy hh:ii',
                          language: 'en',
                          pickTime: false,
                          pick12HourFormat: true,
                          startDate: start,
                          endDate: new Date(new Date().setDate(todayDate + max_days))

                        }).on('changeDate', function() {
                          // set the "fromDate" end to not be later than "toDate" starts:

                          $(this).datetimepicker('hide');
                        });
                        var date7 = $('.datetimepicker3').datetimepicker('getDate', '+89d');
                        date7.setDate(date7.getDate() + 89);

                        $('.datetimepicker3').datetimepicker('setDate', date7);

                        $('.datetimepicker3').datetimepicker('setDate', start);
                        $('.datetimepicker3').datetimepicker('setDate', start);

                      <?php } ?>


                      $('.datetimepicker4').datetimepicker({
                        format: 'MM dd,yyyy hh:ii',
                        language: 'en',
                        pickTime: false,
                        pick12HourFormat: true,
                        startDate: start,
                        endDate: end,
                      }).on('changeDate', function(e) {
                        // Get the selected date from datetimepicker4
                        let selectedDate = e.date;

                        // Set the minimum date for datetimepicker5
                        $('.datetimepicker5').datetimepicker('setStartDate', selectedDate);

                        // Hide the picker after selection
                        $(this).datetimepicker('hide');
                      });

                      $('.datetimepicker5').datetimepicker({
                        format: 'MM dd,yyyy hh:ii',
                        language: 'en',
                        pickTime: false,
                        pick12HourFormat: true,
                        startDate: start,
                        endDate: end,
                      }).on('changeDate', function() {
                        // Hide the picker after selection
                        $(this).datetimepicker('hide');
                      });


                    });
                  </script>

                </div>
              </div>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label" style="color: #078fe8;"><u>Venue Type : </u></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('venue_type', array('class' => 'form-control', 'placeholder' => 'Eg:Home,Garden,stadium,Auditorium,Concern Hall,Runway.', 'id' => '', 'label' => false, 'type' => 'text')); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Location:<span class="jobpostrequired">*</span></label>
            <div class="col-sm-10 location">

              <input id="pac-input" type="text" required class="form-control" placeholder="Location" name="location" value="<?php echo $requirement['location']; ?>">

              <?php echo $this->Form->input('latitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false)); ?>
              <?php echo $this->Form->input('longitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false)); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Landmark:</label>
            <div class="col-sm-10"> <?php echo $this->Form->input('landmark', array('class' => 'form-control', 'placeholder' => 'Landmark', 'id' => 'name', 'label' => false)); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Venue Address:</label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('venue_address', array('class' => 'form-control', 'placeholder' => 'Venue Address', 'id' => 'name', 'label' => false)); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Address :</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-sm-4">
                  <?php echo $this->Form->input('country_id', array('class' => 'form-control', 'placeholder' => 'Country', 'id' => 'country_ids', 'default' => '101', 'label' => false, 'empty' => '--Select Country--', 'options' => $country)); ?>
                </div>
                <div class="col-sm-4">

                  <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', 'label' => false, 'empty' => '--Select State--', 'options' => $states)); ?>
                </div>
                <div class="col-sm-4">
                  <?php echo $this->Form->input('city_id', array('class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'label' => false, 'empty' => '--Select City--', 'options' => $cities)); ?>
                </div>
              </div>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Venue Description:</label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('venue_description', array('class' => 'form-control', 'placeholder' => 'Describe the Venue, Location of the event, job in details', 'id' => 'name', 'label' => false, 'type' => 'textarea')); ?>
            </div>
            <!-- <div class="col-sm-1"></div> -->
          </div>

          <div id="map"></div>

          <style>
            /* Always set the map height explicitly to define the size of the div  * element that contains the map. */
            #map {
              height: 40%;
            }

            /* Optional: Makes the sample page fill the window. */
            html,
            body {
              height: 100%;
              margin: 0;
              padding: 0;
            }

            #description {
              font-family: Roboto;
              font-size: 15px;
              font-weight: 300;
            }

            #infowindow-content .title {
              font-weight: bold;
            }

            #infowindow-content {
              display: none;
            }

            #map #infowindow-content {
              display: inline;
            }

            .pac-card {
              margin: 10px 10px 0 0;
              border-radius: 2px 0 0 2px;
              box-sizing: border-box;
              -moz-box-sizing: border-box;
              outline: none;
              box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
              background-color: #fff;
              font-family: Roboto;
            }

            #pac-container {
              padding-bottom: 12px;
              margin-right: 12px;
            }

            .pac-controls {
              display: inline-block;
              padding: 5px 11px;
            }

            .pac-controls label {
              font-family: Roboto;
              font-size: 13px;
              font-weight: 300;
            }

            #pac-input:focus {
              border-color: #4d90fe;
            }

            #title {
              color: #fff;
              background-color: #4d90fe;
              font-size: 25px;
              font-weight: 500;
              padding: 6px 12px;
            }

            #target {
              width: 345px;
            }
          </style>

          <div class="form-group">
            <div class="col-sm-12 ">
              <div class="checkbox">
                <label>
                  <?php if ($requirement_data['jobquestion']) { ?>
                    <input type="checkbox" id="checkbox1" checked>
                  <?php } else { ?>
                    <input type="checkbox" id="checkbox1">
                  <?php } ?>
                  I would like to ask some specific questions by a questionnaire.
                </label>
              </div>
            </div>
          </div>

          <?php if ($requirement_data['jobquestion']) { ?>
            <div id="autoUpdate" style="display: block;">
            <?php } else { ?>
              <div id="autoUpdate" style="display: none;">
              <?php  } ?>

              <div class="form-group">
                <label for="" class="col-sm-12 control-label">Questionnare:</label>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <div class="multi-field-wrapperdesc">

                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 30%;">Question</th>
                            <th style="width: 10%;">Option Type</th>
                            <th style="width: 10px;">Option 1</th>
                            <th style="width: 10px;">Option 2</th>
                            <th style="width: 10px;">Option 3</th>
                            <th style="width: 10px;">Option 4</th>

                          </tr>
                        </thead>

                        <tbody class="payment_containerdesc">

                          <?php $count = 0;
                          foreach ($requirement_data['jobquestion'] as $valuequestion) {  //pr($valuequestion);
                          ?>
                            <tr class="payment_detailsdesc">

                              <td><?php echo $this->Form->input('question', array('class' => 'form-control', 'placeholder' => 'Question', 'id' => 'myField', 'label' => false, 'name' => 'questions[name][]', 'value' => $valuequestion['question_title'])); ?></td>


                              <td><?php echo $this->Form->input('optiontypeone', array('class' => 'form-control', 'id' => 'gender', 'type' => 'select', 'options' => $questionnare, 'label' => false, 'legend' => false, 'name' => 'questions[optiontype][]', 'empty' => 'Type', 'value' => $valuequestion['option_type'])); ?> </td>
                              <?php $i = 0;
                              foreach ($valuequestion['jobanswer'] as $valueoption) { ?>

                                <td><?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][' . $i . '][]', 'value' => $valueoption['answervalue'])); ?></td>
                              <?php $i++;
                              } ?>

                              <?php
                              $answercount = 4 - count($valuequestion['jobanswer']);
                              ?>
                              <?php for ($i = 0; $i < $answercount; $i++) { ?>
                                <td><?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][' . $i . '][]')); ?></td>
                              <?php } ?>
                            <?php } ?>

                            </tr>
                            <?php
                            $questioncount = 8 - count($requirement_data['jobquestion']);
                            ?>
                            <?php for ($i = 0; $i < $questioncount; $i++) { ?>
                              <tr class="payment_detailsdesc">



                                <td><?php echo $this->Form->input('question', array('class' => 'form-control', 'placeholder' => 'Question', 'id' => 'myField', 'label' => false, 'name' => 'questions[name][]')); ?></td>


                                <td><?php echo $this->Form->input('optiontypeone', array('class' => 'form-control', 'id' => 'gender', 'type' => 'select', 'options' => $questionnare, 'label' => false, 'legend' => false, 'name' => 'questions[optiontype][]', 'empty' => 'Type')); ?> </td>

                                <td><?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][0][]')); ?></td>

                                <td><?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][1][]')); ?></td>


                                <td> <?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][2][]')); ?></td>


                                <td> <?php echo $this->Form->input('answer', array('class' => 'form-control', 'placeholder' => 'Option', 'id' => 'name', 'label' => false, 'name' => 'questions[answer][3][]')); ?></td>

                              </tr>
                            <?php } ?>

                        </tbody>
                      </table>
                    </div>

                  </div>

                </div>
              </div>

              </div>

              <div class="form-group">
                <div class="col-sm-12 text-center m-top-20">
                  <button type="submit" class="btn btn-default">Submit</button>
                </div>
              </div>

              </form>

            </div>

    </div>


</section>

<!-- Skill choose -->
<script>
  $(document).ready(function() {
    $('#room-1').hide();
    $('.rooms').change(function() {
      const skill = $(this).data('val');
      const sanitizedSkill = skill.replace(/\s+/g, '_');
      const isChecked = $(this).is(':checked');
      const container = $('.video_container');

      if (isChecked) {
        const clone = $('#room-1').clone();
        clone.attr('id', `room_${sanitizedSkill}`);
        clone.find('#requirementskills').val(skill);

        // Add required to all inputs and selects
        // clone.find('input, select').attr('required', true);

        clone.show();
        clone.appendTo(container);
      } else {
        $(`#room_${sanitizedSkill}`).remove();
      }

      if ($('.rooms:checked').length > 0) {
        $("#ncpy").show();
      } else {
        $("#ncpy").hide();
      }
    });
  });

  // Handle form submission
  $('form').submit(function(event) {
    $('#room-1').remove();
  });



  // $(document).ready(function() {
  //   // On change of rooms checkbox
  //   $('.rooms').change(function() {
  //     const checkedSkills = $('input:checkbox[class=rooms]:checked').length;
  //     const skills = $(this).data('val');

  //     // console.log('>>>>>>>>>>checkedSkills', checkedSkills);
  //     // console.log('>>>>>>>>>>skills', skills);


  //     manageRooms(checkedSkills, skills); // Call the reusable function to manage rooms
  //   });

  //   // Function to manage room display and actions
  //   function manageRooms(checkedSkills, skills) {
  //     const roomsDisplayed = $('[id^="room-"]:visible').length;
  //     const roomsRendered = $('[id^="room-"]').length;

  //     // Hide or remove rooms when no checkbox is selected
  //     if (checkedSkills === 0) {
  //       $('[id^="room-"]').hide(); // Hide all rooms
  //       $(".video_details#room-1 td:first-child input").val(''); // Clear first room input
  //       $("#ncpy").hide(); // Hide additional controls
  //       return;
  //     }

  //     $("#ncpy").show(); // Show additional controls

  //     // Show or add rooms based on checked skills
  //     for (let i = 1; i <= checkedSkills; i++) {
  //       let room = $(`#room-${i}`);
  //       if (room.length === 0) {
  //         // Clone and append a new room if it doesn't exist
  //         const clone = $('#room-1').clone();
  //         clone.find('input, select').val(''); // Clear input values
  //         setNewID(clone, i);
  //         clone.insertAfter($(`#room-${roomsRendered}`));
  //       } else {
  //         room.show(); // Show the room if hidden
  //       }

  //       // Set skills value if empty
  //       const roomInput = $(`.video_details#room-${i} td:first-child input`);
  //       if (!roomInput.val()) {
  //         roomInput.val(skills);
  //       }
  //     }

  //     // Hide or remove excess rooms
  //     for (let i = checkedSkills + 1; i <= roomsRendered; i++) {
  //       const room = $(`#room-${i}`);
  //       if (i === 1) {
  //         room.hide();
  //       } else {
  //         room.remove();
  //       }
  //     }

  //     $('#event-to-date').prop('disabled', checkedSkills === 0); // Enable or disable event-to-date input
  //   }

  //   // Helper function to set new IDs for cloned elements
  //   function setNewID(elem, i) {
  //     const oldID = elem.attr('id');
  //     const newID = oldID.replace(/\d+$/, i); // Replace the numeric suffix
  //     elem.attr('id', newID);
  //   }
  // });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#checkbox1').change(function() {
      if (!this.checked)
        $('#autoUpdate').hide();
      else
        $('#autoUpdate').show();
    });
  });

  $('#myField').keyup(function() {
    var txtVal = this.value;
    $("#output").text(txtVal);
  });

  $(document).ready(function() {

    setTimeout(() => {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/jobpost/getStates',
        data: 'id=101',
        cache: false,
        success: function(html) {
          $.each(html, function(key, value) {
            $('<option>').val(key).text(value).appendTo($("#state"));
          });
        }
      });
    }, 1000);



    $("#country_ids").on('change', function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/jobpost/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#state"));
            });
          }
        });
      }
    });

    $("#state").on('change', function() {
      var id = $(this).val();
      $("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/jobpost/getcities',
          data: dataString,
          cache: false,
          success: function(html) {
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          }
        });
      }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var allowed_skills = '<?php echo $this->request->session()->read('eligible.job_skills'); ?>';
    //alert();
    $('.multiselect-ui').multiselect({
      onChange: function(option, checked) {
        // Get selected options.
        var selectedOptions = $('.multiselect-ui option:selected');
        var le = selectedOptions.length;

        if (selectedOptions.length >= allowed_skills) {
          // Disable all other checkboxes.
          var nonSelectedOptions = $('.multiselect-ui option').filter(function() {
            return !$(this).is(':selected');
          });

          nonSelectedOptions.each(function() { //alert('test');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', true);
            input.parent('li').addClass('disabled');
          });
        } else {
          // Enable all checkboxes.
          $('.multiselect-ui option').each(function() { //alert('testing');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', false);
            input.parent('li').addClass('disabled');
          });
        }
      }
    });
  });
</script>


<script type="text/javascript">
  function fileValidation() {

    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    //alert(allowedExtensions);
    if (!allowedExtensions.exec(filePath)) {
      $("#ncpyss").css("display", "block");
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
</script>

<script src="<?php echo SITE_URL; ?>/js/jquery.imgareaselect.js"></script>

<script src="<?php echo SITE_URL; ?>/js/jquery.awesome-cropper.js"></script>

<script>
  $(document).ready(function() {
    $('#sample_input').awesomeCropper({
      width: 150,
      height: 150,
      debug: true
    });
  });
</script>

<style>
  input[data-readonly] {
    pointer-events: none;
  }
</style>

<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#profile_picture').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Function to validate file extension
  function fileValidation() {
    var fileInput = document.getElementById('my-file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if (!allowedExtensions.exec(filePath)) {
      $('#ncpyss').show();
      fileInput.value = '';
      $('#profile_picture').attr('src', '<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg');
      return false;
    } else {
      $('#ncpyss').hide();
    }
  }
</script>

<!-- image show js use -->
<!-- <script>
  const fileInput = document.querySelector('input[type="file"]');
const preview = document.querySelector("img.preview");
const eventLog = document.querySelector(".event-log-contents");
const reader = new FileReader();

function handleEvent(event) {
  eventLog.textContent += `${event.type}: ${event.loaded} bytes transferred\n`;

  if (event.type === "load") {
    preview.src = reader.result;
  }
}

function addListeners(reader) {
  reader.addEventListener("loadstart", handleEvent);
  reader.addEventListener("load", handleEvent);
  reader.addEventListener("loadend", handleEvent);
  reader.addEventListener("progress", handleEvent);
  reader.addEventListener("error", handleEvent);
  reader.addEventListener("abort", handleEvent);
}

function handleSelected(e) {
  eventLog.textContent = "";
  const selectedFile = fileInput.files[0];
  if (selectedFile) {
    addListeners(reader);
    reader.readAsDataURL(selectedFile);
  }
}

fileInput.addEventListener("change", handleSelected);
</script> -->
<!-- job profile image script -->