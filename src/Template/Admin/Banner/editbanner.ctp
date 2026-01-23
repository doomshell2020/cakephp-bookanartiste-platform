<?php //echo "test"; die;
foreach ($country as $country_data) {
  $country_id = $country_data['Country']['id'];
  $countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Banner Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="#"> Banner Manager</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit</h3>
            <a href="<?php echo ADMIN_URL; ?>banner" type="reset" class="btn btn-success pull-right">Got To Banner Manger</a>
          </div>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>


          <div class="box-body  table-responsive">
            <div class="manag-stu">
              <?php echo $this->Form->create($banner, array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off', 'onsubmit' => "return validateform()")); ?>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Banner image :</label>
                <div class="col-sm-4 upload-img text-center">

                  <div id="imagePreview" style="float: left;">
                    <img src="<?php echo SITE_URL; ?>/images/mick.png">
                    <!-- <span style="color: red; display: block;">Image Size 1368x767</span> -->
                  </div>
                  <div>

                    <?php if ($banner['banner_image']) { ?>
                      <div class="input-file-container">
                        <input class="input-file" id="file" type="file" name="banner_image" onchange="return fileValidation()">
                        <!-- <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label> -->
                        <span id="ncpyss" style="display: none; color: red">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
                      </div>
                      <img src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $banner['banner_image']; ?>" height="50px" width="130px">

                    <?php } else { ?>
                      <div class="input-file-container">
                        <input class="input-file" id="file" type="file" name="banner_image" onchange="return fileValidation()" required>
                        <!-- <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label> -->
                        <span id="ncpyss" style="display: none; color: red">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
                      </div>
                      <img src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $banner['banner_image']; ?>" height="50px" width="130px">
                    <?php } ?>

                  </div>
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
                  <?php echo $this->Form->input('bannerurl', array('class' => 'form-control', 'placeholder' => 'Banner Url', 'id' => 'bannerurl', 'label' => false, 'type' => 'text')); ?>

                </div>
                <div class="col-sm-1"></div>
              </div>


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Banner From Date/Time:</label>
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-5 date">
                      <?php $fromdate = date('Y-m-d h:i:s', strtotime($banner['banner_date_from']));
                      $todate = date('Y-m-d h:i:s', strtotime($banner['banner_date_to'])); ?>

                      <?php echo $this->Form->input('banner_date_from', array('class' => 'form-control datetimepicker1', 'placeholder' => 'MM DD, YYYY', 'type' => 'text', 'required' => true, 'label' => false, 'id' => 'event_from_date', 'onchange' => "return validateform()", 'value' => (!empty($requirement['event_from_date'])) ? date('M d, Y H:m', strtotime($requirement['event_from_date'])) : '', 'value' => date("M d Y h:i", strtotime($fromdate)))); ?>

                    </div>

                    <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>


                    <div class="col-sm-5 date">
                      <?php echo $this->Form->input('banner_date_to', array('class' => 'form-control datetimepicker2', 'placeholder' => 'MM DD, YYYY', 'type' => 'text', 'required' => true, 'label' => false, 'id' => 'event_to_date', 'onchange' => "return validateform()", 'value' => (!empty($requirement['event_to_date'])) ? date('M d, Y H:m', strtotime($requirement['event_to_date'])) : '', 'value' => date("M d Y h:i", strtotime($todate)))); ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-1"></div>
              </div>

              <div class="form-group">
                <div class="col-sm-12 text-center m-top-20">
                  <button type="submit" class="btn btn-default">Update</button>
                </div>
              </div>
              </form>
            </div>

          </div>

        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<!-- /.content-wrapper -->



<!-- Daynamic modal -->
<div id="myModal" class="modal fade">
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
  $('.order_details').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>

<script>
  $('.performance').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>

<script>
  $('.skill').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>

<script>
  $('.data').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>
<script src="https://www.bookanartiste.com/js/bootstrap-datetimepicker.js"></script>
<script src="https://www.bookanartiste.com/js/bootstrap-datepicker.js"></script>
<link href="https://www.bookanartiste.com/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://www.bookanartiste.com/css/admin/datepicker3.css" />

<script type="text/javascript">
  $(function() {
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate());

    $('#event_from_date').datetimepicker({
      startDate: today,
      format: 'M dd, yyyy hh:ii',
      autoclose: true
    });
    $('#event_to_date').datetimepicker({
      startDate: today,
      format: 'M dd, yyyy hh:ii',
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
    event_from_date = new Date($('#event_from_date').val());
    event_to_date = new Date($('#event_to_date').val());
    //alert(event_to_date);

    var todatenew = event_to_date.getTime();
    var fromdatenew = event_from_date.getTime();
    //console.log(todatenew);
    //console.log(todatenew-fromdatenew);
    var difrence = todatenew - fromdatenew;
    if (difrence < 86400000) {
      alert("Banner End date cannot be less than Banner start date.");
      $('#event_to_date').val('');
      return false;
    }

  }
</script>

<script>
  function ValidateDomain(inputText) {
    //alert(inputText.value);
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