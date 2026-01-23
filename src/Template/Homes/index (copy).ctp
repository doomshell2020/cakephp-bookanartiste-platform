<!----------------------slider-strt----------------------->
  <section id="slider">
    <!--<div class="icon-scroll-social"> <a href="#" class="fa fa-facebook bg-face"></a> <a href="#" class="fa fa-twitter bg-twt"></a> <a href="#" class="fa fa-pinterest bg-pin"></a> <a href="#" class="fa fa-linkedin bg-link"></a> </div>-->
    <div class="slide-caption">
      <h1>MOVE UP TO DAY!</h1>
      <p>Find Jobs, Talent, Employment & Career Opportunities</p>
      <div class="serch-bar">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-5">
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-3">
              <select class="form-control">
                <option>Jobs</option>
                <option>Talents</option>
              </select>
            </div>
            <div class="col-sm-2"> <a href="#" class="btn btn-default btn-block">Search</a> </div>
            <div class="col-sm-2"> <a href="#" class="btn btn-primary btn-block">Advance Search</a> </div>
          </div>
        </form>
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
          <button type="button" class="btn btn-info">Post Your Requirement</button>
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
        
        
        <?php foreach($talent as $artistvalue){ //pr($artistvalue); ?>
        <div class="owl-item">
          <div class="artistes"> <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $artistvalue['profile'][0]['user_id']; ?>"><img src="<?php echo SITE_URL ?>/profileimages/<?php echo $artistvalue['profile'][0]['profile_image'];?>"></a>
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          <h5><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $artistvalue['profile'][0]['user_id']; ?>"><?php echo $artistvalue['profile'][0]['name']; ?></a></h5>
          <?php foreach ($artistvalue['skillset'] as $artistskill){ //pr($artistskill);?>
          
          <h6><?php echo $artistskill['skill']['name']; ?></h6>
          <?php } ?>
          <p><?php echo $artistvalue['profile'][0]['country']['name'];?></p>
        </div>
       <?php } ?>
      </div>
      <div class="text-center m-top-20">
        <button class="btn btn-default">View All</button>
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
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_1.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
            <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
            <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_2.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
            <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
            <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_3.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
            <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
            <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_1.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
            <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
            <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 job-card">
          <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_2.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
          <div class="col-sm-10">
            <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
            <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
            <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
            <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
          </div>
        </div>
        <div class="job-box-inner">
          <div class="col-sm-12 job-card">
            <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_3.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
            <div class="col-sm-10">
              <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
              <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
              <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
              <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
            </div>
          </div>
          <div class="col-sm-12 job-card">
            <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_1.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
            <div class="col-sm-10">
              <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
              <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
              <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
              <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
            </div>
          </div>
          <div class="col-sm-12 job-card">
            <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_2.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
            <div class="col-sm-10">
              <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
              <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
              <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
              <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
            </div>
          </div>
          <div class="col-sm-12 job-card">
            <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_3.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
            <div class="col-sm-10">
              <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
              <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
              <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
              <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
            </div>
          </div>
          <div class="col-sm-12 job-card">
            <div class="col-sm-2">
          <div class="fea-img"> <img src="images/job_1.jpg">
            <div class="arist-circle">
              <div class="artist-inner-circle">
                <div class="arist-circle-inner"> <a href="#"><i class="fa fa-user"></i></a> </div>
              </div>
            </div>
          </div>
          
          
          
          
         </div>
            <div class="col-sm-10">
              <h3 class="heading"><a href="#">Autumn 2017 Graduate Opportunities</a><span>January 23 2015</span></h3>
              <p>Expo soft Company<span class="color-a">| New York, NY 10011</span></p>
              <p class="selected">Lorem ipsum dolor sit amet consectetur adipisicing  labore et dolore magna aliqua uat veniama icing elit sed do</p>
              <div class="row">
              <div class="col-sm-8">
                <div id="popoverbtn"></div>
                <button type="button" onclick="$('#popoverbtn').popover('toggle');">share</button>
                <button type="button" >save</button>
              </div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Apply Job</a></div>
              <div class="col-sm-2 text-right"><a href="#" class="btn btn-default">Send Quote</a></div>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center m-top-20">
        <button class="btn btn-default">View All</button>
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
				<?php foreach($Profilepack as $key=>$value){ //pr($value);?>
              <div class="col-sm-4">
                <div class="package silver">
                  <h5><?php echo $value['packname']; ?> Package</h5>
                  <div class="price"><?php echo "$".$value['price'].".00"; ?><small><span>/</span>month</small></div>
                   <ul class="list-unstyled">
					 <li><b><?php echo $value['number_audio']; ?></b> Upload Audio </li>
					 <li><b>	<?php echo $value['number_video']; ?></b> Upload Video</li>
					 <!--<li><b>    <?php //echo $value['website_visibility']; ?></b> Visibility Of Persoanl Website</li>-->
					 <li><b>  <?php echo $value['private_individual']; ?></b> Private Messages</li>
					 <li><b> <?php echo $value['access_job']; ?></b> Job Access</li>
					 <!-- <li><b><?php //echo $value['privacy_setting_access']; ?></b> Privacy Setting Access</li>
					  <li><b><?php //echo $value['access_to_ads']; ?></b> Access To Advertise</li>-->

					  <li><b>  <?php echo $value['number_job_application']; ?></b> Job Application Per Month</li>
					 <!-- <li><b> <?php //echo $value['number_search']; ?></b> Searches Other Profile</li>-->
					  <!--<li><b> <?php //echo $value['ads_free']; ?></b> AD Free Experience</li>-->
					 <li><b>  <?php echo $value['number_albums']; ?></b> Photos Albums</li>
					<li><b> <?php echo $value['number_of_photo']; ?></b> Photos </li>
					  <li><b> <?php echo $value['number_of_jobs_alerts']; ?></b> Job Alerts Per Month </li>
					 <!-- <li><b> <?php //echo $value['introduction_sent']; ?></b> Total No. of Introductions Sent</li>
					  <li><b> <?php //echo $value['number_of_intorduction_send']; ?></b> Total No. of Introductions Sent Per Day</li>
					  <li><b> <?php //echo $value['number_of_introduction']; ?></b> Total No. of Introductions Recieved</li>-->
					  <li><b> <?php echo $value['nubmer_of_jobs']; ?></b> Job Posting</li>
					  
					 <!-- <li><b> <?php //echo $value['ping_price']; ?></b> Ask for Quote’ Request Per Job</li>
					  <li><b> <?php //echo $value['introduction_sent']; ?></b> No. of Introduction Send Per Day</li>-->
					  <!--<li><b> <?php //echo $value['ping_price']; ?></b> No. of Search Profile</li>-->
					<!--  <li><b> <?php //echo $value['job_alerts_month']; ?></b> No. of Jobs Alerts Per Month</li>-->
					<!--  <li><b> <?php //echo $value['job_alerts']; ?></b> No. of Jobs Alerts in Package</li>-->
					  <!--<li><b> <?php //echo $value['proiorties']; ?></b> Proiorties</li>-->
					  <li><b> <?php echo $value['number_of_free_quote_month']; ?></b>  Free Quote Month</li>
					  <li><b> <?php echo $value['number_of_free_day']; ?></b> Ask for Quote’ Request Per Day</li>
					  <li><b> <?php echo $value['message_folder']; ?></b> Message Folder</li>
					  <li><b> <?php echo $value['number_of_booking']; ?></b> Booking Requests Request Per Job</li>
					<!-- <li><b> <?php //echo $value['profile_likes']; ?></b> Total No. of Profile Likes Given Per Day</li>-->
					 <!--<li><b> <?php //echo $value['persanalized_url']; ?></b> Personalized url</li>-->
					  <li><b> <?php echo $value['number_categories']; ?></b> Skills</li>
					 <!-- <li><b> <?php //echo $value['Visibility_Priority']; ?></b> Visibility Priority</li>-->

                  </ul>
                    <div class="text-center"><form class="form-horizontal">

                    </form></div>
                  <div class="text-center"><a href="#" class="btn btn-default">Choose Plan</a>
                 </div>
                <!-- <div class="text-center"> <a href="#"> Trial for Free</a></div>-->
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
                  <div class="text-center"><a href="#" class="btn btn-default">Choose Plan</a>
                 </div>
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
                  <div class="price"><?php echo "$".$value['price'].".00"; ?><small><span>/</span>month</small></div>
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
                  <div class="text-center"><a href="#" class="btn btn-default">Choose Plan</a>
                 </div>
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
