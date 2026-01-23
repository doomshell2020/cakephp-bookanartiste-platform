
		<?php 
		$counter = 1;
		if(isset($talents) && !empty($talents)){ 
		foreach($talents as $admin){
		
			
		?>
               
                 <tr>
                  <td><?php echo $counter;?></td>
                  <td>
                  <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['country'])){ echo $admin['country'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['state'])){ echo $admin['state'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['city'])){ echo $admin['city'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php 
                 
                   if(isset($admin['skill_name'])){ echo $admin['skill_name'];}else{ echo 'N/A'; } ?>
                  
                  </td>
                  
                  <td><?php if(isset($admin['membership_from'])){ echo $admin['membership_from'];}else{ echo 'N/A'; } ?></td>
		<td><?php if(isset($admin['talent_from'])){ echo $admin['talent_from'];}else{ echo 'N/A'; } ?></td>
                  
                                      
		<td>
		<?php
			echo $this->Html->link('Transcations', [
			    'action' => 'transcations',
			    $admin->id
			],['class'=>'btn btn-primary']); ?>
			
		<?php
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $admin->id
			],['class'=>'btn btn-primary']); ?>
	
			<?php
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $admin->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
      <br>
   
      </td>
                </tr>
               
               
		<?php $counter++;} }



     else{ ?>
		<tr>
		<td colspan="11" align="center">NO Data Available</td>
		</tr>
		<?php } ?>	
               
  
  <!-- Daynamic modal -->
<div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content">
         <div class="modal-body"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->
  
  
  <script>
 $('.skill').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>




<script type="text/javascript">
	// From Date Picker
	$('#from_date_picker').datepicker({ 
	    dateFormat: 'yy-mm-dd', 
	    maxDate: '+0d',
	    changeMonth: true,
	    changeYear: true,
	    // defaultDate: '-18yr',
	});
	
	// To Date Picker
	$('#to_date_picker').datepicker({ 
	    dateFormat: 'yy-mm-dd', 
	    maxDate: '+0d',
	    changeMonth: true,
	    changeYear: true,
	    // defaultDate: '-18yr',
	});



	$(document).ready(function() {
		$("#country_ids").on('change',function() {
			var id = $(this).val();
			$("#state").find('option').remove();
			//$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getStates',
					data: dataString,
					cache: false,
					success: function(html) {
						$.each(html, function(key, value) {        
							$('<option>').val(key).text(value).appendTo($("#state"));
						});
					} 
				});
			}
		});
 
		$("#state").on('change',function() {
			var id = $(this).val();
			$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getcities',
					data: dataString,
					cache: false,
					success: function(html) {
						$.each(html, function(key, value) {              
							$('<option>').val(key).text(value).appendTo($("#city"));
						});
					} 
				});
			}	
		});
	});
</script>
