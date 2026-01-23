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
                      <?php if ($admin['status']=='Y') { ?>
                       <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $admin['id']; ?>" target="_blank"><?php echo $admin['title']; ?></a>
                       <?php }else{
                        echo $admin['title'];
                        } ?>
                       </td>
                 
                      <td><?php if($admin['last_date_app']){ echo $last_date_app; }else{ echo "N/A"; } ?></td>                      
                      <td>
                        <?php if ($admin['continuejob']=='Y') {
                          echo "Continuous";
                        }else{
                          echo "Non-Continuous";
                        }
                         ?> 
                      </td>
                      <td>
                        <?php 
                          echo $admin['location'];
                          
                        ?> 
                      </td>
                      <td>
                        <span>
                          <?php if($admin['status']=='Y'){ echo "Active"; }else{ echo "Inactive"; } ?>
                        </span>
                      </td>
                      
                      <td>
                        <?php if($admin['jobadvertpack']=='' || $admin['jobadvertpack']['status']=='N'){ ?>
                         <a href="<?php echo SITE_URL; ?>/package/advertisejob/<?php echo $admin['id']; ?>" class="advrtviews">
                            <span class="label label-success">Select to Advertise</span>
                        </a> 
                        <?php }elseif($admin['jobadvertpack'] || $admin['jobadvertpack']['status']=='Y'){
                            //echo $admin['jobadvertpack']['ad_date_from']."</br>";
                            //echo date('Y-m-d H:i:s');
                        if(date('Y-m-d H:i:s',strtotime($admin['jobadvertpack']['ad_date_from'])) > date('Y-m-d H:i:s')){ ?>
                        <a href="<?php echo SITE_URL; ?>/package/advertised-requirment/<?php echo $admin['jobadvertpack']['id']; ?>" data-toggle="modal" class="serviceview"> 
                            <span class="label label-success">Ad Schedule</span> 
                        </a> 
                        <?php }else{ ?>
                                <span class="label label-success">Advertise Job</span>
                        <?php } ?>
                          
                        
                        <?php }else{  ?>
                            <span class="label label-primary"><?php  echo "Job advertisement published"; ?></span>
                        <?php } ?>

                      </td>
                    </tr>
                    <?php $counter++; } }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">You do not have any active jobs. Please 
                      <a href="<?php echo SITE_URL; ?>/jobpost">
                        <button class="btn btn-success">Post A Requirement </button>
                        </a> to Advertise it.
                      </td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="11" align="center">
                      <a href="<?php echo SITE_URL; ?>/package/advertised-requirment" data-toggle="modal" class="serviceview">
                        <button class=" btn btn-success">View Previous Advertisement of Job</button>
                        </a> 
                      </td>
                    </tr>