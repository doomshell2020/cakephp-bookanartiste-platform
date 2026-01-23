
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Currency
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
		      <h3 class="box-title"><?php if(isset($Currency['id'])){ echo 'Edit Currency  '; }else{ echo 'Add Currency  ';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

    

		<?php echo $this->Form->create($Currency, array(
                       
                       'class'=>'form-horizontal',
			            'id' => 'content_admin',
                       'enctype' => 'multipart/form-data',
                     	'autocomplete'=>'off')); ?>
		   
		      <div class="box-body">
		    
                
           	 <div class="form-group">
					<label class="col-sm-3 control-label">Currency Name</label>
					<div class="field col-sm-6">
					<?php echo $this->Form->input('name', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Currency name','required','label'=>false,)); ?></div>
             </div>

              <div class="form-group">
					<label class="col-sm-3 control-label">Currency Code</label>
					<div class="field col-sm-6">
					<?php echo $this->Form->input('currencycode', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Currency Code','required','label'=>false,)); ?></div>
             </div>
             
          <!-- /.form group -->
		        
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
		      
			<?php
				if(isset($Currency['id'])){
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
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
