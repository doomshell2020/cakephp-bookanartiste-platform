
 <?php 
foreach ($requirementvacancy as $key => $value) { //pr($value);
$talentarray[]=$value['telent_type'];
}
//pr($profile);
 ?>
 <section id="page_post-req">
 <div class="container">
 <h2>Post Talent <span>Requirement</span></h2>
      <p class="m-bott-50">Here You Can Fill Post Talent Requirement</p>
        <?php echo $this->Flash->render(); ?>
 </div> 
 
<?php if(!empty($jobposterror)){ ?> 
 <section class="content-header">
    <div class="alert alert-danger alert-dismissible">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $jobposterror; ?>
    </div>
</section>
<?php } ?>

 <div class="post-talant-form">
<div class="container profile-bg">
   <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'jobpost'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>

  <script type="text/javascript">

function initialize() {
   var latlng = new google.maps.LatLng(<?php echo $requirement['latitude'] ?>,<?php echo $requirement['longitude'] ?>);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: false,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var infowindow = new google.maps.InfoWindow();   
    google.maps.event.addListener(marker, 'click', function() {
      var iwContent = '<div id="iw_container">' +
      '<div class="iw_title"><b>Location</b> : <?php echo $requirement["location"]; ?></div></div>';
      // including content to the infowindow
      infowindow.setContent(iwContent);
      // opening the infowindow in the current map and at the current marker location
      infowindow.open(map, marker);
    });
}
google.maps.event.addDomListener(window, 'load', initialize);


</script>            

  <link href="<?php echo SITE_URL; ?>/css/imgareaselect-default.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery.awesome-cropper.css">    
              <div class="container">
      
                      <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Profile image :</label>
                  <div class="col-sm-4 upload-img text-center">
			<?php if ($requirement['image']!=''){ ?>
				<img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/job/<?php echo $requirement['image']; ?>"/>
				
				<?php }else{ ?>
							<img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: 140px;" src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
				<?php } ?>
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
                  <label for="" class="col-sm-3 control-label">Title of Job/Event:</label>
                  <div class="col-sm-8">
					    <?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Title of Job/Event','id'=>'name','required','label' =>false)); ?>
                   
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
       
                   <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Talent Requirement :</label>
                  <div class="col-sm-8">
		<select id="rooms" class="multiselect-ui form-control" multiple="multiple" name="data[telent_type][]" required>
			
		<?php foreach($Skill as $key=>$value){ //pr($value);?>
			
		     <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
		<?php } ?>
		</select>
</div>
                   <div class="col-sm-1"></div>
                </div>
                

                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Talent Requirement Description :</label>
                  <div class="col-sm-8">
                       <?php echo $this->Form->input('talent_requirement_description',array('class'=>'form-control','placeholder'=>'Talent Requirement Description','id'=>'name','required','label' =>false,'type'=>'textarea')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                
                
              	<?php if(count($requirementvacancy)>0)
								{ ?>
                   <span id="ncpy">
                <?php }else{ ?>
					 <span id="ncpy" style= "display: none; color: red">
					<?php } ?>
                <div id="">
<br clear="all" />
                <div class="form-group">
                <div class="col-sm-12">
                <div class="table-responsive">
					 <div class="multi-field-wrapper">
						
  <table class="table table-bordered">
<thead>
  <tr>
  
  <th>Vacancy</th>
  <th>Gender</th>
  <th>Payment
Frequency</th>
  <th>Payment
Currency</th>
  <th>Payment
Amount</th>


  </tr>
  </thead>
  <tbody class="video_container">
	  	<?php if(count($requirementvacancy)>0){ ?>
 <?php  $i=1; foreach ($requirementvacancy as $key => $value) { //pr($value); ?>
	 
  <tr class="video_details" id="room-<?php echo $i; ?>">
  <td><?php echo $this->Form->input('number_of_vacancy',array('class'=>'form-control','placeholder'=>'Number of Vacancy','id'=>'','required','label' =>false,'type'=>'number','min'=>'1','name'=>'data[number_of_vacancy][]','value'=>$value['number_of_vacancy'])); ?></td>
 <?php $gen= array('a'=>'All','bmf'=>'Both Male And Female','m'=>'Male','f'=>'Female','o'=>'Other',); ?>
  <td><?php echo $this->Form->input('sex',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'--Select Gender--','options'=>$gen,'selected'=>'selected','name'=>'data[sex][]','value'=>$value['sex'])); ?></td>
 

  <td><?php echo $this->Form->input('payment_freq',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'-- Select Frequency--','options'=>$payfreq,'name'=>'data[payment_freq][]','value'=>$value['payment_freq'])); ?></td>
 
 
  <td><?php echo $this->Form->input('payment_currency',array('class'=>'form-control','placeholder'=>'Amount','id'=>'','required','label' =>false,'empty'=>'--Select Currency--','options'=>$Currency,'selected'=>'selected','name'=>'data[payment_currency][]','value'=>$value['payment_currency'])); ?></td>
  
  
  <td> <?php echo $this->Form->input('payment_amount',array('class'=>'form-control','placeholder'=>'Amount','id'=>'name','required','label' =>false,'type'=>'number','min'=>'1','name'=>'data[payment_amount][]','value'=>$value['payment_amount'])); ?></td>

  
  </tr>
<?php $i++;} }else{?>
	 <tr class="video_details" id="room-1">
  <td><?php echo $this->Form->input('number_of_vacancy',array('class'=>'form-control','placeholder'=>'Number of Vacancy','id'=>'','required','label' =>false,'type'=>'number','min'=>'1','name'=>'data[number_of_vacancy][]')); ?></td>
 <?php $gen= array('a'=>'All','bmf'=>'Both Male And Female','m'=>'Male','f'=>'Female','o'=>'Other',); ?>
  <td><?php echo $this->Form->input('sex',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'--Select Gender--','options'=>$gen,'selected'=>'selected','name'=>'data[sex][]')); ?></td>
 

  <td><?php echo $this->Form->input('payment_freq',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'-- Select Frequency--','options'=>$payfreq,'name'=>'data[payment_freq][]')); ?></td>
 
 
  <td><?php echo $this->Form->input('payment_currency',array('class'=>'form-control','placeholder'=>'Amount','id'=>'','required','label' =>false,'empty'=>'--Select Currency--','options'=>$Currency,'selected'=>'selected','name'=>'data[payment_currency][]')); ?></td>
  
  
  <td> <?php echo $this->Form->input('payment_amount',array('class'=>'form-control','placeholder'=>'Amount','id'=>'name','required','label' =>false,'type'=>'number','min'=>'1','name'=>'data[payment_amount][]')); ?></td>

  
  </tr>
	<?php } ?>
  
  </tbody>
  </table>
</div>
                </div>
                </div>
                </div></div>
                </span>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Payment Description :</label>
                  <div class="col-sm-8">
                  <?php echo $this->Form->input('payment_description',array('class'=>'form-control','placeholder'=>'Payment Description','id'=>'name','required','label' =>false,'type'=>'textarea')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Time:</label>
                  <div class="col-sm-8">
					  <?php   $type=array('Part Time'=>'Part Time','Full Time'=>'Full Time'); ?>
                   <?php echo $this->Form->input('time',array('class'=>'form-control','placeholder'=>'State','id'=>'','required','label' =>false,'empty'=>'--Select Type--','options'=>$type,'selected'=>'selected')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Job / Event Type :</label>
                  <div class="col-sm-8">
					
                   <?php echo $this->Form->input('event_type',array('class'=>'form-control','placeholder'=>'Job / Event Type','id'=>'','required','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Number of Attendees :</label>
                  <div class="col-sm-8">
                   <?php echo $this->Form->input('number_attendees',array('class'=>'form-control','placeholder'=>'Number','id'=>'','required'=>true,'label' =>false,'type'=>'number','min'=>'1')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Event Date/Time:</label>
                  <div class="col-sm-8">
          <div class="row">
                   <div class="col-sm-5 date">
                  
             
    <?php echo $this->Form->input('event_from_date',array('class'=>'form-control datetimepicker1','placeholder'=>'YYYY /MM /DD','type'=>'text','required'=>true,'label' =>false,'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['event_from_date'])):'')); ?>

        </div>

  <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>
                   
                 
    <div class="col-sm-5 date">
                  <?php echo $this->Form->input('event_to_date',array('class'=>'form-control datetimepicker2','placeholder'=>'YYYY /MM /DD','type'=>'text','required'=>true,'label' =>false,'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['event_to_date'])):'')); ?>
        </div>
        </div>
        </div>
           <div class="col-sm-1"></div>       
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Last Date of Application Date/Time:</label>
                  <div class="col-sm-8">
          <div class="row">
                   <div class="col-sm-5 date">
                  
             <?php echo $this->Form->input('last_date_app',array('class'=>'form-control datetimepicker3','placeholder'=>'YYYY /MM /DD','type'=>'text','id'=>'datepicker','required'=>true,'label' =>false,'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['last_date_app'])):'')); ?>

        </div>

  <label for="" class="col-sm-2 control-label" style="text-align:center"></label>
                   
                 
    <div class="col-sm-5 date">
                  
                             
    

        </div>
        </div>
        </div>
       
           <div class="col-sm-1"></div>       
    

              
                </div>
                
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Talent Required Date/Time:</label>
                  <div class="col-sm-8">
          <div class="row">
                   <div class="col-sm-5 date">
                  
             <?php echo $this->Form->input('talent_required_fromdate',array('class'=>'form-control datetimepicker4','placeholder'=>'YYYY /MM /DD','type'=>'text','id'=>'datepicker','required'=>true,'label' =>false,'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['talent_required_fromdate'])):'')); ?>

        </div>

  <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>
                   
                 
    <div class="col-sm-5 date">
                  
             <?php echo $this->Form->input('talent_required_todate',array('class'=>'form-control datetimepicker5','placeholder'=>'YYYY /MM /DD','type'=>'text','id'=>'datepicker','required'=>true,'label' =>false,'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['event_from_date'])):'')); ?>

             
             
             
      
        
        
        
        
              <script type="text/javascript"> 
        $(function() { 
	    var today = new Date();
	   
	    
	    $('.datetimepicker1').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate:0, 
		}); 
		
	       $('.datetimepicker2').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate:0, 
		}); 
		
		<?php 
		if($this->request->session()->read('eligible.job_validity'))  { ?>
		var max_days  = <?php echo $this->request->session()->read('eligible.job_validity'); ?>;
		var todayDate = new Date().getDate();
		$('.datetimepicker3').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate: new Date(new Date().setDate(todayDate + max_days))
		});
		<?php }else{?>
		$('.datetimepicker3').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate: 0
		}); 
		<?php }?>
		
		$('.datetimepicker4').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate:0, 
		}); 
		$('.datetimepicker5').datetimepicker({
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate:0, 
		}); 
	    }); 
	</script>
        </div>
        </div>
        </div>
           <div class="col-sm-1"></div>       
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Venue Type:</label>
                  <div class="col-sm-8">
            <?php echo $this->Form->input('venue_type',array('class'=>'form-control','placeholder'=>'Venue Type','id'=>'','required','label' =>false,'type'=>'text')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Venue Description:</label>
                  <div class="col-sm-8">
                         <?php echo $this->Form->input('venue_description',array('class'=>'form-control','placeholder'=>'Venue Description','id'=>'name','required','label' =>false,'type'=>'textarea')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Venue Address:</label>
                  <div class="col-sm-8">
                       <?php echo $this->Form->input('venue_address',array('class'=>'form-control','placeholder'=>'Venue Address','id'=>'name','required','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div> 
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Address :</label>
                  <div class="col-sm-8">
                    <div class="row">
                      <div class="col-sm-4">
                         <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','required','label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
                      </div>
                      <div class="col-sm-4">
                  <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required','label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
                      </div>
                      <div class="col-sm-4">
                      <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','required','label' =>false,'empty'=>'--Select City--','options'=>$cities)); ?>
                      </div>
                    </div>
                  </div>
                   <div class="col-sm-1"></div>
                </div>
                 <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Requirement Description:</label>
                  <div class="col-sm-8">
                         <?php echo $this->Form->input('requirement_desc',array('class'=>'form-control','placeholder'=>'Requirement Description','id'=>'name','required','label' =>false,'type'=>'textarea')); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Landmark:</label>
                  <div class="col-sm-8">  <?php echo $this->Form->input('landmark',array('class'=>'form-control','placeholder'=>'Landmark','id'=>'name','required','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Location:</label>
                  <div class="col-sm-8 location">
					  
                    <input id="pac-input" type="text" class="form-control" placeholder="Location" name="location" value="<?php  echo $requirement['location']; ?>">
                 
<?php echo $this->Form->input('latitude',array('class'=>'form-control','type'=>'hidden','id'=>'latitude','required','label' =>false)); ?>
<?php echo $this->Form->input('longitude',array('class'=>'form-control','type'=>'hidden','id'=>'longitude','required','label' =>false)); ?>
                  </div>
                  <div class="col-sm-1"></div>
                </div>
                  <div id="map"></div>  
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 40%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
    </style>
<div class="form-group">
    <div class="col-sm-12 ">
      <div class="checkbox">
        <label>
			<?php if ($requirement_data['jobquestion']){ ?>
          <input type="checkbox" id="checkbox1" checked > 
          <?php }else{ ?>
			            <input type="checkbox" id="checkbox1"> 

			  <?php } ?>
			  
          I would like to ask some specific questions by a questionnare
        </label>
      </div>
    </div>
  </div>
  <?php if ($requirement_data['jobquestion']){ ?>
<div id="autoUpdate" style="display: block;">  
	<?php }else{?>
		<div id="autoUpdate" style="display: none;">  

		<?php  } ?>          
                    <div class="form-group">
                  <label for="" class="col-sm-12 control-label">Questionnare:</label>
                </div>
                   <div class="form-group">
                <div class="col-sm-12">
                <div class="table-responsive">
					 <div class="multi-field-wrapperdesc">
						
  <table class="table table-bordered">
<thead>
  <tr>
   <th style="width: 30%;">Question</th>
   <th style="width: 30px;">OptionType</th> 
<th style="width: 10px;">Option1</th> 
<th style="width: 20px;">Option2</th> 
   <th style="width: 20px;">Option3</th> 
  <th style="width: 20px;">Option4</th>
 
  
  </tr>
  </thead>
  
  <tbody class="payment_containerdesc">
	  
	  <?php $count=0; foreach($requirement_data['jobquestion'] as $valuequestion){  //pr($valuequestion);?>	   
  <tr class="payment_detailsdesc">
  
  <td><?php echo $this->Form->input('question',array('class'=>'form-control','placeholder'=>'Question','id'=>'myField','label' =>false,'name'=>'questions[name][]','value'=>$valuequestion['question_title'])); ?></td>
  
  
  <td><?php echo $this->Form->input('optiontypeone',array('class'=>'form-control','id'=>'gender','type'=>'select','options'=>$questionnare,'label' =>false,'legend'=>false,'name'=>'questions[optiontype][]','empty'=>'Type','value'=>$valuequestion['option_type'])); ?> </td>
  <?php $i=0;  foreach($valuequestion['jobanswer'] as $valueoption){ ?>
	
 <td><?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer]['.$i.'][]','value'=>$valueoption['answervalue'])); ?></td>
     <?php $i++ ;} ?>
     
      <?php 
	   $answercount = 4 - count($valuequestion['jobanswer']) ; 
	    ?>
     <?php  for ($i = 0; $i < $answercount; $i++) { ?>
	 <td><?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer]['.$i.'][]')); ?></td>
		 <?php } ?>
       <?php } ?>
	  
	    </tr>
	    <?php 
	   $questioncount = 8 - count($requirement_data['jobquestion']) ; 
	    ?>
	 <?php  for ($i = 0; $i < $questioncount; $i++) { ?>
  <tr class="payment_detailsdesc">
  
  <td><?php echo $this->Form->input('question',array('class'=>'form-control','placeholder'=>'Question','id'=>'myField','label' =>false,'name'=>'questions[name][]')); ?></td>
  
  
  <td><?php echo $this->Form->input('optiontypeone',array('class'=>'form-control','id'=>'gender','type'=>'select','options'=>$questionnare,'label' =>false,'legend'=>false,'name'=>'questions[optiontype][]','empty'=>'Type')); ?> </td>
  
 <td><?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer][0][]')); ?></td>

  <td><?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer][1][]')); ?></td>
    

  <td> <?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer][2][]')); ?></td>
  
 
  <td>  <?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>'Option','id'=>'name','label' =>false,'name'=>'questions[answer][3][]')); ?></td>

  </tr>
       <?php } ?>           
                    
  </tbody>
  </table>
</div>
                
                </div>
                
                
                
    
                </div>
                </div>
               
    </div>           
               
                <div class="form-group">
                  <div class="col-sm-12 text-center m-top-20">
                    <button type="submit" class="btn btn-default">Submit</button>
                  </div>
                </div>
              </form>
            </div>
 
 </div>
 
 
 </section>
  <script>
$(document).ready(function () {
    $('#checkbox1').change(function () {
        if (!this.checked) 
           $('#autoUpdate').hide();
        else 
            $('#autoUpdate').show();
    });
});
</script>
 <script type="text/javascript">
  $('#myField').keyup(function() 
  {
    var txtVal = this.value;
     $("#output").text(txtVal);
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
					url: '<?php echo SITE_URL;?>/jobpost/getStates',
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
					url: '<?php echo SITE_URL;?>/jobpost/getcities',
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
	
	
<script type="text/javascript">
    $(document).ready(function() {
    var allowed_skills = '<?php echo $this->request->session()->read('eligible.job_skills'); ?>';
    //alert();
        $('.multiselect-ui').multiselect({
            onChange: function(option, checked) {
                // Get selected options.
                var selectedOptions = $('.multiselect-ui option:selected');
                var le= selectedOptions.length;

                if (selectedOptions.length >= allowed_skills) {
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
         
       
 
<script>


$(document).ready(function () {
    //onchange of rooms-count
    $('#rooms').change(function() {
        var roomsSelected = $('#rooms option:selected');
		var len= roomsSelected.length;
        var roomsDisplayed = $('[id^="room-"]:visible').length;
        var roomsRendered = $('[id^="room-"]').length;
        //if room count is greater than number displayed - add or show accordingly
         if (len == 0) {
			 $("#ncpy").css("display", "none");
		 }
        if (len > roomsDisplayed) {
			 $("#ncpy").css("display", "block");
            for (var i=1;i<=len;i++){
                var r=$('#room-'+i);
                if (r.length == 0) {
                    var clone=$('#room-1').clone(); 
                    
                         clone.find('input').val('').focus();
                         clone.find('select').val('').focus();
                    //clone
                   // clone.children(':first').text("Room "+i);
                    //change ids appropriately
                    setNewID(clone,i);
                    clone.children('div').children('select').each(function() {
                        setNewID($(this),i);
                    });
                    $(clone).insertAfter($('#room-'+roomsRendered));
                    
                }else{
                    //if the room exists and is hidden 
                    $(r).show();
                }
            }
        }
        else {
            //else if less than room count selected - hide
            for (var i=++len;i<=roomsRendered;i++){
                $('#room-'+i).hide();
            }
        }
    
    });
    function setNewID(elem, i) {
        oldID=elem.attr('id');
        newId=oldID.substring(0,oldID.indexOf('-'))+"-"+i;
        elem.attr('id',newId);
    }

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
