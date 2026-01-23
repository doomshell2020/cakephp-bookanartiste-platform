<?php 
      $counter=1;
      if(isset($subscription) && !empty($subscription)){ 
       foreach($subscription as $subscriptiondata){   

         $packagedetails = $this->Comman->packagedetails($subscriptiondata['package_type'],$subscriptiondata['package_id']);
                          // pr($packagedetails);
         ?>
         <tr>
           <td><?php echo $counter;?></td>
           <td>

            <!-- <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL ?>profile/details/<?php //echo $subscriptiondata['user_id']; ?>" style="color:blue;"> -->
            <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $subscriptiondata['user_id']; ?>" target="_blank" style="color:blue;">
            <?php echo ($subscriptiondata['user']['user_name']) ? $subscriptiondata['user']['user_name'] : "N/A"; ?></a>
          </td>
          <td>
           <?php if($subscriptiondata['package_type']=='PR'){echo "Profile";}elseif($subscriptiondata['package_type']=='RC'){echo "Recruiter";}elseif($subscriptiondata['package_type']=='RE'){echo "Requirement";}else{} ?>
         </td>
         <td>
         <?php 
         if ($packagedetails['title']) {
            echo $packagedetails['title'];  
         }else{
            echo $packagedetails['name'];  
         }
         ?></td>
         <td>
          <?php echo date("d M Y h:i a",strtotime($subscriptiondata['subscription_date']));  ?>
        </td>
        <td>
         <?php echo date("d M Y h:i a",strtotime($subscriptiondata['expiry_date']));  ?>
       </td>
       <td>
         <?php 
         $expriydate=date("Y-m-d",strtotime($subscriptiondata['expiry_date']));
         $curdate=date("Y-m-d");
         if($expriydate >= $curdate){?>
         <a data-toggle="modal" class='label label-success' href="Javascript:void(0)" style="color:blue;">
           Active</a>
           <?php
         }else
         { ?>
         <a data-toggle="modal" class='label label-primary' href="Javascript:void(0)" style="color:blue;">
           Expired</a>
           <?php
         }
         ?>
       </td>
     </tr>
     <?php $counter++;} }else{ ?>
     <tr>
       <td colspan="11" align="center">No Data Available</td>
     </tr>
     <?php } ?>