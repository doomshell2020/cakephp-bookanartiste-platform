<?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
                  foreach($Job as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['feature_pro_date']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['featured_expiry']));
                    $currentdate=date('Y-m-d H:m:s');
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                      <td><?php echo $counter;?></td>
                      
                       <td>
                        <?php if(isset($admin->user_name)){ echo ucfirst($admin->user_name); }else{ echo 'N/A'; } ?>
                      </td>
                      <td><?php echo $admin['email']; ?></td>
                      <td><?php if($admin['feature_pro_date']){ echo $featstart; }else{ echo "N/A"; } ?></td>
                      <td><?php if($admin['featured_expiry']){ echo $expiredate; }else{ echo "N/A"; } ?></td>                      
                      <td>
                        <?php 
                          echo $admin['feature_pro_pack_numofday']." Days";
                         ?> 
                      </td>
                      <td>
                        <?php if ($admin['featuredprofile']) {
                          echo "$".$admin['feature_pro_pack_numofday']*$admin['featuredprofile']['price'];
                          }else{
                          echo "0";
                          }
                        ?> 
                      </td>
                      <td>
                        <span class="label label-success">
                          <?php if($expiredate > $currentdate){ echo "Featured"; }else{ echo "N/A"; } ?>
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