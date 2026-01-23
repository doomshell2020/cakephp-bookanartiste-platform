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
      Payment Made
    </h1>
    <?php echo $this->Flash->render(); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">



        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>


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
                      url: "<?php echo ADMIN_URL; ?>talentadmin/searchpaidtransaction"
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


                <div class="col-sm-3">
                  <label>From</label>
                  <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
                </div>

                <div class="col-sm-3">
                  <label>To</label>
                  <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
                </div>

                <div class="col-sm-2">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Name">
                </div>

                <div class="col-sm-2">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter Email">
                </div>

                <div class="col-sm-4">
                  </br>
                  <button type="submit" class="btn btn-success">Search</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <a class="btn btn-primary label-success" href="<?php echo SITE_URL; ?>/admin/talentadmin/exportpaidtrans">Export to Excel</a>
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
          </div>

          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th>Talent Partner Name</th>
                  <th>Email id</th>
                  <th>Creator Name</th>
                  <th>Creator Email id</th>
                  <th>Membership from</th>
                  <th>Talent Partner from</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="example2">
                <?php
                $counter = 1;

                //pr($talents); die;

                if (isset($talents) && !empty($talents)) {
                  foreach ($talents as $admin) {   //pr($admin); 

                    $talent_admin_id = $admin['user_id'];
                ?>
                    <tr>

                      <td><?php echo $counter; ?></td>
                      <td>
                        <?php if (isset($admin['talent_admin_name'])) {
                          echo $admin['talent_admin_name'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>
                      <td>
                        <?php if (isset($admin['talent_admin_email'])) {
                          echo $admin['talent_admin_email'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>


                      <td>
                        <?php if ($admin['talent_creator_id'] != 0) {
                          echo $admin['talent_creator_name'];
                        } else {
                          echo 'Admin';
                        } ?>
                      </td>
                      <td>
                        <?php if ($admin['talent_creator_id'] != 0) {
                          echo $admin['talent_creator_email'];
                        } else {
                          echo 'Admin';
                        } ?>
                      </td>
                      <td><?php if (isset($admin['membership_from'])) {
                            echo date('d-M-Y', strtotime($admin['membership_from']));
                          } else {
                            echo 'N/A';
                          } ?></td>
                      <td><?php if (isset($admin['talent_from'])) {
                            echo date('d-M-Y', strtotime($admin['talent_from']));
                          } else {
                            echo 'N/A';
                          } ?></td>
                      <td>
                        <?php echo $admin['write_notes']; ?>
                      </td>
                      <td>
                        <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminid('<?php echo $admin['id']; ?>','<?php echo $admin['write_notes']; ?>')">
                          <button class="btn btn-primary">
                            <?php if ($admin['amount'] > 0) {
                              echo "$" . $admin['amount'];
                            } else {
                              echo '-';
                            } ?> Paid</button>
                        </a>

                      </td>
                    </tr>

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

<div class="modal fade" id="myalbum-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Update Payout Information</h4>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create($packentity, array('url' => array('controller' => 'talentadmin', 'action' => 'paidtransaction'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
        <div class="form-group">
          <label class="control-label col-sm-2">Change Note :</label>
          <div class="col-sm-10">
            <?php echo $this->Form->input('write_notes', array('class' => 'form-control', 'placeholder' => 'Write the invoice raised by talent manager, or any observations', 'id' => 'wrnote', 'required', 'label' => false)); ?>
            <input type="hidden" id="talent_admin_id" name="talent_admin_id" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="text-center col-sm-12">
            <button id="btn" type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>

          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>



<script>
  function assigntalentadminid(talent_admin_id, note) {
    $('#talent_admin_id').val(talent_admin_id);
    $('#wrnote').val(note);
  }

  $('.payout').click(function(e) {
    e.preventDefault();
    $('#myalbum-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
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


<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script>
  $(function() {

    var dateFormat = 'dd-mm-yy',
      from = $("#datepicker1")
      .datepicker({
        dateFormat: 'dd-mm-yy',

        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#datepicker2").datepicker({
        dateFormat: 'dd-mm-yy',

        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }
  });
</script>