<?php echo $this->element('viewprofile') ?>
 
    <div class="col-sm-9 my-info">


	<div class="View-review-det">
		<?php 
		$bad = array('0.5','0.6','0.7','0.8','0.9','1.0','1.1','1.2','1.3','1.4','1.5','1.6','1.7','1.8','1.9','2.0','2.1','2.2','2.3','2.4','2.5','2.6','2.7');
		$belowavgreviews = array('2.8','2.9','3.0','3.1','3.2','3.3','3.4','3.5','3.6','3.7','3.8','3.9','4.0','4.1','4.2','4.3','4.4','4.5','4.6','4.7',);
		$averagereviews = array('4.8','4.9','5.0','5.1','5.2','5.3','5.4','5.5','5.6','5.7','5.8','5.9','6.0','6.1','6.2','6.3','6.4','6.5','6.5','6.5','6.5','6.5','6.5','6.0','6.1','6.2','6.3','6.4','6.5','6.6','6.7');
		$goodreviews = array('6.8','6.9','7.0','7.1','7.2','7.3','7.4','7.5','7.6','7.7','7.8','7.9','8.0','8.1','8.2','8.3','8.4','8.5','8.6','8.7');
		$excellentreviews = array('8.8','8.9','9.0','9.1','9.2','9.3','9.4','9.6','9.7','9.8','9.9','10');
	if (in_array($jobavgreview, $bad))
	{	  
	 $raingname = "Bad";
  }elseif(in_array($jobavgreview, $belowavgreviews)){	  
	 $raingname =  "Below Average";
  }elseif(in_array($jobavgreview, $averagereviews)){
	 $raingname = "Average";
  }elseif(in_array($jobavgreview, $goodreviews)){
	 $raingname =  "Good";
  }elseif(in_array($jobavgreview, $excellentreviews)){
	 $raingname =  "Excellent";
  }
		?>
		<?php   if(count($review)>0){   //$jobavgreview=2;?>
	<div class="clearfix rating_rivew ">
	<h4 class="pull-left"><?php echo $raingname; ?><span></span></span>-</h4>
  <fieldset id='demo1' class="ratingusers">
                     <input class="stars dd" type="radio" id="starr0110" name="r01" value="10"  <?php if( $jobavgreview==9.8 || $jobavgreview==9.9 || $jobavgreview==10){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr0110" title="Excellent"></span>
                        
                    
                      <input class="stars dd" type="radio" id="starr0110" name="r01" value="10"  <?php if( $jobavgreview==9.8 || $jobavgreview==9.9 || $jobavgreview==10){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr0110" title="Excellent"></span>
                        
                        <input class="stars dd" type="radio" id="starr019half" name="r01" value="9.5" <?php if($jobavgreview==9.3 ||$jobavgreview==9.4 ||$jobavgreview==9.5 || $jobavgreview==9.6 || $jobavgreview==9.7){ echo "checked"; }?>  disabled />
                        <span class = "review half" for="starr019half" title="Excellent"></span>
                        
                        <input class="stars dd" type="radio" id="starr019" name="r01" value="9" <?php if( $jobavgreview==8.8 || $jobavgreview==8.9 || $jobavgreview==9.0 || $jobavgreview==9.1 || $jobavgreview==9.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr019" title="Very Good"></span>
                        
                        
                        <input class="stars dd" type="radio" id="starr018half" name="r01" value="8.5" <?php if($jobavgreview==8.3 ||$jobavgreview==8.4 ||$jobavgreview==8.5 || $jobavgreview==8.6 || $jobavgreview==8.7){ echo "checked"; }?>  disabled />
                        <span class = "review half" for="starr018half" title="Very Good"></span>
                        
                        <input class="stars dd" type="radio" id="starr018" name="r01" value="8" <?php if( $jobavgreview==7.8 || $jobavgreview==7.9 || $jobavgreview==8.0 || $jobavgreview==8.1|| $jobavgreview==8.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr018" title="Good"></span>
                    
                    
						<input class="stars dd" type="radio" id="starr017half" name="r01" value="7.5" <?php if($jobavgreview==7.3 ||$jobavgreview==7.4 ||$jobavgreview==7.5 || $jobavgreview==7.6 || $jobavgreview==7.7){ echo "checked"; }?> disabled />
                        <span class = "review half" for="starr017half" title="Good"></span>
                        
                        <input class="stars dd" type="radio" id="starr017" name="r01" value="7" <?php if( $jobavgreview==6.8 || $jobavgreview==6.9 || $jobavgreview==7.0 || $jobavgreview==7.1 || $jobavgreview==7.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr017" title="Above Average"></span>
                    
						<input class="stars dd" type="radio" id="starr016half" name="r01" value="6.5" <?php if($jobavgreview==6.3 ||$jobavgreview==6.4 ||$jobavgreview==6.5 || $jobavgreview==6.6 || $jobavgreview==6.7){ echo "checked"; }?> disabled />
                        <span class = "review half" for="starr016half" title="Above Average"></span>
                    
                    
						<input class="stars dd" type="radio" id="starr016" name="r01" value="6" <?php if( $jobavgreview==5.8 || $jobavgreview==5.9 || $jobavgreview==6.0|| $jobavgreview==6.1|| $jobavgreview==6.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr016" title="Average"></span>
                    
						<input class="stars dd" type="radio" id="starr015half" name="r01" value="5.5" <?php if($jobavgreview==5.3 ||$jobavgreview==5.4 ||$jobavgreview==5.5 || $jobavgreview==5.6 || $jobavgreview==5.7){ echo "checked"; }?> disabled />
                        <span class = "review half" for="starr015half" title="Average"></span>
                    
                        <input class="stars" type="radio" id="starr015" name="r01" value="5" <?php if( $jobavgreview==4.8 || $jobavgreview==4.9 || $jobavgreview==5.0|| $jobavgreview==5.1|| $jobavgreview==5.2){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr015" title="Average"></span>
                        
                        <input class="stars" type="radio" id="starr014half" name="r01" value="4.5" <?php if($jobavgreview==4.3 ||$jobavgreview==4.4 ||$jobavgreview==4.5 || $jobavgreview==4.6 || $jobavgreview==4.7){ echo "checked"; }?> disabled />
                        <span class="review half" for="starr014half" title="Average"></span>
                        
                        <input class="stars" type="radio" id="starr014" name="r01" value="4" <?php if($jobavgreview==3.8 ||$jobavgreview==3.9 ||$jobavgreview==4.0|| $jobavgreview==4.1 ||$jobavgreview==4.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr014" title="Below average"></span>
                        
                        <input class="stars" type="radio" id="starr013half" name="r01" value="3.5" <?php if($jobavgreview==3.3 || $jobavgreview==3.4 || $jobavgreview==3.5 || $jobavgreview==3.6 || $jobavgreview==3.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr013half" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr013" name="r01" value="3" <?php if( $jobavgreview==2.8 || $jobavgreview==2.9 || $jobavgreview==3.0 || $jobavgreview==3.1 ||$jobavgreview==3.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr013" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr012half" name="r01" value="2.5" <?php if($jobavgreview==2.3 || $jobavgreview==2.4 || $jobavgreview==2.5 || $jobavgreview==2.6 || $jobavgreview==2.7 ){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr012half" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr012" name="r01" value="2" <?php if($jobavgreview==1.8 || $jobavgreview==1.9 || $jobavgreview==2 || $jobavgreview==2.1 || $jobavgreview==2.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr012" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr011half" name="r01" value="1.5" <?php if($jobavgreview==1.3 || $jobavgreview==1.4 || $jobavgreview==1.5 || $jobavgreview==1.6 || $jobavgreview==1.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr011half" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr011" name="r01" value="1" <?php if($jobavgreview==0.8 || $jobavgreview==0.9 || $jobavgreview==1||$jobavgreview==1.1||$jobavgreview==1.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr011" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr01half" name="r01" value="0.5" <?php if($jobavgreview['r1']==0.5 ||$jobavgreview==0.6 || $jobavgreview==0.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr01half" title="Bad"></span>
                    </fieldset>
		   
	</div>
    
    <?php $totalnumberrating = $excellentreview+$goodreview+$averagereview+$belowavgreview+$badreview;

    
     ?>

	<div class="review_bars">
    <div class="row">
    <div class="col-sm-3">
    <ul>
    <li> Total Number of Rating</li>
    <li> Excellent</li>
    <li> Good</li>
    <li> Average</li>
    <li> Below Average</li>
    <li> Bad</li>
    </ul>
    </div>
    <div class="col-sm-5 ">
    <ul>
    <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $totalnumberrating; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $totalnumberrating."%"; ?>">
    <span class="title"><?php echo $totalnumberrating; ?></span>
    </div>
  </li>
  <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $excellentreview; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $excellentreview."%"; ?>">
    <span class="title"><?php echo $excellentreview; ?></span>
    </div>
  </li>
  <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $goodreview; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $goodreview."%"; ?>">
    <span class="title"><?php echo $goodreview; ?></span>
    </div>
  </li>
  <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $averagereview; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $averagereview."%"; ?>">
    <span class="title"><?php echo $averagereview; ?></span>
    </div>
  </li>
  <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $belowavgreview; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $belowavgreview."%"; ?>">
    <span class="title"><?php echo $belowavgreview; ?></span>
    </div>
  </li>
  <li class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $badreview; ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo $badreview."%"; ?>">
    <span class="title"><?php echo $badreview; ?></span>
    </div>
  </li>
</ul>
    
    
    </div>
    
    <div class="col-sm-4"></div>
    
    </div>
    </div>
    
    <?php 
	//pr($activities);
	
	foreach($review as $reviewusers){ //pr($reviewusers); ?>
		
		
	    
    <div class="review_box">
    <div class="row">
    <div class="col-sm-3">
		<a href= "<?php echo SITE_URL; ?>/viewprofile/<?php echo $reviewusers['user']['id']; ?> ">
    <!-- <img src="<?php echo SITE_URL ?>/job/<?php echo $reviewusers['requirement']['image'];?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/review_img.jpg';"></a> -->
    <div class=""><i class="fa fa-user"></i> <a href= "<?php echo SITE_URL; ?>/viewprofile/<?php echo $reviewusers['user']['id']; ?> "><?php echo $reviewusers['user']['profile']['name']; ?></a></div> 
    <div class=""><i class="fa fa-map-marker"></i> <?php echo $reviewusers['user']['profile']['city']['name']; ?>,<?php echo $reviewusers['user']['profile']['country']['name']; ?></div>
    </div>
    <div class="col-sm-9">
        
    <div class="clearfix">
        <a data-toggle="modal" class='quickrevpop' style="color: #000;"  href="<?php echo SITE_URL?>/profile/quickreviewshow/<?php echo $reviewusers['job_id']; ?>/<?php echo $reviewusers['artist_id']; ?> ">
       <h4 class="pull-left"><?php echo $reviewusers['briefimpression'];?></h4></a>
    
    <span class="pull-right"><?php echo date('d-M-Y, H:m',strtotime($reviewusers['created']));?></span></div>
    
   <div class="review">
        <a data-toggle="modal" class='quickrevpop' style="color: #000;"  href="<?php echo SITE_URL?>/profile/quickreviewshow/<?php echo $reviewusers['job_id']; ?>/<?php echo $reviewusers['artist_id']; ?> ">
                      <fieldset id='demo1' class="ratingusers">
                    
                      <input class="stars" type="radio" id="starr010<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="10" <?php if( $reviewusers['avgrating']==9.8 || $reviewusers['avgrating']==9.9 || $reviewusers['avgrating']==10){ echo "checked"; }?> disabled / >
                        <span class = "review full" for="starr010<?php echo $reviewusers['id']; ?>" title="Excellent"></span>
                        
                        <input class="stars" type="radio" id="starr09half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="9.5" <?php if($reviewusers['avgrating']==9.3 ||$reviewusers['avgrating']==9.4 ||$reviewusers['avgrating']==9.5 || $reviewusers['avgrating']==9.6 || $reviewusers['avgrating']==9.7){ echo "checked"; }?> disabled / >
                        <span class = "review half" for="starr09half<?php echo $reviewusers['id']; ?>" title="Excellent"></span>
                        
                        <input class="stars" type="radio" id="starr019<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="9" <?php if( $reviewusers['avgrating']==8.8 || $reviewusers['avgrating']==8.9 || $reviewusers['avgrating']==9.0 || $reviewusers['avgrating']==9.1 || $reviewusers['avgrating']==9.2){ echo "checked"; }?> disabled / >
                        <span class = "review full" for="starr09<?php echo $reviewusers['id']; ?>" title="Very Good"></span>
                        
                        <input class="stars" type="radio" id="starr08half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="8.5" <?php if($reviewusers['avgrating']==8.3 ||$reviewusers['avgrating']==8.4 ||$reviewusers['avgrating']==8.5 || $reviewusers['avgrating']==8.6 || $reviewusers['avgrating']==8.7){ echo "checked"; }?> disabled / >
                        <span class = "review half" for="starr08half<?php echo $reviewusers['id']; ?>" title="Very Good"></span>
                        
                        <input class="stars" type="radio" id="starr08<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="8" <?php if( $reviewusers['avgrating']==7.8 || $reviewusers['avgrating']==7.9 || $reviewusers['avgrating']==8.0|| $reviewusers['avgrating']==8.1 || $reviewusers['avgrating']==8.2){ echo "checked"; }?> disabled / >
                        <span class = "review full" for="starr08<?php echo $reviewusers['id']; ?>" title="Good"></span>
                    
                    
						<input class="stars" type="radio" id="starr07half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="7.5" <?php if($reviewusers['avgrating']==7.3 ||$reviewusers['avgrating']==7.4 ||$reviewusers['avgrating']==7.5 || $reviewusers['avgrating']==7.6 || $reviewusers['avgrating']==7.7){ echo "checked"; }?> disabled / >
                        <span class = "review half" for="starr07half<?php echo $reviewusers['id']; ?>" title="Good"></span>
                        
                        <input class="stars" type="radio" id="starr07<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="7" <?php if( $reviewusers['avgrating']==6.8 || $reviewusers['avgrating']==6.9 || $reviewusers['avgrating']==7.0 || $reviewusers['avgrating']==7.1 || $reviewusers['avgrating']==7.2 ){ echo "checked"; }?> disabled / >
                        <span class = "review full" for="starr07<?php echo $reviewusers['id']; ?>" title="Above Average"></span>
                    
						<input class="stars" type="radio" id="starr06half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="6.5" <?php if($reviewusers['avgrating']==6.3 ||$reviewusers['avgrating']==6.4 ||$reviewusers['avgrating']==6.5 || $reviewusers['avgrating']==6.6 || $reviewusers['avgrating']==6.7){ echo "checked"; }?> disabled / >
                        <span class = "review half" for="starr06half<?php echo $reviewusers['id']; ?>" title="Above Average"></span>
                    
                    
						<input class="stars" type="radio" id="starr06<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="6" <?php if( $reviewusers['avgrating']==5.8 || $reviewusers['avgrating']==5.9 || $reviewusers['avgrating']==6.0 || $reviewusers['avgrating']==6.1 || $reviewusers['avgrating']==6.2){ echo "checked"; }?> disabled / >
                        <span class = "review full" for="starr06<?php echo $reviewusers['id']; ?>" title="Average"></span>
                    
						<input class="stars" type="radio" id="starr05half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="5.5"  <?php if($reviewusers['avgrating']==5.3 || $reviewusers['avgrating']==5.4 || $reviewusers['avgrating']==5.5 || $reviewusers['avgrating']==5.6 || $reviewusers['avgrating']==5.7){ echo "checked"; }?> disabled / >
                        <span class = "review half" for="starr05half<?php echo $reviewusers['id']; ?>" title="Average"></span>
                        
                    
                        <input class="stars" type="radio" id="starr05 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="5" <?php if( $reviewusers['avgrating']==4.8 || $reviewusers['avgrating']==4.9 || $reviewusers['avgrating']==5.0 || $reviewusers['avgrating']==5.1 || $reviewusers['avgrating']==5.2){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr05 <?php echo $reviewusers['id']; ?>" title="Average"></span>
                        
                        <input class="stars" type="radio" id="starr04half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['avgrating']==4.3 ||$reviewusers['avgrating']==4.4 ||$reviewusers['avgrating']==4.5 || $reviewusers['avgrating']==4.6 || $reviewusers['avgrating']==4.7){ echo "checked"; }?> disabled />
                        <span class="review half" for="starr04half <?php echo $reviewusers['id']; ?>" title="Average"></span>
                        
                        <input class="stars" type="radio" id="starr04 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['avgrating']==3.8 ||$reviewusers['avgrating']==3.9 ||$reviewusers['avgrating']==4.0|| $reviewusers['avgrating']==4.1 ||$reviewusers['avgrating']==4.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr04 <?php echo $reviewusers['id']; ?>" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr03half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['avgrating']==3.3 || $reviewusers['avgrating']==3.4 || $reviewusers['avgrating']==3.5 || $reviewusers['avgrating']==3.6 || $reviewusers['avgrating']==3.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr03half <?php echo $reviewusers['id']; ?>" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr03 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="3" <?php if( $reviewusers['avgrating']==2.8 || $reviewusers['avgrating']==2.9 || $reviewusers['avgrating']==3.0 || $reviewusers['avgrating']==3.1 ||$reviewusers['avgrating']==3.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr03 <?php echo $reviewusers['id']; ?>" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr02half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['avgrating']==2.3 || $reviewusers['avgrating']==2.4 || $reviewusers['avgrating']==2.5 || $reviewusers['avgrating']==2.6 || $reviewusers['avgrating']==2.7 ){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr02half <?php echo $reviewusers['id']; ?>" title="Below Average"></span>
                        
                        <input class="stars" type="radio" id="starr02 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['avgrating']==1.8 || $reviewusers['avgrating']==1.9 || $reviewusers['avgrating']==2 || $reviewusers['avgrating']==2.1 || $reviewusers['avgrating']==2.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr02 <?php echo $reviewusers['id']; ?>" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr01half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['avgrating']==1.3 || $reviewusers['avgrating']==1.4 || $reviewusers['avgrating']==1.5 || $reviewusers['avgrating']==1.6 || $reviewusers['avgrating']==1.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr01half <?php echo $reviewusers['id']; ?>" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr01 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['avgrating']==0.8 || $reviewusers['avgrating']==0.9 || $reviewusers['avgrating']==1||$reviewusers['avgrating']==1.1||$reviewusers['avgrating']==1.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr01 <?php echo $reviewusers['id']; ?>" title="Bad"></span>
                        
                        <input class="stars" type="radio" id="starr0half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['avgrating']==0.5 ||$reviewusers['avgrating']==0.6 || $reviewusers['avgrating']==0.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr0half <?php echo $reviewusers['id']; ?>" title="Bad"></span>
                    
                    </fieldset></a>
              </div> 
               <a data-toggle="modal" class='quickrevpop' style="color: #000;"  href="<?php echo SITE_URL?>/profile/quickreviewshow/<?php echo $reviewusers['job_id']; ?>/<?php echo $reviewusers['artist_id']; ?> ">
              <textarea class="form-control" style="height: 84px; width: 598px;" readonly><?php echo $reviewusers['description']; ?></textarea></a>
    <!--<p id="text_show">
We will help you to  balance the acquisition of technical skills, creative expression and the development of critical insight so that you can find your own voice and visual language to enable you to realise your ideas. We have high standards with a robust but positive and critical approach.
</p>
<div class="btn-container">
<button id="toggle" class="pull-left">Read More</button>
</div>-->

<div> Hired <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $jobdetail['user']['id']; ?>"><?php echo $jobdetail['user']['user_name']; ?></a> for  <?php echo $jobdetail['skill']['name'] ?> 
	    <?php if ($jobdetail['requirement']['continuejob' ]	== 'N'){ ?>
	    from (<?php echo date('Y-M-d H:m:s',strtotime($jobdetail['requirement']['event_from_date' ]));?> To <?php echo date('Y-m-d H:m:s',strtotime($jobdetail['requirement']['event_from_date'])); ?>)
	    <?php } ?></div>
    </div>
    </div>
    <!--<span class="cross_icon"><a href="javascript:voide(0);"><i class="fa fa-times"></i></a></span>-->
    </div>

    <?php } ?>
    <?php }else{ ?>
	<span style="text-align: center !important;margin: 0px auto; display: block;"><strong><?php echo "No Reviews"; ?></strong>	</span>
		
		
		<?php  } ?>
   
    
	</div>
    </div>
    </div>
   
</div>
</div>

</div>
</div>
</div>
</section>
  


   
	    
	    
	    
	    
<!-- reviews modal -->
  
    <div id="reviews" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content"  >
    
         <div class="modal-body"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->

	
  <!-- Modal -->
  <!-- Modal -->
  <script>
$(document).ready(function() {
  $("#toggle").click(function() {
    var elem = $("#toggle").text();
    if (elem == "Read More") {
      //Stuff to do when btn is in the read more state
      $("#toggle").text("Read Less");
      $("#text_show").slideDown();
    } else {
      //Stuff to do when btn is in the read less state
      $("#toggle").text("Read More");
      $("#text_show").slideUp();
    }
  });
});
</script>
<?php /* ?>
  <script>
$('.ratingreview').click(function(e){

  e.preventDefault();
  $('#reviews').modal('show').find('.modal-body').load($(this).attr('href'));
});	
	</script>
    
    <?hpp */ ?>
<!-- Modal -->

<div id="myModal" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" style="width: 610px !important;" >
  
   <div class="modal-body"></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

</div>
    

<script>
 $('.quickrevpop').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>
  
  <!-------------------------------------------------->
