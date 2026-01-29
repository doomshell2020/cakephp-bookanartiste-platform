<div class="content-wrapper">
  <!--breadcrumb -->
  <section class="content-header">
    <h1>
      Job Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>/admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>/admin/genre">Genre</a></li>
    </ol>
  </section>

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
                      url: "<?php echo ADMIN_URL; ?>job/search"
                    });
                    return false;
                  });
                });
                //]]>
              </script>
              <?php echo $this->Form->create('Task', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>


              <div class="form-group">

                <div class="col-sm-3">
                  <label>From</label>
                  <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
                </div>

                <div class="col-sm-3">
                  <label>To</label>
                  <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
                </div>

                <div class="col-sm-3">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Name">
                </div>

                <div class="col-sm-3">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter Email">
                </div>

                <div class="col-sm-3">
                  <label>Posted By</label>
                  <select class="form-control" name="postedby">
                    <option value="" selected="selected">All</option>
                    <option value="2">Talent</option>
                    <option value="3">Non-Talent</option>
                  </select>
                </div>


                <div class="col-sm-3">
                  <label>Posting Type</label>
                  <select class="form-control" name="postingtype">
                    <option value="" selected="selected">All</option>
                    <option value="F">Free Posting</option>
                    <option value="P">Paid Posting Option</option>
                    <option value="R">Recruiter package</option>
                    <option value="PR">Profile and Recruiter package</option>
                  </select>
                </div>

                <div class="col-sm-3">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="" selected="selected">All</option>
                    <option value="Y">Active</option>
                    <option value="N">Inactive</option>
                  </select>
                </div>

                <div class="col-sm-12">
                  <br>
                  <button type="submit" class="btn btn-success">Search</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <a href="<?php echo ADMIN_URL; ?>job/requirmentexcel" type="reset" class="btn btn-warning pull-right">Export Excel</a>

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
            <h3 class="box-title">Job Manager</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="example1" width="100%" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Job Title</th>
                  <th>Talent Requirement</th>
                  <th>Job type</th>
                  <th>Posting Type</th>
                  <th>Posted By Name</th>
                  <th>Posted By Email Id</th>
                  <th>Posted by (Talent type)</th>
                  <th>Advertised Number of Days</th>
                  <th>Featured Number of Days</th>
                  <th>Bill Amount Paid</th>
                  <th>Status</th>
                  <th>Featured</th>
                  <th width="103px;">Action</th>
                </tr>
              </thead>
              <tbody id="example2">
                <?php $page = $this->request->params['paging']['classes']['page'];
                $limit = $this->request->params['paging']['classes']['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if (isset($Job) && !empty($Job)) {
                  foreach ($Job as $Job) {   //pr($job); 
                    $currentdate = date('Y-m-d H:m:s');
                    $lastdate = date('Y-m-d H:m:s', strtotime($Job['last_date_app']));
                    $expiredate = date('Y-m-d H:m:s', strtotime($Job['expiredate']));
                ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <!-- <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $Job['id']; ?>" target="_blank"><?php echo $Job['title']; ?></a> -->
                        <a href="<?php echo SITE_URL; ?>/jobdetails/<?php echo $Job['id']; ?>" target="_blank"><?php echo $Job['title']; ?></a>
                      </td>
                      <td>
                        <a class="globalModals" href="<?php echo SITE_URL; ?>/admin/job/details/<?php echo $Job['id'] ?>" data-target="#globalModal" data-toggle="modal"> View</a>
                      </td>
                      <td>
                        <?php if ($Job['continuejob'] == 'Y') {
                          echo "Continuous";
                        } else {
                          echo "Non continuous";
                        } ?>
                        <?php //echo $Job['eventtype']['name']; 
                        ?>
                      </td>

                      <td>
                        <?php if ($Job['Posting_type']) {
                          echo $Job['Posting_type'];
                        } else {
                          echo "---";
                        } ?>
                      </td>

                      <td>
                        <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $Job['user']['id']; ?>" target="_blank"><?php echo $Job['user']['user_name']; ?></a>
                      </td>
                      <td>
                        <?php echo $Job['user']['email']; ?>
                      </td>
                      <td>
                        <?php if ($Job['user']['role_id'] == '2') {
                          echo "Talent";
                        } else {
                          echo "Non Talent";
                        }
                        ?>
                      </td>

                      <td>
                        <?php $jobdetail = $this->Comman->jobdetail($Job['id']);
                        //pr($jobdetail); //die;
                        $fromdate = date('Y-m-d', strtotime($jobdetail['ad_date_from']));
                        $todate = date('Y-m-d', strtotime($jobdetail['ad_date_to']));
                        $date1 = date_create($fromdate);
                        $date2 = date_create($todate);
                        $diff = date_diff($date1, $date2);
                        $bannerdays = $diff->days;
                        if (!empty($bannerdays)) {
                          echo $bannerdays . " Days";
                        } else {
                          echo "0 Day";
                        }
                        ?>

                      </td>

                      <td>
                        <?php
                        echo $Job['feature_job_days'] . " Days";
                        ?>
                      </td>

                      <td>
                        <?php if ($Job['featuredjob']) {
                          echo "$" . $Job['feature_job_days'] * $Job['featuredjob']['price'];
                        } else {
                          echo "0";
                        }
                        ?>
                      </td>

                      <td>
                        <?php
                        if ($lastdate >= $currentdate) { ?>
                          <span class="label label-success">Active</span>
                        <?php } else { ?>
                          <span class="label label-primary">Inactive</span>
                        <?php }
                        ?>
                      </td>

                      <td>

                        <?php if ($Job['status'] == 'N' || $lastdate < $currentdate) {  ?>
                          <img src="<?php echo SITE_URL; ?>/nof.png" style="width:16px " />
                        <?php
                        } elseif ($expiredate > $currentdate) {  ?>
                          <a href="<?php echo SITE_URL; ?>/admin/job/setdefult/<?php echo $Job['id'] ?>/N">
                            <img src="<?php echo SITE_URL; ?>/yf.png" style="width:16px " />
                          </a>
                        <?php } else { ?>
                          <a href="<?php echo SITE_URL; ?>/admin/job/setdefult/<?php echo $Job['id'] ?>/Y">
                            <img src="<?php echo SITE_URL; ?>/nof.png" style="width:16px " />
                        </a>
                        <?php } ?>

                      </td>


                      <td>

                        <a href="<?php echo ADMIN_URL; ?>job/delete/<?= $Job['id'] ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')">
                          <img src="<?php echo SITE_URL; ?>/img/del.png" style="width:16px ">
                        </a>

                        <?php if ($lastdate >= $currentdate) { ?>
                          <?php
                          if ($Job['status'] == 'Y') {

                            echo $this->Html->link('Deactivate', [
                              'action' => 'status',
                              $Job['id'],
                              $Job['status']
                            ], ['class' => 'label label-success']);
                          } else {
                            echo $this->Html->link('Activate', [
                              'action' => 'status',
                              $Job['id'],
                              $Job['status']
                            ], ['class' => 'label label-primary']);
                          }
                          ?>
                        <?php } ?>

                      </td>
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




<div id="myModal" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>



<script>
  $('.globalModals').click(function(e) {

    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>



<div id="myModal2" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>



<script>
  $('.viewads').click(function(e) {

    e.preventDefault();
    $('#myModal2').modal('show').find('.modal-body').load($(this).attr('href'));
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