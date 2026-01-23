<div style="width:100%; padding:15px">
  <h2>Who Liked This Profile</h2>
  <table class="table table-hover">
    <thead>
      <tr>
		<th>#</th>
        <th>Profile Photo</th>
        <th>Names</th>
        <th>Location</th>
        <th>Talent</th>        
      </tr>
    </thead>
    <tbody>
		<?php $counter = 1;
		foreach($findall as $value){ //pr($value)?>
			<?php $profile=$this->Comman->findprofileimage($value['user_id']); //pr($profile);?> 
      <tr>
		<td><?php echo $counter; ?></td>
	<td>
		    <?php if($profile['profile_image']!='')
		   { ?> 
		    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile['id']; ?>" target="_blank"><img class="" src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile->profile_image; ?>"  width="70px" height="70px" style="width:auto"></a>
		    <?php } else{?>
		    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['user_id']; ?>" target="_blank"><img class="" src="<?php echo SITE_URL; ?>/images/noimage.jpg"  width="70px" height="70px" style="width:auto"></a>
		    
		    <?php } ?>
		    </td>
		
		
		
		
		
		
		
		
		
		
        <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $profile['user_id']; ?>" target="_blank"><?php echo $profile['name']; ?></a></td>
        <td><?php echo $profile->location; ?></td> 
        <?php $userskill= $this->Comman->checktalent($value['user_id']); ?>
      <td>
             <?php if(count($userskill) > 0){ ?>
            <?php foreach($userskill as $key=>$value){ ?>
           
            <?php  echo $value['skill']['name'].",";  ?>
        <?php } } else { ?>
        
     
        <?php echo "Non-Talent"; } ?>
        </td> 
      </tr>
      <?php $counter++; } ?>
    </tbody>
  </table>
</div>
