 <?php
  $counter = 1;
  if (isset($contentadmin) && !empty($contentadmin)) {
    foreach ($contentadmin as $admin) {
  ?>
     <tr>
       <td><?php echo $counter; ?></td>
       <td>
         <?php if (isset($admin['name'])) {
            echo $admin['name'];
          } else {
            echo 'N/A';
          } ?>
         </a>
       </td>
       <td><?php if (isset($admin['email'])) {
              echo $admin['email'];
            } else {
              echo 'N/A';
            } ?></td>

       <?php $var = $this->Comman->referuserno($admin['email']); //pr($var); 
        ?>
       <td>
         <?php
          $user_exist = $this->Comman->checkuserexist($admin['email']);
          //pr($user_exist);
          if (!empty($user_exist['id'])) {
            $referphone = $this->Comman->profilphone($user_exist['id']);
            //pr($referphone);
            if ($referphone['phone']) {
              if (strpos($referphone['phone'], '+') !== false) {
                echo $referphone['phone'];
              } else {
                echo '+' . $referphone['phonecode'] . '-' . $referphone['phone'];
              }
              if (!empty($referphone['altnumber'])) {
                $removespace = str_replace(' ', '', $referphone['altnumber']);
                $altphone = explode(",", $removespace);
                foreach ($altphone as $altphonevalue) {
                  if (strpos($altphonevalue, '+') !== false) {
                    echo ", " . $altphonevalue;
                  } else {
                    echo ", +" . $referphone['phonecode'] . "-" . $altphonevalue;
                  }
                }
              } else {
                echo 'N/A';
              }
            } else {
              echo $admin['mobile'];
            }
          } else {
            if (empty($var['phone'])) {
              if (isset($admin['mobile'])) {
                echo $admin['mobile'];
              } else {
                echo 'N/A';
              }
            } else {
              echo $var['country']['cntcode'] . "-" . $var['phone'];
            }
          }
          ?>

       </td>
       <td><?php if (isset($admin['created'])) {
              echo date('M d, Y', strtotime($admin['created']));
            } else {
              echo 'N/A';
            } ?> </td>

       <td>
         <?php $transaction = $this->Comman->transactions($user_exist['id']); //pr($transaction); 
          ?>
         <?php if (!empty($transaction['sum'])) {
            echo number_format($transaction['sum'], 2);
          } else {
            echo "No Transactions";
          } ?>
       </td>

       <td>
         <?php $lasttransaction = $this->Comman->lasttransaction($user_exist['id']); //pr($transaction); 
          ?>
         <?php if (!empty($lasttransaction['created'])) {
            echo date("d-M-Y h:i:s A", strtotime($lasttransaction['created']));
          } else {
            echo "-";
          } ?>
       </td>

       <td><?php if ($admin['status'] == 'Y') { ?>
           <a href="Javascript:void(0)" class="label label-success">Registered</a>
         <?php } else { ?>
           <a href="Javascript:void(0)" class="label label-primary">Not Registered</a>

           <?php
              echo $this->Html->link('Delete', [
                'action' => 'referdelete',
                $admin->id
              ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>

         <?php } ?>
         <script>
           //  function confirmFunction(){
           //    var name = '<?php echo $admin['name']; ?>';
           //    return confirm("Are you sure you want to delete "+name);
           //  }
         </script>
       </td>
     </tr>
     </td>
     </tr>
   <?php $counter++;
    }
  } else { ?>
   <tr>
     <td colspan="11" align="center">You have not uploaded any profile yet</td>
   </tr>
 <?php } ?>