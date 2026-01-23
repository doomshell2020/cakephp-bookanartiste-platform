 <?php 
      $counter=1;
      if(isset($transcation) && !empty($transcation)){ 
       foreach($transcation as $transcationdata){  
       $refid= $transcationdata['user']['ref_by']; 
        //if ($refid>0) {
          $talentrefers=$this->Comman->refersbyuser($refid);
        
        $crdate=date("d-M-Y",strtotime($transcationdata['created']));
        if ($transcationdata['description']=='PAR') 
        {
          $packtype="Post a Requirement";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='PP') 
        {
          $packtype="Profile Package";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='RP') 
        {
          $packtype="Recruiter Package";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='PG') 
        {
          $packtype="Ping";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='PQ') 
        {
          $packtype="Paid Quote Sent";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='AQ') 
        {
          $packtype="Ask for Quote";
          $unit="01 Units";
        }
        elseif ($transcationdata['description']=='PA') 
        {
          $packtype="Profile Advertisement";
          $unit=$transcationdata['number_of_days']."/days";
        }
        elseif ($transcationdata['description']=='JA') 
        {
          $packtype="Job Advertisement";
          $unit=$transcationdata['number_of_days']."/days";
        }
        elseif ($transcationdata['description']=='BNR') 
        {
          $packtype="Banner";
          $unit=$transcationdata['number_of_days']."/days";
        }
        elseif ($transcationdata['description']=='FJ') 
        {
          $packtype="Feature Job";
          $unit=$transcationdata['number_of_days']."/days";
        }
        elseif ($transcationdata['description']=='FP') 
        {
          $packtype="Feature Profile";
          $unit=$transcationdata['number_of_days']."/days";
        }
        else{
          $packtype="N/A";
        }
        ?>
        <tr>
         <td><?php echo $counter;?></td>
         <td>

           <!--  <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL ?>profile/details/<?php //echo $transcationdata['user_id']; ?>" style="color:blue;"> -->
           <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $transcationdata['user_id']; ?>" target="_blank" style="color:blue;">
            <?php echo $transcationdata['user']['user_name']; ?></a>
          </td>
          <td>
            <?php echo $transcationdata['user']['email']; ?>
          </td>
          <td>
            <?php if($transcationdata['user']['skillset']){
            foreach ($transcationdata['user']['skillset'] as $key => $skillval) {
              echo $skillval['skill']['name']."<br>";
            } }else{
             echo "Non-Talent"; 
            }
             ?>
          </td>
          <td>
            <?php if ($transcationdata['user']['profile']['country']) {
            echo "<b>Country</b>: ".$transcationdata['user']['profile']['country']['name']."<br>"; 
            echo "<b>State</b>: ".$transcationdata['user']['profile']['state']['name']."<br>"; 
            echo "<b>City</b>: ".$transcationdata['user']['profile']['city']['name']."<br>"; 
          }else{
            echo "N/A";
           } ?>
          
          </td>
          <td>
           <?php echo $crdate;  ?>
         </td>
         <td>
         <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $transcationdata['id']; ?>/1">
         <?php 
            echo "INV-".$transcationdata['description']."-".$crdate."-".$transcationdata['id']; 
          ?></a>
          </td>
         <td>
            <?php echo $packtype; ?>
         </td>
         <td>
            <?php echo $unit; ?>
         </td>
         

          <td><?php echo $transcationdata['payment_method'];  ?></td>

          <td>
          <?php 
            echo "$".$transcationdata['before_tax_amt']; 
          ?>
          </td>
          <td>
          <?php if ($transcationdata['GST']) {
            $totaltax=$transcationdata['GST'];
            $gst=$transcationdata['before_tax_amt']*$totaltax/100;
            echo "$".$gst;
          }else{
            echo "Not included";
          }
          ?>
          </td>
          <td>
          <?php if ($transcationdata['CGST']) {
            $totaltax=$transcationdata['CGST'];
            $cgst=$transcationdata['before_tax_amt']*$totaltax/100;
            echo "$".$cgst;
          }else{
            echo "Not included";
          }
          ?>
          </td>

          <td>
          <?php if ($transcationdata['SGST']) {
            $totaltax=$transcationdata['SGST'];
            $sgst=$transcationdata['before_tax_amt']*$totaltax/100;
            echo "$".$sgst;
          }else{
            echo "Not included";
          }
          ?>
          </td>
           <td>
          <?php
           
            $totalbill= $transcationdata['amount'];
            echo "$ ".$totalbill; 
          ?>
          </td>
          
          
         <td>
         <?php if (isset($talentrefers)) {
           echo $talentrefers['user_name'];
         }else{
          echo "Self";
         }
         ?>
         </td>
         <td><?php if (isset($talentrefers)) {
           echo $talentrefers['email'];
         }else{
          echo "Self";
         }
         ?></td>
        <td>
           <?php 
           if($transcationdata['status']=='Y'){?>
           <a class='label label-success' href="Javascript:void(0)" style="color:blue;">
             Completed</a>
             <?php
           }else
           { ?>
           <a class='label label-primary' href="Javascript:void(0)" style="color:blue;">
             Failed</a>
             <?php
           }
           ?>
         </td>
       </tr>
       <?php $counter++;} }else{ ?>
       <tr>
         <td colspan="11" align="center">No Data Available</td>
       </tr>
       <?php } ?>	