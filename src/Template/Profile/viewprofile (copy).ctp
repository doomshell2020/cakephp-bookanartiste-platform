<?php echo $this->element('viewprofile') ?>
    <div class="col-sm-9 my-info">
	<div class="col-sm-12 prsnl-det">
	<div class="clearfix">
	    <h4 class="pull-left">Personal<span> Detail</span></h4>
	    <div class="pull-right">Last Active on <?php echo date("d M Y h:ia",strtotime($profile->user->last_login)); ?></div>
	</div>
	<div class="col-sm-6 personal-info">
<?php $skillcount = count($skillofcontaint); ?>
<?php if($skillcount>0){?>
	    <p><i class="fa fa-birthday-cake m-right-5" aria-hidden="true"></i>Skills</p>
	    <?php } ?>	
	    <p><i class="fa fa-birthday-cake m-right-5" aria-hidden="true"></i>Date of Birth</p>
	        <p><i class="fa fa-mars m-right-5" aria-hidden="true"></i>Gender</p>
	  		<p class="language"><i class="fa fa-globe m-right-5" aria-hidden="true"></i>Language(s) known</p>
	  		<p><i class="fa fa-user-circle m-right-5" aria-hidden="true"></i>ethnicity</p>
	  		 <p class="add-ress"><i class="fa fa-map-marker m-right-5 f-20" aria-hidden="true"></i>Address</p>
	  		 
	    
	</div>
	<div class="col-sm-6">
		<?php if($skillcount>0){?>
	    <p> <?php 
	    if($skillofcontaint){
		foreach($skillofcontaint as $skils){ 
	    ?>
	   <?php echo $skils->skill->name.","; ?>
	    
	    <?php }
	    }
	    ?></p>
	    <?php } ?>
	     <?php $birthdate = date("Y-m-d",strtotime($profile->dob));
	   
	   $from = new DateTime($birthdate);
$to   = new DateTime('today');?>
	    <p><?php echo date("d M Y",strtotime($profile->dob)); ?> (<?php echo $from->diff($to)->y, "Years"; ?>)
	<a href="#" id="dob" data-type="date" data-pk="1" data-url="/post" data-title="Select date">15 Mar 2001</a>
<script>
$(function(){
    $('#dob').editable({
        format: 'yyyy-mm-dd',    
        viewformat: 'd M Y',    
        datepicker: {
                weekStart: 1
           }
        });
});
</script>
	   </p>

	    
	    
	    <p><?php if($profile->gender=='m'){ echo 'Male';}else if($profile->gender=='f'){echo 'Female';}else{echo 'Other';}  ?></p>
	     <p>
	    <?php
	    if($languageknow)
	    {
	    $knownlanguages = '';
	    foreach($languageknow as $language)
	    {
		if(!empty($knownlanguages))
		{
		    $knownlanguages = $knownlanguages.', '.$language->language->name;
		}
		else
		{
		    $knownlanguages = $language->language->name;
		}
	    }
	    echo $knownlanguages;
	    }
	    
	    ?>
	    </p>
	    <p><?php echo $profile->enthicity->title; ?></p>
	    <p class="add-ress"><?php echo $profile->location; ?></p>
	    
	

		
		
		
	</div>
	</div>
	
	<div class="col-sm-12 prsnl-det m-top-20">
	<div class="clearfix">
	    <h4 class="pull-left"><span> Images</span></h4>
	   <?php  if(count($galleryimages) > 0){ ?>
	   <div class="pull-right"><a href="#">View All</a></div>
	   <?php } ?>
	</div>
	<div class="row contact-friend">
	   <?php
	    if(count($galleryimages) > 0)
	    { ?>
	   <div class="demo-gallery">
	    <ul id="imagegallery" class="list-unstyled row">
	    <?php
	    foreach($galleryimages as $images)
	    { ?>
		<a class="col-sm-2" href="<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>"><img src="<?php echo SITE_URL; ?>/gallery/<?php echo $images->imagename; ?>"></a>
	<?php }
	    ?>
	    </ul>
	    
	    
	    
	    
</div>
<?php }else{ ?>
    <div class="col-sm-12">
    No Images available
    </div>

<?php }?>
	</div>
	</div>
	
	<div class="col-sm-12 prsnl-det m-top-20">
	<div class="clearfix">
	    <h4 class="pull-left"><span> Contacts</span></h4>
	 
	</div>
	<div class="row contact-friend">
	   <?php
	    if(count($galleryimages) > 0)
	    { ?>
	   <div class="demo-gallery">
	    <ul id="imagegallery" class="list-unstyled row">
	      <?php  
		    foreach($friends as $friendss)
		    {
		    if($friendss->Users->id!=$userid)
		    {
		    ?>
		<a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss->Users->id;  ?>" title="<?php echo $friendss->Users->profile[0]->name;  ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $friendss->Users->profile[0]->profile_image;  ?>"height="100px" width="100px"></a>
	
	
	<?php } }
	    ?>
	    </ul>
	    
	    
	    
	    
</div>
<?php }else{ ?>
    <div class="col-sm-12">
    No Images available
    </div>

<?php }?>
	</div>
	</div>
	
	
	<div class="col-sm-12 prsnl-det m-top-20">
	<h4><span> Activites</span></h4>
	<?php 
	//pr($activities);
	if($activities && count($activities)>0){ 
	foreach($activities as $activity_data){ 
	    // Calculate time
	    $datetime = $activity_data->date;
	    
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);
	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;
	    $string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
		if ($diff->$k) {
		    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
		    unset($string[$k]);
		}
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    $time_diff = $string ? implode(', ', $string) . ' ago' : 'just now';
	?>
	<div class="row activites-blog">
	    <div class="col-sm-2"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile->user_id; ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile->profile_image; ?>"></a></div>
	    <?php if($activity_data->activity_type=='update_photos'){ ?>
	    <!-- Update Profile -->
	    <div class="col-sm-4 activites">
	    <p><span><?php echo $profile->name; ?></span> Uploaded a Photo.</p>
	    <div><i class="fa fa-clock-o"></i><em><?php echo $time_diff; ?></em></div>
	    </div>
	    <div class="col-sm-2 up-image"><a target="_blank" href="<?php echo SITE_URL; ?>/gallery/<?php echo $activity_data->galleryimage->imagename; ?>"> <img src="<?php echo SITE_URL; ?>/gallery/<?php echo $activity_data->galleryimage->imagename; ?>"></a>
	    <div class="activites-social-icon">
		<ul class="list-unstyled">
		<li> <a href="#" class="bg-blue"><i class="fa fa-thumbs-up"></i></a>
		    <div class="like"><a href="#">0</a></div>
		</li>
		<li> <a href="#" class="bg-blue"><i class="fa fa-share"></i></a>
		    <div class="like"><a href="#">0</a></div>
		</li>
		<li> <a href="#" class="bg-blue"><i class="fa fa-flag"></i></a>
		    <div class="like"><a href="#">0</a></div>
		</li>
		</ul>
	    </div>
	    </div>
	    <?php }elseif($activity_data->activity_type=='update_profile'){?>
	    <div class="col-sm-4 activites">
	    <p><span><?php echo $profile->name; ?></span> Updated Profile.</p>
	    <div><i class="fa fa-clock-o"></i><em><?php echo $time_diff; ?></em></div>
	    </div>
	    <?php }elseif($activity_data->activity_type=='like_profile'){?>
	    <div class="col-sm-4 activites">
	    <p><span><?php echo $profile->name; ?></span> Like  <?php echo $activity_data->user->user_name; ?>'s Profile.</p>
	    <div><i class="fa fa-clock-o"></i><em><?php echo $time_diff; ?></em></div>
	    </div>
	    <?php }elseif($activity_data->activity_type=='unlike_profile'){?>
	    <div class="col-sm-4 activites">
		<p><span><?php echo $profile->name; ?></span> Unlike  <?php echo $activity_data->user->user_name; ?>'s Profile.</p>
	    <div><i class="fa fa-clock-o"></i><em><?php echo $time_diff; ?></em></div>
	    </div>
	    <?php }elseif($activity_data->activity_type=='block_profile'){?>
	    <div class="col-sm-4 activites">
	    <p><span><?php echo $profile->name; ?></span> Blocked <?php echo $activity_data->user->user_name; ?>.</p>
	    <div><i class="fa fa-clock-o"></i><em><?php echo $time_diff; ?></em></div>
	    </div>
	    <?php }else{}?>
	    <div class="col-sm-4"></div>
	</div>
	<?php } ?>
	<div class="col-sm-12"><a href="#" class="btn btn-default">View All</a></div>
	<?php }else{ ?>
	No Activity available.
	<?php }?>
	</div>
    </div>
    </div>
</div>
</div>
<div id="Pro-Summary" class="tab-pane fade">
<div class="container m-top-60"> </div>
</div>
<div id="Perfo-Des" class="tab-pane fade">
<div class="container m-top-60"> </div>
</div>
<div id="Gallery" class="tab-pane fade">
<div class="container m-top-60"> </div>
</div>
<div id="Vital" class="tab-pane fade">
<div class="container m-top-60"> </div>
</div>
</div>
</div>
</div>
</section>
  
  








  
  <!-------------------------------------------------->
