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
            <h3 class="box-title">List</h3>
          </div>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>


          <div class="box-body  table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>



                <tr>
                  <th>S.no</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Banner Url</th>
                  <th>From Date</th>
                  <th>End Date</th>
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
                  foreach ($banners as $bannerdata) {   // pr($bannerdata);
                ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>" />
                        <!--<a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL 
                                                                      ?>profile/details/<?php //echo $talentdata['id']; 
                                                                                                                ?>" style="color:blue;"><?php //echo $talentdata['user_name']; 
                                                                                                                                                                        ?></a>-->
                      </td>
                      <td> <?php echo $bannerdata['title']; ?></td>
                      <td> <?php echo $bannerdata['bannerurl']; ?></td>

                      <td><?php echo date('Y-m-d H:m:s', strtotime($bannerdata['banner_date_from'])); ?></td>
                      <td><?php echo date('Y-m-d H:m:s', strtotime($bannerdata['banner_date_to'])); ?></td>
                      <td>
                        <?php if ($bannerdata['status'] == 'N') { ?>
                          <a data-toggle="modal" class='label label-success  data' href="<?php echo ADMIN_URL ?>banner/approve/<?php echo $bannerdata['id']; ?>" style="color:blue;">Approve</a>
                          <a data-toggle="modal" class='label label-primary  data' href="<?php echo ADMIN_URL ?>banner/reject/<?php echo $bannerdata['id']; ?>" style="color:blue;">Reject</a>
                        <?php } elseif ($bannerdata['status'] == 'R') { ?>
                          <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Rejected</a>

                        <?php } else { ?>
                          <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Approved</a>

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