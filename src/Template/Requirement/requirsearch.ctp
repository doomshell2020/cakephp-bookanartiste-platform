<?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
		              foreach($Job as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['feature_job_date']));
                    $last_date_app=date('Y-m-d H:m:s',strtotime($admin['last_date_app']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['expiredate']));
                    $currntdate=date('Y-m-d H:m:s');
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                      <td><?php //echo $counter; 
                      if ($admin['image']) {
                      ?>
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $admin['image']; ?>">
                        <?php }else{ ?>
                        <img src="<?php echo SITE_URL; ?>/images/job.jpg"/>
                        <?php } ?>
                      </td>
                      <td>
                       <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $admin['id']; ?>" target="_blank"><?php echo $admin['title']; ?></a>
                       </td>
                 
                      <td><?php if($admin['last_date_app']){ echo date('M d,Y',strtotime($last_date_app)); }else{ echo "N/A"; } ?></td>                      
                      <td>
                      <?php 
                        if(isset($admin['requirment_vacancy'])){
                          foreach($admin['requirment_vacancy'] as $skills){
                            //pr($skills); 
                            echo $skills['skill']['name'].'</br>'; 
                          }
                        }
                      ?>
                      </td>
                      <td>
                        <?php 
                          echo $admin['location'];
                          
                        ?> 
                      </td>
                      <td>
                        <span class="label label-success">
                          <?php if($admin['status']=='Y'){ echo "Active"; }else{ echo "Inactive"; } ?>
                        </span>
                      </td>
                      
                      <td>
                        <?php if($expiredate<$currntdate){ 
                          echo $this->Html->link('Make It Featured', [
                            'action' => 'suggestedprofile',
                            $admin->id,
                            ],['class'=>'label label-warning']);

                        }else{ ?>
                        
                        <span class="label label-primary"><?php  echo "Featured"; ?></span>

                        <?php } ?>

                      </td>
                    </tr>
                    <?php $counter++;} }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">You do not have any active jobs. Please 
                      <a href="<?php echo SITE_URL; ?>/jobpost">
                        <button class="btn btn-success">Post A Requirement </button>
                        </a> to Feature it
                      </td>
                    </tr>
                    <?php } ?>