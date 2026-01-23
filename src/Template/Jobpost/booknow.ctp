 <section id="">

   <style>
     .job-link {
       font-weight: bold;
       color: #007bff;
       text-decoration: none;
       display: flex;
       align-items: center;
       position: relative;
     }

     .info-icon {
       color: #888;
       cursor: pointer;
       margin-left: 8px;
       transition: color 0.3s ease;
       position: relative;
     }

     .info-icon:hover {
       color: #ff5722;
     }

     /* Tooltip styling */
     .info-icon::after {
       content: attr(data-tooltip);
       visibility: hidden;
       background-color: #333;
       color: #fff;
       text-align: center;
       padding: 5px 10px;
       border-radius: 4px;
       position: absolute;
       bottom: 100%;
       left: 50%;
       transform: translateX(-50%);
       white-space: nowrap;
       opacity: 0;
       transition: opacity 0.3s ease, visibility 0.3s ease;
       font-size: 12px;
     }

     .info-icon:hover::after {
       visibility: visible;
       opacity: 1;
     }
   </style>

   <div class="" id="singleaskquote">
     <div class="m-top-10 container-fluid">

       <div id="mulitpleaskquoteinvited" style="display: none">

         <?php
          //  pr($numberofaskquoteperjob);exit;
          foreach ($_SESSION['askquotenotinvite'] as $key => $result) { ?>
           <?php echo $result; ?> Avilable Quotes <?php echo $key; ?> Credit Left.

         <?php  } ?>
       </div>
       <!-- ?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'askQuote'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'askquotesubmit','autocomplete'=>'off')); ?> -->
       <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'jobpost', 'action' => 'mutipleaskQuote'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'askquotesubmit', 'autocomplete' => 'off')); ?>
       <span id="noselect" style="display: none">Select Atleast one Skills</span>
       <input type="hidden" name="user_id" value="<?php echo $userid ?>">

       <div class="">
         <?php if (count($activejobs) > 0) { ?>
           <table class="table table-bordered">
             <thead>
               <tr>
                 <th><strong>Job</strong></th>
                 <th><strong>Skills</strong></th>
               </tr>
             </thead>
             <tbody>
               <?php $count = 1;
                $pendingjob = []; // Initialize array to track pending jobs

                foreach ($activejobs as $jobs) { ?>
                 <tr>
                   <?php if (!in_array($jobs['id'], $app)) { ?>
                     <td style="width: 200px;">
                       <?php if ($jobs['askquotedata'] > 0) { ?>
                         <input type="checkbox"
                           name="job_id[<?php echo $jobs['id']; ?>]"
                           value="<?php echo $jobs['id']; ?>"
                           onclick="checkedJobs(this);"
                           data-totallimit="<?= $jobs['askquotedata']; ?>"
                           id="jobselectsingle<?php echo $jobs['id']; ?>"
                           class="jobselectsingle jobselectsinglechecked">
                       <?php } ?>

                       <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id']; ?>" target="_blank">
                         <?php echo $jobs['title']; ?>
                       </a>

                       <i class="fa fa-info-circle info-icon job-link"
                         data-tooltip="<?= $jobs['askquotedata'] > 0 ? 'Ask Quote Limit: ' . $jobs['askquotedata'] : 'No Ask Quote Left. Buy More!' ?>">
                       </i>
                     </td>
                   <?php
                      $pendingjob[] = $jobs['id']; // Store pending job
                    } ?>

                   <?php if (!in_array($jobs['id'], $app)) { ?>
                     <td>
                       <?php if ($jobs['askquotedata'] < 1) { ?>
                         <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>">
                           Buy Quote For <?php echo $jobs['title']; ?>
                         </a>
                       <?php } else { ?>
                         <select name="job_id[<?php echo $jobs['id']; ?>][]"
                           required
                           onchange="return myfunctionsingle(this)"
                           class="form-control jobselectsingle<?php echo $jobs['id']; ?>"
                           data-req="<?php echo $jobs['id']; ?>"
                           disabled>
                           <option value="">--Select--</option>
                           <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { ?>
                             <option value="<?php echo $skillsreq['skill']['id']; ?>">
                               <?php echo $skillsreq['skill']['name']; ?>
                             </option>
                           <?php } ?>
                         </select>

                         <input class="form-control" type="text"
                           id="currencysingle<?php echo $jobs['id']; ?>"
                           style="width: 29%"
                           placeholder="Currency"
                           readonly />

                         <input class="form-control" type="text"
                           id="offeramtsingle<?php echo $jobs['id']; ?>"
                           style="width: 38%"
                           placeholder="Offer Payment"
                           readonly />
                       <?php } ?>
                     </td>
                   <?php } ?>
                 </tr>
               <?php $count++;
                } ?>

               <?php if (empty($pendingjob)) { ?>
                 <tr>
                   <td colspan="2" style="text-align: center;">No Jobs Available For Quote</td>
                 </tr>
               <?php } ?>
             </tbody>
           </table>
         <?php } else { ?>
           <p>No jobs Found</p>
         <?php } ?>

         <?php if (!empty($pendingjob) && ($jobs['askquotedata'] > 0)) { ?>
           <div style="text-align: center;">
             <button type="submit" class="btn btn-default askquotesaves">Ask for Quote</button>
           </div>
         <?php } ?>
       </div>


       </form>
     </div>

   </div>


 </section>

 <!-- <script>
	var SITE_URL='<?php echo SITE_URL; ?>/';
	$('#askquotesave').click(function(e) { 
	e.preventDefault();
    $.ajax({
	type: "POST",
	 url: SITE_URL + 'jobpost/mutipleaskQuote',
	data: $('#askquotesubmit').serialize(),
	cache:false,
	success:function(data){ //alert(data); 
    location.reload();
    var myObj = JSON.parse(data);
    if(myObj.success=='noselect'){

     $("#noselect").css("display","block");
     setTimeout(function() {$("#noselect").fadeOut('fast');}, 5000); 
   }else if(myObj.success=='requestnotsent'){
    $('input:checkbox').removeAttr('checked');
   // location.reload();
  }else if(myObj.success=='requestsent'){
    $("#multipleaskquote").modal('toggle');
    $('input:checkbox').removeAttr('checked');
   // location.reload();
    
  }

		 
	}
    });
});
</script> -->
 <script>
   $(document).ready(function() {

     $(".askquotesaves").prop('disabled', 'disabled');

     $(".jobselectsingle, .jobselectsinglechecked").click(function(evt) {
       var id = $(this).attr("id");
       if ($(this).is(":checked")) {
         $("." + id).removeAttr('disabled');
         // askquotesaves class button disable
         $(".askquotesaves").removeAttr('disabled');
       } else {
         //$("."+id).removeAttr('disabled');
         $("." + id).prop('disabled', 'disabled');
         $(".askquotesaves").prop('disabled', 'disabled');

       }
     });
   });

   var SITE_URL = '<?php echo SITE_URL; ?>/';
   $('.askquotesave').click(function(e) { //alert();
     e.preventDefault();
     $.ajax({
       type: "POST",
       url: SITE_URL + 'jobpost/mutipleaskQuote',
       data: $('#askquotesubmit').serialize(),
       cache: false,
       success: function(data) { //alert(data); 
         // location.reload();
         var myObj = JSON.parse(data);
         if (myObj.success == 'noselect') {

           $("#noselect").css("display", "block");
           setTimeout(function() {
             $("#noselect").fadeOut('fast');
           }, 5000);
         } else if (myObj.success == 'requestnotsent') {

           $('input:checkbox').removeAttr('checked');
           location.reload();
         } else if (myObj.success == 'requestsent') {

           $('input:checkbox').removeAttr('checked');
           location.reload();

           // window.location.href = SITE_URL + 'viewprofile';

         }



       }
     });
   });
 </script>



 <script type="text/javascript">
   var site_url = '<?php echo SITE_URL; ?>/';

   function myfunctionsingle(x) {
     var reqid = x.getAttribute('data-req');
     var skillid = x.value;
     $(this).data("req");




     $.ajax({
       dataType: "html",
       type: "post",
       evalScripts: true,
       url: site_url + 'search/myfunctiondata',
       data: {
         skill: skillid,
         reqid: reqid
       },
       beforeSend: function() {
         $('#clodder').css("display", "block");

       },

       success: function(response) {

         var obj = JSON.parse(response);

         $('#offeramtsingle' + reqid).val(obj.payment_currency);
         $('#currencysingle' + reqid).val(obj.currency);


       },
       complete: function() {
         $('#clodder').css("display", "none");


       },
       error: function(data) {
         alert(JSON.stringify(data));

       }

     });




   }
 </script>
 <script type="text/javascript">
   $(".jobselectsingle").click(function(evt) {
     var id = $(this).attr("id");
     if ($(this).is(":checked")) {
       $("." + id).removeAttr('disabled');
     } else {
       //$("."+id).removeAttr('disabled');
       $("." + id).prop('disabled', 'disabled');
     }
   });
 </script>