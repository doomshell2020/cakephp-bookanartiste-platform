 <!----------------------page_search-strt----------------------->

  <section id="page_job_detail">
    <div class="container">
      <h2>My <span>Requirement</span></h2>
      <p class="m-bott-50">Here You Can See Job Detail</p>
    </div>
    
    <div class="refine-search">
       <?php echo $this->Flash->render(); ?>
      <div class="container">
		  
        <div class="row m-top-20">
          
          <div class="col-sm-12">
            <div class="panel panel-right">
              <div class="clearfix job-box box-1">
				
				  <?php  echo $requirement['id']; ?>
				 <?php if(count($requirementfeatured)>0){ ?>
			<?php $i=1; foreach($requirementfeatured as $requirement)	 { ?>
				 
        <div class="col-sm-12 job-card">
          <div class="col-sm-2 ad-job-image">
   
            <img src="<?php echo SITE_URL;?>/job/<?php echo $requirement['image'];  ?>"></div>
          <div class="col-sm-10">
            <h3 class="heading"><?php echo $i.'.'; ?> <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $requirement['id']; ?>"><?php echo $requirement['title']; ?></a><span><?php echo date('Y-m-d H:m:s',strtotime($requirement['last_date_app'])); ?></span></h3>
          
            <div class="row">
              <div class="col-lg-10 col-md-12 col-sm-12 my-job-but">
              <div class="row">
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-default btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="application"> Application Received ( <?php echo $job_application= $this->Comman->applicationcount($requirement['id']); ?>)</a></div>
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-primary btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="quote_receive"> Quote Received (<?php echo $job_application= $this->Comman->quote_receivecount($requirement['id']); ?>)</a></div>
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-success btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="ping_receive"> Ping Received (<?php echo $job_application= $this->Comman->ping_receivecount($requirement['id']); ?>)</a></div>
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-info btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="sel_receive"> Selected (<?php echo $job_application= $this->Comman->sel_receivecount($requirement['id']); ?>) </a></div>
              </div>
               <div class="row m-top-20">
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-info btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="booking_sent"> Booking Request sent (<?php echo $job_application= $this->Comman->booking_sentcount($requirement['id']); ?>)</a></div>
              
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-warning btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="quote_request"> Quote Requested (<?php echo $job_application= $this->Comman->quote_requestcount($requirement['id']); ?>)</a></div>
       <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-default btn-block"data-val="<?php echo $requirement['id']; ?>" data-action="quote_revised"> Revised Quote Sent (<?php echo $job_application= $this->Comman->quote_revisedcount($requirement['id']); ?>) </a></div>
              <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-primary btn-block"data-val="<?php echo $requirement['id']; ?>" data-action="reject_receive"> Rejected (<?php echo $job_application= $this->Comman->reject_receivecount($requirement['id']); ?>) </a></div>
              </div>
              </div>
              <div class="col-lg-2 col-md-12 col-sm-12 job-det-icon">
             <div class="text-right"> <p>No Of Views : <?php echo count($requirement['job_view']); ?></p></div>
 
  <a href="<?php echo SITE_URL;?>/requirement/jobcsv/<?php
                                 echo $requirement['id']; ?>" data-toggle="tooltip" data-placement="top" title="Export to CSV"><i class="fa fa-file-excel-o"></i></a>
       
<?php if(date('Y-m-d',strtotime($requirement['last_date_app'])) > date("Y-m-d")) { ?>
<button type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-user"></i></button>
                <?php }else{ ?>
					<button type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>

					<?php } ?>
                <a target="_blank" href="<?php echo SITE_URL;?>/jobpost/jobpost/<?php
                                 echo $requirement['id']?>" data-toggle="tooltip" data-placement="top" title="clone"><i class="fa fa-clone"></i></a>
                <!--button type="button" data-toggle="tooltip" data-placement="top" title="clone"><i class="fa fa-clone"></i>-->


</button>
<a href="<?php echo SITE_URL;?>/requirement/delete/<?php
                                 echo $requirement['id']?>" data-toggle="tooltip" data-placement="top" title="delete" onClick="javascript:return confirm('Are you sure do you want to delete this Job')" ><i class="fa fa-remove" aria-hidden="true"></i></a>

               <!-- <button type="button" data-toggle="tooltip" data-placement="top" title="delete" ><i class="fa fa-remove" aria-hidden="true"></i></button>-->
                
              </div>
            </div>
            <div class="row">
			<div class="exp-cntre" id="exp_<?php echo $requirement['id']?>">
			
			
			</div>
            </div>
          </div>
        </div>
        
        
        
        <?php $i++; } }else{ ?>
     <?php  echo   "No Jobs"; ?> 
        <?php } ?>
       
        
       
        
        
        
        
        
        
      </div>
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-------------------------------------------------->
  
</div>
<input type="hidden" id="currentaction" value="">
<script>
$(document).ready(function(){
    $(".btn").click(function(){
		var val = $(this).data('val');
		var action = $(this).data('action');
		var currentaction = $("#currentaction").val();
		
		opentab(val,action,currentaction);
		
		$("#currentaction").val(action+val);
    });
});

function opentab(val,action,currentaction)
{
	
	//alert(action);
	//alert(currentaction);
    if($('.exp-cnt:visible').length == 0)
		{
		    $("#exp_"+val).addClass("show1"); 
		
		}
		else
		    {
			$(".exp-cnt").removeClass("show1");
			//alert(action);
			//alert(action+val+'----'+currentaction);
			if(action+val!=currentaction)
			{
			    $("#exp_"+val).addClass("show1"); 
			     
			}
		
		}
		// Ajax
			$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/requirement/updatequote',
					data: ({job:val,action:action}),
					cache: false,
					success: function(data) { 
						
						 $(".exp-cntre").html("");
						 //alert("#exp_"+val);
						$("#exp_"+val).html(data); 
					} 
				});
}

var actions='<?php echo $_SESSION['quote']; ?>';
var value = '<?php echo $_SESSION['job_id']; ?>';
setTimeout(function(){opentab(value,actions,'')}, 1000);

</script>
