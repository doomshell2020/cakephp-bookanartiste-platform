
  <h2>Report Spam Details</h2>
       
<table>
  <tr>
    <th>S.No</th>
    <th>Reason</th>
    <th>Comments</th>
  </tr>
    
    <?php if($talentpro){   
  $i=1; foreach ( $talentpro as $talentrecord ) {
    
  //  pr($talentrecord);
    ?>
      <tr>
      <td><?php echo $i; ?></td>
        <td><?php echo  $talentrecord['reason']; ?></td>
        <td><?php echo  $talentrecord['comments']; ?></td>
       
     
      </tr>
      
      <?php $i++; } ?>
      <?php } else{    ?>
      <tr>
        <td colspan="6" align="center">No Date Avaiable !!</td>
      </tr>
      <?php  } ?>
      
    </tbody>
  </table>

