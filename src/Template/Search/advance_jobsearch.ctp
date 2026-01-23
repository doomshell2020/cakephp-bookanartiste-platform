<style type="text/css">
  .payment_radio_bgpay li {
    border-bottom: 1px solid #ccc;
  }

  .payment_radio_bgpay li:last-child {
    border-bottom: none;
  }
</style>
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

<script type="text/javascript">
  $(function() {
    var today = new Date();
    var start = new Date();
    // set end date to max one year period:
    var end = new Date(new Date().setYear(start.getFullYear() + 1));
    $('.datetimepicker3').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      startDate: start,
      endDate: end
      // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function() {
      // set the "toDate" start to not be later than "fromDate" ends:

      $('.datetimepicker4').datetimepicker('setStartDate', new Date($(this).val()));
      $('.datetimepicker1').datetimepicker('setStartDate', new Date($(this).val()));

      $(this).datetimepicker('hide');


      //$('.datetimepicker4').defaultValue(lastapplicationform);
    });

    $('.datetimepicker4').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      startDate: start,
      endDate: end
      // update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function() {
      // set the "fromDate" end to not be later than "toDate" starts:
      $('.datetimepicker3').datetimepicker('setEndDate', new Date($(this).val()));
      $('.datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));
      $(this).datetimepicker('hide');


    });



    var start1 = new Date();
    // set end date to max one year period:
    var end1 = new Date(new Date().setYear(start1.getFullYear() + 1));
    $('.datetimepicker1').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      startDate: start1,
      endDate: end1
      // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function() {
      // set the "toDate" start to not be later than "fromDate" ends:

      $('.datetimepicker2').datetimepicker('setStartDate', new Date($(this).val()));
      $('.datetimepicker3').datetimepicker('setStartDate', new Date($(this).val()));
      $('.datetimepicker4').datetimepicker('setStartDate', new Date($(this).val()));

      $(this).datetimepicker('hide');


      //$('.datetimepicker4').defaultValue(lastapplicationform);
    });

    $('.datetimepicker2').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      startDate: start1,
      endDate: end1
      // update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function() {
      // set the "fromDate" end to not be later than "toDate" starts:
      $('.datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));
      $('.datetimepicker3').datetimepicker('setEndDate', new Date($(this).val()));
      $('.datetimepicker4').datetimepicker('setStartDate', new Date($(this).val()));
      $(this).datetimepicker('hide');


    });


    $('.datetimepicker5').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      language: 'en',
      pickTime: false,
      pick12HourFormat: true,
      startDate: today,
      endDate: 0,
    }).on('changeDate', function() {
      // set the "fromDate" end to not be later than "toDate" starts:
      $('.datetimepicker6').datetimepicker('setStartDate', new Date($(this).val()));
      $(this).datetimepicker('hide');


    });

    $('.datetimepicker6').datetimepicker({
      format: 'M dd,yyyy hh:mm',
      language: 'en',
      pickTime: false,
      pick12HourFormat: true,
      startDate: today,
      endDate: 0,
    }).on('changeDate', function() {
      // set the "fromDate" end to not be later than "toDate" starts:
      $('.datetimepicker5').datetimepicker('setEndDate', new Date($(this).val()));
      $(this).datetimepicker('hide');


    });




  });
</script>

<section id="page_adv-srch">
  <div class="container">
    <h2>Advance <span>Job Search</span></h2>
    <p class="m-bott-50">Here you can Search job(s) by filling one or more columns in the form below
    </p>
  </div>
  <div class="">
    <div class="container">
      <div class="adv_srch_bx">

        <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'search', 'action' => 'search'), 'type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Job / Event Name / Title</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="keyword" value="<?php if ($edit == 1) {
                                                                            echo $_SESSION['advancejobsearch']['keyword'];
                                                                          } ?>">
          </div>

        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Skill Type</label>
          <div class="col-sm-7">
            <?php
            echo $this->Form->input(
              'skillshow',
              array(
                'class' => 'longinput form-control totrequirement',
                'maxlength' => '20',
                'placeholder' => 'Skills',
                'readonly' => 'readonly',
                'label' => false,
                'value' => $_SESSION['advancejobsearch']['skillshow']
              )
            );
            ?>

            <?php if ($edit == 1) { ?>
              <input
                type="hidden" name="skill" id="skill" value="<?php if (!$_SESSION['advancejobsearch']['skill']) {
                                                                implode(",", $array);
                                                              } else {
                                                                echo $_SESSION['advancejobsearch']['skill'];
                                                              }  ?>" />

            <?php } else { ?>

              <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",", $array); ?>" />
            <?php } ?>
          </div>
          <div class="col-sm-2">
            <?php $uid = null; ?>
            <!-- <a  data-toggle="modal" class='skill btn btn-success ' href="<?php //echo SITE_URL 
                                                                              ?>/search/Skill/<?php //echo $uid; 
                                                                                              ?>" id="eventtype">Choose Skill type</a> -->
            <a type="button" class="skill btn btn-success" data-toggle="modal" data-target="#totrequirement">Choose Skill type</a>
          </div>
        </div>
        <div class="form-group radio_width">
          <label for="" class="col-sm-3 control-label">Gender</label>
          <div class="col-sm-7">
            <div class="payment_radio_bg">
              <ul>
                <li><input type="checkbox" checked="checked" name="gender[]" value="a" <?php if ($edit == 1) {
                                                                                          if (in_array("a", $_SESSION['advancejobsearch']['gender'])) {
                                                                                            echo "checked";
                                                                                          }
                                                                                        } ?>> <label>Any</label></li>
                <li><input type="checkbox" name="gender[]" value="m" <?php if ($edit == 1) {
                                                                        if (in_array("m", $_SESSION['advancejobsearch']['gender'])) {
                                                                          echo "checked";
                                                                        }
                                                                      } ?>> <label>Male</label></li>
                <li><input type="checkbox" name="gender[]" value="f" <?php if ($edit == 1) {
                                                                        if (in_array("f", $_SESSION['advancejobsearch']['gender'])) {
                                                                          echo "checked";
                                                                        }
                                                                      } ?>> <label>Female</label></li>
                <li><input type="checkbox" name="gender[]" value="o" <?php if ($edit == 1) {
                                                                        if (in_array("o", $_SESSION['advancejobsearch']['gender'])) {
                                                                          echo "checked";
                                                                        }
                                                                      } ?>> <label>Other</label></li>
                <!-- <li><input type="checkbox" name="gender[]" value="bmf" <?php if ($edit == 1) {
                                                                              if (in_array("bmf", $_SESSION['advancejobsearch']['gender'])) {
                                                                                echo "checked";
                                                                              }
                                                                            } ?>> <label>Both Male and Female</label></li> -->

              </ul>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Payment Offered Per</label>
          <div class="col-sm-9">
            <div class="payment_radio_bg payment_radio_bgpay">
              <ul>
                <?php foreach ($Paymentfequency as $value) { ?>
                  <li><input type="checkbox" name="Paymentfequency[]" value="<?php echo $value['id'] ?>" <?php if ($edit == 1) {
                                                                                                            if (in_array($value['id'], $_SESSION['advancejobsearch']['Paymentfequency'])) {
                                                                                                              echo "checked";
                                                                                                            }
                                                                                                          } ?>> <label>
                      <?php echo $value['name'] ?></label>
                  </li>

                <?php } ?>

              </ul>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label"> Event Type</label>
          <div class="col-sm-7">
            <?php echo $this->Form->input('eventshow', array('class' =>
            'longinput form-control', 'maxlength' => '20', 'placeholder' => 'Event type', 'readonly' => 'readonly', 'label' => false, 'value' => $_SESSION['advancejobsearch']['eventshow'])); ?>


            <?php if ($edit == 1) { ?>
              <input type="hidden" name="eventtype" id="event" value="<?php if (!$_SESSION['advancejobsearch']['eventtype']) {
                                                                        implode(",", $array);
                                                                      } else {
                                                                        echo $_SESSION['advancejobsearch']['eventtype'];
                                                                      }  ?>" />

            <?php } else { ?>

              <input type="hidden" name="eventtype" id="event" value="<?php echo  implode(",", $array); ?>" />
            <?php } ?>
          </div>
          <div class="col-sm-2">
            <?php $uid = null; ?>
            <!-- <a  data-toggle="modal" class='skill btn btn-success ' href="?php echo SITE_URL?>/search/eventtypes/?php echo $uid; ?>" id="eventtype">Choose Event type</a> -->
            <a type="button" class="skills btn btn-success pull-right" data-toggle="modal" data-target="#eventrequirement">Choose Event type</a>
          </div>
        </div>
        <?php if ($edit == 1) { ?>
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Place</label>


            <div class="col-sm-9 location">
              <div class="row">
                <div class="col-sm-4">


                  <select name="country_id" class="form-control" placeholder="Country" id="country_ids">
                    <option value>Select Country</option>
                    </optgroup><?php foreach ($country as $key => $value) { ?><option value="<?php echo $key ?>" <?php if ($key == $_SESSION['advancejobsearch']['country_id']) {
                                                                                                                    echo "selected";
                                                                                                                  } ?>><?php echo $value ?></option> <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <?php $states = $this->Comman->editstate($_SESSION['advancejobsearch']['country_id']) ?>

                  <select name="state_id" class="form-control" placeholder="State" id="state"=""="">
                    <option value>Select State</option>
                    <?php foreach ($states as $key => $value) { ?>
                      <option value="<?php echo $key ?>" <?php if ($key == $_SESSION['advancejobsearch']['state_id']) {
                                                            echo "selected";
                                                          } ?>><?php echo $value ?> </option> <?php } ?>

                  </select>
                </div>
                <div class="col-sm-4">
                  <?php $city = $this->Comman->editcity($_SESSION['advancejobsearch']['state_id']);

                  ?>
                  <select name="city_id[]" class="form-control" placeholder="City" id="city" <?php if ($_SESSION['advancejobsearch']['city_id']['0'] != "") { ?> multiple="" <?php } ?> style="height:10% ">
                    <option value>Select City</option>
                    <?php for ($i = 0; $i < count($city); $i++) {

                    ?>
                      <option value="<?php echo  $city[$i]['id']; ?>"><?php echo  $city[$i]['name']; ?></option>

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
                  <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', '', 'label' => false, 'empty' => '--Select State--', 'options' => $states)); ?>
                </div>
                <div class="col-sm-4">
                  <select name="city_id[]" class="form-control" placeholder="City" id="city">
                    <option value="">--Select City--</option>
                  </select>
                </div>
              </div>


            </div>
          </div>

        <?php } ?>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Location</label>
          <div class="col-sm-9 location">

            <input id="pac-input" type="text" class="form-control" placeholder="Location" name="locationlat" value="<?php echo $_SESSION['advancejobsearch']['locationlat']  ?>">

            <?php if ($edit == 1) { ?>
              <?php echo $this->Form->input('latitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false, 'value' => $_SESSION['advancejobsearch']['latitude'])); ?>
              <?php echo $this->Form->input('longitude', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false, 'value' => $_SESSION['advancejobsearch']['longitude'])); ?>
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
            <input type="number" class="form-control" name="within" value="<?php if ($edit == 1) {
                                                                              if ($_SESSION['advancejobsearch']['within']) {
                                                                                echo $_SESSION['advancejobsearch']['within'];
                                                                              }
                                                                            } ?>">
          </div>

          <div class="col-sm-6">
            <select class="form-control" name="unit">
              <option>Select With in</option>
              <option value="km" selected="selected" <?php if ($_SESSION['advancejobsearch']['unit'] == "km") {
                                                        echo "selected";
                                                      } ?>>kms</option>
              <option value="mi" <?php if ($_SESSION['advancejobsearch']['unit'] == "mi") {
                                    echo "selected";
                                  } ?>>Miles</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Posted By</label>
          <div class="col-sm-9">
            <select class="form-control" name="role_id">

              <option value="0">All</option>
              <option value="2" <?php if ($edit == 1) {
                                  if ($_SESSION['advancejobsearch']['role_id'] == 2) {
                                    echo "Selected";
                                  }
                                } ?>>Artists</option>
              <option value="3" <?php if ($edit == 1) {
                                  if ($_SESSION['advancejobsearch']['role_id'] == 1) {
                                    echo "Selected";
                                  }
                                } ?>>Non-Talent</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Posted By</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="Name" name="recname" value="<?php if ($edit == 1) {
                                                                                                echo $_SESSION['advancejobsearch']['recname'];
                                                                                              } ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Continuous Job <span>?</span></label>
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-12">
                <div class="job_radio_bg gender_radio_bg">
                  <ul>
                    <li><input type="radio" checked="checked" name="time" value="a" <?php if ($edit == 1) {
                                                                                      if ($_SESSION['advancejobsearch']['time'] == "a") echo "checked";
                                                                                    } ?> class="conti"> <label>All</label></li>
                    <li><input type="radio" name="time" value="Y" <?php if ($edit == 1) {
                                                                    if ($_SESSION['advancejobsearch']['time'] == "Y") echo "checked";
                                                                  } ?> class="conti"> <label>Yes</label></li>
                    <li><input type="radio" name="time" value="N" <?php if ($edit == 1) {
                                                                    if ($_SESSION['advancejobsearch']['time'] == "N") echo "checked";
                                                                  } ?> class="conti"> <label>No</label></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-6">

              </div>


            </div>

          </div>
        </div>

        <div class="form-group havehide" <?php if ($edit == 1) {
                                            if ($_SESSION['advancejobsearch']['time'] == "Y") { ?> style="display: none" <?php }
                                                                                                                      } ?>>
          <label for="" class="col-sm-3 control-label">Event Dates</label>
          <div class="col-sm-9">
            <div class="row">
              <label for="" class="col-sm-2 control-label">From</label>
              <div class="col-sm-4 date">
                <input type="text" class="form-control datetimepicker1" id="txtdate" placeholder="DD /MM / YYYY" name="event_from_date" readonly="" value="<?php if ($edit == 1) {
                                                                                                                                                              echo $_SESSION['advancejobsearch']['event_from_date'];
                                                                                                                                                            } ?>">
              </div>
              <label for="" class="col-sm-2 control-label">TO</label>
              <div class="col-sm-4 date">
                <input type="text" class="form-control datetimepicker2" id="txtdate2" placeholder="DD /MM / YYYY" name="event_to_date" readonly="" value="<?php if ($edit == 1) {
                                                                                                                                                            echo $_SESSION['advancejobsearch']['event_to_date'];
                                                                                                                                                          } ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group havehide" <?php if ($edit == 1) {
                                            if ($_SESSION['advancejobsearch']['time'] == "Y") { ?> style="display: none" <?php }
                                                                                                                      } ?>>
          <label for="" class="col-sm-3 control-label">Dates of Person(s) Required</label>
          <div class="col-sm-9">
            <div class="row">
              <label for="" class="col-sm-2 control-label">From</label>
              <div class="col-sm-4 date">
                <input type="text" class="form-control datetimepicker3" id="txtdate3" placeholder="DD /MM / YYYY" name="talent_required_fromdate" readonly="" value="<?php if ($edit == 1) {
                                                                                                                                                                        echo $_SESSION['advancejobsearch']['talent_required_fromdate'];
                                                                                                                                                                      } ?>">
              </div>
              <label for="" class="col-sm-2 control-label">TO</label>
              <div class="col-sm-4 date">
                <input type="text" class="form-control datetimepicker4" id="txtdate4" placeholder="DD /MM / YYYY" name="talent_required_todate" readonly="" value="<?php if ($edit == 1) {
                                                                                                                                                                      echo $_SESSION['advancejobsearch']['talent_required_todate'];
                                                                                                                                                                    } ?>">
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="from" value="1" />
        <div class="form-group">
          <label for="" class="col-sm-3 control-label">Last Date</label>

          <div class="col-sm-9">
            <div class="lastdate_checkbox_bg">
              <ul class="row list-unstyled ">
                <li class="col-sm-3 aftr_bx"> <label>After</label></li>
                <li class="col-sm-9"><input type="text" class="form-control datetimepicker5" id="txtdate5" placeholder="DD /MM / YYYY" name="last_date_app" value="<?php if ($edit == 1) {
                                                                                                                                                                      echo $_SESSION['advancejobsearch']['last_date_app'];
                                                                                                                                                                    } ?>"></li>
              </ul>
              <ul class="row list-unstyled ">
                <li class="col-sm-3 aftr_bx"> <label>Before</label></li>
                <li class="col-sm-9"><input type="text" class="form-control datetimepicker6" id="txtdate6" placeholder="DD /MM / YYYY" name="last_date_appbefore" value="<?php if ($edit == 1) {
                                                                                                                                                                            echo $_SESSION['advancejobsearch']['last_date_appbefore'];
                                                                                                                                                                          } ?>"></li>
              </ul>
            </div>
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
            $('#city').css('height', '20%');
          }
        });
      }
    });
  });
</script>




<!-- Modal -->

<!-- <div id="myModal" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
      <div class="modal-body" id="skillsetsearch"></div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div> -->
<!-- /.modal -->

<script>
  $('.skill').click(function(e) {

    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>
<script>
  $('.eventtype').click(function(e) {

    e.preventDefault();
    $('#myModalevent').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>


<div id="myModalevent" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
      <div class="modal-body" id="skillsetsearch"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>

<script type="text/javascript">
  $(document).ready(function() {

    $('.conti').change(function() {


      console.log($(this).val());
      if ($(this).val() == "Y") {
        $('.havehide').css("display", "none");
      } else {
        $('.havehide').css("display", "block");
      }

    });


    $("#skillshow").click(function() {
      //alert("T");
      $("#skillshow").val('');
      $("#skills").trigger("click");

    });


    $("#eventshow").click(function() {
      //alert("T");
      $("#eventshow").val('');
      $("#eventtype").trigger("click");

    });


  });
</script>
<script>


</script>
<!-- choose skill type write -->
<script>
  $('.skillsdata .totrequirement').click(function(e) {
    e.preventDefault();
    $('#totrequirement').modal('show');
  });

  $('.totrequirement').focus(function(e) {
    e.preventDefault();
    $('#totrequirement').modal('show');
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


            <li class="">

              <label class=""><input type="checkbox" name="requirement" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="rooms" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>" data-val="<?php echo $value['name'] ?>" <?php if (in_array($value['id'], $talentarray)) {
                                                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                                                      } ?> /><?php echo $value['name'] ?>
            </li>
            </label>
          <?php $i++;
          } ?>
        </ul>
      </div>

    </div>

  </div>
</div>

<?php $sitesettings = $this->Comman->sitesettings(); ?>

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
        var total_elegible_skills = '1';
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

<!-- choose event type -->
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
          <?php $i = 1;
          foreach ($eventtype as $value) { ?>


            <li class="">
              <label class=""><input type="checkbox" name="event_type" value="<?php echo $value['id'] ?>" onclick="addevent(this)" class="chk" id="event<?php echo $i; ?>" data-event-type="<?php echo $value['name'] ?>" data-val="<?php echo $value['name'] ?>" <?php if ($value['id'] == $requirement['event_type']) {
                                                                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                                                                  } ?> /><?php echo $value['name'] ?>
            </li>
            </label>

          <?php $i++;
          } ?>
        </ul>
      </div>

    </div>

  </div>
</div>

<script>
  function addevent(ele) {
    var fruits = [];
    var other = [];
    var total_elegible_skills = '1';

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
          // $(checked).removeAttr('checked');
          checked.checked = false;
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
<!-- end event type -->