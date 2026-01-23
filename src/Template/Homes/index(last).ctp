<!----------------------slider-strt----------------------->
  <section id="slider">
    <!--<div class="icon-scroll-social"> <a href="#" class="fa fa-facebook bg-face"></a> <a href="#" class="fa fa-twitter bg-twt"></a> <a href="#" class="fa fa-pinterest bg-pin"></a> <a href="#" class="fa fa-linkedin bg-link"></a> </div>-->
    <div class="slide-caption">
      <h1>MOVE UP TO DAY!</h1>
      <p>Find Jobs, Talent, Employment & Career Opportunities</p>
      <div class="serch-bar">

        <?php echo $this->Form->create('Search',array('url' => array('controller' => 'search', 'action' => 'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form',)); ?>

          <div class="form-group">
            <div class="col-sm-5">
              
               <?php echo $this->Form->input('name',array('class'=>'form-control','label' =>false,'placeholder'=>'What are you looking for...','autocomplete'=>'off')); ?>
            </div>
            <div class="col-sm-3">
             <?php $opt= array('1'=>'Job','2'=>'Talent'); ?>
                  <?php echo $this->Form->input('optiontype',array('class'=>' form-control','required'=>true,'label' =>false,'type'=>'select','options'=>$opt,'autocomplete'=>'off')); ?>
            </div>
            <div class="col-sm-2">
             <button type="submit" class="btn btn-default">Submit</button></div>
            <div class="col-sm-2"> <a href="<?php echo SITE_URL; ?>/search/advanceJobsearch" class="btn btn-primary btn-block">Advance Search</a> </div>
          </div>
           <?php echo $this->Form->end(); ?>
      </div>
    </div>
    <div class="owl-carousel owl-theme owl-loaded slider">
      <div class="owl-item"><img src="images/slide-img.jpg" alt=""></div>
      <div class="owl-item"><img src="images/slide-img-2.jpg" alt=""></div>
      <div class="owl-item"><img src="images/slide-img.jpg" alt=""></div>
    </div>
    
  </section>
  <!--------------------------------------------------> 
  
  <!----------------------slider-bottom----------------------->
  
  <section id="slider-bottom">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <p class="text-left">We Help You Find Talent</p>
        </div>
        <div class="col-sm-4 text-right">
         <?php if($this->request->session()->read('Auth.User.id')){ ?>
			 <a href="<?php echo SITE_URL; ?>/jobpost/" class="btn btn-info">Post Your Requirement</a>
			
    <?php } else{ ?>
   <a href="#loginmodal" data-toggle="modal" onclick="assignloginaction('jobpost')" class="btn btn-info" data-action="jobpost">Post Your Requirement</a>
    <?php } ?>
          
        </div>
      </div>
    </div>
  </section>
  
  <!--------------------------------------------------> 
  
  <!----------------------Featured Artistes---------------------->
  <section id="col_Featured">
    <div class="container">
      <h2>Featured <span>Artistes</span></h2>
      <p class="m-bott-50">Here You Can See</p>
      <div class="owl-carousel owl-theme owl-loaded featured-list-carousal">
        
      
        <?php foreach($talent as $artistvalue){  ?>
        <div class="owl-item">
          <div class="artistes"> <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $artistvalue['profile']['user_id']; ?>"><img src="<?php echo SITE_URL ?>/profileimages/<?php  if($artistvalue['profile']['profile_image']) { echo $artistvalue['profile']['profile_image']; }else{ echo "edit-pro-img-upload.jpg"; }?>"></a>
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          <h5><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $artistvalue['profile']['user_id']; ?>"><?php echo $artistvalue['profile']['name']; ?></a></h5>
          <?php foreach ($artistvalue['skillset'] as $artistskill){ //pr($artistskill);?>
          
          <h6><?php echo $artistskill['skill']['name']; ?></h6>
          <?php } ?>
          <p><?php echo $artistvalue['profile'][0]['country']['name'];?></p>
        </div>
       <?php } ?>
      </div>
      <div class="text-center m-top-20">
	  <a href="<?php echo SITE_URL; ?>/featuredartist" class="btn btn-default" target="_blank" >View All</a>
      </div>
    </div>
  </section>
  
  <!--------------------------------------------------> 
  
  <!----------------------Featured jobs---------------------->
  <section id="col_Featured_jobs">
    <div class="container">
      <h2>Featured <span>Jobs</span></h2>
      <p class="m-bott-50">Here You Can See</p>
      <div class="clearfix job-box">
		  
		  <?php foreach($requirementfeatured as $featuredvalue){ //pr($featuredvalue); ?>
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="<?php echo SITE_URL ?>/job/<?php echo $featuredvalue['image'];?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>      
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="<?php echo SITE_URL ?>/applyjob/<?php echo $featuredvalue['id'];?>"><?php echo $featuredvalue['title']; ?> </a><span> <?php echo date('y-m-d H:m:s',strtotime($featuredvalue['last_date_app'])); ?></span></h3>
            <p><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $featuredvalue['user']['id']; ?>"><?php echo $featuredvalue['user']['profile']['name']; ?></a>  <span class="color-a"> | <?php echo $featuredvalue['location']; ?></span></p>
            <p class="selected"><?php echo $featuredvalue['talent_requirement_description']; ?></p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right">
				
			<a href="<?php echo SITE_URL ?>/applyjob/<?php echo $featuredvalue['id'];?>" class="btn btn-default">Apply</a>
				  
				  </div>
              <div class="col-sm-2 text-right"><a href="<?php echo SITE_URL ?>/applyjob/<?php echo $featuredvalue['id'];?>" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
      <?php } ?>
      

      </div>
      <div class="text-center m-top-20">
         <a href="<?php echo SITE_URL; ?>/featuredjob" class="btn btn-default" target="_blank" >View All</a>
      </div>
    </div>
  </section>
  
  <!--------------------------------------------------> 
  
  <!----------------------col_work_process---------------------->
  
  <section id="col_work_process">
    <div class="container">
      <h2>How It  <span>Work</span></h2>
      <p class="m-bott-50">Here You Can See</p>
      <div class="row">
        <ul class="nav nav-pills text-center">
          <li class="active"><a data-toggle="tab" href="#Got-Talent" class="hvr-bubble-bottom">Got Talent</a></li>
          <li><a data-toggle="tab" href="#Need-Talent" class="hvr-bubble-bottom">Need Talent</a></li>
        </ul>
        <div class="tab-content">
          <div id="Got-Talent" class="tab-pane fade in active">
            <div class="container">
              <ul class="progressbar">
                <li class="col-sm-3"><a href="#"><img src="images/work_1.png">
                  <p>Create Profile</p>
                  </a></li>
                <li class="col-sm-3"><a href="#"><img src="images/work_2.png">
                  <p>Search</p>
                  </a></li>
                <li class="col-sm-3"><a href="#"><img src="images/work_3.png">
                  <p>Apply</p>
                  </a></li>
                <li class="col-sm-3"><a href="#"><img src="images/work_4.png">
                  <p>Got Paid Directly</p>
                  </a></li>
              </ul>
            </div>
          </div>
          <div id="Need-Talent" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Some content in menu 1.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--------------------------------------------------> 
  
  <!----------------------col_so_net---------------------->
  <section id="col_so_net">
    <div class="container">
      <h2> <span>Features</span></h2>
      <p class="m-bott-50">Here You Can See</p>
      <div class="row">
        <div class="col-sm-5 social-net-blog"><img src="images/website-features.gif"></div>
        <div class="col-sm-7 social-net-blog-cntnt">
          
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_2.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6>Social Network</h6>
              <p> Add Friends, Manage Contacts, Create your own Network of Performers and reach out.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_3.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6>Personal Messages</h6>
              <p>Use Personal Messages to freely Share your thoughts and ideas.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_4.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6>Share With Friends</h6>
              <p>Spread the word about you, your work and what you do.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_5.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6>Activities</h6>
              <p>Let others see your likes, dislike and your preferences through the activities board.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_6.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6> Calender Management</h6>
              <p>Manage and Organise your day to day work, Get Notifications and Reminders.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_7.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6> Review Ratings</h6>
              <p>Give and receive detailed ratings about various work related parameters.</p>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_7.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6> Review Ratings</h6>
              <p>Give and receive detailed ratings about various work related parameters.</p>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2"><img src="images/acc_7.png" ></div>
            <div class="col-sm-10 netwrk-cntnt">
              <h6> Review Ratings</h6>
              <p>Give and receive detailed ratings about various work related parameters.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!--------------------------------------------------> 
  
  <!----------------------col_package---------------------->
  <section id="col_package">
    <div class="container">
      <h2> <span>Packages</span></h2>
      <p class="m-bott-50">Here You Can See</p>
      <div class="row">
        <ul class="nav nav-pills text-center">
          <li class="active"><a data-toggle="tab" href="#Profile" class="hvr-bubble-bottom">Profile</a></li>
          <li><a data-toggle="tab" href="#Requirement" class="hvr-bubble-bottom">Requirement</a></li>
          <li><a data-toggle="tab" href="#Recruiter" class="hvr-bubble-bottom">Recruiter</a></li>
        </ul>
        <div class="tab-content">
          <div id="Profile" class="tab-pane fade in active">
            <div class="col-sm-12 clearfix m-top-60">
				<?php foreach($Profilepack as $key=>$value){ //pr($value);
          $show_on_home_page = $value['show_on_home_page'];
         // echo $value['show_on_home_page'];
				 $show_on_home_page = unserialize($show_on_home_page);
				?>
              <div class="col-sm-4">
                <div class="package silver">
                  <h5><?php echo $value['packname']; ?> Package</h5>
                  <div class="price"><?php echo "$".$value['price'].".00"; ?><small><span>/</span><?php echo $value['validity_days'];?> days</small></div>
                   <ul class="list-unstyled">
				<?php if(in_array('number_audio',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_audio']; ?></b> Upload Audio </li>
				<?php } ?>
				<?php if(in_array('number_video',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_video']; ?></b> Upload Video</li>
				<?php } ?>
				<?php if(in_array('website_visibility',$show_on_home_page)){ ?>
				<li><b><?php echo $value['website_visibility']; ?></b> Visibility Of Personal Website</li>
				<?php } ?>
				<?php if(in_array('private_individual',$show_on_home_page)){ ?>
				<li><b><?php echo $value['private_individual']; ?></b> Private Messages</li>
				<?php } ?>
				<?php if(in_array('access_job',$show_on_home_page)){ ?>
				<li><b><?php echo $value['access_job']; ?></b> Job Access</li>
				<?php } ?>
				<?php if(in_array('privacy_setting_access',$show_on_home_page)){ ?>
				<li><b><?php echo $value['privacy_setting_access']; ?></b> Privacy Setting Access</li>
				<?php } ?>
				<?php if(in_array('access_to_ads',$show_on_home_page)){ ?>
				<li><b><?php echo $value['access_to_ads']; ?></b> Access To Advertise</li>
				<?php } ?>
				<?php if(in_array('number_job_application',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_job_application']; ?></b> Job Application Per Month</li>
				<?php } ?>
				<?php if(in_array('number_search',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_search']; ?></b> Searches Other Profile</li>
				<?php } ?>
				<?php if(in_array('ads_free',$show_on_home_page)){ ?>
				<li><b><?php echo $value['ads_free']; ?></b> AD Free Experience</li>
				<?php } ?>
				<?php if(in_array('number_albums',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_albums']; ?></b> Photos Albums</li>
				<?php } ?>
				<?php if(in_array('number_of_photo',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_of_photo']; ?></b> Photos </li>
				<?php } ?>
				<?php if(in_array('number_of_jobs_alerts',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_of_jobs_alerts']; ?></b> Job Alerts Per Month </li>
				<?php } ?>
				<?php if(in_array('introduction_sent',$show_on_home_page)){ ?>
				<li><b><?php echo $value['introduction_sent']; ?></b> Total No. of Introductions Sent</li>
				<?php } ?>
				<?php if(in_array('number_of_intorduction_send',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_of_intorduction_send']; ?></b> Total No. of Introductions Sent Per Day</li>
				<?php } ?>
				<?php if(in_array('number_of_introduction',$show_on_home_page)){ ?>
				<li><b><?php echo $value['number_of_introduction']; ?></b> Total No. of Introductions Recieved</li>
				<?php } ?>
				<?php if(in_array('nubmer_of_jobs',$show_on_home_page)){ ?>
				<li><b><?php echo $value['nubmer_of_jobs']; ?></b> Job Posting</li>
				<?php } ?>
				<?php if(in_array('ping_price',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['ping_price']; ?></b> Ask for Quote’ Request Per Job</li>
				<?php } ?>
				<?php if(in_array('introduction_sent',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['introduction_sent']; ?></b> No. of Introduction Send Per Day</li>
				<?php } ?>
				<?php if(in_array('ping_price',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['ping_price']; ?></b> No. of Search Profile</li>
				<?php } ?>
				<?php if(in_array('job_alerts_month',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['job_alerts_month']; ?></b> No. of Jobs Alerts Per Month</li>
				<?php } ?>
				<?php if(in_array('job_alerts',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['job_alerts']; ?></b> No. of Jobs Alerts in Package</li>
				<?php } ?>
				<?php if(in_array('proiorties',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['proiorties']; ?></b> Proiorties</li>
				<?php } ?>
				<?php if(in_array('number_of_free_quote_month',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['number_of_free_quote_month']; ?></b>  Free Quote Month</li>
				<?php } ?>
				<?php if(in_array('number_of_free_day',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['number_of_free_day']; ?></b> Ask for Quote’ Request Per Day</li>
				<?php } ?>
				<?php if(in_array('message_folder',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['message_folder']; ?></b> Message Folder</li>
				<?php } ?>
				<?php if(in_array('number_of_booking',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['number_of_booking']; ?></b> Booking Requests Request Per Job</li>
				<?php } ?>
				<?php if(in_array('profile_likes',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['profile_likes']; ?></b> Total No. of Profile Likes Given Per Day</li>
				<?php } ?>
				<?php if(in_array('number_categories',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['number_categories']; ?></b> Skills</li>
				<?php } ?>
				<?php if(in_array('Visibility_Priority',$show_on_home_page)){ ?>
				<li><b> <?php echo $value['Visibility_Priority']; ?></b> Visibility Priority</li>
				<?php } ?>
				

                  </ul>
                    <div class="text-center"><form class="form-horizontal">

                    </form></div>
                  <div class="text-center"><a href="<?php echo SITE_URL; ?>/package/buy/profilepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
                 </div>
                 <div class="text-center"> <a href="<?php echo SITE_URL ?>/profilepackage">Learn More</a></div>
                </div>
              </div>
             
            <?php } ?>
            
            </div>
          </div>
          <div id="Requirement" class="tab-pane fade">
            <div class="col-sm-12 clearfix m-top-60">
<?php foreach($RequirementPack as $key=>$value){ //pr($value);?>
              <div class="col-sm-4">
                <div class="package silver">
                  <h5><?php echo $value['name']; ?> Package</h5>
                  <div class="price"><?php echo "$".$value['price'].".00"; ?><small><span>/</span>Requirement</small></div>
                <ul class="list-unstyled">
					 <li>Requirement for <b><?php echo $value['number_of_days']; ?> </b> Days</li>
                  </ul>
                    <div class="text-center"><form class="form-horizontal">
                    </form></div>
                  <div class="text-center"><a href="<?php echo SITE_URL; ?>/package/buy/requirementpackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
                 </div>
                 <div class="text-center"> <a href="<?php echo SITE_URL ?>/requirementpackage">Learn More</a></div>
                </div>
              </div>
            <?php } ?>
            </div>
          </div>
          <div id="Recruiter" class="tab-pane fade">
            <div class="col-sm-12 clearfix m-top-60">
            <?php foreach($RecuriterPack as $key=>$value){ //pr($value);?>
              <div class="col-sm-4">
                <div class="package silver">
                  <h5><?php echo $value['title']; ?> Package</h5>
                  <div class="price"><?php echo "$".$value['price'].".00"; ?><small><span>/</span><?php echo $value['validity_days'];?> days</small></div>
					  <ul class="list-unstyled">
					 <li><b><?php echo $value['number_of_job_post']; ?></b> Job post </li>
					 <!--<li><b>	<?php echo $value['number_of_job_simultancney']; ?></b> Job Simultancney</li>-->
					 <!--<li><b>    <?php echo $value['priorites']; ?></b> Job Priorites</li>-->
					 <li><b>  <?php echo $value['nubmer_of_site']; ?></b> Website</li>
					 <li><b> <?php echo $value['number_of_message']; ?></b> Private Message </li>
					   <!--<li><b><?php echo $value['number_of_contact_details']; ?></b> Contact Details </li> -->
					  <li><b><?php echo $value['number_of_talent_search']; ?></b> Talent Search </li>
					  <!--<li><b>  <?php echo $value['lengthofpackage']; ?></b> Length of Package</li>-->
					  <!--<li><b> <?php echo $value['multiple_email_login']; ?></b> Multiple email login</li> -->
					  <!--<li><b> <?php echo $value['number_of_email']; ?></b> Emails</li>-->
					 <!--<li><b>  <?php echo $value['creadit_limit']; ?></b> Credit Limit</li> -->
					  <!--<li><b> <?php echo $value['ping_price']; ?> </b> Ping Price</li>-->

                  </ul>
                    <div class="text-center"><form class="form-horizontal">
                    </form></div>
                  <div class="text-center"><a href="<?php echo SITE_URL; ?>/package/buy/recruiterepackage/<?php echo $value['id']; ?>" class="btn btn-default">Choose Plan</a>
                 </div>
                 <div class="text-center"> <a href="<?php echo SITE_URL ?>/package/allpackages/recruiterepackage">Learn More</a></div>
                </div>
              </div>
             
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!--------------------------------------------------> 
