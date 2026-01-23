<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Vital Statistics
       
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title"> Vital Statistics</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">

            <?php echo $this->Flash->render(); ?>
		<?php echo $this->Form->create($vitals, array('url' => array( 'action' => 'updatevitals'),
                       'class'=>'form-horizontal',
			'id' => 'content_admin',
                       'enctype' => 'multipart/form-data',
                     	'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>
                     	
            <div class="box-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>Skills</th>
                  <th>Is Vitals?</th>
                  <th>Managetalent_Portfolio?</th>
                   <th>Managepersonnel_Details?</th>
                  <th>Genre</th>
                </tr>
                </thead>
                <tbody>
		<?php 
		$counter = 1;
		if(count($skilslist)>0){ 
		foreach($skilslist as $skills_data){
		    $skill_id = $skills_data['id']; 
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php echo $skills_data['name']; ?></a>
                  
                  </td>
                  <td>
                  <input type="hidden" name="skills[<?php echo $skills_data['id']; ?>][is_vital]" value="0">
                  <input type="checkbox" class="vital_check" data-skill_id="<?php echo $skills_data['id']; ?>" name="skills[<?php echo $skills_data['id']; ?>][is_vital]" <?php echo ($skills_data['is_vital']==1)?'checked=checked':''; ?> value="1"></td>

                  <td>
                  <input type="hidden" name="skills[<?php echo $skills_data['id']; ?>][is_vital]" value="0">
                  <input type="checkbox" class="portcheck" data-skill_id="<?php echo $skills_data['id']; ?>" name="skills[<?php echo $skills_data['id']; ?>][is_vital]" <?php echo ($skills_data['is_Portfolio']==1)?'checked=checked':''; ?> value="1"></td>
                  
                  <td>
                  <input type="checkbox" class="portcheckpersonnel" data-skill_id="<?php echo $skills_data['id']; ?>" name="skills[<?php echo $skills_data['id']; ?>][is_vital]" <?php echo ($skills_data['manage_personnel']==1)?'checked=checked':''; ?> value="1"></td>
                  
                  <td>
                  <?php 
                  foreach($genre as $genre_data){
                  $genre_array = $vitalarr_data[$skill_id]['genre_ids'];
                 ?>
                  <input type="checkbox" class="genre_check" data-genid="<?php echo $genre_data['id']; ?>" data-skill_id="<?php echo $skills_data['id']; ?>" name="skills[<?php echo $skills_data['id']; ?>][genere][]" <?php if(in_array($genre_data['id'],$genre_array)){ ?> checked=checked <?php }?> value="<?php echo $genre_data['id']; ?>"> <?php echo $genre_data['name']; ?>
                  <?php }?>
                  
                  </td>
                </tr>
		<?php $counter++;} }
		else{ ?>
		<tr>
		<td colspan="11" align="center">NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
              <br><br>
              <div align="center">
              <!-- <button type="submit" class="btn add-paymentfield btn-danger btn-block"><i class="fa fa-add"></i> Update</button> -->
              </div>
              
            </div>
            <!-- /.box-body -->
            
            <?php echo $this->Form->end(); ?>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  
<script>


    site_url = '<?php echo SITE_URL; ?>/';
    $(function() {
  $(".genre_check").click(function() {
      var genere_id = $(this).data("genid");
      var skill_id = $(this).data("skill_id");
      $.ajax({
          type: "POST",
          datatype: "html",
          data: {
              genere_id: genere_id,
              skill_id: skill_id
          },
          beforeSend: function() {
              
          },
          url: site_url + "admin/vitalstatistics/updategenrevitals",
          success: function(response) {
              
          },
          complete: function() {
              //$(".preloader").hide()
          }
      })
  })
  
  
    $(".vital_check").click(function() {
      var skill_id = $(this).data("skill_id");
      $.ajax({
          type: "POST",
          datatype: "html",
          data: {
              skill_id: skill_id
          },
          beforeSend: function() {
              
          },
          url: site_url + "admin/vitalstatistics/updatevitals",
          success: function(response) {
              
          },
          complete: function() {
              //$(".preloader").hide()
          }
      })
  })
  
     $('.portcheckpersonnel').click(function() {
     var skill_id = $(this).data("skill_id");
      $.ajax({
          type: "POST",
          datatype: "html",
          data: {
              skill_id: skill_id
          },
          beforeSend: function() {
              
          },
          url: site_url + "admin/vitalstatistics/updatepersonnel",
          success: function(response) {
              
          },
          complete: function() {
              //$(".preloader").hide()
          }
      })
     });
     
     
       $('.portcheck').click(function() {
     var skill_id = $(this).data("skill_id");
      $.ajax({
          type: "POST",
          datatype: "html",
          data: {
              skill_id: skill_id
          },
          beforeSend: function() {
              
          },
          url: site_url + "admin/vitalstatistics/updateportfoilo",
          success: function(response) {
              
          },
          complete: function() {
              //$(".preloader").hide()
          }
      })
     });
      
  
  })
</script>
  
  
  