<?php if ($eventtypename=='VA') { ?>
<?php if ($eventview) { ?>
<div  style="text-align:center;font-weight: bold;font-size: 20px;"> Event </div>
<table class="table table-hover table-bordered">
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
 
 
 <?php $i=1 ; foreach($eventview as $key=>$valueeve){ //pr($value);?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y", strtotime($valueeve['from_date'])); ?></td>
    <td><?php echo date("M d,Y", strtotime($valueeve['to_date'])); ?></td>
   <td><?php echo $valueeve['eventtype']; ?></td>
    <td><?php echo $valueeve['title']; ?></td>
    <td><?php echo $valueeve['description']; ?></td>
    <td><?php echo $valueeve['location']; ?></td>
    <td><?php echo $valueeve['remark']; ?></td>
 <td>
    <a title="Delete" href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $valueeve['id']; ?>"onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <a  data-toggle="modal" title="Edit" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>calendar/calendarlist/<?php echo $valueeve['type'] ?>/<?php echo $valueeve['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </td> 

  </tr>
  <?php  $i++; } ?>
</table>
 <?php  } ?>
 
<?php //-----------Reminder----------// ?>
 <?php if ($eventreminderview) { ?>
<div style="text-align:center;font-weight: bold;font-size: 20px;"> Reminder </div>

<table class="table table-hover table-bordered">
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
  <th><strong>To Date</strong></th>
<th><strong>Reminder Type</strong></th>
    <th><strong>Title</strong></th>
    <th><strong>Description</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
  <th><strong>Action</strong></th>
 </tr>
 

 <?php $i=1 ; foreach($eventreminderview as $key=>$valuerem){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y", strtotime($valuerem['from_date'])); ?></td>
    <td><?php echo date("M d,Y", strtotime($valuerem['to_date'])); ?></td>
    <td><?php echo $valuerem['eventtype']; ?></td>
    <td><?php echo $valuerem['title']; ?></td>
    <td><?php echo $valuerem['description']; ?></td>
    <td><?php echo $valuerem['location']; ?></td>
    <td><?php echo $valuerem['remark']; ?></td>
 <td>
    <a title="Delete" href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $valuerem['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <a  data-toggle="modal" title="Edit" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/calendarlist/<?php echo $valuerem['type'] ?>/<?php echo $valuerem['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </td> 

  </tr>
  <?php  $i++; } ?>
    </table>

  <?php } ?>
<?php //-----------To-Do----------// ?>

 <?php if ($eventtodoview) { ?>
<div  style="text-align:center;font-weight: bold;font-size: 20px;"> ToDo </div>

<table class="table table-hover table-bordered">
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
 
 <?php $i=1 ; foreach($eventtodoview as $key=>$valuetodo){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y", strtotime($valuetodo['from_date'])); ?></td>
    <td><?php echo $valuetodo['eventtype']; ?></td>
    <td><?php echo $valuetodo['title']; ?></td>
    <td><?php echo $valuetodo['description']; ?></td>
    <td><?php echo $valuetodo['location']; ?></td>
    <td><?php echo $valuetodo['remark']; ?></td>
 <td>
    <a  title="Delete" href="<?php echo SITE_URL; ?>calendar/delete/<?php echo $valuetodo['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <a  data-toggle="modal" title="Edit" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/calendarlist/<?php echo $valuetodo['type'] ?>/<?php echo $valuetodo['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </td> 

  </tr>
  <?php  $i++; } ?>
</table>

  <?php } ?>
<?php } else { ?>

<table class="table table-hover table-bordered">
  <tr>
    <th><strong>S.NO</strong></th>
    <th><strong>From Date</th>
    <?php if($eventtypename=='EV' || $eventtypename=='RE'||$eventtypename=='VA'){ ?><th><strong>To Date</strong></th><?php } ?>
    <?php if($eventtypename=='EV' || $eventtypename=='VA'){ ?><th><strong>Event Type</strong></th><?php } ?>
    <th><strong>Title</strong></th>
    <th><strong>Descripation</strong></th>
    <th><strong>Location</strong></th>
    <th><strong>Remark</strong></th>
  <th><strong>Action</strong></th>
 </tr>
 
 <?php if ($event) { ?>
 <?php $i=1 ; foreach($event as $key=>$value){ ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date("M d,Y", strtotime($value['from_date'])); ?></td>
     <?php if($eventtypename=='EV' || $eventtypename=='RE' || $eventtypename=='VA'){ ?> <td><?php if($value['type']=='TD'){ echo "--"; }else{ echo date("M d,Y", strtotime($value['to_date'])); } ?></td><?php } ?>
    <?php if($eventtypename=='EV' || $eventtypename=='VA'){ ?><td><?php echo $value['eventtype']; ?></td><?php } ?>
    <td><?php echo $value['title']; ?></td>
    <td><?php echo $value['description']; ?></td>
    <td><?php echo $value['location']; ?></td>
    <td><?php echo $value['remark']; ?></td>
 <td>
    <a title="Delete" href="<?php echo SITE_URL; ?>/calendar/delete/<?php echo $value['id']; ?>" onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <a  data-toggle="modal" title="Edit" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>/calendar/calendarlist/<?php echo $value['type'] ?>/<?php echo $value['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </td> 

  </tr>
  <?php  $i++; } ?>
  <?php }else{  ?>
 <td colspan="8" style="text-align:center;"><strong><?php  echo "No ";  
  if($eventtypename=='EV'){echo "EVENT"; }else if($eventtypename=='RE'){echo "Reminder";}else if($eventtypename=='To DO'){echo "TO DO";} }
  ?></strong></td>
</table>


<?php } ?>
          