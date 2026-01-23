<?php
foreach ($languageknow as $key => $value) {
  //pr($languageknow); die;
  $languagearray[] = $value['language_id'];
  //pr($tes); 
}

?>

<?php
foreach ($performance_genre as $performance_genrekey => $performance_genrevalue) {
  //	pr($performance_genrevalue); die;
  $genrearray[] = $performance_genrevalue['genre_id'];
  //pr($genrearray); 
}

?>

<?php

foreach ($performance_subgenre as $performance_subgenrekey => $performance_subgenrevalue) {

  $subgenrearray[] = $performance_subgenrevalue['subgenre_id'];
  //pr($tes); 
}

?>

<!----------------------editprofile-strt----------------------->
<section id="edit_profile">
  <div class="container">
    <h2>Work <span>Charges</span></h2>
    <p class="m-bott-50">Here You Can Manage Your Work Charges Description</p>
    <div class="row">
      <?php echo  $this->element('editprofile') ?>
      <div class="tab-content">
        <div class="profile-bg m-top-20">
          <?php echo $this->Flash->render(); ?>
          <div id="Perfo-Des" class="">
            <div class="container m-top-60">
              <?php echo $this->Form->create($proff, array('url' => array('controller' => 'profile', 'action' => 'performance'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>


              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Performance,Work Description:</label>
                <div class="col-sm-5">
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">

                  <?php echo $this->Form->input('performance_desc', array('class' => 'form-control', 'placeholder' => 'Describe your work/performance in details', 'label' => false, 'type' => 'textarea')); ?>

                </div>

              </div>

              <div class="form-group">
                <label for="" class="col-sm-3 control-label">Special Requirements:</label>
                <div class="col-sm-5">

                </div>
                <div class="col-sm-4"></div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <?php echo $this->Form->input('setup_requirement', array('class' => 'form-control', 'placeholder' => 'Mention any special requirement(s) for your performance, work eg stage, light, culture etc', 'label' => false, 'type' => 'textarea')); ?>
                </div>

              </div>


             
         <div class="form-group">
           <label for="" class="col-sm-12 control-label">Personnel Details:</label>
         </div>
         <div class="form-group">
           <div class="col-sm-12">
            <div class="table-responsive">
              <div class="multi-field-wrapper">					
               <table class="table table-bordered">
                <thead>
                 <tr>
                   <th>Name</th>
                   <th>URL</th> 
                   <th></th>
                 </tr>
               </thead>
               <tbody class="video_container">
                 <?php if(count($videoprofile)>0){ ?>
                  <?php foreach($videoprofile as $prop){ //pr($prop);?>	
                    <tr class="video_details">

                      <td> <?php echo $this->Form->input('name',array('value'=>$prop['name'],'class'=>'form-control','placeholder'=>'Name', 'id'=>'name','label' =>false,'name'=>'data[name][]')); ?>
                      <input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/></td>
                    </td>

                    <td> <?php echo $this->Form->input('url',array('value'=>$prop['url'],'class'=>'form-control','placeholder'=>'URL', 'id'=>'url','type'=>'url','label' =>false,'name'=>'data[url][]',
                    'pattern'=>'http://www\.bookanartiste\.com\/(.+)|https://www\.bookanartiste\.com\/(.+)',  'oninvalid'=>"this.setCustomValidity('URL should start from http://www.bookanartiste.com')","oninput"=>"setCustomValidity('')")); ?></td>
                    <td>
                      <a href="javascript:void(0);" class="deletepersonal btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

                      <!--<button type="button" onclick="delete_detials(<?php //echo $prop['id'] ?>);" class="btn remove-field btn-danger btn-block"><i class="fa fa-remove"></i> Delete</button>-->

                    </td>

                  </tr>
                <?php }}else{ ?>
                  <tr class="video_details">

                    <td> <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Name','id'=>'name','label' =>false,'name'=>'data[name][]')); ?>
                  </td>

                  <td> <?php echo $this->Form->input('url',array('class'=>'form-control','placeholder'=>'URL','id'=>'url','type'=>'url','label' =>false,'name'=>'data[url][]',
                  'pattern'=>'http://www\.bookanartiste\.com\/(.+)|https://www\.bookanartiste\.com\/(.+)',  'oninvalid'=>"this.setCustomValidity('URL should start from http://www.bookanartiste.com')","oninput"=>"setCustomValidity('')")); ?></td>

                  <td>
                    <a href="javascript:void(0);" class="deletepersonal btn remove-field btn-danger btn-block" data-val="<?php echo $prop['id'] ?>"><i class="fa fa-remove"></i> Delete</a>

                  </td>
                </tr>

              <?php } ?>

            </tbody>


            <tfoot>
              <tr>
                <td colspan="7" style="text-align:right"><a type="button" class="btn-primary add-field pull-right">Add </a></td>

              </tr>


            </tfoot>
          </table>
        </div>

      </div>




    </div>

    

  </div>  








              <div class="form-group">
                <label for="" class="col-sm-2 control-label">Influenced by:</label>
                <div class="col-sm-10">
                  <?php echo $this->Form->input('infulences', array('class' => 'form-control', 'placeholder' => 'Influences', 'label' => false, 'type' => 'text')); ?>

                </div>


              </div>
              <?php /* ?>
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Genre :</label>
                  <div class="col-sm-6">
					 
				
                             <?php //echo $this->Form->input('genre',array('class'=>'form-control','placeholder'=>'State', 'id'=>'','label' =>false,'empty'=>'--Select Genre--','options'=>$genreresult)); ?>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                <?php */ ?>

              <?php if (count($genre) > 0) { ?>
                <?php
                $generes = '';
                foreach ($genre as $gen) { //pr($gen);
                  if (!empty($generes)) {
                    $generes =  $generes . ', ' . $gen->Genre->name;
                  } else {
                    $generes =  $gen->Genre->name;
                  }
                ?>
                  <input type="hidden" name="genere[]" value="<?php echo $gen->Genre->id; ?>">
                <?php
                } ?>

                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Genre :</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="readonly" class="form-control" name="generes_name" id="generes_name" value="<?php echo $generes; ?>">
                  </div>

                </div>

                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">SubGenre :</label>
                  <div class="col-sm-10 leng_box">
                    <select id="dates-field2" class="multiselect-ui-subgenre form-control" multiple="multiple" name="subgenre[]" required>

                      <?php foreach ($subgenre as $subgen => $subres) { //pr($res);
                      ?>

                        <option value="<?php echo  $subres['id']; ?>" <?php if (in_array($subres['id'], $subgenrearray)) { ?> selected <?php } ?>><?php echo $subres['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>

                </div>

              <?php } ?>
              <!--
                <?php ?>
                
                                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label">SubGenre :</label>
                  <div class="col-sm-6">
					  <?php $ar = array('1' => '1', '2' => '2'); ?>
                             <?php echo $this->Form->input('subgenre', array('class' => 'form-control', 'placeholder' => 'State', 'id' => '', 'label' => false, 'empty' => '--Select SubGenre--', 'options' => $subgenreresult)); ?>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                <?php   ?>  -->
              <div class="form-group">
                <label for="" class="col-sm-12 control-label">Charges:</label>

              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <div class="multi-field-wrapperpayment">

                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Charges Type</th>
                            <th>Currency</th>
                            <th>Charges</th>
                            <th></th>

                          </tr>
                        </thead>

                        <tbody class="payment_container">
                          <?php if (count($payfrequency) > 0) { ?>
                            <?php foreach ($payfrequency as $pay) { //pr($prop);
                            ?>
                              <tr class="payment_details">


                                <td><?php echo $this->Form->input('payment_frequency', array('value' => $pay['payment_frequency'], 'class' => 'form-control', 'placeholder' => 'Payment Frequency', 'id' => '', 'label' => false, 'empty' => '--Select Type--', 'options' => $pay_freq, 'name' => 'datas[payment_frequency][]')); ?>
                                  <input type="hidden" value="<?php echo $pay['id'] ?>" name="datas[hid][]" />
                                </td>

                                <td><?php echo $this->Form->input('currency', array('value' => $pay['currency_id'], 'class' => 'form-control', 'id' => '', 'label' => false, 'empty' => '--Select Currency--', 'options' => $currency, 'name' => 'datas[currency][]')); ?></td>

                                <td> <?php echo $this->Form->input('amount', array('value' => $pay['amount'], 'class' => 'form-control', 'placeholder' => 'Amount', 'id' => 'name', 'label' => false, 'name' => 'datas[amount][]', 'type' => 'number')); ?></td>

                                <td><a href="javascript:void(0);" class="deletepayment btn remove-field btn-danger btn-block" data-val="<?php echo $pay['id'] ?>"><i class="fa fa-remove"></i> Delete</a></td>

                              </tr>
                            <?php }
                          } else { ?>
                            <tr class="payment_details">

                              <td><?php echo $this->Form->input('payment_frequency', array('class' => 'form-control', 'placeholder' => 'Payment Frequency', 'id' => '', 'label' => false, 'empty' => '--Select Payment Frequency--', 'options' => $pay_freq, 'name' => 'datas[payment_frequency][]')); ?>
                                <input type="hidden" value="<?php echo $pay['id'] ?>" name="datas[hid][]" />
                              </td>

                              <td><?php echo $this->Form->input('currency', array('class' => 'form-control', 'id' => '', 'label' => false, 'empty' => '--Select Currency--', 'options' => $currency, 'name' => 'datas[currency][]')); ?></td>

                              <td> <?php echo $this->Form->input('amount', array('class' => 'form-control', 'placeholder' => 'Amount', 'id' => 'name', 'label' => false, 'name' => 'datas[amount][]', 'type' => 'number')); ?></td>


                              <td><a href="javascript:void(0);" class="deletepayment btn remove-field btn-danger btn-block" data-val="<?php echo $pay['id'] ?>"><i class="fa fa-remove"></i> Delete</a></td>

                            </tr>

                          <?php } ?>

                        </tbody>


                        <tfoot>
                          <tr>
                            <td colspan="7" style="text-align:right"><a type="button" class="btn-primary add-paymentfield pull-right">Add </a></td>

                          </tr>


                        </tfoot>
                      </table>
                    </div>

                  </div>




                </div>



              </div>


              <div class="form-group">

                <div class="col-sm-8">
                  <input type="checkbox" value="1" name="acceptassignment" <?php if ($proff['acceptassignment'] == 1) {
                                                                              echo "checked";
                                                                            } ?>> Open To Accepting Interesting Assignments for free
                </div>
                <div class="col-sm-4"></div>
              </div>
              <div class="form-group">
                <label for="" class="col-sm-12 control-label">Charges Description Terms and Conditions:</label>

              </div>
              <div class="form-group">
                <label for="" class="col-sm-2 control-label">Charges Description :</label>
                <div class="col-sm-10">
                  <?php $ar = array('1' => '1', '2' => '2'); ?>
                  <?php echo $this->Form->input('chargesdescription', array('class' => 'form-control', 'placeholder' => 'Write any details or conditions of your charges, fees etc', 'label' => false, 'type' => 'textarea')); ?>
                </div>

              </div>

              <div class="form-group">
                <label for="" class="col-sm-2 control-label">Payment Terms And Conditions :</label>
                <div class="col-sm-10">
                  <?php $ar = array('1' => '1', '2' => '2'); ?>
                  <?php echo $this->Form->input('paytermsandcondition', array('class' => 'form-control', 'placeholder' => 'Describe mode of payment, lodging, food, travel etc', 'label' => false, 'type' => 'textarea')); ?>
                </div>

              </div>



              <div class="form-group">
                <label for="" class="col-sm-2 control-label">Performance, Work Language(s) :</label>
                <div class="col-sm-10 leng_box">
                  <select id="dates-field2" class="multiselect-ui form-control" multiple="multiple" name="languageknow[]">

                    <?php foreach ($lang as $key => $value) { //pr($value);
                    ?>

                      <option value="<?php echo $value['id']; ?>" <?php if (in_array($value['id'], $languagearray)) { ?> selected <?php } ?>><?php echo $value['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>

              </div>

              <div class="form-group">
                <label for="" class="col-sm-2 control-label">Open To Travel :</label>
                <div class="col-sm-10">
                  <?php $opentravel = array('Y' => 'Yes', 'N' => 'No'); ?>

                  <?php echo $this->Form->input('opentotravel', array('class' => '', 'id' => 'gender', 'type' => 'radio', 'options' => $opentravel, 'label' => false, 'legend' => false, 'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'])); ?>


                </div>

              </div>
              <?php  //	pr($proff); 
              ?>
              <div class="form-group trades" <?php if ($proff['opentotravel'] != 'Y') { ?> style="display: none;" <?php } ?>>
                <label for="" class="col-sm-2 control-label"> Travel Description:</label>
                <div class="col-sm-10">
                </div>

              </div>

              <div class="form-group opdesc" <?php if ($proff['opentotravel'] != 'Y') { ?>style="display:none" <?php } ?>>
                <div class="col-sm-12">

                  <?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'Mention any travel conditions, points to keep in mind etc', 'label' => false, 'type' => 'textarea')); ?>
                </div>

              </div>


              <div class="form-group d-flex justify-content-center p" style="text-align: center;" >
                <!-- <div class="col-sm-4 text-left"> -->
                <button id="btn" type="submit" class="btn btn-default mr" onclick='this.form.action="profile/performance/save";'>Save</button>
                <!-- </div>
        <div class="col-sm-4 text-center">
            
        </div>
        <div class="col-sm-4 text-right">
          <div class="text-right"> -->
                <button id="btn" type="submit" onclick='this.form.action="profile/performance/submit";' class="btn btn-default redButton">Submit</button>
                <!-- </div> -->
                <!-- </div> -->
              </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
</section>

<script>
  $(document).ready(function() {
    $("#opentotravel-n").click(function() {
      $(".opdesc").hide();
      $(".trades").hide();
    });
    $("#opentotravel-y").click(function() {
      $(".opdesc").show();
      $(".trades").show();
    });
  });
</script>



<script>
  var site_url = '<?php echo SITE_URL; ?>/';
  $('.deletepersonal').click(function() { //alert();
    user_id = $(this).data('val');
    $.ajax({
      type: "post",
      url: site_url + 'profile/deletepersonal',
      data: {
        datadd: user_id
      },

      success: function(data) {}
    });


  });



  $('.deletepayment').click(function() { //alert();
    id = $(this).data('val');
    $.ajax({
      type: "post",
      url: site_url + 'profile/deletepayment',
      data: {
        datadd: id
      },

      success: function(data) {}
    });


  });
</script>

<script>
  $('.multi-field-wrapperpayment').each(function() {
    var $wrapper = $('.payment_container', this);
    $(".add-paymentfield", $(this)).click(function(e) {

      var paymentdetails = $('.payment_details:first-child', $wrapper).clone(true).appendTo($wrapper)
      paymentdetails.find('input').val('').focus();
      paymentdetails.find('select').val('').focus();
      paymentdetails.find('[data-val]').attr("data-val", '');


    });
    $('.remove-field', $wrapper).click(function() {
      if ($('.payment_details', $wrapper).length > 1)
        $(this).closest('.payment_details').remove();
    });
  });
</script>





<script>
  $('.multi-field-wrapper').each(function() {
    var $wrapper = $('.video_container', this);
    $(".add-field", $(this)).click(function(e) {
      var personaldetail = $('.video_details:first-child', $wrapper).clone(true).appendTo($wrapper)
      personaldetail.find('input').val('').focus();
      personaldetail.find('[data-val]').attr("data-val", '');
    });
    $('.remove-field', $wrapper).click(function() {
      if ($('.video_details', $wrapper).length > 1)
        $(this).closest('.video_details').remove();
    });
  });
</script>




<script type="text/javascript">
  $(document).ready(function() {
    $('.multiselect-ui-subgenre').multiselect({
      onChange: function(option, checked) {
        // Get selected options.
        var selectedOptions = $('.multiselect-ui-subgenre option:selected');

        if (selectedOptions.length >= 7) {
          // Disable all other checkboxes.
          var nonSelectedOptions = $('.multiselect-ui-subgenre option').filter(function() {
            return !$(this).is(':selected');
          });

          nonSelectedOptions.each(function() { //alert('test');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', true);
            input.parent('li').addClass('disabled');
          });
        } else {
          // Enable all checkboxes.
          $('.multiselect-ui-subgenre option').each(function() { //alert('testing');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', false);
            input.parent('li').addClass('disabled');
          });
        }
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.multiselect-ui-gnere').multiselect({
      onChange: function(option, checked) {
        // Get selected options.
        var selectedOptions = $('.multiselect-ui-gnere option:selected');

        if (selectedOptions.length >= 7) {
          // Disable all other checkboxes.
          var nonSelectedOptions = $('.multiselect-ui-gnere option').filter(function() {
            return !$(this).is(':selected');
          });

          nonSelectedOptions.each(function() { //alert('test');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', true);
            input.parent('li').addClass('disabled');
          });
        } else {
          // Enable all checkboxes.
          $('.multiselect-ui-gnere option').each(function() { //alert('testing');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', false);
            input.parent('li').addClass('disabled');
          });
        }
      }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.multiselect-ui').multiselect({
      onChange: function(option, checked) {
        // Get selected options.
        var selectedOptions = $('.multiselect-ui option:selected');

        if (selectedOptions.length >= 7) {
          // Disable all other checkboxes.
          var nonSelectedOptions = $('.multiselect-ui option').filter(function() {
            return !$(this).is(':selected');
          });

          nonSelectedOptions.each(function() { //alert('test');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', true);
            input.parent('li').addClass('disabled');
          });
        } else {
          // Enable all checkboxes.
          $('.multiselect-ui option').each(function() { //alert('testing');
            var input = $('input[value="' + $(this).val() + '"]');
            input.prop('disabled', false);
            input.parent('li').addClass('disabled');
          });
        }
      }
    });
  });
</script>
<script>
  var $form = $('form'),
    origForm = $form.serialize();
  $('.popcheckconfirm').on('click', function() {
    if ($form.serialize() !== origForm) {
      var result = confirm('Do you want to leave this page? Changes that you made may not be saved');
      if (result) {
        return true;
      } else {
        return false;
      }
    }
  });
</script>