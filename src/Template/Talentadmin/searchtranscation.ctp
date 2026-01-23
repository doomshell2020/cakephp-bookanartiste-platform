<?php 
		$counter = 1;
		if(isset($transcations) && !empty($transcations)){ 
		//pr($transcations); die;
		foreach($transcations as $transcationsdata){ //pr($transcationsdata); 
			//$transaction=$this->Comman->referreduserpurches($transcationsdata['transaction_id']);
			//pr($transaction); 
			$payoutdate=date('d-M-Y',strtotime($transcationsdata['paid_date']));
			if ($transcationsdata['description']=='PAR') {
              $packtype="Post a Requirement";
            }elseif ($transcationsdata['description']=='PP') {
              $packtype="Profile Package";
            }elseif ($transcationsdata['description']=='RP') {
              $packtype="Recruiter Package";
            }elseif ($transcationsdata['description']=='PG') {
              $packtype="Ping";
            }elseif ($transcationsdata['description']=='PQ') {
              $packtype="Paid Quote Sent";
            }elseif ($transcationsdata['description']=='AQ') {
              $packtype="Ask for Quote";
            }elseif ($transcationsdata['description']=='PA') {
              $packtype="Profile Advertisement";
            }elseif ($transcationsdata['description']=='JA') {
              $packtype="Job Advertisement";
            }elseif ($transcationsdata['description']=='BNR') {
              $packtype="Banner";
            }elseif ($transcationsdata['description']=='FJ') {
              $packtype="Feature Job";
            }elseif ($transcationsdata['description']=='FP') {
              $packtype="Feature Profile";
            }
		?>
		<tr>
		    <td><?php echo $counter; ?></td>
		    <td><?php if($transcationsdata['user']['profile']['name'])
		    	{ 
		    		echo $transcationsdata['user']['profile']['name'];
		    	}
		    	elseif($transcationsdata['user']['user_name'])
		    	{ 
		    		echo $transcationsdata['user']['user_name'];
		    	}
		    	else
		    	{ 
		    		echo '-'; 
		    	} ?>
		    </td>

		    <td><?php if(isset($transcationsdata['user']['email'])){ 
		    	echo $transcationsdata['user']['email'];
		    }else{
		    	 echo '-'; 
		    } ?>
		    </td>

		    <td><?php if ($transcationsdata['paid_date']) {
		    	echo "INV-".$transcationsdata['description']."-".$payoutdate."-".$transcationsdata['id'];
			}else{
				echo "-";
			}
		     ?></td> 
		     <td><?php if(isset($transcationsdata['created_date']))
		     { 
		     	echo date('M d, Y, H:i A',strtotime($transcationsdata['created_date'])); 
		     	}else{ 
		     		echo '-'; 
		     	} ?>
		    </td>

		    <td>
		    <?php 
		    	if($transcationsdata['transcation']['subscription'])
		    	{ 
		    		$namepack=$transcationsdata['transcation']['subscription']['profilepack']['name'];

		    		if ($transcationsdata['transcation']['subscription']['package_type']=='PR') {
		    			echo $namepack." Profile Package (01 units)";
		    		}
		    		elseif ($transcationsdata['transcation']['subscription']['package_type']=='RC') {
		    			echo $namepack." Recruiter Package (01 units)";
		    		}
		    		elseif ($transcationsdata['transcation']['subscription']['package_type']=='RE') {
		    			echo $namepack." Requirement Package (01 units)";
		    		}
		    	}
		    	elseif($transcationsdata['transcation'])
		    	{ 
		    		echo $packtype." (".$transcationsdata['transcation']['number_of_days']." Days)";
		    	}
		    	else{ 
		    		echo '-'; 
		    	} 
		    ?>
		    	
		    </td>

		    <td>
		    <?php if($transcationsdata['amount']>0)
		    { 
		    	echo "$".$transcationsdata['amount'];
		    }else{
		    	echo '-'; 
		    } ?>
		    </td>
		    <td>
		    <?php if($transcationsdata['payout_amount']>0)
		    { ?>
		    <button class="btn btn-success">
		    <?php echo "$".$transcationsdata['payout_amount']." Received"; ?>
		    </button>
		    <?php }else{ 
		    	echo '-'; 
		    } ?>
		    
		    </td>
		</tr>
		<?php $counter++;

		$total_tranc = $total_tranc+$transcationsdata['transcation_amount'];
		$total_comm = $total_comm+$transcationsdata['amount'];
		$total_payout = $total_payout+$transcationsdata['payout_amount'];
		} 
		?>
		
                
		<tr>
		<td></td>
		<td><b>Total</b></td>
		<td></td>
		<td></td>
		<td></td>		
		<td></td>
		<td><b><?php  echo "$".$total_comm; ?></b></td>
		<td><b><?php  echo "$".$total_payout; ?></b></td>
                </tr>
		
		<?php 
		
		}
     else{ ?>
		<tr>
		<td colspan="11" align="center">NO Data Available</td>
		</tr>
		<?php } ?>	