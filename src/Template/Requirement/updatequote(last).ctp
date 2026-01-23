<?php if(count($requirementfeatured)>0){ //pr($destination);?>
	   <?php foreach($requirementfeatured as $requirement) { //pr($requirement);?>
            <div class="requ_hide clearfix">
            <div class="row">
            <div class="col-sm-3">
            <img src="<?php echo SITE_URL;?>/profileimages/<?php echo $requirement['user']['profile']['profile_image']; ?>">
            </div>
            <div class=" col-sm-9">
	        <table class="table">
		
			
	 <?php if ($quote=='sel_receive'){ ?>
		  
		  <?php $skills= $this->Comman->reviews($requirement['job_id'],$requirement['user_id']); ?>
  <?php if($skills>0){ ?>
	
		 <a  data-toggle="modal" class='btn btn-success btn-job' href="#">Reviewed</a>

		 <?php  }else{ ?>
			 			
				<?php $currentdate=date("Y-m-d H:m:s"); ?>
<?php $eventtodate = date('Y-m-d H:m:s',strtotime($requirement['requirement']['event_to_date'])); ?>

<?php if( $eventtodate <	 $currentdate  ) { ?>
			  <a  data-toggle="modal" target ="_blank" class='btn btn-success btn-job' href="<?php echo SITE_URL?>/requirement/talentrating/<?php echo $requirement['job_id']; ?>/<?php echo $requirement['user_id']; ?>">Review </a>
			 <?php }else{ ?>
			
			 <?php } ?>
			 <?php } ?>
	 <?php } ?>

	 <?php if ($quote=='sel_receive'){ ?>
            <tr>
				
    <th>Select Skills </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>
				 <?php if ($quote=='reject_receive'){ ?>
            <tr>
				
    <th>Reject Skills </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>
                 <?php if ($quote=='quote_revised'){ ?>
            <tr>
				
    <th>Revised Quote Sent </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>  
<?php if ($quote=='quote_receive'){ ?>
            <tr>
				
    <th>Quote Recieve </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>

	<?php if ($quote=='application'){ ?>
            <tr>
				
    <th>Job Application Sent </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>

     			<?php if ($quote=='quote_request'){ ?>
            <tr>
				
    <th>Quote Request Sent </th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>


            <?php if ($quote=='booking_sent'){ ?>
            <tr>
				
    <th>Booking Request Sent</th>
    <td>:</td>
    <td><?php echo $requirement['skill']['name'] ; ?></td>
    </tr>
    <?php  } ?>
          	

            <tr>
				
    <th>Name</th>
    <td>:</td>
    <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $requirement['user_id']; ?>" target="_blank"><?php echo $requirement['user']['professinal_info']['profile_title']; ?></a></td>
    </tr>
            
            <tr>
    <th>Gender</th>
    <td>:</td>
    <td>
		<?php if($requirement['user']['profile']['gender']=='m'){
			echo "Male";
		}elseif($requirement['user']['profile']['gender']=='f'){
			echo "Female";
			
			}elseif($requirement['user']['profile']['gender']=='o'){
					echo "Other";
				
				}  ?>
		</td>
    </tr>
            <tr>
    <th>Talent</th>
    <td>:</td>
    <td>
		<?php if($requirement['user']['skillset'])
					{
					$knownskills = '';
					foreach($requirement['user']['skillset'] as $skillquote)
					{
					if(!empty($knownskills))
					{
						$knownskills = $knownskills.', '.$skillquote['skill']['name'];
					}
					else
					{
						$knownskills = $skillquote['skill']['name'];
					}
					}
					$output.=str_replace(',',' ',$knownskills).',';
					//$output.=$knownskills.",";	
				   echo $knownskills;
					}	?></td>
    </tr>
            <tr>
    <th>Location</th>
    <td>:</td>
    <td><?php echo $requirement['user']['profile']['location']; ?></td>
    </tr>
            <tr>
    <th>Experience</th>
    <td>:</td>
   <?php $experienceyear = date("Y")-$requirement['user']['professinal_info']['performing_year']; ?>
    
    <td><?php echo $experienceyear;?> years</td>
    </tr>
            <tr>
    <th>Date & Time</th>
    <td>:</td>
    <td><?php echo date('Y-m-d',strtotime($requirement['user']['profile']['created'])); ?></td>
    </tr>
            <tr>
    <?php  if ($quote=='quote_receive'){ ?>
        <th>Quote Amount</th><?php } ?>
    <?php  if ($quote=='quote_receive'){ ?><td>:</td><?php } ?>
    <?php if ($quote=='quote_receive'){ ?>
        <td><?php echo $requirement['amt']; ?></td>
        <?php } ?>
    </tr>
            <tr>
        <th>Action</th>
        <td>:</td> 
        <?php if($quote=='application'){ ?>
        <td>
<a href="<?php echo SITE_URL;?>/requirement/applicationselect/<?php echo $requirement['id']?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>		
<a href="<?php echo SITE_URL;?>/requirement/applicationreject/<?php echo $requirement['id']?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a>
  </td>
        <?php }elseif($quote=='quote_receive'){ ?>
	    <td>
<a  data-toggle="modal" class='quote btn btn-success btn-job' href="<?php echo SITE_URL?>/requirement/amountquote/<?php echo $requirement['id']; ?>">Sent Revised Quote</a>

<a href="<?php echo SITE_URL;?>/requirement/quoteselect/<?php echo $requirement['id']?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>		
<a href="<?php echo SITE_URL;?>/requirement/quotereject/<?php echo $requirement['id']?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a>  </td>
        <?php }elseif($quote=='quote_revised'){ ?>
	    <td><a href="<?php echo SITE_URL;?>/requirement/quotereject/<?php echo $requirement['id']?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job"onClick="javascript:return confirm('Are you sure do you want to reject this job')" >Reject</a>  </td>
        <?php }elseif($quote=='reject_receive'){ ?>	
	    <td><a href="<?php echo SITE_URL;?>/requirement/applicationselect/<?php echo $requirement['id']?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a></td>
        <?php }elseif($quote=='sel_receive' ){ ?>
		<td><a href="<?php echo SITE_URL;?>/requirement/applicationreject/<?php echo $requirement['id']?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job"onClick="javascript:return confirm('Are you sure do you want to reject this job')" >Reject</a></td>
        <?php  }elseif($quote=='booking_sent'){ ?>
	    <td>
	<a href="<?php echo SITE_URL;?>/requirement/deleteapplication/<?php echo $requirement['id']?>" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-job"onClick="javascript:return confirm('Are you sure do you want to cancel this booking')" >Cancel</a></td>
	    <?php }elseif($quote=='quote_request'){ ?>
		<td><a href="<?php echo SITE_URL;?>/requirement/deletequotes/<?php echo $requirement['id']?>" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-job"onClick="javascript:return confirm('Are you sure do you want to cancel this request')" >Cancel</a></td>
 		<?php }elseif($quote=='ping_receive'){ ?>
		<td><a href="<?php echo SITE_URL;?>/requirement/applicationselect/<?php echo $requirement['id']?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>		
<a href="<?php echo SITE_URL;?>/requirement/applicationreject/<?php echo $requirement['id']?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a></td>
 		<?php } ?>
     </tr>
            
            </table>
            </div>
            </div>
           
            
            
            </div>
             <?php } ?>
<?php } else{?>
	<?php echo "No Data Found"; ?>
	<?php } ?>
<!-- Modal -->
  
    <div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content" >
     
         <div class="modal-body" id="skillsetsearch"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->


  <!-- Modal -->
  
<!-- reviews modal -->
  
    <div id="reviews" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content" >
     <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">Review & Rating</h4>
        </div>
         <div class="modal-body"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->


  <!-- Modal -->

<script>
	
$('.reviewrate').click(function(e){

  e.preventDefault();
  $('#reviews').modal('show').find('.modal-body').load($(this).attr('href'));
});	
	
	
 $('.quote').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});


$('#selectjob').click(function() { //alert();
    job_id = $(this).data('val');
   
    if(job_id > 0)
    {
	$.ajax({
	    type: "POST",
	    url: '<?php echo SITE_URL;?>/requirement/applicationselect',
	    data: {job_id: job_id},
	    cache:false,
	    success:function(data){ 
		
	    }
	});
    }
   
});


</script>


  <!-- Trigger the modal with a button -->
  

