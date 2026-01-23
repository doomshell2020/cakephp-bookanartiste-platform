<?php
// $offerAmount = null;
// $currencyId = null;
// foreach ($requirement_data['requirment_vacancy'] as $value) {

//      if ($value['telent_type'] == $skill_id) {
//           $selected = $value['telent_type'] == $skill_id ? 'selected' : '';
//           $offerAmount = $value['payment_amount'];
//      }
//      // pr($value);exit;
//      if ($value['payment_currency'] > 0) {
//           $currencyId = $value['payment_currency'];
//      }

// }

?>

<form action="<?php echo SITE_URL ?>/jobpost/SendQoute" method="POST">
     <div class="form-group">
          <label for="skillid">Skill</label>
          <select class="form-control"
               name="skill"
               onchange="return myfunction(this)"
               data-req="<?php echo $requirement_data['id'] ?>"
               id="skillid"
               required>
               <option value="">Select Skill</option>
               <?php
               $offerAmount = null;
               $currencyId = null;
               foreach ($requirement_data['requirment_vacancy'] as $value) {
                    $selected = $value['telent_type'] == $skill_id ? 'selected' : '';
                    // if ($value['telent_type'] == $skill_id) {
                    //      $offerAmount = $value['payment_amount'];
                    // }
                    // if ($value['payment_currency'] > 0) {
                    //      $currencyId = $value['payment_currency'];
                    // }

               ?>
                    <option value="<?php echo $value['skill']['id']; ?>" <?php echo $selected; ?>>
                         <?php echo htmlspecialchars($value['skill']['name']); ?>
                    </option>
               <?php } ?>
          </select>
     </div>

     <div>Currency</div>
     <div style="margin-bottom: 20px">
          <?php
          $currencyFieldId = "currencysingle" . $requirement_data["id"];
          echo $this->Form->control('payment_currency', [
               'type' => 'select',
               'class' => 'form-control currency_select',
               'label' => false,
               'empty' => 'Select Currency',
               // 'onchange'=>'currecyChoose(this)',
               'options' => $Currency,
               'selected' => 'selected',
               'id' => $currencyFieldId,
               // 'value' => $currencyId,
               'title' => 'Select Currency'
          ]);
          ?>
     </div>

     <div>Offer Amount</div>
     <div style="margin-bottom: 20px">
          <input type="text"
               class="form-control"
               value="<?php echo htmlspecialchars($offerAmount); ?>"
               id="offeramt<?php echo $requirement_data['id']; ?>"
               name="offeredamt<?php echo $a; ?>"
               placeholder="Open to Negotiation"
               readonly>
     </div>

     <div>Payment Frequency</div>
     <div style="margin-bottom: 20px">
          <?php
          echo $this->Form->input('payment_freq', array(
               'class' => 'form-control payfreq',
               'placeholder' => 'Frequency',
               'label' => false,
               'required' => true,
               'empty' => '-- Select Frequency--',
               'options' => $payfreq,
               'name' => 'payment_freq',
          ));
          ?>
     </div>

     <div class="form-group">
          <label for="sendquouteamt">Your Quote</label>
          <div class="input-group">
               <span class="input-group-addon" id="prefixcode">
                    <?php //echo $requirement_data['requirment_vacancy'][0]['currency']['symbol']; 
                    ?>
               </span>
               <input type="number"
                    class="form-control"
                    id="sendquouteamt"
                    name="amt"
                    pattern="^[0-9]*$"
                    min="0"
                    step="any"
                    required>
          </div>
     </div>

     <input type="hidden" name="job_id" value="<?php echo $requirement_data['id']; ?>" />
     <?php if ($quoteid) { ?>
          <input type="hidden" name="job_idprimary" value="<?php echo $quoteid; ?>" />
     <?php } ?>

     <button type="submit" class="btn btn-default">Send Quote</button>
</form>


<script type="text/javascript">
     var site_url = '<?php echo SITE_URL; ?>/';

     $(document).ready(function() {
          $('.currency_select').on('change', function() {
               var selectedText = $(this).find('option:selected').text();
               var words = selectedText.split("-");
               var modifiedWord = words[1].replace(")", "");
               $('#prefixcode').text(modifiedWord);
          });
     });

     function myfunction(x) {
          var reqid = x.getAttribute('data-req');
          var skillid = x.value;
          $(this).data("req");
          $.ajax({
               dataType: "html",
               type: "post",
               evalScripts: true,
               url: site_url + 'search/myfunctiondata',
               data: {
                    skill: skillid,
                    reqid: reqid
               },
               beforeSend: function() {
                    $('#clodder').css("display", "block");
               },
               success: function(response) {
                    var obj = JSON.parse(response);

                    if (obj.payment_currency == 0) {
                         $('#offeramt' + reqid).val('');
                    } else {
                         $('#offeramt' + reqid).val(obj.payment_currency);
                    }
                    // $('#offeramt' + reqid).val(obj.payment_currency);
                    // $('#currency' + reqid).val(obj.currency);
                    if (obj.currency_id) {
                         $('#currencysingle' + reqid).val(obj.currency_id);
                    } else {
                         $('#currencysingle' + reqid).val(''); // default to empty
                    }
                    $('#prefixcode').text(obj.code);
                    $('#sendquouteamt').removeAttr('readonly');
               },
               complete: function() {
                    $('#clodder').css("display", "none");
               },
               error: function(data) {
                    alert(JSON.stringify(data));
               }
          });
     }

     $(document).ready(function() {
          // setTimeout(() => {
          var skillSelect = $('#skillid');
          if (skillSelect.val() !== "") {
               myfunction(skillSelect[0]); // or skillSelect.get(0)
          }
          // }, 800);
     });

     // Set the selected currency in the <select> dropdown
</script>