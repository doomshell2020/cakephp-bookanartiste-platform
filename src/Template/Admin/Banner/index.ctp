<?php
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
                      url: "<?php echo ADMIN_URL; ?>banner/search"
                    });
                    return false;
                  });
                });
                //]]>
              </script>
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

                <div class="col-sm-2">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="" selected="selected">All</option>
                    <option value="N">Pending</option>
                    <option value="Y">Approved</option>
                    <option value="R">Declined</option>
                  </select>
                </div>

                <div class="col-sm-3">
                  <br>
                  <button type="submit" class="btn btn-success">Search</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <a href="<?php echo ADMIN_URL; ?>banner/bannerexcel" type="reset" class="btn btn-warning ">Export Excel</a>

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
          <div class="box-header">
            <h3 class="box-title">List</h3>
            <a href="<?php echo ADMIN_URL; ?>banner/createbanner" type="reset" class="btn btn-success pull-right">Create A Banner</a>
          </div>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>


          <div class="box-body  table-responsive">
            <table id="example" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.no</th>
                  <th>Image</th>
                  <th>Banner Title</th>
                  <th>Banner URL</th>
                  <th>From Date</th>
                  <th>End Date</th>
                  <th>Total Price</th>
                  <th>Requested By</th>
                  <th>Requested By EMail id</th>
                  <th>Status</th>
                  <th width="103px;">Action</th>
                </tr>
              </thead>

              <style>
                #example2 .pne {
                  position: relative;
                  overflow: hidden;
                }

                #example2 .pne .p_new {
                  width: 87px;
                  height: 71px;
                  position: absolute;
                  background: url(../images/newarrival-icon.PNG) no-repeat;
                  z-index: 9999;
                  left: -5px;
                  top: -3px;
                }
              </style>
              <tbody id="example2">
                <?php
                $counter = 1;
                if (isset($banners) && !empty($banners)) {

                  foreach ($banners as $bannerdata) {    //pr($bannerdata);
                    $fromdate = date('Y-m-d h:i:s', strtotime($bannerdata['banner_date_from']));
                    $todate = date('Y-m-d h:i:s', strtotime($bannerdata['banner_date_to']));
                    $banneramt = $bannerdata['amount'];

                ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <a target="_blank" href="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>" style="color:blue;">
                          <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>" />
                        </a>
                      </td>
                      <td> <?php echo $bannerdata['title']; ?></td>
                      <td> <?php echo $bannerdata['bannerurl']; ?></td>

                      <td><?php if ($bannerdata['banner_date_from']) {
                            echo date("M d Y h:i:sa", strtotime($fromdate));
                          } else {
                            echo "--";
                          } ?></td>
                      <td><?php if ($bannerdata['banner_date_to']) {
                            echo date("M d Y h:i:sa", strtotime($todate));
                          } else {
                            echo "--";
                          } ?></td>
                      <td><?php echo "$" . $banneramt; ?></td>
                      <td><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bannerdata['user_id']; ?>">

                          <?php
                          if ($bannerdata['user']['role_id'] == 1) {
                            echo $bannerdata['user']['user_name'] . "(Admin)";
                          } else {
                            echo $bannerdata['user']['user_name'];
                          }


                          ?>
                        </a></td>
                      <td><?php echo $bannerdata['user']['email']; ?></td>
                      <td>
                        <?php if ($bannerdata['status'] == 'N' && $bannerdata['banner_status'] == 'Y') { ?>
                          <a class='label label-danger' href="<?php echo ADMIN_URL ?>banner/status/<?php echo $bannerdata['id']; ?>/Y">Inactive</a>
                        <?php } ?>

                        <?php if ($bannerdata['status'] == 'Y' && $bannerdata['banner_status'] == 'Y') { ?>
                          <a class='label label-success' href="<?php echo ADMIN_URL ?>banner/status/<?php echo $bannerdata['id']; ?>/N">Active</a>
                        <?php } ?>
                      </td>

                      <?php if ($bannerdata['auto_decline'] == 0) { ?>
                        <td>
                          <?php if ($bannerdata['status'] == 'N' && $bannerdata['banner_status'] == 'Y') { ?>
                            <?php if ($bannerdata['is_approved'] == 1) { ?>
                              <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Approved</a>
                              <a class='label label-danger' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>">Delete</a>
                            <?php } else { ?>
                              <a class='label label-success' href="<?php echo ADMIN_URL ?>banner/banneramount/<?php echo $bannerdata['id'] . "/" . $banneramt; ?>" style="color:blue;">Approve</a>

                              <a data-toggle="modal" class='label label-primary  data' href="<?php echo ADMIN_URL ?>banner/reject/<?php echo $bannerdata['id']; ?>" style="color:blue;">Decline</a>
                            <?php } ?>

                          <?php } elseif ($bannerdata['status'] == 'R') { ?>
                            <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Declined</a>

                          <?php } else { ?>
                            <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Approved</a>

                          <?php } ?>

                          <?php
                          $currenttime = date("Y-m-d h:i:s");
                          if ($currenttime > $todate) {
                          ?>
                            <a class='label label-danger' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>">Delete</a>
                            <a class='label label-warning' href="<?php echo ADMIN_URL ?>banner/editbanner/<?php echo $bannerdata['id']; ?>">Edit</a>
                          <?php
                          }

                          ?>

                        </td>
                      <?php } else { ?>
                        <td>
                          <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Auto Declined</a>

                          <?php
                          $currenttime = date("Y-m-d h:i:s");
                          if ($currenttime > $todate) {
                          ?><br>
                            <a class='label label-danger' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>">Delete</a>
                            <a class='label label-warning' href="<?php echo ADMIN_URL ?>banner/editbanner/<?php echo $bannerdata['id']; ?>">Edit</a>
                          <?php } ?>

                          <br>
                          <p><?php echo $bannerdata['decline_reason']; ?></p>
                        </td>
                      <?php } ?>

                    </tr>

                  <?php $counter++;
                  }
                } else { ?>
                  <tr>
                    <td colspan="11" align="center">No Data Available</td>
                  </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>
          <!-- /.box-body -->
          <script>
            $(document).ready(function() {
              $(".globalModals").click(function(event) {
                $('.modal-content').load($(this).attr("href"));
              });
            });
          </script>
          <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="loader">
                    <div class="es-spinner">
                      <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                  </div>
                </div>
              </div>
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