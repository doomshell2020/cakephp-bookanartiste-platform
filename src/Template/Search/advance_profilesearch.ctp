<?php
$session = $this->request->session();
// $session->delete('testtttt');
//pr($_SESSION); die; 
?>

<script type="text/javascript">
  function initMap() {
    var uluru = {
      lat: 26.9620727,
      lng: 75.7816225
    };
    var map = new google.maps.Map(document.getElementById('map'), {
      center: uluru,
      zoom: 15
    });
    var card = document.getElementById('pac-card');
    var input = document.getElementById('pac-input');
    var types = document.getElementById('type-selector');
    var strictBounds = document.getElementById('strict-bounds-selector');

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input);

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
      position: uluru,
      map: map,
      anchorPoint: new google.maps.Point(0, -29)

    });
    autocomplete.addListener('place_changed', function() {
      infowindow.open();
      marker.setVisible(false);
      var place = autocomplete.getPlace();
      changelatlong(place.geometry.location);
      // alert(place);
      if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17); // Why 17? Because it looks good.
      }
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);

      var address = '';
      if (place.address_components) {
        address = [
          (place.address_components[0] && place.address_components[0].short_name || ''),
          (place.address_components[1] && place.address_components[1].short_name || ''),
          (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
      }

      infowindowContent.children['place-icon'].src = place.icon;
      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-address'].textContent = address;
      infowindow.open(map, marker);
    });

    function changelatlong(location) {
      latitude = location.lat();
      longitude = location.lng();
      if (document.getElementById('latitude') != undefined) {
        document.getElementById('latitude').value = latitude;
      }
      if (document.getElementById('longitude') != undefined) {
        document.getElementById('longitude').value = longitude;
      }
    }


    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    function setupClickListener(id, types) {
      var radioButton = document.getElementById(id);
      radioButton.addEventListener('click', function() {
        autocomplete.setTypes(types);
      });
    }

    setupClickListener('changetype-all', []);
    setupClickListener('changetype-address', ['address']);
    setupClickListener('changetype-establishment', ['establishment']);
    setupClickListener('changetype-geocode', ['geocode']);

    document.getElementById('use-strict-bounds')
      .addEventListener('click', function() {
        console.log('Checkbox clicked! New state=' + this.checked);
        autocomplete.setOptions({
          strictBounds: this.checked
        });
      });
  }
</script>

<?php
$skillArra = explode(",", $_SESSION['advanceprofiesearchdata']['skill']);
?>


<section id="page_adv-srch">
  <div class="container">
    <h2>Advance <span>Profile Search</span></h2>
    <p class="m-bott-50">Here You Can Search Advance Profile </p>
  </div>

  <div class="">
    <div class="container">
      <div class="adv_srch_bx">

        <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'search', 'action' => 'profilesearch'), 'type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Talent Name</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="name" placeholder="Talent Name" value="<?php if ($edit == 1) {
                                                                                                    echo $_SESSION['advanceprofiesearchdata']['name'];
                                                                                                  } ?>">
          </div>

        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Profile Title</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="profiletitle" placeholder="Profile Title" value="<?php if ($edit == 1) {
                                                                                                              echo $_SESSION['advanceprofiesearchdata']['profiletitle'];
                                                                                                            } ?>">
          </div>

        </div>



        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Word Search</label>
          <?php
          $wordSearch = $edit == 1 ? ($_SESSION['advanceprofiesearchdata']['wordsearch'] ?? '') : '';
          $contain = $edit == 1 ? ($_SESSION['advanceprofiesearchdata']['contain'] ?? 'c') : 'c'; // default to 'c'
          ?>

          <div class="col-sm-9">
            <input type="text" class="form-control" name="wordsearch" placeholder="Write multiple words separated by comma" value="<?= htmlspecialchars($wordSearch) ?>">

            <input type="radio" value="c" name="contain" <?= $contain == 'c' ? 'checked' : '' ?> /> Contains any of the words
            <input type="radio" value="a" name="contain" <?= $contain == 'a' ? 'checked' : '' ?> /> Contains all the words
            <input type="radio" value="n" name="contain" <?= $contain == 'n' ? 'checked' : '' ?> /> Does not contain any of the words
          </div>

        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Talent Type</label>
          <div class="col-sm-7">
            <?php
            echo $this->Form->input('skillshow', [
              'class' => 'longinput form-control',
              'maxlength' => '20',
              'placeholder' => 'Skills',
              'readonly' => 'readonly',
              'label' => false,
              'value' => htmlspecialchars($_SESSION['advanceprofiesearchdata']['skillshow'] ?? '')
            ]);

            $skillValue = ($edit == 1 && !empty($_SESSION['advanceprofiesearchdata']['skill']))
              ? $_SESSION['advanceprofiesearchdata']['skill']
              : implode(",", $array);
            ?>

            <input type="hidden" name="skill" id="skill" value="<?= htmlspecialchars($skillValue); ?>" />
          </div>

          <div class="col-sm-2">
            <?php $uid = null; ?>
            <!-- <a  data-toggle="modal" class='skill btn btn-success ' href="<?php echo SITE_URL ?>/search/profileskill/<?php echo $uid; ?>" id="skills">Choose Talent</a> -->
            <a type="button" class="skill btn btn-success " data-toggle="modal" data-target="#totrequirement">Choose Talent</a>
          </div>
        </div>
        <div class="form-group radio_width">
          <label for="" class="col-sm-3 control-label">Gender</label>
          <div class="col-sm-7">
            <div class="payment_radio_bg">
              <ul>
                <?php
                function isGenderChecked($value, $edit, $genderData)
                {
                  return $edit == 1 && in_array($value, $genderData) ? 'checked' : '';
                }

                $genderData = $_SESSION['advanceprofiesearchdata']['gender'] ?? [];
                ?>

                <li>
                  <input type="checkbox" name="gender[]" value="a" <?= isGenderChecked("a", $edit, $genderData) ?>> <label>Any</label>
                </li>
                <li>
                  <input type="checkbox" name="gender[]" value="m" <?= isGenderChecked("m", $edit, $genderData) ?>> <label>Male</label>
                </li>
                <li>
                  <input type="checkbox" name="gender[]" value="f" <?= isGenderChecked("f", $edit, $genderData) ?>> <label>Female</label>
                </li>
                <li>
                  <input type="checkbox" name="gender[]" value="o" <?= isGenderChecked("o", $edit, $genderData) ?>> <label>Other</label>
                </li>
                <!--
                <li>
                    <input type="checkbox" name="gender[]" value="bmf" <?= isGenderChecked("bmf", $edit, $genderData) ?>> <label>Both Male and Female</label>
                </li>
                -->


              </ul>
            </div>
          </div>
        </div>

        <div class="form-group">

          <label for="" class="col-sm-3 control-label">Position Name </label>
          <div class="col-sm-7">
            <input type="text" placeholder="Position Name " class="form-control" name="positionname" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                              echo $_SESSION['advanceprofiesearchdata']['positionname'];
                                                                                                            } ?>">
          </div>

          <input type="hidden" value="1" name="form" />
        </div>
        <?php if ($edit == 1) { ?>
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Place</label>


            <div class="col-sm-9 location">
              <div class="row">
                <div class="col-sm-4">

                  <?php $states = $this->Comman->editstate($_SESSION['advanceprofiesearchdata']['country_id']) ?>
                  <select name="country_id" class="form-control" placeholder="Country" id="country_ids">
                    <option value>Select Country</option><?php foreach ($country as $key => $value) { ?><option value="<?php echo $key ?>" <?php if ($key == $_SESSION['advanceprofiesearchdata']['country_id']) {
                                                                                                                                              echo "selected";
                                                                                                                                            } ?>><?php echo $value ?></option> <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <select name="state_id" class="form-control" placeholder="State" id="state"=""="">
                    <?php foreach ($states as $key => $value) { ?>
                      <option value="<?php echo $key ?>" <?php if ($key == $_SESSION['advanceprofiesearchdata']['state_id']) {
                                                            echo "selected";
                                                          } ?>><?php echo $value ?> </option> <?php } ?>

                  </select>
                </div>
                <div class="col-sm-4">

                  <select name="city_id[]" class="form-control" placeholder="City" id="city" multiple="">

                    <?php for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['city_id']); $i++) {

                      $citydata = $this->Comman->city($_SESSION['advanceprofiesearchdata']['city_id'][$i]); ?>
                      <option value="<?php echo  $citydata['id']; ?>" selected><?php echo  $citydata['name']; ?></option>

                    <?php          } ?>

                  </select>
                </div>
              </div>


            </div>
          </div>
        <?php } else { ?>
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Place</label>
            <div class="col-sm-9 location">
              <div class="row">
                <div class="col-sm-4">
                  <?php echo $this->Form->input('country_id', array('class' => 'form-control', 'placeholder' => 'Country', 'id' => 'country_ids', 'label' => false, 'empty' => '--Select Country--', 'options' => $country)); ?>
                </div>
                <div class="col-sm-4">
                  <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', '', 'label' => false, 'empty' => '--Select State--')); ?>
                </div>
                <div class="col-sm-4">

                  <select name="city_id[]" class="form-control" placeholder="City" id="city"=""="">
                    <option value="">--Select City--</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Location of Origin</label>
          <div class="col-sm-9 location">

            <input id="pac-input" type="text" class="form-control" placeholder="Location of Origin" name="location" value="<?php if ($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">


            <?php if ($edit == 1) { ?>
              <?php echo $this->Form->input('latitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false, 'value' => $_SESSION['advanceprofiesearchdata']['latitude'])); ?>
              <?php echo $this->Form->input('longitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false, 'value' => $_SESSION['advanceprofiesearchdata']['longitude'])); ?>
            <?php  } else { ?>
              <?php echo $this->Form->input('latitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false)); ?>
              <?php echo $this->Form->input('longitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false)); ?>
            <?php  } ?>
          </div>

          <div id="map"></div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">With In</label>
          <div class="col-sm-3">
            <input type="number" class="form-control" name="within" value="<?php if ($_SESSION['advanceprofiesearchdata']['within']) {
                                                                              echo $_SESSION['advanceprofiesearchdata']['within'];
                                                                            } ?>">
          </div>
          <div class="col-sm-6">
            <select class="form-control" name="unit">
              <option>Select With in</option>
              <option selected="selected" value="km" <?php if ($_SESSION['advanceprofiesearchdata']['unit'] == "km") {
                                                        echo "selected";
                                                      } ?>>kms</option>
              <option value="mi" <?php if ($_SESSION['advanceprofiesearchdata']['unit'] == "mi") {
                                    echo "selected";
                                  } ?>>Miles</option>
            </select>
          </div>
        </div>




        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Current Location</label>
          <div class="col-sm-9 location">

            <input id="pac"
              type="text"
              class="form-control"
              placeholder="Location"
              name="clocation"
              value="<?php if ($_SESSION['advanceprofiesearchdata']['clocation']) {
                        echo $_SESSION['advanceprofiesearchdata']['clocation'];
                      } ?>">

          </div>

          <?php echo $this->Form->input('clatitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'clatitude', 'label' => false)); ?>
          <?php echo $this->Form->input('clongitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'clongitude', 'label' => false)); ?>
        </div>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">With In</label>
          <div class="col-sm-3">
            <input type="number" class="form-control" name="cwithin" value="<?php if ($edit == 1) {
                                                                              if ($_SESSION['advanceprofiesearchdata']['cwithin']) {
                                                                                echo $_SESSION['advanceprofiesearchdata']['cwithin'];
                                                                              }
                                                                            } ?>">
          </div>
          <div class="col-sm-6">
            <select class="form-control" name="currentlocunit">
              <option>Select With in</option>
              <option selected="selected" value="km" <?php if ($_SESSION['advanceprofiesearchdata']['currentlocunit'] == "km") {
                                                        echo "selected";
                                                      } ?>>kms</option>
              <option value="mi" <?php if ($_SESSION['advanceprofiesearchdata']['currentlocunit'] == "mi") {
                                    echo "selected";
                                  } ?>>Miles</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Currently Working</label>
          <div class="col-sm-9 location">

            <input type="text" class="form-control" placeholder="Currently Working" name="currentlyworking" value="<?php if ($_SESSION['advanceprofiesearchdata']) {
                                                                                                                      echo $_SESSION['advanceprofiesearchdata']['currentlyworking'];
                                                                                                                    } ?>">



          </div>


        </div>



        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Year of Experience</label>
          <div class="col-sm-9">
            <select class="form-control" name="experyear">
              <option value="0">Select Year</option>

              <option value="0,5" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "0,5") {
                                    echo "selected";
                                  } ?>> 0 to 5 Years </option>
              <option value="5,10" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "5,10") {
                                      echo "selected";
                                    } ?>> 5 to 10 Years </option>
              <option value="10,15" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "10,15") {
                                      echo "selected";
                                    } ?>> 10 to 15 Years </option>
              <option value="15,20" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "15,20") {
                                      echo "selected";
                                    } ?>> 15 to 20 Years </option>
              <option value="20,25" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "20,25") {
                                      echo "selected";
                                    } ?>> 20 to 25 Years </option>
              <option value="25" <?php if ($_SESSION['advanceprofiesearchdata']['experyear'] == "25") {
                                    echo "selected";
                                  } ?>> More than 25 Years </option>


            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Active in</label>
          <div class="col-sm-9">
            <select class="form-control" name="active">
              <option value="0" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "0") {
                                  echo "selected";
                                } ?>>Select Active in</option>
              <option value="1" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "1") {
                                  echo "selected";
                                } ?>> Last 15 days </option>
              <option value="2" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "2") {
                                  echo "selected";
                                } ?>> Last 30 days </option>
              <option value="3" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "3") {
                                  echo "selected";
                                } ?>> Last 45 days </option>
              <option value="4" selected="selected" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "4") {
                                                      echo "selected";
                                                    } ?>> Last 60 days </option>
              <option value="5" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "5") {
                                  echo "selected";
                                } ?>> Last 3 Months </option>
              <option value="6" <?php if ($_SESSION['advanceprofiesearchdata']['active'] == "6") {
                                  echo "selected";
                                } ?>> Last 6 Months </option>
            </select>
          </div>
        </div>


        <div class="form-group">
          <div class="col-sm-12 text-center m-top-20">
            <button type="submit" class="btn btn-default">Search</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
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

            $('#city').attr('multiple', 'multiple');
            $('#city').css('height', '10%');
          }
        });
      }
    });
  });
</script>




<!-- Modal -->

<!-- <div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content" >
       <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
         <div class="modal-body" id="skillsetsearch"></div>
      </div> 
    
   </div>


</div> -->
<!-- /.modal -->

<!-- <script>
 $('.skill').click(function(e){

 e.preventDefault();
 $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script> -->

<script>
  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  function initMaplocation() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: -33.8688,
        lng: 151.2195
      },
      zoom: 13
    });
    var card = document.getElementById('pac-card');
    var input = document.getElementById('pac');
    var types = document.getElementById('type-selector');
    var strictBounds = document.getElementById('strict-bounds-selector');

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input);

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo('bounds', map);

    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
      ['address_components', 'geometry', 'icon', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
      infowindow.close();
      marker.setVisible(false);

      var place = autocomplete.getPlace();
      changecurrentlatlong(place.geometry.location);
      if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17); // Why 17? Because it looks good.
      }
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);

      var address = '';
      if (place.address_components) {
        address = [
          (place.address_components[0] && place.address_components[0].short_name || ''),
          (place.address_components[1] && place.address_components[1].short_name || ''),
          (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
      }

      infowindowContent.children['place-icon'].src = place.icon;
      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-address'].textContent = address;
      infowindow.open(map, marker);
    });

    function changecurrentlatlong(location) {
      console.log("it is calling");
      latitude = location.lat();
      longitude = location.lng();
      if (document.getElementById('clatitude') != undefined) {
        document.getElementById('clatitude').value = latitude;
      }
      if (document.getElementById('clongitude') != undefined) {
        document.getElementById('clongitude').value = longitude;
      }
    }


  }

  $("#skillshow").click(function() {
    //alert("T");
    $("#skills").trigger("click");
  });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI&libraries=places&callback=initMaplocation" async defer>

</script>


<!-- new code choose talent -->
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
          <?php foreach ($Skill as $i => $skill):
            $skillId = (int)$skill['id'];
            $skillName = htmlspecialchars($skill['name']);
            $isChecked = in_array($skillId, $skillArra) ? 'checked' : '';
          ?>
            <li>
              <label for="skill<?= $i; ?>">
                <input type="checkbox"
                  name="requirement"
                  value="<?= $skillId; ?>"
                  onclick="addskill(this)"
                  class="rooms"
                  id="skill<?= $i; ?>"
                  data-skill-type="<?= $skillName; ?>"
                  data-val="<?= $skillName; ?>"
                  <?= $isChecked; ?> />
                <?= $skillName; ?>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>


      </div>

    </div>

  </div>
</div>

<?php $sitesettings = $this->Comman->sitesettings();    ?>
<script>
  function addskill(ele) {
    var total_elegible_skillsddd = '<?php echo $this->request->session()->read('eligible.job_skills'); ?>';
    // alert(total_elegible_skillsddd); 
    if (total_elegible_skillsddd > 0) {
      var total_elegible_skills = '<?php echo $this->request->session()->read('eligible.job_skills'); ?>';
    } else {
      var total_elegible_skillsddd = '<?php echo $sitesettings['number_of_talent_free_jobpost']; ?>';
      if (total_elegible_skillsddd) {
        var total_elegible_skills = '<?php echo $sitesettings['number_of_talent_free_jobpost']; ?>';
      } else {
        var total_elegible_skills = 1;
      }
    }
    var fruits = [];
    var other = [];
    var ckName = document.getElementsByName(ele.name);
    var checked = document.getElementById(ele.id);
    $("input:checkbox[class=rooms]").each(function() {
      if ($(this).is(":checked")) {
        var checkedskills = $('input:checkbox[class=rooms]:checked').length;
        if (checkedskills > total_elegible_skills) {
          skill_error = "You can only add " + total_elegible_skills + " Skills in your Job. To increase this limit please upgrade your Profile Package";
          $("#skill_error").html(skill_error);
          $("#error_message").removeClass("hide");
          // $(checked).removeAttr('checked');
          checked.checked = false;

        }
        for (var i = 0; checkedskills > total_elegible_skills; i++) {
          if (!ckName[i].checked) {
            ckName[i].disabled = true;

          } else {
            ckName[i].disabled = false;

          }
        }
        fruits.push($(this).val());
        other.push(' ' + $(this).attr("data-skill-type"));
      } else {
        for (var i = 0; i < ckName.length; i++) {
          ckName[i].disabled = false;
        }
      }

    });


    $('#skill').val(fruits);
    $('#skillshow').val(other);
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
<!-- end code -->