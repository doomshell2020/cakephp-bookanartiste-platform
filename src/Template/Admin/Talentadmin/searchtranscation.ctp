<?php 
                    $counter = 1;
                    if(isset($transcations) && !empty($transcations)){ 
    //pr($transcations); die;
                      foreach($transcations as $transcationsdata){
                        if ($transcationsdata['description']=='PAR') {
                          $packtype="Post a Requirement";
                        }elseif ($transcationsdata['description']=='PP') {
                          $packtype="Profile Package";
                        }elseif ($transcationsdata['description']=='RP') {
                          $packtype="Recruiter Package";
                        }elseif ($transcationsdata['description']=='PG') {
                          $packtype="Ping";
                        }elseif ($transcationsdata['description']=='PQ') {
                          $packtype="Paid Quote Sent";
                        }elseif ($transcationsdata['description']=='AQ') {
                          $packtype="Ask for Quote";
                        }elseif ($transcationsdata['description']=='PA') {
                          $packtype="Profile Advertisement";
                        }elseif ($transcationsdata['description']=='JA') {
                          $packtype="Job Advertisement";
                        }elseif ($transcationsdata['description']=='BNR') {
                          $packtype="Banner";
                        }elseif ($transcationsdata['description']=='FJ') {
                          $packtype="Feature Job";
                        }elseif ($transcationsdata['description']=='FP') {
                          $packtype="Feature Profile";
                        }
                        ?>
                        <tr>
                          <td>
                          <?php if($transcationsdata['payout_amount']==0){ ?>
                            <input type="checkbox" class="selectcheck mycheckbox" name="check[]" value="<?php echo $transcationsdata['id']; ?>">
                            <?php }else{ ?>
                            <input type="checkbox" disabled="disabled">
                              <?php } ?>
                          </td>
                          <td><?php echo $counter; ?></td>
                          <td><?php echo $transcationsdata['transaction_id']; ?></td>
                          <td><?php if(isset($transcationsdata['created_date'])){ echo $transcationsdata['created_date']; }else{ echo '-'; } ?></td>
                          <td><?php if(isset($transcationsdata['description'])){ echo $packtype;}else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']>0){ echo "$".$transcationsdata['payout_amount'];}else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']<1){ echo "$".$transcationsdata['amount'];}else{ echo '-'; } ?></td>
                          <td><?php if(isset($transcationsdata['paid_date'])){ echo $transcationsdata['paid_date']; }else{ echo '-'; } ?></td>
                          <td><?php if($transcationsdata['payout_amount']>0){ ?>
                            
                           <a href="Javascript:void(0)" class="payout" onclick="assigntalentadminids('<?php echo $transcationsdata['id']; ?>','<?php echo $transcationsdata['write_notes']; ?>')">
                           <button  class="btn btn-primary">
                           Paid</button>
                          </a>
                          <?php }else{ ?>
                          <a href="<?php echo SITE_URL ?>/admin/talentadmin/payselected/<?php echo $transcationsdata['id']; ?>" class="quiks">
                            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                              Update Payout 
                            </button>
                          </a>
                          <?php } ?>
                          </td>
                          

                        </tr>
                        <?php $counter++;
    //$total_tranc = $total_tranc+$transcationsdata['transcation_amount'];
                        $total_comm = $total_comm+$transcationsdata['payout_amount'];

                      } 
                      ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>

                      <tr>
                        <td></td>
                        <td><b>Total</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?php  echo "$".$total_comm; ?></b></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php 

                    }
                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">NO Data Available</td>
                    </tr>
                    <?php } ?>  

<script>
  function assigntalentadminid(talent_admin_id,note)
  {
   $('#talent_admin_id').val(talent_admin_id);
   $('#wrnote').val(note);
 }

 $('.payout').click(function(e){
   e.preventDefault();
   $('#myalbum-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
 });
</script>

 <script>
    $('.quiks').click(function(e){ 
      e.preventDefault();
      $('#myModals').modal('show').find('.modal-body').load($(this).attr('href'));
    });
  </script>