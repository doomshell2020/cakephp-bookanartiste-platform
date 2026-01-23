 
<!----------------------editprofile-strt------------------------>
  <section id="edit_profile">
    <div class="container">
      <h2>Banking<span> Information</span></h2>
      <div class="row">
          

        <div class="tab-content">
        <div class="profile-bg m-top-20">
	    <?php echo $this->Flash->render(); ?>
          <div id="Personal" class="tab-pane fade in active">
            <div class="container m-top-60">
         <?php echo $this->Form->create($bankinginformation,array('url' => array('controller' => 'talentadmin', 'action' => 'bankinformationupdate'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
            <p>    Give us your account details in which you would like to receive your payment of revenue earned by you</p>
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Bank Name: <span style="color:red; font-weight: bold">*</span> </label>
	    
	    <div class="col-sm-9">
		<?php echo $this->Form->input('bank_name',array('class'=>'form-control','placeholder'=>'Bank Name','id'=>'name','required'=>true,'label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Account Number: <span style="color:red; font-weight: bold">* </span></label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('bank_account_no',array('class'=>'form-control','placeholder'=>'Account Number','id'=>'acnum','required'=>true,'label' =>false,'type'=>'text', 'onkeypress'=>'return isNumber(event);','onkeyup'=>'return isNumberchng();', 'value'=>$bankinginformation['bank_account_no'])); ?>
		<span id="msg" style="color: red;"></span>
	    </div>
	    <div class="col-sm-1"></div>
	</div>

	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Branch Address: <span style="color:red; font-weight: bold">*</span></label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('bank_branch_add',array('class'=>'form-control','placeholder'=>'Branch Address','id'=>'name','required'=>true,'label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Country:</label>
	    <div class="col-sm-9">
		 <?php echo $this->Form->input('bank_country',array('class'=>'form-control','placeholder'=>'Country','id'=>'country_ids','label' =>false,'empty'=>'--Select Country--','options'=>$country)); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">State:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('bank_state',array('class'=>'form-control','placeholder'=>'State','id'=>'state','label' =>false,'empty'=>'--Select State--','options'=>array())); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">City:</label>
	    <div class="col-sm-9">
		  <?php echo $this->Form->input('bank_city',array('class'=>'form-control','id'=>'city','label' =>false,'empty'=>'--Select City--','options'=>array())); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">SWIFT Code Number:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('swift_code',array('class'=>'form-control','placeholder'=>'SWIFT Code Number','id'=>'name','label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label"> IBAN Number:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('iban_number',array('class'=>'form-control','placeholder'=>'IBAN Number','id'=>'name','label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">BSB Code :</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('bsb_code',array('class'=>'form-control','placeholder'=>'BSB Code','id'=>'name','label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">IFSC Code:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('ifsc_code',array('class'=>'form-control','placeholder'=>'IFSC Code','id'=>'name','label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Payment Getway details:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('payment_getway',array('class'=>'form-control','placeholder'=>'Write the details of payment gateway to which your account is linked', 'id'=>'name', 'label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>

	<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Any Important Information:</label>
	    <div class="col-sm-9">
		<?php echo $this->Form->input('important_info',array('class'=>'form-control','placeholder'=>'Write any notes or information that is important for making a successful transaction into your account','label' =>false,'type'=>'text')); ?>
	    </div>
	    <div class="col-sm-1"></div>
	</div>
	
	
		<div class="form-group">
	    <label for="" class="col-sm-2 control-label">Note:</label>
	    <div class="col-sm-9">
	    <p style="text-align: left; font-size: 14px;">
www.bookanartiste.com shall never ask you for any confidential banking information other than the one in this form. Please ignore any attempts made by anyone to solicit any confidential information of your credit card, debit card, online banking, online wallet or any other passwords or any other banking information on behalf of bookanartiste.com. Do not share such information with anyone by any medium of communication </p> 
  </div>
	    <div class="col-sm-1"></div>
	</div>
	
	
	<div class="form-group">
	    <div class="col-sm-8 text-center">
	    <button id="btn" type="submit" class="btn btn-default">Submit</button>
	    </div>
	</div>
           <?php echo $this->Form->end(); ?>
            </div>
          </div>
    </div>
        </div>
      </div>
    </div>
  </section>
<script type="text/javascript">
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
    	$('#msg').html("Please Enter Only Numeric Characters!!!!");
    	return false;
    }
    return true;
}
</script>

<script type="text/javascript">
function isNumberchng() {
	var val = $("#acnum").val();
	// alert(val);
	if (isNaN(val) || parseInt(val) === 0)
	{
		$("#acnum").val('');
	    $('#msg').html("Please Enter Valid Account Number");
	    return false;
	}else{
		$('#msg').html("");
		return true;
	}
}
</script>
  
    <script type="text/javascript">
    $(document).ready(function() {
	$("#country_ids").on('change',function() {
	    var id = $(this).val();
	    changestate(id);    
	});
	
    
	

	$("#state").on('change',function() {
		var id = $(this).val();	
		changecity(id);
	});
    });
    
    // Change Country function 
    function changecity(id)
    {
		//alert(id);
	current_city = '<?php echo $bankinginformation['bank_city'];  ?>';
	$("#city").find('option').remove();
	if (id) {
	    var dataString = 'id='+ id;
	    $.ajax({
		    type: "POST",
		    url: '<?php echo SITE_URL;?>/talentadmin/getcities',
		    data: dataString,
		    cache: false,
		    success: function(html) {
				$('<option>').val('0').text('--Select City--').appendTo($("#city"));
			    $.each(html, function(key, value) {              
				    if(current_city==key)
				    {
						//alert(value);
						$('<option selected=selected>').val(key).text(value).appendTo($("#city"));
				    }
				    else
				    {
						$('<option>').val(key).text(value).appendTo($("#city"));
				    }
			    });
		    } 
	    });
	}
    }
    
    
    // Change State fucntion
    function changestate(id)
    {
	current_state = '<?php echo $bankinginformation['bank_state'];  ?>';
	$("#state").find('option').remove();
	$("#city").find('option').remove();
	//$("#city").find('option').remove();
	if (id) {
	    var dataString = 'id='+ id;
	    $.ajax({
		type: "POST",
		url: '<?php echo SITE_URL;?>/talentadmin/getStates',
		data: dataString,
		cache: false,
		success: function(html) {
			$('<option>').val('0').text('--Select State--').appendTo($("#state"));
		    $.each(html, function(key, value) {        
			if(key==current_state)
			{
			    $('<option selected=selected>').val(key).text(value).appendTo($("#state"));
			}
			else
			{
			    $('<option>').val(key).text(value).appendTo($("#state"));
			}
		    });
		} 
	    });
	}
    }
    
    changestate('<?php echo $bankinginformation['bank_country'];  ?>');   
    changecity('<?php echo $bankinginformation['bank_state'];  ?>');
    </script>
  
