
<div class="container detailspopup">
  <h3>Performance Details</h3>
                                                                                       
  <div class="table-responsive">   
    
  <table class="table" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Performance_desc</th>
        <th>Setup requirement</th>
        <th>Travel</th>
        <th>Payment_frequency</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
    
    <?php if($fullperfomance){  //pr($fullperfomance); die; ?>
      <tr>
      <td>1</td>
        <td><?php echo  substr($fullperfomance[0]['performance_desc'],0.15); ?></td>
        <td><?php echo  substr($fullperfomance[0]['setup_requirement'],0.15) ?></td>
        <td><?php if ($fullperfomance[0]['opentotravel']) {
          echo  "Yes";
        }else{ echo  "No"; } ?></td>
        <td>
        <?php foreach ($fullperfomance as $key => $value) 
        { if ($key!=0) { ?>
        
        <?php echo  $value['payment_fequency']['name']; ?><br>
       
        <?php 
        } } ?>
         </td>

        <td>
        <?php foreach ($fullperfomance as $keys => $values) 
        { 
          //pr($values); die;
          if ($keys!=0) { ?>
        <?php echo  $values['amount']; ?><br>
        <?php 
        } } ?>
        </td>
      </tr>
      <?php } else{    ?>
      <tr>
        <td colspan="6" align="center">No Date Available !!</td>
      </tr>
      <?php } ?>
      
    </tbody>
  </table>


  </div>
</div>