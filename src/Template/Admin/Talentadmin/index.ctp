<?php
foreach ($country as $country_data) {
  $country_id = $country_data['Country']['id'];
  $countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Talent Partners
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php echo $this->Flash->render(); ?>
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">

            <h3 class="box-title"> Advance Search </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <div class="manag-stu">

              <script inline="1">
                //<![CDATA[
                $(document).ready(function() {
                  $("#TaskAdminCustomerForm").bind("submit", function(event) {
                    $.ajax({
                      async: true,
                      data: $("#TaskAdminCustomerForm").serialize(),
                      dataType: "html",

                      success: function(data, textStatus) {

                        $("#example2").html(data);
                      },
                      type: "POST",
                      url: "<?php echo ADMIN_URL; ?>talentadmin/search"
                    });
                    return false;
                  });
                });
                //]]>
              </script>
              <style>
                .dataTables_filter,
                .dataTables_info {
                  display: none;
                }
              </style>

              <?php echo $this->Form->create('Task', array('url' => array('controller' => 'products', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>

              <div class="form-group">



                <div class="col-sm-4">
                  <label>Country</label>
                  <?php echo $this->Form->input('country_id', array('class' => 'form-control', 'placeholder' => 'Country', 'id' => 'country_ids', 'label' => false, 'empty' => '--Select Country--', 'options' => $countryarr)); ?>
                </div>

                <div class="col-sm-4">
                  <label>State</label>
                  <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', 'label' => false, 'empty' => '--Select State--', 'options' => $states)); ?>
                </div>

                <div class="col-sm-4">
                  <label>City</label>
                  <?php echo $this->Form->input('city_id', array('class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'label' => false, 'empty' => '--Select City--', 'options' => $cities)); ?>
                </div>
              </div>
              <div class="form-group">

                <div class="col-sm-4">
                  <label>User Type</label>
                  <select class="form-control" name="user_type">
                    <option value="" selected="selected">-All-</option>
                    <option value="<?php echo TALANT_ROLEID; ?>">Talent</option>
                    <option value="<?php echo NONTALANT_ROLEID; ?>">Non Talent</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label>Skills</label>
                  <div style="display: flex;">
                  <input type="text" class="form-control" name="skillshow" id="skillshow" placeholder="Skills">
                  <a style="    margin-top: 0px; margin-left: 5px;" data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL ?>/admin/talentadmin/skills/<?php echo $packentity['id']; ?>">Add Skills</a>
                  </div>
                  

                </div>

                <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",", $array); ?>" />

                <div class="col-sm-4">
                  <label>Name</label>
                  <input type="text" class="form-control" name="talent_name" placeholder="Enter Name">
                </div>

                <div class="col-sm-4">
                  </br>
                  <button type="submit" class="btn btn-success">Search</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <a class="btn btn-primary label-success" href="<?php echo SITE_URL; ?>/admin/talentadmin/exporttalentadmin">Export to Excel</a>
                </div>
              </div>
              <?php
              echo $this->Form->end();
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="clearfix">
            <a href="<?php echo SITE_URL; ?>/admin/talentadmin/add">
              <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                Add Talent Admin </button></a>


            <a href="<?php echo SITE_URL; ?>/admin/talentadmin/comissionmanager">
              <button class="btn btn-primary label-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                Commission Manager </button></a>
          </div>
          <div class="box-body">
            <table id="example" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center">S.no</th>
                  <th rowspan="2" class="text-center">Name</th>
                  <th rowspan="2" class="text-center">Contact Number</th>
                  <th rowspan="2" class="text-center">Country</th>
                  <th rowspan="2" class="text-center">State</th>
                  <th rowspan="2" class="text-center">City</th>
                  <th rowspan="2" class="text-center">Created By</th>
                  <th rowspan="2" class="text-center">Total</th>
                  <th colspan="2" class="text-center">Profiles Uploaded</th>
                  <th rowspan="2" class="text-center">Talent Partner from</th>
                  <th rowspan="2" class="text-center">Action</th>
                </tr>
                <tr>
                  <th>Registered</th>
                  <th>Non Registered</th>
                </tr>
              </thead>
              <tbody id="example2">
                <?php
                $counter = 1;

                //pr($talents); die;

                if (isset($talents) && !empty($talents)) {
                  foreach ($talents as $admin) {   //pr($admin);
                    if ($admin['talentdadmin_id'] == 0) {
                      $talentId = 1;
                    } else {
                      $talentId = $admin['talentdadmin_id'];
                    }
                    $talentadminname = $this->Comman->talentadminname($talentId);
                    $talentpartnersrefers = $this->Comman->talentpartnersrefers($admin['user_id']);
                    $profiledata = $this->Comman->profilphone($admin['user_id']);
                    //pr($profiledata);
                ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <a data-toggle="modal" class='bankdata<?php echo $counter; ?>' href="javascript:void();" style="color:blue;">
                          <?php if (isset($admin['user_name'])) {
                            echo $admin['user_name'];
                          } else {
                            echo 'N/A';
                          } ?>
                        </a>
                      </td>

                      <td>
                        <?php
                        if (isset($profiledata)) {

                          if (!empty($profiledata['altnumber'])) {
                            echo '+' . $profiledata['phonecode'] . '-' . $profiledata['phone'];
                            $removespace = str_replace(' ', '', $profiledata['altnumber']);
                            $altphone = explode(",", $removespace);
                            foreach ($altphone as $altphonevalue) {
                              echo "<br> +" . $profiledata['phonecode'] . "-" . $altphonevalue;
                            }
                          } else {
                            echo "-";
                          }
                        } else {
                          echo 'N/A';
                        }
                        ?>

                      </td>

                      <td>
                        <?php if (isset($admin['country'])) {
                          echo $admin['country'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>

                      <td>
                        <?php if (isset($admin['state'])) {
                          echo $admin['state'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>

                      <td>
                        <?php if (isset($admin['city'])) {
                          echo $admin['city'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>
                      <!-- <td><?php //if(isset($admin['skill_name'])){ echo $admin['skill_name'];}else{ echo 'N/A'; } 
                                ?></td> -->
                      <td>
                        <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $talentadminname['id']; ?>" target="_blank">
                          <?php if ($admin['talentdadmin_id'] != 0) { ?>

                            <?php
                            //pr($talentadminname);
                            if (isset($talentadminname['profile']['name'])) {
                              if ($talentadminname['role_id'] != 1) {
                                echo $talentadminname['profile']['name'];
                              } else {
                                echo "Anirudh (Admin)";
                              }
                            } else {
                              if ($talentadminname['role_id'] != 1) {
                                echo $talentadminname['user_name'];
                              } else {
                                echo "Anirudh (Admin)";
                              }
                            } ?>

                          <?php } else {
                            if (isset($talentadminname['profile']['name'])) {
                              if ($talentadminname['role_id'] != 1) {
                                echo $talentadminname['profile']['name'];
                              } else {
                                echo "Anirudh (Admin)";
                              }
                            } else {
                              if ($talentadminname['role_id'] != 1) {
                                echo $talentadminname['user_name'];
                              } else {
                                echo "Anirudh (Admin)";
                              }
                            }
                          } ?>
                        </a>
                      </td>
                      <td><?php echo count($talentpartnersrefers); ?></td>
                      <td><?php $i = 0;
                          $v = 0;
                          foreach ($talentpartnersrefers as $key => $referValue) {
                            if ($referValue['status'] == 'Y') {
                              $i++;
                            } else {
                              $v++;
                            }
                          }
                          //echo '('.$i.' / '.count($talentpartnersrefers).')';
                          echo $i;
                          ?>

                      </td>

                      <td>
                        <?php $v = 0;
                        foreach ($talentpartnersrefers as $key => $referValues) {
                          if ($referValues['status'] == 'N') {
                            $v++;
                          }
                        }
                        //echo '('.$v.' / '.count($talentpartnersrefers).')';
                        echo $v;
                        ?>
                      </td>
                      <td><?php if (isset($admin['talent_from'])) {
                            echo date('d M Y', strtotime($admin['talent_from']));
                          } else {
                            echo 'N/A';
                          } ?></td>
                      <td>
                        <?php
                        /* echo $this->Html->link('Commission Manager', [
			    'action' => 'transcations',
			    $admin['user_id']
         ],['class'=>'btn btn-primary']); */ ?>

                        <?php
                        echo $this->Html->link('Edit', [
                          'action' => 'add',
                          $admin['user_id']
                        ], ['class' => 'btn btn-primary']); ?>
                        <br>
                        <?php
                        echo $this->Html->link('Delete', [
                          'action' => 'delete',
                          $admin['id']
                        ], ['class' => 'btn btn-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                        <br>
                        <a data-toggle="modal" class='btn btn-success bankdata<?php echo $counter; ?>' href="javascript:void();">Bank Detail</a>
                        <br>

                      </td>
                    </tr>
                    <script>
                      $('.bankdata<?php echo $counter; ?>').click(function(e) {
                        e.preventDefault();
                        $('#globalModal<?php echo $counter; ?>').modal('show').find('.modal-body').load($(this).attr('href'));
                      });
                    </script>

                  <?php $counter++;
                  }
                } else { ?>
                  <tr>
                    <td colspan="11" align="center">NO Data Available</td>
                  </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>
          <!-- /.box-body -->
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
<?php $i = 1;
foreach ($talents as $admins) {  ?>
  <div id="globalModal<?php echo $i; ?>" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="text-center">Bank Details Of <?php echo  ucfirst($admins['user_name']); ?></h4>
          <div>
            <h4>Bank Name: <small> <?php echo $admins['bank_name']; ?></small></h4>
            <h4>Bank Account No.: <small><?php echo $admins['bank_account_no']; ?></small></h4>
            <h4>Bank Branch Address: <small><?php echo $admins['bank_branch_add']; ?></small></h4>
            <h4>Country: <small><?php echo $admins['bankcountry']; ?></small></h4>
            <h4>State: <small><?php echo $admins['bankstate']; ?></small></h4>
            <h4>City: <small><?php echo $admins['bankcity']; ?></small></h4>
            <h4>Swift Code: <small><?php echo $admins['swift_code']; ?></small></h4>
            <h4>IBAN Number: <small><?php echo $admins['iban_number']; ?></small></h4>
            <h4>BSB Code: <small><?php echo $admins['bsb_code']; ?></small></h4>
            <h4>IFSC Code: <small><?php echo $admins['ifsc_code']; ?></small></h4>
            <h4>Payment Getway: <small><?php echo $admins['payment_getway']; ?></small></h4>
            <h4>important Information: <small><?php echo $admins['important_info']; ?></small></h4>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php $i++;
} ?>

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
  $('.skill').click(function(e) {

    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>

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
          url: '<?php echo SITE_URL; ?>/admin/talentadmin/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("Select State").appendTo($("#state"));
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
          url: '<?php echo SITE_URL; ?>/admin/talentadmin/getcities',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("Select City").appendTo($("#city"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          }
        });
      }
    });
  });
</script>