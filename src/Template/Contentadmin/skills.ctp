
<?php  


foreach($skillset as $value){
	$array[]=$value['skill_id'];
}

?>
<div class="container">

                                                                                       
  <div class="table-responsive">  
<ul id="myUL">
<?php if($Skill) { $i=1; foreach($Skill as $value){


 ?>
  <li>
<input type="checkbox" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>" <?php if(in_array($value['id'],$array)) { echo "checked"; } ?>/><a href="#"><?php echo $value['name'] ?></a></li>
<?php $i++; } echo "</ul>"; } else {   echo "No Data Found"; } ?>

  </div>
</div>