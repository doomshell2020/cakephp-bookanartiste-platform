<?php $page = $this->request->params['paging']['classes']['page'];
    $limit = $this->request->params['paging']['classes']['perPage'];
    $counter = ($page * $limit) - $limit + 1;
    if(isset($Job) && !empty($Job)){ 
     foreach($Job as $Job){  
      $currentdate=date('Y-m-d H:m:s');
      $lastdate=date('Y-m-d H:m:s',strtotime($Job['last_date_app']));
        $expiredate=date('Y-m-d H:m:s',strtotime($Job['expiredate']));
      ?>
     <tr>
       <td><?php echo $counter;?></td>
       <td>
        <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $Job['id']; ?>" target="_blank"><?php echo $Job['title']; ?></a>
      </td>
      <td>
       <a class="globalModals" href="<?php echo SITE_URL;?>/admin/job/details/<?php echo $Job['id'] ?>" data-target="#globalModal" data-toggle="modal"> View</a>
     </td>
     <td>
       <?php if($Job['continuejob']=='Y'){
          echo "Continuous";
        }else{
          echo "Non continuous";
          } ?>
       <?php //echo $Job['eventtype']['name']; ?>
     </td>
      <td>
       <?php if($Job['Posting_type']){
          echo $Job['Posting_type'];
        }else{
          echo "---";
          } ?>
       <?php //echo $Job['eventtype']['name']; ?>
     </td>
     <td>
     <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $Job['user']['id']; ?>" target="_blank"><?php echo $Job['user']['user_name']; ?></a>
     </td>
     <td>
      <?php echo $Job['user']['email']; ?>
    </td>
    <td>
     <?php if($Job['user']['role_id']=='2'){
        echo "Talent";
     }else{
      echo "Non Talent";
     }
    ?>
   </td>
   <td>
   <?php $jobdetail = $this->Comman->jobdetail($Job['id']); 
   //pr($jobdetail); //die;
    $fromdate= date('Y-m-d',strtotime($jobdetail['ad_date_from'])); 
    $todate= date('Y-m-d',strtotime($jobdetail['ad_date_to'])); 
    $date1 = date_create($fromdate);
    $date2 = date_create($todate);
    $diff = date_diff($date1,$date2);
    $bannerdays=$diff->days;
    if(!empty($bannerdays)){
      echo $bannerdays." Days";
    }else{
      echo "0 Day";
    }
   ?>
    
  </td>
  <td>
  <?php 
      	echo $Job['feature_job_days']." Days";
       ?> 
  </td>

  <td>
  <?php if ($Job['featuredjob']) {
      	echo "$".$Job['feature_job_days']*$Job['featuredjob']['price'];
      }else{
      	echo "0";
      } ?>
  </td>



  <td><?php 
 if ($lastdate>=$currentdate) { ?>
  <span class="label label-success">Active</span>
<?php }else{ ?>
  <span class="label label-primary">Inactive</span>
<?php }
 ?>

    </td>

    <td>

    <?php if($Job['status']=='N' || $lastdate < $currentdate)
      {  ?>
      <!-- <img src="<?php echo SITE_URL; ?>/nof.png" style="height:35px "/> -->
      <?php  
      }elseif($expiredate>$currentdate){  ?>
      <a href="<?php echo SITE_URL; ?>/admin/job/setdefult/<?php echo $Job['id']?>/N"><img src="<?php echo SITE_URL; ?>/yf.png" style="height:35px "/></a>
      <?php  } else{ ?>
      <a href="<?php echo SITE_URL; ?>/admin/job/setdefult/<?php echo $Job['id']?>/Y"><img src="<?php echo SITE_URL; ?>/nof.png" style="height:35px "/></a>
      <?php   } ?>

    </td>
    <td>
    <?php if ($lastdate>=$currentdate) { ?>
    <?php
    if($Job['status']=='Y'){ 

      echo $this->Html->link('Deactivate', [
        'action' => 'status',
        $Job['id'],
        $Job['status']  
        ],['class'=>'label label-success']);

    }else{ 
      echo $this->Html->link('Activate', [
        'action' => 'status',
        $Job['id'],
        $Job['status']
        ],['class'=>'label label-primary']);
     } 
     ?>
     <?php } ?>
     <br>
     <br>
      <a href="<?php echo ADMIN_URL;?>job/delete/<?= 
       $Job['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
        <br>
     <br>

     </td>
   </tr>
   <?php $counter++;} }else{ ?>
   <tr>
     <td colspan="11" align="center">No Data Available</td>
   </tr>
   <?php } ?> 

   

<script>
 $('.globalModals').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>