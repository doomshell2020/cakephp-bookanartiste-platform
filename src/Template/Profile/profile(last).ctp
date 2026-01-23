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
foreach ($languageknow as $key => $value) {
	$languagearray[]= $value['language_id'];
	//pr($tes); 
}
?>
  <?php 
foreach ($skillofcontaint as $key => $value) {
//pr($value);
$array[]=$value['skill_id'];
$array1[]=$value['skill']['name'];
}

//pr($profile);
 ?>

<link href="<?php echo SITE_URL; ?>/css/imgareaselect-default.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery.awesome-cropper.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  

  <section id="edit_profile">
    <div class="container">
		<?php if(count($skillofcontaint) > 0){ ?>
    	<h2><span>Profile</span></h2>

      <?php }else{ ?>
      <h2>Non Talent <span>Profile</span></h2>
	 <?php  } ?>
		
		
      <p class="m-bott-50">Here You Can Create Your Profile</p>
      <div class="row">
                 <?php echo  $this->element('editprofile') ?>

        <div class="tab-content">
        <div class="profile-bg m-top-20">
	    <?php echo $this->Flash->render(); ?>
          <div id="Personal" class="tab-pane fade in active">
            <div class="container m-top-60">
         <?php echo $this->Form->create($profile,array('url' => array('controller' => 'profile', 'action' => 'profile'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'profile_form','autocomplete'=>'off')); ?>
                
                   <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Personal E-mail :</label>
                  <div class="col-sm-9">
					  
					  <?php echo $this->Form->email('altemail',array('class'=>'form-control','required'=>true,'autocomplete'=>'off','id'=>'altemail','label' =>false,'type'=>'email','value'=>$this->request->session()->read('Auth.User.email'),'readonly'=>'readonly')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Profile image :</label>
                  <div class="col-sm-2 upload-img text-center">
			<?php if ($profile['profile_image']!=''){ ?>
				<img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile['profile_image']; ?>"/>
				<?php }else{ ?>
					<img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
					
					<?php  } ?>
				
    <div><a href="#"><div class="input-file-container">
	<input id="sample_input" type="hidden" name="profile_image">
	<label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
	<span id="ncpyss" style= "display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
    </div>
                  
                    </a>
                    
                    
                    </div>
					  
                  </div>
                  
                
               
                  <div class="col-sm-3"> 
                    <!-- <input type="file" class="upload">-->
                    
                    
                    <p class="file-return"></p>
                  </div>
                </div>
                
                
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Member Name :</label>
                  <div class="col-sm-9">
					  
					  <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Member Name','maxlength'=>'25','id'=>'name','required'=>true,'label' =>false,'value'=>$profile['user']['user_name'])); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
					<?php $gen= array('m'=>'Male','f'=>'Female','o'=>'Other','bmf'=>'Male And Female'); ?>
                  <label for="" class="col-sm-2 control-label">Gender :</label>
                  <div class="col-sm-9">
					
 
                       <?php echo $this->Form->input('gender',array('class'=>'form-control','maxlength'=>'25','id'=>'gender','type'=>'radio','required','options'=>$gen,'label' =>false,'legend'=>false,'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'],'required'=>true)); ?>
                      
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                 
                 <?php if($profile['dob']!=''){ ?>
                  <label for="" class="col-sm-2 control-label">Date Of Birth  :</label>
                  <div class="col-sm-4">
					  
					  <?php $dateget= date('Y-m-d',strtotime($profile['dob'])); ?>
					  <?php echo $this->Form->input('dob',array('class'=>'form-control','placeholder'=>'DateOfBirth','maxlength'=>'25','type'=>'text','id'=>'dobpicker','label' =>false,'value'=>$dateget,'readonly'=>'readonly')); ?>

                  </div>
             
                  
                  <label for="" class="col-sm-1 control-label">Age  :</label>
                  <div class="col-sm-4">
					  <div class="form-control" id="age"></div>
                   <!-- <input type="text" class="form-control" >-->
                  </div>
                  <?php }else{ ?>
					  
					    <label for="" class="col-sm-2 control-label">Date Of Birth  :</label>
                  <div class="col-sm-4">
					  
					  <?php echo $this->Form->input('dob',array('class'=>'form-control','placeholder'=>'DateOfBirth','maxlength'=>'25','type'=>'text','id'=>'dobpicker','label' =>false,'readonly'=>'readonly')); ?>

                  </div>
             
                  
                  <label for="" class="col-sm-1 control-label">Age  :</label>
                  <div class="col-sm-4">
					  <div class="form-control" id="age"></div>
                   <!-- <input type="text" class="form-control" >-->
                  </div>
					  
					  <?php } ?>
                  
                  <div class="col-sm-1"></div>
                  
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Language(s) known :</label>
                  <div class="col-sm-9 leng_box">
		<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple" name="languageknow[]" required>
			
		<?php foreach($lang as $key=>$value){ //pr($value);?>
			
		     <option value="<?php echo $value['id']; ?>"<?php if(in_array($value['id'], $languagearray)){ ?> selected <?php }?>><?php echo $value['name']; ?></option>
		<?php } ?>
		</select>
</div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Ethnicity :</label>
                  <div class="col-sm-9">
                             <?php echo $this->Form->input('ethnicity',array('class'=>'form-control','placeholder'=>'State','maxlength'=>'25','id'=>'','required','label' =>false,'empty'=>'--Select Ethnicity--','options'=>$ethnicity,'selected'=>'selected')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-9">
                       <?php echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Country','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'--Select Country--','options'=>$country)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Phone Number :</label>
                  
                      <div class="col-sm-4">
						  <?php echo $this->Form->input('phonecode',array('class'=>'form-control','placeholder'=>'Phone Code','id'=>'phonecode','required'=>true,'label' =>false,'type'=>'text','readonly'=>true)); ?>
<!--<div class="form-control" id="phonecode"></div>-->
        <!--    <input type="text" id="phonecode" placeholder="Skills">-->
                      </div>
                  <div class="col-sm-5">
<?php echo $this->Form->input('phone',array('class'=>'form-control','placeholder'=>'Phone Number','maxlength'=>'25','id'=>'altnumber','required','label' =>false,'type'=>'tel','pattern'=>'^\d{10}$')); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Skills :</label>
                  <div class="col-sm-8">
					   <?php echo $this->Form->input('skillshow', array('class' => 
                    'longinput form-control','maxlength'=>'20','placeholder'=>'Skills','readonly'=>'readonly','label'=>false,'value'=>implode(", ",$array1))); ?>

                <!--    <input type="text" class="form-control" placeholder="Skills">-->
                  </div>
                  <?php	$uid=$this->request->session()->read('Auth.User.id');?>
                  <div class="col-sm-2 text-left p-left-0">  <a  data-toggle="modal" class='skill btn btn-success ' href="<?php echo SITE_URL?>/profile/skills/<?php echo $uid; ?>">Add Skills</a>
                  <input type="hidden" id="elegible_category" value="<?php echo  count($array); ?>"/> </div>
                  <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> </div>
                
              
               <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Current Location :</label>
                  <div class="col-sm-9">

                 <?php echo $this->Form->input('current_location', array('class' => 
                    'longinput form-control','placeholder'=>'Location','label'=>false,'id'=>'pac-inputss','required'=>true));?>
                   <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">-->                    <div id="map"></div>  
<?php echo $this->Form->input('current_lat',array('class'=>'form-control','type'=>'hidden','id'=>'latitudecurrent','label' =>false)); ?>
<?php echo $this->Form->input('current_long',array('class'=>'form-control','type'=>'hidden','id'=>'longitudecurrent','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
              
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">From Location :</label>
                  <div class="col-sm-9">

                 <?php echo $this->Form->input('location', array('class' => 
                    'longinput form-control','placeholder'=>'Location','label'=>false,'id'=>'pac-input','required'=>true));?>
                   <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">-->                    <div id="map"></div>  
<?php echo $this->Form->input('lat',array('class'=>'form-control','type'=>'hidden','id'=>'latitude','label' =>false)); ?>
<?php echo $this->Form->input('longs',array('class'=>'form-control','type'=>'hidden','id'=>'longitude','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                
                
                
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Address :</label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-sm-12">
                       <?php echo $this->Form->input('country_ids',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','required'=>true,'label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>

                      </div>
                    <!--  <div class="col-sm-4">
                     <?php //echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required'=>true,'label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
                      </div>
                      <div class="col-sm-4">
                       <?php //echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','options'=>$cities)); ?>

                      </div>-->
                    </div>
                  </div>
                  
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Skype id :</label>
                  <div class="col-sm-9"><?php echo $this->Form->input('skypeid',array('class'=>'form-control','placeholder'=>'Skype id','id'=>'skypeid','label' =>false,'type'=>'text','pattern'=>'[a-zA-Z]*')); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Alternate E-mail :</label>
                  <div class="col-sm-9">
					  <?php echo $this->Form->email('altemail',array('class'=>'form-control','placeholder'=>'Alternate Email','autocomplete'=>'off','id'=>'altemail','label' =>false,'type'=>'email')); ?>
 <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                  <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Alternate Mobile :</label>
                  
                      <div class="col-sm-4">
						  <?php echo $this->Form->input('phonecode',array('class'=>'form-control','placeholder'=>'Phone Code','id'=>'phonecode','required'=>true,'label' =>false,'type'=>'text','readonly'=>true)); ?>
<!--<div class="form-control" id="phonecode"></div>-->
        <!--    <input type="text" id="phonecode" placeholder="Skills">-->
                      </div>
                  <div class="col-sm-5">
<?php echo $this->Form->input('altnumber',array('class'=>'form-control','placeholder'=>'Alternate Number','maxlength'=>'25','id'=>'altnumber','label' =>false,'type'=>'tel','pattern'=>'^\d{10}$')); ?>
                  </div>
                </div>
                
                
               <!--<div class="form-group">
                  <label for="" class="col-sm-2 control-label">Alternate Mobile :</label>
                  <div class="col-sm-9">
					  
<?php //echo $this->Form->input('altnumber',array('class'=>'form-control','placeholder'=>'Alternate Number','maxlength'=>'25','id'=>'altnumber','label' =>false,'type'=>'tel','pattern'=>'^\d{10}$')); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                -->
                
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Alternate Skype id :</label>
                  <div class="col-sm-9"><?php echo $this->Form->input('altskypeid',array('class'=>'form-control','placeholder'=>'Alternate Skype id','id'=>'altskypeid','label' =>false,'type'=>'text','pattern'=>'[a-zA-Z]*')); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
				
				<div id="ncpy" style="display: none;">
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Guardian Name :</label>
                  <div class="col-sm-9"><?php echo $this->Form->input('guadian_name',array('class'=>'form-control','placeholder'=>'Guardian Name','maxlength'=>'25','id'=>'guardianname','label' =>false,'type'=>'text')); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Guardian Email Address :</label>
                  <div class="col-sm-9"><?php echo $this->Form->input('guardian_email',array('class'=>'form-control','placeholder'=>'Guardian Email Address','maxlength'=>'25','id'=>'guardianemail','label' =>false,'type'=>'email')); ?>
<span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Guardian Phone Number:</label>
                  <div class="col-sm-9"><?php echo $this->Form->input('guardian_phone',array('class'=>'form-control','placeholder'=>'Guardian Phone Number','maxlength'=>'25','id'=>'guardianphone','label' =>false,'type'=>'tel','pattern'=>'^\d{10}$')); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Guardian Password :</label>
               
                      <div class="col-sm-4">
						 <?php echo $this->Form->input('guardianpassword',array('class'=>'form-control','placeholder'=>'Password','maxlength'=>'11','type'=>'password','autocomplete'=>'off','id'=>'p1','label' =>false)); ?>
<!--<div class="form-control" id="phonecode"></div>-->
        <!--    <input type="text" id="phonecode" placeholder="Skills">-->
                      </div>
                  <div class="col-sm-5">
<input type="password" name="guardianconfirmpassword" class="form-control" id="registration" placeholder="Confirm Password" onfocus="validatePass(document.getElementById('p1'), this);"  oninput="validatePass(document.getElementById('p1'), this);" >
                  </div>
                </div>
                
                
                </div>
              
                
              <?php if($profile['location']==''){ ?>
                <div class="form-group">
                  <div class="col-sm-11">
					   <label>
          <input type="checkbox" required> I Agree with <a href="<?php echo SITE_URL; ?>/termsandconditions"  target="_blank">Terms and Conditions</a>
        </label>
                  </div>
                  <div class="col-sm-1"></div>
                </div<?php } ?>
                
              
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

</div>
 <script>
	$(document).ready(function(){  //alert();
		$('#guardianemail').change(function() { alert();
			var guardian = $('#guardianemail').val();
			//alert(username);
			$.ajax({ 
				type: 'POST', 
				url: '<?php echo SITE_URL;?>/profile/find_username',
				data: {'username':guardian}, 
				success: function(data){ 
					if(data > 0)
						{
							$('#guardianemail').val('');
							$('#dividhere').show();
						}
						else
						{
							$('#dividhere').hide();
						}
				}, 
			});  
		});
	});
function validatePass(p1, p2) {

if (p1.value != p2.value) {

p2.setCustomValidity('Password incorrect');

} else {

p2.setCustomValidity('');

}
}
</script>



<script>
	$('#dobpicker').datepicker({ //alert();

	onSelect: function(value, ui) { 

	calculatedate(value);
	},
	dateFormat: 'yy-mm-dd', 
	maxDate: '+0d',
	changeMonth: true,
	changeYear: true,
	// defaultDate: '-18yr',
	});

	function calculatedate(dob){ //alert(date);
	//dob='1988-04-07';
	dob = new Date(dob);
	var today = new Date(); 
	var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000)); 
	//	age = today.getFullYear() - date;
	if (age < 18)
	{
	$("#ncpy").css("display", "block");

	}
	else
	{
	$("#ncpy").css("display", "none");
	$("#guardianname").val('');
	$("#guardianemail").val('');
	$("#guardianphone").val('');
	}

	if (age){
	$('#age').text(age);
	$('#age').html(age+' years');

	}

	}
	bdate='<?php echo $dateget; ?>';
	calculatedate(bdate);
					</script>
<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#country_phone").on('change',function() {
			var id = $(this).val();
			$("#phonecode").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/profile/getphonecode',
					data: dataString,
					cache: false,
					success: function(html) {
						$.each(html, function(key, value) {    
						//$('<option>').val(key).text(value).appendTo($("#phonecode"));
								$('#phonecode').val(value);
								//$('#phonecode').html('+'+value);
						//$('#phonecode').html('+'+value);
						});
					} 
				});
			}
		});
	});
	</script>
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
					url: '<?php echo SITE_URL;?>/profile/getStates',
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
					url: '<?php echo SITE_URL;?>/profile/getcities',
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.multiselect-ui').multiselect({
            onChange: function(option, checked) {
                // Get selected options.
                var selectedOptions = $('.multiselect-ui option:selected');
               // alert(selectedOptions.length);
                if (selectedOptions.length >= 7) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('.multiselect-ui option').filter(function() {
                        return !$(this).is(':selected');
                    });
 
                    nonSelectedOptions.each(function() {//alert('test');
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                }
                else {
                    // Enable all checkboxes.
                    $('.multiselect-ui option').each(function() { //alert('testing');
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });
    });
</script>
<script  type="text/javascript">
function fileValidation(){
	
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    //alert(allowedExtensions);
    if(!allowedExtensions.exec(filePath)){
       $("#ncpyss").css("display", "block");
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>


 
<script src="<?php echo SITE_URL; ?>/js/jquery.imgareaselect.js"></script> 
<script src="<?php echo SITE_URL; ?>/js/jquery.awesome-cropper.js"></script>

<script>

    $(document).ready(function () {

        $('#sample_input').awesomeCropper(

        { width: 150, height: 150, debug: true }

        );

    });

    </script> 



