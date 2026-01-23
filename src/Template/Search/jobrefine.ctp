
<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>

<div id="page-wrapper">

  <?php if($searchdata){ ?>



<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

  <section id="page_search-job_result">

  <?php 
  if($month!=0 && $daily!=0 && $quote!=0){ ?>
    <div id="aplybutton" style="display:none;">
  <div class="container">   
      <div class="pull-left top-three-but"> 
   
        <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
    </div>


     <div class="pull-right top-three-but"> 
   
        <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send">Send Quote</button>
          

    </div>
    </div>
    </div>

    <?php } ?>

<?php if($month==0 && $daily==0 && $quote==0){  ?>
    <div id="aplybutton" style="display:none;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
    <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
    </div>



    </div>
    </div>
<?php } ?>



<?php if($month!=0 && $daily==0 && $quote==0){  ?>
    <div id="aplybutton" style="display:none;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
    <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
    </div>



    </div>
    </div>
<?php } ?>


    
<?php if($month==0 && $daily!=0 && $quote==0){ ?>
    <div id="aplybutton" style="display:none;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
        <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
    </div>


  <div class="pull-right top-three-but"> 
   
       <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send" >Send Quote</button>
          
      
      
    </div>
    
    </div>
    </div>

    <?php } ?>

    <?php if($month!=0 && $daily==0 && $quote!=0){ ?>
    <div id="aplybutton" style="display:none;">
    <div class="container">   
    <div class="pull-left top-three-but"> 
   
    <button type="button" value="1" class="btn btn-default m-right-20 actbut" data-toggle="modal" data-target="#pingjobmodal">Ping Job</button>
    </div>


  <div class="pull-right top-three-but"> 
   
       <button type="submit" form="multiple" value="2" class="btn btn-primary m-right-20 actbut send" >Send Quote</button>
          
      
      
    </div>
    
    </div>
    </div>

    <?php } ?>

    <?php if($month!=0 && $daily!=0 && $quote==0){ ?>
    <div id="aplybutton" style="display:none;">
    <div class="container">   
   <div class="pull-left top-three-but"> 
   
        <button type="submit" form="multiple" value="1" class="btn btn-default m-right-20 actbut">Apply</button>
    </div>


    
    </div>
    </div>

    <?php } ?>


      <h2>Search <span>Job Result</span></h2>
      <p class="m-bott-50">Here You Can Search Job Result</p>


    <div class="alert alert-warning alert-dismissible fade in" style="display:none" id="packfinish">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <h4 id="warmsg"></h4>
  </div>

     <div class="alert alert-warning alert-dismissible fade in" style="display:none" id="application">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <h4 id="appmsz"></h4>
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

                    
                    if($appliedjob['nontalent_aacepted_status']=="N" && $appliedjob['talent_accepted_status']=="Y"){
                      
if($appliedjob->ping==1){
                      echo '<h5>You have Pinged  on ';echo date('d F Y',strtotime($appliedjob['created'])).'</h5>';
                  }else{
                      echo '<h5>You have Applied  on ';echo date('d F Y',strtotime($appliedjob['created'])).'</h5>';
                  }
                   }else if($appliedjob['nontalent_aacepted_status']=="Y" && $appliedjob['talent_accepted_status']=="N"){ ?> <h5 id="" style="display: block">You have Recived booking request   on <?php echo date("d F Y",strtotime($appliedjob["created"]));?></h5> <?php  }elseif($appliedjob['nontalent_aacepted_status']=="Y" && $appliedjob['talent_accepted_status']=="Y"){echo '<h5>You are Selected  on ';echo date('d F Y',strtotime($jobdataeapryxits['created'])).'</h5>';}else{  ?>  

 <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-default" id="apply<?php echo $value['id'] ?>" target="_blank">Apply</a>
<h5 id="aplymsz<?php echo $value['id'] ?>" style="display: none">You have Applied  on <?php echo date('d F Y');?></h5>
    <?php }  ?>


    <?php if($sentquote['revision']==0 && $sentquote['status']=="N" && $sentquote['nontalent_satus']=="Y" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>
             
         <h5 id="sendquotemsz<?php echo $value['id'] ?>" style="display: block">You have Sent Quote  on <?php echo date('d F Y',strtotime($sentquote['created']));?></h5>


<?php } else if($sentquote['revision']!=0 && $sentquote['status']=="N" && $appliedjob['nontalent_aacepted_status']!="N" && $appliedjob['talent_accepted_status']!="Y"){ ?>
 <h5 id="sendquotemsz<?php echo $value['id'] ?>" style="display: block">You received revised quote   on <?php echo date('d F Y',strtotime($sentquote['created']));?></h5>

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
                 <a href="javascript:void(0)" class="fa fa-thumbs-up likejobs" data-job="<?php echo $value['id'] ?>" id="like<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$likejobarray)) { ?> style="color:red" <?php  } ?> alt="Likes Jobs"></a>
                 <a href="#" class="fa fa-share"></a> 
                   <a href="#" class="fa fa-paper-plane-o"></a>
               
                 <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$savejobarray)) { ?> style="color:red" <?php  } ?> alt="Save Jobs"></a>
               

                  <a href="javascript:void(0)" class="fa fa-ban block" data-job="<?php echo $value['id'] ?>" id="block<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$blockjobarray)) { ?> style="color:red" <?php  } ?> alt="Block Jobs"></a>
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
               
                 <a href="javascript:void(0)" class="fa fa-floppy-o savejobs" data-job="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" <?php if(in_array($value['id'],$savejobarray)) { ?> style="color:red" <?php  } ?>></a>
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

    
    var urllog=$('#refinesearch').serialize();
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/jobrefine',
            data: $('#refinesearch').serialize(),
       beforeSend: function() {
   
     
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
      var curl = window.location.href;
      var win = window.open(curl+"&"+urllog,"_self");

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
                   location.reload();
q=0;
                 // var obj = jQuery.parseJSON(response);

   //console.log('#apply'+myObj.job_id);

   $.each(myObj.jobarray, function(key,value) {
  //alert(value);

   $('#apply'+value).remove();
   $('#aplymsz'+value).css('display','block');
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
                  $("#limitalert").css('display','none');
                 }else if(myObj.success==3){
             
                    $("#applymultiplequote").modal('show');
                    $('#sendquotelimitalert').css("display","none");
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
     var checkclick=0;
$(document).ready(function(){
   var site_url='<?php echo SITE_URL;?>/';
  $('.chkbox').click(function() { 
    

     var job_id = $(this).data('val');
      if ($(this).is(':checked')) {

        ++checkclick;
                 mypingfunction(job_id,checkclick);
     console.log(checkclick);
        var status="chek";
         $(this).parent('div').removeClass('check_hide');
             $.ajax({
        type: 'POST',
        url: site_url + 'search/applymultiple',
        data:{jobsearch:job_id,dyid:checkclick,status:status},
      
        beforeSend: function() {
           

        },
        success: function(data) { 
           $("#multiplejob").append(data);
           
            //$('#update').html(data);
           
        },
        complete: function() {
           $('#aplybutton').css("display","block");


        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
    });

      }else{
         $(this).parent('div').addClass('check_hide');
         checkclick--;
           $("#job-"+job_id).remove();
           $("#myping"+job_id).remove();
           if(checkclick==0){
             $('#aplybutton').css("display","none");
           }
           


      }


  });



});
  </script>



   <script>
     var quote=0;

$(document).ready(function(){

   var pop=0;
  var site_url='<?php echo SITE_URL;?>/';
  $('.sendquoute').click(function() { 


 var job_id = $(this).data('val');

if ($(this).is(':checked')) {
  

  var status="chek";

console.log(quote);

   $.ajax({
        type: "post",
        url: site_url+'search/sendquotemultiple',
        data:{jobsearch:job_id,a:quote,status:status},
        success:function(data){ 
        
$("#multiplequote").append(data);


        }
           

        });
    quote++;
   console.log("here");
  

     
     pop++;

     //alert(pop);

  if(pop>=1){
    

    //$('#aplybutton').css("visibility","visible");
    //$("#aplybutton").attr("data-toggle","modal");

  }

 }else{

pop--;

  //jQuery(this).parent('li').addClass('yourClass');
  $(this).parent('div').removeClass('Active');

if(pop<1){
   

    
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
                 

               $('#'+job+'').css('color','red');
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
                 

               $('#'+job+'').css('color','red');
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


  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.likejobs').click(function(){
  
var job=$(this).data('job');
    
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/likejobs',
            data: {jobid:job},
       beforeSend: function() {
         

      },
      
            success:function(response){
                
                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                 

               $('#like'+job+'').css('color','red');
                 }else{
                   $('#like'+job+'').css('color','white');
                 }
           
    
            },
       complete: function() {
            
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });
    
     });

    var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.block').click(function(){
  
var job=$(this).data('job');
    
    event.preventDefault();
      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: SITE_URL + 'search/blockjobs',
            data: {jobid:job},
       beforeSend: function() {
         

      },
      
            success:function(response){
                
                 var myObj = JSON.parse(response);
                 
                 if(myObj.success==1){
                 

               $('#block'+job+'').css('color','red');
                 }else{
                   $('#block'+job+'').css('color','white');
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
<div id="applymultiplejob" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Apply Job</h4>
      </div>

      <div class="modal-body" >
<div class="alert alert-warning alert-dismissible" id="limitalert" style="display: none">

  <strong id="limittext"></strong> 
</div>
      <form id="multiplejob"  method="POST" onsubmit="return chekvalidate(this)">
        


     
      </form>
      </div>
      
              
      <div class="modal-footer" style="border-top: none">
        <button type="submit" class="btn btn-default" form="multiplejob">Apply</button>
      </div>
    </div>
<script type="text/javascript">
  function chekvalidate(x){

    if(x.telentskill.value==''){
      return false;
    }
    return false;
  }
</script>
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


<div class="alert alert-warning alert-dismissible" id="sendquotelimitalert" style="display: none">

  <strong id="sendlimittext"></strong> 
</div>

      <form id="multiplequote"  method="POST">
        


     
      </form>
      </div>
      
              
      <div class="modal-footer" style=" border-top:none; ">
        <button type="submit" class="btn btn-default" form="multiplequote">Send Quote</button>
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
      <?php echo $this->Form->input('amount',array('class'=>'form-control','placeholder'=>'Amount','required'=>true,'label' =>false,'id'=>'pingamount','readonly')); ?>
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
         $('#updateping').empty();
         $('#multiplequote').empty();
         $('#pingbutton').css("visibility","hidden");
         $('#quote').css("visibility","hidden");

var count=0;
   $.each(myObj.jobarray, function(key,value) {
 

   //$('#apply'+value).text('Applied');
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
            
//window.location = SITE_URL+"showjob/applied";

$('#pingjobmodal').modal('toggle');
 window.scrollTo(0, 50);
 $('#pingbutton').css("visibility","hidden");
                 }else{
                  $("#applymultiplejob").modal('show');
                 }

 $('#pingamount').val('');
    
            },
       complete: function() {
        
      // alert(a);
    //  a=0;
    location.reload();


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

                 if(myObj.daily==1){
                    $('#sendquotelimitalert').css('display','block');
                    $('#sendlimittext').text(myObj.message);
                 }
                 
                 if(myObj.success==2){

quote=0;
                 
                 $('#updateping').empty();
                 $("#pingamount").val('');
                
                 

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


$('#applymultiplequote').modal('toggle');
 window.scrollTo(0, 50);
 location.reload();
 $('#aplybutton').css("visibility","hidden");
 
                 }else{
                  $("#applymultiplequote").modal('show');
                 // $('#sendquotelimitalert').css("display","none");
                 }
              
    $('#quote').css("visibility","hidden");
    
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
           

      },
      
            success:function(response){
quote=0;
                 var myObj = JSON.parse(response);

             
                 if(myObj.daily==1){
                  $('#limitalert').css('display','block');
                  $('#limittext').text(myObj.message);

                 }
                 
                else if(myObj.success==2){

                 // var obj = jQuery.parseJSON(response);

$('#multiplequote').empty();

   //console.log('#apply'+myObj.job_id);
var count=0;
   $.each(myObj.jobarray, function(key,value) {
  //alert(value);

  // $('#apply'+value).text('Applied');
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
   location.reload();

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

