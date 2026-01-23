<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			Job  
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
                        <h3 class="box-title"><?php if(isset($Country['id'])){ echo 'Edit Job '; }else{ echo 'Add Job  ';} ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <?php echo $this->Flash->render(); ?>

                        <?php echo $this->Form->create($Genre, array(

                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                     	)); ?>

                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Skill Name</label>
                                    <div class="field col-sm-6">
                                        <?php echo $this->Form->input('skills_id', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Country Name','required','label'=>false,'type'=>'select','options'=>$skill)); ?>
                                    </div>
                                </div>
                                   <div class="form-group">
                                    <label class="col-sm-3 control-label">Genre Name</label>
                                    <div class="field col-sm-6">
                                        <?php echo $this->Form->input('name', array('class' => 
                    'longinput form-control','maxlength'=>'20','required','placeholder'=>'Genre Name','required','label'=>false)); ?>
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
				if(isset($transports['id'])){
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

