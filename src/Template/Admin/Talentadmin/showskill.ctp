

<div class="container">
  <h2>Skills Set</h2>
                                                                                       
  <div class="table-responsive">  

<?php if($skill) { $i=1; foreach($skill as $value){ ?>
  <span><b>(<?php echo $i; ?>)&nbsp; <?php echo $value['skill']['name']; ?></b></span>

<?php $i++; } } else {   echo "No Data Found"; } ?>
  </div>
</div>
