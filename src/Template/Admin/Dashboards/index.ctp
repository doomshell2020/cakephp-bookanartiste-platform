 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Talents</span>
              <span class="info-box-number"><?php echo $total_talents; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-university"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Non Talents</span>
              <span class="info-box-number"><?php echo $total_nontalents; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-suitcase"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jobs</span>
              <span class="info-box-number"><?php echo $total_jobs; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Payments</span>
              <span class="info-box-number"><?php echo $total_payments; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                
                <!-- /.col -->
              <div class="col-md-8">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Members</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><?php echo count($latest_members); ?> New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php foreach($latest_members as $members){ ?>
                    <li>
                      <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $members['profile']['profile_image']; ?>" onerror="this.src='<?php echo SITE_URL; ?>/no-image.jpg';" alt="<?php echo $members['profile']['name']; ?>">
                      <a class="users-list-name" href="#"><?php echo $members['profile']['name']; ?></a>
                      <span class="users-list-date"><?php //echo $members['created']->time(); ?></span>
                    </li>
                    <?php }?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
               
                <!-- /.box-footer -->
              </div>
              <!--/.box -->



<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Jobs</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Location</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  //pr($latest_jobs); die;
                  foreach ($latest_jobs as $jobs) { ?>
                  <tr>
                    <td><?php echo $jobs['id']; ?></td>
                    <td><?php echo $jobs['title']; ?></td>
                    <td><?php echo $jobs['event_from_date']; ?></td>
                    <td><?php echo $jobs['event_to_date']; ?></td>
                    <td><?php echo $jobs['city']['name']; ?>,<?php echo $jobs['state']['name']; ?>,<?php echo $jobs['country']['name']; ?></td>
                  </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?php echo SITE_URL; ?>/admin/job/" class="btn btn-sm btn-default btn-flat pull-right">View All Jobs</a>
            </div>
            <!-- /.box-footer -->
          </div>












            </div>

<div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-paper-plane-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sent Quotes</span>
              <span class="info-box-number">0</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
                
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Quote Requests</span>
              <span class="info-box-number">0</span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
                  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-comments"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Messages</span>
              <span class="info-box-number">0</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-floppy-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Saved Searches</span>
              <span class="info-box-number">0</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
                  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <!-- /.box -->
        </div>

                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <!-- /.col -->

        
        <!-- /.col -->
      </div>




    

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ChartJS 1.0.1 -->
<script src="<?php echo SITE_URL; ?>/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo SITE_URL; ?>/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->

