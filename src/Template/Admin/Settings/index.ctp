<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Setting Manager</h1>
            <?php echo $this->Flash->render(); ?>
    </section>

        <!-- Main content -->
      <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Setting List</h3>
                        </div>

            <div class="row">
                  <div class="col-xs-12">
                        <div class="box">
                            <div class="clearfix"></div>
                            <div class="box-body">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>S.no</th>
                                <th>Block After</th>
                                <th>Unblock Within </th>

                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                          <?php 
                          if(isset($settingdetails) && !empty($settingdetails)){ 
                            $counter=1;
                          foreach($settingdetails as $pack){
                            //pr($pack);

                          ?>
                          <tr>
                          <td><?php echo $counter; ?></td>
                          <td><?php if(isset($pack['block_after_days'])){ echo $pack['block_after_days'];}else{ echo 'N/A'; } ?></td>
                          <td>
                          <?php if(isset($pack['unblock_within'])){ echo $pack['unblock_within'];}else{ echo 'N/A'; } ?></td>

                          <td><?php if($pack['status']=='Y'){ 
                          echo $this->Html->link('Activate', [
                          'action' => 'status',
                          $pack['id'],
                          $pack['status']  
                          ],['class'=>'label label-success']);

                          }else{ 
                          echo $this->Html->link('Deactivate', [
                          'action' => 'status',
                          $pack['id'],
                          $pack['status']
                          ],['class'=>'label label-primary']);

                          } ?>
                          </td>

                          <td>
                          <?php
                          echo $this->Html->link('Edit', [
                          'action' => 'add',
                          $pack->id
                          ],['class'=>'btn btn-primary']); ?>

                          </td>
                          </tr>
                          <?php $counter++;} } else{ ?>
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