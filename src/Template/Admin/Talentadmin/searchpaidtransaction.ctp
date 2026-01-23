 <?php 
      $counter = 1;

    //pr($talents); die;

      if(isset($talents) && !empty($talents)){ 
    foreach($talents as $admin){   //pr($admin); 

      $talent_admin_id=$admin['user_id'];
      ?>
      <tr>
      
        <td><?php echo $counter;?></td>
        <td>
          <?php if(isset($admin['talent_admin_name'])){ echo $admin['talent_admin_name'];}else{ echo 'N/A'; } ?>
        </td>
        <td>
          <?php if(isset($admin['talent_admin_email'])){ echo $admin['talent_admin_email'];}else{ echo 'N/A'; } ?>
        </td>


        <td>
          <?php if($admin['talent_creator_id']!=0){ 
            echo $admin['talent_creator_name']; 
          }else{ 
            echo 'Admin'; 
            } ?>
        </td>
        <td>
          <?php if($admin['talent_creator_id']!=0){
           echo $admin['talent_creator_email']; 
         }else{ 
          echo 'Admin'; 
           } ?>
        </td>
        <td><?php if(isset($admin['membership_from'])){ echo date('d-M-Y',strtotime($admin['membership_from'])); }else{ echo 'N/A'; } ?></td>
        <td><?php if(isset($admin['talent_from'])){ echo date('d-M-Y',strtotime($admin['talent_from'])); }else{ echo 'N/A'; } ?></td>
       <td>
          <?php echo $admin['write_notes']; ?>
        </td>
      <td>
       <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminid('<?php echo $admin['id'];?>')">
         <button  class="btn btn-primary">
        <?php if($admin['amount']>0){ echo "$".$admin['amount']; }else{ echo '-'; } ?> Paid</button>
        </a>

       </td>
     </tr>

    <?php $counter++;} }



    else{ ?>
    <tr>
      <td colspan="11" align="center">NO Data Available</td>
    </tr>
    <?php } ?> 