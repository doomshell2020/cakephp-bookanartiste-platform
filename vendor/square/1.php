<script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
<script>
    var sqPaymentForm = new SqPaymentForm({
      // Replace this value with your application's ID (available from the merchant dashboard).
      // If you're just testing things out, replace this with your _Sandbox_ application ID,
      // which is also available there.
      //applicationId: 'sandbox-sq0idp-lK20wMyUuYoQM6S66tk16w',
      applicationId: 'sq0idp-ItuZhjieN4WIK9qWWrKhcw',
      inputClass: 'sq-input',
      cardNumber: {
        elementId: 'sq-card-number',
        placeholder: "0000 0000 0000 0000"
      },
      cvv: {
        elementId: 'sq-cvv',
        placeholder: 'CVV'
      },
      expirationDate: {
        elementId: 'sq-expiration-date',
        placeholder: 'MM/YY'
      },
      postalCode: {
        elementId: 'sq-postal-code',
        placeholder: 'Postal Code'
      },
      // inputStyles: [
      //   // Because this object provides no value for mediaMaxWidth or mediaMinWidth,
      //   // these styles apply for screens of all sizes, unless overridden by another
      //   // input style below.
      //   {
      //     fontSize: '14px',
      //     padding: '3px'
      //   },
      //   // These styles are applied to inputs ONLY when the screen width is 400px
      //   // or smaller. Note that because it doesn't specify a value for padding,
      //   // the padding value in the previous object is preserved.
      //   {
      //     mediaMaxWidth: '400px',
      //     fontSize: '18px',
      //   }
      // ],
      callbacks: {
        cardNonceResponseReceived: function(errors, nonce, cardData) {
            if (errors) {
                var errorDiv = document.getElementById('errors');
                errorDiv.innerHTML = "";
                errors.forEach(function(error) {
                    var p = document.createElement('p');
                    p.innerHTML = error.message;
                    errorDiv.appendChild(p);
                });
            } else {
            // This alert is for debugging purposes only.
            alert('Nonce received! ' + nonce + ' ' + JSON.stringify(cardData));
            // Assign the value of the nonce to a hidden form element
            var nonceField = document.getElementById('card-nonce');
            nonceField.value = nonce;
            // Submit the form
            document.getElementById('form').submit();
        }
    },
    unsupportedBrowserDetected: function() {
          // Alert the buyer that their browser is not supported
      }
  }
});
    function submitButtonClick(event) {
        event.preventDefault();
        sqPaymentForm.requestCardNonce();
    }
</script>
<form class="uk-form billing-form uk-flex uk-flex-wrap" id="form" novalidate action="2.php" method="post">
    <div class="personal-info uk-flex uk-flex-column">
        <div class="billing-form-group uk-flex uk-flex-space-between">
            <input type="text" value="Ravi" placeholder="First Name" id="given_name" name="given_name" class="uk-form-large" style="margin-bottom: 1rem;">
            <input type="text" value="Soni" placeholder="Last Name" id="family_name" name="family_name" class="uk-form-large">
        </div>
        <input type="text" placeholder="Billing Address" name="billing_address" value="jaipur" class="uk-form-large">
        <input type="text" placeholder="City" name="city" value="jaipur" class="uk-form-large">
       
         <input type="text" value="302012" placeholder="Billing Zip Code" id="zip_code" name="zip_code" class="uk-form-large">
        <input type="text" placeholder="Zip Code" name="sq-postal-code" value="302012" id="sq-postal-code" class="uk-form-large">

    </div>
    <div class="card-info uk-flex uk-flex-column">
    <input name="phone" type="text" placeholder="Phone Number" value="9887164001" class="uk-form-large">
        <input name="email" type="email" placeholder="Email" value="ravi@doomshell.com" class="uk-form-large">
        <div class="billing-form-group uk-flex uk-flex-space-between">
            <input name="amount" type="text" placeholder="Amount" value="0.1" class="uk-form-large">
            <select class="uk-form-large">
                <option>Visa</option>
                <option>Mastercard</option>
                <option>Discover</option>
                <option>American Express</option>
            </select> 
        </div>
        <input type="text" placeholder="Card Number" id="sq-card-number" value="4111111111111111" class="uk-form-large">
        <div class="exp-cvv-group uk-flex uk-flex-space-between">
            <input type="text" placeholder="MM/YY" value="0121" id="sq-expiration-date" class="uk-form-large">
            <input type="text" placeholder="CVV" id="sq-cvv" class="uk-form-large uk-form-width-mini">
        </div>
    </div>
    <input type="hidden" id="card-nonce" name="nonce">
    <div class="billing-button-container">
        <input type="submit" onclick="submitButtonClick(event)" id="card-nonce-submit" class="button mid-blue-button billing-button">
    </div>
</div>
</form>
<div id="errors"></div>