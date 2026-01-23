<style type="text/css">
  
#myInput {
    background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>
<?php 

foreach ($skillofcontaint as $key => $value) {
$array[]=$value['skill_id'];
$array1[]=$value['skill']['name'];
}
 ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Content Admin
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
		      <h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Content Admin '; }else{ echo 'Add Content Admin ';} ?></h3>
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
					<label class="col-sm-3 control-label">Name</label>
					<div class="field col-sm-6">
					<?php echo $this->Form->input('user_name', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Name','required','readonly','label'=>false,)); ?></div>
             </div>
             
               	 <div class="form-group">
					<label class="col-sm-3 control-label">Email</label>
					<div class="field col-sm-6">
					
					<?php echo $this->Form->input('email', array('class' => 
					'longinput form-control','maxlength'=>'50','required','placeholder'=>'Email','required','readonly','label'=>false)); ?>

                                        </div>
             </div>
                
            <div class="form-group">
                    <label class="col-sm-3 control-label">Country</label>
                    <div class="field col-sm-6">
                
                    <?php echo $this->Form->input('country',array('class'=>'form-control','placeholder'=>'Country','maxlength'=>'25','id'=>'country_ids','required','label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
                    
                    </div>

             </div>
             <div class="form-group">

                    <label class="col-sm-3 control-label">Skills</label>
                    
                    <div class="field col-sm-6">
                    
                  
                      <?php echo $this->Form->input('skillshow', array('class' => 
                    'longinput form-control','maxlength'=>'20','required','placeholder'=>'Skills','required','label'=>false,'value'=>implode(",",$array1))); ?>

                     <a  data-toggle="modal" class='skill btn btn-success pull-right' href="<?php echo ADMIN_URL?>contentadmin/skills/<?php echo $packentity['id'] ?>">Add Skills</a>
                    
                    </div>
                        
             </div>
             
          
               
             <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/>
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
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>





  <!-- /.content-wrapper -->
  
  <!-- Daynamic modal -->
<div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content" >
       <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
         <div class="modal-body" id="skillsetsearch"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->


<script>
 $('.skill').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});



</script>
