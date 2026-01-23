 
<!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2>Personal <span> Detail</span></h2>
      <div class="row">
          

        <div class="tab-content">
        <div class="profile-bg m-top-20">
	    <?php echo $this->Flash->render(); ?>
          <div id="Personal" class="tab-pane fade in active">
            <div class="container m-top-60">
         <?php echo $this->Form->create($bankinginformation,array('url' => array('controller' => 'talentadmin', 'action' => 'personaldetail'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
                
	
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Country:</label>
	    <div class="col-sm-9">
		 <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','required'=>true,'label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">State:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>array())); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">City:</label>
	    <div class="col-sm-9">
		  <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','required'=>true,'options'=>array())); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Email:</label>
	    <div class="col-sm-9">
		  <?php echo $this->Form->input('personalemail',array('class'=>'form-control','placeholder'=>'Email','type'=>'email','label' =>false,'required'=>true)); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	
	<div class="form-group">
	    <div class="col-sm-8 text-center">
	    <button id="btn" type="submit" class="btn btn-default">Submit</button>
	    </div>
	</div>
           <?php echo $this->Form->end(); ?>
            </div>
          </div>
    </div>
        </div>
      </div>
    </div>
  </section>

  
    <script type="text/javascript">
    $(document).ready(function() {
	$("#country_ids").on('change',function() {
	    var id = $(this).val();
	    changestate(id);    
	});
	
    
	

	$("#state").on('change',function() {
		var id = $(this).val();	
		changecity(id);
	});
    });
    
    // Change Country function 
    function changecity(id)
    {
	current_city = '<?php echo $bankinginformation['city_id'];  ?>';
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
				    if(current_city==key)
				    {
					$('<option selected=selected>').val(key).text(value).appendTo($("#city"));
				    }
				    else
				    {
					$('<option>').val(key).text(value).appendTo($("#city"));
				    }
			    });
		    } 
	    });
	}
    }
    
    
    // Change State fucntion
    function changestate(id)
    {
	current_state = '<?php echo $bankinginformation['state_id'];  ?>';
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
			if(key==current_state)
			{
			    $('<option selected=selected>').val(key).text(value).appendTo($("#state"));
			}
			else
			{
			    $('<option>').val(key).text(value).appendTo($("#state"));
			}
		    });
		} 
	    });
	}
    }
    
    changestate('<?php echo $bankinginformation['country_id'];  ?>');   
    changecity('<?php echo $bankinginformation['state_id'];  ?>');
    </script>
  
