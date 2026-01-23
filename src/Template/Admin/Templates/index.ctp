 <!-- Content Wrapper. Contains page content -->
 
 
<script>
$(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalModals").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    });
</script>
 
 
 
  <div class="content-wrapper">
   
    <section class="content-header">
      <h1>
       Template Manager
       
       
      </h1>
    <ol class="breadcrumb">
		<li><a href="<?php echo SITE_URL; ?>admin/tattoo"><i class="fa fa-home"></i>Home</a></li>
<li><a href="#">Template  Manager</a></li>


	      </ol> 
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
					<?php echo $this->Flash->render(); ?>
<!--<h3 class="box-title">Search</h3> -->
				<a href="<?php echo SITE_URL; ?>/admin/templates/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add </button></a> 

            </div>
            <!-- /.box-header -->

            <div class="box-body">
				</div>	</div>	</div>
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Template List</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="example" width="100%"   class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                     <th>Title</th>
                     <th>Subject</th>
                     <th>Format</th>	
                    <th>Status</th>	
                    <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['classes']['page'];
		$limit = $this->request->params['paging']['classes']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($templatesdata) && !empty($templatesdata)){ 
		foreach($templatesdata as $work){
		?>
                <tr>
                  <td><?php echo $counter;?></td>	 
 <td><?php if(isset($work['title'])){ echo ucfirst($work['title']);}else{ echo 'N/A';}?></td>                
 <td><?php if(isset($work['subject'])){ echo ucfirst($work['subject']);}else{ echo 'N/A';}?></td>                
<td><a class="globalModals" href="<?php echo SITE_URL;?>/admin/templates/description/<?php echo $work['id'] ?>" data-target="#globalModal" data-toggle="modal"> View </td>
				       <td><?php if($work['status']=='Y'){ 
			echo $this->Html->link('ACTIVE', [
			    'action' => 'status',
			    $work['id'],
			     $work['status']	
			],['class'=>'label label-success']);
			
			 }else{ 
				echo $this->Html->link('DEACTIVE', [
			    'action' => 'status',
			    $work['id'],
			     $work['status']
			],['class'=>'label label-primary']);
				
			 } ?>
		</td>
           
                      <td>

                   <a href="<?php echo ADMIN_URL;?>templates/delete/<?= 
                $work['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
                <?php
                echo $this->Html->link('Edit', [
                'action' => 'add',
                $work->id
                ],['class'=>'btn btn-primary']); ?>
                <br>

		  </td>
		
                </tr>
		<?php $counter++;} }else{?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
            
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

  
