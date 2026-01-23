
<?php 
foreach($country as $country_data)
{
  $country_id = $country_data['Country']['id'];
  $countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<section id="page_signup">
 <div class="container">
   <div class="row">
     <div class="col-sm-2">
     </div>

     <div class="col-sm-12">
       <div class="signup-popup">
         <h2>Manage <span>Talent Partners</span></h2>
         <?php //echo $this->Flash->render(); ?>
         <?php if($this->Flash->render('td') != ""){
                echo $this->Flash->render('td');
              }else{
                echo $this->Flash->render();
              } 
           ?>

              <div class="box-body">

       <div class="manag-stu">

        <script inline="1">
//<![CDATA[
$(document).ready(function () {
  $("#TaskAdminCustomerForm").bind("submit", function (event) {
    $.ajax({
      async:true,
      data:$("#TaskAdminCustomerForm").serialize(),
      dataType:"html", 

      success:function (data, textStatus) {

        $("#example2").html(data);}, 
        type:"POST", 
        url:"<?php echo SITE_URL; ?>/talentadmin/talentpartnersearch"});
    return false;
  });
});
//]]>
</script>
<?php echo $this->Form->create('Task',array('type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>

<div class="form-group">
  <div class="col-sm-3">
    <label>Name</label>
    <input type="text" class="form-control" name="name" placeholder="Enter Name" autocomplete="off">
  </div> 

  <div class="col-sm-3">
   <label>Email</label>
   <input type="text" class="form-control" name="email" placeholder="Enter Email" autocomplete="off">
 </div> 

  <div class="col-sm-3">
   <label>Created From Date</label>
   <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
 </div> 

 <div class="col-sm-3">
   <label>Date To</label>
   <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="Date To" autocomplete="off" readonly="readonly">
 </div> 
</div>

<div class="form-group">

 <div class="col-sm-2">
   <!-- <label>Country</label> -->
    <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','label' =>false,'empty'=>'-Select Country-','options'=>$country)); ?>
 </div> 

 <div class="col-sm-2">
   <!-- <label>State</label> -->
   <?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','label' =>false,'empty'=>'-Select State-')); ?>
 </div> 
<div class="col-sm-2">
   <!-- <label>City</label> -->
     <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'-Select City-')); ?>
 </div> 

 <div class="col-sm-2">
   
   <select class="form-control" name="status" >
    <option value="" selected="selected">All Talent Partners</option>
    <option value="1">Registered</option>
    <option value="2">Not Registered</option>
    <option value="3">Active Talent Partners</option>   
    <option value="4">Inactive Talent Partners</option>
  </select>
</div> 



<div class="col-sm-4">
<button type="submit" class="btn btn-success">Search</button>
<button type="reset" class="btn reset">Reset</button>
<a class="btn btn-success" href="<?php echo SITE_URL; ?>/talentadmin/exporttalentadminexcel">Export to Excel</a>
</div>

<script>
$(".reset").click(function(){
  $.ajax({
      async:true,
      dataType:"html", 
      success:function (data, textStatus) {
        $('#TaskAdminCustomerForm').trigger("reset");
        $("#example2").html(data);
      }, 
        type:"POST", 
        url:"<?php echo SITE_URL; ?>/talentadmin/talentpartnersearch"
      });
    return false;
  });
</script>

</div>
<?php
echo $this->Form->end();
?> 

         <div class="clearfix">
          <?php if($this->request->session()->read('talentadmin.enable_create_subadmin')=='Y'){ ?>
          <a href="<?php echo SITE_URL; ?>/talent-partner/create-talent-partner">
            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
              Create Talent Partner </button></a>
              <?php } ?>
            </div><br>


            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center">S.no</th>
                  <th rowspan="2" class="text-center">Name</th>
                  <th rowspan="2" class="text-center">Email ID</th>
                  <th rowspan="2" class="text-center">Phone Number</th>
                  <th rowspan="2" class="text-center">Total Profiles Uploaded</th>
                  <th>Registered</th>
                  <th>Not Registered</th>
                  <?php if($this->request->session()->read('talentadmin.enable_delete_subadmin')=='Y'){ ?>
                  <th rowspan="2" class="text-center">Action</th>	                
                  <?php } ?>
                </tr>
              </thead>
              <tbody id="example2">
                <?php 
                $counter = 1;
                if(isset($contentadmin) && !empty($contentadmin)){ 
		              foreach($contentadmin as $admin){  //pr($admin); ?>
            <tr>
              <td><?php echo $counter;?></td>
              <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                <?php if(isset($admin->user_name)){
                    echo ucfirst($admin->user_name);
                    if($admin['user_id'] == ""){
                      echo "<br>(Not Registered)";
                    }
                }else{
                    echo 'N/A';
                } ?></a>
              </td>
              <td><?php if(isset($admin->email)){
                          echo $admin->email;
                          if(!empty($admin['user_id'])){
                            $mails = $this->Comman->profilemails($admin['user_id']);
                            
                            if(!empty($mails['altemail'])){                              
                              echo '</br>'. str_replace(",","</br>",$mails['altemail']);
                            }
                          }
                        }else{ 
                          echo 'N/A'; 
                        } ?></td>
              <td><?php if(!empty($admin['user_id'])){
                            $data = $this->Comman->managetalentpartner($admin['user_id']);
                            //pr($data); 
                            if($data['profile']['phone']){
                              $altp = array();
                              echo $data['profile']['phone']; 
                              if(!empty($data['profile']['altnumber'])){
                                echo ", ";
                                $removespace = str_replace(' ','',$data['profile']['altnumber']);
                                $altphone = explode(",",$removespace);
                                foreach($altphone as $altphonevalue){                             
                                  $altp[] =$altphonevalue;                               
                                }
                                echo implode(", ",$altp); 
                              }  
                            }else{ 
                              echo 'N/A'; 
                            }
                           
                        }else{ 
                          echo 'N/A'; 
                        } 
                  ?></td>
              <td><?php
                if(!empty($admin['user_id'])){
                    $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                    //pr($refercount); die;
                    echo count($refercount['refers'] );
                  }else{ 
                    echo 'N/A'; 
                  }
                ?>
                
                </td>
              <td><?php 
              if(!empty($admin['user_id'])){
              $i=0; $v=0;
              
                  $refers = $this->Comman->managetalentpartner($admin['user_id']);
              
                foreach ($refers['refers'] as $key => $referValue) {
                  if($referValue['status']=='Y'){ 
                    $i++;         
                  }else{
                    $v++;
                  }
                }
              
                echo $i;
              }else{
                  echo 'N/A'; 
              }
                ?>

                </td>

                <td>
                  <?php  if(!empty($admin['user_id'])){
                   $v=0;
                  
                  $referss = $this->Comman->managetalentpartner($admin['user_id']);
                foreach ($referss['refers'] as $key => $referValues) {
                  if($referValues['status']=='N'){ 
                    $v++;         
                  }
                }
                      
                  
                echo $v;
		              }else{
		                  echo 'N/A'; 
		              }
                ?>
                </td>
                <?php if($this->request->session()->read('talentadmin.enable_delete_subadmin')=='Y'){ ?>
                <td>
                <?php /* if($admin->user->status=='Y'){ 
                  echo $this->Html->link('Active', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status  
                    ],['class'=>'label label-success']);

                }else{ 
                 echo $this->Html->link('Inactive', [
                  'action' => 'status',
                  $admin->user->id,
                  $admin->user->status
                  ],['class'=>'label label-primary']);

                } */ ?>
                  
                  <?php
                  echo $this->Html->link('Edit', [
                   'action' => 'addsubadmin',
                   $admin->id
                   ],['class'=>'label label-primary']); ?>

                  <?php
                  echo $this->Html->link('Delete', [
                   'action' => 'delete',
                   $admin->id,
                   $i
                   ],['class'=> 'label label-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                   <br>
                 </td>
                 <?php }?>
                 <script>
                  // function confirmFunction(){
                  //   var name = '<?php echo $admin['user_name']; ?>';
                  //   return confirm("Are you sure you want to delete "+name);
                  // }
                  </script>
               </tr>
               <?php $counter++; } }

               else{ ?>
               <tr>
                <td colspan="11" align="center">You have not created any Talent Partner yet</td>
              </tr>
              <?php } ?>	
            </tbody>

          </table>

  </div>
</div>


</div>
</div>
</div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $("#country_ids").on('change',function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id='+ id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/talentadmin/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("-Select State-").appendTo($("#state"));
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
          url: '<?php echo SITE_URL;?>/talentadmin/getcities',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("-Select City-").appendTo($("#city"));
            $.each(html, function(key, value) {              
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          } 
        });
      } 
    });
  });
</script>



<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script>
  $( function() {

    var dateFormat = 'dd-mm-yy',
    from = $( "#datepicker1" )
    .datepicker({
      dateFormat: 'dd-mm-yy',
      changeYear: true,
      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      to.datepicker( "option", "minDate", getDate( this ) );
    }),
    to = $( "#datepicker2" ).datepicker({
      dateFormat: 'dd-mm-yy',
      changeYear: true,
      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }
  } );
</script>

<script>
 $(function () {
   $("#example1").DataTable();
   $('#example2').DataTable({
     "paging": true,
     "lengthChange": false,
     "searching": false,
     "ordering": true,
     "info": true,
     "autoWidth": false
   });
 });
</script>




