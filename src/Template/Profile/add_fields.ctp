 <script>



        $('#remove-btn<?php echo $i; ?>').on('click', function(){
	 $('.fields<?php echo $i; ?>').remove();
	 });

</script>
   
 <div class="form-group fields<?php echo $i; ?>">
   

    <div class="col-sm-4">
 <label for="inputEmail3" class="control-label">Length<span style="color:red;">*</span></label>
    <?php echo $this->Form->input('size.',array('type'=>'select','label' =>false,'options'=>$variationsize,'empty'=>'--Select--','placeholder'=>'Shirt Size','class'=>'form-control','required')); ?></div>   
    



<div class="col-sm-2">
<label for="inputEmail3" class="control-label">Quantity<span style="color:red;">*</span></label>
<?php echo $this->Form->input('inventory.',array('label' =>false,'placeholder'=>'Quantity','class'=>'form-control','required')); ?>        
</div> 
  
<div class="col-sm-2">
<label for="inputEmail3" class="control-label">Price<span style="color:red;">*</span></label>
<?php echo $this->Form->input('price.',array('label' =>false,'placeholder'=>'Price','class'=>'form-control','onkeypress'=>'return isNumberKey(event)','required')); ?>        
</div>   
  
  
<div class="col-sm-0">
	<label for="inputEmail3" class="control-label"></label>
<div class="input text"><a class="btn btn-info" style="
    margin-top: 6px;
" href="javascript:void(0);" id="remove-btn<?php echo $i; ?>"><i class="fa fa-minus-square" aria-hidden="true"></i> Remove</a></div>
</div>   
</div>  
</div>
<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>
