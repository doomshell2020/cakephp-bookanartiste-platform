
<div class="container">
<h3>Package Details</h3>
<?php  if($subscription){ 
$packagedetails = $this->Comman->packagedetails($subscription['package_type'],$subscription['package_id']);
//pr($packagedetails);
?>
  <table class="table table-hover">
    <tbody>
      <tr>
        <td>Package Name</td>
        <td><?php if($subscription['package_type']!="RC"){ echo $packagedetails['name']; }else{ echo $packagedetails['title']; } ?></td>
      </tr>
      <tr>
        <td>Package Type</td>
        <td> <?php if($subscription['package_type']=='PR'){echo "Profile Package";}elseif($subscription['package_type']=='RC'){echo "Recruiter Package";}elseif($subscription['package_type']=='RE'){echo "Requirement Package";}else{} ?></td>
      </tr>

       <tr>
        <td>Subscription Date </td>
        <td><?php echo date("d M Y h:i a",strtotime($subscription['subscription_date']));  ?></td>
     
      </tr>
       <tr>
        <td>Subscription Expiry Date</td>
        <td><?php echo date("d M Y h:i a",strtotime($subscription['expiry_date']));  ?></td>
     
      </tr>
       <tr>
        <td>Subscription Status</td>
        <td><?php echo ($subscription['status']=='Y')?'Active':'In Active'; ?></td>
     
      </tr>
    </tbody>
  </table>
  <?php }elseif($transcation) { //pr($transcation);
    
    if ($transcation['description']=='PAR') {
      $packtype="Post a Requirement";
    }elseif ($transcation['description']=='PG') {
      $packtype="Ping";
    }elseif ($transcation['description']=='PQ') {
      $packtype="Paid Quote Sent";
    }elseif ($transcation['description']=='AQ') {
      $packtype="Ask for Quote";
    }elseif ($transcation['description']=='PA') {
      $packtype="Profile Advertisement";
    }elseif ($transcation['description']=='JA') {
      $packtype="Job Advertisement";
    }elseif ($transcation['description']=='BNR') {
      $packtype="Banner";
    }elseif ($transcation['description']=='FJ') {
      $packtype="Feature Job";
    }elseif ($transcation['description']=='FP') {
      $packtype="Feature Profile";
    }
   ?>
    <table class="table table-hover">
    <tbody>
      <tr>
        <td>Package Type</td>
        <td> 
        <?php if($transcation['description']){echo $packtype; }else{ echo "N/A"; } ?>
        </td>
       
      </tr>

       <tr>
        <td>Number of Days </td>
         <td> <?php if($transcation['number_of_days']){echo $transcation['number_of_days']; }else{ echo "N/A"; } ?></td>
     
      </tr>
       <tr>
        <td>Cost</td>
         <td> <?php if($transcation['amount']){echo "$".round($transcation['amount']/$transcation['number_of_days'],2); }else{ echo "N/A"; } ?></td>
      </tr>
      
    </tbody>
  </table>
  <?php }else{
    echo "No data Available";
    } ?>
</div>
