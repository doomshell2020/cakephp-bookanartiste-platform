
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Talent Sub Admin
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
		      <h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Talent Admin '; }else{ echo 'Add  Talent Sub Admin ';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

    

		<?php echo $this->Form->create($packentity, array(
                       
                       'class'=>'form-horizontal',
			'id' => 'content_admin',
                       'enctype' => 'multipart/form-data',
                     	'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>
		   
		      <div class="box-body">
		    
                <div class="form-group">
          <label class="col-sm-3 control-label">Talent Admin</label>
          <div class="field col-sm-6">
          
          
            <select class="form-control" name="talent_admin" required="">
            <option>Select Talent Admin</option>
            <?php for($i=0;$i<count($telantadmin);$i++){
             ?>
                <option value="<?php echo $telantadmin[$i]['id'] ?>" <?php if($packentity->talent_admin==$telantadmin[$i]['id']){echo "selected";} ?>><?php  echo $telantadmin[$i]['user_name'] ?></option>

            <?php } ?>      

            </select>

          </div>
             </div>

           	 <div class="form-group">
					<label class="col-sm-3 control-label">Name</label>
					<div class="field col-sm-6">
					<?php echo $this->Form->input('user_name', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Name','required','label'=>false,)); ?></div>
             </div>
             
               	 <div class="form-group">
					<label class="col-sm-3 control-label">Username</label>
					<div class="field col-sm-6">
					
					<?php echo $this->Form->input('email', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Username','required','label'=>false)); ?>

                                        </div>
             </div>
                
            <div class="form-group">

                    <label class="col-sm-3 control-label">Password</label>
                    <?php if(isset($packentity['id'])){ ?>

                       <div class="field col-sm-6">
                    
                    <?php echo $this->Form->input('passedit', array('class' => 
                    'longinput form-control','maxlength'=>'20','label'=>false)); ?>
                    
                    </div>
                    <?php } else{ ?>
 
                    <div class="field col-sm-6">
                    
                    <?php echo $this->Form->input('password', array('class' => 
                    'longinput form-control','maxlength'=>'20','required','placeholder'=>'***','required','label'=>false)); ?>
                    
                    </div>

                    <?php } ?>

            </div>
            
              <div class="form-group">

                    <label class="col-sm-3 control-label">Cpassword</label>
                     <?php if(isset($packentity['id'])){ ?>

                       <div class="field col-sm-6">
                    
                    <?php echo $this->Form->input('confirmpassedit', array('class' => 
                    'longinput form-control','maxlength'=>'20','label'=>false)); ?>
                    
                    </div>
                    <?php } else { ?>
                    <div class="field col-sm-6">
                    
                    <?php echo $this->Form->input('confirmpassd', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>'***','label'=>false,'type'=>'password')); ?>
                    
                    </div>

                     <?php } ?> 

             </div>
      
             
          
               

                </div><!--content-->
                
            
		     
			 
		      <!-- /.form group -->
		        
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
         
      
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

