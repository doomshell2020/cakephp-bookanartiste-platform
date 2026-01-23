<?php echo $this->Form->create('', array('url' => ['controller' => 'requirement', 'action' => 'amountquote'], 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>

<?php
//pr($revisedquote); die;

$data = $this->Comman->vacanydetails($revisedquote['job_id'], $revisedquote['skill_id']);
$dataquotedetail = $this->Comman->quoteuserdetail($revisedquote['job_id'], $revisedquote['user_id']);

$recievedPaymentQuote =  $this->Comman->getPaymentCurrencyAndFreq($dataquotedetail['payment_freq'], $dataquotedetail['payment_currency']);

if ($data['currency']) {
  $result_currency = $data['currency']->symbol . ' (' . $data['currency']->currencycode . ')';
} else {
  $result_currency = '';
}

?>

<input type="hidden" name="revisedid" value="<?php echo $revisedquote['id']; ?>">


<div class="form-group">
  <label for="" class="col-sm-4 control-label">Name :</label>
  <div class="col-sm-8">
    <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $dataquotedetail['user_id']; ?>" target="_blank"><?php echo $dataquotedetail['user']['profile']['name']; ?>
    </a>
  </div>
</div>


<div class="form-group">
  <label for="" class="col-sm-4 control-label">Skill :</label>
  <div class="col-sm-8">
    <?php echo $dataquotedetail['skill']['name']; ?>
  </div>
</div>


<div class="form-group">
  <label for="" class="col-sm-4 control-label">Currency :</label>
  <div class="col-sm-8">
    <?php

    if ($data['currency']['symbol']) {
      echo $data['currency']['name'] . ' (' . $data['currency']['currencycode'] . ' - ' . $data['currency']['symbol'] . ')';
    }else{
      echo '-';
    }
    //echo $data['currency']['symbol'] ?? '-'; 
    ?>
  </div>
</div>

<div class="form-group">
  <label for="" class="col-sm-4 control-label">Payment Offered :</label>
  <div class="col-sm-8">
    <?php
    $payment_amount = ($data['payment_amount'] > 0)
      ? $data['currency']['symbol'] . ' ' . $data['payment_amount']
      : 'Open To Negotiation';

      echo $payment_amount;
    ?>
    <?php //echo $this->Form->input('revisedquote', array('class' => 'form-control', 'placeholder' => 'Payment Offered', 'required' => true, 'label' => false, 'type' => 'text', 'value' => $payment_amount, 'readonly' => true)); ?>

  </div>
</div>

<div class="form-group">
  <label for="" class="col-sm-4 control-label"> Quote Received :</label>
  <div class="col-sm-8">

    <?php
    if (!empty($dataquotedetail['amt'])) {
      echo (!empty($recievedPaymentQuote['currency']) ? $recievedPaymentQuote['currency'] . ' ' : '') . $dataquotedetail['amt'];
      if (!empty($recievedPaymentQuote['frequency'])) {
        echo ' / ' . $recievedPaymentQuote['frequency'];
      }
    } else {
      echo 'Open to Negotiation';
    }
    ?>

    <?php
    //$currencyrec =  $data['currency']['symbol'] . $revisedquote['amt'];    
    ?>
    <?php
    //echo $this->Form->input('revisedquote', array('class' => 'form-control', 'placeholder' => 'Quote Received', 'required' => true, 'label' => false, 'type' => 'text', 'value' => $currencyrec, 'readonly' => true)); 
    ?>

  </div>
</div>

<div class="form-group">
  <label for="" class="col-sm-4 control-label">Your Revised Quote:</label>

  <div class="col-sm-2">
    <?php //echo $this->Form->input('revisedquote', array('class' => 'form-control', 'placeholder' => '', 'required' => true, 'label' => false, 'type' => 'text', 'value' => $data['currency']['symbol'], 'readonly' => true)); 
    ?>

    <?php
    if (!empty($dataquotedetail['payment_currency'])):
      $existCurrencyId = (int)$dataquotedetail['payment_currency'];
    ?>

      <?= $this->Form->control('revised_payment_currency', [
        'type' => 'select',
        'value' => $existCurrencyId, // <-- use 'value' instead of 'selected'
        'class' => 'form-control',
        'label' => false,
        'required' => true,
        'empty' => 'Select Currency',
        'options' => $currencies_list,
        'title' => 'Select Currency'
      ]); ?>
    <?php endif; ?>

  </div>

  <div class="col-sm-2">
    <?php
    if (!empty($dataquotedetail['payment_freq'])):
      $existFrequencyId = (int)$dataquotedetail['payment_freq'];
    ?>

      <?= $this->Form->control('revised_payment_frequency', [
        'type' => 'select',
        'value' => $existFrequencyId,
        'class' => 'form-control',
        'label' => false,
        'required' => true,
        'empty' => 'Payment Frequency',
        'options' => $payfreq,
        'title' => 'Payment Frequency'
      ]); ?>
    <?php endif; ?>

  </div>

  <div class="col-sm-4">
    <?php echo $this->Form->input('revision', array('class' => 'form-control', 'placeholder' => 'Enter Revised Quote', 'required' => true, 'label' => false, 'min' => 1, 'type' => 'Number')); ?>
  </div>

</div>

<div class="form-group">
  <div class="col-sm-12 text-center requiter_btn">
    <button class="btn btn-default" id="bn_subscribe">Submit</button>
  </div>
</div>
<?php echo $this->Form->end(); ?>


<script>
  /*
$('#bn_subscribesss').click(function(e) { //alert();
	e.preventDefault();
    $.ajax({
	type: "POST",
	url: '<?php //echo SITE_URL; 
        ?>/requirement/amountquote',
	data: $('#submit-formdd').serialize(),
	cache:false,
	success:function(data){  //alert(data);
	    obj = JSON.parse(data);
	    if(obj.status!=1)
	    {
		//$('#reportuser').modal('toggle');
		showerror(obj.error);
	    }
	    else
	    {
		//$('#reportuser').modal('toggle');
		success = "Revised quote amount sent successfully.";
		showerror(success);
	    }
	}
    });
});


function showerror(error)
{
    BootstrapDialog.alert({
	size: BootstrapDialog.SIZE_SMALL,
	title: "<img title='Book an Artiste' src='<?php //echo SITE_URL; 
                                            ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	message: "<h5>"+error+"</h5>"
	});
    return false;
}
*/
</script>