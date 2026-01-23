

<div class="alert alert-warning alert-dismissible" id="limitalert" style="display: none">

  <strong id="limittext"></strong> 
</div>
      
        

<div id="job-<?php echo $id ?>">
<input type="hidden" value="<?php echo $id ?>" name="job_id[]"/>
<div class="form-group">
    <label for="email"><a href="<?php echo SITE_URL?>/applyjob/<?php echo $id ?>" target="_blank"><?php echo $requirement_data['title']; ?></a></label>
    <select class="form-control" name="skill[]" required id="telentskill">
    <option value="">Select Talent Type</option>
<?php  foreach($requirement_data['requirment_vacancy'] as $value){ ?>
<option value="<?php  echo $value['skill']['id'] ?>"><?php  echo $value['skill']['name'] ?></option>
<?php } ?>
</select>
  </div>
</div>
     
      