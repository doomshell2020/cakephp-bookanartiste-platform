 <?php 
                  $counter = 1;

		//pr($talents); die;

                  if(isset($talents) && !empty($talents)){ 
		foreach($talents as $admin){   //pr($admin); 
      if ($admin['talentdadmin_id']==0) {
        $talentId=1;
      }else{
        $talentId=$admin['talentdadmin_id'];
      }
      $talentadminname=$this->Comman->talentadminname($talentId);
      $talentpartnersrefers=$this->Comman->talentpartnersrefers($admin['user_id']);
      $profiledata=$this->Comman->profilphone($admin['user_id']);

      ?>
      <tr>
        <td><?php echo $counter;?></td>
        <td>
          <a data-toggle="modal" class='bankdata<?php echo $counter; ?>' href="javascript:void();" style="color:blue;">
            <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
          </a>
        </td>

        <td>
          <?php             
            if (isset($profiledata)) {
              
              if(!empty($profiledata['altnumber'])){
                echo '+'.$profiledata['phonecode'].'-'.$profiledata['phone'];
                $removespace = str_replace(' ','',$profiledata['altnumber']);
                $altphone = explode(",",$removespace);
                foreach($altphone as $altphonevalue){
                  echo "<br> +".$profiledata['phonecode']."-".$altphonevalue; 
                }
              }else{
                  echo "-";
              }         
            }else{
              echo 'N/A';
            }
          ?>
          
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
        <!-- <td><?php //if(isset($admin['skill_name'])){ echo $admin['skill_name'];}else{ echo 'N/A'; } ?></td> -->
        <td>
          <?php if ($admin['talentdadmin_id']!=0) { ?>
          <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $talentadminname['id']; ?>" target="_blank">
            <?php 
            if(isset($talentadminname['profile']['name'])){ 
              echo $talentadminname['profile']['name']; 
            }else{
              echo $talentadminname['user_name']; 
            } ?>
          </a>
          <?php }else{
            if(isset($talentadminname['profile']['name'])){ 
              echo $talentadminname['profile']['name']; 
            }else{
              echo $talentadminname['user_name']; 
            }
          } ?>
        </td>
        <td><?php $i=0; $v=0;
          foreach ($talentpartnersrefers as $key => $referValue) {
            if($referValue['status']=='Y'){ 
              $i++;         
            }else{
              $v++;
            }
          }
          echo $i;
          ?>

        </td>

        <td>
          <?php $v=0;
          foreach ($talentpartnersrefers as $key => $referValues) {
            if($referValues['status']=='N'){ 
              $v++;         
            }
          }
          echo $v;
          ?>
        </td>
        <td><?php if(isset($admin['talent_from'])){ echo date('d M Y', strtotime($admin['talent_from'])); }else{ echo 'N/A'; } ?></td>
        <td>
          <?php
			/* echo $this->Html->link('Commission Manager', [
			    'action' => 'transcations',
			    $admin['user_id']
         ],['class'=>'btn btn-primary']); */ ?>

         <?php
         echo $this->Html->link('Edit', [
           'action' => 'add',
           $admin['user_id']
           ],['class'=>'btn btn-primary']); ?>

         <?php
         echo $this->Html->link('Delete', [
           'action' => 'delete',
           $admin['id']
           ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
           <br>

         </td>
       </tr>
       <script>
         $('.bankdata<?php echo $counter; ?>').click(function(e){
          e.preventDefault();
          $('#globalModal<?php echo $counter; ?>').modal('show').find('.modal-body').load($(this).attr('href'));
        });

      </script>

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
