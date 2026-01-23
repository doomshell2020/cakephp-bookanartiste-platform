<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Banner Package</h1>
    <?php echo $this->Flash->render(); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Banner Package List</h3>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="clearfix">
                  <a href="<?php echo ADMIN_URL; ?>bannerpack/add">
                    <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                      Add Banner Packages </button>
                    </a>
                  </div>
                  <div class="box-body">
                    <table id="" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Package name</th>
                          <th>Cost Per Day</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php 
                        $counter=1;
                        if(isset($Profilepack) && !empty($Profilepack)){ 
                          foreach($Profilepack as $pack){

                            ?>
                            <tr>
                              <td><?php echo $counter; ?></td>
                              <td><?php if(isset($pack['id'])){ echo $pack['name'];}else{ echo 'N/A'; } ?></td>
                              <td>
                                <?php if(isset($pack['cost_per_day'])){ echo $pack['cost_per_day'];}else{ echo 'N/A'; } ?></td>

                                
                                <td><?php if($pack['status']=='Y'){ 
                                  echo $this->Html->link('Deactivate', [
                                    'action' => 'status',
                                    $pack['id'],
                                    $pack['status']  
                                    ],['class'=>'label label-success']);

                                }else{ 
                                  echo $this->Html->link('Activate', [
                                    'action' => 'status',
                                    $pack['id'],
                                    $pack['status']
                                    ],['class'=>'label label-primary']);

                                    echo $this->Html->link('Delete', ['action' => 'delete', $pack['id']],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]);
                                  } ?>
                                  
                                  <?php
                                  echo $this->Html->link('Edit', [
                                    'action' => 'add',
                                    $pack->id
                                    ],['class'=>'btn btn-primary']); ?>

                                  <!-- <?php// echo $this->Html->link('Delete', ['action' => 'delete', $pack['id']],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?> -->
           

                                  </td>
                                </tr>
                                <?php $counter++; } } else{ ?>
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

