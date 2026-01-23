
<!----------------------editprofile-strt------------------------>
  <section id="edit_profile">
    <div class="container">
        <?php //pr($typeevent); ?>
      <h2><?php if ($typeevent=='EV'){echo "EVENT"; }else if($typeevent=='RE'){echo "Reminder";}else if($typeevent=='To DO'){echo "EVENT";} ?><span> Calendar</span></h2>
      <div class="row">
          
 <?php echo $this->Flash->render(); ?>
        <div class="tab-content">
        <div class="profile-bg m-top-20">
	   
          <div id="Personal" class="tab-pane fade in active">
			  <div class="clearfix">
	    <div class="pull-right"></div>
	</div>
            <div class="container m-top-60">
   
<table class="table table-hover">
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
    <?php if($typeevent=='EV' || $typeevent=='RE'){ ?><th><strong>To Date</strong></th><?php } ?>
    <?php if($typeevent=='EV'){ ?><th><strong>Event Type</strong></th><?php } ?>
    <th><strong>Title</strong></th>
    <th><strong>Description</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
     <th><strong>Action</strong></th>
 </tr>
 
 <?php if ($event) { ?>
 <?php $i=1 ; foreach($event as $key=>$value){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y H:i", strtotime($value['from_date'])); ?></td>
     <?php if($typeevent=='EV' || $typeevent=='RE'){ ?> <td><?php echo date("M d,Y H:i", strtotime($value['to_date'])); ?></td><?php } ?>
    <?php if($typeevent=='EV'){ ?><td><?php echo $value['eventtype']; ?></td><?php } ?>
    <td><?php echo $value['title']; ?></td>
    <td><?php echo $value['description']; ?></td>
    <td><?php echo $value['location']; ?></td>
    <td><?php echo $value['remark']; ?></td>
    <td>
    <a title="Delete" href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $value['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <!-- <a title="Edit" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $typeevent ?>">Edit</i></a> -->
  <a title="Edit" href="<?php echo SITE_URL; ?>/calendar/edit/<?php echo $value['id']; ?>/<?php echo $typeevent;?>" ><i class="fa fa-pencil" ></i></a>
    </td>

  </tr>
  <?php  $i++; } ?>
  <?php }else{  ?>
 <td colspan="8" style="text-align:center;"><strong><?php  echo "No ";  
  if($typeevent=='EV'){echo "EVENT"; }else if($typeevent=='RE'){echo "Reminder";}else if($typeevent=='To DO'){echo "EVENT";} }
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


<script>
<?php if($this->Flash->render('calendardataget')){  ?>
  $(document).ready(function() { 
     eventdata ='<?php echo $eventid; ?>';
      eventtype = '<?php echo $typeevent ?>';
	messagingurl = '<?php echo SITE_URL; ?>/calendar/edit/'+eventdata+'/'+eventtype;
	$('#addcal').modal('show').find('.modal-body').load(messagingurl);

});
  <?php } ?>
</script>
