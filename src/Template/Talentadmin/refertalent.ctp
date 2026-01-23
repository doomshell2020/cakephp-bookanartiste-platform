<!----------------------editprofile-strt------------------------>
<?php
foreach ($skillofcontaint as $key => $value) {
  $array[] = $value['skill_id'];
  $array1[] = $value['skill']['name'];
}
?>
<style type="text/css">
  .js .input-file {
    position: absolute !important;
    z-index: 9999 !important;
    width: 130px !important;
  }

  .js .input-file-trigger {
    position: absolute;
  }
</style>
<section id="page_signup">
  <div class="container">
    <div class="row">

      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Upload Profiles</h2>
          <p class="m-bott-50">As a Talent Partner with us; build a business and income stream by referring profiles. Create great community of creatives and generate opportunities.</p>
          <?php echo $flashmessage = $this->Flash->render('sucess'); ?>
          <?php echo $columnerror = $this->Flash->render('columnerror'); ?>
          <?php
          if ($columnerror == "") {
            echo $allsuc = $this->Flash->render('allsuc');
          }
          ?>
          <?php echo $multiflash =  $this->Flash->render(); ?>

          <?php echo $this->Form->create($packentity, array(
            'class' => 'form-horizontal',
            'id' => 'content_admin',
            'enctype' => 'multipart/form-data',
            'onsubmit' => ' return checkpass()', 'autocomplete' => 'off'
          )); ?>
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Upload Profile Options
              </label>
              <div class="field col-sm-6">
                <input style="cursor: pointer;" type="radio" name="refer_type" id="ump" onclick="changerefertype(this)" class="refer_type " value="C" checked> <label style="cursor: pointer;" for="ump">Upload Multiple Profiles</label>
                <br>
                <input style="cursor: pointer;" type="radio" name="refer_type" id="usp" onclick="changerefertype(this)" class="refer_type " value="I"> <label style="cursor: pointer;" for="usp">Upload Single Profile </label>

              </div>
            </div>

            <div id="csv_upload" class="">
              <div class="form-group">
                <label class="col-sm-3 control-label">Excel sheet upload
                </label>
                <div class="field col-sm-6">
                  <input class="input-file" type="file" name="csv_file" id="csv_file" required onchange="return fileValidation();" required accept=".xlsx, .xls">
                  <label tabindex="0" for="my-file" class="input-file-trigger">Upload Excel Sheet</label>
                </div>
                <span id="ncpyss" style="display: none; color: red"> File Extension Allow .xls|.xlsx Format Only</span>

              </div>


              <div class="form-group" id="submittext" style="display: none; color: red">
                <label class="col-sm-3 control-label">
                </label>
                <div class="field col-sm-6">
                  <span> Click on Submit button to Upload</span>
                </div>
              </div>
            </div>

            <div id="refer_form">
              <div class="form-group">
                <label class="col-sm-3 control-label">Name<span class="jobpostrequired">*</span>
                </label>
                <div class="field col-sm-6">
                  <?php echo $this->Form->input('name', array('class' =>
                  'longinput form-control', 'id' => 'user_name', 'placeholder' => 'Name', 'required', 'label' => false, 'disabled' => true)); ?>
                  <input type="hidden" name="ref_by" value="<?php echo $this->request->session()->read('Auth.User.id'); ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Email<span class="jobpostrequired">*</span>
                </label>
                <div class="field col-sm-6">
                  <?php echo $this->Form->input('email', array('class' =>
                  'longinput form-control talentusers', 'type' => 'email', 'onChange()' => 'isEmail', 'placeholder' => 'Write one email id to refer profile', 'required', 'label' => false, 'disabled' => true)); ?>
                  <span id="talenthere" style="display:none;color:red;"><span id="talentheres"></span> already exists in the site. Please upload another profile.</span>
                  <!--<span id="talenthere" style="display:none;color:red;"><span id="talentheres"></span> has already uploaded. Please upload another profile.</span> -->

                  <!--<span id="referhear" style="display:none;color:red;"><span id="referhears"></span> Profile has already been referred to the site. Please upload another profile. </span>-->
                  <span id="referhear" style="display:none;color:red;"><span id="referhears"></span> `s already uploaded. Please upload another profile. </span>
                  <span id="talentmessage" style="display:none;color:red;"><span id="talentmessages"></span> already exists in the site. Please upload another profile. </span>
                  <span id="validemail" style="display:none;color:red;"> Please enter a valid email address.</span>
                </div>
                <button type="button" class="btn btn-success" id="verify">Verify</button>
                <span id="verified" style="color:red; display:none">Click on Submit to upload</span>

              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Phone No
                </label>
                <div class="field col-sm-6">
                  <?php echo $this->Form->input('mobile', array('class' =>
                  'longinput form-control', 'onkeypress' => 'return isNumber();', 'placeholder' => 'Write country code starting with "+"', 'label' => false, 'disabled' => true)); ?>
                </div>
              </div>
            </div>
            <script type="text/javascript">
              function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                //alert(charCode);

                if (charCode != 190 && charCode != 44 && charCode != 40 && charCode != 41 && charCode != 45 && charCode != 190 && charCode != 32 && charCode != 43 && charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
                  alert("Please Enter Only Numeric Characters!!!!");
                  return false;
                }
                return true;

              }
            </script>
            <?php /* ?>   <div class="form-group">
            <label class="col-sm-3 control-label">Skills
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('skillshow', array('class' => 
'longinput form-control','maxlength'=>'200',''=>true,'placeholder'=>'Skills','required','label'=>false,'value'=>implode(", ",$array1))); ?>
            </div>
            <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentsubadmin/skills/<?php echo $packentity['id']; ?>">Add Skills
            </a>
            <input type="hidden" name="skill" id="skill"  value="<?php echo  implode(",",$array); ?>"/> 
          </div>
          <?php */ ?>
            <div class="form-group">
              <label class="col-sm-3 control-label">
              </label>
              <div class="field col-sm-6">
                <span id="dse"><a href="<?php echo SITE_URL; ?>/talentadmin/uploadexcelsample">Download Sample Excel Sheet</a>
                  (Name and E-Mail ID are compulsory fields in the excel sheet)
                </span>
              </div>
            </div>


            <div class="form-group">
              <div class="col-sm-12 text-center">
                <?php
                echo $this->Form->submit(
                  'Submit',
                  array('class' => 'btn btn-primary', 'id' => 'submitf', 'title' => 'Submit')
                );
                ?>
              </div>
            </div>
          </div>

          <!--content-->
          <!-- Modal -->
          <div id="myModal" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
                <div class="modal-body" id="skillsetsearch">
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
              $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
            });
          </script>
          <!-- /.form group -->
        </div>
        <!-- /.box-body -->

        <!-- /.box-footer -->
        <?php echo $this->Form->end(); ?>
      </div>
    </div>

  </div>
  </div>
</section>

<div class="modal fade" id="irefer" role="dialog">
  <style>
    .modal-body .alert-danger {
      color: #000000;
      background-color: #078fe8;
      border-color: #ebccd1;
    }
  </style>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?php echo $this->Flash->render('count');  ?>
        <?php if (isset($_SESSION['referinvited'])) { ?>
          <span class="error-record"><?php echo $this->Flash->render('refer_error'); ?></span>
          <table class="table table-bordered error-record-table">
            <thead>
              <tr>
                <th>Sr</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sr = 1;
              foreach ($_SESSION['referinvited'] as $key => $value) { ?>
                <tr>
                  <td><?php echo $sr; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                </tr>
              <?php $sr++;
              } ?>
            </tbody>
          </table>
        <?php } ?>

        <?php if (isset($_SESSION['blank'])) { ?>
          <br>
          <br>
          <span class="blank-record"><?php echo $this->Flash->render('blank'); ?></span>
          <table class="table table-bordered blank-record-table">
            <thead>
              <tr>
                <th>Sr</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sr = 1;
              foreach ($_SESSION['blank'] as $key => $value) { ?>
                <tr>
                  <td><?php echo $sr; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                  <td><?php echo $value['mobile']; ?></td>
                </tr>
              <?php $sr++;
              } ?>
            </tbody>
          </table>
        <?php } ?>

        <?php if (isset($_SESSION['invalid'])) { ?>
          <br>
          <br>
          <span class="invalid-record"><?php echo $this->Flash->render('invalid'); ?></span>
          <table class="table table-bordered invalid-record-table">
            <thead>
              <tr>
                <th>Sr</th>
                <th>Name</th>
                <th>Incorrect Email</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sr = 1;
              foreach ($_SESSION['invalid'] as $key => $value) { ?>
                <tr>
                  <td><?php echo $sr; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                </tr>
              <?php $sr++;
              } ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script>
  $(".blank-record .content-header .alert .close").click(function() {
    $(".blank-record-table").css("display", "none");
  });

  $(".error-record .content-header .alert .close").click(function() {
    $(".error-record-table").css("display", "none");
  });

  $(".invalid-record .content-header .alert .close").click(function() {
    $(".invalid-record-table").css("display", "none");
  });
</script>


<script type="text/javascript">
  function fileValidation() {
    var fileInput = document.getElementById('csv_file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.xls|\.xlsx)$/i;
    //alert(allowedExtensions);
    if (!allowedExtensions.exec(filePath)) {
      $("#ncpyss").css("display", "block");
      $("#submittext").css("display", "none");
      fileInput.value = '';
      return false;
    } else {
      $("#submittext").css("display", "block");
      $("#ncpyss").css("display", "none");
    }
  }

  // Change refer type
  function changerefertype(values) {
    type = values.value;
    //alert(type);
    if (type == 'C') {
      $('#csv_file').removeAttr('disabled');
      $('#submitf').removeAttr('disabled');
      $('#user_name').attr('disabled', 'disabled');
      $('#email').attr('disabled', 'disabled');
      $('#mobile').attr('disabled', 'disabled');
      $("#csv_upload").show();
      $("#refer_form").hide();
      $("#dse").show();
    } else {
      $('#user_name').removeAttr('disabled');
      $('#email').removeAttr('disabled');
      $('#mobile').removeAttr('disabled');
      $('#csv_file').attr('disabled', 'disabled');
      $('#submitf').attr('disabled', 'disabled');
      $("#csv_upload").hide();
      $("#refer_form").show();
      $("#dse").hide();
    }
  }
  $("#refer_form").hide();




  $(document).ready(function() {

    $("#country_ids").on('change', function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/talentadmin/getStates',
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
          url: '<?php echo SITE_URL; ?>/talentadmin/getcities',
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

    $(".talentusers").keyup(function() {
      $('#submitf').attr('disabled', 'disabled');
      $('#verified').hide();
    });

    $("#verify").on('click', function() {
      var userprofile = $('.talentusers').val();
      //alert(userprofile);
      if (userprofile) {
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/talentadmin/checktalent',
          data: {
            'userprofile': userprofile
          },
          cache: false,
          success: function(data) {
            if (/(.+)@(.+){2,}\.(.+){2,}/.test(userprofile)) {
              obj = JSON.parse(data);
              console.log(obj);
              if (obj.name == 'Y') {
                $('.talentusers').val('');
                $('#talenthere').show();
                $('#referhear').hide();
                $('#talentmessage').hide();
                $("#talentheres").html(obj.user_name);
              } else if (obj.name == 'R') {
                $('.talentusers').val('');
                $('#referhear').show();
                $('#talenthere').hide();
                $('#talentmessage').hide();
                $("#referhears").html(obj.user_name);
              } else if (obj.name == 'T') {
                $('.talentusers').val('');
                $('#talenthere').hide();
                $('#talentmessage').show();
                $('#referhear').hide();
                $("#talentmessages").html(obj.user_name);
              } else {
                $('#talenthere').hide();
                $('#talentmessage').hide();
                $('#referhear').hide();
                $('#submitf').removeAttr('disabled');
                $("#verified").css("display", "block");
              }
            } else {
              //alert("Please Enter a Valid Email");
              $('#validemail').show();
              $('#talenthere').hide();
              $('#referhear').hide();
              $('.talentusers').val('');
            }
          }
        });
        $('#validemail').hide();
      }

      //alert("Valid Email");


    });
  });
</script>


<script>
  <?php if ($this->Flash->render('refer_fail')) {  ?>
    $(document).ready(function() { //alert();
      $('#irefer').modal('show');
    });
  <?php } ?>

  $('#irefer').on('hidden.bs.modal', function() {
    $(this).removeData('bs.modal');
  })
</script>

<script>
  $(document).ready(function() {
    <?php if ($allsuc) {  ?>
      setTimeout(function() {
        $('.close').trigger('click');
      }, 7000);
    <?php } ?>

    <?php if ($flashmessage) {  ?>
      setTimeout(function() {
        $('.close').trigger('click');
      }, 7000);

      $('#usp').attr('checked', 'checked')
      $('#user_name').removeAttr('disabled');
      $('#email').removeAttr('disabled');
      $('#mobile').removeAttr('disabled');
      $('#submitf').attr('disabled', 'disabled');
      $('#csv_file').attr('disabled', 'disabled');
      $("#csv_upload").hide();
      $("#refer_form").show();
      $("#dse").hide();
    <?php } else { ?>
      $('#csv_file').removeAttr('disabled');
      $('#submitf').removeAttr('disabled');
      $('#user_name').attr('disabled', 'disabled');
      $('#email').attr('disabled', 'disabled');
      $('#mobile').attr('disabled', 'disabled');
      $("#csv_upload").show();
      $("#refer_form").hide();
      $("#dse").show();
    <?php } ?>

    <?php if ($multiflash) {  ?>
      setTimeout(function() {
        $('.close').trigger('click');
      }, 7000);
    <?php } ?>
  });
</script>

<script>
  // $( document ).ready(function() {
  //   setTimeout(function(){ 
  //     $(".alert").hide();
  //   }, 7000);
  // });
</script>