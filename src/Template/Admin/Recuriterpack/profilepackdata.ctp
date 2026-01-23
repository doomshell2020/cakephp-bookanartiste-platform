
<div class="container detailspopup">
  <h3><?php echo $profile['title'] ?> Pack  Details</h3>                                                                                
  <div class="table-responsive">          
  <table class="table" width="100%">
    <tbody>
    
    <?php if($profile){   ?>
      <tr>

        <th>Number of site recommended profiles after posting a Job</th>
        <td><?php echo $profile['nubmer_of_site'] ?></td>
        </tr>  
        
        <tr>

        <th>Number of contact details access</th>
        <td><?php echo $profile['number_of_contact_details'] ?></td>
        </tr> 
        
        <tr>

        <th>Number of Telent Search</th>
        <td><?php echo $profile['number_of_talent_search'] ?></td>
        </tr> 
        
        
        <tr>

        <th>Multiple Email Login</th>
        <td>

        <?php  if($profile['multipal_email_login']=="Y"){echo "Yes";} else{
          echo "No";
          } ?>

        </td>
        </tr> 
        
         <tr>

        <th>Number of Multiple E Mail id login</th>
        <td><?php echo $profile['number_of_email'] ?></td>
        </tr> 
     
     
 
        
        
      <?php } else{  ?>
    
        <td colspan="6" align="center">No Date Avaiable !!</td>
      </tr>
      <?php } ?>
      
    </tbody>
  </table>
  </div>
</div>
