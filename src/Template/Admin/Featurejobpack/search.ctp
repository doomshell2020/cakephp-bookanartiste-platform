<?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
                  foreach($Job as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['feature_job_date']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['expiredate']));
                    $currentdate=date('Y-m-d H:m:s');
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                      <td><?php echo $counter;?></td>
                      <td>
                       <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $admin['id']; ?>" target="_blank"><?php echo $admin['title']; ?></a>
                       </td>
                       <td>
                        <?php // if(isset($admin->user->user_name)){ echo ucfirst($admin->user->user_name); }else{ echo 'N/A'; } ?>
                        <?php if(isset($admin->user->user_name)){ ?>
                       <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank"><?php echo ucfirst($admin->user->user_name); }else{ echo 'N/A'; } ?></a>
                      </td>
                      <td><?php echo $admin['user']['email']; ?></td>
                      <td><?php if($admin['feature_job_date']){ echo $featstart; }else{ echo "N/A"; } ?></td>
                      <td><?php if($admin['expiredate']){ echo $expiredate; }else{ echo "N/A"; } ?></td>                      
                      <td>
                        <?php 
                          echo $admin['feature_job_days']." Days";
                         ?> 
                      </td>
                      <td>
                        <?php if ($admin['featuredjob']) {
                          echo "$".$admin['feature_job_days']*$admin['featuredjob']['price'];
                          }else{
                          echo "0";
                          }
                        ?> 
                      </td>
                      <td>
                        
                        <span class="label label-success">
                          <?php if($admin['featured']=='Y' && $expiredate > $currentdate){ echo "Featured till ".date('M d,Y',strtotime($expiredate)); }else{ echo "N/A"; } ?>
                        </span>
                      </td>
                      
                     
                    </tr>
                    <?php $counter++;} }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">No Featured Jobs Available.
                      </td>
                    </tr>
                    <?php } ?>