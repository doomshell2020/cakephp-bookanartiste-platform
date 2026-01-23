  <?php  foreach($friends as $friendss){   ?>
		 <?php //pr($friendss); ?>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><input type="checkbox" name="profile[]" class="profilesavecontact"> <a href="#" class="fa fa-remove"></a></div>
 <a style="Width:100%;" target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> ">  <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $friendss['profile_image'];  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
   </a>
    <div class="img-top-bar"> 
     <?php  $subprpa = $this->Comman->subscriprpack($friendss['from_id']); ?>
    <?php if ($subprpa){ ?>
    <a href="<?php echo SITE_URL; ?>/profilepackage" title="Profile package"><img src="<?php echo SITE_URL; ?>/images/profile-package.png"></a>
    <?php } ?>
     <?php  $subrepa = $this->Comman->subscrirepack($friendss['from_id']); ?>
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
   <div class="all-cnt-det"><h5 class="text-center"><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> "><?php echo $friendss['name']; ?></a></h5>
   <?php $skills= $this->Comman->userskills($friendss['user_id']); ?>
  <p class="text-center">  <a style="color:black;" target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> "> <?php if($skills)
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
					}	?></a></p>
     <p class="text-center"><a style="color:black;" target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> "><?php echo $friendss['location']; ?></a></p></div>
     
     <div class="btn-book text-center">
     <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> " class="btn btn-default">Book</a>
      <a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id']; ?> " class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <?php } ?>
     
        