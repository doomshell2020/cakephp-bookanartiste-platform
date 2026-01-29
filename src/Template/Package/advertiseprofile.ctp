<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

<style type="text/css">
  .js .input-file {
    top: 0;
    left: 0;
    width: 100% !important;
    opacity: 0;
    padding: 14px 0;
    cursor: pointer;
    height: 316px;
  }

  #totalamt,
  .rename {
    border: 0;
  }

  #totalamt:focus,
  #totalamt:active {
    border: 0;
  }

  .rename:focus,
  .rename:active {
    border: 0;
  }

  #myInput {
    background-image: url('/css/searchicon.png');
    background-position: 10px 12px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
  }

  .swal-button {
    background-color: #0075c5 !important;
  }

  .swal-button:active {
    background-color: #0075c5 !important;
  }
</style>


<section id="page_signup" class="advertisement">
  <div class="container">
    <div class="row">
      <div class="col-sm-2">
      </div>

      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Create Advertisement <span>For Your Profile</span></h2>
          <p>The charges of displaying advertise of your profile is <?php echo "$" . $bannerpackid['cost_per_day'] . " per day."; ?></p>
          <?php echo $this->Flash->render(); ?>

          <div class="box-body">

            <div class="manag-stu">
              <?php echo $this->Form->create($banner, array('url' => array('controller' => 'package', 'action' => 'advertiseprofile'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off', 'onsubmit' => "return validateform()")); ?>


              <div class="form-group">
                <?php $username = $this->request->session()->read('Auth.User.user_name'); ?>
                <label for="" class="col-sm-3 control-label">Advertisement Title:</label>
                <div class="col-sm-8">
                  <input type="text" name="rname" placeholder="Enter Profile Title" value="<?php echo $username; ?>" class="longinput form-control input-medium " autocomplete="off">

                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Advertisement Picture:</label>
                <div class="col-sm-4 upload-img text-center">
                  <?php if ($profileimg['profile_image']) { ?>

                    <div>
                      <a href="#">
                        <div class="input-file-container">
                          <div id="imagePreview">
                            <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profileimg['profile_image']; ?>">
                          </div>
                          <input type="hidden" id="jobimg" name="jobimg" value="<?php echo $profileimg['profile_image']; ?>">
                          <input class="input-file" id="file" type="file" name="job_image_change" onchange="return fileValidation()">
                          <label tabindex="0" for="my-file" class="input-file-trigger">Change Image</label>
                          <span id="ncpyss" style="display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

                        </div>
                      </a>
                    </div>
                  <?php } else { ?>
                    <div class="input-file-container">
                      <div id="imagePreview">
                        <img src="images/Audio-icon.png">
                      </div>
                      <span style="color: red; display: block;">Image Size 500X400</span>
                      <div>
                        <input type="hidden" id="jobimg" name="jobimg">
                        <input class="input-file" id="file" type="file" name="job_image_change" onchange="return fileValidation()">
                        <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                        <span id="ncpyss" style="display: none; color: red">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

                      </div>

                    </div>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <!-- <input type="file" class="upload">-->
                  <p class="file-return"></p>
                </div>
              </div>

              <input type="hidden" name="banner_pack_id" value="<?php echo $bannerpackid['id']; ?>">


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Target Gender:</label>
                <div class="col-sm-8">
                  <div class="input radio">

                    <label class="radio-inline">
                      <label for="gender-a">
                        <input type="checkbox" name="gender[]" value="a" id="gender-a">All</label>
                    </label>
                    <label class="radio-inline">
                      <label for="gender-m">
                        <input type="checkbox" name="gender[]" value="m" id="gender-m">Male</label>
                    </label>
                    <label class="radio-inline">
                      <label for="gender-f">
                        <input type="checkbox" name="gender[]" value="f" id="gender-f" placeholder="">Female</label>
                    </label>
                    <label class="radio-inline">
                      <label for="gender-o">
                        <input type="checkbox" name="gender[]" value="o" id="gender-o">Other</label>
                    </label>
                    <label class="radio-inline">
                      <label for="gender-bmf">
                        <input type="checkbox" name="gender[]" value="bmf" id="gender-bmf">Male And Female</label>
                      <lable>

                        <a href="javascript:void(0);" data-toggle="tooltip" title="Select Male and Female option in case you want to promote to bands that have both men and women as members">?</a>
                        <script>
                          $(document).ready(function() {
                            $('[data-toggle="tooltip"]').tooltip();
                          });
                        </script>


                    </label>

                  </div>

                </div>
                <div class="col-sm-1"></div>
              </div>

              <script>
                $('#gender-a').click(function() {

                  if ($(this).is(':checked')) {
                    $('#gender-a').attr('checked', true);
                    $('#gender-m').attr('checked', true);
                    $('#gender-f').attr('checked', true);
                    $('#gender-o').attr('checked', true);
                    $('#gender-bmf').attr('checked', true);
                  } else {
                    $('#gender-a').attr('checked', false);
                    $('#gender-m').attr('checked', false);
                    $('#gender-f').attr('checked', false);
                    $('#gender-o').attr('checked', false);
                    $('#gender-bmf').attr('checked', false);
                  }
                });
              </script>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Age Group : </label>
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-5 date">


                      <?php echo $this->Form->input('min_age', array('class' => 'form-control', 'placeholder' => 'Minimum Age', 'type' => 'Number', 'required' => true, 'label' => false, 'value' => (!empty($requirement['min_age'])) ? $requirement['min_age'] : '')); ?>

                    </div>


                    <div class="col-sm-5 date">
                      <?php echo $this->Form->input('max_age', array('class' => 'form-control', 'placeholder' => 'Maximum Age', 'type' => 'number', 'required' => true, 'label' => false, 'value' => (!empty($requirement['max_age'])) ? $requirement['max_age'] : '')); ?>
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Locations:</label>
                <div class="append">
                  <div class="locfield">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-7">
                      <?php echo $this->Form->input('current_location[]', array('class' =>
                      'longinput form-control', 'type' => 'text', 'placeholder' => 'Location', 'label' => false, 'id' => 'pac-inputss')); ?>
                      <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">-->
                      <div id="map"></div>
                      <?php echo $this->Form->input('current_lat[]', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitudecurrent', 'label' => false)); ?>

                      <?php echo $this->Form->input('current_long[]', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitudecurrent', 'label' => false)); ?>
                      <br>
                    </div>
                  </div>
                  <button type="button" id="addbutton" class="btn btn-default col-sm-1">Add</button>
                  <div class="clonediv">

                  </div>
                </div>



              </div>

              <script>
                $(document).ready(function() {
                  $("#addbutton").click(function() {
                    if ($("#pac-inputss").val() != "") {
                      event.preventDefault();
                      $(".locfield").clone().appendTo(".clonediv");
                      $(".clonediv div").removeClass("locfield");
                      $(".clonediv .longinput").attr("readonly", "true");
                      $(".locfield .longinput").val("");
                      $(".locfield #latitudecurrent").val("");
                      $(".locfield #longitudecurrent").val("");
                    }

                  });
                  $(document).on("click", "a.remove", function() {
                    $(this).parent().remove();
                  });
                });
              </script>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Advertise to:</label>
                <div class="col-sm-8">
                  <div class="input radio">
                    <label class="radio-inline">
                      <label for="advrto1">
                        <input type="checkbox" name="adfor[]" value="0" id="advrto1">All</label>
                    </label>
                    <label class="radio-inline">
                      <label for="advrto2">
                        <input type="checkbox" name="adfor[]" value="2" id="advrto2" placeholder="">Talent</label>
                    </label>
                    <label class="radio-inline">
                      <label for="advrto3">
                        <input type="checkbox" name="adfor[]" value="3" id="advrto3" placeholder="">Non talent</label>
                    </label>

                    <a style="display:none;" data-toggle="modal" class='skill btn btn-success btn-xs' href="#">Add Skills</a>
                    <!-- Modal -->

                    <div id="myModal" class="modal fade">
                      <div class="modal-dialog" style="height: 487px; overflow-y: scroll;">

                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Please select the talent types to whom you want to advertise your profile</h3>
                          </div>
                          <div class="modal-body" id="skillsetsearch">

                            <div class="">
                              <section class="content-header hide" id="error_message">
                                <div class="alert alert-danger alert-dismissible">
                                  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                  <p id="skill_error"></p>
                                </div>
                              </section>
                              <div class="table-responsive">

                                <ul id="myUL" class="list-inline form-group col-sm-12">

                                  <?php if ($Skill) {
                                    $i = 1;
                                    foreach ($Skill as $value) {
                                  ?>
                                      <li class="">
                                        <div>
                                          <label class="radio-inline">
                                            <input name="skill[]" type="checkbox" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>" /><?php echo $value['name'] ?>
                                          </label>
                                        </div>

                                      </li>

                                    <?php $i++;
                                    } ?>
                                </ul>
                              <?php } else {
                                    echo "No Data Found";
                                  } ?>
                              <!--         <div class="row m-top-20">-->
                              <!--	<div class="col-sm-6 text-center">-->
                              <!--		<button id="btn" type="submit" class="btn btn-default">Select Skills</button>-->
                              <!--	</div>-->
                              <!--	<div class="col-sm-6 text-center">-->
                              <!--		<button id="btn" type="button" onclick="cancel(); " class="btn btn-default">Cancel</button>-->
                              <!--	</div>-->
                              <!--</div>-->

                              </div>
                            </div>

                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->

                    </div>
                    <!-- /.modal -->
                  </div>

                </div>
                <div class="col-sm-1"></div>
              </div>

              <script>
                $('#advrto1').click(function() {

                  if ($(this).is(':checked')) {
                    $('#advrto1').attr('checked', true);
                    $('#advrto2').attr('checked', true);
                    $('#advrto3').attr('checked', true);
                  } else {
                    $('#advrto1').attr('checked', false);
                    $('#advrto2').attr('checked', false);
                    $('#advrto3').attr('checked', false);
                  }

                  if ($("#advrto2").prop('checked') == true) {
                    //alert("hello");
                    $('.skill').css({
                      "display": "inline-block",
                      "margin-left": "10px"
                    });
                  } else {
                    $('.skill').css("display", "none");
                  }
                });
                $('#advrto2').click(function() {
                  if ($("#advrto2").prop('checked') == true) {
                    //alert("hello");
                    $('.skill').css({
                      "display": "inline-block",
                      "margin-left": "10px"
                    });
                  } else {
                    $('.skill').css("display", "none");
                  }
                });
              </script>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Advertise From Date/Time:</label>
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-5 date">


                      <?php echo $this->Form->input('ad_date_from', array('class' => 'form-control', 'placeholder' => 'M DD, YYYY', 'type' => 'text', 'required' => true, 'readonly' => true, 'label' => false, 'id' => 'event_from_date', 'onchange' => "return validateform()", 'value' => (!empty($requirement['event_from_date'])) ? date('Y-m-d H:m', strtotime($requirement['event_from_date'])) : '')); ?>

                    </div>

                    <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>
                    <div class="col-sm-5 date">
                      <?php echo $this->Form->input('ad_date_to', array('class' => 'form-control', 'placeholder' => 'M DD, YYYY', 'type' => 'text', 'required' => true, 'readonly' => true, 'label' => false, 'id' => 'event_to_date', 'onchange' => "return validateform()", 'value' => (!empty($requirement['event_to_date'])) ? date('Y-m-d H:m', strtotime($requirement['event_to_date'])) : '')); ?>
                    </div>
                  </div>
                  <!--  <span class="jobpostrequired">* Your Banner request shall be reviewed within 48 hours</span> -->
                  <span id="datealert" style="display:none; color:red;">Your profile already advertised on this date.</span>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Total Price</label>
                <div class="col-sm-8">

                  <h5 id="totaldiv">
                    Total Price of <span class="jobname rename"> </span> Advertisement is $<input readonly="re
                  " type="text" name="req_ad_total" id="totalamt">
                  </h5>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="field col-sm-6">
                  <input type="hidden" value="N" name="enable_create_subadmin">
                  <label>
                    <input type="checkbox" required="required" class="mtac"> I agree with Bookanartiste <a data-toggle="modal" class='tandc' href="javascript:void(0);"> Terms and Conditions</a>

                    <script>
                      $('.tandc').click(function(e) {
                        //alert("hello");
                        e.preventDefault();
                        $('#termsConditions').modal('show');
                      });
                    </script>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-4"></div>
                <div class="col-sm-4 text-center m-top-20">
                  <button type="submit" class="btn btn-default">Pay Now and Advertise</button>
                </div>
                <div class="col-sm-4 text-center m-top-20">
                  <a href="<?php echo SITE_URL; ?>/package/advertised-profile" data-toggle="modal" class="serviceview btn btn-default">View Earlier Profile Advertisements</a>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<script type="text/javascript">
  $('.serviceview').click(function(e) {
    e.preventDefault();
    $('#servicedetail').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>

<div class="modal fade" id="servicedetail">
  <div class="modal-dialog" style="width: 88% !important;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">


      </div>


    </div>
  </div>
</div>

<!-- Modal -->

<div id="termsConditions" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms and Conditions</h4>
      </div>
      <div class="modal-body">
        <?php echo $termsandconditions; ?>
        <br>
        <div>
          <input type="checkbox" class="tac">I agree the Bookanartiste Terms and Conditions
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<script>
  $('.skill').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show');
  });
</script>



<script>
  $('.tac').click(function() {

    if ($(this).is(':checked')) {
      $('.mtac').attr('checked', true);
    } else {
      $('.mtac').attr('checked', false);
    }
  });

  $('.mtac').click(function() {

    if ($(this).is(':checked')) {
      $('.tac').attr('checked', true);
    } else {
      $('.tac').attr('checked', false);
    }
  });
</script>

<?php //pr($jobadid); die; 
?>


<script type="text/javascript">
  $(function() {
    //var daydiff;
    var today = new Date();
    var tomorrow = new Date();
    var lastadvertisedate = '<?php echo $jobadid['ad_date_from']; ?>';
    //alert(lastadvertisedate);

    tomorrow.setDate(today.getDate() + 1);
    $("#totalamt").val('0');
    $('#event_from_date').datetimepicker({
      format: 'M dd, yyyy HH:ii P',
      startDate: today,
      autoclose: true,
    });
    $('#event_from_date').click(function(e) {
      $('#event_from_date').datetimepicker("show");
      e.preventDefault();
    });

    $('#event_to_date').datetimepicker({
      format: 'M dd, yyyy HH:ii P',
      startDate: tomorrow,
      autoclose: true,
    });
    $('#event_to_date').click(function(e) {
      $('#event_to_date').datetimepicker("show");
      e.preventDefault();
    });

    $('#event_from_date').change(function() {

      var adfromdate = $('#event_from_date').val();
      //  alert(changedate);

      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/package/checkadtodate',
        data: {
          'advertisejobdate': adfromdate
        },
        //cache: false,
        success: function(data) {
          //alert(data);
          if (data == 1) {
            $("#event_from_date").val('');
            $("#datealert").css("display", "block");
          } else {
            $("#datealert").css("display", "none");
          }
        }
      });
    });

  });
</script>

<script type="text/javascript">
  function fileValidation() {
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var maxsize = '100';
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (!allowedExtensions.exec(filePath)) {
      $("#ncpyss").css("display", "block");
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {

        var size = fileInput.files[0].size;
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);

      }
    }
  }
</script>



<script>
  $(document).ready(function() {
    $('#sample_input').awesomeCropper({
      width: 150,
      height: 150,
      debug: true
    });
  });

  // Validate form
  function validateform() {
    console.log('validateform');

    var error = '';

    var fromVal = $('#event_from_date').val();
    var toVal = $('#event_to_date').val();

    // Check empty dates
    if (!fromVal || !toVal) {
      error = "Please select both Advertisement start and end dates.<br>";
    }

    var event_from_date = new Date(fromVal);
    var event_to_date = new Date(toVal);

    // Remove time part for accurate comparison
    event_from_date.setHours(0, 0, 0, 0);
    event_to_date.setHours(0, 0, 0, 0);

    // Date validation
    if (event_to_date < event_from_date) {
      $("#totalamt").val('0');
      error += "Advertisement end date cannot be earlier than start date.<br>";
    }

    // Calculate amount only if no error
    if (error == '') {
      var diffTime = event_to_date.getTime() - event_from_date.getTime();
      var daydiff = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      var amt = <?php echo (int)$bannerpackid['cost_per_day']; ?>;
      var totalamt = amt * daydiff;

      if (isNaN(totalamt) || totalamt <= 0) {
        $("#totalamt").val('');
      } else {
        $("#totalamt").val(totalamt);
      }
    }    

    // Show error dialog
    if (error != '') {
      BootstrapDialog.alert({
        size: BootstrapDialog.SIZE_SMALL,
        title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Advertisement !!",
        message: "<h5>" + error + "</h5>"
      });

      $('#event_to_date').val('');
      return false;
    }

    return true;
  }
</script>




<script>
  function addskill(ele) {
    var total_elegible_skills = '<?php echo $total_elegible_skills ?>';
    var fruits = [];
    var other = [];
    $("#error_message").addClass("hide");
    var checked = document.getElementById(ele.id);
    var ckName = document.getElementsByName(ele.name);
    $("input:checkbox[class=chk]").each(function() {
      if ($(this).is(":checked")) {
        var checkedskills = $('input:checkbox[class=chk]:checked').length;
        if (checkedskills > total_elegible_skills) {

          skill_error = "You can only Select " + total_elegible_skills + " skill categories for your profile";
          $("#skill_error").html(skill_error);
          $("#error_message").removeClass("hide");
          // $("#"+ele.id).prop('checked', false);
          $(checked).removeAttr('checked');
          // return false;
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