<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Job Advertisement Package 
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
                    <h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Job Advertisement Package'; }else{ echo 'Add Job Advertisement Package';} ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <?php echo $this->Flash->render(); ?>

                <?php echo $this->Form->create($packentity, array(

                 'class'=>'form-horizontal',
                 'id' => 'sevice_form',
                 'enctype' => 'multipart/form-data'
                 )); ?>

                 <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Package Name</label>
                        <div class="field col-sm-6">
                            <?php echo $this->Form->input('name', array('class' => 
                            'longinput form-control','maxlength'=>'20','required','placeholder'=>'Packagename','required','label'=>false)); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cost per day</label>
                        <div class="field col-sm-6">

                            <?php echo $this->Form->input('cost_per_day', array('class' => 
                            'longinput form-control','maxlength'=>'20','required','placeholder'=>'Cost per day','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>

                        </div>
                    </div>

                </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php
                echo $this->Html->link('Back', [
                 'action' => 'index'

                 ],['class'=>'btn btn-default pull-left']); ?>

                <?php
                if(isset($packentity['id'])){
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

