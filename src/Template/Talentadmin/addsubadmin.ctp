<!----------------------editprofile-strt------------------------>
<?php
foreach ($skillofcontaint as $key => $value) {
  $array[] = $value['skill_id'];
  $array1[] = $value['skill']['name'];
}
?>

<section id="page_signup">
  <div class="container">
    <div class="row">

      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>
            <?php
            //pr($packentity); die;
            if (isset($packentity)) {
              echo "Edit Talent Partner";
            } else {
              echo "Create Talent Partner";
            }
            ?>

          </h2>
          <?php echo $this->Flash->render(); ?>
          <?php echo $this->Form->create($packentity, array(
            'class' => 'form-horizontal',
            'id' => 'content_admin',
            'enctype' => 'multipart/form-data',
            'onsubmit' => ' return checkpass()', 'autocomplete' => 'off'
          ));  //pr($packentity); 
          ?>
          <div class="box-body">

            <div class="form-group">
              <label class="col-sm-3 control-label">Name</label>
              <div class="field col-sm-6">
                <?php echo $this->Form->input('user_name', array('class' =>
                'longinput form-control usrname usern', 'required', 'placeholder' => 'Name', 'required', 'label' => false, 'id' => 'user_val uname')); ?>

                <div id="user_display" style="display:none">
                  <?php echo $this->Form->input('user_name2', array('class' =>
                  'longinput form-control', 'required', 'placeholder' => 'Name', 'required', 'label' => false, 'id' => 'usertval_default', 'readonly' => true)); ?>
                </div>

                <input type="hidden" name="talent_admin" value="<?php echo $this->request->session()->read('Auth.User.id'); ?>">
              </div>

              <input type="hidden" name="non_tp_id" id="nontalentpartnerid">
            </div>
            <div class="form-group">
              <?php
              if (isset($packentity['email'])) {
                $readonly = "true";
              } else {
                $readonly = "false";
              }
              ?>
              <label class="col-sm-3 control-label">Email
              </label>
              <div class="field col-sm-6">
                <?php echo $this->Form->input('usertalentid', array('class' => 'form-control', 'placeholder' => 'usertalentid', 'id' => 'usertalentid', 'required' => true, 'label' => false, 'type' => 'hidden', 'readonly' => true)); ?>

                <?php echo $this->Form->input('email', array('class' =>
                'longinput form-control uemail', 'required', 'placeholder' => 'Email', 'required', 'label' => false, 'id' => 'talentusers', 'readonly' => $readonly)); ?>
                <span id="talenthere" style="display:none;color:red;"><span id="talentheres"></span> is already a talent partner. Please create another talent partner</span>
              </div>
            </div>

            <div class="form-group">
              <?php
              if ($packentity['talent_admin']['country_id'] != 0) {
                $loccountry = $packentity['talent_admin']['country_id'];
              } else {
                $loccountry = $packentity['profile']['country_ids'];
              }
              ?>
              <label class="col-sm-3 control-label">Country
              </label>
              <div class="field col-sm-6">
                <?php echo $this->Form->input('country_id', array('class' => 'form-control country', 'placeholder' => 'Country', 'id' => 'country_ids', 'required' => true, 'label' => false, 'empty' => '--Select Country--', 'options' => $country, 'value' => $loccountry)); ?>
              </div>
            </div>
            <div class="form-group">
              <?php if ($packentity['talent_admin']['state_id'] != 0) {
                $locstate = $packentity['talent_admin']['state_id'];
              } else {
                $locstate = $packentity['profile']['state_id'];
              }
              ?>
              <label class="col-sm-3 control-label">State
              </label>
              <div class="field col-sm-6">
                <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', 'required' => true, 'label' => false, 'empty' => '--Select State--', 'options' => $states, 'value' => $locstate)); ?>
              </div>
            </div>
            <div class="form-group">
              <?php if ($packentity['talent_admin']['city_id'] != 0) {
                $loccity = $packentity['talent_admin']['city_id'];
              } else {
                $loccity = $packentity['profile']['city_id'];
              }
              ?>
              <label class="col-sm-3 control-label">City
              </label>
              <div class="field col-sm-6">
                <?php echo $this->Form->input('city_id', array('class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'label' => false, 'empty' => '--Select City--', 'required' => false, 'options' => $cities, 'value' => $loccity)); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Revenue Share Commission(%)
              </label>
              <div class="field col-sm-6">
                <?php //pr($talentsubadmin); 
                ?>
                <select class="form-control" name="commission" required>
                  <option value="">Select Revenue Share Percentage</option>
                  <?php
                  for ($c = 1; $c <= $tal_part_comm['tal_part_comm']; $c++) { ?>
                    <option value="<?php echo $c; ?>" <?php if ($c == $packentity['commision']) {
                                                        echo "selected=selected";
                                                      } ?>><?php echo $c; ?></option>

                  <?php } ?>
                </select>



              </div>
            </div>
            <?php /* 
                <div class="form-group">
                  <label class="col-sm-3 control-label">Skills
                  </label>
                  <div class="field col-sm-6">
                    <?php echo $this->Form->input('skillshow', array('class' => 
                    'longinput form-control','maxlength'=>'200','required'=>true,'placeholder'=>'Skills','label'=>false,'value'=>implode(", ",$array1))); ?>
                  </div>
                  <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentsubadmin/skills/<?php echo $packentity['id']; ?>">Add Skills
                  </a>
                  <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> 
                 */ ?>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="field col-sm-6">
                <input type="hidden" value="N" name="enable_create_subadmin">
                <label> <input type="checkbox" id="checktalpartner" value="Y" name="enable_create_subadmin" <?php if ($packentity['talent_admin'][0]['enable_create_subadmin'] == 'Y') {
                                                                                                              echo "checked";
                                                                                                            } ?>> Can Create Talent Partners
                  <a id="popoverOption" class="badge" href="#" data-content="This gives the right to Talent Partner to create more Talent partners. If you remove tick, then the talent partner being created will not be able to create talent partners" rel="popover" data-placement="bottom" data-original-title="Create Talent Partners">?</a>
                </label>
              </div>
            </div>

            <script>
              $(document).ready(function() {
                $('#popoverData').popover();
                $('#popoverOption').popover({
                  trigger: "hover"
                });
              });
            </script>

            <script>
              radiobtn = document.getElementById("checktalpartner");
              radiobtn.checked = true;
            </script>

            <div class="form-group">
              <div class="col-sm-12 text-center">
                <?php
                echo $this->Form->submit(
                  'Submit',
                  array('class' => 'btn btn-success', 'title' => 'Submit')
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
<script>
  $(document).ready(function() { //alert();
    $('#talentusers').change(function() { //alert();
      var username = $('#talentusers').val();
      //alert(username);
      $.ajax({
        type: 'POST',
        url: '<?php echo SITE_URL; ?>/talentadmin/checktalent',
        data: {
          'username': username
        },
        success: function(data) {
          console.log(data);
          obj = JSON.parse(data);


          if (obj.name == 'Y') {
            $('#talentusers').val('');
            $('#talenthere').show();
            $('.usrname').val('');
            $("#talentheres").html(obj.user_name);
          } else if (obj.id == null) {
            $('#passwordblank').show();
            $('#talenthere').hide();

            $('#nontalentpartnerid').val('');
          } else {

            $('#talenthere').hide();
            if (obj.country) {
              $("#state").find('option').remove();
              var dataString = 'id=' + obj.country;
              $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>/talentadmin/getStates',
                data: dataString,
                cache: false,
                success: function(html) {
                  $('<option>').val('0').text('--Select State--').appendTo($("#state"));
                  $.each(html, function(key, value) {
                    $('<option>').val(key).text(value).appendTo($("#state"));
                  });
                  $('#state').val(obj.state);
                }
              });

              $("#city").find('option').remove();
              var dataStrings = 'id=' + obj.state;
              $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>/talentadmin/getcities',
                data: dataStrings,
                cache: false,
                success: function(htmls) {
                  $('<option>').val('0').text('--Select City--').appendTo($("#city"));
                  $.each(htmls, function(keys, values) {
                    $('<option>').val(keys).text(values).appendTo($("#city"));
                  });
                  $('#city').val(obj.city);
                }
              });

            }


            $('.country').removeAttr('value');

            $('.usrname').val(obj.name);
            $('#nontalentpartnerid').val(obj.id);
            $('.country').val(obj.country);

            $('.country').change(function() {

              $('#state').val(obj.state);
              $('#city').val(obj.city);

            });

          }
        },
      });
    });
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $("#country_ids").on('change', function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      $("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/talentadmin/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val('0').text('--Select City--').appendTo($("#city"));
            $('<option>').val('0').text('--Select State--').appendTo($("#state"));
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
            $('<option>').val('0').text('--Select City--').appendTo($("#city"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          }
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    var uname = '<?php echo $packentity['user_name']; ?>';
    var uemail = '<?php echo $packentity['email']; ?>';
    if (uname != "") {
      $(".usern").attr("readonly", "true");
    }

    if (uemail != "") {
      $(".uemail").attr("readonly", "true");
    }
  });
</script>