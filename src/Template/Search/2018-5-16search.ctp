
<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
<?php 


if($type==1) { ?>
<div id="page-wrapper">

  <?php   if($searchdata){  ?>



<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

  <section id="page_search-job_result">
  <?php if($havevalidilty){ ?>
    <div id="aplybutton" style="visibility:hidden;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
    <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
    </div>


     <div class="pull-right top-three-but"> 
   
    <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut">Send Quote</button>
    </div>
    </div>
    </div>
<?php  } else{  ?>

    <div id="pingbutton" style="visibility:hidden;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
    <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
    </div>



    </div>
    </div>


    
<?php } ?>
      <h2>Search <span>Job Result</span></h2>
      <p class="m-bott-50">Here You Can Search Job Result</p>
  <div class="alert alert-warning alert-dismissible fade in" style="display:none" id="packfinish">
    
  Your Number Of Application Limit Exceed 
  </div>



    <div class="alert alert-success alert-dismissible fade in" style="display:none" id="singleskillnumber">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5 id="numberofapp"></h5>
  </div>

    </div>
    
    <div class="srch-box">
      <div class="container">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
            <label for="" class=" control-label">Job Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" >
            </div>
            <div class="col-sm-2">
            <label for="" class=" control-label">Event:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="">
            </div>
            <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
              <input type="text" class="form-control" id="inputEmail3" value="<?php echo $title; ?>">
            </div>
            <div class="col-sm-2">
            <label for="" class=" control-label">Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="">
            </div>
            <div class="col-sm-2">
            <label for="" class=" control-label">Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="">
            </div>
            
            
            <div class="col-sm-2"> 
            <label for="" class=" control-label" style="visibility:hidden;">View All</label><a href="#" class="btn btn-default btn-block">View All</a> </div>   </div>
           <div class="form-group">
            <div class="col-sm-2"> 
            <a href="#" class="btn btn-default btn-block">Edit Search</a> </div>
            <div class="col-sm-2"> 
            <a href="<?php echo SITE_URL ?>/search/advanceJobsearch" class="btn btn-primary btn-block">Advance Search</a> </div></div>
       
        </form>
      </div>
    </div>
    <div id="update">

    <div class="refine-search m-top-60">
      <div class="container">
      <div class="profile-bg">
        <div class="clearfix m-top-20">
          <div class="col-sm-3">
            <div class="panel panel-left">
              <h6>Refine Job Search</h6>
              <form class="form-horizontal"  id="refinesearch" action="<?php echo SITE_URL ?>/search/jobrefine" method="post">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Currency </label>
                  <div class="col-sm-12">
                   <select class="form-control" name="currency">
                   <option value="0">Select Currency</option>
               <?php $i=0; foreach($currencyarray as $key => $value){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $value; ?> </option>

               <?php $i++;  } ?>       
              

                   
                    </select>
                  </div>
                </div>
                <div class="form-group salry">
                  <label for="inputEmail3" class="col-sm-12 control-label">Salary </label>
    <p class="prc_sldr">
                   <label for="amount">Salary</label>
                   <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="salaryrange">
                  </p>
<div id="slider-range"></div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment AS per </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="payment">
                    <option value="0">Select Payment</option>
                      <?php  $i=0;  foreach($payemntfaq as $key => $paymentfaqvalue){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $paymentfaqvalue; ?> </option>

               <?php $i++; } ?>  
                    </select>
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Location </label>
                  <div class="col-sm-12">
                   <input type="text" class="form-control" placeholder="Location" name="location">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                       <select class="form-control" name="telenttype">
                       <option value="0">Select Talent Type</option>
                      <?php $i=0;  foreach($talentype as $key => $talentypevalue){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $talentypevalue; ?> </option>

               <?php $i++; } ?>  
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Event Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="eventtype">
                    <option value="0">Select Event</option>
                        <?php $i=0; foreach($eventtype as $key => $eventtypevalue){ ?>

                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $eventtypevalue; ?> </option>

               <?php  $i++; } ?> 
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12"> </label>
                  <div class="col-sm-12">
                    <label class="">
                      <input type="radio" name="time" id="inlineRadio1" value="part Time"  >
                      Part Time</label>
                    <label class="">
                      <input type="radio" name="time" id="inlineRadio2" value="Full Time"  >
                      Continuous Employment </label>
                    
                  </div>
                </div>
                
                
                
                
                <input type="hidden" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" name="keyword">
                
                
                
                <div class="form-group">
                  <div class="col-sm-12"> 

                  <input type="submit" value="Refine Search" class="btn btn-default"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-9" id="nof">
            <div class="panel panel-right">
              <div class="clearfix job-box">
<form id="multiple" method="POST">

<input type="hidden" id="btuuonpress" name="buttonpresstype" value="5"/>
              <?php 
              $date=date('Y-m-d H:i:s');
               $max=0;
              $jobarray=array(); $isdata=0; foreach($searchdata as $value) { 
              

        
         

              

                 if(!in_array($value['id'],$jobarray )){
               
                     $jobarray[]=$value['id']; 

                  
                       if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                       
                       
      if($date<$value['last_date_app']) {
$isdata=1;

               ?>



        <div class="col-sm-12  box job-card">
        
		<div class="check_hide">
        
		<?php 
     $appliedjob=$this->Comman->appliedjob($value['id']); 
     $sentquote=$this->Comman->sentquote($value['id']); 


    if(!$appliedjob){ ?>
        <input type="checkbox" name="job[]" value="<?php echo $value['id'] ?>" class="chkbox sendquoute" data-val="<?php echo $value['id'] ?>"  id="mycke<?php echo $value['id']; ?>">
        <?php } ?>
        <div class="remove-top"> 


   <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
          </div>
          </div>
        
        
        <div class="col-sm-3">
            <div class="profile-det-img1">
            <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
            <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
            
            </div></div>
        <div class="col-sm-9">
            <h3 class="heading"><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" target="_blank"><?php echo $value['title'] ?></a><span><?php echo date('d M Y',strtotime($value['last_date_app']));  ?></span></h3>
            <p><?php echo $value['location'] ?></p>
            <ul class="list-unstyled job-r-skill">
            <li><a href="#" class="fa fa-user"></a>
      
          <?php 

                $skill=$this->Comman->requimentskill($value['id']);
                
                
                 ?>
           <?php

            foreach($skill as $vacancy){ 
            	
$skillarray=array();
if($max<$vacancy['payment_amount']){

	 $max=$vacancy['payment_amount'];
	 
}

             echo $vacancy['skill']['name']; echo ",";  } ?>
           

            </li>
            <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['eventname'] ?></li>
            </ul>
            <div class="row">
              <div class="col-sm-7">
                   <?php 

                    //pr($appliedjob);
                    if($appliedjob['nontalent_aacepted_status']=="N" && $appliedjob['talent_accepted_status']=="Y"){

                      echo '<a href="javascript:void(0)" class="btn btn-default">Applied </a>';
                   }else if($appliedjob['nontalent_aacepted_status']=="Y" && $appliedjob['talent_accepted_status']=="N"){echo '<a href="javascript:void(0)" class="btn btn-default">Booking Request Recived </a>'; }elseif($appliedjob['nontalent_aacepted_status']=="Y" && $appliedjob['talent_accepted_status']=="Y"){echo '<a href="javascript:void(0)" class="btn btn-default">Selected </a>';}else{  ?>  

 <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-default" id="apply<?php echo $value['id'] ?>" target="_blank">Apply</a>
    <?php }  ?>


    <?php if($sentquote['revision']==0 && $sentquote['status']=="N" && $sentquote['nontalent_satus']=="Y" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" id="Send<?php echo $value['id'] ?>" target="_blank">Quote Send</a>
<?php } else if($sentquote['revision']!=0 && $sentquote['status']=="N" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>
 <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" id="Send<?php echo $value['id'] ?>" target="_blank">Revised Quote Revived </a>

<?php  } else if($sentquote['status']=="R" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>

<a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" id="Send<?php echo $value['id'] ?>" target="_blank">Rejected </a>
<?php  } else if($sentquote['status']=="S" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y") { ?>
<a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" id="Send<?php echo $value['id'] ?>" target="_blank">Selected </a>

<?php }else{ if($appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>

<a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" id="Send<?php echo $value['id'] ?>" target="_blank">Send Quote </a>
<?php }} ?>
           
              </div>
              
              <div class="col-sm-5 text-right">
                <div class="icon-bar"> 
                <a href="#" class="fa fa-thumbs-up"></a>
                 <a href="#" class="fa fa-share"></a> 
                   <a href="#" class="fa fa-paper-plane-o"></a>
               
                 <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$savejobarray)) { ?> style="color:green" <?php  } ?>></a>
                 <a href="#" class="fa fa-ban"></a> 
                 </div>
                
                
              </div>
            </div>
          </div>
        </div>
        
    
        <?php    } } }} ?>

 
        </form>
  
        
      </div>

              
              
              
              
                            
           <div class="row">   <div class="col-sm-12 m-top-20">
                <?php if($isdata==1){ ?>
            <a href="Javascript:void(0)" class="btn btn-default m-right-20" data-toggle="modal" data-target="#savejobrefinetamplate">Save Search Result </a>
            <?php }else { ?>
<h3 style="margin-top: 172px;margin-left: 300px;">No Job's Found;</h3>

            <?php } ?>




             </div></div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <?php  } else{ ?>
?>
    
    
     <div class="refine-search m-top-60">
      <div class="container">
      <div class="profile-bg">
        <div class="clearfix m-top-20">
          <div class="col-sm-3">
            <div class="panel panel-left">
              <h6>Refine Profile Search</h6>
              <form class="form-horizontal"  id="refinesearch" action="<?php echo SITE_URL ?>/search/jobrefine" method="post">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Currency </label>
                  <div class="col-sm-12">
                   <select class="form-control" name="currency">
                   <option value="0">Select Currency</option>
               <?php $i=0; foreach($currencyarray as $key => $value){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $value; ?> </option>

               <?php $i++;  } ?>       
              

                   
                    </select>
                  </div>
                </div>
                <div class="form-group salry">
                  <label for="inputEmail3" class="col-sm-12 control-label">Salary </label>
    <p class="prc_sldr">
                   <label for="amount">Salary</label>
                   <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="salaryrange">
                  </p>
<div id="slider-range"></div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment AS per </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="payment">
                    <option value="0">Select Payment</option>
                      <?php  $i=0;  foreach($payemntfaq as $key => $paymentfaqvalue){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $paymentfaqvalue; ?> </option>

               <?php $i++; } ?>  
                    </select>
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Location </label>
                  <div class="col-sm-12">
                   <input type="text" class="form-control" placeholder="Location" name="location">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                       <select class="form-control" name="telenttype">
                       <option value="0">Select Talent Type</option>
                      <?php $i=0;  foreach($talentype as $key => $talentypevalue){ ?>
                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $talentypevalue; ?> </option>

               <?php $i++; } ?>  
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Event Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="eventtype">
                    <option value="0">Select Event</option>
                        <?php $i=0; foreach($eventtype as $key => $eventtypevalue){ ?>

                      <option value="<?php echo $key ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $eventtypevalue; ?> </option>

               <?php  $i++; } ?> 
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12"> </label>
                  <div class="col-sm-12">
                    <label class="">
                      <input type="radio" name="time" id="inlineRadio1" value="part Time"  >
                      Part Time</label>
                    <label class="">
                      <input type="radio" name="time" id="inlineRadio2" value="Full Time"  >
                      Continuous Employment </label>
                    
                  </div>
                </div>
                
                
                
                
                <input type="hidden" class="form-control" id="inputEmail3" value="<?php echo $title; ?>" name="keyword">
                
                
                
                <div class="form-group">
                  <div class="col-sm-12"> 

                  <input type="submit" value="Refine Search" class="btn btn-default"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-9" id="nof">
            <div class="panel panel-right">
              <div class="clearfix job-box">
<form id="multiple" method="POST">


              <?php 
              $date=date('Y-m-d H:i:s');
              
              $jobarray=array();  foreach($searchdata as $value) { 
             // pr($value);

        
         

              

                 if(!in_array($value['id'],$jobarray )){
               
                     $jobarray[]=$value['id']; 

                  
                       if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                       
                       
      if($date<$value['last_date_app']) {

               ?>



        <div class="col-sm-12  box job-card">
        <input type="checkbox" name="job[]" value="<?php echo $value['id'] ?>" class="chkbox" data-val="<?php echo $value['id'] ?>" >
        <div class="remove-top"> 


   <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
          </div>
          <div class="col-sm-3">
            <div class="profile-det-img1">
            <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
            <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
            
            </div></div>
          <div class="col-sm-9">
            <h3 class="heading"><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>"><?php echo $value['title'] ?></a><span><?php echo date('d M Y',strtotime($value['last_date_app']));  ?></span></h3>
            <p><?php echo $value['location'] ?></p>
            <ul class="list-unstyled job-r-skill">
            <li><a href="#" class="fa fa-user"></a>
      
          <?php 

                $skill=$this->Comman->requimentskill($value['id']);
                
                
                 ?>
           <?php
 $max=0;
            foreach($skill as $vacancy){ 
$skillarray=array();
if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

             echo $vacancy['skill']['name']; echo ",";  } ?>
           

            </li>
            <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['eventname'] ?></li>
            </ul>
            <div class="row">
              <div class="col-sm-7">
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-default" target="_blank">Apply</a>
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary" target="_blank">Send Quote</a>
              </div>
              
              <div class="col-sm-5 text-right">
                <div class="icon-bar"> 
                <a href="#" class="fa fa-thumbs-up"></a>
                 <a href="#" class="fa fa-share"></a> 
                   <a href="#" class="fa fa-paper-plane-o"></a>
               
                 <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$savejobarray)) { ?> style="color:green" <?php  } ?>></a>
                 <a href="#" class="fa fa-ban"></a> 
                 </div>
                
                
              </div>
            </div>
          </div>
        </div>
        
    
        <?php    } } }} ?>

 
        </form>
  
        
      </div>

              
              
              
              
                            
           <div class="row">   <div class="col-sm-12 m-top-20"> <h3 align='center' style="margin-top:150px">No Jobs Found</h3> </div></div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    
    
   <?php 
    
    
    
    
    
    } ?>
    </div>
  </section>
  

  
</div>
<script>
$(document).ready(function(){
    $(".btn").click(function(){
        $(".exp-cnt").toggleClass("show");
    });
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('#refinesearch').submit(function(event){
    console.log('test');
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/jobrefine',
            data: $('#refinesearch').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

       
            
            if(response==1){
       $('#nof').html("<h3 align='center' style='margin-top:300px'>No job's Found</h3>");
          
            }else{
             $('#update').html(response);
            }
      
    
            },
       complete: function() {
            $('#clodder').css("display", "none");
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>

<script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.actbut').click(function() {
     // alert($(this).val());

     // $('#btuuonpress').value='1';
     var v=$(this).val();
     $('#btuuonpress').val(v);
     
      console.log('testdfsdf');
        });


  $('#multiple').submit(function(event){
   console.log('testd');
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/aplyjobmultiple',
            data: $('#multiple').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==2){

                 // var obj = jQuery.parseJSON(response);
$('#singleskillnumber').css('display','block');
$('#singleskillnumber').text('Application to Jobs Sent Successfully')

   //console.log('#apply'+myObj.job_id);

   $.each(myObj.jobarray, function(key,value) {
  //alert(value);

   $('#apply'+value).text('Applied');
                 $('#mycke'+value).css('display','none');
                 $('#mycke'+value).prop('checked', false);
                 $('#Send'+value).css('display','none');

                 //alert('#multiplejob #job-'+value);
                 $('#multiplejob #job-'+value).remove();
                 $('#multiplequote #job-'+value).remove();
});
                window.scrollTo(0, 50); 
                $('#aplybutton').css("visibility","hidden");
//window.location = SITE_URL+"showjob/applied";
                 }else if(myObj.success==1){
                  $("#applymultiplejob").modal('show');
                 }else if(myObj.success==3){
             
                    $("#applymultiplequote").modal('show');
                 }
              
    
    
            },
       complete: function() {
            $('#clodder').css("display", "none");
               a=0; 
   

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>

<script>
$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 1,
      max: <?php echo $max; ?>,
      values: [ 0, <?php echo $max; ?>],
      slide: function( event, ui ) {
        $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
  } );
</script>

   <script>
$(document).ready(function(){
  var site_url='<?php echo SITE_URL;?>/';
  $('.delete_jobalerts').click(function() { 
 var job_id = $(this).data('val');
// $("#"+job_id).remove();
 var job_action = $(this).data('action');
   $.ajax({
        type: "post",
        url: site_url+'myalerts/alertsjob',
        data:{jobsearch:job_id,action:job_action},
        success:function(data){ 
      $("."+job_id).remove();
        }
           
        });
 
 
});
});
    </script>



   <script>
     var a=0;
$(document).ready(function(){
   var pop=0;
  var site_url='<?php echo SITE_URL;?>/';
  $('.chkbox').click(function() { 
   
 var job_id = $(this).data('val');

// $("#"+job_id).remove();



 if ($(this).is(':checked')) {
  var status="chek";

//$(this).addClass('Active');
 $(this).parent('div').addClass('Active');

   $.ajax({
        type: "post",
        url: site_url+'search/applymultiple',
        data:{jobsearch:job_id,a:a,status:status},
        success:function(data){ 
        

          if(data=="show"){
            
            $('#packfinish').css("display","block");




          }else{
     $("#multiplejob").append(data);
     $('#packfinish').css("display","none");
   }
            pop++;

            //alert(pop);

            if(pop>=1){

            if(data=="show"){
            $('#pingbutton').css("visibility","visible");

            mypingfunction(job_id,a);

            }else{
            $('#aplybutton').css("visibility","visible");
            }

            }

        }
           
        });
     a++;


 }else{
a--;
pop--;

  //jQuery(this).parent('li').addClass('yourClass');
  $(this).parent('div').removeClass('Active');

if(pop<1){
   

    $('#aplybutton').css("visibility","hidden");
  }

  $("#job-"+job_id).remove();
 }
 
 
});
});
    </script>



   <script>
     var q=0;
$(document).ready(function(){
   var pop=0;
  var site_url='<?php echo SITE_URL;?>/';
  $('.sendquoute').click(function() { 
   
 var job_id = $(this).data('val');

// $("#"+job_id).remove();



 if ($(this).is(':checked')) {
  var status="chek";

//$(this).addClass('Active');
 $(this).parent('div').addClass('Active');

   $.ajax({
        type: "post",
        url: site_url+'search/sendquotemultiple',
        data:{jobsearch:job_id,a:q,status:status},
        success:function(data){ 
        

          if(data=="show"){
            
            $('#packfinish').css("display","block");

   // $('#aplybutton').css("visibility","hidden");
  // $("#aplybutton").attr("data-toggle","");


          }else{
     $("#multiplequote").append(data);
     $('#packfinish').css("display","none");
   }


        }
           
        });
     q++;
     pop++;

     //alert(pop);

  if(pop>=1){
    

    $('#aplybutton').css("visibility","visible");
    //$("#aplybutton").attr("data-toggle","modal");

  }

 }else{
q--;
pop--;

  //jQuery(this).parent('li').addClass('yourClass');
  $(this).parent('div').removeClass('Active');

if(pop<1){
   

    $('#aplybutton').css("visibility","hidden");
  }

  $("#job-"+job_id).remove();
 }
 
 
});
});
    </script>

    <script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.savejobs').click(function(){
    console.log('test');
var job=$(this).data('job');
    
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/savejobs',
            data: {jobid:job},
       beforeSend: function() {
         

      },
      
            success:function(response){
                
                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                 

               $('#'+job+'').css('color','green');
                 }else{
                   $('#'+job+'').css('color','white');
                 }
           
    
            },
       complete: function() {
            
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });

function mypingfunction(job_id,count){

  alert(job_id);


      $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: SITE_URL + 'search/pingjobs',
      data: {jobid:job_id,count:count},
      beforeSend: function() {


      },

      success:function(response){

   $('#updateping').append(response);
var amt=<?php echo $ping_amt ?>;
alert(amt*count);
$('#pingamount').val(amt*count);
$('#pingcount').val(count);
      },
      complete: function() {



      },
      error: function(data) {
      alert(JSON.stringify(data));

      }

      });
    



}

</script>





    <!-- Modal -->
<div id="applymultiplejob" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Apply Job</h4>
      </div>

      <div class="modal-body" >

      <form id="multiplejob"  method="POST">
        


     
      </form>
      </div>
      
              
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" form="multiplejob">Apply</button>
      </div>
    </div>

  </div>
</div>




    <!-- Modal -->
<div id="applymultiplequote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Quote</h4>
      </div>

      <div class="modal-body" >

      <form id="multiplequote"  method="POST">
        


     
      </form>
      </div>
      
              
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" form="multiplequote">Apply</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="pingjobmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ping jobs</h4>
      </div>
      <div class="modal-body">
       <?php echo $this->Form->create('Package',array('url' => array('controller' => 'Package', 'action' => 'Pingpay'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'PackageIndexForm','autocomplete'=>'off')); ?>
    
    <input type="hidden" name="amount" value="<?php echo $ping_amt; ?>">
    <input type="hidden" name="payment_method" value="Paypal">
    <input type="hidden" name="user_id" value="<?php $this->request->session()->read('Auth.User.id'); ?>">
  

  <form class="form-horizontal">
  <div class="form-group">
   
    <div class="col-sm-6">
    <?php echo $this->Form->input('user_name',array('class'=>'form-control','placeholder'=>'Enter Your Name','pattern'=>'[a-zA-Z ]*','id'=>'inputEmail3','required'=>true,'readonly','label' =>false,'type'=>'text','value'=>$this->request->session()->read('Auth.User.user_name'))); ?>
    </div>
    <div class="col-sm-6">
    <?php echo $this->Form->email('email',array('class'=>'form-control','placeholder'=>'Enter Your Email','required'=>true,'readonly','autocomplete'=>'off','id'=>'username','label' =>false,'value'=>$this->request->session()->read('Auth.User.email'))); ?>
    </div>
  </div>

  
  
    <div class="form-group">
   
    <div class="col-sm-6">
    <?php echo $this->Form->input('card_name',array('class'=>'form-control','placeholder'=>'Name on Card','pattern'=>'[a-zA-Z ]*','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
    </div>
    <div class="col-sm-6">
    <?php echo $this->Form->input('card_number',array('class'=>'form-control','placeholder'=>'Card Number','pattern'=>'[0-9 ]*','maxlength'=>'16','min'=>'16','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
    </div>
  </div>

    <div class="form-group">
  <div class="col-sm-6">
        <?php echo $this->Form->input('csv_number',array('class'=>'form-control','placeholder'=>'CSV','pattern'=>'[0-9 ]*','maxlength'=>'3','min'=>'3','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
  </div>
  <?php
      for($m=0;$m<=12;$m++)
      {
    $months[] = $m;
      }
      
      $current_year = date('Y');
      $next_year = $current_year+10;
      for($y=$current_year;$y<=$next_year;$y++)
      {
    $years[] = $y;
      }
      
      
   ?>
   <div class="col-sm-3">
      <?php echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Month','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'Expiry Month','options'=>$months)); ?>
  </div>
  <div class="col-sm-3">
      <?php echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Country','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'Expiry Year','options'=>$years)); ?>
  </div>
<br><br><br>
   <div class="col-sm-3">
      <?php echo $this->Form->input('amount',array('class'=>'form-control','placeholder'=>'Amount','required'=>true,'label' =>false,'id'=>'pingamount')); ?>
  </div>
  </div>
  <input type="hidden" name="count" id="pingcount">
  
  
  <div class="form-group" >
    <div class="col-sm-12 text-center"> </div>
  </div>
    <div class="form-group" style="
    margin-left:  0px;
    margin-right: 23px;
">
      <div id="updateping"></div>
  
  <div class="form-group">
    <div class="col-sm-12 text-center">
    <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
    </div>
  </div>
   <?php echo $this->Form->end(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>
<script type="text/javascript">
  $('#PackageIndexForm').submit(function(event){
  
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'package/Pingpaybymultiple',
            data: $('#PackageIndexForm').serialize(),
       beforeSend: function() {
           

      },
      
            success:function(response){
        var myObj = JSON.parse(response);
      if(myObj.success==1){

var count=0;
   $.each(myObj.jobarray, function(key,value) {
  alert(value);

   $('#apply'+value).text('Applied');
                 $('#mycke'+value).css('display','none');
                 
                 $('#mycke'+value).prop('checked', false);
                 $('#Send'+value).css('display','none');
//alert('#multiplejob #job-'+value);
                 $('#multiplejob #job-'+value).remove();
                 count++;
 //$('#multiplejob').find('#job-'+value).remove();
                  //$('#job-'+value).remove();
});
   $('#singleskillnumber').css('display','block');
$('#numberofapp').text('Application to '+count+' jobs sent Successfully');             
//window.location = SITE_URL+"showjob/applied";

$('#pingjobmodal').modal('toggle');
 window.scrollTo(0, 50);
 $('#pingbutton').css("visibility","hidden");
                 }else{
                  $("#applymultiplejob").modal('show');
                 }

 
    
            },
       complete: function() {
        
      // alert(a);

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });
</script>

<script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';



  $('#multiplequote').submit(function(event){
  
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'jobpost/aplysendquotemultiple',
            data: $('#multiplequote').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==2){

var count=0;
   $.each(myObj.jobarray, function(key,value) {
  //alert(value);


   $('#Send'+value).text('Quote Send');
                // $('#mycke'+value).css('display','none');
                 
                 $('#mycke'+value).prop('checked', false);
                 //$('#Send'+value).css('display','none');
//alert('#multiplejob #job-'+value);
                 $('#multiplequote #job-'+value).remove();
                  $('#multiplejob #job-'+value).remove();
                 count++;
 //$('#multiplejob').find('#job-'+value).remove();
                  //$('#job-'+value).remove();
});
   $('#singleskillnumber').css('display','block');
$('#numberofapp').text('Job Quote to '+count+' jobs sent Successfully');             
//window.location = SITE_URL+"showjob/applied";

$('#applymultiplequote').modal('toggle');
 window.scrollTo(0, 50);
 $('#aplybutton').css("visibility","hidden");
 
                 }else{
                  $("#applymultiplequote").modal('show');
                 }
              
    
    
            },
       complete: function() {
            $('#clodder').css("display", "none");
            a=0;
      // alert(a);

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>

<script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';



  $('#multiplejob').submit(function(event){
  
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'jobpost/aplymultiple',
            data: $('#multiplejob').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==2){

                 // var obj = jQuery.parseJSON(response);



   //console.log('#apply'+myObj.job_id);
var count=0;
   $.each(myObj.jobarray, function(key,value) {
  //alert(value);

   $('#apply'+value).text('Applied');
                 $('#mycke'+value).css('display','none');
                 
                 $('#mycke'+value).prop('checked', false);
                 $('#Send'+value).css('display','none');
//alert('#multiplejob #job-'+value);
                 $('#multiplejob #job-'+value).remove();
                 count++;
 //$('#multiplejob').find('#job-'+value).remove();
                  //$('#job-'+value).remove();
});
   $('#singleskillnumber').css('display','block');
$('#numberofapp').text('Application to '+count+' jobs sent Successfully');             
//window.location = SITE_URL+"showjob/applied";

$('#applymultiplejob').modal('toggle');
 window.scrollTo(0, 50);
 $('#aplybutton').css("visibility","hidden");
                 }else{
                  $("#applymultiplejob").modal('show');
                 }
              
    
    
            },
       complete: function() {
            $('#clodder').css("display", "none");
            a=0;
      // alert(a);

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>

<!-- Modal -->
<div class="modal fade" id="savejobrefinetamplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Template </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <div class="alert alert-success" id="saverefinejobs" style="display:none">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    <strong>Success!</strong> Your Template is saved Successfully 
</div>
        <?php if($_SESSION['Refinejobfilter']) { ?>
        <form id="savesearchresulttem"  onsubmit="return test(this)" >
<div class="form-group">
    <label for="exampleInputEmail1">Enter Tamplate Name</label>
    <input type="text" class="form-control"  placeholder="Enter Tamplate Name" name="template" id="template">
      </div>
 <?php } else{ ?>
<div class="alert alert-secondary" role="alert">
 Nothing to Save 
</div>

       <?php } ?>
        
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary" <?php if($_SESSION['Refinejobfilter']) { ?> style="display:block" <?php }else { ?> style="display:none"   <?php } ?>>Save</button>
      </div>

       </form>

      
    </div>
  </div>
</div>

<script>
  function test(x){
    //alert(x.template.value);
     event.preventDefault();

var tem=x.template.value;

var w='1';

      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/savesearchresult',
            data: {template:tem,savewhere:w},
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){
              //alert(response);
               
 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                  $('#saverefinejobs').css("display","block");
                 }
                    setTimeout(function(){ $('#savejobrefinetamplate').modal('toggle');  }, 7000);
    
    
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

<?php  } else {    ?>
<?php  

if($searchdata) {
$agearray=array();
      foreach ($searchdata as $key => $value) {


       $birthdate = date("Y-m-d",strtotime($value['dob']));
      
      $from = new DateTime($birthdate);
      $to   = new DateTime('today');
      $age=$from->diff($to)->y;
      if(!in_array($age, $agearray))
      $agearray[]=$age;

      }
      
?>
<section id="page_search_result">
    <div class="container">
      <h2>Search <span>Result</span></h2>
      <p class="m-bott-50">Here You Can See Search Result</p>
    </div>
    <div class="srch-box">
      <div class="container">
        <form class="form-horizontal" >
          <div class="form-group">
            <div class="col-sm-2">
              <label>Talent Name:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for..." value="<?php echo $title ?>">
            </div>
            <div class="col-sm-2">
              <label>Profile Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for..." value="<?php echo $title ?>">
            </div>
            <div class="col-sm-2">
              <label>Word Search:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2">
              <label>Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2">
              <label>Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="What are you looking for...">
            </div>
            <div class="col-sm-2 btn_view_al">
              <a href="#" class="btn btn-default btn-block">View All</a>
            </div>
          </div>
          <div class="form-group">  
            <div class="col-sm-2"> <a href="#" class="btn btn-default btn-block">Edit Search</a> </div>
            <div class="col-sm-2"> <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div>
          </div>
        </form>
      </div>
    </div>
    <div class="refine-search">
      <div class="container">
        <div class="row m-top-20">
          <div class="col-sm-3">
            <div class="panel panel-left">
              <h6>Refine Profile Search</h6>
              <form class="form-horizontal" id="telentrefine">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" placeholder="Name" value="<?php echo $title; ?>" name="name" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">age </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="age">
                    <option value="0">Select age</option>
                    <?php for ($i=0; $i <count($agearray) ; $i++) { ?>
                    
                      <option value="<?php echo  $agearray[$i] ?>"><?php  echo  $agearray[$i] ?></option> 
                   <?php  } ?>
                      
                    
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Gender</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="gender">
                      <option value="0" >Select Gender</option>
                      <option value="m">Male</option>
                      <option value="f">Female</option>
                      <option value="o" >Other</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                
                  <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="performancelan">
                    <option value="0" >Select Language</option>
                    <?php foreach($performancelan as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="language">
                    <option value="0" >Select Language</option>
             <?php foreach($languageknown as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Online Now </label>
                  <div class="col-sm-12">
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio1" value="0">
                      All </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio2" value="1">
                      Online </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio3" value="2">
                      Offline </label>
                  </div>
                </div>
                <?php $vitalstatic=array(); //pr($querytionarray); ?>
                <?php  if($querytionarray){   ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Vital Statistics parameters </label>
                 <?php  $i=0; foreach($querytionarray as $key=> $value){  ?>

                
                  <p class="prc_sldr">
                   <label for="amount"><?php echo  $key; ?></label>
                   
                  </p>
                
                <div class="col-sm-12">
                    <select class="form-control" name="vitalstats[<?php echo  $i; ?>]">
                     <option value="0">Select  <?php echo  $key; ?> </option>
                    <?php  foreach($value as $key=> $opt){ ?>

                      <option value="<?php echo key($value); ?>"><?php echo $opt ?></option>

                      <?php } ?>
                     
                    </select>
                  </div>
                   <?php  $i++;} ?>
                </div>
                <?php }  ?>

              
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="activein">
                      <option value="0">Select Active in</option>
                      <option value="5">5 days</option>
                      <option value="10">10 days</option>
                      <option value="15">15 days</option>
                      <option value="20">20 days</option>
                      <option value="25">25 days</option>
                      <option value="30">30 days</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="paymentfaq">
                    <option value="0" >Select Payment Frequency </option>
                       <?php foreach($paymentfaq as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="skill">
                      <option value="0" >Select Talent Type</option>
                        <?php foreach($skill as $key => $skillvalue){ ?>
                      <option value="<?php echo $key ?>"> <?php echo  $skillvalue; ?> </option>

               <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Ethnicity</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="ethnicity">
                    <option value="0" >Select  Ethnicity </option>
                      <?php foreach($Enthicity as $key => $Enthicity){ ?>
                      <option value="<?php echo $key ?>"> <?php echo  $Enthicity; ?> </option>

               <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group Review">
                  <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>
                   
                      <fieldset id='demo6' class="rating">
              
              
              
              
              
               <input class="stars" type="radio" id="starr310" name="r3" value="10"  / >
                        <label class = "review full" for="starr310" title="Excellent"></label>
                        
                        <input class="stars" type="radio" id="starr39half" name="r3" value="9.5"  / >
                        <label class = "review half" for="starr39half" title="Excellent"></label>
                        
                        <input class="stars" type="radio" id="starr39" name="r3" value="9"  / >
                        <label class = "review full" for="starr39" title="Excellent"></label>
                        
                        <input class="stars" type="radio" id="starr38half" name="r3" value="8.5"  / >
                        <label class = "review half" for="starr38half" title="Good"></label>
                        
                        <input class="stars" type="radio" id="starr38" name="r3" value="8"  / >
                        <label class = "review full" for="starr38" title="Good"></label>
                    
                    
            <input class="stars" type="radio" id="starr37half" name="r3" value="7.5"  / >
                        <label class = "review half" for="starr37half" title="Good"></label>
                        
                        <input class="stars" type="radio" id="starr37" name="r3" value="7"  / >
                        <label class = "review full" for="starr37" title="Good"></label>
                    
            <input class="stars" type="radio" id="starr36half" name="r3" value="6.5"  / >
                        <label class = "review half" for="starr36half" title="Average"></label>
                    
                    
            <input class="stars" type="radio" id="starr36" name="r3" value="6"  / >
                        <label class = "review full" for="starr36" title="Average"></label>
                    
            <input class="stars" type="radio" id="starr35half" name="r3" value="5.5"  / >
                        <label class = "review half" for="starr35half" title="Average"></label>
              
                        <input class="stars" type="radio" id="starr35" name="r3" value="5"  />
                        <label class = "review full" for="starr35" title="Average"></label>
                        
                        <input class="stars" type="radio" id="starr34half" name="r3" value="4.5"   />
                        <label class="review half" for="starr34half" title="Below average "></label>
                        
                        <input class="stars" type="radio" id="starr34" name="r3" value="4"  />
                        <label class = "review full" for="starr34" title="Below average "></label>
                        
                        <input class="stars" type="radio" id="starr33half" name="r3" value="3.5"  />
                        <label class="review half" for="starr33half" title="Below average "></label>
                        
                        <input class="stars" type="radio" id="starr33" name="r3" value="3"  />
                        <label class = "review full" for="starr33" title="Below average "></label>
                        
                        <input class="stars" type="radio" id="starr32half" name="r3" value="2.5"  />
                        <label class="review half" for="starr32half" title="Bad"></label>
                        
                        <input class="stars" type="radio" id="starr32" name="r3" value="2"  />
                        <label class = "review full" for="starr32" title="Bad"></label>
                        
                        <input class="stars" type="radio" id="starr31half" name="r3" value="1.5"  />
                        <label class="review half" for="starr31half" title="Bad"></label>
                        
                        <input class="stars" type="radio" id="starr31" name="r3" value="1"  />
                        <label class = "review full" for="starr31" title="Bad"></label>
                        
                        <input class="stars" type="radio" id="starr3half" name="r3" value="0.5"  />
                        <label class="review half" for="starr3half" title="Bad"></label>
                    </fieldset>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Working Style</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="workingstyle">
                      <option value="0" >Select Working Style</option>
                      <option value="P" >Professional</option>
                      <option value="A">Amateur</option>
                      <option value="PT">Part time</option>
                      <option value="H">Hobbyist</option>
                    </select>
                  </div>
                </div>
               
                <div class="form-group">
                  <div class="col-sm-12"> <a href="#" class="btn btn-default">Back to Search Result </a>

                      <input type="submit" value="Refine" class="btn btn-default">
                   </div>
                </div>


                
              </form>
            </div>
          </div>
          <div class="col-sm-9" id="data">
            <div class="panel-right">
      


                <?php 

                foreach($searchdata as $value){ 


if(!in_array($value['id'],$_SESSION['profilesearch'])) {
                 ?>


              <div class="member-detail  box row">
                <div class="col-sm-3">
                  <div class="member-detail-img"> <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
                    <div class="img-top-bar"> <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user']['id'] ?>" class="fa fa-user"></a> </div>
                  </div>
                </div>
                <div class="col-sm-9 boc_gap">
                  <div class="row">
                  <ul class="col-sm-4 member-info">
                    <li>Name</li>
                    <li>Gender</li>
                    <li>Talent</li>
                    <li>Location</li>
                    <li>Experience</li>
                    </ul>
                  <ul class="col-sm-2">
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                    <li>:</li>
                  </ul>
                  <ul class="col-sm-6">
                    <li><?php echo $value['name'] ?></li>
                    <li><?php 
                      switch($value['gender']){
                        case 'm' :
                        echo "Male";
                        break;
                        case 'f' :
                        echo "FeMale";
                        break;
                        case 'o' :
                        echo "Other";
                        break;

                      } 

                     ?></li>
                    <li><?php  foreach($value['user']['skillset'] as $skillvalue){
                      
                    

                    echo  $skill= $skillvalue['skill']['name'].","; 
                     
                    
                       }  ?></li>
                    <li><?php echo $value['current_location'] ? $value['current_location'] :'-';  ?></li>
                    <li><?php if($value['user']['professinal_info']){  

                 echo date('Y')-$value['user']['professinal_info']['performing_year']; 
                 echo "Years"; 
                  }else{ echo "-";};
                     ?></li>
                  
                  </ul>
                  </div>
                  <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['user']['id']  ?>" class="btn btn-default ad">Add Friend</a>
                  <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['user']['id']  ?>" class="btn btn-default qot">Ask For Quote</a>
                  <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['user']['id']  ?>" class="btn btn-default cnt">Connect</a>

                </div>
                <div class="icon-bar"> 
                <a href="#" class="fa fa-thumbs-up"></a> 
                <a href="#" class="fa fa-share"></a> 
                <a href="#" class="fa fa-envelope"></a> 
                <a href="#" class="fa fa-paper-plane-o"></a>                 
                <a href="#" class="fa fa-floppy-o saveprofile" id="<?php echo $value['id'] ?>" data-profile="<?php echo $value['id'] ?>"></a>
                <a href="#" class="fa fa-download"></a>
                <a href="#" class="fa fa-file-text-o"></a>
                <a href="#" class="fa fa-ban"></a>  
                </div>
                <div class="box_hvr_checkndlt">
                <span class="pull-left"><input type="checkbox" value=""></span>
                
                 <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
              </div>



<?php  } } ?>






          




                 <script>
$(document).ready(function(){
  var site_url='<?php echo SITE_URL;?>/';
  $('.delete_jobalerts').click(function() { 
 var profile_id = $(this).data('val');
// $("#"+job_id).remove();
 var job_action = $(this).data('action');
   $.ajax({
        type: "post",
        url: site_url+'myalerts/alertsjob',
        data:{job:profile_id,action:job_action},
        success:function(data){ 
      $("."+job_id).remove();
        }
           
        });
 
 
});
});
    </script>


<script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('#telentrefine').submit(function(event){
  
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/Profilerefine',
            data: $('#telentrefine').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){
              //alert(response);
               

               if(response=="<h3 align='center'>No Talent's Found</h3>"){ 
                $('#data').html(response)}else{
            $('#page_search_result').html(response)
        }
      
    
            },
       complete: function() {
            $('#clodder').css("display", "none");
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>
           
            </div>
            <div class="row"> <div class="col-sm-12"><a href="#" class="btn btn-default" data-toggle="modal" data-target="#saveprofilerefinetamplate"> Save Search Result </a></div> </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <?php  } else{ echo "<h3 align='center'>No Talent's Found</h3>";}   }?>

      <script type="text/javascript">
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.saveprofile').click(function(){
    console.log('test');
var profile=$(this).data('profile');
    
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/saveprofile',
            data: {p_id:profile},
       beforeSend: function() {
         

      },
      
            success:function(response){
                
                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                 

               $('#'+profile+'').css('color','green');
                 }else{
                   $('#'+profile+'').css('color','white');
                 }
           
    
            },
       complete: function() {
            
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });



</script>
<!-- Modal -->
<div class="modal fade" id="saveprofilerefinetamplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Template </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <div class="alert alert-success" id="saverefinejobs" style="display:none">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    <strong>Success!</strong> Your Template is saved Successfully 
</div>
        <?php pr($_SESSION['Profilerefinedata']); if($_SESSION['Profilerefinedata']) { ?>
        <form id="savesearchresulttem"  onsubmit="return profilesearchsave(this)" >
<div class="form-group">
    <label for="exampleInputEmail1">Enter Tamplate Name</label>
    <input type="text" class="form-control"  placeholder="Enter Tamplate Name" name="template" id="template">
      </div>
 <?php } else{ ?>
<div class="alert alert-secondary" role="alert">
 Nothing to Save 
</div>

       <?php } ?>
        
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary" <?php if($_SESSION['Profilerefinedata']) { ?> style="display:block" <?php }else { ?> style="display:none"   <?php } ?>>Save</button>
      </div>

       </form>

      
    </div>
  </div>
</div>


<script>
  function profilesearchsave(x){
    //alert(x.template.value);
     event.preventDefault();

var tem=x.template.value;

var w='1';

      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/saveprosearchresult',
            data: {template:tem,savewhere:w},
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){
              //alert(response);
               
 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                  $('#saverefinejobs').css("display","block");
                 }
    
    
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