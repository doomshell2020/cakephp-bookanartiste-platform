<?php 
            if(isset($nontalent) && !empty($nontalent)){ 
              $counter=1;
                           foreach($nontalent as $talentdata){  //pr($talentdata);

                            ?>
                            <tr>
                              <td><?php echo $counter;?></td>
                              <td>
                                <!-- <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL ?>nontelent/details/<?php //echo $talentdata['profile']['id']; ?>" style="color:blue;"><?php //echo $talentdata['profile']['name']; ?></a> -->
                                <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $talentdata['id']; ?>" target="_blank" style="color:blue;">
                                  <?php if ($talentdata['profile']['name']) {
                                   echo $talentdata['profile']['name'];
                                 }else{
                                   echo $talentdata['user_name'];
                                 }?>
                               </a>

                             </td>

                             <td> <?php if ($talentdata['profile']['phone']) {
                              echo $talentdata['profile']['phonecode']."-".$talentdata['profile']['phone'];
                            }elseif($talentdata['phone']){
                              echo $talentdata['profile']['phonecode']."-".$talentdata['phone'];
                            }else{
                              echo "---";
                            } ?></td>
                            <td> <?php echo $talentdata['email']; ?></td>
                            <td>
                              <?php  echo date('d-M-Y',strtotime($talentdata['created'])); ?>
                            </td>


                            <td><?php if($talentdata['status']=='Y'){ 
                              echo $this->Html->link('Deactivate', [
                               'action' => 'status',
                               $talentdata['id'],
                               $talentdata['status']  
                               ],['class'=>'label label-success']);

                            }else{ 
                              echo $this->Html->link('Activate', [
                               'action' => 'status',
                               $talentdata['id'],
                               $talentdata['status']
                               ],['class'=>'label label-primary']);

                             } ?>
                           </td>
                           <td>
                            <?php if ($talentdata['packfeature']['non_telent_number_of_job_post'] ==0) { ?> <a href="<?php echo ADMIN_URL;?>nontelent/renewfreejob/<?= 
                            $talentdata['id']?>" >Renew Job</a>
                            <?php } ?>

                            <a href="<?php echo ADMIN_URL;?>nontelent/delete/<?= 
                             $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
                             <br>
                             <?php if($talentdata['is_talent_admin']=='N'){ ?>      
                             <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/maketalentadmin/<?= 
                              $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to make this user talent admin')" >Make Talent Admin</a>
                              <?php }else{ ?>
                              <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/removetalentadmin/<?= 
                               $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from talent admin')" >Remove Talent Admin</a>
                               <?php } ?>

                             </td>
                           </tr>
                           <?php $counter++;
                         } }else{ ?>
                         <tr>
                           <td colspan="11" align="center">No Data Available</td>
                         </tr>
                         <?php } ?> 