<!----------------------editprofile-strt----------------------->
<?php 
foreach ($skillofcontaint as $key => $value) {
    $array[]=$value['skill_id'];
    $array1[]=$value['skill']['name'];
}
?>
 
<section id="page_signup">
  <div class="container">
    <div class="row">
      
      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Create Talent Partner </h2>
                    		<?php echo $this->Flash->render(); ?>

          <?php echo $this->Form->create($packentity,array('url' => array('controller' => 'talentadmin', 'action' => 'talentadd'),'inputDefaults'=> array(
'class'=>'form-horizontal',
'id' => 'content_admin',
'enctype' => 'multipart/form-data',
'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>
          <div class="box-body">
        
          <div class="form-group">
            <label class="col-sm-3 control-label">Name
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('user_name', array('class' => 
'longinput form-control','required','placeholder'=>'Name','required','label'=>false,)); ?>
 <input type="hidden" name="talent_admin" value="<?php echo $this->request->session()->read('Auth.User.id'); ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('email', array('class' => 
'longinput form-control','required','placeholder'=>'Email','required','label'=>false)); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Password
            </label>
            <?php if(isset($packentity['id'])){ ?>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('passedit', array('class' => 
'longinput form-control','label'=>false)); ?>
            </div>
            <?php } else{ ?>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('password', array('class' => 
'longinput form-control','required','placeholder'=>'***','required','label'=>false)); ?>
            </div>
            <?php } ?>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Cpassword
            </label>
            <?php if(isset($packentity['id'])){ ?>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('confirmpassedit', array('class' => 
'longinput form-control','label'=>false)); ?>
            </div>
            <?php } else { ?>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('confirmpassd', array('class' => 'longinput form-control','required','placeholder'=>'***','label'=>false,'type'=>'password')); ?>
            </div>
            <?php } ?> 
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Country
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','required'=>true,'label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">State
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">City
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','required'=>true,'options'=>$cities)); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Commission
            </label>
            <div class="field col-sm-6">
              <select class="form-control" name="commission" required>
		<option value="">Select commision percentage</option>
		<?php  
		    for($c=1;$c<=50;$c++)
		    {
		?>
		<option value="<?php echo $c; ?>" if($c==$talentsubadmin['talent_admin'][0]['commision']){ echo "selected=selected"; }><?php echo $c; ?></option>
		
		<?php }?>
              </select>
              
              
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Skills
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('skillshow', array('class' => 
'longinput form-control','maxlength'=>'200','required'=>true,'placeholder'=>'Skills','label'=>false,'value'=>implode(", ",$array1))); ?>
            </div>
            <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentsubadmin/skills/<?php echo $packentity['id']; ?>">Add Skills
            </a>
            <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> 
          </div>
          
	<div class="form-group">
	    <label class="col-sm-3 control-label"></label>
	    <div class="field col-sm-6">
		<input type="hidden" value="N" name="enable_create_subadmin">
	  <label>	<input type="checkbox" id="checktalpartner" value="Y" name="enable_create_subadmin" <?php if($packentity['talent_admin'][0]['enable_create_subadmin']=='Y'){ echo "checked"; }?>> Can Create Talent Partners</label>
	    </div>
	</div>
          
            <script>
				radiobtn = document.getElementById("checktalpartner");
radiobtn.checked = true;	
</script>
          
	<div class="form-group">
	    <div class="col-sm-12 text-center">
		<?php 
		    echo $this->Form->submit(
		    'Submit', 
		    array('class' => 'btn btn-primary', 'title' => 'Submit')
		    );
		?>
		</div>
	    </div>
	</div>
    
        <!--content-->
        <!-- Modal -->
        <div id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content" >
              <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
              <div class="modal-body" id="skillsetsearch">
              </div>
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
          }
                           );
        </script>
        <!-- /.form group -->
      </div>
      <!-- /.box-body -->

      <!-- /.box-footer -->
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
  
  </div>
</div>
</section>



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
				url: '<?php echo SITE_URL;?>/talentadmin/getStates',
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
				url: '<?php echo SITE_URL;?>/talentadmin/getcities',
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
