<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Talent Admin
       
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">


    
	<div class="box">
            <div class="box-header">
					<?php echo $this->Flash->render(); ?>

          
<h3 class="box-title"> Advance Search  </h3>
            </div>
            <!-- /.box-header -->
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
        url:"<?php echo ADMIN_URL ;?>talentadmin/search"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('url'=>array('controller'=>'products','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>

<div class="form-group">
  

 
<div class="col-sm-3">
 <label>Country</label>
   <?php echo $this->Form->input('country_id',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
</div> 

<div class="col-sm-3">
 <label>State</label>
<?php echo $this->Form->input('state_id',array('class'=>'form-control','placeholder'=>'State','id'=>'state','label' =>false,'empty'=>'--Select State--','options'=>$states)); ?>
</div> 

<div class="col-sm-3">
 <label>City</label>
 <?php echo $this->Form->input('city_id',array('class'=>'form-control','placeholder'=>'City','id'=>'city','label' =>false,'empty'=>'--Select City--','options'=>$cities)); ?>
</div> 
</div>
<div class="form-group">

  <div class="col-sm-3">
   <label>User Type</label>
   <select class="form-control" name="user_type" >
        <option value="" selected="selected">-All-</option>
        <option value="<?php echo TALANT_ROLEID; ?>">Talent</option>
        <option value="<?php echo NONTALANT_ROLEID; ?>">Non Talent</option>
  </select>
</div>  
<div class="col-sm-3">
 <label>Skills</label>
  <input type="text" class="form-control" name="skillshow" id="skillshow" placeholder="Skills">
   <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentadmin/skills/<?php echo $packentity['id']; ?>">Add Skills</a>
   
</div> 

<div class="col-sm-3">
  
    <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",",$array); ?>"/> 
</div>
  <div class="col-sm-3">
	  </br>
    <button type="submit" class="btn btn-success">Search</button>
    <button type="reset" class="btn btn-primary">Reset</button>
    <a href="<?php echo SITE_URL; ?>/admin/talentadmin/exporttalentadmin"><i class="fa fa-file-excel-o"></i></a>
  </div>
</div>
<?php
echo $this->Form->end();
?>   
</div>
</div>
</div>	</div>	</div>
 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">
<a href="<?php echo SITE_URL; ?>/admin/talentadmin/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Talent Admin </button></a>

</div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
		    <th>S.no</th>
		    <th>Name</th>
		    <th>Country</th>
		    <th>State</th>
		    <th>City</th>
		    <th>Skills</th>
		    <th>Membership from</th>
		    <th>Talent Partner from</th>
		    <th>Action</th>	
                </tr>
                </thead>
                 <tbody id="example2">
		<?php 
		$counter = 1;
		
		//pr($talents); die;
		
		if(isset($talents) && !empty($talents)){ 
		foreach($talents as $admin){ //  pr($admin); 
		
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td>
                  <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['country'])){ echo $admin['country'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['state'])){ echo $admin['state'];}else{ echo 'N/A'; } ?>
                  </td>
                  
                   <td>
                  <?php if(isset($admin['city'])){ echo $admin['city'];}else{ echo 'N/A'; } ?>
                  </td>
		<td><?php if(isset($admin['skill_name'])){ echo $admin['skill_name'];}else{ echo 'N/A'; } ?></td>
		<td><?php if(isset($admin['membership_from'])){ echo $admin['membership_from'];}else{ echo 'N/A'; } ?></td>
		<td><?php if(isset($admin['talent_from'])){ echo $admin['talent_from'];}else{ echo 'N/A'; } ?></td>
		<td>
		<?php
			echo $this->Html->link('Transcations', [
			    'action' => 'transcations',
			    $admin['user_id']
			],['class'=>'btn btn-primary']); ?>
			
		<?php
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $admin['user_id']
			],['class'=>'btn btn-primary']); ?>
	
			<?php
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $admin['id']
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
      <br>
   
      </td>
                </tr>
		<?php $counter++;} }



     else{ ?>
		<tr>
		<td colspan="11" align="center">NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
  
  <!-- Daynamic modal -->
<div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content">
         <div class="modal-body"></div>
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




<script type="text/javascript">
	// From Date Picker
	$('#from_date_picker').datepicker({ 
	    dateFormat: 'yy-mm-dd', 
	    maxDate: '+0d',
	    changeMonth: true,
	    changeYear: true,
	});
	
	// To Date Picker
	$('#to_date_picker').datepicker({ 
	    dateFormat: 'yy-mm-dd', 
	    maxDate: '+0d',
	    changeMonth: true,
	    changeYear: true,
	});



	$(document).ready(function() {
		$("#country_ids").on('change',function() {
			var id = $(this).val();
			$("#state").find('option').remove();
			//$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getStates',
					data: dataString,
					cache: false,
					success: function(html) {
						$('<option>').val("").text("Select State").appendTo($("#state"));
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
					url: '<?php echo SITE_URL;?>/admin/talentadmin/getcities',
					data: dataString,
					cache: false,
					success: function(html) {
						$('<option>').val("").text("Select City").appendTo($("#city"));
						$.each(html, function(key, value) {              
							$('<option>').val(key).text(value).appendTo($("#city"));
						});
					} 
				});
			}	
		});
	});
</script>
