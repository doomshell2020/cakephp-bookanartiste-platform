<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Requirement Package
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
                        <h3 class="box-title"><?php if (isset($Requirement['id'])) {
                                                    echo 'Edit Requirement Package Details';
                                                } else {
                                                    echo 'Add Requirement Package Details';
                                                } ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <?php echo $this->Flash->render(); ?>

                    <?php echo $this->Form->create($Requirement, array(

                        'class' => 'form-horizontal',
                        'id' => 'sevice_form',
                        'enctype' => 'multipart/form-data'
                    )); ?>

                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Package Name</label>
                            <div class="field col-sm-6">
                                <?php echo $this->Form->input('name', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Package Name', 'required', 'label' => false)); ?>
                            </div>
                        </div>


                        <div class="form-group">

                            <label class="col-sm-3 control-label">Number of Days</label>

                            <div class="field col-sm-6">

                                <?php echo $this->Form->input('number_of_days', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                            </div>

                        </div>



                        <div class="form-group">

                            <label class="col-sm-3 control-label">Number of Talent type</label>

                            <div class="field col-sm-6">

                                <?php echo $this->Form->input('number_of_talent_type', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Talent type', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                            </div>

                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label">Price</label>
                            <div class="field col-sm-6">

                                <?php echo $this->Form->input('price', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Price', 'required', 'label' => false, 'type' => 'text', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Package Text</label>
                            <div class="field col-sm-5">
                                <?php echo $this->Form->input('packagetext', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'placeholder' => 'Package Text',  'label' => false, 'type' => 'text')); ?>
                            </div>
                        </div>


                        <div class="form-group">

                            <label class="col-sm-3 control-label">Priorities </label>

                            <div class="field col-sm-6">

                                <?php echo $this->Form->input('priorites', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Priorities', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                            </div>

                        </div>


                    </div>


                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    echo $this->Html->link('Back', [
                        'action' => 'index'

                    ], ['class' => 'btn btn-default']); ?>

                    <?php
                    if (isset($Requirement['id'])) {
                        echo $this->Form->submit(
                            'Update',
                            array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                        );
                    } else {
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
    </section> <!--/.col (right) -->
</div>
<!-- /.row -->