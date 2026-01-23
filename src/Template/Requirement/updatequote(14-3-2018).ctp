<?php if(count($requirementfeatured)>0){ //pr($destination);?>
				  <table class="table table-bordered">
    <thead>
      <tr>
        <th><b>Profile Name</b></th>
        <th><b>Date & Time</b></th>
 <?php if ($quote=='quote_receive'){ ?><th><b>Sent Quote Amount</b></th><?php } ?>
        <th><b>Action</b></th>
      </tr>
    </thead>
       <tbody>
 <?php foreach($requirementfeatured as $requirement) { //pr($requirement);?>
 <div class="exp-cnt-inner clearfix">
            <div class="col-sm-12">
      <tr>
        <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $requirement['user_id']; ?>" target="_blank"><?php echo $requirement['user']['professinal_info']['profile_title']; ?></a></td>
        
        <td><?php echo date('Y-m-d H:m:s',strtotime($requirement['created'])); ?></td>
   
<?php if ($quote=='quote_receive'){ ?>
<td><?php echo $requirement['amt']; ?></td>
<?php } ?>
				
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
				</div>
            </div>
<?php } ?>

  </tbody>
  </table>
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


<script>
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
