<?php echo $this->element('viewprofile') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <div class="col-sm-9 my-info" id="conatact-all">
	<div class="col-sm-12 prsnl-det">
	<script inline="1">
//<![CDATA[
$(document).ready(function () {  //alert();
  $("#searchForm").bind("keyup", function (event) {
    $.ajax({
      async:true,
      data:$("#searchForm").serialize(),
      dataType:"html", 

      success:function (data) { //alert(data);

        $(".prosrrc").html(data);}, 
        type:"POST", 
        url:"<?php echo SITE_URL;?>/profile/search"});
    return false;
  });
});
//]]>


function opentab()
  {
    $.ajax({
      async:true,
      data:$("#searchForm").serialize(),
      dataType:"html", 

      success:function (data) { //alert(data);

        $(".prosrrc").html(data);}, 
        type:"POST", 
        url:"<?php echo SITE_URL;?>/profile/search"});
    return false;
 }

</script>
	
	<div class="row">
	<div class="col-sm-12">
 <?php  echo $this->Form->create('',array('url'=>array('controller'=>'profile','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'searchForm','class'=>'form-horizontal')); ?>
 
 
   <input type="text" class="form-control  chekallser" name="name" placeholder="search...">
		<input type="hidden" id="phonecode" class="form-control" name="tab" value ="following">
		<?php echo $this->Form->end();?>   
    </div>	
	</div>
    <style>
    .prsnl-det .contact_all_refine label:after {
    content: "" !important;
    display: inline-block;
    color: #000;
    font-weight: 500;
    position: absolute;
    right: 0;
}
#slider-range {
    margin: 0px 0px !important;
}
    </style>
    <div class="row">
    
    <ul class="nav nav-pills">
   
  
    <li class="active"><a data-toggle="" href="<?php echo SITE_URL?>/profile/allcontacts" class="cnt" data-action="contacts">Contacts (<?php echo count($friends); ?>)</a></li>
    <li><a data-toggle="" href="<?php echo SITE_URL?>/profile/mutualcontacts" class="cnt" data-action="mutual">Mutual Contacts (<?php echo count($mutualfrnd); ?>)</a></li>
    <li><a data-toggle="" href="<?php echo SITE_URL?>/profile/onlinecontacts" class="cnt" data-action="online">Online Contacts (<?php echo count($onlines); ?>)</a></li>
     <li><a data-toggle="" href="<?php echo SITE_URL?>/profile/followingcontacts" class="cnt" data-action="following">Following (<?php echo count($following); ?>)</a></li>
      <li><a data-toggle="" href="<?php echo SITE_URL?>/profile/followerscontacts" class="cnt" data-action="followers">Followers (<?php echo count($followerd); ?>)</a></li>
      
      
      
     <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Refine Contacts<span class="caret"></span></a>
     <ul class="dropdown-menu contact_all_refine">
      <li><div class="col-sm-12">
    
     <form class="form-horizontal">
         
      <div class="form-group">
    <div class="col-sm-12">
        <label>Name :</label>
        </div>
        
        <div class="col-sm-12">
       <input type="text" class="form-control" placeholder="Name" name="name" >
       
    </div>
  </div>
  
  <div class="form-group">
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<div class="col-sm-12">
        <label>AGE :
        <input type="text" id="amount" readonly style="border:0; background-color:#eeeeee; font-weight:normal;" name="age" class="auto_submit_item">
        </label>
        </div>
    <div class="col-sm-12">
<div id="slider-range"></div>
    </div>
  </div>
  
  
   <div class="form-group">
    <div class="col-sm-12">
        <label>Gender :</label>
        </div>
         <?php $gen= array('m'=>'Male','f'=>'Female','o'=>'Other','bmf'=>'Male And Female'); ?>
        <div class="col-sm-12">
      <?php echo $this->Form->input('gender',array('class'=>'form-control','placeholder'=>'State', 'id'=>'','label' =>false,'empty'=>'--Select Gender--','options'=>$gen,'selected'=>'selected')); ?>
       
    </div>
  </div>
  
  
  <div class="form-group">
    <div class="col-sm-12">
        <label>Ethnicity :</label>
        </div>
        
        <div class="col-sm-12">
       <?php echo $this->Form->input('ethnicity',array('class'=>'form-control', 'id'=>'','label' =>false,'empty'=>'--Select Ethnicity--','options'=>$ethnicity,'selected'=>'selected')); ?>
       
    </div>
  </div>
  
   <div class="form-group">
    <div class="col-sm-12">
        <label>country :</label>
        </div>
        
        <div class="col-sm-12">
       <?php echo $this->Form->input('country_ids',array('class'=>'form-control','id'=>'country_ids','label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
       
    </div>
  </div>
  
  
  <div class="form-group">
    <div class="col-sm-12">
        <label>State :</label>
        </div>
        
        <div class="col-sm-12">
       <?php echo $this->Form->input('state_id',array('class'=>'form-control','id'=>'state','label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
       
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-12">
        <label>City :</label>
        </div>
        
        <div class="col-sm-12">
      <?php echo $this->Form->input('city_id',array('class'=>'form-control','id'=>'city','label' =>false,'empty'=>'--Select City--','options'=>$cities)); ?>
       
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-12">
        <label>Profile Active :</label>
        </div>
        
        <div class="col-sm-12">
            <?php echo $this->Form->input('profile_active',array('class'=>'form-control','id'=>'profileactivein','label' =>false,'empty'=>'--Select Profile Active IN--','options'=>$profileactivein)); ?>
       <input type="select" class="form-control" placeholder="Name" name="name" >
       
    </div>
  </div>
  
  
  
   <div class="form-group">
 
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Refine Search</button>
    </div>
  </div>
       </form>
  <script>
        $(document).ready(function() {
        $( "#slider-range" ).slider({
          range: true,
          min: 10,
          max: 999,
          values: [ 200, 500 ],
          slide: function( event, ui ) {
         $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
         }
      });
          
      $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
               " - $" + $( "#slider-range" ).slider( "values", 1 ) );
          
        });
    </script>
    
  
    <script>
      /*
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min:<?php  //echo $minimumage;  ?>,
      max: <?php  //echo $maxage;  ?>,
      values: [ <?php  //echo $minisels;  ?>, <?php  //echo $maxsels;  ?>],
      slide: function( event, ui ) {
        $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      },change: function(event, ui) {
        $("#ajexrefine").submit();
      }
    });

    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  */
</script>
    
    
   <script>
$(document).ready(function(){  //alert();
    $(".cnt").click(function(){
		var action = $(this).data('action');
	
	
		$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/profile/tabget',
					data: ({action:action}),
					cache: false,
					success: function(data) { //alert(data);
						$('#phonecode').val(data);
						opentab();
						
						} 
				});
	
	
    });
});
</script>
      
      
      </div></li>
       
    </ul>
     
     </li>
  </ul>

    <div class="tab-content">
 

           <?php //////////////-Following------------?>
 <div id="Following" class="tab-pane fade in active">
      <div class="col-sm-12">
     <div class="row">
		  <div class="prosrrc">
		 <?php  foreach($following as $followingss){  //pr($followingss);?>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $followingss['profile_image'];  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
     <div class="img-top-bar"> 
     <?php  $subprpa = $this->Comman->subscriprpack($followingss['user_id']); ?>
    <?php if ($subprpa){ ?>
    <a href="<?php echo SITE_URL; ?>/profilepackage" title="Profile package"><img src="<?php echo SITE_URL; ?>/images/profile-package.png"></a>
    <?php } ?>
     <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $followingss['user_id']; ?>" class="fa fa-user"></a> 
     <?php  $subrepa = $this->Comman->subscrirepack($followingss['user_id']); ?>
<?php if ($subrepa){ ?>
      <a href="<?php echo SITE_URL; ?>/recruiterepackage" title="Recruiter package"><img src="<?php echo SITE_URL; ?>/images/recruiter-package-.png"></a> 
     <?php } ?>
     </div>
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center"><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $followingss['user_id']; ?>"><?php echo $followingss['name']; ?></a></h5>
    <?php $skills= $this->Comman->userskills($followingss['user_id']); ?>
   <p class="text-center"><?php if($skills)
					{
					$knownskills = '';
					foreach($skills as $skillquote)
					{
					if(!empty($knownskills))
					{
						$knownskills = $knownskills.', '.$skillquote['skill']['name'];
					}
					else
					{
						$knownskills = $skillquote['skill']['name'];
					}
					}
					$output.=str_replace(',',' ',$knownskills).',';
					//$output.=$knownskills.",";	
				   echo $knownskills;
					}	?></p>
     <p class="text-center"><?php echo $followingss['location']; ?></p></div>
     
     <div class="btn-book text-center">
     <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $followingss['user_id']; ?>" class="btn btn-default">Book</a>
      <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $followingss['user_id']; ?>" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     
     
        <?php } ?>
    
     </div>
     </div>
     
     
     </div>
    </div>
    
    
    
   
  </div>

    
    
    
    </div>
	</div>
	
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







  
  <!-------------------------------------------------->
