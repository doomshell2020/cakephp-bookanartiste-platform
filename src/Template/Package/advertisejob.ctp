
<style type="text/css">
  .js .input-file {
    top: 0;
    left: 0;
    width: 100% !important;
    opacity: 0;
    padding: 14px 0;
    cursor: pointer;
    height: 316px;
}
#totalamt, .rename{
  border: 0;
}
#totalamt:focus, #totalamt:active{
  border: 0;
}
.rename:focus, .rename:active{
  border: 0;
}


/*=======================================All Searching input designs=============================
 * ================================================================================================
 * ===================================================================================================*/
 
 #myUL, #testUL, #retail{
  position: relative !important;
  z-index: 999 !important;
}
#myUL ul, #testUL ul, #retail ul {
  list-style-type: none;
  overflow-y: scroll;
  margin: 0;
  padding: 0;
  max-height:150px !important;
  position: absolute;
  width: 100% !important;
  background-color: #eaeaea !important;
}

#myUL li, #testUL li, #retail li {
  font-size:13px !important;
  border-bottom: 0px solid #ccc !important;

}

#myUL li  li:last-child {
  border: none;
}

#testUL li  li:last-child {
  border: none;
}

#retail li  li:last-child {
  border: none;
}

#myUL li  a, #testUL li a, #retail li a {
  text-decoration: none;
  color: #000;
  display: block;
  padding:  8px 13px !important;
  width: 100% !important;

  -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
  -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
  -o-transition: font-size 0.3s ease, background-color 0.3s ease;
  -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
  transition: font-size 0.3s ease, background-color 0.3s ease;
}

#myUL li  a:hover, #testUL li a:hover, #retail li a:hover {background-color: #ddd;}

.nav-link {
  display: block;
  padding: .5rem 10px !important;
}
</style>

<section id="page_signup">
 <div class="container">
   <div class="row">
     <div class="col-sm-2">
     </div>

     <div class="col-sm-12">
       <div class="signup-popup">
         <h2>Create Advertisement <span>For Your Requirement</span></h2>
         <p>The charges of displaying advertise of your requirement is <?php echo "$".$bannerpackid['cost_per_day']." per day."; ?></p>
         <?php echo $this->Flash->render(); ?>

         <div class="box-body">

           <div class="manag-stu">
            <?php echo $this->Form->create($banner,array('url' => array('controller' => 'package', 'action' => 'advertisejob'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off','onsubmit'=>"return validateform()")); ?>


            <div class="form-group">
                <label for="" class="col-sm-3 control-label">Advertisement Title:</label>
                <div class="col-sm-8">
                 <?php //echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Advertisement Title','id'=>'name','required','label' =>false,'maxlength'=>100)); ?>

                <input type="hidden" name="requir_id" value="<?php echo $myjobs['id']; ?>">
                <input type="text"  name="rname" placeholder ="Enter Job Title" class="longinput form-control input-medium" autocomplete="off" value="<?php echo $myjobs['title']; ?>" >
                

               </div>
               <div class="col-sm-1"></div>
              </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Advertisement Picture:</label>
                    <div class="col-sm-4 upload-img text-center">
                        <?php if($profile['profile_image']){ ?>
                        <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile['profile_image']; ?>">
                        <div><a href="#"><div class="input-file-container">
                          <input class="input-file" id="file" type="file" name="banner_image" onchange="return fileValidation()">
                          <label tabindex="0" for="my-file" class="input-file-trigger">Change Image</label>
                          <span id="ncpyss" style= "display: none; color: red"> Image Extension Allow .jpg|.jpeg|.png... Format Only</span>
                        </div>

                      </a>


                    </div>
                    <?php }else{ ?>
                    <div class="input-file-container">
                    <div id="imagePreview">
                    <img src="job/jobadvrt.jpg">
                    </div>
                    <span style="color: red; display: block;">Image Size 500X400</span>
                    <div>
                    
                      <input class="input-file" id="file" type="file" name="job_image_change" onchange="return fileValidation()">
                      <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                      <span id="ncpyss" style= "display: none; color: red">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

                    </div>
              
                </div>
                <input type="hidden" id="jobimg" name="jobimg">
                <?php } ?>
              </div>
              <div class="col-sm-3"> 
                <!-- <input type="file" class="upload">-->
                <p class="file-return"></p>
              </div>
            </div>

              <input type="hidden" name="banner_pack_id" value="<?php echo $bannerpackid['id']; ?>">
              


              <!-- <div class="form-group">
                <label for="" class="col-sm-3 control-label">Requirement URL:</label>
                <div class="col-sm-8">
                 <?php //echo $this->Form->input('bannerurl',array('class'=>'form-control','placeholder'=>'Banner Url','id'=>'name','required','label' =>false,'type'=>'url')); ?>

               </div>
               <div class="col-sm-1"></div>
              </div> -->
            
              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Target Gender:</label>
                <div class="col-sm-8">
                 <div class="input radio">
                 
                 <label class="radio-inline">
                 <label for="gender-a">
                 <input type="checkbox" name="gender[]" value="a" id="gender-a">All</label>
                 </label>
                 <label class="radio-inline">
                 <label for="gender-m">
                 <input type="checkbox" name="gender[]" value="m" id="gender-m">Male</label>
                 </label>
                 <label class="radio-inline">
                 <label for="gender-f">
                 <input type="checkbox" name="gender[]" value="f" id="gender-f" placeholder="">Female</label>
                 </label>
                 <label class="radio-inline">
                 <label for="gender-o">
                 <input type="checkbox" name="gender[]" value="o" id="gender-o">Other</label>
                 </label>
                 <label class="radio-inline">
                 <label for="gender-bmf">
                 <input type="checkbox" name="gender[]" value="bmf" id="gender-bmf">Male And Female</label>
                 </label>
                 </div>

               </div>
               <div class="col-sm-1"></div>
              </div>
              
              <script>
                $('#gender-a').click(function() {
                    
                    if ($(this).is(':checked')) {
                        $('#gender-m').attr('checked',true);
                        $('#gender-f').attr('checked', true);
                        $('#gender-o').attr('checked', true);
                        $('#gender-bmf').attr('checked', true);
                    }else{
                        $('#gender-m').attr('checked', false);
                        $('#gender-f').attr('checked', false);
                        $('#gender-o').attr('checked', false);
                        $('#gender-bmf').attr('checked', false);
                    }
                });
            </script>
            
                <div class="form-group">
                <label for="" class="col-sm-3 control-label">Age Group : </label>
                <div class="col-sm-8">
                  <div class="row">
                   <div class="col-sm-5 date">


                    <?php echo $this->Form->input('min_age',array('class'=>'form-control','placeholder'=>'Minimum Age','type'=>'Number','required'=>true,'label' =>false,'value'=>(!empty($requirement['min_age']))?$requirement['min_age']:'')); ?>

                  </div>


                  <div class="col-sm-5 date">
                    <?php echo $this->Form->input('max_age',array('class'=>'form-control','placeholder'=>'Maximum Age','type'=>'number','required'=>true,'label' =>false,'value'=>(!empty($requirement['max_age']))?$requirement['max_age']:'')); ?>
                  </div>
                </div>
              </div>    
              </div>   

               <div class="form-group">
                <label for="" class="col-sm-3 control-label">Locations:</label>
                <div class="append">
                <div class="locfield">
                <div class="col-sm-3"></div>
                <div class="col-sm-7">
                  <?php echo $this->Form->input('current_location[]', array('class' => 
                  'longinput form-control','type'=>'text','placeholder'=>'Location','label'=>false,'id'=>'pac-inputss'));?>
                  <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">--> <div id="map"></div>  
                  <?php echo $this->Form->input('current_lat[]',array('class'=>'form-control','type'=>'hidden','id'=>'latitudecurrent','label' =>false)); ?>

                  <?php echo $this->Form->input('current_long[]',array('class'=>'form-control','type'=>'hidden','id'=>'longitudecurrent','label' =>false)); ?>
                  <br>
                </div>
                </div>
                <button type="button" id="addbutton" class="btn btn-default col-sm-1">Add</button>
                <div class="clonediv">
                
                </div>
                </div>
                
                  
               
              </div>

              <script>
                $(document).ready(function(){
                    $("#addbutton").click(function(){
                        if($("#pac-inputss").val() != ""){
                            event.preventDefault();
                            $(".locfield").clone().appendTo(".clonediv");
                            $(".clonediv div").removeClass("locfield"); 
                            $(".clonediv .longinput").attr("readonly","true"); 
                            $(".locfield .longinput").val(""); 
                            $(".locfield #latitudecurrent").val(""); 
                            $(".locfield #longitudecurrent").val(""); 
                        }else{
                            
                        }
                       
                    });
                    $(document).on("click", "a.remove" , function() {
                        $(this).parent().remove();
                    });
                });
            </script>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Advertise to:</label>
                <div class="col-sm-8">
                 <div class="input radio">
                 <label class="radio-inline">
                 <label for="advrto1">
                 <input type="checkbox" name="adfor[]" value="0" id="advrto1">All</label>
                 </label>
                 <label class="radio-inline">
                 <label for="advrto2">
                 <input type="checkbox" name="adfor[]" value="2" id="advrto2" placeholder="">Talent</label>
                 </label>
                 <label class="radio-inline">
                 <label for="advrto3">
                 <input type="checkbox" name="adfor[]" value="3" id="advrto3" placeholder="">Non talent</label>
                 </label>
                 <a style="display:none;" data-toggle="modal" class='skill btn btn-success btn-xs' href="#">Add Skills</a>
                 <!-- Modal -->

                  <div id="myModal" class="modal fade">
                  <div class="modal-dialog" style="height: 487px; overflow-y: scroll;">

                    <div class="modal-content" >
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3 class="modal-title">Please select the talent types to whom you want to advertise your profile</h3>
                    </div>
                    <div class="modal-body" id="skillsetsearch">
                    
                    <div class="">										
                    <section class="content-header hide" id="error_message">
                      <div class="alert alert-danger alert-dismissible">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <p id="skill_error"></p>
                      </div>
                    </section>
                    <div class="table-responsive">  
                    
                      <ul id="myUL"  class="list-inline form-group col-sm-12">
                          
                        <?php if($Skill) { $i=1; foreach($Skill as $value){
                          ?>
                          <li class=""> 
                            <div>
                              <label class="radio-inline">
                                <input name="skill[]" type="checkbox" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>"/><?php echo $value['name'] ?>
                              </label>
                            </div>
                            
                            </li>
                            
                                  <?php $i++; } ?> 
                                  </ul>
                                  <?php } else {   echo "No Data Found"; } ?>
                    <!--         <div class="row m-top-20">-->
                        <!--	<div class="col-sm-6 text-center">-->
                        <!--		<button id="btn" type="submit" class="btn btn-default">Select Skills</button>-->
                        <!--	</div>-->
                        <!--	<div class="col-sm-6 text-center">-->
                        <!--		<button id="btn" type="button" onclick="cancel(); " class="btn btn-default">Cancel</button>-->
                        <!--	</div>-->
                        <!--</div>-->
                                  
                          </div>
                        </div>                    
                    
                    </div>
                  </div>
                  <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->

                  </div>
                 <!-- /.modal -->   

               </div>
               </div>
               <div class="col-sm-1">
                
               </div>
              </div>
              
              <script>
                $('#advrto1').click(function() {
                    
                    if ($(this).is(':checked')) {
                        $('#advrto1').attr('checked',true);
                        $('#advrto2').attr('checked',true);
                        $('#advrto3').attr('checked', true);
                    }else{
                        $('#advrto1').attr('checked',false);
                        $('#advrto2').attr('checked',false);
                        $('#advrto3').attr('checked', false);
                    }
                    
                    if($("#advrto2").prop('checked') == true){
                         //alert("hello");
                         $('.skill').css({"display": "inline-block", "margin-left": "10px"});
                     }else{
                         $('.skill').css("display", "none");
                     }
                });
                $('#advrto2').click(function() {
                     if($("#advrto2").prop('checked') == true){
                         //alert("hello");
                         $('.skill').css({"display": "inline-block", "margin-left": "10px"});
                     }else{
                         $('.skill').css("display", "none");
                     }
                });
            </script>           
            

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Advertise From Date/Time:</label>
                <div class="col-sm-8">
                  <div class="row">
                   <div class="col-sm-5 date">


                    <?php echo $this->Form->input('ad_date_from',array('class'=>'form-control datetimepicker1','placeholder'=>'M DD, YYYY','type'=>'text','required'=>true,'label' =>false,'readonly'=>true,'id'=>'event_from_date','onchange'=>"return validateform()",'value'=>(!empty($requirement['event_from_date']))?date('Y-m-d H:m',strtotime($requirement['event_from_date'])):'')); ?>

                  </div>

                  <label for="" class="col-sm-2 control-label" style="text-align:center">TO :</label>
                  <div class="col-sm-5 date">
                    <?php echo $this->Form->input('ad_date_to',array('class'=>'form-control datetimepicker2','placeholder'=>'M Dd, YYYY','type'=>'text','required'=>true,'label' =>false,'readonly'=>true,'id'=>'event_to_date','onchange'=>"return validateform()",'value'=>(!empty($requirement['event_to_date']))?date('Y-m-d H:m',strtotime($requirement['event_to_date'])):'')); ?>
                  </div>
                </div>
               <!--  <span class="jobpostrequired">* Your Banner request shall be reviewed within 48 hours</span> -->
              </div>
              <div class="col-sm-1"></div>       
              </div>              

              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Total Price</label>
                <div class="col-sm-8">
                
                  <h5 id="totaldiv">
                    $<input readonly="readonly" type="text" name="req_ad_total" id="totalamt">
                 </h5>
                </div>
              </div>      

             <div class="form-group">
                 <label class="col-sm-3 control-label"></label>
                 <div class="field col-sm-6">
                  <input type="hidden" value="N" name="enable_create_subadmin">
                  <label>
                   <input type="checkbox" required="required" class="mtac"> I agree with Bookanartiste <a data-toggle="modal" class='tandc' href="javascript:void(0);"> Terms and Conditions</a>
                  
                  <script>
                     $('.tandc').click(function(e){
                        //alert("hello");
                      e.preventDefault();
                      $('#termsConditions').modal('show');
                    });
                    </script>
                  </label>
                </div>
              </div>


              <div class="form-group">
                <div class="col-sm-12 text-center m-top-20">
                  <button type="submit" class="btn btn-default">Pay Now and Advertise</button>
                </div>
              </div>
              </form>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 
 <!-- Modal -->

<div id="myModal" class="modal fade">
 <div class="modal-dialog" style="height: 487px; overflow-y: scroll;">

  <div class="modal-content" >
   <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
   <div class="modal-body" id="skillsetsearch"></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

 <!-- Modal -->

<div id="termsConditions" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms and Conditions</h4>
      </div>
   <div class="modal-body">
      <?php echo $termsandconditions; ?>
      <br>
      <div>
       <input type="checkbox" class="tac">I agree the Bookanartiste Terms and Conditions
   </div>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show');
});
</script>

<script>
                $('.tac').click(function() {
                    
                    if ($(this).is(':checked')) {
                        $('.mtac').attr('checked',true);
                    }else{
                        $('.mtac').attr('checked',false);
                    }
                });
                
                $('.mtac').click(function() {
                    
                    if ($(this).is(':checked')) {
                        $('.tac').attr('checked',true);
                    }else{
                        $('.tac').attr('checked',false);
                    }
                });
            </script>

<?php 
//pr($jobadid['ad_date_to']);
if($jobadid['ad_date_to']){  
  $jobaddate= date('Y-m-d H:i:s', strtotime($jobadid['ad_date_to'] . ' +1 day'));
}else{
  $jobaddate= date('Y-m-d');
}
  $lastdate= date('d',strtotime($myjobs['last_date_app'])); 
if ($myjobs['image']) {  
$jobimg= SITE_URL."/job/".$myjobs['image'];
$myimg=$myjobs['image'];
}else{
$jobimg= SITE_URL."/job/jobadvrt.jpg";
} ?>
<?php
$lastappdate= date('Y-m-d H:i:',strtotime($myjobs['last_date_app']));
?>


<script type="text/javascript">
    $(function () {
      $img=document.getElementById('imagePreview').innerHTML = '<img src="<?php echo $jobimg; ?>"/>';
      $('#jobimg').val('<?php echo $myimg; ?>');
      //alert(img);
      var daydiff='<?php echo $lastdate; ?>';
      var jobaddate=new Date('<?php echo $jobaddate; ?>');
      var lastappdate=new Date('<?php echo $lastappdate; ?>');
    
      var today = new Date();
      var tomorrow = new Date();
      
      tomorrow.setDate(today.getDate()+1);
      $("#totalamt").val('0');
        $('#event_from_date').datetimepicker({
            format: 'M dd, yyyy HH:ii P',
            startDate: today,
            endDate: lastappdate,
            autoclose:true,
        });
        $('#event_from_date').click(function (e) {
            $('#event_from_date').datetimepicker("show");
            e.preventDefault();
        });
        $('#event_from_date').change(function(){
            var event_from_dates = new Date($('#event_from_date').val());
            var day=event_from_dates.getDate();
         
            $('#event_to_date').datetimepicker({
                format: 'M dd, yyyy HH:ii P',
                startDate: tomorrow,
                endDate: lastappdate,
                autoclose:true,
            });
        
        });
        $('#event_to_date').click(function (e) {
            $('#event_to_date').datetimepicker("show");
            e.preventDefault();
        });
        
    
    });
</script>

<script  type="text/javascript">
  function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var maxsize = '100';
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    
    if(!allowedExtensions.exec(filePath)){
     $("#ncpyss").css("display", "block");
     fileInput.value = '';
     return false;
   }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {

         var size = fileInput.files[0].size;
         var reader = new FileReader();
         reader.onload = function(e) {
          document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);

      }
    }
  }
</script>



<script>
  $(document).ready(function () {
   $('#sample_input').awesomeCropper(
     { width: 150, height: 150, debug: true }
     );
 });

// Validate form
function validateform()
{
  
error = '';
//alert('0');
// alert($('#event_from_date').val());
event_from_date = new Date($('#event_from_date').val());
event_to_date = new Date($('#event_to_date').val());

var day=event_from_date.getDate();
var months=event_from_date.getMonth()+1;
var years=event_from_date.getFullYear();

var fromdate=years+'-'+months+'-'+day;

//console.log(fromdate);

var dayto=event_to_date.getDate();
var monthsto=event_to_date.getMonth()+1;
var yearsto=event_to_date.getFullYear();

var todate=yearsto+'-'+monthsto+'-'+dayto;

//console.log(todate);

if(todate <= fromdate)
{
  $("#totalamt").val('0'); 
  //error = error+"Advertisement End date cannot be less than Advertisement start date.<br>";
}else{
  var start = $('#event_from_date').val();
  var end = $('#event_to_date').val();
  // end - start returns difference in milliseconds 
  var diff = new Date(event_to_date - event_from_date);
  // get days
  var days = diff/1000/60/60/24;
  var daydiff= Math.round(days);
  var amt='<?php echo $bannerpackid['cost_per_day']; ?>';
  var totalamt=amt*daydiff;
  //alert(totalamt);
  if (isNaN(totalamt)) {
    $("#totalamt").val('');
  }else{
    $("#totalamt").val(totalamt);
  }
}

// if(error!='')
// {
//   BootstrapDialog.alert({
//   size: BootstrapDialog.SIZE_SMALL,
//   title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Advertisement !!",
//   message: "<h5>"+error+"</h5>"
//  });
//   $('#event_to_date').val('');
//   return false;
// }
}

</script> 

<script>

function addskill(ele){
  var total_elegible_skills = '<?php echo $total_elegible_skills ?>';
  var fruits = [];
  var other = [];
  $("#error_message").addClass("hide");
  var checked = document.getElementById(ele.id);
  var ckName = document.getElementsByName(ele.name);
  $("input:checkbox[class=chk]").each(function () {
    if($(this).is(":checked")){
      var checkedskills = $('input:checkbox[class=chk]:checked').length;
      if(checkedskills > total_elegible_skills)
      {

skill_error = "You can only Select "+total_elegible_skills+" skill categories for your profile"; 
$("#skill_error").html(skill_error);
$("#error_message").removeClass("hide");
// $("#"+ele.id).prop('checked', false);
$(checked).removeAttr('checked');
// return false;
}


for(var i=0; checkedskills > total_elegible_skills; i++){
if(!ckName[i].checked){
ckName[i].disabled = true;

}else{
ckName[i].disabled = false;

}
} 
fruits.push($(this).val());
other.push(' '+$(this).attr("data-skill-type"));
}else{

for(var i=0; i < ckName.length; i++){
ckName[i].disabled = false;
} 
}
});


  $('#skill').val(fruits);
  $('#skillshow').val(other);
}



</script>
<script>
function myFunction() {
var input, filter, ul, li, a, i;
input = document.getElementById("myInput");

filter = input.value.toUpperCase();
ul = document.getElementById("myUL");
li = ul.getElementsByTagName("li");
for (i = 0; i < li.length; i++) {
a = li[i].getElementsByTagName("label")[0];

if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
li[i].style.display = "";
} else {
li[i].style.display = "none";

}
}
}
</script>    

