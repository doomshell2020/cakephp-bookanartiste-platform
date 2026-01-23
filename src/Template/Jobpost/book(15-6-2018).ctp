
   <?php 

   foreach($bookjob as $value){
   	$app[]=$value['job_id'];
   }
    ?>

    <section id="page_post-req">

    <div class="post-talant-form">
    <div class="m-top-10 container-fluid">
    <h4 class="text-center">My Active Jobs</h4>
    <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'insBook'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
    <input type="hidden" name="user_id" value="<?php echo $userid ?>">
	<div class="">
	<?php if(count($activejobs) > 0){ ?>
		
		
		       
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job</th>
        <th>Skills</th>
      </tr>
    </thead>
    <tbody>
		<?php  foreach($activejobs as $jobs){ //pr($jobs);

	?>
      <tr>
		  <?php if(! in_array($jobs['id'], $app)) {?>
        <td>		
		<input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>">
		<?php } ?>
		<?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>
		

		<a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
		</td>
		<?php  }?>
		 <?php if(! in_array($jobs['id'], $app)) {?>
        <td>
			
			<select name="job_id[<?php echo $jobs['id']; ?>][]">
			<option value="">--Select--</option>
				<?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
			
    <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>
<?php } ?>
  </select>  
 </td>
<?php } ?>
      </tr>
      <?php } ?>
      <?php if($pendingjob) { ?>
	
	  <?php }else{?>
		  <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Booking "; ?></td>	
		  <?php } ?>
    </tbody>
    
  </table>
		
	  <?php  
	}?>
	
	
	
   <?php if($pendingjob) {?>   <input type="submit" name="submit" class="form-control" value="Book">	 <?php } ?>
    </div>
    </form>
    </div>

    </div>


    </section>



       

