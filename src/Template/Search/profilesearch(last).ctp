
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
 $maxage=$max;
}else{


 $minimumage=min($agearray);
 $maxage=max($agearray);
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


   <?php $c=0; 

   $count=0;
   foreach($_SESSION['advanceprofiesearchdata'] as $key=> $value){
  //echo $key;
    if($key=="skillshow" || $key=="currentlocunit" || $key=="form" || $key=="optiontype" || $key=="unit" ){


    }else{
      if($value ){


        if($key=="city_id"){

          if($value['0']){
            $count++;
          }

        }else{

          $count++;

        }

      }

    }
  }

  ?>
  <?php if(!$_SESSION['advanceprofiesearchdata']){ ?>
  <form class="form-horizontal">
    <div class="form-group">
      <div class="col-sm-2">

        <label for="" class=" control-label">Talent Name:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Profile Title:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Word Search:</label>
        <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Talent Type:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Location:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
      </div>

      <div class="col-sm-2" style="margin-top: 30px">

       <a href="javascript:void(0)" class="btn btn-default pull-right">View All</a>
     </div>
   </div>
   <div class="form-group">
    <div class="col-sm-2"> 
      <a href="http://bookanartiste.com/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a> </div>
      <div class="col-sm-2"> 
        <a href="http://bookanartiste.com/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div></div>
      </form>
      <?php } ?>
<div class="row"  id="panel">
        <?php if($count>5){ ?> <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip" style="    position: absolute;
    right: 5px;
    top: 243px;">Show Less</a> <?php } ?>
        <?php  if(empty($_SESSION['advanceprofiesearchdata']['name']) && $_SESSION['advanceprofiesearchdata']['optiontype']==2){ ?>
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">

              <label for="" class=" control-label">Talent Name:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
            </div>
            <div class="col-sm-2">
              <label for="" class=" control-label">Profile Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
            </div>
            <div class="col-sm-2">
              <label for="" class=" control-label">Word Search:</label>
              <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
            </div>
            <div class="col-sm-2">
              <label for="" class=" control-label">Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
            </div>
            <div class="col-sm-2">
              <label for="" class=" control-label">Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
            </div>
          </div>
        </form>
        <?php } ?>
        <form class="form-horizontal">

          <div class="form-group">
            <?php if( $_SESSION['advanceprofiesearchdata']['name'] ){ ?>
            <div class="col-sm-2">

              <label for="" class=" control-label">Talent Name:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>" readonly>
            </div>
            <?php } ?>

            <?php if( $_SESSION['advanceprofiesearchdata']['profiletitle'] ){ ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Profile Title:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['profiletitle'] ){ ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Word Search:</label>
              <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['skillshow'] ){ ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Talent Type:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['location'] ){ ?>
            <div class="col-sm-2">
              <label for="" class=" control-label">Location:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>" readonly>
            </div>
            <?php } ?>
            
          

          
            <?php  if( $_SESSION['advanceprofiesearchdata']['gender'] ){ ?>    
            <div class="col-sm-2">

              <label for="" class=" control-label">Gender:</label>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly value="<?php  if($_SESSION['advanceprofiesearchdata']){ ?> <?php for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['gender']);$i++){
                if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="m") echo "Male,";
                else if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="f")echo "Female,";
                else if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="bmf")echo "Both Male and Female";

              } ?> <?php } ?>">
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['positionname'] ){ ?>    
            <div class="col-sm-2">
              <label for="" class=" control-label">Position Name :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  echo $_SESSION['advanceprofiesearchdata']['positionname'] ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['country_id'] ){ ?>   
            <div class="col-sm-2">
              <label for="" class=" control-label">Country:</label>
              <?php $countrydata=$this->Comman->cnt($_SESSION['advanceprofiesearchdata']['country_id']);


              ?>
              <input type="text" class="form-control" id="inputEmail3" value="<?php if($countrydata){  echo $countrydata['name']; } ?>" readonly />
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['state_id'] ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">State :</label>
              <?php $statedata=$this->Comman->state($_SESSION['advanceprofiesearchdata']['state_id']);  ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($statedata){  echo $statedata['name']; } ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['city_id']['0']!="" ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">City:</label>

              <?php for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['city_id']);$i++){

                $citydata=$this->Comman->city($_SESSION['advanceprofiesearchdata']['city_id'][$i]);

                $cityarray[]=$citydata['name'];
              } ?>
              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo implode(",",$cityarray); ?>" readonly>
            </div>
            <?php } ?>


            <?php  if( $_SESSION['advanceprofiesearchdata']['clocation'] ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">Current Location :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['clocation'];  ?>" readonly>
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['currentlyworking'] ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">Currently Working</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){  echo $_SESSION['advanceprofiesearchdata']['currentlyworking']; } ?>" readonly >
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['currentlyworking'] ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">Year of Experience </label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){  echo $_SESSION['advanceprofiesearchdata']['experyear']; } ?>">
            </div>
            <?php } ?>
            <?php if( $_SESSION['advanceprofiesearchdata']['active'] ){ ?> 
            <div class="col-sm-2">
              <label for="" class=" control-label">Active In :</label>

              <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){ if($_SESSION['advanceprofiesearchdata']['active']==1){ echo " Last 45 days ";}else if($_SESSION['advanceprofiesearchdata']['active']==2){ echo " Last 60 days ";}else if($_SESSION['advanceprofiesearchdata']['active']==3){ echo " Last 3 Months ";} else if($_SESSION['advanceprofiesearchdata']['active']==4){ echo " Last 6 Months ";}   } ?>">
            </div>


            <?php } ?>



          </div>
          <?php if($_SESSION['advanceprofiesearchdata']){ ?>
          <div class="form-group">
            <div class="col-sm-2"> 
              <a href="http://bookanartiste.com/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a> </div>
              <div class="col-sm-2"> 
                <a href="http://bookanartiste.com/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div></div>
          

              <?php } ?>
                  </form>
            </div>
          </div>
          </section>

          <div class="refine-search">
            <div class="container">
              <div class="row m-top-20">
                <div class="col-sm-4">
                  <div class="panel panel-left">
                    <h6>Refine Profile Search</h6>

                    <form class="form-horizontal" method="get" action="<?php echo SITE_URL ?>/search/profilesearch" id="ajexrefine">

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Name </label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control auto_submit_item" placeholder="Name" value="<?php echo $title; ?>" name="name" >
                        </div>
                      </div>
                      <div class="form-group salry">
                        <label for="inputEmail3" class="col-sm-12 control-label">Age </label>
                        <p class="prc_sldr">
                          <label for="amount">Age</label>
                          <input type="text" id="amount" readonly style="border:0; color:#30a5ff; font-weight:normal;" name="age" class="auto_submit_item">
                        </p>
                        <div id="slider-range"></div>

                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Gender<?php  echo $gen; ?></label>
                        <div class="col-sm-12">
                          <select class="form-control auto_submit_item"" name="gender">
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
                          <select class="form-control auto_submit_item" name="performancelan[]" multiple="" >
                            <option value="0" >Select Language</option>
                            <?php foreach($performancelan as $key => $value){ ?>
                            <option value="<?php echo $key; ?>" <?php if(in_array($key,$performancelansel)){ echo"selected"; } ?> ><?php echo $value; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Language known </label>
                        <div class="col-sm-12">
                          <select class="form-control auto_submit_item" name="language[]"  multiple="" >
                            <option value="0" >Select Language</option>
                            <?php foreach($languageknownarray as $key => $value){ ?>
                            <option value="<?php echo $key; ?>"<?php if(in_array($key,$languagesel)){ echo"selected"; } ?> ><?php echo $value; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Online Now </label>
                        <div class="col-sm-12">
                          <label class="radio-inline">
                            <input type="radio" name="online" id="inlineRadio1" value="0" class="auto_submit_item">
                            All </label>
                            <label class="radio-inline">
                              <input type="radio" name="online" id="inlineRadio2" value="1" <?php if($live==1){echo "checked";} ?> class="auto_submit_item">
                              Online </label>
                              <label class="radio-inline">
                                <input type="radio" name="online" id="inlineRadio3" value="2" <?php if($live==2){echo "checked";} ?> class="auto_submit_item">
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
                              <select class="form-control auto_submit_item" name="vitalstats[<?php echo  $i; ?>]"  multiple="">
                               <option value="0">Select  <?php echo  $key; ?> </option>
                               <?php  foreach($value as $key=> $opt){ ?>

                               <option value="<?php echo $key ?>" <?php if(in_array($key,$vitalarray)) { echo"selected"; } ?> class="auto_submit_item"><?php echo $opt ?></option>

                               <?php } ?>

                             </select>
                           </div>
                           <?php  $i++;} ?>
                         </div>
                         <?php }  ?>


                         <div class="form-group">
                          <label for="inputEmail3" class="col-sm-12 control-label">Profile Active</label>
                          <div class="col-sm-12">
                            <select class="form-control auto_submit_item" name="activein">
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
                            <select class="form-control auto_submit_item" name="paymentfaq">
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
                            <select class="form-control auto_submit_item" name="skill">
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
                            <select class="form-control auto_submit_item" name="ethnicity[]"  multiple="">
                              <option value="0" >Select  Ethnicity </option>
                              <?php foreach($Enthicity as $key => $Enthicity){ ?>
                              <option value="<?php echo $key ?>" <?php if($ethnicity==$key){echo "selected";}?> ><?php echo  $Enthicity; ?> </option>

                              <?php } ?> 
                            </select>
                          </div>
                        </div>

                        <div class="form-group Review">
                         <label for="inputEmail3" class="col-sm-12 control-label">Review Rating</label>
                         <input type="radio" name="allrated" value="rate"  class="auto_submit_item"  <?php if($rated=="rate"){ echo "checked";} ?> />  All Rated
                         <input type="radio" name="allrated" value="unrate" class="auto_submit_item" <?php if($rated=="unrate"){ echo "checked";} ?> />  UnRated

                         <input type="radio" name="allrated" value="all" class="auto_submit_item"  />  All
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


                        <input type="hidden" name="r3" id="rvi" value="<?php if($r3){echo $r3;} ?>" class="auto_submit_item" />
              <script type="text/javascript">
              var array = [];
              $(".review").click(function(){
              array=$(this).attr('rel');
              //alert"Tes");
              $('#rvi').val(array[0])   

              $("#ajexrefine").submit();
              //alert(array[0]);
              });

              </script> 

        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-12 control-label">Working Style</label>
          <div class="col-sm-12">
            <select class="form-control auto_submit_item" name="workingstyle[]"  multiple="" >
              <option value="0" >Select Working Style</option>
              <option value="P"<?php if(in_array("P",$workingstyleasel)){ echo"selected"; } ?> >Professional</option>
              <option value="A"<?php if(in_array("A",$workingstyleasel)){ echo"selected"; } ?>>Amateur</option>
              <option value="PT"<?php if(in_array("PT",$workingstyleasel)){ echo"selected"; } ?>>Part time</option>
              <option value="H"<?php if(in_array("H",$workingstyleasel)){ echo"selected"; } ?>>Hobbyist</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12"> <a href="<?php echo SITE_URL ?>/search/profilesearch?name=&optiontype=2" class="btn btn-default">Back to Search Result </a>


          </div>
        </div>



      </form>
    </div>
  </div>
  <div class="col-sm-8" id="data">
    <div class="panel-right">



      <?php 

      foreach($searchdata as $value){ 
      	//$data=$this->Common->userskills($value['id']);
        if($rated=="unrate"){

          if($value['avgrating']) continue;


        }


        if(!in_array($value['id'],$_SESSION['profilesearch'])) {
         ?>


         <div class="member-detail  box row">
           <div class="box_hvr_checkndlt chkprofile">
             <?php 
             $bookjob=$this->Comman->bookjob($value['user_id']); 
             $askquote=$this->Comman->askquote($value['user_id']); 
    
             ?>          
             
            
             <input type="checkbox" name="profile[]" value="<?php echo $value['user_id']; ?>" class="chkask askqoute" data-val="<?php echo $value['user_id']; ?>" id="myask<?php echo $value['id'] ?>">
            

             <a href="javascript:void(0);" class="delete_jobalerts pull-right dlt_prfl_box" data-widget="remove" data-action="prosearch" data-val="<?php echo $value['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
           </div>
           <div class="col-sm-3">
            <div class="member-detail-img"> <img src="<?php echo SITE_URL ?>/profileimages/<?php echo $value['profile_image']  ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
              <div class="img-top-bar"> <a href="<?php echo SITE_URL;  ?>/viewprofile/<?php echo $value['user_id']; ?>" class="fa fa-user"></a> </div>
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
            
            
				 
				 
             <a href="#"  class="btn btn-default ad singlebooknow"  data-toggle="modal" data-profile="<?php echo $value['id'] ?>"  data-target="#singlebooknow">Book Now</a>
             <a href="#"  class="btn btn-default qot singleaskquote" data-profile="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#singleaskquote">Ask For Quote</a>
            
            
             
             


           </div>
           <?php $totaluserlikes=$this->Comman->likess($value['user_id']);
           $profilesave=$this->Comman->profilesave($value['user_id']);
           ?>
           <div class="icon-bar"> 
             <a href="javascript:void(0)" class="likeprofile bg-blue <?php echo (isset($totaluserlikes) && $totaluserlikes >0)?'active':'';?>" id="likeprofile<?php echo $value['user_id']?>" data-toggle="tooltip" data-val="<?php echo ($value['user_id'])?$value['user_id']:'0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

             <a href="#" class="fa fa-share"></a> 

             <a href="javascript:void(0)"  data-val="<?php echo $value['user_id']; ?>" class="sendmessage bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-envelope"></i></a>

             <a href="#" class="fa fa-paper-plane-o"></a>                 
             <a href="#" class="fa fa-floppy-o saveprofile" id="<?php echo $value['id'] ?>" data-profile="<?php echo $value['id'] ?>"<?php if ($profilesave){?>  style="color:red"     <?php  } ?>></a>
             <a href="<?php echo SITE_URL; ?>/profile/profilecountersearch/<?php echo $value['id'] ?>" class="fa fa-download"></a>
             <a href="<?php echo SITE_URL?>/profile/reportspamsearch/<?php echo $value['id']; ?>" class="report fa fa-file-text-o" data-target="#reportuser"></a>
             <!--<a href="#" class="fa fa-ban"></a>  -->
           </div>

         </div>



         <?php  } } ?>
         <script>
          $('.singleaskquote').click(function(){ 
           var profile=$(this).data('profile');
           $('.singleaskquotechekprofileid').val(profile);


           });
           
            $('.singlebooknow').click(function(){ 
           var profile=$(this).data('profile');
             $('.singlebooknowchekprofileid').val(profile);

           });
           
                    </script>

           
         
         <?php /*--------------------------------Start Singlebooknow--------------------------*/?>



         <!-- Modal -->
         <div class="modal fade" id="singlebooknow" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
             <div class="modal-header">
               <h4 class="modal-title" style="text-align: center;">Select Job's To Booking Request</h4>
             </div>
             <div class="modal-body">



               <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'insBook'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'booknowsubmitddd','autocomplete'=>'off')); ?>
               <span id="booknownoselect" style="display: none">Select Atleast one Job</span>
               <input type="hidden" name="user_id" value="" class="singlebooknowchekprofileid">

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

                      <?php if(! in_array($jobs['id'], $app)) { ?>

                      <td>    
                        <input  type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" onclick="bookingremoveslect(this);" id="bookingselectsingle<?php echo $jobs['id']; ?>" class="bookingselectsingle" >

                        <?php } ?>

                        <?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>


                        <a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
                      </td>
                      <?php  }?>
                      <?php if(! in_array($jobs['id'], $app)) {?>
                      <td>

                        <select  name="job_id[<?php echo $jobs['id']; ?>][]" class="form-control bookingselectsingle<?php echo $jobs['id']; ?>" disabled required >
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



              <?php if($pendingjob) {?>  <button type="submit" class="btn btn-default booknowsavesingle">Book Now</button> <?php } ?>
            </div>
          </form>
        </div>

      </div>
      
    </div>
  </div>
  
</div>

<?php /*--------------------------------End Singlebooknow--------------------------*/?>
<?php /*--------------------------------start Singleaskquote--------------------------*/?>
<div class="modal fade" id="singleaskquote" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
     </div>
     <div class="modal-body">
      <div id = "mulitpleaskquoteinvited" style="display: none">

        <?php foreach($_SESSION['askquotenotinvite'] as $key=>$result){ ?>
        <?php echo $result; ?> Avilable Quotes <?php echo $key; ?> Credit Left.

        <?php  } ?>
      </div>
      <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'search', 'action' => 'mutipleaskQuote'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'askquotesubmit','autocomplete'=>'off')); ?>
      <span id="noselect" style="display: none">Select Atleast one Skills</span>
      <input type="hidden" name="user_id" value="" class="singleaskquotechekprofileid">
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

          <!--<a href="<?php //echo SITE_URL; ?>/package/buyquote/<?php //echo $jobs['id']; ?>"> Buy Quote </a>-->
          <?php  }else{ ?>
          <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" onclick="removeslect(this);" id="jobselectsingle<?php echo $jobs['id']; ?>" class="jobselectsingle">
          <?php }


        } ?>

        <?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>


        <a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
      </td>
      <?php  }?>
      <?php if(! in_array($jobs['id'], $app)) {?>
      <td>
       <?php
       if($jobs['askquotedata']<1){ ?>
       <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote </a>
       <?php  }else{ ?>
       <select name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunctionsingle(this)" class="form-control jobselectsingle<?php echo $jobs['id']; ?>" data-req="<?php echo $jobs['id'] ?>"disabled required>
        <option value="">--Select--</option>
        <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
        
        <option value="<?php echo $skillsreq['skill']['id']; ?>" ><?php echo $skillsreq['skill']['name']; ?></option>
        

        <?php } } ?>

      </select>  
      <?php
      if($jobs['askquotedata']<1){ ?>

      <?php } else{?>
      <input class="form-control" type="text" id="currencysingle<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly />
      <input  class="form-control" type="text" id="offeramtsingle<?php echo $jobs['id']; ?>" style="width: 38%" placeholder=" Offer Payment" readonly/>

      <?php } ?>
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
   <button type="submit" class="btn btn-default" class="askquotesave">Ask for Quote</button>

   <?php } ?>
 </div>
</form>
</div>

</div>

</div>
</div>

</div>
<?php /*--------------------------------End Singleaskquote--------------------------*/?>






<!-- Modal -->
<div class="modal fade" id="multiplebooknow" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title" style="text-align: center;">Select Job's To Booking Request</h4>
     </div>
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
                <input  type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" id="bookingselectmultiple<?php echo $jobs['id']; ?>" class="bookingselectmultiple">

                <?php } ?>

                <?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>


                <a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
              </td>
              <?php  }?>
              <?php if(! in_array($jobs['id'], $app)) {?>
              <td>

                <select name="job_id[<?php echo $jobs['id']; ?>][]" class="form-control bookingselectmultiple<?php echo $jobs['id']; ?>" disabled required >
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



      <?php if($pendingjob) {?>  <button type="submit" class="btn btn-default booknowsave">Book Now</button> <?php } ?>
    </div>
  </form>
</div>

</div>

</div>
</div>
<div class="row"><a href="#" class="btn btn-default" style="margin-top: 40px" data-toggle="modal" data-target="#saveprofilerefinetamplate"> Save Search Result </a> </div>
</div>





















<!-- Modal -->
<div class="modal fade" id="multipleaskquote" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
     </div>
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

          <!--<a href="<?php //echo SITE_URL; ?>/package/buyquote/<?php //echo $jobs['id']; ?>"> Buy Quote </a>-->
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
       <?php
       if($jobs['askquotedata']<1){ ?>
       <a href="<?php echo SITE_URL; ?>/package/buyquote/<?php echo $jobs['id']; ?>"> Buy Quote </a>
       <?php  }else{ ?>
       <select name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunction(this)" class="form-control jobselect<?php echo $jobs['id']; ?>" data-req="<?php echo $jobs['id'] ?>"disabled required>
        <option value="">--Select--</option>
        <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
        
        <option value="<?php echo $skillsreq['skill']['id']; ?>" ><?php echo $skillsreq['skill']['name']; ?></option>
        

        <?php } } ?>

      </select>  
      <?php
      if($jobs['askquotedata']<1){ ?>

      <?php } else{?>
      <input class="form-control" type="text" id="currency<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly />
      <input  class="form-control" type="text" id="offeramt<?php echo $jobs['id']; ?>" style="width: 38%" placeholder=" Offer Payment" readonly/>

      <?php } ?>
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
   <button type="submit" class="btn btn-default" class="askquotesave">Ask for Quote</button>

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
     if($(this).is(":checked")){
      $("."+id).removeAttr('disabled');
    }else{
    //$("."+id).removeAttr('disabled');
    $("."+id).prop('disabled', 'disabled');}
  });
  });
</script>

<script>
  $(document).ready(function(){
    $(".jobselectsingle").click(function(evt){ 
     var id = $(this).attr("id"); 
     if($(this).is(":checked")){
      $("."+id).removeAttr('disabled');
    }else{
    //$("."+id).removeAttr('disabled');
    $("."+id).prop('disabled', 'disabled');}
  });
  });
</script>
<script>
  $(document).ready(function(){
    $(".bookingselectsingle").click(function(evt){ 
     var id = $(this).attr("id"); 
     if($(this).is(":checked")){
      $("."+id).removeAttr('disabled');
    }else{
    //$("."+id).removeAttr('disabled');
    $("."+id).prop('disabled', 'disabled');}
  });
  });
</script>

<script>
  $(document).ready(function(){
    $(".bookingselectmultiple").click(function(evt){ 
     var id = $(this).attr("id"); 
     if($(this).is(":checked")){
      $("."+id).removeAttr('disabled');
    }else{
    //$("."+id).removeAttr('disabled');
    $("."+id).prop('disabled', 'disabled');}
  });
  });
</script>



<script>
  var SITE_URL='<?php echo SITE_URL; ?>/';
  $('.askquotesave').click(function(e) { //alert();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: SITE_URL + 'search/mutipleaskQuote',
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
  $('.booknowsave').click(function(e) { //alert();
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


$('.booknowsavesingle').click(function(e) { //alert();
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: SITE_URL + 'search/mutiplebooknow',
    data: $('#booknowsubmitddd').serialize(),
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
      },change: function(event, ui) {
        $("#ajexrefine").submit();
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


</div>
</div>
</div>
</div>
</section>

<?php  } else{  $c=0; 

  $count=0;
  foreach($_SESSION['advanceprofiesearchdata'] as $key=> $value){
  //echo $key;
    if($key=="skillshow" || $key=="currentlocunit" || $key=="form" || $key=="optiontype" || $key=="unit" ){


    }else{
      if($value ){


        if($key=="city_id"){

          if($value['0']){
            $count++;
          }

        }else{

          $count++;

        }

      }

    }
  }
  ?>

  <div class="srch-box">
    <div class="container">
      <?php if(!$_SESSION['advanceprofiesearchdata']){ ?>
  <form class="form-horizontal">
    <div class="form-group">
      <div class="col-sm-2">

        <label for="" class=" control-label">Talent Name:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Profile Title:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Word Search:</label>
        <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Talent Type:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
      </div>
      <div class="col-sm-2">
        <label for="" class=" control-label">Location:</label>
        <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
      </div>

      <div class="col-sm-2" style="margin-top: 30px">

       <a href="javascript:void(0)" class="btn btn-default pull-right">View All</a>
     </div>
   </div>
   <div class="form-group">
    <div class="col-sm-2"> 
      <a href="http://bookanartiste.com/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a> </div>
      <div class="col-sm-2"> 
        <a href="http://bookanartiste.com/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div></div>
      </form>
      <?php } ?>
     <?php $c=0; 

     $count=0;
     foreach($_SESSION['advanceprofiesearchdata'] as $key=> $value){
  //echo $key;
      if($key=="skillshow" || $key=="currentlocunit" || $key=="form" || $key=="optiontype" || $key=="unit" ){


      }else{
        if($value ){


          if($key=="city_id"){

            if($value['0']){
              $count++;
            }

          }else{

            $count++;

          }

        }

      }
    }

    ?>
    <?php if($count>5){ ?>   <a href="javascript:void(0)" class="btn btn-default pull-right" id="flip">View All</a> <?php } ?>
      <?php  if(empty($_SESSION['advanceprofiesearchdata']['name']) && $_SESSION['advanceprofiesearchdata']['optiontype']==2){ ?>
      <form class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-2">

            <label for="" class=" control-label">Talent Name:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Profile Title:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
            <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Talent Type:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>">
          </div>
          <div class="col-sm-2">
            <label for="" class=" control-label">Location:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>">
          </div>
        </div>
      </form>
      <?php } ?>
      <form class="form-horizontal">
        <div class="form-group">
          <?php if( $_SESSION['advanceprofiesearchdata']['name'] ){ ?>
          <div class="col-sm-2">

            <label for="" class=" control-label">Talent Name:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['name'];   ?>" readonly>
          </div>
          <?php } ?>

          <?php if( $_SESSION['advanceprofiesearchdata']['profiletitle'] ){ ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Profile Title:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['profiletitle'] ){ ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Word Search:</label>
            <input type="text" class="form-control" id="inputEmail3" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo $_SESSION['advanceprofiesearchdata']['profiletitle'];  ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['skillshow'] ){ ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Talent Type:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['skillshow'];   ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['location'] ){ ?>
          <div class="col-sm-2">
            <label for="" class=" control-label">Location:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['location'];  ?>" readonly>
          </div>
          <?php } ?>

      

        <div class="row"  id="panel">
          <?php  if( $_SESSION['advanceprofiesearchdata']['gender'] ){ ?>    
          <div class="col-sm-2">

            <label for="" class=" control-label">Gender:</label>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" readonly value="<?php  if($_SESSION['advanceprofiesearchdata']){ ?> <?php for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['gender']);$i++){
              if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="m") echo "Male,";
              else if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="f")echo "Female,";
              else if($_SESSION['advanceprofiesearchdata']['gender'][$i]=="bmf")echo "Both Male and Female";

            } ?> <?php } ?>">
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['positionname'] ){ ?>    
          <div class="col-sm-2">
            <label for="" class=" control-label">Position Name :</label>

            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  echo $_SESSION['advanceprofiesearchdata']['positionname'] ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['country_id'] ){ ?>   
          <div class="col-sm-2">
            <label for="" class=" control-label">Country:</label>
            <?php $countrydata=$this->Comman->cnt($_SESSION['advanceprofiesearchdata']['country_id']);


            ?>
            <input type="text" class="form-control" id="inputEmail3" value="<?php if($countrydata){  echo $countrydata['name']; } ?>" readonly />
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['state_id'] ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">State :</label>
            <?php $statedata=$this->Comman->state($_SESSION['advanceprofiesearchdata']['state_id']);  ?>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($statedata){  echo $statedata['name']; } ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['city_id']['0']!="" ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">City:</label>

            <?php for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['city_id']);$i++){

              $citydata=$this->Comman->city($_SESSION['advanceprofiesearchdata']['city_id'][$i]);

              $cityarray[]=$citydata['name'];
            } ?>
            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata']) echo implode(",",$cityarray); ?>" readonly>
          </div>
          <?php } ?>


          <?php  if( $_SESSION['advanceprofiesearchdata']['clocation'] ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">Current Location :</label>

            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php  if($_SESSION['advanceprofiesearchdata'])  echo $_SESSION['advanceprofiesearchdata']['clocation'];  ?>" readonly>
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['currentlyworking'] ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">Currently Working</label>

            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){  echo $_SESSION['advanceprofiesearchdata']['currentlyworking']; } ?>" readonly >
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['currentlyworking'] ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">Year of Experience </label>

            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){  echo $_SESSION['advanceprofiesearchdata']['experyear']; } ?>">
          </div>
          <?php } ?>
          <?php if( $_SESSION['advanceprofiesearchdata']['active'] ){ ?> 
          <div class="col-sm-2">
            <label for="" class=" control-label">Active In :</label>

            <input type="text" class="form-control" id="inputEmail3" placeholder="" value="<?php if($_SESSION['advanceprofiesearchdata']){ if($_SESSION['advanceprofiesearchdata']['active']==1){ echo " Last 45 days ";}else if($_SESSION['advanceprofiesearchdata']['active']==2){ echo " Last 60 days ";}else if($_SESSION['advanceprofiesearchdata']['active']==3){ echo " Last 3 Months ";} else if($_SESSION['advanceprofiesearchdata']['active']==4){ echo " Last 6 Months ";}   } ?>">
          </div>


          <?php } ?>
          


        </div>
          <?php if($_SESSION['advanceprofiesearchdata']){ ?>
        <div class="form-group">
          <div class="col-sm-2"> 
            <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch/1" class="btn btn-default btn-block">Edit Search</a> </div>
            <div class="col-sm-2"> 
              <a href="<?php echo SITE_URL ?>/search/advanceProfilesearch" class="btn btn-primary btn-block">Advance Search</a> </div></div>

              <?php } ?>

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


                $('#'+profile+'').css('color','red');
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
 function myfunctionsingle(x){ 
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
      $('#cloddersingle').css("display", "block");

    },

    success:function(response){

      var obj = JSON.parse(response);
      
      $('#offeramtsingle'+reqid).val(obj.payment_currency);
      $('#currencysingle'+reqid).val(obj.currency);


    },
    complete: function() {
      $('#cloddersingle').css("display", "none");
      

    },
    error: function(data) {
      alert(JSON.stringify(data));

    }

  });




 }

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
<script type="text/javascript">


  $(function() {
   $(".auto_submit_item").change(function() {
  //  alert("Test");
  $("#ajexrefine").submit();
});
 });
</script>

<script>
  <?php if($this->Flash->render('job_fail')){  ?>
  $(document).ready(function() { //alert();
    $('#jobrefer').modal('show');
  });
  <?php } ?>
</script>


<script>
  <?php if($this->Flash->render('booking_fail')){  ?>
  $(document).ready(function() { //alert();
    $('#bookingrefer').modal('show');
  });
  <?php } ?>
</script>



<script>
  <?php if($this->Flash->render('alreadyask_job_fail')){  ?>
  $(document).ready(function() { //alert();
    $('#askquotealreadyrefrer').modal('show');
  });
  <?php } ?>
</script>

<script>
  <?php if($this->Flash->render('alreadybooknow_job_fail')){  ?>
  $(document).ready(function() { //alert();
    $('#booknowalreadyrefrer').modal('show');
  });
  <?php } ?>
</script>



<div class="modal fade" id="booknowalreadyrefrer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('',array('url' => array('controller' => 'search', 'action' => 'askquoterpeat'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>
           <?php foreach($_SESSION['bookingalreadyask']as $key=>$value){ ?>
           <tr>
            <?php   $jobdetailalready=$this->Comman->repeatalreadybooking($key);  
            
           // pr($jobdetailalready); 
            ?>
            <td><?php echo $jobdetailalready['user']['profile']['name']; ?> ,<?php echo $jobdetailalready['requirement']['title'];?> Job Booking Sent Already <?php echo $jobdetailalready['skill']['name']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
 

  </div>

</div>

</div>
</div>




<div class="modal fade" id="askquotealreadyrefrer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('',array('url' => array('controller' => 'search', 'action' => 'askquoterpeat'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>
           <?php foreach($_SESSION['askquoteinvitealreadyask']as $key=>$value){ ?>
           <tr>
            <?php   $jobdetailalready=$this->Comman->repeatalreadyjob($key);  
            
           // pr($jobdetailalready); 
            ?>
            <td><?php echo $jobdetailalready['user']['profile']['name']; ?> ,<?php echo $jobdetailalready['requirement']['title'];?> Job Ask quote data send Already <?php echo $jobdetailalready['skill']['name']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
 

  </div>

</div>

</div>
</div>


<div class="modal fade" id="bookingrefer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('',array('url' => array('controller' => 'search', 'action' => 'bookingquoterpeat'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>
           <?php foreach($_SESSION['booknownotinvite']as $key=>$value){ ?>
           <tr>
            <?php   $jobdetailbooking=$this->Comman->repeatbooking($key);  
    //pr($jobdetailbooking);
            ?>

            <?php   $alreadybooking=$this->Comman->bookingalready($key,$value);  
            ?>
            <?php if ($alreadybooking== $jobdetailbooking['requirment_vacancy'][0]['number_of_vacancy']){ ?>  
            <td></td>
            <td><?php echo $jobdetailbooking['title']."already Booked"; ?></td>
            <?php }else{   ?>
            <td>
              <input type="hidden" name="jobselectedprofile" value="<?php echo $_SESSION['bookingselectedprofile']['profile']; ?>"> 
              <input  type="checkbox" name="job_idss[<?php echo $key; ?>][]" value="<?php echo $value; ?>">
            </td>
            <td><?php echo $jobdetailbooking['title']."your vacancy available only".$jobdetailbooking['requirment_vacancy'][0]['number_of_vacancy']."are you Book Now" ?></td>

            <?php  } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>

      <button type="submit" class="btn btn-default" id="">Yes</button>
    </form>
    <button type="submit" class="btn btn-default" id="jobselectno">No</button>

  </div>

</div>

</div>
</div>












<div class="modal fade" id="jobrefer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <?php echo $this->Form->create('',array('url' => array('controller' => 'search', 'action' => 'askquoterpeat'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
        <table class="table table-bordered">
          <thead>

          </thead>

          <tbody>
           <?php foreach($_SESSION['askquotenotinvite']as $key=>$value){ ?>
           <tr>
            <?php   $jobdetail=$this->Comman->repeatjob($key);  ?>
            <td>
              <input type="hidden" name="jobselectedprofile" value="<?php echo $_SESSION['jobselectedprofile']['profile']; ?>"> 
              <input  type="checkbox" name="job_idss[<?php echo $key; ?>][]" value="<?php echo $value; ?>">
              <!--<input type="hidden"  name="job_idss[<?php //echo $key; ?>][]" value="<?php //echo $value; ?>">-->
            </td>
            <td><?php echo $jobdetail['title']."your ask quote data avilabel only".$jobdetail['askquotedata']."are you send data" ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

      <button type="submit" class="btn btn-default" id="">Yes</button>
    </form>
    <button type="submit" class="btn btn-default" id="jobselectno">No</button>

  </div>

</div>

</div>
</div>

<script>
  $('#jobselectno').click(function() {
    location.reload();
  });
</script>


<script>




  /*  Like Profile profile*/
  $('.likeprofile').click(function(){

    var profile=$(this).data('val');
    event.preventDefault();
    $.ajax({
     dataType: "html",
     type: "post",
     evalScripts: true,
     url: '<?php echo SITE_URL;?>/profile/likeprofile',
     data: {user_id:profile},
     beforeSend: function() {


     },

     success:function(response){

       var myObj = JSON.parse(response);
       if(myObj.status=='like'){

         $('#likeprofile'+profile+'').css('color','red');
       }else{
         $('#likeprofile'+profile+'').css('color','white');
       }


     },
     complete: function() {



     },
     error: function(data) {
      alert(JSON.stringify(data));

    }

  });
    
  });

  /*  Block Profile profile*/
  $('#blockprofile').click(function() {
    error_text = "You cannot Block yourself";
    user_id = $(this).data('val');
    if(user_id > 0)
    {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL;?>/profile/blockprofile',
        data: {user_id: user_id},
        cache:false,
        success:function(data){ 
          obj = JSON.parse(data);
          if(obj.error==1)
          {
            showerror(error_text);
          }
          else
          {
            if(obj.status=='block'){
              $("#blockprofile").addClass('active');
            }else{
              $("#blockprofile").removeClass('active');
            }
          }
        }
      });
    }
    else
    {
      showerror(error_text);
    }
  });
//profile counter
function profilecounter(obj){
  $.ajax({
    type: "post",
    url: '<?php echo SITE_URL;?>/profile/profilecounter',
    data:{data:obj},
    success:function(data){ 
      obj = JSON.parse(data);
      if(obj.status==1)
      {
        var div = document.getElementById("newpost");
        div.style.display = "block";
      }
      else
      {
        showerror(obj.error);
      }
    }
  });
}
function showerror(error)
{
  BootstrapDialog.alert({
    size: BootstrapDialog.SIZE_SMALL,
    title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
    message: "<h5>"+error+"</h5>"
  });
  return false;
}

</script>
<script> 
  $(document).ready(function(){
    $("#flip").click(function(){

      $("#panel").slideToggle("slow");
    });
  });
</script>
<script>
 $('.report').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>



<div id="sendmessage" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content" >
   <div class="modal-body" ></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
  $('.sendmessage').click(function(e){
    e.preventDefault();
    userid = $(this).data('val');
    messagingurl = '<?php echo SITE_URL; ?>/message/sendmessage/'+userid;
    $('#sendmessage').modal('show').find('.modal-body').load(messagingurl);
  });
</script>

<div id="myModal" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" >
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Report for this User</h4>
    </div>
    <div class="modal-body"></div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->
