
        <?php 
        $counter=1;
        if(isset($banners) && !empty($banners)){ 
          
         foreach($banners as $bannerdata){    //pr($bannerdata);
          $fromdate=date('Y-m-d h:i:s',strtotime($bannerdata['banner_date_from']));
          $todate=date('Y-m-d h:i:s',strtotime($bannerdata['banner_date_to']));
          /*echo $fromdate;*/
          /*$date1 = date_create($fromdate);
          $date2 = date_create($todate);
          $diff = date_diff($date1,$date2);
         $banneramt=$bannerdata['bannerpack']['cost_per_day']*$diff->days;*/
         $banneramt=$bannerdata['amount'];
          
          ?>
         <tr>
           <td><?php echo $counter;?></td>
           <td>
           <a target="_blank" href="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>" style="color:blue;">
            <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>"/>
            </a>
          </td>
          <td> <?php echo $bannerdata['title']; ?></td>
          <td> <?php echo $bannerdata['bannerurl']; ?></td>

          <td><?php echo date("M d Y h:i:sa",strtotime($fromdate)); ?></td>
          <td><?php echo date("M d Y h:i:sa",strtotime($todate)); ?></td>
          <td><?php echo "$".$banneramt; ?></td>
          <td><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bannerdata['user_id']; ?>">
            <?php echo $bannerdata['user']['user_name']; ?>
          </a></td>
          <td><?php echo $bannerdata['user']['email']; ?></td>
          <?php if($bannerdata['auto_decline']==0) {?>
          <td>
            <?php if ($bannerdata['status']=='N' && $bannerdata['banner_status']=='Y'){ ?>
            <?php if($bannerdata['is_approved']==1){ ?>
              <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Approved</a>
              <a  class='label label-warning' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>" >Delete</a>
            <?php }else{ ?>
            <a  class='label label-success' href="<?php echo ADMIN_URL ?>banner/banneramount/<?php echo $bannerdata['id']."/".$banneramt; ?>" style="color:blue;">Approve</a>
            
            <a data-toggle="modal" class='label label-primary  data' href="<?php echo ADMIN_URL ?>banner/reject/<?php echo $bannerdata['id']; ?>" style="color:blue;">Decline</a>
            <?php } ?>

            <?php }elseif($bannerdata['status']=='R'){ ?>
            <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Declined</a>

            <?php }else{ ?>
            <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Approved</a>

            <?php } ?>

            <?php 
            $currenttime = date("Y-m-d h:i:s");  
            if($currenttime > $todate){
                ?>
                    <a  class='label label-warning' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>" >Delete</a>
 <?php
           }
            
            ?>

          </td>
          <?php }else{ ?>
            <td>
            <a data-toggle="modal" class='label label-success' href="#" style="color:blue;">Auto Declined</a>

            <?php 
            $currenttime = date("Y-m-d h:i:s");  
            if($currenttime > $todate){
                ?><br>
                    <a  class='label label-warning' href="<?php echo ADMIN_URL ?>banner/delete/<?php echo $bannerdata['id']; ?>" >Delete</a>
            <?php } ?>

            <br>
            <p><?php echo $bannerdata['decline_reason']; ?></p>
            </td>
          <?php } ?>

        </tr>

        <?php $counter++;} }else{ ?>
        <tr>
         <td colspan="11" align="center">No Data Available</td>
       </tr>
       <?php } ?>	
   
