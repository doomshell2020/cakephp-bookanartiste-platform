<div class="container detailspopup">
  <h3>Profession Details</h3>
                                                                                       
  <div class="table-responsive">          
  <table class="table" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Profile</th>
        <th>Designation</th>
        <th>Agency Name</th>
        <th>Manager</th>
        <!-- <th>Agency url</th> -->
      </tr>
    </thead>
    <tbody>
    
    <?php if($talentpro){  //pr($talentpro);  ?>
      <tr>
      <td>1</td>
        <td><a href="<?php echo SITE_URL ?>/viewprofile/<?php echo $talentpro['user_id']; ?>" target="_blank" style="color:blue;"><?php echo $talentpro['profile_title']; ?></a></td>
        <?php $designation = $this->Comman->finddesignation($talentpro['user_id']); //pr($designation); ?>
        <td><?php echo  $designation['role']; ?></td>
        <td><?php echo  $talentpro['agency_name']; ?></td>   
        <td><?php echo  $talentpro['talent_manager']; ?></td>
        <!-- <td><?php //echo  $talentpro['agency_link']; ?></td> -->     
      </tr>
      <?php } else{ ?>
      <tr>
        <td colspan="6" align="center">No Date Available !!</td>
      </tr>
      <?php } ?>  
    </tbody>
  </table>
  </div>
</div>