<div class="container detailspopup">
  <h3><?php echo $profile['packname'] ?> Pack  Details</h3>
                                                                                       
  <div class="table-responsive">          
  <table class="table" width="100%">
    <tbody>
    <?php if($profile){   ?>
      <tr>
        <th>Selection of Number of Categories while registering</th>
        <td><?php echo $profile['number_categories'] ?></td>
        </tr>  
        <tr>
        <th>Visibility of personal website</th>
        <td><?php echo ($profile['website_visibility']=='Y')?'Yes':'No'; ?></td>
        </tr> 
        <tr>
        <th>Number of Private Messages to New Individuals per month</th>
        <td><?php echo $profile['private_individual'] ?></td>
        </tr> 
        <tr>
        <th>Access to number to Job Opportunities/Openings</th>
        <td><?php echo $profile['access_job'] ?></td>
        </tr> 
         <tr>
        <th>Number of Job Applications per month</th>
        <td><?php echo $profile['number_job_application'] ?></td>
        </tr> 
      <tr>
        <th>Number of  Searches other Profile</th>
        <td><?php echo $profile['number_search'] ?></td>
        </tr>
        <tr>
        <th>Ad Free Experience</th>
        <td><?php echo ($profile['ads_free']=='Y')?'Yes':'No'; ?></td>
        </tr>
        <tr>
        <th>Privacy Setting Access</th>
        <td><?php echo ($profile['privacy_setting_access']=='Y')?'Yes':'No'; ?></td>
        </tr>
        <tr>
        <th>Access to Advertise</th>
        <td><?php echo ($profile['access_to_ads']=='Y')?'Yes':'No'; ?></td>
        </tr>
        
        <tr>
        <th>Number of Job Alerts per month in inbox</th>
        <td><?php echo $profile['number_of_jobs_alerts'] ?></td>
        </tr>
        
         <tr>
        <th>Number of Search Profile</th>
        <td><?php echo $profile['search_of_other_profile'] ?></td>
        </tr>
        
          <tr>
        <th>Number of Jobs</th>
        <td><?php echo $profile['nubmer_of_jobs'] ?></td>
        </tr>
        
      <?php } else{  ?>
    
        <td colspan="6" align="center">No Date Avaiable !!</td>
      </tr>
      <?php } ?>
      
    </tbody>
  </table>
  </div>
</div>
