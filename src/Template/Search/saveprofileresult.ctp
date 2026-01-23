
<?php

 if($searchdata) {

      $agearray=array();
      $performancelan=array();
      $languageknownarray=array();
      $paymentfaqarray=array();
      $paymentfaqarray=array();
      $userskillarray=array();
      $querytionarray=array();
      foreach ($searchdata as $key => $value) {


           $birthdate = date("Y-m-d",strtotime($value['dateofbirth']));
          
          $from = new DateTime($birthdate);
          $to   = new DateTime('today');
          $age=$from->diff($to)->y;
          if(!in_array($age, $agearray))
          $agearray[]=$age;

           $performlanguage=$this->Comman->performainglanguage($value['user_id']);
   

            foreach($performlanguage as $perlanguage){
              $performancelan[$perlanguage['language']['id']]=$perlanguage['language']['name'];
            }

             $languageknown=$this->Comman->languageknown($value['user_id']);
           

            foreach($languageknown as $language){
              $languageknownarray[$language['language']['id']]=$language['language']['name'];
            }

                 $paymentfaq=$this->Comman->paymentfaq($value['user_id']);

             foreach($paymentfaq as $paymentfaq){
              $paymentfaqarray[$paymentfaq['paymentfequency']['id']]=$paymentfaq['paymentfequency']['name'];

            }
               
          //  pr($paymentfaq); 
              $userskill=$this->Comman->userskills($value['user_id']);

             foreach($userskill as $userskill){
              $userskillarray[$userskill['skill']['id']]=$userskill['skill']['name'];

            }
            if($value['title']){
$Enthicity[$value['ethnicity']]=$value['title'];
}





          }
      


$agearray=array();
      foreach ($searchdata as $key => $value) {
 // pr($value);

       $birthdate = date("Y-m-d",strtotime($value['dateofbirth']));
      
      $from = new DateTime($birthdate);
      $to   = new DateTime('today');
      $age=$from->diff($to)->y;
      //pr($age);
      if(!in_array($age, $agearray))
      $agearray[]=$age;

      }
    // pr($agearray);
      if(!empty($this->request->query['age']) && $this->request->query['age']!='0' ){

           $age=explode("-",$this->request->query['age']);

    $min=$age['0'];
    $max=$age['1'];
        $minimumage=$min;
        $maxage=$max+1;
      }else{
       
  
         $minimumage=min($agearray);
      $maxage=max($agearray)+1;
      }
?>
<section id="page_search_result">
      <div id="askaplybutton" style="visibility:hidden;">
  <div class="container">   
      <div class="pull-left top-three-but"> 
    <button type="button" class="btn btn-default m-right-20" data-toggle="modal" data-target="#multiplebooknow">Book Now</button>
    </div>


     <div class="pull-right top-three-but"> 
     
 <button type="button" class="btn btn-primary m-right-20" data-toggle="modal" data-target="#multipleaskquote">Ask For Quote</button>
 
      
    </div>
    </div>
    </div>

    <div class="container">
      <h2>Search <span>Result</span></h2>
      <p class="m-bott-50">Here You Can See Search Result</p>
    </div>
    <?php echo $this->Flash->render(); ?>
    <span class="quotepurchasemessage"> </span>
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
          <div class="col-sm-4">
            <div class="panel panel-left">
              <h6>Refine Profile Search</h6>
              <form class="form-horizontal" method="get" action="<?php echo SITE_URL ?>/search/profilesearch">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" placeholder="Name" value="<?php echo $title; ?>" name="name" >
                  </div>
                </div>
                        <div class="form-group salry">
                  <label for="inputEmail3" class="col-sm-12 control-label">Age </label>
    <p class="prc_sldr">
                   <label for="amount">Age</label>
                   <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="age">
                  </p>
<div id="slider-range"></div>

                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Gender<?php  echo $gen; ?></label>
                  <div class="col-sm-12">
                    <select class="form-control" name="gender">
                      <option value="0" <?php ($gen == '0') ? 'Selected' : ''; ?> >Select Gender</option>
                      <option value="m" <?php if($gen=='m') echo "selected"; ?>>Male</option>
                      <option value="f" <?php if($gen=='f') echo "selected"; ?>>Female</option>
                      <option value="o" <?php if($gen=='o') echo "selected"; ?> >Other</option>
                      <option value="bmf" <?php if($gen=='bmf') echo "selected"; ?> >Both Male and Female</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                
                  <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="performancelan">
                    <option value="0" >Select Language</option>
                    <?php foreach($performancelan as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($performancelansel==$key) echo "selected"; ?> ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="language">
                    <option value="0" >Select Language</option>
             <?php foreach($languageknownarray as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($languagesel==$key) echo "selected"; ?> ><?php echo $value; ?></option>
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
                      <input type="radio" name="online" id="inlineRadio2" value="1" <?php if($live==1){echo "checked";} ?>>
                      Online </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio3" value="2" <?php if($live==2){echo "checked";} ?>>
                      Offline </label>
                  </div>
                </div>
              <?php $vitalstatic=array();  ?>
                <?php  if($myvital){   ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Vital Statistics parameters </label>
                 <?php  $i=0; foreach($myvital as $key=> $value){  ?>

                
                  <p class="prc_sldr">
                   <label for="amount"><?php echo  $key; ?></label>
                   
                  </p>
               
                <div class="col-sm-12">
                    <select class="form-control" name="vitalstats[<?php echo  $i; ?>]">
                     <option value="0">Select  <?php echo  $key; ?> </option>
                    <?php  foreach($value as $key=> $opt){ ?>

                      <option value="<?php echo $key ?>" <?php if(in_array($key,$vitalarray)) { echo"selected"; } ?>><?php echo $opt ?></option>

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
                      <option value="5" <?php if($day==5){echo "selected";}?> >5 days</option>
                      <option value="10" <?php if($day==10){echo "selected";}?> >10 days</option>
                      <option value="15" <?php if($day==15){echo "selected";}?> >15 days</option>
                      <option value="20" <?php if($day==20){echo "selected";}?> >20 days</option>
                      <option value="25" <?php if($day==25){echo "selected";}?> >25 days</option>
                      <option value="30" <?php if($day==30){echo "selected";}?> >30 days</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="paymentfaq">
                    <option value="0" >Select Payment Frequency </option>
                       <?php foreach($paymentfaqarray as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($payment==$key){echo "selected";}?> ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="skill">
                      <option value="0" >Select Talent Type</option>
                        <?php foreach($userskillarray as $key => $skillvalue){ ?>
                      <option value="<?php echo $key ?>"  <?php if($skill==$key){echo "selected";}?>> <?php echo  $skillvalue; ?> </option>

               <?php } ?> 
                    </select>
                  </div>
                </div>
                 <input type="hidden" name="refine" value="2">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Ethnicity</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="ethnicity">
                    <option value="0" >Select  Ethnicity </option>
                      <?php foreach($Enthicity as $key => $Enthicity){ ?>
                      <option value="<?php echo $key ?>" <?php if($ethnicity==$key){echo "selected";}?> ><?php echo  $Enthicity; ?> </option>

               <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="form-group Review">
               <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>
    
                 <a href="javascript:void(0)" class="review" rel="9">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          
          <span class="fa fa-star"></span>
          & up
          </a>
                 <a href="javascript:void(0)" class="review" rel="8">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
                 <a href="javascript:void(0)" class="review" rel="7">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
                 <a href="javascript:void(0)" class="review" rel="6">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
                 <a href="javascript:void(0)" class="review" rel="5">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
               <a href="javascript:void(0)" class="review" rel="4">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
<br>
           <a href="javascript:void(0)" class="review" rel="3">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          & up
          </a>
          <br>
         <a href="javascript:void(0)" class="review" rel="2">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star" ></span>
          <span class="fa fa-star"></span>
          & up
          </a>
          <br>
         <a href="javascript:void(0)" class="review" rel="1" id="my">
          <span class="fa fa-star" style="color: orange"></span>
          <span class="fa fa-star" ></span>
          <span class="fa fa-star" "></span>
          <span class="fa fa-star" ></span>
          <span class="fa fa-star"></span>
          & up
          </a>  
      
                   
          <input type="hidden" name="r3" id="rvi" value="<?php if($r3){echo $r3;} ?>" />
          <script type="text/javascript">
            var array = [];
              $(".review").click(function(){
               array=$(this).attr('rel');
              //alert"Tes");
              $('#rvi').val(array[0])   

              console.log(array[0]);
              //alert(array[0]);
              });

          </script> 
                  <!--       <fieldset id='demo6' class="rating">
              
              
              
              
              
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
                    </fieldset> -->
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Working Style</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="workingstyle">
                      <option value="0" >Select Working Style</option>
                      <option value="P"<?php if($workstyle=="P"){echo "selected";}?> >Professional</option>
                      <option value="A"<?php if($workstyle=="A"){echo "selected";}?>>Amateur</option>
                      <option value="PT"<?php if($workstyle=="PT"){echo "selected";}?>>Part time</option>
                      <option value="H"<?php if($workstyle=="H"){echo "selected";}?>>Hobbyist</option>
                    </select>
                  </div>
                </div>
               
                <div class="form-group">
                  <div class="col-sm-12"> <a href="<?php echo SITE_URL ?>/search/profilesearch?name=&optiontype=2" class="btn btn-default">Back to Search Result </a>

                      <input type="submit" value="Refine" class="btn btn-default">
                   </div>
                </div>


                
              </form>
            </div>
          </div>
             <div class="col-sm-8" id="data">
            <div class="panel-right">
      


                <?php 

                foreach($searchdata as $value){ //pr($value);


if(!in_array($value['id'],$_SESSION['profilesearch'])) {
                 ?>


              <div class="member-detail  box row">
           <div class="box_hvr_checkndlt chkprofile">
     <?php 
     $bookjob=$this->Comman->bookjob($value['user']['id']); 
     $askquote=$this->Comman->askquote($value['user']['id']); 
    // pr($askquote);
     ?>          
             
<?php   if(!$bookjob && !$askquote ) {?>
 <input type="checkbox" name="profile[]" value="<?php echo $value['user']['id'] ?>" class="chkask askqoute" data-val="<?php echo $value['user']['id']; ?>" id="myask<?php echo $value['id'] ?>">
   <?php } ?>
                
                 <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
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
                  <?php   if($bookjob!="") { //pr($bookjob);?>
            <span class="bookingmsg"><strong>You have Booked <?php echo $bookjob['user']['user_name']; ?> on <?php echo  date("Y-m-d H:s:i",strtotime($bookjob['created'])); ?></strong> </span>
            <?php  }else{ ?>
             <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['user']['id']  ?>" class="btn btn-default ad">Book Now</a>
              <?php if($askquote!=""){ ?>
        <br><span class="bookingmsg"><strong>You have Ask for Quote Sent <?php echo $askquote['user']['user_name']; ?> on <?php echo  date("Y-m-d H:s:i",strtotime($askquote['created'])); ?></strong> </span>
               
               <?php }else{ ?>
                    
                  <a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $value['user']['id']  ?>" class="btn btn-default qot">Ask For Quote</a>
                 <?php } ?>
            <?php } ?>
              

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
               
              </div>



<?php  } } ?>

 <!-- Modal -->
  <div class="modal fade" id="multiplebooknow" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      
        <div class="modal-body">
      
  
      
     <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'insBook'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'booknowsubmit','autocomplete'=>'off')); ?>
      <span id="booknownoselect" style="display: none">Select Atleast one Job</span>
      <input type="hidden" name="user_id" value="<?php echo $userid ?>" class="chekprofileid">

  <div class="">
  <?php if(count($activejobs) > 0){ ?>
    
    
           
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job</th>
        <th>Skills</th>
      </tr>
    </thead>
    <tbody>
    <?php  foreach($activejobs as $jobs){ //pr($jobs);?>
      <tr>
      
      <?php if(! in_array($jobs['id'], $app)) {?>
      
        <td>    
    <input  type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>">
    
    <?php } ?>
    
    <?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>
    

    <a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
    </td>
    <?php  }?>
     <?php if(! in_array($jobs['id'], $app)) {?>
        <td>
      
      <select class="form-control" name="job_id[<?php echo $jobs['id']; ?>][]">
      <option value="">--Select--</option>
        <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
    <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>
<?php } ?>
  </select>  
 </td>
<?php } ?>
      </tr>
      <?php } ?>
      <?php if($pendingjob) { ?>
  
    <?php }else{?>
      <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Booking "; ?></td>  
      <?php } ?>
    </tbody>
    
  </table>
    
    <?php  
  }else{
    
    echo "No jobs Found";
  }
    
    ?>
  
  
  
   <?php if($pendingjob) {?>  <button type="submit" class="btn btn-default" id="booknowsave">Book Now</button> <?php } ?>
    </div>
    </form>
        </div>
      
      </div>
      
    </div>
  </div>
  
</div>

 <!-- Modal -->
  <div class="modal fade" id="multipleaskquote" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
        <div class="modal-body">
      <div id = "mulitpleaskquoteinvited" style="display: none">
      
    <?php foreach($_SESSION['askquotenotinvite'] as $key=>$result){ ?>
        <?php echo $result; ?> Avilable Quotes <?php echo $key; ?> Credit Left.
    
      <?php  } ?>
      </div>
           <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'search', 'action' => 'mutipleaskQuote'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'askquotesubmit','autocomplete'=>'off')); ?>
           <span id="noselect" style="display: none">Select Atleast one Skills</span>
    <input type="hidden" name="user_id" value="<?php echo $userid ?>" class="chekprofileid">
  <div class="">
  <?php if(count($activejobs) > 0){ ?>
            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job</th>
        <th>Skills</th>
      </tr>
    </thead>
    <tbody>
    <?php  $count=1;foreach($activejobs as $jobs){ //pr($jobs);

  ?>
      <tr>
      <?php if(! in_array($jobs['id'], $app)) { ?>
        <td>  


  
 
    <?php
    if($jobs['askquotedata']<1){ ?>
    
    <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote </a>
   <?php  }else{ ?>
  <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" onclick="removeslect(this);" id="jobselect<?php echo $jobs['id']; ?>" class="jobselect">
    <?php }


     } ?>

    <?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>
    

    <a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
    </td>
    <?php  }?>
      <?php if(! in_array($jobs['id'], $app)) {?>
        <td>
      
      <select name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunction(this)" class="form-control jobselect<?php echo $jobs['id']; ?>" data-req="<?php echo $jobs['id'] ?>"disabled >
        <option value="">--Select--</option>
        <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
        
         <option value="<?php echo $skillsreq['skill']['id']; ?>" ><?php echo $skillsreq['skill']['name']; ?></option>
        
 
<?php } ?>
  </select>  
  <input class="form-control" type="text" id="currency<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly />
  <input  class="form-control" type="text" id="offeramt<?php echo $jobs['id']; ?>" style="width: 38%" placeholder=" Offer Payment" readonly/>
 </td>
<?php } ?>
      </tr>
      <?php  $count++;} ?>
      <?php if($pendingjob) { ?>
  
    <?php } else{ ?>
      <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Quote "; ?></td>  
      <?php } ?>
    </tbody>
    
  </table>


<?php }else{
  
  echo "No jobs Found"; }?>
  

  
  
  
  
  
  <?php if($pendingjob) { 
      
   ?>  
    <button type="submit" class="btn btn-default" id="askquotesave">Ask for Quote</button>
 
      <?php } ?>
    </div>
    </form>
        </div>
     
      </div>
      
    </div>
  </div>
  
</div>
<script>
  $(document).ready(function(){
      $(".jobselect").click(function(evt){
        var id = $(this).attr("id");
              $("."+id).removeAttr('disabled');

      });
     });
</script>

<script>
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('#askquotesave').click(function(e) { //alert();
  e.preventDefault();
    $.ajax({
  type: "POST",
   url: SITE_URL + 'search/mutipleaskQuote',
  data: $('#askquotesubmit').serialize(),
  cache:false,
  success:function(data){ //alert(data); 
  var myObj = JSON.parse(data);
  if(myObj.success=='noselect'){

   $("#noselect").css("display","block");
   setTimeout(function() {$("#noselect").fadeOut('fast');}, 5000); 
  }else if(myObj.success=='requestnotsent'){
  $('input:checkbox').removeAttr('checked');
  location.reload();
  }else if(myObj.success=='requestsent'){
    $("#multipleaskquote").modal('toggle');
  $('input:checkbox').removeAttr('checked');
  location.reload();
    
  }


     
  }
    });
});


var SITE_URL='<?php echo SITE_URL; ?>/';
  $('#booknowsave').click(function(e) { //alert();
  e.preventDefault();
    $.ajax({
  type: "POST",
   url: SITE_URL + 'search/mutiplebooknow',
  data: $('#booknowsubmit').serialize(),
  cache:false,
  success:function(data){
    var myObj = JSON.parse(data);  
    if(myObj.success=='booknownoselect'){
   $("#booknownoselect").css("display","block");
setTimeout(function() {$("#booknownoselect").fadeOut('fast');}, 1000); 
  }else if(myObj.success=='bookingrequestnotsent'){
  
  $('input:checkbox').removeAttr('checked');
      location.reload();
  $('input:checkbox').removeAttr('checked');
  }else if (myObj.success=='bookingrequestsent'){
    $("#multiplebooknow").modal('toggle');
  $('input:checkbox').removeAttr('checked');
  location.reload();
  }
    //
    //$("#multiplebooknow").modal('toggle');
           // $('input:checkbox').removeAttr('checked');
//location.reload();

  }
    });
});



</script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min:<?php  echo $minimumage;  ?>,
      max: <?php  echo $maxage;  ?>,
      values: [ <?php  echo $minimumage;  ?>, <?php  echo $maxage;  ?>],
      slide: function( event, ui ) {
        $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });

    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
  } );
</script>
 <script>
    $('.askquotemultiple').click(function(e){
  e.preventDefault();
  action = $(this).data('action');
  userid = $(this).data('val');
  bookingurl = '<?php echo SITE_URL; ?>/search/askquotemultiple/'+userid+'/'+action;
  $('#askquotemultiple').modal('show').find('.modal-body').load(bookingurl);
    });
</script>
<script> 
$(document).ready(function(){ 
  var site_url='<?php echo SITE_URL;?>/';
  $('.chkask').click(function() { 
   
 var profile_id = $(this).data('val');
 var selected = $(".chkask:checked").map(function() {
        return $(this).data('val');
    }).get();
    var chkprofile_id = selected.join(",");
$('.chekprofileid').val(chkprofile_id);
 
 if ($(this).is(':checked')) {
   
 $(this).parent('div').removeClass('box_hvr_checkndlt');
  $('#askaplybutton').css("visibility","visible");
}else{   
   $(this).parent('div').addClass('box_hvr_checkndlt');
}
var numberOfChecked = $('input:checkbox:checked').length;
if(numberOfChecked==0){
  $('#askaplybutton').css("visibility","hidden");
}
});
});
    </script>





          




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
            <div class="row"> <div class="col-sm-5"><a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#saveprofilerefinetamplate"> Save Search Result </a></div> </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <?php  } else{   ?>

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


       <div class="row m-top-20">
          <div class="col-sm-3" style="margin-left: 35px;">
            <div class="panel panel-left">
              <h6>Refine Profile Search</h6>
              <form class="form-horizontal" method="get" action="<?php echo SITE_URL ?>/search/profilesearch">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" placeholder="Name" value="<?php echo $title; ?>" name="name" >
                  </div>
                </div>
                        <div class="form-group salry">
                  <label for="inputEmail3" class="col-sm-12 control-label">Age </label>
    <p class="prc_sldr">
                   <label for="amount">Age</label>
                   <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="age">
                  </p>
<div id="slider-range"></div>

                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Gender<?php  echo $gen; ?></label>
                  <div class="col-sm-12">
                    <select class="form-control" name="gender">
                      <option value="0" <?php ($gen == '0') ? 'Selected' : ''; ?> >Select Gender</option>
        
                    </select>
                  </div>
                  <h3 style="position: relative;left: 560px;">No Talent Found </h3>
                </div>
                <div class="form-group">
                
                  <label for="inputEmail3" class="col-sm-12 control-label">Performance Language</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="performancelan">
                    <option value="0" >Select Language</option>
                    <?php foreach($performancelan as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($performancelansel==$key) echo "selected"; ?> ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                  <div class="col-sm-12">
                    <select class="form-control" name="language">
                    <option value="0" >Select Language</option>
             <?php foreach($languageknownarray as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($languagesel==$key) echo "selected"; ?> ><?php echo $value; ?></option>
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
                      <input type="radio" name="online" id="inlineRadio2" value="1" <?php if($live==1){echo "checked";} ?>>
                      Online </label>
                    <label class="radio-inline">
                      <input type="radio" name="online" id="inlineRadio3" value="2" <?php if($live==2){echo "checked";} ?>>
                      Offline </label>
                  </div>
                </div>
             


              
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="activein">
                    <option>Select Profile </option>
               
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Payment Frequency</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="paymentfaq">
                    <option value="0" >Select Payment Frequency </option>
                       <?php foreach($paymentfaqarray as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php if($payment==$key){echo "selected";}?> ><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-12 control-label">Talent Type</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="skill">
                      <option value="0" >Select Talent Type</option>
                        <?php foreach($userskillarray as $key => $skillvalue){ ?>
                      <option value="<?php echo $key ?>"  <?php if($skill==$key){echo "selected";}?>> <?php echo  $skillvalue; ?> </option>

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
                      <option value="<?php echo $key ?>" <?php if($ethnicity==$key){echo "selected";}?> ><?php echo  $Enthicity; ?> </option>

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
                     
                    </select>
                  </div>
                </div>
             
                <div class="form-group">
                  <div class="col-sm-12"> <a href="<?php echo SITE_URL ?>/search/profilesearch?name=&optiontype=2" class="btn btn-default">Back to Search Result </a>

                      <input type="submit" value="Refine" class="btn btn-default">
                   </div>
                </div>


                
              </form>
            </div>
          </div>
          </div>

             <div class="col-sm-9" id="data">
            <div class="panel-right">
            </div>
            </div>

<?php } ?>      <script type="text/javascript">
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
                 

               $('#'+profile+'').css('color','reds');
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
        <?php  if($_SESSION['Profilerefinedata']) { ?>
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
            url: SITE_URL + 'search/savesearchprofileresult',
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
<script type="text/javascript">
   var site_url='<?php echo SITE_URL;?>/';

   function myfunction(x){
   var reqid=x.getAttribute('data-req');  
var skillid=x.value;
$(this).data("req");

   


          $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: site_url + 'search/myfunctiondata',
            data: {skill:skillid,reqid:reqid},
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

      var obj = JSON.parse(response);
      
      $('#offeramt'+reqid).val(obj.payment_currency);
      $('#currency'+reqid).val(obj.currency);


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
