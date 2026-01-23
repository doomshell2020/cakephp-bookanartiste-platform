<form action="<?php echo $paypalURL; ?>" method="post" id="payment_form">
  <!-- Identify your business so that you can collect the payments. -->
  <input type="hidden" name="business" value="<?php echo $paypalID; ?>">

  <!-- Specify URLs -->
  <input type='hidden' name='cancel_return' value='<?php echo $cancel_return; ?>'>
  <input type='hidden' name='return' value='<?php echo $return; ?>'>
  <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>" />
  <input type="hidden" name="paymentaction" value="<?php echo $paymentaction; ?>" />
  <!-- Specify a Buy Now button. -->
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="upload" value="1" />


  <!-- Specify details about the item that buyers will purchase. -->
  <input type="hidden" name="item_name" value="<?php echo $package_name; ?>">
  <input type="hidden" name="item_number" value="<?php echo $package_id; ?>">
  <input type="hidden" name="quantity" value="1" />
  <input type="hidden" name="amount" value="<?php echo $package_price; ?>">



  <input type="hidden" name="first_name" value="<?php echo $user_data['user_name'] ?>" />
  <input type="hidden" name="last_name" value="" />
  <input type="hidden" name="address1" value="" />

  <input type="hidden" name="city" value="" />
  <input type="hidden" name="zip" value="" />
  <input type="hidden" name="country" value="India" />
  <input type="hidden" name="address_override" value="0" />
  <input type="hidden" name="email" value="<?php echo $user_data['email'] ?>" />

  <input type="hidden" name="currency_code" value="USD">



  <!-- Display the payment button. -->
  <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
  <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
</form>

<script type="text/javascript">
  //document.getElementById('payment_form').submit();
</script>