<!----------------------editprofile-strt------------------------>
<section id="page_login">
 <div class="container">
   <div class="row">
     <div class="col-sm-12">
       <div class="login-popup">
         <h2>Package  <span>Details</span></h2>


         <?php //pr($pcakgeinformation); ?>

        <div class="row">
         <div class="col-sm-6">
          <div>
           <strong>Package Name</strong>
          </div>
          <div class="">
           <?php echo $pcakgeinformation['name']; ?>
          </div>
          <div class="">
           <strong>Package Amount</strong>
         </div>
          <div class="">
           <?php echo $pcakgeinformation['price']; ?>
         </div>
         </div>

           <div class="col-sm-6">
            <div>
             <h5>Total Amount Before Tax: <span><?php echo "$".$pcakgeinformation['price']; ?> </span></h5>
          </div>
          <?php if ($invoicereceipt) {
             foreach ($invoicereceipt as $key => $value) { 
              $totaltax+=$value['tax_percentage'];
              ?>
            <div class="">
             <h5>Add: <span><?php echo $value['title']."@".$value['tax_percentage']."%"; ?></span></h5>
           </div>
          <?php }  }else{
            echo "GST not included";
            } ?>

          <div class="">
             <h5>Total Bill Amount: <span><?php $grandtotal=$pcakgeinformation['price']+($pcakgeinformation['price']*$totaltax/100); echo "$".$grandtotal; ?></span></h5>
           </div>

           <div class="">
             <h5>View Price in Local Currency: <span><a target="_blank" href="https://www.xe.com/currencyconverter/">Click Here</a></span></h5>
           </div>
          </div>
        </div>


     <?php echo $this->Form->create('Package',array('url' => array('controller' => 'Package', 'action' => 'processpayment'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'PackageIndexForm','autocomplete'=>'off')); ?>

     <input type="hidden" name="package_type" value="<?php echo $package_type; ?>">
     <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
     <input type="hidden" name="package_price" value="<?php echo $pcakgeinformation['price']; ?>">
     <?php if ($invoicereceipt) {
      foreach ($invoicereceipt as $key => $values) { ?>
       <input type="hidden" name="<?php echo $values['title']; ?>" value="<?php echo $values['tax_percentage']; ?>">
    <?php } } ?>

     <?php echo $this->Flash->render(); ?>
  <!--
  <div class="form-group">
	<label for="inputEmail3" class="col-sm-12 control-label">Email Address</label>
	<div class="col-sm-12">

	<?php echo $this->Form->input('email',array('class'=>'form-control','label' =>false,'type'=>'text')); ?>

	</div>
    </div>
  -->
  <div class="form-group">
    <div class="col-sm-12">
     <button type="submit" class="btn btn-default"><?php echo ($pcakgeinformation['price']=='0')?'Confirm':'Proceed to Payment'; ?></button>
   </div>
 </div>


 <?php echo $this->Form->end();   ?>
 


</div>

</div>




</div>
</div>
</div>







</section>



