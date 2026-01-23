<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile Package

    </h1>
    <?php echo $this->Flash->render(); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Package List</h3>
          </div>

          <!-- /.box-header -->

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="clearfix">
                  <a href="<?php echo SITE_URL; ?>/admin/profilepack/add">
                    <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                      Add Profile Packages </button></a>

                </div>
                <div class="box-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.no</th>
                        <th>Package name</th>
                        <th>Number Of Days</th>
                        <th>Package Cost</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($Profilepack) && !empty($Profilepack)) {
                        $counter = 1;
                        foreach ($Profilepack as $pack) {
                          // pr($pack);exit;
                      ?>
                          <tr>
                            <td><?php echo $counter; ?></td>
                            <td>

                              <a data-toggle="modal" class='pack' href="<?php echo ADMIN_URL ?>profilepack/profilepackdata/<?php echo $pack['id']; ?>" style="color:#1e89d9;">
                                <?php if (isset($pack['id'])) {
                                  echo $pack['name'];
                                } else {
                                  echo 'N/A';
                                } ?>
                              </a>


                            </td>
                            <td><?php if (isset($pack['validity_days'])) {
                                  echo $pack['validity_days'];
                                } else {
                                  echo '0';
                                } ?></td>
                            <td>$<?php if (isset($pack['price'])) {
                                    echo $pack['price'];
                                  } else {
                                    echo '0';
                                  } ?></td>


                            <td><?php if ($pack['status'] == 'Y') {
                                  echo $this->Html->link('Activate', [
                                    'action' => 'status',
                                    $pack['id'], 'N'
                                  ], ['class' => 'label label-success']);
                                } else {
                                  echo $this->Html->link('Deactivate', [
                                    'action' => 'status',
                                    $pack['id'], 'Y'
                                  ], ['class' => 'label label-primary']);
                                } ?></td>

                            <td><?php
                                echo $this->Html->link('Edit', [
                                  'action' => 'add',
                                  $pack->id
                                ], ['class' => 'btn btn-primary']); ?>
                                                      <?php  /*
                              echo $this->Html->link('View', [
                                  'action' => 'view',
                                  $pack->id
                              ],['class'=>'btn btn-success']); */ ?>
                                                      <?php

                              //pr($pack);exit;
                              if ($pack['id'] != 1) {
                                echo $this->Html->link('Delete', [
                                  'action' => 'delete',
                                  $pack->id
                                ], ['class' => 'btn btn-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]);
                              } ?></td>
                          </tr>
                        <?php $counter++;
                        }
                      } else { ?>
                        <tr>
                          <td>NO Data Available</td>
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
  $('.pack').click(function(e) {

    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });
</script>