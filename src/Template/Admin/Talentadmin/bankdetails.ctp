<?php foreach ($talents as $key => $bankdetail) { ?>

        <h4 class="text-center">Bank Details Of <?php  echo  ucfirst($bankdetail['user_name']); ?></h4>
        <div>
          <h4>Bank Name: <small> <?php echo $bankdetail['bank_name']; ?></small></h4>
          <h4>Bank Account No.: <small><?php echo $bankdetail['bank_account_no']; ?></small></h4>
          <h4>Bank Branch Address: <small><?php echo $bankdetail['bank_branch_add']; ?></small></h4>
          <h4>Country: <small><?php echo $bankdetail['country']; ?></small></h4>
          <h4>State: <small><?php echo $bankdetail['state']; ?></small></h4>
          <h4>City: <small><?php echo $bankdetail['city']; ?></small></h4>
          <h4>Swift Code: <small><?php echo $bankdetail['swift_code']; ?></small></h4>
          <h4>IBAN Number: <small><?php echo $bankdetail['iban_number']; ?></small></h4>
          <h4>BSB Code: <small><?php echo $bankdetail['bsb_code']; ?></small></h4>
          <h4>IFSC Code: <small><?php echo $bankdetail['ifsc_code']; ?></small></h4>
          <h4>Payment Getway: <small><?php echo $bankdetail['payment_getway']; ?></small></h4>
          <h4>important Information: <small><?php echo $bankdetail['important_info']; ?></small></h4>

        </div>
      
<?php } ?>