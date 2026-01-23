
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Talent Sub Admin
		      </h1>
	    </section>
 <?php 
foreach ($skillofcontaint as $key => $value) {
//pr($value);
$array[]=$value['skill_id'];
$array1[]=$value['skill']['name'];
}

//pr($profile);
 ?>
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
          
          <?php //pr($talentsubadmin); ?>
            <select class="form-control" name="talent_admin" required>
            <option>Select Talent Admin</option>
            <?php for($i=0;$i<count($telantadmin);$i++){
             ?>
                <option value="<?php echo $telantadmin[$i]['id'] ?>" <?php if($talentsubadmin['talent_admin'][0]['talentdadmin_id']==$telantadmin[$i]['id']){echo "selected";} ?>><?php  echo $telantadmin[$i]['user_name'] ?></option>

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
      
             <div class="form-group">

                    <label class="col-sm-3 control-label">Country</label>
                       <div class="field col-sm-6">
                    <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','required'=>true,'label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
                    
                    </div>
                   

             </div>
      
      
       <div class="form-group">

                    <label class="col-sm-3 control-label">State</label>
                 

                       <div class="field col-sm-6">
                    
                   <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
                    
                    </div>
                    

             </div>
      
      <div class="form-group">

                    <label class="col-sm-3 control-label">City</label>
                 

                       <div class="field col-sm-6">
                    
                   <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','required'=>true,'options'=>$cities)); ?>
                    
                    </div>
                  

             </div>
       <div class="form-group">

                    <label class="col-sm-3 control-label">Commission</label>
                 

                       <div class="field col-sm-6">
                    
                   <?php echo $this->Form->input('commission',array('class'=>'form-control','placeholder'=>'Commission','required'=>true,'id'=>'comm','label' =>false,'type'=>'number','value'=>$talentsubadmin['talent_admin'][0]['commision'])); ?>
                    
                    </div>
                  

             </div>
             
             
             
             
             
              <div class="form-group">

                    <label class="col-sm-3 control-label">Skills</label>
                 

                       <div class="field col-sm-6">
                    
                   <?php echo $this->Form->input('skillshow', array('class' => 
                    'longinput form-control','maxlength'=>'200','required'=>true,'placeholder'=>'Skills','label'=>false,'value'=>implode(", ",$array1))); ?>
         
                    </div>
                   <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentsubadmin/skills/<?php echo $packentity['id']; ?>">Add Skills</a>
      <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> 
             </div>
             
             
             

               
     
             
          
               

                </div><!--content-->
                
             <!-- Modal -->
  
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
<script type="text/javascript">
	$(document).ready(function() {
		$("#country_ids").on('change',function() {
			var id = $(this).val();
			$("#state").find('option').remove();
			//$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentsubadmin/getStates',
					data: dataString,
					cache: false,
					success: function(html) {
						$.each(html, function(key, value) {        
							$('<option>').val(key).text(value).appendTo($("#state"));
						});
					} 
				});
			}
		});
 
		$("#state").on('change',function() {
			var id = $(this).val();
			$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentsubadmin/getcities',
					data: dataString,
					cache: false,
					success: function(html) {
						$.each(html, function(key, value) {              
							$('<option>').val(key).text(value).appendTo($("#city"));
						});
					} 
				});
			}	
		});
	});
</script>

