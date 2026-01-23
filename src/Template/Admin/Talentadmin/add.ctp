
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Talent Admin
   </h1>
 </section>
 <?php 
 foreach ($skillofcontaint as $key => $value) {
//pr($value);
  $array[]=$value['skill_id'];
  $array1[]=$value['skill']['name'];
}

//pr($profile);
?>
<!-- Main content -->
<section class="content">
  <div class="row">

    <!-- right column -->
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><?php if(isset($packentity['id'])){ echo 'Edit Talent Admin '; }else{ echo 'Add Talent Admin ';} ?></h3>
        </div>  
        <!-- /.box-header -->
        <!-- form start -->

        <?php echo $this->Flash->render(); ?>

        <?php echo $this->Form->create($packentity, array( 

         'class'=>'form-horizontal',
         'id' => 'content_admin',
         'enctype' => 'multipart/form-data',
         'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>

         <div class="box-body">
		   <?php //pr($packentity);
       ?>                
       <div class="form-group">
         <label class="col-sm-3 control-label">Name</label>  
         <div class="field col-sm-6">
           <?php echo $this->Form->input('user_name', array('class' => 
           'longinput form-control usrname','maxlength'=>'20','required','placeholder'=>'Name','required','label'=>false,)); ?></div>
         </div>

         <div class="form-group">
         <?php if(isset($packentity['email'])){
           $readonly = "true";
         }else{
          $readonly = "false";
         }
          ?>
           <label class="col-sm-3 control-label">Email</label>
           <div class="field col-sm-6">
             <?php echo $this->Form->input('email', array('class' => 
             'longinput form-control','maxlength'=>'100','required','placeholder'=>'Username','id'=>'talentusers','required','label'=>false,'readonly'=>$readonly)); ?>
             <span id="talenthere" style="display:none;color:red;"><span id="talentheres"></span> is already a Talent partner</span>
             <span id="referhere" style="display:none;color:red;"><span id="referusers"></span> has already been referred. Please Create another Talent Partner</span>
           </div>
         </div>  

         <div class="form-group">
         <?php if($packentity['talent_admin']['country_id'] != 0){
           $loccountry = $packentity['talent_admin']['country_id'];
         }else{
          $loccountry = $packentity['profile']['country_ids'];
         }
          ?>

          <label class="col-sm-3 control-label">Country</label>
          <div class="field col-sm-6">
            <?php echo $this->Form->input('country_id',array('class'=>'form-control country','placeholder'=>'Country','id'=>'country_ids','required'=>true,'label' =>false,'empty'=>'--Select Country--','value'=>$loccountry,'options'=>$country)); ?>
          </div>
        </div>


        <div class="form-group">
        <?php if($packentity['talent_admin']['state_id'] != 0){
            $locstate = $packentity['talent_admin']['state_id'];
            }else{
              $locstate = $packentity['profile']['state_id'];
            }
          ?>

          <label class="col-sm-3 control-label">State</label>

          <div class="field col-sm-6">

           <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','required'=>true,'label' =>false,'empty'=>'--Select State--','value'=>$locstate,'options'=>$states)); ?>

         </div>


       </div>

       <div class="form-group">
       <?php if($packentity['talent_admin']['city_id'] != 0){
           $loccity = $packentity['talent_admin']['city_id'];
         }else{
          $loccity = $packentity['profile']['city_id'];
         }
          ?>

        <label class="col-sm-3 control-label">City</label>


        <div class="field col-sm-6">

         <?php echo $this->Form->input('city_id',array('class'=>'form-control ','placeholder'=>'City','id'=>'city','required'=>false,'label' =>false,'empty'=>'--Select City--','value'=>$loccity,'options'=>$cities)); ?>

       </div>
   

     </div>

     <div class="form-group">

      <label class="col-sm-3 control-label">Commission</label>


      <div class="field col-sm-6">

       <?php echo $this->Form->input('commission',array('class'=>'form-control','placeholder'=>'Commission','required'=>true,'id'=>'comm','label' =>false,'type'=>'number','value'=>$packentity['talent_admin']['commision'])); ?>

     </div>

   
   </div>


<input type="hidden" name="non_tp_id" id="nontalentpartnerid">


   <div class="form-group">

    <label class="col-sm-3 control-label">Skills</label>


    <div class="field col-sm-6">

     <?php echo $this->Form->input('skillshow', array('class' => 
     'longinput form-control','maxlength'=>'200','required'=>true,'placeholder'=>'Skills','label'=>false,'value'=>implode(", ",$array1))); ?>

   </div>
   <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentadmin/skills/<?php echo $packentity['id']; ?>">Add Skills</a>
   <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> 
 </div>





 <?php //pr($packentity);  ?>     
 <div class="form-group">
  <label class="col-sm-3 control-label"></label>
  <div class="field col-sm-6">
    <input type="hidden" value="N" name="enable_create_subadmin">
    <input type="checkbox" value="Y" class="cancreate" name="enable_create_subadmin" <?php if($packentity['talent_admin']['enable_create_subadmin']=='Y'){ echo "checked"; }?>> Can Create Talent Partners</div>
  </div>


  <div class="form-group">

    <label class="col-sm-3 control-label"></label>
    <div class="field col-sm-6">
     <input type="hidden" value="N" name="enable_delete_subadmin">
     <input type="checkbox" value="Y" class="candelet" name="enable_delete_subadmin" disabled <?php if($packentity['talent_admin']['enable_delete_subadmin']=='Y'){ echo "checked"; }?>> Can Edit and Delete Talent Partners
   </div>


 </div>

 <script type="text/javascript">
 $(document).ready(function() {
  if($('.cancreate').prop("checked") == true){
    $('.candelet').removeAttr("disabled");
  }

  $('.cancreate').click(function(){
    var enab;
    if($(this).prop("checked") == true){
      enab = $(this).val();
    }else{
      enab = "";
    }    
    //alert(enab);
    if(enab=='Y'){
      $('.candelet').removeAttr("disabled");
    }else{
      $('.candelet').prop("disabled",true);
      $('.candelet').prop("checked",false);
    }
   
  });
 });
</script>

</div><!--content-->

<!-- Modal -->

<div id="myModal" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" >
   <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
   <div class="modal-body" id="skillsetsearch"></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<script>
 $('.skill').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});



</script>
<!-- /.form group -->

</div>
<!-- /.box-body -->
<div class="box-footer">
 <?php
 echo $this->Html->link('Back', [
   'action' => 'index'

   ],['class'=>'btn btn-default']); ?>

 <?php
 if(isset($transports['id'])){
  echo $this->Form->submit(
    'Update', 
    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
    ); }else{ 
    echo $this->Form->submit(
      'Add', 
      array('class' => 'btn btn-info pull-right', 'title' => 'Add')
      );
  }
  ?>
</div>
<!-- /.box-footer -->
<?php echo $this->Form->end(); ?>
</div>


<!-- /.row -->
</section>
<!-- /.content -->
</div>

<script>
  $(document).ready(function(){  //alert();
    $('#talentusers').change(function() { //alert();
      var username = $('#talentusers').val();
      //alert(username);
      $.ajax({ 
        type: 'POST', 
        url: '<?php echo SITE_URL;?>/admin/talentadmin/checktalent',
        data: {'username':username}, 
        success: function(data){
          obj = JSON.parse(data);
          console.log(obj);

          if(obj.name == 'Y')
          {
           $('#talentusers').val('');
           $('#talenthere').show();
           $('#referhere').hide();
           $('.usrname').val('');
           $("#talentheres").html(obj.user_name);
           //$("#referuser").html(obj.user_name);
         }else if(obj.name == 'R'){
           //alert('hello');
          $('#talentusers').val('');
           $('#referhere').show();
           $('#talenthere').hide();
           $('.usrname').val('');
           //$("#talentheres").html(obj.user_name);
           $("#referusers").html(obj.user_name);
         }else if(obj.id == null)
         {
           $('#passwordblank').show();
           $('#talenthere').hide();
           $('#referhere').hide();
           
          $('#nontalentpartnerid').val('');
         }else{


          if (obj.country) {
            $("#state").find('option').remove();
            var dataString = 'id='+ obj.country;
            $.ajax({
              type: "POST",
              url: '<?php echo SITE_URL;?>/admin/talentadmin/getallStates',
              data: dataString,
              cache: false,
              success: function(html) {
                $('<option>').val('0').text('--Select State--').appendTo($("#state"));
                $.each(html, function(key, value) {        
                 $('<option>').val(key).text(value).appendTo($("#state"));
               });
               $('#state').val(obj.state);
              } 
            });

            $("#city").find('option').remove();
            var dataStrings = 'id='+ obj.state;
            $.ajax({
              type: "POST",
              url: '<?php echo SITE_URL;?>/admin/talentadmin/getallcities',
              data: dataStrings,
              cache: false,
              success: function(htmls) {   
                $('<option>').val('0').text('--Select City--').appendTo($("#city"));
                $.each(htmls, function(keys, values) {              
                  $('<option>').val(keys).text(values).appendTo($("#city"));
                });
                $('#city').val(obj.city);
              } 
            });

          }


          $('.country').removeAttr('value');

          $('.usrname').val(obj.name);
          $('#nontalentpartnerid').val(obj.id);
          $('.country').val(obj.country);

          $('.country').change(function() {

         /* $('#state').removeAttr('value');
         $('#city').removeAttr('value');*/
         $('#state').val(obj.state);
         $('#city').val(obj.city);

       });
          
        }
      }, 
    });  
    });
  });
</script>


<script type="text/javascript">
	$(document).ready(function() {
		$("#country_ids").on('change',function() {
			var id = $(this).val();
			$("#state").find('option').remove();
			$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getallStates',
					data: dataString,
					cache: false,
					success: function(html) {
            $('<option>').val('0').text('--Select City--').appendTo($("#city"));
            $('<option>').val('0').text('--Select State--').appendTo($("#state"));
            $.each(html, function(key, value) {        
             $('<option>').val(key).text(value).appendTo($("#state"));
           });
          } 
        });
			}
		});

		$("#state").on('change',function() {
			var id = $(this).val();
			$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getallcities',
					data: dataString,
					cache: false,
					success: function(html) {
            $('<option>').val('0').text('--Select City--').appendTo($("#city"));
						$.each(html, function(key, value) {              
							$('<option>').val(key).text(value).appendTo($("#city"));
						});
					} 
				});
			}	
		});
	});
</script>


