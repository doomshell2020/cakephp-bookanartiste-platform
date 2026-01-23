<?php echo $this->element('viewprofile') ?>
 
    <div class="col-sm-9 my-info">


	<div class="col-sm-12 prsnl-det">
		
		
		
	<div class="clearfix">
	<h4 class="pull-left">Rating <span>& Reviews</span>(<?php echo $jobavgreview; ?>)</h4>
  <fieldset id='demo1' class="ratingusers">
                    
                    
                      <input class="stars dd" type="radio" id="starr0110" name="r01" value="10" disabled / >
                        <span class = "review full" for="starr0110" title="Excellent"></span>
                        
                        <input class="stars dd" type="radio" id="starr019half" name="r01" value="9.5" disabled / >
                        <span class = "review half" for="starr019half" title="Excellent"></span>
                        
                        <input class="stars dd" type="radio" id="starr019" name="r01" value="9" disabled / >
                        <span class = "review full" for="starr019" title="Excellent"></span>
                        
                        <input class="stars dd" type="radio" id="starr018half" name="r01" value="8.5" disabled / >
                        <span class = "review half" for="starr018half" title="Good"></span>
                        
                        <input class="stars dd" type="radio" id="starr018" name="r01" value="8" disabled / >
                        <span class = "review full" for="starr018" title="Good"></span>
                    
                    
						<input class="stars dd" type="radio" id="starr017half" name="r01" value="7.5" disabled / >
                        <span class = "review half" for="starr017half" title="Good"></span>
                        
                        <input class="stars dd" type="radio" id="starr017" name="r01" value="7" disabled / >
                        <span class = "review full" for="starr017" title="Good"></span>
                    
						<input class="stars dd" type="radio" id="starr016half" name="r01" value="6.5" disabled / >
                        <span class = "review half" for="starr016half" title="Average"></span>
                    
                    
						<input class="stars dd" type="radio" id="starr016" name="r01" value="6" disabled / >
                        <span class = "review full" for="starr016" title="Average"></span>
                    
						<input class="stars dd" type="radio" id="starr015half" name="r01" value="5.5" disabled / >
                        <span class = "review half" for="starr015half" title="Average"></span>
                    
                    
                    
                    
                    
                    
                    
                        <input class="stars" type="radio" id="starr015" name="r01" value="5" <?php if( $jobavgreview==4.8 || $jobavgreview==4.9 || $jobavgreview==5.0){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr015" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr014half" name="r01" value="4.5" <?php if($jobavgreview==4.3 ||$jobavgreview==4.4 ||$jobavgreview==4.5 || $jobavgreview==4.6 || $jobavgreview==4.7){ echo "checked"; }?> disabled />
                        <span class="review half" for="starr014half" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr014" name="r01" value="4" <?php if($jobavgreview==3.8 ||$jobavgreview==3.9 ||$jobavgreview==4.0|| $jobavgreview==4.1 ||$jobavgreview==4.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr014" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr013half" name="r01" value="3.5" <?php if($jobavgreview==3.3 || $jobavgreview==3.4 || $jobavgreview==3.5 || $jobavgreview==3.6 || $jobavgreview==3.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr013half" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr013" name="r01" value="3" <?php if( $jobavgreview==2.8 || $jobavgreview==2.9 || $jobavgreview==3.0 || $jobavgreview==3.1 ||$jobavgreview==3.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr013" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr012half" name="r01" value="2.5" <?php if($jobavgreview==2.3 || $jobavgreview==2.4 || $jobavgreview==2.5 || $jobavgreview==2.6 || $jobavgreview==2.7 ){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr012half" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr012" name="r01" value="2" <?php if($jobavgreview==1.8 || $jobavgreview==1.9 || $jobavgreview==2 || $jobavgreview==2.1 || $jobavgreview==2.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr012" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr011half" name="r01" value="1.5" <?php if($jobavgreview==1.3 || $jobavgreview==1.4 || $jobavgreview==1.5 || $jobavgreview==1.6 || $jobavgreview==1.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr011half" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr011" name="r01" value="1" <?php if($jobavgreview==0.8 || $jobavgreview==0.9 || $jobavgreview==1||$jobavgreview==1.1||$jobavgreview==1.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr011" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr01half" name="r01" value="0.5" <?php if($jobavgreview['r1']==0.5 ||$jobavgreview==0.6 || $jobavgreview==0.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr01half" title="Sucks big time - 0.5 stars"></span>
                    </fieldset>
		   
	</div>
	<?php 
	//pr($activities);
	if(count($review)>0){ 
	foreach($review as $reviewusers){ //pr($reviewusers);?>
		<?php $avgrating = $reviewusers['r1']+$reviewusers['r2']+$reviewusers['r3']+$reviewusers['r4']+$reviewusers['r5'];  
	    $totalrating = $avgrating/5;
	    
$te = count($reviewusers);
	    
	     $res= $totalrating/$te; 
	   //pr($res); 
	    ?>
	<div class="row activites-blog">
	    <div class="col-sm-2"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $reviewusers['nontalent_id']; ?>"><img src="<?php echo SITE_URL ?>/job/<?php echo $reviewusers['requirement']['image'];?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';"></a>
	    <span><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $reviewusers['nontalent_id']; ?>"><?php echo $reviewusers['user']['profile']['name']; ?></a></span>
	    </div>
	    
	    <!-- Update Profile -->
	    <div class="col-sm-4 activites">
	    <p><strong><?php echo $reviewusers['reviewheadline']; ?></strong> </p>
	        <div><div class="review">
                      <fieldset id='demo1' class="ratingusers">
                    
                      <input class="stars" type="radio" id="starr010<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="10" disabled / >
                        <span class = "review full" for="starr010<?php echo $reviewusers['id']; ?>" title="Excellent"></span>
                        
                        <input class="stars" type="radio" id="starr09half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="9.5" disabled / >
                        <span class = "review half" for="starr09half<?php echo $reviewusers['id']; ?>" title="Excellent"></span>
                        
                        <input class="stars" type="radio" id="starr019<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="9" disabled / >
                        <span class = "review full" for="starr09<?php echo $reviewusers['id']; ?>" title="Excellent"></span>
                        
                        <input class="stars" type="radio" id="starr08half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="8.5" disabled / >
                        <span class = "review half" for="starr08half<?php echo $reviewusers['id']; ?>" title="Good"></span>
                        
                        <input class="stars" type="radio" id="starr08<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="8" disabled / >
                        <span class = "review full" for="starr08<?php echo $reviewusers['id']; ?>" title="Good"></span>
                    
                    
						<input class="stars" type="radio" id="starr07half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="7.5" disabled / >
                        <span class = "review half" for="starr07half<?php echo $reviewusers['id']; ?>" title="Good"></span>
                        
                        <input class="stars" type="radio" id="starr07<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="7" disabled / >
                        <span class = "review full" for="starr07<?php echo $reviewusers['id']; ?>" title="Good"></span>
                    
						<input class="stars" type="radio" id="starr06half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="6.5" disabled / >
                        <span class = "review half" for="starr06half<?php echo $reviewusers['id']; ?>" title="Average"></span>
                    
                    
						<input class="stars" type="radio" id="starr06<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="6" disabled / >
                        <span class = "review full" for="starr06<?php echo $reviewusers['id']; ?>" title="Average"></span>
                    
						<input class="stars" type="radio" id="starr05half<?php echo $reviewusers['id']; ?>" name="r0<?php echo $reviewusers['id']; ?>" value="5.5" disabled / >
                        <span class = "review half" for="starr05half<?php echo $reviewusers['id']; ?>" title="Average"></span>
                        
                    
                        <input class="stars" type="radio" id="starr05 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="5" <?php if( $totalrating==4.8 || $totalrating==4.9 || $totalrating==5.0){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr05 <?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr04half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="4.5" <?php if($totalrating==4.3 ||$totalrating==4.4 ||$totalrating==4.5 || $totalrating==4.6 || $totalrating==4.7){ echo "checked"; }?> disabled />
                        <span class="review half" for="starr04half <?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr04 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="4" <?php if($totalrating==3.8 ||$totalrating==3.9 ||$totalrating==4.0|| $totalrating==4.1 ||$totalrating==4.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr04 <?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr03half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="3.5" <?php if($totalrating==3.3 || $totalrating==3.4 || $totalrating==3.5 || $totalrating==3.6 || $totalrating==3.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr03half <?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr03 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="3" <?php if( $totalrating==2.8 || $totalrating==2.9 || $totalrating==3.0 || $totalrating==3.1 ||$totalrating==3.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr03 <?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr02half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="2.5" <?php if($totalrating==2.3 || $totalrating==2.4 || $totalrating==2.5 || $totalrating==2.6 || $totalrating==2.7 ){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr02half <?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr02 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="2" <?php if($totalrating==1.8 || $totalrating==1.9 || $totalrating==2 || $totalrating==2.1 || $totalrating==2.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr02 <?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr01half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="1.5" <?php if($totalrating==1.3 || $totalrating==1.4 || $totalrating==1.5 || $totalrating==1.6 || $totalrating==1.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr01half <?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr01 <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="1" <?php if($totalrating==0.8 || $totalrating==0.9 || $totalrating==1||$totalrating==1.1||$totalrating==1.2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr01 <?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr0half <?php echo $reviewusers['id']; ?>" name="r0 <?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r1']==0.5 ||$totalrating==0.6 || $totalrating==0.7){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr0half <?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset>
              </div> 
	    </em>
<a data-toggle="modal" class='ratingreview btn' href="<?php echo SITE_URL?>/profile/viewrating/<?php echo $reviewusers['id']; ?>">Other Rating </a>
	   
	    
	    </div>
	    
	    
	      
	    
	    
	  
	    
	    
	    
	    <div class="col-sm-12 activites">
	    <p><strong>Review Description</strong> </p>
	        <div>

	   <?php 
	   echo "test"; ?>
	    </div>
	    </div>
	    
	</div>
	<?php } ?>
	<!--<div class="col-sm-12"><a href="#" class="btn btn-default">View All</a></div>-->
	<?php }else{ ?>
	No Activity available.
	<?php }?>
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
   
      <div class="modal-content" >
    
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
$('.ratingreview').click(function(e){

  e.preventDefault();
  $('#reviews').modal('show').find('.modal-body').load($(this).attr('href'));
});	
	</script>


  
  <!-------------------------------------------------->
