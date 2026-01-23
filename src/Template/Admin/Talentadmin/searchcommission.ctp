<?php 
      $counter = 1;

    //pr($talents); die;

      if(isset($talents) && !empty($talents)){ 
    foreach($talents as $admin){   //pr($admin); 

      $talent_admin_id=$admin['user_id'];
      ?>
      <tr>
      <!-- <td>
      <?php /*if ($admin['total']>0) { ?>
        <input type="checkbox" class="selectcheck mycheckbox" name="check[]" value="<?php echo $talent_admin_id; ?>">
        <?php }else{ ?>
        <input type="checkbox" disabled="disabled">
          <?php }*/ ?>
        </td> -->
        <td><?php echo $counter;?></td>
        <td>
          <?php if(isset($admin['user_name'])){ echo $admin['user_name'];}else{ echo 'N/A'; } ?>
        </td>
        <td>
          <?php if(isset($admin['email'])){ echo $admin['email'];}else{ echo 'N/A'; } ?>
        </td>

        <td>
          <?php if(isset($admin['talentname'])){ echo $admin['talentname']; }else{ echo 'Admin'; } ?>
        </td>
        <td>
          <?php if(isset($admin['talentemail'])){ echo $admin['talentemail']; }else{ echo 'Admin'; } ?>
        </td>
        <td><?php if(isset($admin['membership_from'])){ echo $admin['membership_from'];}else{ echo 'N/A'; } ?></td>
        <td><?php if(isset($admin['talent_from'])){ echo $admin['talent_from'];}else{ echo 'N/A'; } ?></td>
        <td>
          <?php if ($admin['bank_name'] && $admin['bank_account_no']) { ?>
          <a data-toggle="modal" class='bankdata' href="<?php echo SITE_URL; ?>/admin/talentadmin/bankdetails/<?php echo $talent_admin_id; ?>" style="color:blue;">
            <?php echo "Banking Detail";
        //if(isset($admin['commissionearned'])){ echo round($admin['commissionearned'],2);}else{ echo 'N/A'; } ?>
      </a>
      <?php }else{
        echo "N/A";
      } ?></td>
      <td>
      <?php 
      if(isset($admin['total']) >0){ 
          echo round($admin['total'],2);
        }else if(isset($admin['total']) < 1){ 
          echo 'N/A'; 
        }else{ 
          echo 'N/A'; 
        } ?>
        </td>
      <td>
        <?php if ($admin['total'] > 0) {
         
        echo $this->Html->link('Transaction', [
         'action' => 'transcations',
         $admin['user_id']
         ],['class'=>'btn btn-primary']); 
         ?>

         <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminid('<?php echo $talent_admin_id;?>','<?php echo round($admin['total'],2);?>')">
          <button class="btn btn-success">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Update Payout 
          </button></a>
          <?php }else{ ?>
            <button class="btn btn">
            <i class="fa fa-minus" aria-hidden="true"></i>
            No Earnings
          </button>
            <?php } ?>
      <?php /*
      echo $this->Html->link('Delete', [
          'action' => 'delete',
          $admin['id']
         ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); */ ?>
         <br>

       </td>
     </tr>

     <script>
       $('.bankdata<?php echo $counter; ?>').click(function(e){
        e.preventDefault();
        $('#globalModal<?php echo $counter; ?>').modal('show').find('.modal-body').load($(this).attr('href'));
      });

    </script>
    <?php $counter++;} }



    else{ ?>
    <tr>
      <td colspan="11" align="center">NO Data Available</td>
    </tr>
    <?php } ?>

     <script>
       $('.bankdata').click(function(e){
        e.preventDefault();
        $('#globalModal').modal('show').find('.modal-body').load($(this).attr('href'));
      });

    </script>