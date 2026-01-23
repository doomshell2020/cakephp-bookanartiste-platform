  <div class="alert alert-warning alert-dismissible fade in" style="display:none" id="packfinish">
    
  Your Number Of Application Limit Exceed 
  </div>

<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>
<div id="page-wrapper">
  <?php   
     if($searchdata){
     

   ?>



<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

  <section id="page_search-job_result">
    <div class="container">
    <div class="row">   <div class="col-sm-12 text-right top-three-but"> <a href="#" class="btn btn-default m-right-20" data-toggle="modal" data-target="#applymultiplejob" style="visibility:hidden " id="aplybutton">Apply</a></div></div>
      <h2>Search <span>Job Result</span></h2>
      <p class="m-bott-50">Here You Can Search Job Result</p>
    </div>
    
    <div class="srch-box">
      <div class="container">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
            <label for="" class=" control-label">Talent Name:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="">
            </div>
            <div class="col-sm-2">
            <label for="" class=" control-label">Profile Title:</label>
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
    <div id=update>
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

                      <option value="<?php echo $eventtypevalue ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $eventtypevalue; ?> </option>

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
                      <input type="radio" name="time" id="inlineRadio2" value="Full Time" >
                      Continuous Employment </label>
                    
                  </div>
                </div>
                
                
              
                
                <input type="hidden" class="form-control" id="inputEmail3"  <?php if($data['title']) {?> value="<?php echo $data['title']; ?>" <?php }  ?> name="keyword">
                
                
                
                <div class="form-group">
                  <div class="col-sm-12"> 

                  <input type="submit" value="Refine Search" class="btn btn-default"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="panel panel-right">
              <div class="clearfix job-box">

              <?php $jobarray=array(); $isdata=0; foreach($searchdata as $value) { 
    
         

               $date=date('Y-m-d H:i:s');

                 if(!in_array($value['id'],$jobarray)){
                     $jobarray[]=$value['id']; 

                     if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                     
                     
                     if($date<$value['last_date_app']) {
                     
                    // pr($value);
                     
$isdata=1;
               ?>



        <div class="col-sm-12 box job-card">
        	 <input type="checkbox" name="vehicle" value="Bike" class="chkbox" data-val="<?php echo $value['id'] ?>">
        <div class="remove-top">  <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>  </div>
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
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-default">Apply</a>
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary">Send Quote</a>
              </div>
              
              <div class="col-sm-5 text-right">
                <div class="icon-bar"> 
                <a href="#" class="fa fa-thumbs-up"></a>
                 <a href="#" class="fa fa-share"></a> 
                   <a href="#" class="fa fa-paper-plane-o"></a>
                 
                 <a href="#" class="fa fa-floppy-o"></a>
                 <a href="#" class="fa fa-ban"></a> 
                 </div>
                
                
              </div>
            </div>
          </div>
        </div>
        
    
        <?php  } } }  }?>

 
        
  
        
      </div>

              
              
              
              
                            
           <div class="row">   <div class="col-sm-12 m-top-20">
<?php  if($isdata==1){ ?>
            <a href="#" class="btn btn-default m-right-20" data-toggle="modal" data-target="#savejobrefinetamplate">Save Search Result </a>

            <?php } ?>

            </div></div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <?php  } else{ ?> <div class="refine-search m-top-60">
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

                      <option value="<?php echo $eventtypevalue ?>" <?php if($i==0)  echo "selected"; ?> > <?php echo  $eventtypevalue; ?> </option>

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
                      <input type="radio" name="time" id="inlineRadio2" value="Full Time" >
                      Continuous Employment </label>
                    
                  </div>
                </div>
                
                
              
                
                <input type="hidden" class="form-control" id="inputEmail3"  <?php if($data['title']) {?> value="<?php echo $data['title']; ?>" <?php }  ?> name="keyword">
                
                
                
                <div class="form-group">
                  <div class="col-sm-12"> 

                  <input type="submit" value="Refine Search" class="btn btn-default"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="panel panel-right">
              <div class="clearfix job-box">

              <?php $jobarray=array(); foreach($searchdata as $value) { 
    
         

               $date=date('Y-m-d H:i:s');

                 if(!in_array($value['id'],$jobarray)){
                     $jobarray[]=$value['id']; 

                     if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                     
                     
                     if($date<$value['last_date_app']) {
                     
                     
                     

               ?>



        <div class="col-sm-12 box job-card">
        	 <input type="checkbox" name="vehicle" value="Bike" class="chkbox" data-val="<?php echo $value['id'] ?>">
        <div class="remove-top">  <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="search" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>  </div>
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
            <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['event_type'] ?></li>
            </ul>
            <div class="row">
              <div class="col-sm-7">
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-default">Apply</a>
              <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['id'] ?>" class="btn btn-primary">Send Quote</a>
              </div>
              
              <div class="col-sm-5 text-right">
                <div class="icon-bar"> 
                <a href="#" class="fa fa-thumbs-up"></a>
                 <a href="#" class="fa fa-share"></a> 
                   <a href="#" class="fa fa-paper-plane-o"></a>
                 
                 <a href="#" class="fa fa-floppy-o"></a>
                 <a href="#" class="fa fa-ban"></a> 
                 </div>
                
                
              </div>
            </div>
          </div>
        </div>
        
    
        <?php  } } }  }?>

 
        
  
        
      </div>

              
              
              
              
                            
           <div class="row">   <div class="col-sm-12 m-top-20"> <h3 algin="center" style="margin-left:220;margin-top:220"> No Job Found</h3> </div></div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div> <?php  } ?>
    </div>
  </section>
  
  <!-------------------------------------------------->
  
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
            url: SITE_URL + 'search/advance_refine',
            data: $('#refinesearch').serialize(),
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){
              // alert(response);
            $('#update').html(response)
      
    
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
<script>
$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 1,
      max: <?php echo $max; ?>,
      values: [ 0, <?php echo $max; ?> ],
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
$(document).ready(function(){
   var a=0;
  var site_url='<?php echo SITE_URL;?>/';
  $('.chkbox').click(function() { 
   
 var job_id = $(this).data('val');

// $("#"+job_id).remove();



 if ($(this).is(':checked')) {
  var status="chek";

   $.ajax({
        type: "post",
        url: site_url+'search/applymultiple',
        data:{jobsearch:job_id,a:a,status:status},
        success:function(data){ 
        

          if(data=="show"){
            
            $('#packfinish').css("display","block");

   // $('#aplybutton').css("visibility","hidden");
  // $("#aplybutton").attr("data-toggle","");


          }else{
     $("#multiplejob").append(data);
     $('#packfinish').css("display","none");
   }
        }
           
        });
  a++;
  if(a>=1){
    

    $('#aplybutton').css("visibility","visible");
    //$("#aplybutton").attr("data-toggle","modal");

  }

 }else{
a--;
  


if(a<1){
   

    $('#aplybutton').css("visibility","hidden");
  }

  $("#job-"+job_id).remove();
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

      <form id="multiplejob" action="<?php echo SITE_URL ?>/jobpost/aplymultiple" method="POST">
        


     
      </form>
      </div>
      
              
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" form="multiplejob">Apply</button>
      </div>
    </div>

  </div>
</div>
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
    <strong>Warning!</strong> There was a problem with your network connection.
</div>
        <?php if($_SESSION['Refinejobfilter']) { ?>
        <form id="savesearchresulttem"  onsubmit="return testinf(this)" >
<div class="form-group">
    <label for="exampleInputEmail1">Enter Tamplate Name</label>
    <input type="text" class="form-control"  placeholder="Enter Tamplate Name" name="template" id="template">
      </div>
 <?php } else{ ?>
<div class="alert alert-secondary" role="alert">
 Nothing to Save 
</div>

       <?php } ?>
          <button type="submit" class="btn btn-primary" <?php if($_SESSION['Refinejobfilter']) { ?> style="display:block" <?php }else { ?> style="display:none"   <?php } ?>>Save changes</button>
      </div>
  
       </form>

      
    </div>
  </div>
</div>

<script>
  function testinf(x){
    
         event.preventDefault();

var tem=x.template.value;

var w='2';

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