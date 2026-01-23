
<!----------------------editprofile-strt------------------------>
  <section id="edit_profile">
    <div class="container">
    
      <h2>Select your <span>posting options</span></h2>
      <div class="row">
          

  
        <div class="profile-bg m-top-20">
	    <?php echo $this->Flash->render(); ?>
          <div id="Personal_page" class="tab-pane fade in active">
            <div class="container">
            <div class="prsnl_page_dtl">
<?php echo $this->Form->create('Package',array('url' => array('controller' => 'Package', 'action' => 'buyquotepayment'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'PackageIndexForm','autocomplete'=>'off')); ?>
  
		<h5>Choose any options from the list in Ask for Quote </h5>
		<table id="" class="table table-bordered table-striped">
		<tbody>
		<?php foreach($quote_packages as $key=>$value){ //pr($value);
		?>
		<tr>
		    <td style="text-align:center"><input type="radio" required name="package_id" onclick="updatepackageprice('<?php echo $value['price']; ?>')" value="<?php echo $value['id']; ?>"></td>
		      <td>Buy <?php echo $value['number_of_free_quotes']; ?> Quote Request @ <?php echo $value['cost_per_quote']; ?> each. Pay $<?php echo $value['total_price']; ?> </td>
	
		</tr>
		<?php } ?>
		
	
		
		
		</tbody>
		</table>
		
		 <div class="form-group">
	    <div class="col-sm-12 text-center">
		<input type="hidden" name="requirement_id" value="<?php echo $job_id; ?>">
		<input type="hidden" name="redirect_url" value="<?php echo $redirection_url; ?>">
		<button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
		
		
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
  
  
<script>
  $('.5quote').click(function() { 
	  var price= '2.5'
$('.quoteamount').val(price);
});
  $('.10quote').click(function() { 
	  var price= '3'
$('.quoteamount').val(price);
});
</script>
    
<script>

$('tr').click(function() {
    $(this).find('td input:radio').prop('checked', true);
})

</script>
  
