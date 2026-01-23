 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
           Artiste Manager
      </h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
<li><a href="#"> Artiste Manager</a></li>
</ol> 
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
        url:"<?php echo ADMIN_URL ;?>profile/search"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('url'=>array('controller'=>'products','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


<div class="form-group">
  <div class="col-sm-3">
 <label>Name</label>
  <input type="text" class="form-control" name="name" placeholder="Enter Name">
</div> 

<div class="col-sm-3">
 <label>Email</label>
  <input type="text" class="form-control" name="email" placeholder="Enter Email">
</div> 

<div class="col-sm-3">
 <label>Country</label>
 
   <?php echo $this->Form->input('country',array('class'=>'form-control','placeholder'=>'Country','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'--Select Country--','options'=>$country)); ?>
   
   
        
  
</div> 

  <div class="col-sm-3">
   <label>Status</label>
   <select class="form-control" name="status" >
        <option value="" selected="selected">-Select-</option>
        <option value="Y">Active</option>
        <option value="N">Inactive</option>
  </select>
</div>  





  <div class="col-sm-3">
	  </br>
    <button type="submit" class="btn btn-success">Search</button>
    <button type="reset" class="btn btn-primary">Reset</button>
   
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
            <div class="box-header">
              <h3 class="box-title">List</h3>
            </div>
            <!-- /.box-header -->


            <div class="box-body  table-responsive" >
		 <table id="example1" class="table table-bordered table-striped">
                <thead>
			
			
                
                 <tr>
                    <th>S.no</th>
                           <th>Name</th>
                           <th>Contact Number</th>
                           <th>Sex</th>
                           <th>Gallery</th>
                           <th>Details</th>
                           <th>Status</th>
                           <th width="103px;">Action</th>
                </tr>
                
                
            
                </thead>
                
        <style>
#example2 .pne{ position:relative; overflow:hidden;}
#example2 .pne .p_new{    
width: 87px;
   height: 71px;
   position: absolute;
   background: url(../images/newarrival-icon.PNG) no-repeat;
   z-index: 9999; left:-5px; top:-3px; 
   } 
        </style>        
                <tbody id="example2">
                        <?php 
                        $counter=1;
                           if(isset($talent) && !empty($talent)){ 
                           foreach($talent as $talentdata){    ?>
                        <tr>
                           <td><?php echo $counter;?></td>
                           <td>
                             
                              <a data-toggle="modal" class='data' href="<?php echo ADMIN_URL ?>profile/details/<?php echo $talentdata['id']; ?>" style="color:blue;"><?php echo $talentdata['user_name']; ?></a>
                           </td>
                           <td>
                             <?php echo $talentdata['profile']['phone']; ?>
                           </td>
                           <td><?php if($talentdata['profile']['gender']=="m"){echo "Male";}else if($talentdata['profile']['gender']=="f"){echo"Female";} else{echo "other"; }  ?></td>
                           <td>
                           <a class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/audio/<?php echo $talentdata['id']; ?>">View Audio</a>
                           <a  class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/video/<?php echo $talentdata['id']; ?>">View Video</a>
                           <a  class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/gallery/<?php echo $talentdata['id'];  ?>">View Images</a>
                           </td>
                           <td>
                           <a data-toggle="modal" class='order_details' href="<?php echo ADMIN_URL?>profile/professiondata/<?php echo $talentdata['id']; ?>" >Profession</a>
                                 <br>
                                 <a  data-toggle="modal" class='performance' href="<?php echo ADMIN_URL?>profile/performancedata/<?php echo $talentdata['id']; ?>">Performance</a>
                                 <br>

                                 <a data-toggle="modal" class='skill'  href="<?php echo ADMIN_URL?>profile/skill/<?php echo $talentdata['id']; ?>">Skill</a>
                                 
                           </td>
                           <td><?php if($talentdata['status']=='Y'){ 
                              echo $this->Html->link('Activate', [
                                  'action' => 'status',
                                  $talentdata['id'],
                                   $talentdata['status']	
                              ],['class'=>'label label-success']);
                              
                               }else{ 
                              	echo $this->Html->link('Deactivate', [
                                  'action' => 'status',
                                  $talentdata['id'],
                                   $talentdata['status']
                              ],['class'=>'label label-primary']);
                              	
                               } ?>
                  
                                 
                           </td>
                           <td>
                              <a href="<?php echo ADMIN_URL;?>profile/delete/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
				<br>
                              <?php if($talentdata['is_talent_admin']=='N'){ ?>      
			      <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/maketalentadmin/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to make this user talent admin')" >Make Talent Admin</a>
			     <?php }else{ ?>
			     <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/removetalentadmin/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from talent admin')" >Remove Talent Admin</a>
			     <?php } ?>
				 
				  <br>
                              <?php if($talentdata['is_content_admin']=='N'){ ?>      
			      <a title="Make Content Admin" href="<?php echo ADMIN_URL;?>contentadmin/makecontentadmin/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to make this user content admin')" >Make Content Admin</a>
			     <?php }else{ ?>
			     <a title="Make Content Admin" href="<?php echo ADMIN_URL;?>contentadmin/removecontentadmin/<?= 
                                 $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from content admin')" >Remove Content Admin</a>
			     <?php } ?>
				 
                           </td>
                        </tr>
                        <?php $counter++;} }else{ ?>
                        <tr>
                           <td colspan="11" align="center">No Data Available</td>
                        </tr>
                        <?php } ?>	
                     </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
            <script>
$(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalModals").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    });
    
    
    
    
    
    
</script>
                  <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="loader">
                                <div class="es-spinner">
                                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
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
 $('.order_details').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.performance').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.data').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

