
      <?php 
      $counter=1;
      if(isset($talent) && !empty($talent)){ 
       foreach($talent as $talentdata){   //pr($talentdata); ?>
       <tr>
         <td><?php echo $counter;?></td>
         <td>

          <a data-toggle="modal" class='data' href="<?php echo ADMIN_URL ?>profile/details/<?php echo $talentdata['id']; ?>" style="color:blue;"><?php echo $talentdata['user_name']; ?></a>
        </td>
        <td>
         <?php if ($talentdata['profile']['phone']) {
          echo "+".$talentdata['profile']['phonecode']."-".$talentdata['profile']['phone'];
         }else{
          echo "--";
         } ?>
       </td>
       <td><?php if($talentdata['profile']['gender']=="m"){echo "Male";}else if($talentdata['profile']['gender']=="f"){echo"Female";} else{echo "other"; }  ?></td>
       <td>
         <a class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/audio/<?php echo $talentdata['id']; ?>">View Audio</a>
         <a  class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/video/<?php echo $talentdata['id']; ?>">View Video</a>
         <a  class="admin_anchors" href="<?php echo SITE_URL ?>/admin/profile/gallery/<?php echo $talentdata['id'];  ?>">View Images</a>
       </td>
       <td>
         <a data-toggle="modal" class='order_details' href="<?php echo ADMIN_URL?>profile/professiondata/<?php echo $talentdata['id']; ?>" >Profession</a>
         <br>
         <a  data-toggle="modal" class='performance' href="<?php echo ADMIN_URL?>profile/performancedata/<?php echo $talentdata['id']; ?>">Performance</a>
         <br>

         <a data-toggle="modal" class='skill'  href="<?php echo ADMIN_URL?>profile/skill/<?php echo $talentdata['id']; ?>">Skill</a>
         </td>

         <td>
          <?php
          if(!empty($talentdata['profile']['currency_id'])){
            $var=$this->Comman->currencyname($talentdata['profile']['currency_id']);
            //pr($var);
            echo $var['currencycode']." ".$var['symbol'];
          }else{
            echo "--"; 
          }          
            
          ?>
      </td>

         <td>
           <?php echo date('d-M-Y',strtotime($talentdata['created'])); ?>
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

      <?php 
      $currentdate=date('Y-m-d H:m:s');
      $expiredate=date('Y-m-d H:m:s',strtotime($talentdata['featured_expiry']));
      ?>

      <?php if($expiredate>$currentdate  ){  ?>
      <a href="<?php echo SITE_URL; ?>/admin/profile/setdefult/<?php echo $talentdata['id']?>/N"><img src="<?php echo SITE_URL; ?>/yf.png" style="height:35px "/></a>
      <?php  } else{ ?>
      <a href="<?php echo SITE_URL; ?>/admin/profile/setdefult/<?php echo $talentdata['id']?>/Y"><img src="<?php echo SITE_URL; ?>/nof.png" style="height:35px "/></a>
      <?php   } ?>

    </td>

    <td>
      <a href="<?php echo ADMIN_URL;?>profile/delete/<?= 
       $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to delete this')" ><img src="<?php  echo SITE_URL; ?>/img/del.png"></a>
       <br>
       <?php if($talentdata['is_talent_admin']=='N'){ ?>      
       <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/maketalentadmin/<?= 
         $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to make this user talent admin')" >Make Talent Admin</a>
         <?php }else{ ?>
         <a title="Make Talent Admin" href="<?php echo ADMIN_URL;?>talentadmin/removetalentadmin/<?= 
           $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from talent admin')" >Remove Talent Admin</a>
           <?php } ?>

           <br>
           <?php if($talentdata['is_content_admin']=='N'){ ?>      
           <a title="Make Content Admin" href="<?php echo ADMIN_URL;?>contentadmin/makecontentadmin/<?= 
             $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to make this user content admin')" >Make Content Admin</a>
             <?php }else{ ?>
             <a title="Make Content Admin" href="<?php echo ADMIN_URL;?>contentadmin/removecontentadmin/<?= 
               $talentdata['id']?>" onClick="javascript:return confirm('Are you sure do you want to remove this user from content admin')" >Remove Content Admin</a>
               <?php } ?>

             </td>
           </tr>
           <?php $counter++;} }else{ ?>
           <tr>
             <td colspan="11" align="center">No Data Available</td>
           </tr>
           <?php } ?> 