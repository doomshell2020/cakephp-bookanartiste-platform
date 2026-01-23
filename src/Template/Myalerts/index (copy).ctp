<!----------------------page_search-strt----------------------->
  <section id="page_alert">
    <div class="container">
      <h2>Alerts </h2>
      <p class="m-bott-50">Here You Can See Job  alerts</p>
    </div>
    
    <div class="refine-search">
      <div class="container">
        <div class="row m-top-20 profile-bg">
          <div class="col-sm-3">
            <div class="panel panel-left">
            <ul class=" alrt-categry list-unstyled navff" >
			
			<?php  $allalerts =count($quotereceive)+count($bookingreceived)+count($quoteapplicationalerts)+ count($viewjobalerts); ?>
			<li class="active"><a href="#"class="jobalerts" data-action="alerts">All</a><span class="noti_f"><?php echo $allalerts; ?></span></li>
			<?php //Non Talent Status ?>
                <?php /* ?>
                    <li><a href="javascript:void(0);" class="jobalerts" data-action="applicationreceived">Application Received</a><span class="noti_f"><?php echo count($jobapplicationalerts); ?></span></li>
                    
					
					<li><a href="javascript:void(0);" class="jobalerts" data-action="quotereceived">  Quote Received</a><span class="noti_f"><?php echo count($quoteapplicationreceivedalerts); ?></span></li>
			
					<li><a href="javascript:void(0);" class="jobalerts" data-action="pingreceived">Ping Received</a><span class="noti_f"><?php echo count($pingalerts); ?></span></li>
			        <?php */ ?>
			<?php //Talent Status ?>
                    <li><a href="javascript:void(0);" class="jobalerts" data-action="jobalerts">Job Alerts</a><span class="noti_f"><?php echo count($viewjobalerts); ?></span></li>
                    <li><a href="javascript:void(0);" class="jobalerts" data-action="quotesent">Revised Quote Received</a><span class="noti_f"><?php echo count($quotereceive); ?></span></li>
					<li><a href="javascript:void(0);" class="jobalerts" data-action="bookingreceived">Booking Received</a><span class="noti_f"><?php echo count($bookingreceived); ?></span></li>
					
					<li><a href="javascript:void(0);" class="jobalerts" data-action="quoterequest">Quote Request Received</a><span class="noti_f"><?php echo count($quoteapplicationalerts); ?></span></li>
					
			</ul>
              
            </div>
			<img src="<?php echo SITE_URL; ?>/images/CB_Card.png">
          </div>
          
          
          <div class="col-sm-9">
	<?php if(count($quotereceive) > 0 || count($bookingreceived)> 0 || count($quoteapplicationalerts) > 0 || count($viewjobalerts) > 0){ ?>
				
				<?php  }else{?>
									<?php echo "No Alerts for you at the moment"; ?>

					<?php } ?>
            <div class="panel-right">
              <form>
				  
				  
				  				           <?php //------------Start Non Talented-----------// ?>
         <?php /////////////////////////////job alerts//////////////////////////?>
				  <?php foreach($viewjobalerts as $jobalertsss) { //pr($jobalertsss); ?>
              <div id="<?php echo $jobalertsss['id']; ?>" class="member-detail row alerts jobalerts <?php if($applicationrec['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($jobalertsss['image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/job/<?php echo $jobalertsss['image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
					 <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><?php echo $jobalertsss['title']; ?><span><?php echo date('Y-m-d H:m:s',strtotime($jobalertsss['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                     
                  <li>Requirement</li>
                    <li>Location </li>
                    
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                  
                    <li>:</li>
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                    
                    
                    <li><?php echo $jobalertsss['skillname']; ?></li>
					<li><?php echo $jobalertsss['location']; ?></li>
                    
                  </ul>
                  </div>
                   <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $jobalertsss['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $jobalertsss['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
               <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                              <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-val="<?php echo $jobalertsss['id'] ?>" data-action="jobalerts"> <i class="fa fa-times"aria-hidden="true"></i></a>	

                </div>
              </div>
         <?php } ?>
				  
				  
				  
				           <?php //------------Start Non Talented-----------// ?>
         <?php /////////////////////////////Application Received//////////////////////////?>
				  <?php foreach($jobapplicationalerts as $applicationrec) { //pr($applicationrec); ?>
              <div id="<?php echo $applicationrec['id']; ?>" class="member-detail row alerts applicationreceived <?php if($applicationrec['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($applicationrec['user']['profile']['profile_image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/profileimages/<?php echo $applicationrec['user']['profile']['profile_image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
					 <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><span><?php echo date('Y-m-d H:m:s',strtotime($applicationrec['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                       <li>Title</li>
                    <li>Requirement</li>
                    <li>Location </li>
                    
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                    <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $applicationrec['user']['id']; ?>"><?php echo $applicationrec['user']['profile']['name'];?></a></li>
                    
                    <li><?php if($applicationrec['user']['skillset'])
					{
					$knownskills = '';
					foreach($applicationrec['user']['skillset'] as $skillquote)
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
					}	?></li>
					<li><?php echo $applicationrec['user']['profile']['location'];?></li>
                    
                  </ul>
                  </div>
                   <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $applicationrec['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $applicationrec['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
               <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                              <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-val="<?php echo $applicationrec['id'] ?>" data-action="jobapplication" > <i class="fa fa-times"aria-hidden="true"></i></a>	

                </div>
              </div>
         <?php } ?>
         
         
        
         
           <?php /////////////////////////////Quote Receive//////////////////////////?>
         
          <?php foreach($quoteapplicationreceivedalerts as $quotereceialerts) { //pr($applicationrec); ?>
              <div id="<?php echo $quotereceialerts['id']; ?>" class="member-detail row alerts quotereceived <?php if($quotereceialerts['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($quotereceialerts['user']['profile']['profile_image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/profileimages/<?php echo $quotereceialerts['user']['profile']['profile_image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
					 <img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><span><?php echo date('Y-m-d H:m:s',strtotime($quotereceialerts['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                    <li>Title</li>
                    <li>Requirement</li>
                    <li>Location </li>
                    
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                    <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $quotereceialerts['user']['id']; ?>"><?php echo $quotereceialerts['user']['profile']['name'];?></a></li>
                    
                    <li><?php if($quotereceialerts['user']['skillset'])
					{
					$knownskills = '';
					foreach($quotereceialerts['user']['skillset'] as $skillquote)
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
					}	?></li>
					<li><?php echo $quotereceialerts['user']['profile']['location'];?></li>
                    
                  </ul>
                  </div>
                        <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quotereceialerts['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quotereceialerts['job_id']; ?>" class="btn btn-default cnt">Decline</a>


                </div>
               
                <div class="box_hvr_checkndlt">
            <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
            <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $quotereceialerts['id'] ?>"><i class="fa fa-times"aria-hidden="true"></i></a>	
                </div>
              </div>
         <?php } ?>
         
         
         
         
         
         
         
       
         
         
         
          <?php /////////////////////////////Ping Received//////////////////////////?>
         
          <?php foreach($pingalerts as $pingreceivedalerts) { //pr($applicationrec); ?>
              <div id="<?php echo $pingreceivedalerts['id']; ?>" class="member-detail row alerts pingreceived <?php if($pingreceivedalerts['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($pingreceivedalerts['user']['profile']['profile_image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/profileimages/<?php echo $pingreceivedalerts['user']['profile']['profile_image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
				<img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><span><?php echo date('Y-m-d H:m:s',strtotime($pingreceivedalerts['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                    <li>Title</li>
                    <li>Requirement</li>
                    <li>Location </li>
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                    <li><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pingreceivedalerts['user']['id']; ?>"><?php echo $pingreceivedalerts['user']['profile']['name'];?></a></li>
                    
                    <li><?php if($pingreceivedalerts['user']['skillset'])
					{
					$knownskills = '';
					foreach($pingreceivedalerts['user']['skillset'] as $skillquote)
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
					}	?></li>
					<li><?php echo $pingreceivedalerts['user']['profile']['location'];?></li>
                    
                  </ul>
                  </div>
                <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingreceivedalerts['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pingreceivedalerts['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
       <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                  <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $pingreceivedalerts['id'] ?>"><i class="fa fa-times"aria-hidden="true"></i></a>
                </div>
              </div>
         <?php } ?>
         
          <?php //------------End Non Talented-----------// ?>
         
         
         
         <?php //------------Start Talented-----------// ?>
     
         
        <?php // Quote sent// ?> 
         
          <?php foreach($quotereceive as $sendquote) { //pr($sendquote); ?>
              <div id="<?php echo $sendquote['id']; ?>" class="member-detail row alerts quotesent <?php if($sendquote['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($sendquote['requirement']['image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/job/<?php echo $sendquote['requirement']['image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><?php echo $sendquote['requirement']['title'];?><span><?php echo date('Y-m-d H:m:s',strtotime($sendquote['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                    <li>Requirement</li>
                    <li>Location </li>                    
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
              
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                 <li>
						  <?php if($sendquote['requirement']['requirment_vacancy'])
					{
					$knownskills = '';
					foreach($sendquote['requirement']['requirment_vacancy'] as $skillquote)
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
					}	?> </li>
                    
					<li><?php echo $sendquote['requirement']['location'];?></li>
                    
                  </ul>
                  </div>
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $sendquote['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
                 <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                  <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $sendquote['id'] ?>"><i class="fa fa-times"aria-hidden="true"></i></a>
                </div>
              </div>
         <?php } ?>
         
         
         
         
         
         <?php // Quote sent// ?> 
         
          <?php foreach($bookingreceived as $bookingrecalert) { //pr($bookingrecalert); ?>
              <div id="<?php echo $bookingrecalert['id']; ?>" class="member-detail row alerts bookingreceived <?php if($bookingrecalert['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($bookingrecalert['requirement']['image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/job/<?php echo $bookingrecalert['requirement']['image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
			<img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
					  
				  <h4><?php echo $bookingrecalert['requirement']['title'];?><span><?php echo date('Y-m-d H:m:s',strtotime($bookingrecalert['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
					       <li>Requirement</li> 
                    <li>Location</li>   
                               
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
              
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
					  <li>
						  <?php if($bookingrecalert['requirement']['requirment_vacancy'])
					{
					$knownskills = '';
					foreach($bookingrecalert['requirement']['requirment_vacancy'] as $skillquote)
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
					}	?> </li>
					<li><?php echo $bookingrecalert['requirement']['location'];?></li>
                    					

                  </ul>
                  </div>
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $bookingrecalert['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
                <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                      <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobapplication" data-val="<?php echo $bookingrecalert['id'] ?>"><i class="fa fa-times"aria-hidden="true"></i></a>
                </div>
              </div>
         <?php } ?>
         
       
                <?php // Ping Received// ?> 
         
           <?php foreach($quoteapplicationalerts as $quoterecapp) { //pr($quoterecapp); ?>
              <div id="<?php echo $quoterecapp['id']; ?>"  class="member-detail row alerts quoterequest <?php if($quoterecapp['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
				
			<?php if($quoterecapp['requirement']['image']!=''){ ?>
                <div class="col-sm-3">
                  <div class="member-detail-img"> 
					<img src="<?php echo SITE_URL;?>/job/<?php echo $quoterecapp['requirement']['image']; ?>">
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <?php }else{ ?>
					  <div class="col-sm-3">
                  <div class="member-detail-img"> 
				<img src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg"/>
                    <div class="img-top-bar"> <a href="#" class="fa fa-user"></a> </div>
                  </div>
                </div>
					<?php } ?>
                
                <div class="col-sm-9 boc_gap">
                  <div class="row">
				  <h4><?php echo $quoterecapp['requirement']['title']; ?><span><?php echo date('Y-m-d H:m:s',strtotime($quoterecapp['created']))?> </span></h4>
                  <ul class=" list-unstyled col-sm-4 member-info">
                    <li>Requirement</li>
                    <li> Location </li>                    
                    </ul>
                  <ul class="col-sm-2 list-unstyled">
                    <li>:</li>
                    <li>:</li>
              
                   
                  </ul>
                  <ul class="col-sm-6 list-unstyled">
                     <li>
						  <?php if($quoterecapp['requirement']['requirment_vacancy'])
					{
					$knownskills = '';
					foreach($quoterecapp['requirement']['requirment_vacancy'] as $skillquote)
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
					}	?> </li>
                    
					<li><?php echo $quoterecapp['requirement']['location'];?></li>
                    
                  </ul>
                  </div>
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quoterecapp['job_id']; ?>" class="btn btn-default ad">Accept</a>
                  
                  <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quoterecapp['job_id']; ?>" class="btn btn-default cnt">Decline</a>

                </div>
               
                <div class="box_hvr_checkndlt">
              <!--  <span class="pull-left"><input type="checkbox" value=""></span>-->
                    <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-action="jobquote" data-val="<?php echo $quoterecapp['id'] ?>"><i class="fa fa-times"aria-hidden="true"></i></a>
                </div>
              </div>
         <?php } ?>
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  
   <script>
$(document).ready(function(){
	var site_url='<?php echo SITE_URL;?>/';
	$('.delete_jobalerts').click(function() { 
 var job_id = $(this).data('val');
 $("#"+job_id).remove();
 var job_action = $(this).data('action');
   $.ajax({
        type: "post",
        url: site_url+'myalerts/alertsjob',
        data:{job:job_id,action:job_action},
        success:function(data){ 
			$("."+job_id).remove();
	 	    }
           
        });
 
 
});
});
	  </script>
  
  
       <script>
$(document).ready(function(){
    $(".jobalerts").click(function(){
		var val = $(this).data('action');
		$(".alerts").hide();
		 $("."+val).show();
    });
    
    var selector = '.navff li';

$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});
    
  });
</script>
  <!-------------------------------------------------->
