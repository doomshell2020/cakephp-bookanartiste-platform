<?php
$isFlagTwo = ($flag == 1);
?>
<div id="<?= $isFlagTwo ? 'job-' . $requirement_data['id'] : 'myping' . $requirement_data['id'] ?>">

    <?php if ($flag == 1): ?>
        <!-- Success: Display the job information -->
        <a href="<?= SITE_URL ?>/applyjob/<?= $requirement_data['id'] ?>" target="_blank">
            <?= $requirement_data['title'] ?>
        </a>

        <select class="form-control" name="skill" required id="telentskill">>
            <option value="">Select Talent Type</option>
            <?php foreach ($requirement_data['requirment_vacancy'] as $value) : ?>
                <option value="<?= $value['skill']['id'] ?>"><?= $value['skill']['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <div class="form-group">

            <label for="comment">Cover Latter:</label>
            <textarea class="form-control" rows="5" id="comment" name="cover"></textarea>
        </div>

        <input type="hidden" name="job_id" value="<?= $requirement_data['id'] ?>">

    <?php else: ?>
        <!-- Error: Show the error message -->
        <div class="error-message">
            <?= isset($message) ? $message : 'An error occurred. Please try again later.' ?>
        </div>
    <?php endif; ?>
</div>


<div class="modal-footer" style="border-top: none; text-align: center;">
    <button type="submit" class="btn btn-default" form="single">Apply</button>
</div>


<?php
/*
if($flag==2){ ?>
<div id="job-<?php echo $id ?>">
<input type="hidden" value="<?php echo $jobid ?>" name="job_id"/>
<div class="form-group">
    <label for="email"><a href="<?php echo SITE_URL?>/applyjob/<?php echo $id ?>" target="_blank"><?php echo $requirement_data['title']; ?></a></label>
    <select class="form-control" name="skill<?php echo $a ?>" required id="telentskill">
    <option value="">Select Talent Type</option>
<?php  foreach($requirement_data['requirment_vacancy'] as $value){ ?>
<option value="<?php  echo $value['skill']['id'] ?>"><?php  echo $value['skill']['name'] ?></option>
<?php } ?>
</select>
  </div>
</div>
<?php }else{ 


$html="<div id='myping".$requirement_data['id']."'>";			
$html.="
	<a href=".SITE_URL."/applyjob/".$requirement_data['id']." target='_blank'>".$requirement_data['title']."</a>
     <select class='form-control' name='skill' required>
     <option value=''>Select Skill</option>";

foreach($requirement_data['requirment_vacancy'] as $value){

$html.='<option value='.$value["skill"]["id"].'>'.$value["skill"]["name"].'</option>';


}

        $html.='<input type="hidden" name="job_id" value='.$requirement_data['id'].'> </div>';
echo $html;




} */ ?>