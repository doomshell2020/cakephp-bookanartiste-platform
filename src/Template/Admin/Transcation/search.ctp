<?php 
      $counter=1;
      if(isset($transcation) && !empty($transcation)){ 
       foreach($transcation as $transcationdata){   
        $crdate=date("d-M-Y",strtotime($transcationdata['created']));
                          // $packagedetails = $this->Comman->packagedetails($transcationdata['package_type'],$transcationdata['package_id']);
                          // pr($packagedetails);
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
           <?php echo $crdate;  ?>
         </td>
         <td><?php echo $transcationdata['transcation_id'];  ?></td>

         <td>
         <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $transcationdata['id']; ?>">
         <?php echo "INV-".$transcationdata['description']."-".$crdate."-".$transcationdata['id']; ?>
         </a>
         </td>


          <td><?php echo $transcationdata['payment_method'];  ?></td>
          <td><?php echo "$".$transcationdata['amount'];  ?></td>
          <td><a data-toggle="modal" class='data' href="<?php echo ADMIN_URL ?>transcation/details/<?php echo $transcationdata['id']; ?>" style="color:blue;">Details</a></td>
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
     
     <!-- Daynamic modal -->
     <div id="myModal" class="modal fade">
       <div class="modal-dialog">
         
        <div class="modal-content">
         <div class="modal-body"></div>
       </div>
       <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->

   </div>
   <!-- /.modal -->
   


   <script>
     $('.order_details').click(function(e){
      e.preventDefault();
      $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });

  </script>

  <script>
   $('.performance').click(function(e){
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });

</script>

<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.data').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

