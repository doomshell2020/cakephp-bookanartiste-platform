
<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="row">
 <div class="col-sm-2">
 </div>
 
 <div class="col-sm-8">
 <div class="signup-popup">
 <h2>Complete your <span>Purchase</span></h2>
      
 <h4>Package Details</h4>
 
       <div class="row">
      <div class="col-sm-8">
	<label>Package Name</label>
    </div>
       <div class="col-sm-8">
	<?php echo $pcakgeinformation['name']; ?>
    </div>
    </div>
    
    <div class="row">
      <div class="col-sm-8">
	<label>Package Amount</label>
    </div>
       <div class="col-sm-8">
	$<?php echo $pcakgeinformation['price']; ?>
    </div>
    </div>
 
 
  <h4>Payment Information</h4>

 
<?php echo $this->Form->create('Package',array('url' => array('controller' => 'Package', 'action' => 'processpayment'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'PackageIndexForm','autocomplete'=>'off')); ?>
  	
  	<input type="hidden" name="package_type" value="<?php echo $package_type; ?>">
  	<input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
  	<input type="hidden" name="package_price" value="<?php echo $pcakgeinformation['price']; ?>">

  <form class="form-horizontal">
  <div class="form-group">
   
    <div class="col-sm-6">
		<?php echo $this->Form->input('user_name',array('class'=>'form-control','placeholder'=>'Enter Your Name','pattern'=>'[a-zA-Z ]*','id'=>'inputEmail3','required'=>true,'readonly','label' =>false,'type'=>'text','value'=>$this->request->session()->read('Auth.User.user_name'))); ?>
    </div>
    <div class="col-sm-6">
		<?php echo $this->Form->email('email',array('class'=>'form-control','placeholder'=>'Enter Your Email','required'=>true,'readonly','autocomplete'=>'off','id'=>'username','label' =>false,'value'=>$this->request->session()->read('Auth.User.email'))); ?>
    </div>
  </div>

  
  
    <div class="form-group">
   
    <div class="col-sm-6">
		<?php echo $this->Form->input('card_name',array('class'=>'form-control','placeholder'=>'Name on Card','pattern'=>'[a-zA-Z ]*','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
    </div>
    <div class="col-sm-6">
		<?php echo $this->Form->input('card_number',array('class'=>'form-control','placeholder'=>'Card Number','pattern'=>'[0-9 ]*','maxlength'=>'16','min'=>'16','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
    </div>
  </div>

    <div class="form-group">
	<div class="col-sm-6">
		    <?php echo $this->Form->input('csv_number',array('class'=>'form-control','placeholder'=>'CSV','pattern'=>'[0-9 ]*','maxlength'=>'3','min'=>'3','id'=>'inputEmail3','required'=>true,'label' =>false,'type'=>'text')); ?>
	</div>
	<?php
	    for($m=1;$m<=12;$m++)
	    {
		$months[] = $m;
	    }
	    
	    $current_year = date('Y');
	    $next_year = $current_year+10;
	    for($y=$current_year;$y<=$next_year;$y++)
	    {
		$years[] = $y;
	    }
	    
	    
	 ?>
	 <div class="col-sm-3">
	    <?php echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Month','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'Expiry Month','options'=>$months)); ?>
	</div>
	<div class="col-sm-3">
	    <?php echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Country','required'=>true,'label' =>false,'id'=>'country_phone','empty'=>'Expiry Year','options'=>$years)); ?>
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
