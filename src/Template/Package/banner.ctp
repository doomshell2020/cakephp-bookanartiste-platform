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

  #totalamt {
    border: 0;
  }

  #totalamt:focus,
  #totalamt:active {
    border: 0;
  }
</style>
<section id="page_signup">
  <div class="container">
    <div class="row">
      <div class="col-sm-2">
      </div>

      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Create <span>A Banner</span></h2>
          <p>The charges of displaying banner on the homepage is <?php echo "$" . $bannerpackid['cost_per_day'] . " per day."; ?></p>
          <p>Increase your reach and awareness by creating a banner on our homepage. Get more eyeballs.</p>
          <hr>
          <?php echo $this->Flash->render(); ?>

          <div class="box-body">

            <div class="manag-stu">
              <?php echo $this->Form->create($banner, array('name' => 'form1', 'url' => array('controller' => 'package', 'action' => 'banner'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off', 'onsubmit' => "return validateform()")); ?>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Banner image :</label>
                <div class="col-sm-4 upload-img text-center">
                  <?php if ($profile['profile_image']) { ?>
                    <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile['profile_image']; ?>">
                    <div><a href="#">
                        <div class="input-file-container">
                          <input class="input-file" id="file" type="file" name="banner_image" onchange="return fileValidation()">
                          <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                          <span id="ncpyss" style="display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

                        </div>

                      </a>


                    </div>
                  <?php } else { ?>
                    <div class="input-file-container">
                      <div id="imagePreview">
                        <!-- <img src="images/mick.png"> -->
                        <img src="images/mick.png">

                      </div>
                      <!-- <span style="color: red; display: block;">Image Size 1368x767</span> -->
                      <div>


                        <input class="input-file" id="file" type="file" name="banner_image" onchange="return fileValidation()" required>
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
                <label for="" class="col-sm-3 control-label">Title of Banner:</label>
                <div class="col-sm-8">
                  <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Banner Title', 'id' => 'name', 'label' => false, 'maxlength' => 100)); ?>

                </div>
                <div class="col-sm-1"></div>
              </div>


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Banner URL:</label>
                <div class="col-sm-8">
                  <?php echo $this->Form->input('bannerurl', array('class' => 'form-control url', 'placeholder' => 'Banner Url', 'id' => 'bannerurl', 'label' => false)); ?>

                </div>


                <div class="col-sm-1"></div>
              </div>


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Banner From Date/Time:</label>
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-5 date">


                      <?php echo $this->Form->input('banner_date_from', array('class' => 'form-control datetimepicker1', 'placeholder' => 'MM DD, YYYY', 'type' => 'text', 'required' => true, 'label' => false, 'id' => 'event_from_date', 'value' => (!empty($requirement['event_from_date'])) ? date('M d, Y H:m', strtotime($requirement['event_from_date'])) : '')); ?>

                    </div>

                    <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>


                    <div class="col-sm-5 date">
                      <?php echo $this->Form->input('banner_date_to', array('class' => 'form-control datetimepicker2', 'placeholder' => 'MM DD, YYYY', 'type' => 'text', 'required' => true, 'label' => false, 'id' => 'event_to_date', 'onchange' => "return validateform()", 'value' => (!empty($requirement['event_to_date'])) ? date('M d, Y H:m', strtotime($requirement['event_to_date'])) : '')); ?>
                    </div>
                  </div>
                  <span class="jobpostrequired">* Your Banner request shall be reviewed within 48 hours</span>
                </div>
                <div class="col-sm-1"></div>
              </div>
<hr>
              <div class="form-group">
                <label for="" class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                  <h5 id="totaldiv" style="margin-left: 92px;">Total Amount Payable for this Banner Campaign is $<span style="color:red;"><input readonly="re" type="text" name="bannertotal" id="totalamt"></span></h5>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12 text-center m-top-20">
                  <button type="submit" onclick="clicked();" class="btn btn-default">Submit</button>
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
  /*  $(function() { 
   var today = new Date();
   var tomorrow = new Date();
    tomorrow.setDate(today.getDate()+2);

   $('.datetimepicker1').datetimepicker({
     format: "dd MM yyyy h:mm",
     language: 'en', 
     pickTime: false,
     pick12HourFormat: true,
     startDate: tomorrow,
     endDate:0, 
   }); 

   $('.datetimepicker2').datetimepicker({
     format: "dd MM yyyy h:mm",
     language: 'en', 
     pickTime: false,
     pick12HourFormat: true,
     startDate: tomorrow,
     endDate:0, 
   }); 
 }); */
</script>

<script>
  function clicked() {
    var text = $('.url').val();
    if (text) {
      var res = text.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
      if (res == null) {
        alert('Invalid Banner Url');
      }
    }
  }
</script>

<script type="text/javascript">
  $(function() {
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 2);
    $("#totalamt").val('0');
    $('#event_from_date').datetimepicker({
      format: 'M dd, yyyy hh:ii',
      startDate: tomorrow,
      autoclose: true
    });

    $('#event_to_date').datetimepicker({
      format: 'M dd, yyyy hh:ii',
      startDate: tomorrow,
      autoclose: true
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

    error = '';
    //alert('0');

    event_from_date = new Date($('#event_from_date').val());
    event_to_date = new Date($('#event_to_date').val());
    //alert(event_to_date);

    var todatenew = event_to_date.getTime();
    var fromdatenew = event_from_date.getTime();
    //console.log(todatenew);
    //console.log(todatenew-fromdatenew);
    var difrence = todatenew - fromdatenew;
    if (difrence < 86400000) {
      $("#totalamt").val('0');
      error = error + "The minimum durationof a homepage banner is 1 day. Please select another time value in To column.<br>";
    } else {
      var start = $('#event_from_date').val();
      var end = $('#event_to_date').val();
      // end - start returns difference in milliseconds 
      var diff = new Date(event_to_date - event_from_date);
      // get days
      var days = diff / 1000 / 60 / 60 / 24;
      var daydiff = Math.round(days);
      var amt = '<?php echo $bannerpackid['cost_per_day']; ?>';
      var totalamt = amt * daydiff;
      //alert(totalamt);
      if (isNaN(totalamt)) {
        $("#totalamt").val('');
      } else {
        $("#totalamt").val(totalamt);
      }
    }

    if (error != '') {
      BootstrapDialog.alert({
        size: BootstrapDialog.SIZE_SMALL,
        title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Banner !!",
        message: "<h5>" + error + "</h5>"
      });
      $('#event_to_date').val('');
      return false;
    }
  }
</script>

<script>
  function ValidateDomain(inputText) {
    // alert(inputText.value);
    var urlformat = /^(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;

    if (inputText.value.match(urlformat)) {
      return true;
    } else {
      alert("You have entered an invalid Domain !");
      $('#bannerurl').val('');
      return false;
    }
  }
</script>