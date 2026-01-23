<!----------------------editprofile-strt------------------------>
<section id="page_signup">
  <div class="container">
    <div class="row">
      <div class="col-sm-2">
      </div>

      <div class="col-sm-8">
        <div class="signup-popup">
          <h2>Complete your <span>Purchase</span></h2>

          <h4>Package Details</h4>
          <?php
          if ($package_type == 'profilepackage') {
            $propack = "Profile Package";
          } elseif ($package_type == 'requirementpackage') {
            $propack = "Requirement Package";
          } elseif ($package_type == 'recruiterepackage') {
            $propack = "Recruiter Package";
          }
          ?>
          <div class="row">
            <div class="col-sm-6">
              <div>
                <h5>Package Name</h5>
              </div>
              <div class="">
                <?php echo $pcakgeinformation['title'] . " " . $propack; ?>
              </div>

              <div class="">
                <h5>Package Amount</h5>
              </div>
              <div class="">
                $<?php echo $pcakgeinformation['price']; ?>
              </div>
            </div>

            <div class="col-sm-6">
              <div>
                <h5>Total Amount Before Tax: <span><?php echo "$" . $pcakgeinformation['price']; ?> </span></h5>
              </div>
              <?php if ($invoicereceipt) {
                foreach ($invoicereceipt as $key => $value) {
                  $totaltax += $value['tax_percentage'];
              ?>
                  <div class="">
                    <h5>Add: <span><?php echo $value['title'] . "@" . $value['tax_percentage'] . "%"; ?></span></h5>
                  </div>
              <?php }
              } else {
                echo "GST not included";
              } ?>

              <div class="">
                <h5>Total Bill Amount: <span><?php $grandtotal = $pcakgeinformation['price'] + ($pcakgeinformation['price'] * $totaltax / 100);
                                              echo "$" . $grandtotal; ?></span></h5>
              </div>

              <div class="">
                <h5>View Price in Local Currency: <span><a target="_blank" href="https://www.xe.com/currencyconverter/">Click Here</a></span></h5>
              </div>
            </div>

          </div>


          <h4>Payment Information</h4>


          <?php echo $this->Form->create('Package', array('url' => array('controller' => 'Package', 'action' => 'processpayment'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'PackageIndexForm', 'autocomplete' => 'off')); ?>

          <input type="hidden" name="package_type" value="<?php echo $package_type; ?>">
          <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
          <input type="hidden" name="before_tax_amt" value="<?php echo $pcakgeinformation['price']; ?>">
          <input type="hidden" name="package_price" value="<?php echo $grandtotal; ?>">
          <?php if ($invoicereceipt) {
            foreach ($invoicereceipt as $key => $values) { ?>
              <input type="hidden" name="<?php echo $values['title']; ?>" value="<?php echo $values['tax_percentage']; ?>">
          <?php }
          } ?>
          <form class="form-horizontal">
            <div class="form-group">

              <div class="col-sm-6">
                <?php echo $this->Form->input('user_name', array('class' => 'form-control', 'placeholder' => 'Enter Your Name', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'readonly', 'label' => false, 'type' => 'text', 'value' => $this->request->session()->read('Auth.User.user_name'))); ?>
              </div>
              <div class="col-sm-6">
                <?php echo $this->Form->email('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'required' => true, 'readonly', 'autocomplete' => 'off', 'id' => 'username', 'label' => false, 'value' => $this->request->session()->read('Auth.User.email'))); ?>
              </div>
            </div>



            <div class="form-group">

              <div class="col-sm-6">
                <?php echo $this->Form->input('card_name', array('class' => 'form-control', 'placeholder' => 'Name on Card', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
              </div>
              <div class="col-sm-6">
                <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'placeholder' => 'Card Number', 'pattern' => '[0-9 ]*', 'maxlength' => '16', 'min' => '16', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-6">
                <?php echo $this->Form->input('csv_number', array('class' => 'form-control', 'placeholder' => 'CSV', 'pattern' => '[0-9 ]*', 'maxlength' => '3', 'min' => '3', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
              </div>
              <?php
              for ($m = 1; $m <= 12; $m++) {
                $months[] = $m;
              }

              $current_year = date('Y');
              $next_year = $current_year + 10;
              for ($y = $current_year; $y <= $next_year; $y++) {
                $years[] = $y;
              }


              ?>
              <div class="col-sm-3">
                <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Month', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Month', 'options' => $months)); ?>
              </div>
              <div class="col-sm-3">
                <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => 'Expiry Year', 'options' => $years)); ?>
              </div>
            </div>


            <div class="form-group">
              <div class="col-sm-12 text-center"> </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
      </div>

      <div class="col-sm-2">
      </div>
    </div>
  </div>
</section>