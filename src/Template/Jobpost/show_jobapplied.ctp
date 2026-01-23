<style>
  #page_alert .member-detail .btn-primary{margin-top: 0;}
  .member-detail .btn-default {margin-top: 0; }
</style>
<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>

<section id="page_alert">
  <div class="container">
   <div class="job_search_heading">
    
    <h2> Applied <span>Job Result</span></h2>
  </div>
</div>

<div class="refine-search">
  <div class="container">
    <div class="row m-top-20 profile-bg">
      <div class="col-sm-3">
        <div class="panel panel-left">
          <ul class=" alrt-categry list-unstyled navff" >

            <?php  $allalerts =count($sendquotedata)+count($pingdata)+count($sendreviseddata)+ count($jobdata)+ count($paidquotedata); ?>
            <li class="active">
            <a href="#" class="jobalerts" data-action="alerts">All<span class="noti_f"><?php echo $allalerts; ?></span>
              </a>
            </li>

            <li>
              <a href="javascript:void(0);" class="jobalerts" data-action="jobalertss">Applied<span class="noti_f"><?php echo count($jobdata); ?></span>
              </a>
            </li>

            <li>
              <a href="javascript:void(0);" class="jobalerts" data-action="ping">Ping<span class="noti_f"><?php echo count($pingdata); ?></span>
              </a>
            </li>

            <li>
              <a href="javascript:void(0);" class="jobalerts" data-action="sentquote">Sent Quote<span class="noti_f"><?php echo count($sendquotedata); ?></span></a>
            </li>

            <li>
              <a href="javascript:void(0);" class="jobalerts" data-action="revisedquote">Sent Revised Quote<span class="noti_f"><?php echo count($sendreviseddata); ?></span>
              </a>
            </li>

            <li>
              <a href="javascript:void(0);" class="jobalerts" data-action="paidquote">Sent Paid Quote<span class="noti_f"><?php echo count($paidquotedata); ?></span>
              </a>
            </li>
          </ul>

        </div>
        <!-- <img src="<?php echo SITE_URL; ?>/images/CB_Card.png"> -->
      </div>


      <div class="col-sm-9">
        <?php if(count($sendquotedata) > 0 || count($pingdata)> 0 || count($sendreviseddata) > 0 || count($jobdata) > 0 || count($paidquotedata) > 0){ ?>
        
        <?php  }else{?>
        <?php echo "No Alerts for you at the moment"; ?>

        <?php } ?>
        <div class="panel-right">
          <form>


            <?php //------------Start applied jobs-----------// ?>
<?php if(count($jobdata) > 0){ ?>
            <div id="<?php echo $jobalertsss['id']; ?>" class="box member-detail  alerts jobalertss <?php if($applicationrec['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
              <div class="row">
                <div class="profile-bg job_rslt_bg">
                  <div class="clearfix">
                    <div class="col-sm-12">
                     <div class="clearfix job-box">
                      <?php $jobarray=array();  foreach($jobdata as $value) { //pr($value); die;

                       if(!in_array($value['id'],$jobarray )){
                         $jobarray[]=$value['id']; 
                         if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                           ?>
                           <div class="col-sm-12  box job-card">
                            <div class="remove-top"> 
                            </div>
                            <div class="col-sm-2">
                              <div class="profile-det-img1">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['requirement']['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <!--<div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>-->

                              </div></div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id'] ?>"><?php echo $value['requirement']['title'] ?></a>


                                    <span><?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></span></h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="#" class="fa fa-user"></a>
                                      Job Posted By <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['requirement']['user']['id'] ?>"><?php echo $value['requirement']['user']['user_name'] ?></a></li>
                                      <li><a href="#" class="fa fa-braille"></a>

                                        <?php 

                                        $skill=$this->Comman->requimentskill($value['job_id']);


                                        ?>
                                        <?php
                                        $max=0;
                                        foreach($skill as $vacancy){ 
                                          $skillarray=array();
                                          if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

                                          echo $vacancy['skill']['name'];


                                        } ?>


                                      </li>

                                      <?php if($value['requirement']['eventtype']['name']){ ?>
                                      <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['requirement']['eventtype']['name'] ?></li>
                                      <?php } ?>
                           
                                      <?php if(date('Y-m-d',strtotime($value['requirement']['event_from_date']))!='1970-01-01'){?>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_from_date']));  ?>
                                      </li>
                                      <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_to_date']));  ?>
                                      </li>
                                      <?php } ?>
                                      
                                      
                                       <li><a href="#" class="fa fa-braille"></a>

                                     <?php 
                                        $dataskill=$this->Comman->getSkillname($value['skill_id']);  
                                       //pr($dataskill); 
                                       echo 'You Have Applied For '.$dataskill->name.' Skill on ';echo date('d F Y',strtotime($value['created']));
                                        ?>
                                    </li>
                                    
                                      
                                    </ul>
                                    <?php /* ?>
                                    <div class="row">
                                      <div class="col-sm-7">
                                       <h5>You have <?php echo $status ?> On <?php echo  date('d M Y',strtotime($value['requirement']['job_application']['0']['created'])); ?>   </h5>

                                     </div>

                                     <div class="col-sm-5 text-right">

                                     </div>
                                   </div>
                                   <?php */ ?>
                                   
                                 </div> 
                               </div>
                             </div>
                             <?php    } } }  ?>
                           </div>
                           <!--<div class="row">   <div class="col-sm-12 m-top-20">  </div></div>-->
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>

<?php } ?>


                 <?php //------------------ Revised Quote Received-------------// ?> 
<?php if(count($pingdata) > 0){ ?>
                 <div id="<?php echo $sendquote['id']; ?>" class="box member-detail  alerts ping <?php if($sendquote['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
                     
    <div class="row">
                <div class="profile-bg job_rslt_bg">
                  <div class="clearfix">
                    <div class="col-sm-12">
                     <div class="clearfix job-box">
                      <?php $jobarray=array();  foreach($pingdata as $value) { 

                       if(!in_array($value['id'],$jobarray )){
                         $jobarray[]=$value['id']; 
                         if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                           ?>
                           <div class="col-sm-12  box job-card">
                            <div class="remove-top"> 
                            </div>
                            <div class="col-sm-2">
                              <div class="profile-det-img1">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['requirement']['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <!--<div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>-->

                              </div></div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id'] ?>"><?php echo $value['requirement']['title'] ?></a>


                                    <span><?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></span></h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="#" class="fa fa-user"></a>
                                      Job Posted By <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['requirement']['user']['id'] ?>"><?php echo $value['requirement']['user']['user_name'] ?></a></li>
                                      <li><a href="#" class="fa fa-braille"></a>

                                        <?php 

                                        $skill=$this->Comman->requimentskill($value['job_id']);


                                        ?>
                                        <?php
                                        $max=0;
                                        foreach($skill as $vacancy){ 
                                          $skillarray=array();
                                          if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

                                          echo $vacancy['skill']['name'];


                                        } ?>


                                      </li>

                                      <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['requirement']['eventtype']['name'] ?></li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_from_date']));  ?>
                                      </li>
                                      <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_to_date']));  ?>
                                      </li>
                                      
                                      
                                       <li><a href="#" class="fa fa-braille"></a>

                                     <?php 
                                        $dataskill=$this->Comman->getSkillname($value['skill_id']);  
                                       //pr($dataskill); 
                                       echo 'You have Pinged  on'.$dataskill->name.' Skill on ';echo date('d F Y',strtotime($value['created']));
                                        ?>
                                    </li>
                                    
                                      
                                    </ul>
                                    <?php /* ?>
                                    <div class="row">
                                      <div class="col-sm-7">
                                       <h5>You have <?php echo $status ?> On <?php echo  date('d M Y',strtotime($value['requirement']['job_application']['0']['created'])); ?>   </h5>

                                     </div>

                                     <div class="col-sm-5 text-right">

                                     </div>
                                   </div>
                                   <?php */ ?>
                                   
                                 </div> 
                               </div>
                             </div>
                             <?php    } } }  ?>
                           </div>
                           <!--<div class="row">   <div class="col-sm-12 m-top-20">  </div></div>-->
                         </div>
                       </div>
                     </div>
                   </div>
                   
                 </div>
              

<?php } ?>

  
                 
                 
                 <?php  if($sendquotedata) { ?>
                 <div id="<?php echo $sendquote['id']; ?>" class="box member-detail  alerts sentquote <?php if($sendquote['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
 <div class="row">
                <div class="profile-bg job_rslt_bg">
                  <div class="clearfix">
                    <div class="col-sm-12">
                     <div class="clearfix job-box">
                      <?php $jobarray=array();  foreach($sendquotedata as $value) {  //pr($value);

                       if(!in_array($value['id'],$jobarray )){
                         $jobarray[]=$value['id']; 
                         if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                           ?>
                           <div class="col-sm-12  box job-card">
                            <div class="remove-top"> 
                            </div>
                            <div class="col-sm-2">
                              <div class="profile-det-img1">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['requirement']['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <!--<div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>-->

                              </div></div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id'] ?>"><?php echo $value['requirement']['title'] ?></a>


                                    <span><?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></span></h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="#" class="fa fa-user"></a> Job Posted By <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['requirement']['user']['id'] ?>"><?php echo $value['requirement']['user']['user_name'] ?></a></li>
                                      <li><a href="#" class="fa fa-braille"></a>

                                        <?php 

                                        $skill=$this->Comman->requimentskill($value['job_id']);


                                        ?>
                                        <?php
                                        $max=0;
                                        foreach($skill as $vacancy){ 
                                          $skillarray=array();
                                          if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

                                          echo $vacancy['skill']['name'];


                                        } ?>


                                      </li>
<?php if ($value['requirement']['continuejob'] == 'Y'){ ?>
                                      <li><a href="#" class="fa fa-suitcase"></a> Continue Job :  <?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></li>
                                    
                                      <?php }else{ ?>
                                        <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['requirement']['eventtype']['name'] ?></li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_from_date']));  ?>
                                      </li>
                                      
                                        <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_to_date']));  ?>
                                      </li>
                                      <?php } ?>
                                    
                                         <li><a href="#" class="fa fa-braille"></a>

                                     <?php 
                                        $dataskill=$this->Comman->getSkillname($value['skill_id']);  
                                       //pr($dataskill); 
                                       echo 'You Have Sent Quotes For '.$dataskill->name.' Skill on ';echo date('d F Y',strtotime($value['created']));
                                        ?>
                                    </li>
                                    
                                    
                                    
                                    </ul>
                                    <?php /* ?>
                                    <div class="row">
                                      <div class="col-sm-7">
                                       <h5>You have <?php echo $status ?> On <?php echo  date('d M Y',strtotime($value['requirement']['job_application']['0']['created'])); ?>   </h5>

                                     </div>

                                     <div class="col-sm-5 text-right">

                                     </div>
                                   </div>
                                   <?php */ ?>
                                   
                                 </div> 
                               </div>
                             </div>
                             <?php    } } }  ?>
                           </div>
                           <!--<div class="row">   <div class="col-sm-12 m-top-20">  </div></div>-->
                         </div>
                       </div>
                     </div>
                   </div>
                   
                 </div>
              
              <?php } ?>
                 
                 
                <?php if($sendreviseddata){ ?>
                 <div id="<?php echo $sendquote['id']; ?>" class="box member-detail  alerts revisedquote <?php if($sendquote['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">
<div class="row">
                <div class="profile-bg job_rslt_bg">
                  <div class="clearfix">
                    <div class="col-sm-12">
                     <div class="clearfix job-box">
                      <?php $jobarray=array();  foreach($sendreviseddata as $value) {  //pr($value);

                       if(!in_array($value['id'],$jobarray )){
                         $jobarray[]=$value['id']; 
                         if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                           ?>
                           <div class="col-sm-12  box job-card">
                            <div class="remove-top"> 
                            </div>
                            <div class="col-sm-2">
                              <div class="profile-det-img1">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['requirement']['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <!--<div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>-->

                              </div></div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id'] ?>"><?php echo $value['requirement']['title'] ?></a>


                                    <span><?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></span></h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="#" class="fa fa-user"></a> Job Posted By <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['requirement']['user']['id'] ?>"><?php echo $value['requirement']['user']['user_name'] ?></a></li>
                                      <li><a href="#" class="fa fa-braille"></a>

                                        <?php 

                                        $skill=$this->Comman->requimentskill($value['job_id']);


                                        ?>
                                        <?php
                                        $max=0;
                                        foreach($skill as $vacancy){ 
                                          $skillarray=array();
                                          if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

                                          echo $vacancy['skill']['name'];


                                        } ?>


                                      </li>
<?php if ($value['requirement']['continuejob'] == 'Y'){ ?>
                                      <li><a href="#" class="fa fa-suitcase"></a> Continue Job :  <?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></li>
                                    
                                      <?php }else{ ?>
                                        <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['requirement']['eventtype']['name'] ?></li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_from_date']));  ?>
                                      </li>
                                      
                                        <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_to_date']));  ?>
                                      </li>
                                      <?php } ?>
                                    
                                         <li><a href="#" class="fa fa-braille"></a>

                                     <?php 
                                        $dataskill=$this->Comman->getSkillname($value['skill_id']);  
                                       //pr($dataskill); 
                                       echo 'You Have Sent Revised Quote For '.$dataskill->name.' Skill on ';echo date('d F Y',strtotime($value['created']));
                                        ?>
                                    </li>
                                    
                                    
                                    
                                    </ul>
                                    <?php /* ?>
                                    <div class="row">
                                      <div class="col-sm-7">
                                       <h5>You have <?php echo $status ?> On <?php echo  date('d M Y',strtotime($value['requirement']['job_application']['0']['created'])); ?>   </h5>

                                     </div>

                                     <div class="col-sm-5 text-right">

                                     </div>
                                   </div>
                                   <?php */ ?>
                                   
                                 </div> 
                               </div>
                             </div>
                             <?php    } } }  ?>
                           </div>
                           <!--<div class="row">   <div class="col-sm-12 m-top-20">  </div></div>-->
                         </div>
                       </div>
                     </div>
                   </div>
                   
                 </div>
              
              
               <?php } ?>
                 
                 <?php if($paidquotedata){ ?>
                  
                 <div id="<?php echo $sendquote['id']; ?>" class="box member-detail  alerts paidquote <?php if($sendquote['viewedstatus']=='Y'){?>jobviewed<?php }else {?>jobnotviewed <?php } ?>">




<div class="row">
                <div class="profile-bg job_rslt_bg">
                  <div class="clearfix">
                    <div class="col-sm-12">
                     <div class="clearfix job-box">
                      <?php $jobarray=array();  foreach($paidquotedata as $value) {  //pr($value);

                       if(!in_array($value['id'],$jobarray )){
                         $jobarray[]=$value['id']; 
                         if(!in_array($value['id'],$_SESSION['jobsearchdata'])) {
                           ?>
                           <div class="col-sm-12  box job-card">
                            <div class="remove-top"> 
                            </div>
                            <div class="col-sm-2">
                              <div class="profile-det-img1">
                                <img src="<?php echo SITE_URL; ?>/job/<?php echo $value['requirement']['image'] ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/job.jpg';">
                                <!--<div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>-->

                              </div></div>
                              <div class="col-sm-10">
                                <div class="box_dtl_text">
                                  <h3 class="heading">
                                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $value['job_id'] ?>"><?php echo $value['requirement']['title'] ?></a>


                                    <span><?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></span></h3>
                                    <p><?php echo $value['location'] ?></p>
                                    <ul class="list-unstyled job-r-skill">
                                      <li><a href="#" class="fa fa-user"></a> Job Posted By <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['requirement']['user']['id'] ?>"><?php echo $value['requirement']['user']['user_name'] ?></a></li>
                                      <li><a href="#" class="fa fa-braille"></a>

                                        <?php 

                                        $skill=$this->Comman->requimentskill($value['job_id']);


                                        ?>
                                        <?php
                                        $max=0;
                                        foreach($skill as $vacancy){ 
                                          $skillarray=array();
                                          if($max<$vacancy['payment_amount']){$max=$vacancy['payment_amount'];}

                                          echo $vacancy['skill']['name'];


                                        } ?>


                                      </li>
<?php if ($value['requirement']['continuejob'] == 'Y'){ ?>
                                      <li><a href="#" class="fa fa-suitcase"></a> Continue Job :  <?php echo date('d M Y',strtotime($value['requirement']['last_date_app']));  ?></li>
                                    
                                      <?php }else{ ?>
                                        <li><a href="#" class="fa fa-suitcase"></a><?php echo $value['requirement']['eventtype']['name'] ?></li>
                                      <li><a href="#" class=" fa fa-calendar"></a> To
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_from_date']));  ?>
                                      </li>
                                      
                                        <li><a href="#" class=" fa fa-calendar"></a> From
                                        <?php echo date('d M Y',strtotime($value['requirement']['event_to_date']));  ?>
                                      </li>
                                      <?php } ?>
                                    
                                         <li><a href="#" class="fa fa-braille"></a>

                                     <?php 
                                        $dataskill=$this->Comman->getSkillname($value['skill_id']);  
                                       //pr($dataskill); 
                                       echo 'You Have paid quote For '.$dataskill->name.' Skill on ';echo date('d F Y',strtotime($value['created']));
                                        ?>
                                    </li>
                                    
                                    
                                    
                                    </ul>
                                    <?php /* ?>
                                    <div class="row">
                                      <div class="col-sm-7">
                                       <h5>You have <?php echo $status ?> On <?php echo  date('d M Y',strtotime($value['requirement']['job_application']['0']['created'])); ?>   </h5>

                                     </div>

                                     <div class="col-sm-5 text-right">

                                     </div>
                                   </div>
                                   <?php */ ?>
                                   
                                 </div> 
                               </div>
                             </div>
                             <?php    } } }  ?>
                           </div>
                           <!--<div class="row">   <div class="col-sm-12 m-top-20">  </div></div>-->
                         </div>
                       </div>
                     </div>
                   </div>


                 </div>
                
<?php  } ?>



                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

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
  data:{job:job_id,action:job_action},
  success:function(data){ 
    $("."+job_id).remove();
  }

});


});
        });
      </script>


      <script>
        $(document).ready(function(){
          $(".jobalerts").click(function(){
            var val = $(this).data('action');
            $(".alerts").hide();
            $("."+val).show();
          });

          var selector = '.navff li';

          $(selector).on('click', function(){
            $(selector).removeClass('active');
            $(this).addClass('active');
          });

        });
      </script>

