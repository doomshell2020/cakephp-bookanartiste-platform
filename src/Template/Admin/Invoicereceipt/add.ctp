<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Invoice And Receipt  
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><?php if(isset($invoicereceipt['id'])){ echo 'Edit Percentage Details'; }else{ echo 'Update Percentage';} ?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->

          <?php echo $this->Flash->render(); ?>

          <?php echo $this->Form->create($invoicereceipt, array(

           'class'=>'form-horizontal',
           'id' => 'sevice_form',
           'enctype' => 'multipart/form-data',
           'action'=>'add'
           )); ?>

           <div class="box-body">
            <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $invoicereceipt['title']; ?></label>
              <div class="field col-sm-2">
                <?php echo $this->Form->input('tax_percentage', array('class' => 
                'longinput form-control','maxlength'=>'3','type'=>'text','required','placeholder'=>$invoicereceipt['title'].' in %','value'=>$invoicereceipt['tax_percentage'],'label'=>false)); ?>
              </div>
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?php
          echo $this->Html->link('Back', [
            'action' => 'index'

            ],['class'=>'btn btn-default']); ?>

          <?php
          if(isset($invoicereceipt['id'])){
            echo $this->Form->submit(
              'Update', 
              array('class' => 'btn btn-info pull-right', 'title' => 'Update')
              ); }else{ 
              echo $this->Form->submit(
                'Add', 
                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                );
            }
            ?>
          </div>
          <!-- /.box-footer -->
          <?php echo $this->Form->end(); ?>
        </div>

      </div>
    </section>     <!--/.col (right) -->
  </div>
  <!-- /.row -->

