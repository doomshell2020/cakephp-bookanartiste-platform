  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
  <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Template Manager
		      </h1>
<ol class="breadcrumb">
		<li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo SITE_URL; ?>admin/templates">Manage Template</a></li>
<li class="active">Create New Template</li>
	      </ol>
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if(isset($templates['id'])){ echo 'Edit Template'; }else{ echo 'Add Template';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
		<?php echo $this->Form->create($templates, array(
                       
                       'class'=>'form-horizontal',
			          'id' => 'student_form',
                       'enctype' => 'multipart/form-data',
                       'validate'
                     	)); ?>

  
  
  
    <div class="box-body">
  
  <div class="form-group">
    
    <div class="col-sm-6">
    <label for="inputEmail3" class="control-label">Title<span style="color:red;">*</span></label>
    <?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Title','required'=>true, 'id'=>'title','label' =>false)); ?>
    <input type="hidden" name="id" value="<?php echo $templates['id']; ?>">
    </div> 
   
      <div class="col-sm-6">
    <label for="inputEmail3" class="control-label">Subject<span style="color:red;">*</span></label>
    <?php echo $this->Form->input('subject',array('class'=>'form-control','placeholder'=>' Enter Subject','required'=>true,'label' =>false)); ?>
    </div>
  </div>
       <div class="form-group">
      <div class="col-sm-8">
           <label>Description</label>
  <textarea name="description"  id="summernote"  placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if($templates->description){ echo $templates->description; } ?></textarea>
                </div>
            
  </div
  </div>
  
  

  <!-- /.box-body -->
		      <div class="box-footer">
		
		      
			<?php
				if(isset($templates['id'])){
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
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
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
<script>
  $(function () {
    CKEDITOR.replace('editor1');
  });
 </script>  



