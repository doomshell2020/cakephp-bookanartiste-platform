  
<!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2>Edit <span>Profile</span></h2>
      <p class="m-bott-50">Here You Can Create Your Profile</p>
      <div class="row">
      <?php echo  $this->element('editprofile') ?>

        <div class="tab-content">
          <?php echo $this->Flash->render(); ?>
          <div id="Pro-Summary" class="">
            <div class="container m-top-60">
         <?php echo $this->Form->create($proff,array('url' => array('controller' => 'profile', 'action' => 'professionalsummary'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
              <?php  // pr($proff); ?>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Profile Title</label>
                  <div class="col-sm-6">
                   <?php echo $this->Form->input('profile_title',array('class'=>'form-control','placeholder'=>'Profile Title','maxlength'=>'25','id'=>'name','required'=>true,'label' =>false)); ?>	
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Month:</label>
                  <?php
// set the month array
$formattedMonthArray = array(
                    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
                    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
                    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
                );?>
                  <div class="col-sm-3">
                   <?php echo $this->Form->input('performing_month',array('class'=>'form-control','maxlength'=>'25','required'=>true,'label' =>false,'empty'=>'--Select Month--','options'=>$formattedMonthArray)); ?>
                  
                  </div>
                  <label for="" class="col-sm-1 control-label">Year:</label>
                  <div class="col-sm-3">
					  <?php                               
$yearArray = range(1948, date("Y"));
?>
                <select name="performing_year" class="form-control" required>
    <option value="">--Select Year--</option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
   $selected = ($year == $proff['performing_year']) ? 'selected' : '';
        echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
    }
    ?>
</select>
                  </div>
                  <div class="col-sm-3"></div>
                </div>
                
                
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Are You A :</label>
                  <?php $gen= array('P'=>'Professional','A'=>'Amateur','PT'=>'Part time','H'=>'Hobbyist'); ?>
                  <div class="col-sm-8">
                    <?php echo $this->Form->input('areyoua',array('class'=>'form-control','maxlength'=>'25','id'=>'gender','type'=>'radio','required'=>true,'options'=>$gen,'label' =>false,'legend'=>false,'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'])); ?>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Book An Artiste Link:</label>
                  <div class="col-sm-6">
					   <?php echo $this->Form->input('artistelink',array('class'=>'form-control','placeholder'=>'Artiste Link','maxlength'=>'25','id'=>'name','required'=>true,'label' =>false)); ?>	
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Role/Designation Name:</label>
                  <div class="col-sm-6">
                    <?php echo $this->Form->input('designation',array('class'=>'form-control','placeholder'=>'Designation','required'=>true,'label' =>false)); ?>	
                  </div>
                  <div class="col-sm-4"></div>
                </div>
               
               
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Location :</label>
                  <div class="col-sm-6">
					   <input id="pac-input" type="text" class="form-control" placeholder="Location" required>
                    <div id="map"></div>  
<?php echo $this->Form->input('lat',array('class'=>'form-control','type'=>'hidden','id'=>'latitude','required','label' =>false)); ?>
<?php echo $this->Form->input('longs',array('class'=>'form-control','type'=>'hidden','id'=>'longitude','required','label' =>false)); ?>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Description :</label>
                  <div class="col-sm-6">  <?php echo $this->Form->input('description',array('class'=>'form','placeholder'=>'Description','required'=>true,'label' =>false,'type'=>'textarea' )); ?>	
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                  <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Date From:</label>
                  
                  <div class="col-sm-3">
                    <?php echo $this->Form->input('datefrommonth',array('class'=>'form-control','maxlength'=>'25','required'=>true,'label' =>false,'empty'=>'--Select Month--','options'=>$formattedMonthArray)); ?>
					    <?php                               
$yearArray = range(1948, date("Y"));
?></div> 
<div class="col-sm-3">
                <select name="datefromyear" class="form-control" required>
    <option value="">--Select Year--</option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
		   $selected = ($year == $proff['datefromyear']) ? 'selected' : '';
        echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
    }
    ?>
</select>
                  </div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Date To:</label>
                  
                  <div class="col-sm-3">
                    <?php echo $this->Form->input('datetomonth',array('class'=>'form-control','maxlength'=>'25','required'=>true,'label' =>false,'empty'=>'--Select Month--','options'=>$formattedMonthArray)); ?>
					    <?php                               
$yearArray = range(1948, date("Y"));
?></div> 
<div class="col-sm-3">
                <select name="datetoyear" class="form-control" required>
    <option value="">--Select Year--</option>
    <?php
    foreach ($yearArray as $year) {
		   $selected = ($year == $proff['datetoyear']) ? 'selected' : '';

		echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
    }
    ?>
</select>
                  </div>
                    <div class="col-sm-4"></div>
                </div>
                
                  <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Agency Name :</label>
                  <div class="col-sm-6">
		<?php echo $this->Form->input('agency_name',array('class'=>'form-control','placeholder'=>'Agency Name','maxlength'=>'25','required'=>true,'label' =>false)); ?>	
                 
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Talent Manager Name :</label>
                  <div class="col-sm-6">
                 <?php echo $this->Form->input('talent_manager',array('class'=>'form-control','placeholder'=>'Talent Manager Name','maxlength'=>'25','required'=>true,'label' =>false)); ?>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
            
               <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Manage Portfolio:</label>
                  <div class="col-sm-6">
                 <?php echo $this->Form->input('talent_managerlink',array('class'=>'form-control','placeholder'=>'Manage Portfolio','maxlength'=>'25','required'=>true,'label' =>false)); ?>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
               
                
                <div class="form-group">
                <div class="col-sm-12">
                <div class="table-responsive">
					 <div class="multi-field-wrapper">
						 <?php $typ=array('S'=>'Social','C'=>'Company','P'=>'Personal','B'=>'Blog'); ?>
  <table class="table table-bordered">
<thead>
  <tr>
   <th>URL</th> 
  <th>Type</th>
  <th>Delete</th>
  
  </tr>
  </thead>
  
  <tbody class="video_container">
	  <?php if(count($videoprofile)>0)
								{ ?>
							   <?php foreach($videoprofile as $prop){ //pr($prop);?>	
  <tr class="video_details">
    
  <td> <?php echo $this->Form->input('weblink',array('value'=>$prop['web_link'],'class'=>'form-control','placeholder'=>'Skills','maxlength'=>'25','id'=>'name','required'=>true,'label' =>false,'name'=>'data[weblink][]')); ?>
  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/></td>
   <td><?php echo $this->Form->input('webtype',array('value'=>$prop['web_type'],'class'=>'form-control','placeholder'=>'State','maxlength'=>'25','id'=>'','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>$typ,'selected'=>'selected','name'=>'data[webtype][]')); ?></td>

  <td><button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button></td>
  
  </tr>
 <?php }}else{ ?>
	 
	 
	  <tr class="video_details">
    
  <td> <?php echo $this->Form->input('weblink',array('class'=>'form-control','placeholder'=>'Skills','maxlength'=>'25','id'=>'name','required'=>true,'label' =>false,'name'=>'data[weblink][]')); ?>
  <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/></td>
   <td><?php echo $this->Form->input('webtype',array('class'=>'form-control','placeholder'=>'State','maxlength'=>'25','id'=>'','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>$typ,'selected'=>'selected','name'=>'data[webtype][]')); ?></td>

  <td><button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button></td>
  
  </tr>
	 
	 <?php } ?>
  
  </tbody>

  
  <tfoot>
  <tr>
  <td colspan="7" style="text-align:right"><a class="btn-primary add-field pull-right">Add </a></td>
  
  </tr>
  
  
  </tfoot>
  </table>
</div>
                
                </div>
                
                
                
                
                </div>
                
                
                
                </div>
               
               
               
               
              
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Sign in</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          
        
        </div>
      </div>
    </div>
  </section>
  <script>
function showResult(result) {
    document.getElementById('latitude').value = result.geometry.location.lat();
    document.getElementById('longitude').value = result.geometry.location.lng();
}
function getLatitudeLongitude(callback, address) {
    // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
    address = address || 'Ferrol, Galicia, Spain';
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0]);
            }
        });
    }
}
	$("#pac-input").on('change',function() {
    var address = document.getElementById('pac-input').value;
    getLatitudeLongitude(showResult, address)
});

</script>

<script>
		var site_url='<?php echo SITE_URL;?>/';

function delete_detials(obj){

        $.ajax({
        type: "post",
        url: site_url+'profile/deleteproffessional',
        data:{datadd:obj},
       
        success:function(data){ 
	 	    }
           
        });
   }
</script>

 <script>
	
    
	
	
$('.multi-field-wrapper').each(function() { 
    var $wrapper = $('.video_container', this);
    $(".add-field", $(this)).click(function(e) { 
        $('.video_details:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.remove-field', $wrapper).click(function() {
        if ($('.video_details', $wrapper).length > 1)
            $(this).closest('.video_details').remove();
    });
});
	</script>
