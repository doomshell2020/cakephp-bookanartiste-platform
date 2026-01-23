<!----------------------editprofile-strt------------------------>
  <section id="edit_profile">
    <div class="container">
        <?php //pr($typeevent); ?>
      <h2><?php echo "Today's TASK" ?><span> Calendar</span></h2>
      <div class="row">
          
 <?php echo $this->Flash->render(); ?>
        <div class="tab-content">
        <div class="profile-bg m-top-20">
	   
          <div id="Personal" class="tab-pane fade in active">
			  <div class="clearfix">
	    <div class="pull-right"></div>
	</div>
            <div class="container m-top-60">
                 <?php if ($userevent) { ?>
    <div class="pendingstyle">Event</div>
<table class="table table-hover">
   
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
   <th><strong>To Date</strong></th>
   <th><strong>Event Type</strong></th>
    <th><strong>Title</strong></th>
    <th><strong>Description</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
    <th><strong>Action</strong></th>
 </tr>
 

 <?php $i=1 ; foreach($userevent as $key=>$valueevent){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($valueevent['from_date'])); ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($valueevent['to_date'])); ?></td>
    <td><?php echo $valueevent['eventtype']; ?></td>
    <td><?php echo $valueevent['title']; ?></td>
    <td><?php echo $valueevent['description']; ?></td>
    <td><?php echo $valueevent['location']; ?></td>
    <td><?php echo $valueevent['remark']; ?></td>
     <td>
    <a href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $valueevent['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <!-- <a  data-toggle="modal" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $valueevent['id']; ?>/<?php echo $valueevent['type'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
  <a title="Edit" href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $valueevent['id']; ?>/<?php echo $valueevent['type']; ?>" ><i class="fa fa-pencil" ></i></a>
    </td> 
  </tr>
  <?php  $i++; } ?>
  <?php }
  ?></strong></td>
</table>

 <?php if ($reminderevent) { ?>
<div class="pendingstyle">Reminder</div>
<table class="table table-hover">
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
   <th><strong>To Date</strong></th>
   <th><strong>Event Type</strong></th>
    <th><strong>Title</strong></th>
    <th><strong>Descripation</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
    <th><strong>Action</strong></th>
 </tr>
 

 <?php $i=1 ; foreach($reminderevent as $key=>$value){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($value['from_date'])); ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($value['to_date'])); ?></td>
    <td><?php echo $value['eventtype']; ?></td>
    <td><?php echo $value['title']; ?></td>
    <td><?php echo $value['description']; ?></td>
    <td><?php echo $value['location']; ?></td>
    <td><?php echo $value['remark']; ?></td>
     <td>
    <a href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $value['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <!-- <a  data-toggle="modal" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $value['type'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
  <a title="Edit" href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $value['type'];?>" ><i class="fa fa-pencil" ></i></a>
    </td> 
  </tr>
  <?php  $i++; } ?>
  <?php }
  ?></strong></td>
</table>

 <?php if ($todoevent) { ?>
<div class="pendingstyle">To Do</div>
<table class="table table-hover">
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
   <th><strong>Task</strong></th>
    <th><strong>Title</strong></th>
    <th><strong>Descripation</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
    <th><strong>Action</strong></th>
 </tr>
 

 <?php $i=1 ; foreach($todoevent as $key=>$value){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($value['from_date'])); ?></td>
    <td><?php echo $value['eventtype']; ?></td>
    <td><?php echo $value['title']; ?></td>
    <td><?php echo $value['description']; ?></td>
    <td><?php echo $value['location']; ?></td>
    <td><?php echo $value['remark']; ?></td>
     <td>
    <a href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $value['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <!-- <a  data-toggle="modal" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $value['type'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
     <a title="Edit" href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $value['type'];?>" ><i class="fa fa-pencil" ></i></a> 

    </td> 
  </tr>
  <?php  $i++; } ?>
  <?php   
   }
  ?></strong></td>
</table>


            </div>
          </div>
    </div>
        </div>
      </div>
    </div>
  </section>
 <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


</style>
	  
<div id="addcal" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" style="width: 124%;" >
 
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
  $('#addcal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>